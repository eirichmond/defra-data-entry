<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://squareone.software
 * @since      1.0.0
 *
 * @package    Defra_Data_Entry
 * @subpackage Defra_Data_Entry/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Defra_Data_Entry
 * @subpackage Defra_Data_Entry/admin
 * @author     Elliott Richmond <elliott@squareonemd.co.uk>
 */
class Defra_Data_Entry_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Defra_Data_Entry_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Defra_Data_Entry_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/defra-data-entry-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Defra_Data_Entry_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Defra_Data_Entry_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/defra-data-entry-admin.js', array( 'jquery' ), $this->version, false );

	}

	/**
	 * Change logo url link to home page
	 *
	 * @param [type] $url
	 * @return void
	 */
	public function defra_logo_url_link($url) {
		return home_url();
	}

	/**
	 * remove post edit menu from admin
	 *
	 * @return void
	 */
	public function remove_menu_post_edit ()  {
		remove_menu_page('edit.php');
	}

	/**
	 * remove default dashboard widgets
	 *
	 * @return void
	 */
	public function defra_db_widgets() {
		global $wp_meta_boxes;
		
		unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_activity']);
		unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_primary']);
	 
		wp_add_dashboard_widget(
			'defre_requests_widget',                          // Widget slug.
			esc_html__( 'Appliance Requests', 'defra-data-entry' ), // Title.
			array($this,'defre_requests_widget_render')                    // Display function.
		); 
	}

	/**
	 * include appliance requests dashboard widgets file
	 *
	 * @return void
	 */
	public function defre_requests_widget_render() {
		$draft_appliances = $this->get_draft_appliances();
		$draft_appliances_count = count($draft_appliances);
		$pending_appliances = $this->get_pending_appliances();
		$pending_appliances_count = count($pending_appliances);
		$reveiwer_rejected_appliances = $this->get_reveiwer_rejected_appliances();
		$reveiwer_rejected_appliances_count = count($reveiwer_rejected_appliances);
		$reveiwer_approved_appliances = $this->get_reveiwer_approved_appliances();
		$reveiwer_approved_appliances_count = count($reveiwer_approved_appliances);
		$published_appliances = $this->get_published_appliances();
		$published_appliances_count = count($published_appliances);
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/dashboard/appliance-requests-widget.php';
	}
	
	public function get_published_appliances() {
		$args = array(
			'post_type' => 'appliances',
			'post_status' => 'publish',
			'posts_per_page' => -1
		);
		$published_appliances = get_posts($args);
		return $published_appliances;

	}

	public function get_reveiwer_approved_appliances() {
		$args = array(
			'post_type' => 'appliances',
			'post_status' => 'approved',
		);
		$reveiwer_approved_appliances = get_posts($args);
		return $reveiwer_approved_appliances;

	}

	public function get_reveiwer_rejected_appliances() {
		$args = array(
			'post_type' => 'appliances',
			'post_status' => 'rejected',
		);
		$reveiwer_rejected_appliances = get_posts($args);
		return $reveiwer_rejected_appliances;

	}

	public function get_pending_appliances() {
		$args = array(
			'post_type' => 'appliances',
			'post_status' => 'pending',
		);
		$pending_appliances = get_posts($args);
		return $pending_appliances;

	}

	public function get_draft_appliances() {
		$args = array(
			'post_type' => 'appliances',
			'post_status' => 'draft',
		);
		$draft_appliances = get_posts($args);
		return $draft_appliances;
	}

	/**
	 * get all data reviewers
	 *
	 * @return array $emails_as_array
	 */
	public function get_data_reviewers_email_addresses() {
		$data_reviewers = get_users(array(
			'role__in' => array(
				'data_reviewer'
			)
		));
		$emails_as_array = wp_list_pluck( $data_reviewers, 'user_email' );
		if(defined('LOCAL_DEV')) {
			$emails_as_array = array(LOCAL_DEV);
		}
		return $emails_as_array;

	}

	/**
	 * get all data entry
	 *
	 * @return array $emails_as_array
	 */
	public function get_data_entry_email_addresses() {
		$data_entry = get_users(array(
			'role__in' => array(
				'data_entry'
			)
		));
		$emails_as_array = wp_list_pluck( $data_entry, 'user_email' );
		if(defined('LOCAL_DEV')) {
			$emails_as_array = array(LOCAL_DEV);
		}
		return $emails_as_array;

	}
	
	/**
	 * get all data approvers
	 *
	 * @return array $emails_as_array
	 */

	public function get_data_approver_email_addresses() {
		$data_approvers = get_users(array(
			'role__in' => array(
				'data_approver'
			)
		));
		$emails_as_array = wp_list_pluck( $data_approvers, 'user_email' );
		if(defined('LOCAL_DEV')) {
			$emails_as_array = array(LOCAL_DEV);
		}
		return $emails_as_array;

	}

	/**
	 * when appliance is submitted for review
	 *
	 * @param [type] $post_id
	 * @param [type] $post
	 * @param [type] $update
	 * @return void
	 */
	public function defra_save_appliances($post_id, $post, $update) {

		// bail out if this is an autosave
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}
		
		// bail out if this is not an event item
		if ( 'appliances' !== $post->post_type ) {
			return;
		}

		remove_action( 'save_post_appliances', array($this, 'defra_save_appliances'), 10, 3 );

		$post = $this->check_data_approval_process_status($post);
		
		// if pending then notify data reviewers
		if($post->post_status == 'pending') {
			$data_reviewers = $this->get_data_reviewers_email_addresses();
			$subject = 'Appliance submitted for review';
			$content = 'Appliance ID: ' . get_post_meta($post_id, 'appliance_id', true) . '<br>';
			$content .= 'To review submitted Appliance <a href="'.home_url().'/wp-admin/post.php?post='.$post_id.'&action=edit"><strong>click here</strong></a>';
			$headers = array('Content-Type: text/html; charset=UTF-8');
			wp_mail($data_reviewers, $subject, $content, $headers);
			wp_update_post( $post, true );
			$this->update_pending_meta($post);

		}

		// if rejected then notify data entry
		if($post->post_status == 'rejected') {
			$data_entry = $this->get_data_entry_email_addresses();
			$subject = 'Appliance Rejected!';
			$content = 'To review rejected Appliance <a href="'.home_url().'/wp-admin/post.php?post='.$post_id.'&action=edit"><strong>click here</strong></a>';
			$headers = array('Content-Type: text/html; charset=UTF-8');
			wp_mail($data_entry, $subject, $content, $headers);
			wp_update_post( $post, true );
			$this->update_rejected_meta($post);

		}

		// if approved then notify data approvers
		if($post->post_status == 'approved') {
			$data_approvers = $this->get_data_approver_email_addresses();
			$subject = 'Appliance reviewed and awaiting approval';
			$content = '<strong>Appliance ID: ' . get_post_meta($post_id, 'appliance_id', true) . '</strong><br>';
			$content .= 'The following Appliance has been approved by a reviewer and is now awaiting approval<br>';
			$content .= '<a href="'.home_url().'/wp-admin/post.php?post='.$post_id.'&action=edit"><strong>View</strong></a>';
			$headers = array('Content-Type: text/html; charset=UTF-8');
			wp_mail($data_approvers, $subject, $content, $headers);
			wp_update_post( $post, true );
			$this->update_approve_meta($post);

		}
		
		add_action( 'save_post_appliances', array($this, 'defra_save_appliances'), 10, 3 );


	}

	/**
	 * when fuel is submitted for review
	 *
	 * @param [type] $post_id
	 * @param [type] $post
	 * @param [type] $update
	 * @return void
	 */
	public function defra_save_fuels($post_id, $post, $update) {

		// bail out if this is an autosave
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}
		
		// bail out if this is not an event item
		if ( 'fuels' !== $post->post_type ) {
			return;
		}

		remove_action( 'save_post_fuels', array($this, 'defra_save_fuels'), 10, 3 );

		$post = $this->check_data_approval_process_status($post);
		
		// if pending then notify data reviewers
		if($post->post_status == 'pending') {
			$data_reviewers = $this->get_data_reviewers_email_addresses();
			$subject = 'Fuel submitted for review';
			$content = 'Fuel ID: ' . get_post_meta($post_id, 'fuel_id', true) . '<br>';
			$content .= 'To review submitted Fuel <a href="'.home_url().'/wp-admin/post.php?post='.$post_id.'&action=edit"><strong>click here</strong></a>';
			$headers = array('Content-Type: text/html; charset=UTF-8');
			wp_mail($data_reviewers, $subject, $content, $headers);
			wp_update_post( $post, true );
			$this->update_pending_meta($post);

		}

		// if rejected then notify data entry
		if($post->post_status == 'rejected') {
			$data_entry = $this->get_data_entry_email_addresses();
			$subject = 'Fuel Rejected!';
			$content = 'To review rejected Fuel <a href="'.home_url().'/wp-admin/post.php?post='.$post_id.'&action=edit"><strong>click here</strong></a>';
			$headers = array('Content-Type: text/html; charset=UTF-8');
			wp_mail($data_entry, $subject, $content, $headers);
			wp_update_post( $post, true );
			$this->update_rejected_meta($post);

		}

		// if approved then notify data approvers
		if($post->post_status == 'approved') {
			$data_approvers = $this->get_data_approver_email_addresses();
			$subject = 'Appliance reviewed and awaiting approval';
			$content = '<strong>Appliance ID: ' . get_post_meta($post_id, 'appliance_id', true) . '</strong><br>';
			$content .= 'The following Appliance has been approved by a reviewer and is now awaiting approval<br>';
			$content .= '<a href="'.home_url().'/wp-admin/post.php?post='.$post_id.'&action=edit"><strong>View</strong></a>';
			$headers = array('Content-Type: text/html; charset=UTF-8');
			wp_mail($data_approvers, $subject, $content, $headers);
			wp_update_post( $post, true );
			$this->update_approve_meta($post);

		}
		
		add_action( 'save_post_fuels', array($this, 'defra_save_fuels'), 10, 3 );


	}

	
	/**
	 * Create a data process status select box
	 *
	 * @param [type] $post
	 * @return void
	 */
	public function defra_process_status($post){
		if($post->post_type != 'appliances') {
			return; // die early 
		}
		$current_user = wp_get_current_user();
		$allowed_roles = array('data_reviewer', 'administrator');
		if ( array_intersect($allowed_roles, $current_user->roles) ) { ?>
	
			<div class="my-options">
				<label for="defra_data_process_status" style="padding-bottom:8px; display:block;">Data Approval Status</label>
				<select id="defra_data_process_status" name="defra_data_process_status">
					<option value="">Select Status</option>
					<option value="rejected" <?php selected( $post->post_status, 'rejected', true ); ?>>Reject</option>
					<option value="approved" <?php selected( $post->post_status, 'approved', true ); ?>>Approve</option>
					<option value="pending" <?php selected( $post->post_status, 'pending', true ); ?>>Pending</option>
				</select>
			</div>
			
		<?php }

	}

	/**
	 * Register a post status for rejected
	 *
	 * @return void
	 */
	public function defra_custom_post_status_rejected(){
		register_post_status( 'rejected', array(
			'label'                     => _x( 'Rejected', 'post' ),
			'public'                    => false,
			'exclude_from_search'       => true,
			'show_in_admin_all_list'    => true,
			'show_in_admin_status_list' => true,
			'label_count'               => _n_noop( 'Rejected <span class="count">(%s)</span>', 'Rejected <span class="count">(%s)</span>' ),
		) );
	}

	/**
	 * Register a post status approved
	 *
	 * @return void
	 */
	public function defra_custom_post_status_approved(){
		register_post_status( 'approved', array(
			'label'                     => _x( 'Approved', 'post' ),
			'public'                    => false,
			'exclude_from_search'       => true,
			'show_in_admin_all_list'    => true,
			'show_in_admin_status_list' => true,
			'label_count'               => _n_noop( 'Approved <span class="count">(%s)</span>', 'Approved <span class="count">(%s)</span>' ),
		) );
	}

	/**
	 * Setup a post_status check
	 *
	 * @param object $post
	 * @return object $post
	 */
	public function check_data_approval_process_status($post) {
		if(isset($_POST) && !empty($_POST['defra_data_process_status'])) {
			$post->post_status = $_POST['defra_data_process_status'];
		}
		return $post;
	}

	/**
	 * Create a date in the formate of YYYYMMDD
	 *
	 * @return string $date
	 */
	public function set_date_now() {
		$timezone = new DateTimeZone('Europe/London'); 
		$now = new DateTime('now', $timezone);
		$date = $now->format('Ymd');
		return $date;
	}
	
	/**
	 * Update post meta of rejected meta data
	 *
	 * @param object $post
	 * @return void
	 */
	public function update_rejected_meta($post) {
		$current_user = wp_get_current_user();
		$date = $this->set_date_now();
		update_post_meta( $post->ID, 'reviewer_user_id', $current_user->ID );
		update_post_meta( $post->ID, 'reviewer_reject_date', $date );
	}

	/**
	 * Update post meta of pending meta data
	 *
	 * @param object $post
	 * @return void
	 */
	public function update_pending_meta($post) {
		$current_user = wp_get_current_user();
		$date = $this->set_date_now();
		update_post_meta( $post->ID, 'reviewer_assign_date', $date );
	}

	/**
	 * Update post meta of approve meta data
	 *
	 * @param object $post
	 * @return void
	 */
	public function update_approve_meta($post) {
		$current_user = wp_get_current_user();
		$date = $this->set_date_now();
		update_post_meta( $post->ID, 'reviewer_approve_date', $date );
	}


	/** show comment custom meta */
	public function comment_types($type_id) {
		$array = array(
			'1' => 'Data Entry User',
			'2' => 'Reviewer',
			'3' => 'Approver',
			'4' => 'Devolved Admin'
		);
		return $array[$type_id];
	}
	public function comment_actions($action_id) {
		$array = array(
			'1' => 'Data Entry',
			'2' => 'Approved',
			'3' => 'Rejected',
			'4' => 'Cancelled'
		);
		return $array[$action_id];

	}

	/**
	 * Show appened comment meta 
	 *
	 * @param string $comment_text
	 * @return string $comment_text
	 */
	public function show_defra_comments_admin ( $comment_text ) {
		$comment_type = $this->comment_types(get_comment_meta( get_comment_ID(), "comment_type_id", true));
		$comment_action_id = $this->comment_actions(get_comment_meta( get_comment_ID(), "comment_action_id", true));
		if ( $comment_type ) {
			$additional_text = '<p>Comment Type: ' . $comment_type . '</p>';
			$additional_text .= '<p>Action Type: ' . $comment_action_id . '</p>';
			$comment_text = $comment_text . $additional_text;
			return $comment_text;
		} else {
			return $comment_text;
		}
	}
	
	
}
