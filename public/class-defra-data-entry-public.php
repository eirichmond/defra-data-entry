<?php

require WP_PLUGIN_DIR . '/defra-data-entry/vendor/autoload.php';
// reference the Dompdf namespace
use Spipu\Html2Pdf\Html2Pdf;
// reference the Dompdf namespace
use Dompdf\Dompdf;
use Dompdf\Options;

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://squareone.software
 * @since      1.0.0
 *
 * @package    Defra_Data_Entry
 * @subpackage Defra_Data_Entry/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Defra_Data_Entry
 * @subpackage Defra_Data_Entry/public
 * @author     Elliott Richmond <elliott@squareonemd.co.uk>
 */
class Defra_Data_Entry_Public {

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
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
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

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/defra-data-entry-public.css', array(), $this->version, 'all' );
		wp_enqueue_style( $this->plugin_name . '-datatables', plugin_dir_url( __FILE__ ) . 'css/datatables.css', array(), $this->version, 'all' );
		wp_enqueue_style( $this->plugin_name . '-select2', plugin_dir_url( __FILE__ ) . 'css/select2.min.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
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

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/defra-data-entry-public.js', array( 'jquery' ), $this->version, false );
		wp_localize_script( $this->plugin_name, 'defra_object', array( 'ajax_url' => admin_url( 'admin-ajax.php' ), 'nextNonce' => wp_create_nonce( 'create_nonce' ) ) );

		if ( is_page( 'create-new-appliance' ) ) {
			wp_enqueue_script( $this->plugin_name.'-create-new-appliance', plugin_dir_url( __FILE__ ) . 'js/defra-create-new-appliance.js', array( 'jquery' ), $this->version, false );
		}

		if ( is_page( 'si-appliance' ) || is_page( 'si-fuel' ) ) {
			wp_enqueue_script( $this->plugin_name.'-si-appliance', plugin_dir_url( __FILE__ ) . 'js/defra-si-edit.js', array( 'jquery' ), $this->version, false );
		}

		if ( is_page( 'appliances' ) || is_page( 'fuels' ) ) {
			if (is_user_logged_in()) {
				wp_enqueue_script( $this->plugin_name.'-appliances', plugin_dir_url( __FILE__ ) . 'js/defra-assign-auth.js', array( 'jquery' ), $this->version, false );
				wp_localize_script( $this->plugin_name.'-appliances', 'defra_object', array( 'ajax_url' => admin_url( 'admin-ajax.php' ), 'nextNonce' => wp_create_nonce( 'create_nonce' ) ) );
			}
		}

		if ( is_singular( 'appliances' ) || is_singular( 'fuels' ) ) {
			wp_enqueue_script( $this->plugin_name.'-da-comment', plugin_dir_url( __FILE__ ) . 'js/defra-comments.js', array( 'jquery' ), $this->version, false );
		}


		wp_enqueue_script( $this->plugin_name . '-datatables', plugin_dir_url( __FILE__ ) . 'js/datatables.min.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script( $this->plugin_name . '-select2', plugin_dir_url( __FILE__ ) . 'js/select2.full.min.js', array( 'jquery' ), $this->version, false );

	}
	
	public function defra_assign_link() {
		if (!wp_verify_nonce($_POST['defra_assign'], 'defra-assign')) {
			wp_die('Sorry, there was a security issue. Please try again.');
		}
		$approver_counties = $this->get_exemption_countries();
		$audit = new Defra_Data_Audit_Log();
		$permalink = get_the_permalink($_POST["post_id"]);
		$datetime = new DateTime('now', new DateTimeZone('Europe/London'));
		$post = get_post($_POST["post_id"]);
		
		if($_POST["role"] == 'data_reviewer') {
			update_post_meta( $_POST["post_id"], 'reviewer_user_id', $_POST["user_id"] );
			update_post_meta( $_POST["post_id"], 'reviewer_assign_date', $datetime->format('Y-m-d H:i:s') );

			if( $_POST["revoked"] == 'true' ) {
				get_post_meta( $_POST["post_id"], $post->post_type == 'appliances' ? 'exempt-in_country_and_statutory_instrument_england_revoke_status_id' : 'authorised_country_and_statutory_instrument_england_revoke_status_id', true ) ? update_post_meta( $_POST["post_id"], $post->post_type == 'appliances' ? 'exempt-in_country_and_statutory_instrument_england_revoke_status_id' : 'authorised_country_and_statutory_instrument_england_revoke_status_id', '30' ) : null;
				get_post_meta( $_POST["post_id"], $post->post_type == 'appliances' ? 'exempt-in_country_and_statutory_instrument_wales_revoke_status_id' : 'authorised_country_and_statutory_instrument_wales_revoke_status_id', true ) ? update_post_meta( $_POST["post_id"], $post->post_type == 'appliances' ? 'exempt-in_country_and_statutory_instrument_wales_revoke_status_id' : 'authorised_country_and_statutory_instrument_wales_revoke_status_id', '30' ) : null;
				get_post_meta( $_POST["post_id"], $post->post_type == 'appliances' ? 'exempt-in_country_and_statutory_instrument_scotland_revoke_status_id' : 'authorised_country_and_statutory_instrument_scotland_revoke_status_id', true ) ? update_post_meta( $_POST["post_id"], $post->post_type == 'appliances' ? 'exempt-in_country_and_statutory_instrument_scotland_revoke_status_id' : 'authorised_country_and_statutory_instrument_scotland_revoke_status_id', '30' ) : null;
				get_post_meta( $_POST["post_id"], $post->post_type == 'appliances' ? 'exempt-in_country_and_statutory_instrument_n_ireland_revoke_status_id' : 'authorised_country_and_statutory_instrument_n_ireland_revoke_status_id', true ) ? update_post_meta( $_POST["post_id"], $post->post_type == 'appliances' ? 'exempt-in_country_and_statutory_instrument_n_ireland_revoke_status_id' : 'authorised_country_and_statutory_instrument_n_ireland_revoke_status_id', '30' ) : null;
			} else {
				get_post_meta( $_POST["post_id"], $post->post_type == 'appliances' ? 'exempt-in_country_and_statutory_instrument_england_status' : 'authorised_country_and_statutory_instrument_england_status', true ) ? update_post_meta( $_POST["post_id"], $post->post_type == 'appliances' ? 'exempt-in_country_and_statutory_instrument_england_status' : 'authorised_country_and_statutory_instrument_england_status', '30' ) : null;
				get_post_meta( $_POST["post_id"], $post->post_type == 'appliances' ? 'exempt-in_country_and_statutory_instrument_wales_status' : 'authorised_country_and_statutory_instrument_wales_status', true ) ? update_post_meta( $_POST["post_id"], $post->post_type == 'appliances' ? 'exempt-in_country_and_statutory_instrument_wales_status' : 'authorised_country_and_statutory_instrument_wales_status', '30' ) : null;
				get_post_meta( $_POST["post_id"], $post->post_type == 'appliances' ? 'exempt-in_country_and_statutory_instrument_scotland_status' : 'authorised_country_and_statutory_instrument_scotland_status', true ) ? update_post_meta( $_POST["post_id"], $post->post_type == 'appliances' ? 'exempt-in_country_and_statutory_instrument_scotland_status' : 'authorised_country_and_statutory_instrument_scotland_status', '30' ) : null;
				get_post_meta( $_POST["post_id"], $post->post_type == 'appliances' ? 'exempt-in_country_and_statutory_instrument_n_ireland_status' : 'authorised_country_and_statutory_instrument_n_ireland_status', true ) ? update_post_meta( $_POST["post_id"], $post->post_type == 'appliances' ? 'exempt-in_country_and_statutory_instrument_n_ireland_status' : 'authorised_country_and_statutory_instrument_n_ireland_status', '30' ) : null;
			}

			$audit->defra_audit_log($_POST["user_id"], $post->post_type == 'appliances' ? 'appliance' : 'fuel', $_POST["post_id"], 'Data Reviewer assigned '.$post->post_type == 'appliances' ? 'appliance' : 'fuel'.' to their account', $_SERVER["REMOTE_ADDR"]);
		}
		if($_POST["role"] == 'data_approver') {

			$country_approver_key = get_user_meta( $_POST["user_id"], 'approver_country_id', true );

			if($_POST["revoked"] == 'true') { // set only if revocation requested 

				update_post_meta( $_POST["post_id"], $post->post_type == 'appliances' ? 'exempt-in_country_and_statutory_instrument_'.$approver_counties[$country_approver_key].'_revoke_assigned_user_id' : 'authorised_country_and_statutory_instrument_'.$approver_counties[$country_approver_key].'_revoke_assigned_user_id', $_POST["user_id"] );
				update_post_meta( $_POST["post_id"], $post->post_type == 'appliances' ? 'exempt-in_country_and_statutory_instrument_'.$approver_counties[$country_approver_key].'_revoke_assigned_date' : 'authorised_country_and_statutory_instrument_'.$approver_counties[$country_approver_key].'_revoke_assigned_date', $datetime->format('Y-m-d H:i:s') );
				update_post_meta( $_POST["post_id"], $post->post_type == 'appliances' ? 'exempt-in_country_and_statutory_instrument_'.$approver_counties[$country_approver_key].'_revoke_status_id' : 'authorised_country_and_statutory_instrument_'.$approver_counties[$country_approver_key].'_revoke_status_id', '60' );

			} else {
				update_post_meta( $_POST["post_id"], $post->post_type == 'appliances' ? 'exempt-in_country_and_statutory_instrument_'.$approver_counties[$country_approver_key].'_status' : 'authorised_country_and_statutory_instrument_'.$approver_counties[$country_approver_key].'_status', '60' );
				update_post_meta( $_POST["post_id"], $post->post_type == 'appliances' ? 'exempt-in_country_and_statutory_instrument_'.$approver_counties[$country_approver_key].'_user' : 'authorised_country_and_statutory_instrument_'.$approver_counties[$country_approver_key].'_user', $_POST["user_id"] );
				update_post_meta( $_POST["post_id"], $post->post_type == 'appliances' ? 'exempt-in_country_and_statutory_instrument_'.$approver_counties[$country_approver_key].'_assigned_date' : 'authorised_country_and_statutory_instrument_'.$approver_counties[$country_approver_key].'_assigned_date', $datetime->format('Y-m-d H:i:s') );
			}

			$audit->defra_audit_log($_POST["user_id"], $post->post_type == 'appliances' ? 'appliance_country' : 'fuel_country', $_POST["post_id"], $post->post_type == 'appliances' ? 'Appliance' : 'Fuel' . ' for '.ucfirst($approver_counties[$country_approver_key]).' assigned to user_id: ('.$_POST["user_id"].')', $_SERVER["REMOTE_ADDR"]);

		}

		wp_send_json( $permalink );
		
	}

	/**
	 * custom login logo
	 *
	 * @return void
	 */
	public function defra_login_logo() {
	    wp_enqueue_style( 'custom-login', plugin_dir_url( __FILE__ ) . 'css/defra-data-entry-style-login.css' );
	}

	/**
	 * Mail from
	 *
	 * @return void
	 */
	public function defra_mail_from($email_address) {
	    return 'no-reply@smokecontrol-data-entry.hetas.co.uk';
	}

	/**
	 * Mail from name
	 *
	 * @return void
	 */
	public function defra_mail_from_name($email_address) {
	    return 'Clean Air Act Data Entry System';
	}

	/**
	 * Redirect after login
	 *
	 * @param string $redirect_to
	 * @param string $requested_redirect_to
	 * @param object $user
	 * @return void
	 */
	public function defra_login_redirect($redirect_to, $requested_redirect_to, $user) {
		$redirect_to = home_url( '/data-entry/dashboard/' );
		return $redirect_to;
	}

	/**
	 * Return the post id
	 *
	 * @param array $global of the super global $_GET
	 * @param string $string
	 * @return void
	 */
	public function resolve_id($global, $string) {
		return $global[$string];
	}

	/**
	 * Register all custom post types and tax
	 *
	 * @return void
	 */
	public function defra_register_cpts() {

		/**
		 * Post Type: Manufacturers.
		 */
	
		$labels = [
			"name" => __( "Manufacturers", "defra-data" ),
			"singular_name" => __( "Manufacturer", "defra-data" ),
			"menu_name" => __( "Manufacturers", "defra-data" ),
			"all_items" => __( "Manufacturers", "defra-data" ),
			"add_new" => __( "Add new", "defra-data" ),
			"add_new_item" => __( "Add new Manufacturer", "defra-data" ),
			"edit_item" => __( "Edit Manufacturer", "defra-data" ),
			"new_item" => __( "New Manufacturer", "defra-data" ),
			"view_item" => __( "View Manufacturer", "defra-data" ),
			"view_items" => __( "View Manufacturers", "defra-data" ),
			"search_items" => __( "Search Manufacturers", "defra-data" ),
			"not_found" => __( "No Manufacturers found", "defra-data" ),
			"not_found_in_trash" => __( "No Manufacturers found in bin", "defra-data" ),
			"parent" => __( "Parent Manufacturer:", "defra-data" ),
			"featured_image" => __( "Featured image for this Manufacturer", "defra-data" ),
			"set_featured_image" => __( "Set featured image for this Manufacturer", "defra-data" ),
			"remove_featured_image" => __( "Remove featured image for this Manufacturer", "defra-data" ),
			"use_featured_image" => __( "Use as featured image for this Manufacturer", "defra-data" ),
			"archives" => __( "Manufacturer archives", "defra-data" ),
			"insert_into_item" => __( "Insert into Manufacturer", "defra-data" ),
			"uploaded_to_this_item" => __( "Upload to this Manufacturer", "defra-data" ),
			"filter_items_list" => __( "Filter Manufacturers list", "defra-data" ),
			"items_list_navigation" => __( "Manufacturers list navigation", "defra-data" ),
			"items_list" => __( "Manufacturers list", "defra-data" ),
			"attributes" => __( "Manufacturers attributes", "defra-data" ),
			"name_admin_bar" => __( "Manufacturer", "defra-data" ),
			"item_published" => __( "Manufacturer published", "defra-data" ),
			"item_published_privately" => __( "Manufacturer published privately.", "defra-data" ),
			"item_reverted_to_draft" => __( "Manufacturer reverted to draft.", "defra-data" ),
			"item_scheduled" => __( "Manufacturer scheduled", "defra-data" ),
			"item_updated" => __( "Manufacturer updated.", "defra-data" ),
			"parent_item_colon" => __( "Parent Manufacturer:", "defra-data" ),
		];
	
		$args = [
			"label" => __( "Manufacturers", "defra-data" ),
			"labels" => $labels,
			"description" => "",
			"public" => true,
			"publicly_queryable" => true,
			"show_ui" => true,
			"show_in_rest" => true,
			"rest_base" => "defra_manufacturers",
			"rest_controller_class" => "WP_REST_Posts_Controller",
			"has_archive" => "manufacturers",
			"show_in_menu" => true,
			"show_in_nav_menus" => true,
			"delete_with_user" => false,
			"exclude_from_search" => false,
			"capability_type" => "post",
			"capabilities" => [
				'edit_post' => 'edit_manufacturer',
				'edit_posts' => 'edit_manufacturers',
				'edit_others_posts' => 'edit_others_manufacturers',
				'publish_posts' => 'publish_manufacturers',
				'read_post' => 'read_manufacturers',
				'read_private_posts' => 'read_private_manufacturers',
				'delete_post' => 'delete_manufacturer'
			],
			"map_meta_cap" => false,
			"hierarchical" => false,
			"rewrite" => [ "slug" => "manufacturers", "with_front" => true ],
			"query_var" => true,
			"menu_position" => 9,
			"menu_icon" => "dashicons-building",
			"supports" => [ "title" ],
			"show_in_graphql" => false,
		];
	
		register_post_type( "manufacturers", $args );
	
		/**
		 * Post Type: Fuels.
		 */
	
		$labels = [
			"name" => __( "Fuels", "defra-data" ),
			"singular_name" => __( "Fuel", "defra-data" ),
			"menu_name" => __( "Fuels", "defra-data" ),
			"all_items" => __( "All Fuels", "defra-data" ),
			"add_new" => __( "Add new", "defra-data" ),
			"add_new_item" => __( "Add new Fuel", "defra-data" ),
			"edit_item" => __( "Edit Fuel", "defra-data" ),
			"new_item" => __( "New Fuel", "defra-data" ),
			"view_item" => __( "View Fuel", "defra-data" ),
			"view_items" => __( "View Fuels", "defra-data" ),
			"search_items" => __( "Search Fuels", "defra-data" ),
			"not_found" => __( "No Fuels found", "defra-data" ),
			"not_found_in_trash" => __( "No Fuels found in bin", "defra-data" ),
			"parent" => __( "Parent Fuel:", "defra-data" ),
			"featured_image" => __( "Featured image for this Fuel", "defra-data" ),
			"set_featured_image" => __( "Set featured image for this Fuel", "defra-data" ),
			"remove_featured_image" => __( "Remove featured image for this Fuel", "defra-data" ),
			"use_featured_image" => __( "Use as featured image for this Fuel", "defra-data" ),
			"archives" => __( "Fuel archives", "defra-data" ),
			"insert_into_item" => __( "Insert into Fuel", "defra-data" ),
			"uploaded_to_this_item" => __( "Upload to this Fuel", "defra-data" ),
			"filter_items_list" => __( "Filter Fuels list", "defra-data" ),
			"items_list_navigation" => __( "Fuels list navigation", "defra-data" ),
			"items_list" => __( "Fuels list", "defra-data" ),
			"attributes" => __( "Fuels attributes", "defra-data" ),
			"name_admin_bar" => __( "Fuel", "defra-data" ),
			"item_published" => __( "Fuel published", "defra-data" ),
			"item_published_privately" => __( "Fuel published privately.", "defra-data" ),
			"item_reverted_to_draft" => __( "Fuel reverted to draft.", "defra-data" ),
			"item_scheduled" => __( "Fuel scheduled", "defra-data" ),
			"item_updated" => __( "Fuel updated.", "defra-data" ),
			"parent_item_colon" => __( "Parent Fuel:", "defra-data" ),
		];
	
		$args = [
			"label" => __( "Fuels", "defra-data" ),
			"labels" => $labels,
			"description" => "",
			"public" => false,
			"publicly_queryable" => true,
			"show_ui" => true,
			"show_in_rest" => true,
			"rest_base" => "",
			"rest_controller_class" => "WP_REST_Posts_Controller",
			"has_archive" => true,
			"show_in_menu" => true,
			"show_in_nav_menus" => true,
			"delete_with_user" => false,
			"exclude_from_search" => false,
			"capability_type" => "post",
			"capabilities" => [
				'edit_post' => 'edit_fuel',
				'edit_posts' => 'edit_fuels',
				'edit_others_posts' => 'edit_others_fuels',
				'publish_posts' => 'publish_fuels',
				'read_post' => 'read_fuels',
				'read_private_posts' => 'read_private_fuels',
				'delete_post' => 'delete_fuel'
			],
			"map_meta_cap" => false,
			"hierarchical" => false,
			"rewrite" => [ "slug" => "fuels", "with_front" => true ],
			"query_var" => true,
			"menu_position" => 6,
			"menu_icon" => "dashicons-lightbulb",
			"supports" => [ "title", "comments", "revisions", "author" ],
			"show_in_graphql" => false,
		];
	
		register_post_type( "fuels", $args );
	
		/**
		 * Post Type: Appliances.
		 */
	
		$labels = [
			"name" => __( "Appliances", "defra-data" ),
			"singular_name" => __( "Appliance", "defra-data" ),
			"menu_name" => __( "Appliances", "defra-data" ),
			"all_items" => __( "All Appliances", "defra-data" ),
			"add_new" => __( "Add new", "defra-data" ),
			"add_new_item" => __( "Add new Appliance", "defra-data" ),
			"edit_item" => __( "Edit Appliance", "defra-data" ),
			"new_item" => __( "New Appliance", "defra-data" ),
			"view_item" => __( "View Appliance", "defra-data" ),
			"view_items" => __( "View Appliances", "defra-data" ),
			"search_items" => __( "Search Appliances", "defra-data" ),
			"not_found" => __( "No Appliances found", "defra-data" ),
			"not_found_in_trash" => __( "No Appliances found in bin", "defra-data" ),
			"parent" => __( "Parent Appliance:", "defra-data" ),
			"featured_image" => __( "Featured image for this Appliance", "defra-data" ),
			"set_featured_image" => __( "Set featured image for this Appliance", "defra-data" ),
			"remove_featured_image" => __( "Remove featured image for this Appliance", "defra-data" ),
			"use_featured_image" => __( "Use as featured image for this Appliance", "defra-data" ),
			"archives" => __( "Appliance archives", "defra-data" ),
			"insert_into_item" => __( "Insert into Appliance", "defra-data" ),
			"uploaded_to_this_item" => __( "Upload to this Appliance", "defra-data" ),
			"filter_items_list" => __( "Filter Appliances list", "defra-data" ),
			"items_list_navigation" => __( "Appliances list navigation", "defra-data" ),
			"items_list" => __( "Appliances list", "defra-data" ),
			"attributes" => __( "Appliances attributes", "defra-data" ),
			"name_admin_bar" => __( "Appliance", "defra-data" ),
			"item_published" => __( "Appliance published", "defra-data" ),
			"item_published_privately" => __( "Appliance published privately.", "defra-data" ),
			"item_reverted_to_draft" => __( "Appliance reverted to draft.", "defra-data" ),
			"item_scheduled" => __( "Appliance scheduled", "defra-data" ),
			"item_updated" => __( "Appliance updated.", "defra-data" ),
			"parent_item_colon" => __( "Parent Appliance:", "defra-data" ),
		];
	
		$args = [
			"label" => __( "Appliances", "defra-data" ),
			"labels" => $labels,
			"description" => "",
			"public" => false,
			"publicly_queryable" => true,
			"show_ui" => true,
			"show_in_rest" => true,
			"rest_base" => "",
			"rest_controller_class" => "WP_REST_Posts_Controller",
			"has_archive" => true,
			"show_in_menu" => true,
			"show_in_nav_menus" => true,
			"delete_with_user" => false,
			"exclude_from_search" => false,
			"capability_type" => "post",
			"capabilities" => [
				'edit_post' => 'edit_appliance',
				'edit_posts' => 'edit_appliances',
				'edit_others_posts' => 'edit_others_appliances',
				'publish_posts' => 'publish_appliances',
				'read_post' => 'read_appliances',
				'read_private_posts' => 'read_private_appliances',
				'delete_post' => 'delete_appliance'
			],
			"map_meta_cap" => false,
			"hierarchical" => false,
			"rewrite" => [ "slug" => "appliances", "with_front" => true ],
			"query_var" => true,
			"menu_position" => 5,
			"menu_icon" => "dashicons-editor-table",
			"supports" => [ "title", "comments", "revisions", "author" ],
			"show_in_graphql" => false,
		];
	
		register_post_type( "appliances", $args );
	
		/**
		 * Post Type: Statutory Instruments.
		 */
	
		$labels = [
			"name" => __( "Statutory Instruments", "defra-data" ),
			"singular_name" => __( "Statutory Instrument", "defra-data" ),
			"menu_name" => __( "Statutory Instruments", "defra-data" ),
			"all_items" => __( "All Statutory Instruments", "defra-data" ),
			"add_new" => __( "Add new", "defra-data" ),
			"add_new_item" => __( "Add new Statutory Instrument", "defra-data" ),
			"edit_item" => __( "Edit Statutory Instrument", "defra-data" ),
			"new_item" => __( "New Statutory Instrument", "defra-data" ),
			"view_item" => __( "View Statutory Instrument", "defra-data" ),
			"view_items" => __( "View Statutory Instruments", "defra-data" ),
			"search_items" => __( "Search Statutory Instruments", "defra-data" ),
			"not_found" => __( "No Statutory Instruments found", "defra-data" ),
			"not_found_in_trash" => __( "No Statutory Instruments found in bin", "defra-data" ),
			"parent" => __( "Parent Statutory Instrument:", "defra-data" ),
			"featured_image" => __( "Featured image for this Statutory Instrument", "defra-data" ),
			"set_featured_image" => __( "Set featured image for this Statutory Instrument", "defra-data" ),
			"remove_featured_image" => __( "Remove featured image for this Statutory Instrument", "defra-data" ),
			"use_featured_image" => __( "Use as featured image for this Statutory Instrument", "defra-data" ),
			"archives" => __( "Statutory Instrument archives", "defra-data" ),
			"insert_into_item" => __( "Insert into Statutory Instrument", "defra-data" ),
			"uploaded_to_this_item" => __( "Upload to this Statutory Instrument", "defra-data" ),
			"filter_items_list" => __( "Filter Statutory Instruments list", "defra-data" ),
			"items_list_navigation" => __( "Statutory Instruments list navigation", "defra-data" ),
			"items_list" => __( "Statutory Instruments list", "defra-data" ),
			"attributes" => __( "Statutory Instruments attributes", "defra-data" ),
			"name_admin_bar" => __( "Statutory Instrument", "defra-data" ),
			"item_published" => __( "Statutory Instrument published", "defra-data" ),
			"item_published_privately" => __( "Statutory Instrument published privately.", "defra-data" ),
			"item_reverted_to_draft" => __( "Statutory Instrument reverted to draft.", "defra-data" ),
			"item_scheduled" => __( "Statutory Instrument scheduled", "defra-data" ),
			"item_updated" => __( "Statutory Instrument updated.", "defra-data" ),
			"parent_item_colon" => __( "Parent Statutory Instrument:", "defra-data" ),
		];
	
		$args = [
			"label" => __( "Statutory Instruments", "defra-data" ),
			"labels" => $labels,
			"description" => "",
			"public" => true,
			"publicly_queryable" => true,
			"show_ui" => true,
			"show_in_rest" => true,
			"rest_base" => "",
			"rest_controller_class" => "WP_REST_Posts_Controller",
			"has_archive" => false,
			"show_in_menu" => true,
			"show_in_nav_menus" => true,
			"delete_with_user" => false,
			"exclude_from_search" => false,
			"capability_type" => "post",
			"capabilities" => [
				'edit_post' => 'edit_statutory_instrument',
				'edit_posts' => 'edit_statutory_instruments',
				'edit_others_posts' => 'edit_others_statutory_instruments',
				'publish_posts' => 'publish_statutory_instruments',
				'read_post' => 'read_statutory_instruments',
				'read_private_posts' => 'read_private_statutory_instruments',
				'delete_post' => 'delete_statutory_instrument'
			],
			"map_meta_cap" => false,
			"hierarchical" => false,
			"rewrite" => [ "slug" => "statutory_instrument", "with_front" => true ],
			"query_var" => true,
			"menu_position" => 7,
			"supports" => [ "title", "editor" ],
			"show_in_graphql" => false,
		];
	
		register_post_type( "statutory_instrument", $args );
	
	}

	/**
	 * Register all custom  tax
	 *
	 * @return void
	 */

	public function defra_register_ctts() {

		/**
		 * Taxonomy: Manufacturer Types.
		 */
	
		$labels = [
			"name" => __( "Manufacturer Types", "defra-data" ),
			"singular_name" => __( "Manufacturer Type", "defra-data" ),
			"menu_name" => __( "Manufacturer Types", "defra-data" ),
			"all_items" => __( "All Manufacturer Types", "defra-data" ),
			"edit_item" => __( "Edit Manufacturer Type", "defra-data" ),
			"view_item" => __( "View Manufacturer Type", "defra-data" ),
			"update_item" => __( "Update Manufacturer Type name", "defra-data" ),
			"add_new_item" => __( "Add new Manufacturer Type", "defra-data" ),
			"new_item_name" => __( "New Manufacturer Type name", "defra-data" ),
			"parent_item" => __( "Parent Manufacturer Type", "defra-data" ),
			"parent_item_colon" => __( "Parent Manufacturer Type:", "defra-data" ),
			"search_items" => __( "Search Manufacturer Types", "defra-data" ),
			"popular_items" => __( "Popular Manufacturer Types", "defra-data" ),
			"separate_items_with_commas" => __( "Separate Manufacturer Types with commas", "defra-data" ),
			"add_or_remove_items" => __( "Add or remove Manufacturer Types", "defra-data" ),
			"choose_from_most_used" => __( "Choose from the most used Manufacturer Types", "defra-data" ),
			"not_found" => __( "No Manufacturer Types found", "defra-data" ),
			"no_terms" => __( "No Manufacturer Types", "defra-data" ),
			"items_list_navigation" => __( "Manufacturer Types list navigation", "defra-data" ),
			"items_list" => __( "Manufacturer Types list", "defra-data" ),
			"back_to_items" => __( "Back to Manufacturer Types", "defra-data" ),
		];
	
		
		$args = [
			"label" => __( "Manufacturer Types", "defra-data" ),
			"labels" => $labels,
			"public" => true,
			"publicly_queryable" => true,
			"hierarchical" => false,
			"show_ui" => true,
			"show_in_menu" => true,
			"show_in_nav_menus" => true,
			"query_var" => true,
			"rewrite" => [ 'slug' => 'manufacturer_types', 'with_front' => true, ],
			"show_admin_column" => false,
			"show_in_rest" => true,
			"show_tagcloud" => false,
			"rest_base" => "manufacturer_types",
			"rest_controller_class" => "WP_REST_Terms_Controller",
			"show_in_quick_edit" => false,
			"show_in_graphql" => false,
		];
		register_taxonomy( "manufacturer_types", [ "manufacturers" ], $args );
	
		/**
		 * Taxonomy: Fuel Types.
		 */
	
		$labels = [
			"name" => __( "Fuel Types", "defra-data" ),
			"singular_name" => __( "Fuel Type", "defra-data" ),
			"menu_name" => __( "Fuel Types", "defra-data" ),
			"all_items" => __( "All Fuel Types", "defra-data" ),
			"edit_item" => __( "Edit Fuel Type", "defra-data" ),
			"view_item" => __( "View Fuel Type", "defra-data" ),
			"update_item" => __( "Update Fuel Type name", "defra-data" ),
			"add_new_item" => __( "Add new Fuel Type", "defra-data" ),
			"new_item_name" => __( "New Fuel Type name", "defra-data" ),
			"parent_item" => __( "Parent Fuel Type", "defra-data" ),
			"parent_item_colon" => __( "Parent Fuel Type:", "defra-data" ),
			"search_items" => __( "Search Fuel Types", "defra-data" ),
			"popular_items" => __( "Popular Fuel Types", "defra-data" ),
			"separate_items_with_commas" => __( "Separate Fuel Types with commas", "defra-data" ),
			"add_or_remove_items" => __( "Add or remove Fuel Types", "defra-data" ),
			"choose_from_most_used" => __( "Choose from the most used Fuel Types", "defra-data" ),
			"not_found" => __( "No Fuel Types found", "defra-data" ),
			"no_terms" => __( "No Fuel Types", "defra-data" ),
			"items_list_navigation" => __( "Fuel Types list navigation", "defra-data" ),
			"items_list" => __( "Fuel Types list", "defra-data" ),
			"back_to_items" => __( "Back to Fuel Types", "defra-data" ),
		];
	
		
		$args = [
			"label" => __( "Fuel Types", "defra-data" ),
			"labels" => $labels,
			"public" => true,
			"publicly_queryable" => true,
			"hierarchical" => false,
			"show_ui" => true,
			"show_in_menu" => true,
			"show_in_nav_menus" => true,
			"query_var" => true,
			"rewrite" => [ 'slug' => 'fuel_types', 'with_front' => true, ],
			"show_admin_column" => false,
			"show_in_rest" => true,
			"show_tagcloud" => false,
			"rest_base" => "fuel_types",
			"rest_controller_class" => "WP_REST_Terms_Controller",
			"show_in_quick_edit" => false,
			"show_in_graphql" => false,
		];
		register_taxonomy( "fuel_types", [ "appliances" ], $args );
	
		/**
		 * Taxonomy: Appliance Types.
		 */
	
		$labels = [
			"name" => __( "Appliance Types", "defra-data" ),
			"singular_name" => __( "Appliance Type", "defra-data" ),
			"menu_name" => __( "Appliance Types", "defra-data" ),
			"all_items" => __( "All Appliance Types", "defra-data" ),
			"edit_item" => __( "Edit Appliance Type", "defra-data" ),
			"view_item" => __( "View Appliance Type", "defra-data" ),
			"update_item" => __( "Update Appliance Type name", "defra-data" ),
			"add_new_item" => __( "Add new Appliance Type", "defra-data" ),
			"new_item_name" => __( "New Appliance Type name", "defra-data" ),
			"parent_item" => __( "Parent Appliance Type", "defra-data" ),
			"parent_item_colon" => __( "Parent Appliance Type:", "defra-data" ),
			"search_items" => __( "Search Appliance Types", "defra-data" ),
			"popular_items" => __( "Popular Appliance Types", "defra-data" ),
			"separate_items_with_commas" => __( "Separate Appliance Types with commas", "defra-data" ),
			"add_or_remove_items" => __( "Add or remove Appliance Types", "defra-data" ),
			"choose_from_most_used" => __( "Choose from the most used Appliance Types", "defra-data" ),
			"not_found" => __( "No Appliance Types found", "defra-data" ),
			"no_terms" => __( "No Appliance Types", "defra-data" ),
			"items_list_navigation" => __( "Appliance Types list navigation", "defra-data" ),
			"items_list" => __( "Appliance Types list", "defra-data" ),
			"back_to_items" => __( "Back to Appliance Types", "defra-data" ),
		];
	
		
		$args = [
			"label" => __( "Appliance Types", "defra-data" ),
			"labels" => $labels,
			"public" => true,
			"publicly_queryable" => true,
			"hierarchical" => false,
			"show_ui" => true,
			"show_in_menu" => true,
			"show_in_nav_menus" => true,
			"query_var" => true,
			"rewrite" => [ 'slug' => 'appliance_types', 'with_front' => true, ],
			"show_admin_column" => false,
			"show_in_rest" => true,
			"show_tagcloud" => false,
			"rest_base" => "appliance_types",
			"rest_controller_class" => "WP_REST_Terms_Controller",
			"show_in_quick_edit" => false,
			"show_in_graphql" => false,
		];
		register_taxonomy( "appliance_types", [ "appliances" ], $args );

		/**
		 * Taxonomy: Appliance Types.
		 */
	
		$labels = [
			"name" => __( "Permitted Fuels", "defra-data" ),
			"singular_name" => __( "Permitted Fuel", "defra-data" ),
			"menu_name" => __( "Permitted Fuels", "defra-data" ),
			"all_items" => __( "All Permitted Fuels", "defra-data" ),
			"edit_item" => __( "Edit Permitted Fuel", "defra-data" ),
			"view_item" => __( "View Permitted Fuel", "defra-data" ),
			"update_item" => __( "Update Permitted Fuel name", "defra-data" ),
			"add_new_item" => __( "Add new Permitted Fuel", "defra-data" ),
			"new_item_name" => __( "New Permitted Fuel name", "defra-data" ),
			"parent_item" => __( "Parent Permitted Fuel", "defra-data" ),
			"parent_item_colon" => __( "Parent Permitted Fuel:", "defra-data" ),
			"search_items" => __( "Search Permitted Fuels", "defra-data" ),
			"popular_items" => __( "Popular Permitted Fuels", "defra-data" ),
			"separate_items_with_commas" => __( "Separate Permitted Fuels with commas", "defra-data" ),
			"add_or_remove_items" => __( "Add or remove Permitted Fuels", "defra-data" ),
			"choose_from_most_used" => __( "Choose from the most used Permitted Fuels", "defra-data" ),
			"not_found" => __( "No Permitted Fuels found", "defra-data" ),
			"no_terms" => __( "No Permitted Fuels", "defra-data" ),
			"items_list_navigation" => __( "Permitted Fuels list navigation", "defra-data" ),
			"items_list" => __( "Permitted Fuels list", "defra-data" ),
			"back_to_items" => __( "Back to Permitted Fuels", "defra-data" ),
		];
	
		
		$args = [
			"label" => __( "Permitted Fuels", "defra-data" ),
			"labels" => $labels,
			"public" => true,
			"publicly_queryable" => true,
			"hierarchical" => false,
			"show_ui" => true,
			"show_in_menu" => true,
			"show_in_nav_menus" => true,
			"query_var" => true,
			"rewrite" => [ 'slug' => 'permitted_fuels', 'with_front' => true, ],
			"show_admin_column" => false,
			"show_in_rest" => true,
			"show_tagcloud" => false,
			"rest_base" => "permitted_fuels",
			"rest_controller_class" => "WP_REST_Terms_Controller",
			"show_in_quick_edit" => false,
			"show_in_graphql" => false,
		];
		register_taxonomy( "permitted_fuels", [ "appliances" ], $args );
	
		/**
		 * Taxonomy: Types.
		 */
	
		$labels = [
			"name" => __( "Types", "defra-data" ),
			"singular_name" => __( "Type", "defra-data" ),
			"menu_name" => __( "Types", "defra-data" ),
			"all_items" => __( "All Types", "defra-data" ),
			"edit_item" => __( "Edit Type", "defra-data" ),
			"view_item" => __( "View Type", "defra-data" ),
			"update_item" => __( "Update Type name", "defra-data" ),
			"add_new_item" => __( "Add new Type", "defra-data" ),
			"new_item_name" => __( "New Type name", "defra-data" ),
			"parent_item" => __( "Parent Type", "defra-data" ),
			"parent_item_colon" => __( "Parent Type:", "defra-data" ),
			"search_items" => __( "Search Types", "defra-data" ),
			"popular_items" => __( "Popular Types", "defra-data" ),
			"separate_items_with_commas" => __( "Separate Types with commas", "defra-data" ),
			"add_or_remove_items" => __( "Add or remove Types", "defra-data" ),
			"choose_from_most_used" => __( "Choose from the most used Types", "defra-data" ),
			"not_found" => __( "No Types found", "defra-data" ),
			"no_terms" => __( "No Types", "defra-data" ),
			"items_list_navigation" => __( "Types list navigation", "defra-data" ),
			"items_list" => __( "Types list", "defra-data" ),
			"back_to_items" => __( "Back to Types", "defra-data" ),
		];
	
		
		$args = [
			"label" => __( "Types", "defra-data" ),
			"labels" => $labels,
			"public" => true,
			"publicly_queryable" => true,
			"hierarchical" => false,
			"show_ui" => true,
			"show_in_menu" => true,
			"show_in_nav_menus" => true,
			"query_var" => true,
			"rewrite" => [ 'slug' => 'si_types', 'with_front' => true, ],
			"show_admin_column" => false,
			"show_in_rest" => true,
			"show_tagcloud" => false,
			"rest_base" => "si_types",
			"rest_controller_class" => "WP_REST_Terms_Controller",
			"show_in_quick_edit" => false,
			"show_in_graphql" => false,
		];
		register_taxonomy( "si_types", [ "statutory_instrument" ], $args );

		/**
		 * Taxonomy: Statutory Instruments Countries.
		 */
	
		$labels = [
			"name" => __( "Countries", "defra-data" ),
			"singular_name" => __( "Country", "defra-data" ),
			"menu_name" => __( "Countries", "defra-data" ),
			"all_items" => __( "All Countries", "defra-data" ),
			"edit_item" => __( "Edit Country", "defra-data" ),
			"view_item" => __( "View Country", "defra-data" ),
			"update_item" => __( "Update Country name", "defra-data" ),
			"add_new_item" => __( "Add new Country", "defra-data" ),
			"new_item_name" => __( "New Country name", "defra-data" ),
			"parent_item" => __( "Parent Country", "defra-data" ),
			"parent_item_colon" => __( "Parent Country:", "defra-data" ),
			"search_items" => __( "Search Countries", "defra-data" ),
			"popular_items" => __( "Popular Countries", "defra-data" ),
			"separate_items_with_commas" => __( "Separate Countries with commas", "defra-data" ),
			"add_or_remove_items" => __( "Add or remove Countries", "defra-data" ),
			"choose_from_most_used" => __( "Choose from the most used Countries", "defra-data" ),
			"not_found" => __( "No Countries found", "defra-data" ),
			"no_terms" => __( "No Countries", "defra-data" ),
			"items_list_navigation" => __( "Countries list navigation", "defra-data" ),
			"items_list" => __( "Countries list", "defra-data" ),
			"back_to_items" => __( "Back to Countries", "defra-data" ),
		];
	
		
		$args = [
			"label" => __( "Countries", "defra-data" ),
			"labels" => $labels,
			"public" => true,
			"publicly_queryable" => true,
			"hierarchical" => false,
			"show_ui" => true,
			"show_in_menu" => true,
			"show_in_nav_menus" => true,
			"query_var" => true,
			"rewrite" => [ 'slug' => 'si_countries', 'with_front' => true, ],
			"show_admin_column" => false,
			"show_in_rest" => true,
			"show_tagcloud" => false,
			"rest_base" => "si_countries",
			"rest_controller_class" => "WP_REST_Terms_Controller",
			"show_in_quick_edit" => false,
			"show_in_graphql" => false,
		];
		register_taxonomy( "si_countries", [ "statutory_instrument" ], $args );
	}


	
	

	/**
	 * add all ajax events
	 *
	 * @return array $ajaxevents
	 */
	public function defra_public_ajax_events() {
		$ajaxevents = array(
			'update_fuel_type',
			'delete_fuel_type',
			'update_appliance_type',
			'delete_appliance_type',
			'update_additional_condition',
			'delete_additional_condition',
			'update_permitted_fuel',
			'delete_permitted_fuel',
		);

		return $ajaxevents;

	}

	/**
	 * Add classes to navigation menus
	 *
	 * @return void
	 */
	public function defra_nav_menu_link_attributes_callback($classes, $item, $args) {
		if (isset($args->add_a_class)) {
			$classes['class'] = $args->add_a_class;
		}
		return $classes;
	}

	/**
	 * Require all action hooks for markup
	 *
	 * @return void
	 */
	public function html_markup_components_callback() {
		require_once plugin_dir_path( __FILE__ ) . 'html-markup/markup-action-hooks.php';
	}


	/**
	 * A custom header function for calling our own header template from the plugin
	 *
	 * @param [type] $name
	 * @param array $args
	 * @return $located
	 */
	public function defra_get_header($name, $args = array()) {
		
		// return get_header();

		// $require_once = true;
		// $templates = array();
	
		// $name = (string) $name;
		// if ('' !== $name) {
		// 	$templates[] = "header-{$name}.php";
		// } else {
		// 	return false;
		// }
	
		// $templates[] = 'header.php';
	
		// $located = '';
		// foreach ($templates as $template_name) {
	
		// 	if (!$template_name) {
		// 		continue;
		// 	}
	
		// 	if (file_exists(plugin_dir_path( __FILE__ ) . 'partials/' . $template_name)) {
	
		// 		$located = plugin_dir_path( __FILE__ ) . 'partials/' . $template_name;
		// 		break;
		// 	} elseif (file_exists(STYLESHEETPATH . '/' . $template_name)) {
		// 		$located = STYLESHEETPATH . '/' . $template_name;
		// 		break;
		// 	} elseif (file_exists(TEMPLATEPATH . '/' . $template_name)) {
		// 		$located = TEMPLATEPATH . '/' . $template_name;
		// 		break;
		// 	} elseif (file_exists(ABSPATH . WPINC . '/theme-compat/' . $template_name)) {
		// 		$located = ABSPATH . WPINC . '/theme-compat/' . $template_name;
		// 		break;
		// 	}
		// }
	
		// if ('' !== $located) {
		// 	load_template($located, $require_once, $args);
		// }
	
		// return $located;
	}

	/**
	 * Register the additional menu for data entry
	 *
	 * @return void
	 */
	public function defra_register_menu_callback() {
		register_nav_menus(
			array(
				'data-entry' => esc_html__( 'Data Entry', 'defra-data' ),
				'data-reviewer' => esc_html__( 'Data Reviewer', 'defra-data' ),
				'data-approver' => esc_html__( 'Data Approver', 'defra-data' ),
			)
		);	
	}
		
	/**
	 * A function to return a page as included via this plugin.
	 *
	 * @since    1.1.0
	 * @param    string    $original_template    the path of the original template.
	 * @return   string    $original_template    the conditionally filtered path of the template.
	 */
	public function defra_page_includes( $original_template ) {

		global $wp_query;
		$config = config_setup();

		$data_entry_pages = $config['data_entry_pages'];

		foreach ($data_entry_pages as $k => $data_entry_page) {

			if ( is_page( 'data-entry' ) ) {
				if (is_user_logged_in()) {
					$original_template = plugin_dir_path( __FILE__ ) . 'partials/data-entry.php';
				} else {
					$original_template = plugin_dir_path( __FILE__ ) . 'partials/not-logged-in.php';
				}
			}


			if ( is_page( $data_entry_page['slug'] ) ) {
				if (is_user_logged_in() || $data_entry_page['slug'] == 'form-process') {
					$original_template = plugin_dir_path( __FILE__ ) . $data_entry_page['template'];
				} else {
					$original_template = plugin_dir_path( __FILE__ ) . 'partials/not-logged-in.php';
				}
			}
			// get sub pages of
			if(isset($data_entry_page['child']) && !empty($data_entry_page['child'])){
				foreach($data_entry_page['child'] as $i => $data_entry_sub_page) {
					if ( is_page( $data_entry_sub_page['slug'] ) ) {
						if (is_user_logged_in()) {
							$original_template = plugin_dir_path( __FILE__ ) . $data_entry_sub_page['template'];
						} else {
							$original_template = plugin_dir_path( __FILE__ ) . 'partials/not-logged-in.php';
						}
					}

				}

			}
		}

		// Check if the page is a 404 error
		// if(is_404()) {
		// 	if(isset($_GET['post_type'])) {
		// 		// Check if the value of $_GET['post_type'] is 'fuel' or 'appliance'
		// 		$type = $_GET['post_type'];
		// 		if($type == 'fuels' || $type == 'appliances') {
		// 			// Your code here if the conditions are met
		// 			$redirect_url = admin_url('/');

		// 			// Redirect to the new URL
		// 			wp_redirect($redirect_url);
		// 			exit;

		// 		}
		// 	}
		// }

		return $original_template;
	}

	/**
	 * Set approver exemption countries
	 * 
	 * @return array $approver_counties
	 */
	public function get_exemption_countries() {
		$approver_counties = array(
			'1' => 'england',
			'2' => 'wales',
			'3' => 'scotland',
			'4' => 'n_ireland'
		);
		return $approver_counties;
	}

	/**
	 * Generic function to process forms
	 * @TODO Check all methods are converted to WP db interactions
	 *
	 * @return void
	 */
	public function process_form_callback() {
		if(empty($_POST)) {
			return;
		}
		$user = wp_get_current_user();
		if($user) {
			$_POST['user_id'] = $user->ID;
		}

		// this is setup for curl test data
		$data = json_decode(file_get_contents('php://input'), true);
		if (json_last_error() === JSON_ERROR_NONE) {
			// Valid JSON received
			$_POST = $data;
		}
		if (is_array($_POST)) {
			if($_POST['process'] == 'create-appliance') {
				$this->process_create_appliance();
			}
			if($_POST['process'] == 'create-fuel') {
				$this->process_create_fuel();
			}
			if($_POST['process'] == 'create-statutory-instrument') {
				$this->process_create_statutory_instrument();
			}
			if($_POST['process'] == 'update-statutory-instrument') {
				$this->process_update_statutory_instrument();
			}
			if($_POST['process'] == 'create-permitted-fuel') {
				$this->process_create_permitted_fuel();
			}
			if($_POST['process'] == 'create-additional-condition') {
				$this->process_create_additional_condition();
			}
			if($_POST['process'] == 'create-appliance-type') {
				$this->process_create_appliance_type();
			}
			if($_POST['process'] == 'create-fuel-type') {
				$this->process_create_fuel_type();
			}
			if($_POST['process'] == 'create-manufacturer') {
				$this->process_create_manufacturer();
			}
			if($_POST['process'] == 'status-change') {
				$this->process_status_change();
			}

			if($_POST['process'] == 'download-recommendation-letter') {
				$this->download_recommendation_letter($_POST);
			}
			if($_POST['process'] == 'pdf-fuel-download') {
				$this->pdf_fuel_download($_POST);
			}
			if($_POST['process'] == 'csv-fuel-download') {
				$this->csv_fuel_download($_POST);
			}
			if($_POST['process'] == 'pdf-appliance-download') {
				$this->pdf_appliance_download($_POST);
			}
			if($_POST['process'] == 'csv-appliance-download') {
				$this->csv_appliance_download($_POST);
			}
		}
	}

	/**
	 * Create a new appliance WP
	 *
	 * @return void
	 */
	public function process_create_appliance() {

		if ( ! isset( $_POST['create_nonce_field'] ) || ! wp_verify_nonce( $_POST['create_nonce_field'], 'create_nonce' ) ) {
			wp_die('Sorry, security did not verify.');
		} else {
			// process form data
			$current_user = wp_get_current_user();
			$db = new Defra_Data_DB_Requests();
			$audit = new Defra_Data_Audit_Log();
			$post_id = $db->insert_new_appliance($_POST);
			$comments = $this->create_comment_logic($post_id, $_POST);
			
			$audit->set_appliance_audit_data($current_user->ID, $post_id, $_POST);
			// check and send to reviewer
			if($_POST['submit-type'] == 'submit-review') {
				$this->notify_data_review( $post_id, 'appliance' );
			}

			// redirect with success
			$url = home_url().'/data-entry/appliances/create-new-appliance/?post=success&id='.$post_id;
			wp_redirect( $url );
			exit;

		}
	}
	
	/**
	 * Create a new fuel WP
	 *
	 * @return void
	 */
	public function process_create_fuel() {

		if ( ! isset( $_POST['create_nonce_field'] ) || ! wp_verify_nonce( $_POST['create_nonce_field'], 'create_nonce' ) ) {
			wp_die('Sorry, security did not verify.');
		} else {
			// process form data
			$current_user = wp_get_current_user();
			$db = new Defra_Data_DB_Requests();
			$audit = new Defra_Data_Audit_Log();
			$post_id = $db->insert_new_fuel($_POST);
			$comments = $this->create_comment_logic($post_id, $_POST);

			$audit->set_appliance_audit_data($current_user->ID, $post_id, $_POST);
			// check and send to reviewer
			if($_POST['submit-type'] == 'submit-review') {
				$this->notify_data_review( $post_id, 'fuel' );
			}

			// redirect with success
			$url = home_url().'/data-entry/fuels/create-new-fuel/?post=success&id='.$post_id;
			wp_redirect( $url );
			exit;

		}
	}

	/**
	 * To resolve comment meta type
	 *
	 * @param [type] $postdata
	 * @return void
	 */
	public function resolve_comment_type_id($postdata) {
		if($postdata["submit-type"] == "submit-review") {
			$comment_type_id = '1';
		}

		// @TODO
		// create conditional logic for Reviewer, Approver & Devolved Admin

		return $comment_type_id;
	}

	/**
	 * To resolve comment meta action
	 *
	 * @param [type] $postdata
	 * @return void
	 */
	public function resolve_comment_action_id($postdata) {
		if($postdata["submit-type"] == "submit-review") {
			$comment_action_id = '1';
		}

		// @TODO
		// create conditional logic for Approved, Rejected & Cancelled

		return $comment_action_id;
	}

	public function create_comment( $post_id, $postdata, $current_user, $appended, $comment ) {
		// Create a new comment object

		$commentdata = array(
			'comment_post_ID' => $post_id,
			'comment_author' => $current_user->user_login,
			'comment_author_email' => $current_user->user_email,
			'comment_content' => $appended . $comment,
			'comment_approved' => 1, // 0 for unapproved, 1 for approved
		);


		// Insert the comment into the database
		$comment_id = wp_insert_comment($commentdata);
		if ($comment_id) {

			$comment_type_id = $this->resolve_comment_type_id($postdata);
			$comment_action_id = $this->resolve_comment_action_id($postdata);
			// Add comment meta
			update_comment_meta($comment_id, 'comment_type_id', $comment_type_id);
			update_comment_meta($comment_id, 'comment_action_id', $comment_action_id);

		}
	}

	/**
	 * Create a new comment
	 *
	 * @param [type] $post_id
	 * @param [type] $postdata
	 * @return void
	 */
	public function create_comment_logic($post_id, $postdata) {
		$current_user = wp_get_current_user();
		if(isset($postdata["comment_to_da"]) && '' != $postdata["comment_to_da"]) {
			$this->create_comment( $post_id, $postdata, $current_user, 'Comment to DA: ', $postdata["comment_to_da"] );
		}
		if(isset($postdata["user_comment"]) && '' != $postdata["user_comment"]) {
			$this->create_comment( $post_id, $postdata, $current_user, 'User comment: ', $postdata["user_comment"] );
		}
	}

	/**
	 * Resolve type data for human readable output
	 *
	 * @param string $type
	 * @return array $type_array
	 */
	public function resolve_type_data( $type ) {
		$type_array = array(
			'name' => $type == 'appliance' ? 'Appliance' : 'Fuel',
			'slug' => $type == 'appliance' ? 'appliances' : 'fuels',
			'meta_key' => $type == 'appliance' ? 'appliance_id' : 'fuel_id',
		);
		return $type_array;
	}

	/**
	 * notify data review of appliance
	 *
	 * @param int $post_id
	 * @param string $type
	 * @return void
	 */
	public function notify_data_review( $post_id, $type ) {

		$admin = new Defra_Data_Entry_Admin('Admin','1,0');
		$type_array = $this->resolve_type_data($type);

		$data_reviewers = $admin->get_data_reviewers_email_addresses();
		$subject = $type_array['name'] . ' submitted for review';
		$content = $type_array['name'] . ' ID: ' . get_post_meta($post_id, $type_array['meta_key'], true) . '<br>';
		$content .= 'To review submitted ' . $type_array['name'] . ' <a href="'.home_url().'/?post_type=' . $type_array['slug'] . '&p='.$post_id.'"><strong>click here</strong></a>';
		$headers = array('Content-Type: text/html; charset=UTF-8');
		wp_mail($data_reviewers, $subject, $content, $headers);

	}

	/**
	 * notify data approver of appliance
	 *
	 * @param [type] $post_id
	 * @return void
	 */
	public function notify_appliance_data_approve($post_id) {

		$post = get_post($post_id);
		$type_label = $post->post_type == 'appliances' ? 'Appliance' : 'Fuel';
		$type_slug = $post->post_type == 'appliances' ? 'appliances' : 'fuels';
		$type_meta = $post->post_type == 'appliances' ? 'appliance' : 'fuel';

		$admin = new Defra_Data_Entry_Admin('Admin','1,0');

		$data_approvers = $admin->get_data_approver_email_addresses();
		$subject = $type_label . ' submitted for approval';
		$content = $type_label . ' ID: ' . get_post_meta($post_id, $type_meta . '_id', true) . '<br>';
		$content .= 'To approve submitted '.$type_label.' <a href="'.home_url().'/?post_type='.$type_slug.'&p='.$post_id.'"><strong>click here</strong></a>';
		$headers = array('Content-Type: text/html; charset=UTF-8');
		wp_mail($data_approvers, $subject, $content, $headers);

	}

	/**
	 * notify approved by DA of appliance
	 *
	 * @param [type] $post_id
	 * @return void
	 */
	public function notify_data_approved_by_da($post_id) {
		

		$admin = new Defra_Data_Entry_Admin('Admin','1,0');

		$administrators = $admin->get_administrator_email_addresses();
		$subject = 'Appliance Approved by DA';
		$content = 'Appliance ID: ' . get_post_meta($post_id, 'appliance_id', true) . '<br>';
		$content .= 'To review Appliance Approved <a href="'.home_url().'/?post_type=appliances&p='.$post_id.'"><strong>click here</strong></a>';
		$headers = array('Content-Type: text/html; charset=UTF-8');
		wp_mail($administrators, $subject, $content, $headers);

	}

	/**
	 * notify appliance rejected by DA
	 *
	 * @param [type] $post_id
	 * @return void
	 */
	public function notify_data_rejected_by_da($post_id) {
		$admin = new Defra_Data_Entry_Admin('Admin','1,0');
		$post = get_post($post_id);
		$type_label = $post->post_type == 'appliances' ? 'Appliance' : 'Fuel';
		$type_slug = $post->post_type == 'appliances' ? 'appliances' : 'fuels';
		$type_meta = $post->post_type == 'appliances' ? 'appliance' : 'fuel';



		$administrators = $admin->get_administrator_email_addresses();
		$subject = $type_label . ' Rejected by DA';
		$content = $type_label . ' ID: ' . get_post_meta($post_id, $type_meta . '_id', true) . '<br>';
		$content .= $type_label . ' Rejected by DA <a href="'.home_url().'/?post_type='. $type_slug . '&p='.$post_id.'"><strong>click here</strong></a>';
		$headers = array('Content-Type: text/html; charset=UTF-8');
		wp_mail($administrators, $subject, $content, $headers);

	}


	/**
	 * if testing then check constant so emails are not triggered to all users
	 *
	 * @param [type] $args
	 * @return void
	 */
	public function defra_check_mail_env($args) {
		if(defined('LOCAL_DEV') && LOCAL_DEV) {
			$args['to'] = array(
				get_bloginfo('admin_email'),
				'smokecontroltesting1@hetas.co.uk',
				'smokecontroltesting2@hetas.co.uk',
				'smokecontroltesting3@hetas.co.uk'
			);
		}
		return $args;
	}

	/**
	 * Create a new statutory instrument
	 *
	 * @return void
	 */
	public function process_create_statutory_instrument() {


		if ( ! isset( $_POST['create_nonce_field'] ) || ! wp_verify_nonce( $_POST['create_nonce_field'], 'create_nonce' ) ) {
			wp_die('Sorry, security did not verify.');
		} else {
			// process form data
			$db = new Defra_Data_DB_Requests();
			$post_id = $db->insert_new_statutory_instrument($_POST);
			// redirect with success
			$url = home_url().'/data-entry/si/create-new-si/?post=success&id='.$post_id;
			wp_redirect( $url );
			exit;
			
		}
	}
	
	/**
	 * Update a statutory instrument
	 *
	 * @return void
	 */
	public function process_update_statutory_instrument() {
		if ( ! isset( $_POST['update_si_appliance_field'] ) || ! wp_verify_nonce( $_POST['update_si_appliance_field'], 'update_si_appliance' ) ) {
			wp_die('Sorry, security did not verify.');
		} else {
			// Create an array with the post data
			$post_data = array(
				'ID'           => $_POST["deid"],             // The ID of the post to update
				'post_title'   => $_POST["denumber"], // New post title
				'post_content' => $_POST["delink"], // New post content
				'post_author'  => $_POST["user_id"],                    // Post author ID
			);
			
			// Update the post using wp_update_post()
			$updated_post_id = wp_update_post( $post_data );
			
			if ( is_wp_error( $updated_post_id ) ) {
				// Handle errors
				error_log( 'Error updating post: ' . $updated_post_id->get_error_message() );
			} else {
				error_log( 'Post updated successfully with ID: ' . $updated_post_id );

				// Now update the taxonomy terms
				$taxonomy = 'si_countries'; // Replace with your taxonomy (e.g., 'category', 'post_tag', 'genre')

				if(isset($_POST["countries"])) {
					$term_ids = array_map( 'intval', $_POST["countries"] ); // Array of term IDs to associate with the post
					// Set the taxonomy terms for the post
					wp_set_post_terms( $post_data["ID"], $term_ids, $taxonomy );
				}
			}
		}
		
		$url = home_url().'/data-entry/si/si-'.$_POST["rd"].'/?post=success&id='.$post_data["ID"];
		wp_redirect( $url );
		exit;

	}

	/**
	 * Create a new permitted fuel
	 *
	 * @return void
	 */
	public function process_create_permitted_fuel() {
		if ( ! isset( $_POST['create_nonce_field'] ) || ! wp_verify_nonce( $_POST['create_nonce_field'], 'create_nonce' ) ) {
			wp_die('Sorry, security did not verify.');
		} else {
			// process form data
			$db = new Defra_Data_DB_Requests();
			$term = $db->insert_new_permitted_fuel($_POST);
			if(!is_wp_error($term)) {
				$term_id = $term->term_id;
			} else {
				wp_die('Error adding the term: ' . $term->get_error_message());
			}
			// redirect with success
			$url = home_url().'/data-entry/permitted-fuels/create-new-permitted-fuel/?post=success&id='.$term_id;
			wp_redirect( $url );
			exit;

		}
	}

	/**
	 * Create a new appliance type
	 *
	 * @return void
	 */
	public function process_create_additional_condition() {
		if ( ! isset( $_POST['create_nonce_field'] ) || ! wp_verify_nonce( $_POST['create_nonce_field'], 'create_nonce' ) ) {
			wp_die('Sorry, security did not verify.');
		} else {
			// process form data
			$db = new Defra_Data_DB_Requests();
			$db->insert_new_additional_condition($_POST);
			// redirect with success
			$url = home_url().'/data-entry/additionalconditions/create-new-additional-condition/?post=success';
			wp_redirect( $url );
			exit;

		}
	}

	/**
	 * Create a new appliance type
	 *
	 * @return void
	 */
	public function process_create_appliance_type() {
		if ( ! isset( $_POST['create_nonce_field'] ) || ! wp_verify_nonce( $_POST['create_nonce_field'], 'create_nonce' ) ) {
			wp_die('Sorry, security did not verify.');
		} else {
			// process form data
			$db = new Defra_Data_DB_Requests();
			$db->insert_new_appliance_type($_POST);
			// redirect with success
			$url = home_url().'/data-entry/appliance-types/create-new-appliance-type/?post=success';
			wp_redirect( $url );
			exit;

		}
	}

	/**
	 * Create a new fuel type
	 *
	 * @return void
	 */
	public function process_create_fuel_type() {
		if ( ! isset( $_POST['create_nonce_field'] ) || ! wp_verify_nonce( $_POST['create_nonce_field'], 'create_nonce' ) ) {
			wp_die('Sorry, security did not verify.');
		} else {
			// Check if the term exists, if not, create it
			if (!term_exists($_POST['fuel-type'], 'fuel_types')) {
				// Arguments for creating the term
				$args = array(
					'description' => 'User created fuel type',
					'slug' => sanitize_title( $_POST['fuel-type'] )
				);

				// Insert the term into the database
				$term_inserted = wp_insert_term($_POST['fuel-type'], 'fuel_types', $args);
				
				if (is_wp_error($term_inserted)) {
					// Handle error, for example, log it or display a message
					wp_die('Error inserting term: ' . $term_inserted->get_error_message());
				}

			} else {
				wp_die('This term already exists.');
			}

			// redirect with success
			$url = home_url().'/data-entry/fuel-types/create-new-fuel-type/?post=success';
			wp_redirect( $url );
			exit;

		}

	}

	/**
	 * Create a new manufacturer
	 *
	 * @return void
	 */
	public function process_create_manufacturer() {

		if ( ! isset( $_POST['create_manufacturer_field'] ) || ! wp_verify_nonce( $_POST['create_manufacturer_field'], 'create_manufacturer' ) ) {
			wp_die('Sorry, security did not verify.');
		} else {
			// process form data
			$db = new Defra_Data_DB_Requests();
			$post_id = $db->insert_new_manufacturer($_POST);
			// redirect with success
			$url = home_url().'/data-entry/manufacturers/create-new-manufacturer/?post=success&id='.$post_id;
			wp_redirect( $url );
			exit;
		}

	}

	/**
	 * Setters for country metas
	 *
	 * @return array
	 */
	public function country_meta_slugs($key = null) {
		$country_meta_slugs = array(
			'1' => 'england',
			'2' => 'wales',
			'3' => 'scotland',
			'4' => 'n_ireland',
		);
		if($key) {
			return $country_meta_slugs[$key];
		}
		return $country_meta_slugs;
	}

	/**
	 * Process status change
	 * 
	 * note on comments:
	 * comment_type_id
	 * 1	Data Entry User
	 * 2	Reviewer
	 * 3	Approver
	 * 4	Devolved Admin
	 * 
	 * comment_action_id
	 * 1	Data Entry
	 * 2	Approved
	 * 3	Rejected
	 * 4	Cancelled
	 * 
	 * Status change should be applied to the following where ** is equal to _england_, _scotland_, _wales_ or _n_ireland_
	 * 
	 * // the following are added by default during data entry
	 * exempt-in_country_and_statutory_instrument_**_enabled
	 * exempt-in_country_and_statutory_instrument_**_si
	 * exempt-in_country_and_statutory_instrument_**_si_0_si_id
	 * 
	 * // the following is updaded by staged status exchange between data entry, data reviewer and data approver
	 * exempt-in_country_and_statutory_instrument_**_status
	 * 
	 * // the following is updated once the application has been submitted to defra
	 * exempt-in_country_and_statutory_instrument_**_user
	 * exempt-in_country_and_statutory_instrument_**_assigned_date
	 * exempt-in_country_and_statutory_instrument_**_approve_date
	 * exempt-in_country_and_statutory_instrument_**_reject_date
	 * exempt-in_country_and_statutory_instrument_**_publish_date
	 * exempt-in_country_and_statutory_instrument_**_revoke_assigned_date
	 * exempt-in_country_and_statutory_instrument_**_revoke_approve_date
	 * exempt-in_country_and_statutory_instrument_**_revoke_reject_date
	 * exempt-in_country_and_statutory_instrument_**_is_published
	 *
	 * @return void
	 */
	public function process_status_change() {
		if ( ! isset( $_POST['submit_nonce'] ) || ! wp_verify_nonce( $_POST['submit_nonce'], 'submit_form' ) ) {
			wp_die('Sorry, security did not verify.');
		} else {
			$audit = new Defra_Data_Audit_Log();
			$datetime = new DateTime('now', new DateTimeZone('Europe/London'));
			$user = get_user_by( 'id', $_POST["user_id"] );
			$country = get_user_meta( $user->ID, 'approver_country_id', true );
			$post = get_post($_POST["post_id"]);
			$countries = array(
				'1' => $post->post_type == 'appliances' ? 'exempt-in_country_and_statutory_instrument_england_status' : 'authorised_country_and_statutory_instrument_england_status',
				'2' => $post->post_type == 'appliances' ? 'exempt-in_country_and_statutory_instrument_wales_status' : 'authorised_country_and_statutory_instrument_wales_status',
				'3' => $post->post_type == 'appliances' ? 'exempt-in_country_and_statutory_instrument_scotland_status' : 'authorised_country_and_statutory_instrument_scotland_status',
				'4' => $post->post_type == 'appliances' ? 'exempt-in_country_and_statutory_instrument_n_ireland_status' : 'authorised_country_and_statutory_instrument_n_ireland_status'
			);
			$status_country = array(
				'1' => 'England',
				'2' => 'Wales',
				'3' => 'Scotland',
				'4' => 'N. Ireland'
			);

			$country_meta_slugs = $this->country_meta_slugs();

			// process data
			if($_POST["status"] == 'reject') {
				update_post_meta( $_POST["post_id"], 'reviewer_user_id', $_POST["user_id"] );
				update_post_meta( $_POST["post_id"], 'reviewer_reject_date', $datetime->format('Y-m-d H:i:s') );
				// update postmeta
				get_post_meta( $_POST["post_id"], $post->post_type == 'appliances' ? 'exempt-in_country_and_statutory_instrument_england_status' : 'authorised_country_and_statutory_instrument_england_status', true ) ? update_post_meta( $_POST["post_id"], $post->post_type == 'appliances' ? 'exempt-in_country_and_statutory_instrument_england_status' : 'authorised_country_and_statutory_instrument_england_status', '10' ) : null;
				get_post_meta( $_POST["post_id"], $post->post_type == 'appliances' ? 'exempt-in_country_and_statutory_instrument_wales_status' : 'authorised_country_and_statutory_instrument_wales_status', true ) ? update_post_meta( $_POST["post_id"], $post->post_type == 'appliances' ? 'exempt-in_country_and_statutory_instrument_wales_status' : 'authorised_country_and_statutory_instrument_wales_status', '10' ) : null;
				get_post_meta( $_POST["post_id"], $post->post_type == 'appliances' ? 'exempt-in_country_and_statutory_instrument_scotland_status' : 'authorised_country_and_statutory_instrument_scotland_status', true ) ? update_post_meta( $_POST["post_id"], $post->post_type == 'appliances' ? 'exempt-in_country_and_statutory_instrument_scotland_status' : 'authorised_country_and_statutory_instrument_scotland_status', '10' ) : null;
				get_post_meta( $_POST["post_id"], $post->post_type == 'appliances' ? 'exempt-in_country_and_statutory_instrument_n_ireland_status' : 'authorised_country_and_statutory_instrument_n_ireland_status', true ) ? update_post_meta( $_POST["post_id"], $post->post_type == 'appliances' ? 'exempt-in_country_and_statutory_instrument_n_ireland_status' : 'authorised_country_and_statutory_instrument_n_ireland_status', '10' ) : null;
				
				if(!empty($_POST["user_comments"])) {
					// add comments
					$comment_data = array(
						'comment_post_ID' => $_POST["post_id"], 
						'comment_content' => $_POST["user_comments"],
						'comment_author' => $user->data->user_email,
						'comment_author_email' => $user->data->user_email,
						'comment_date' => $datetime->format('Y-m-d H:i:s'),
						'user_id' => $_POST["user_id"],
						'comment_approved' => 1, 
					);
					  
					$comment_id = wp_insert_comment($comment_data);
					// update comment meta
					update_comment_meta($comment_id, 'comment_type_id', '2');
					update_comment_meta($comment_id, 'comment_action_id', '3');
				}
				// create audit
				$audit->defra_audit_log($_POST["user_id"], 'appliance_country', $_POST["post_id"], 'Changed appliance to status_id: (10) Rejected by data review so back into draft for data entry', $_SERVER["REMOTE_ADDR"]);

			}
			if($_POST["status"] == 'approve') {

				get_post_meta( $_POST["post_id"], $post->post_type == 'appliances' ? 'exempt-in_country_and_statutory_instrument_england_status' : 'authorised_country_and_statutory_instrument_england_status', true ) ? update_post_meta( $_POST["post_id"], $post->post_type == 'appliances' ? 'exempt-in_country_and_statutory_instrument_england_status' : 'authorised_country_and_statutory_instrument_england_status', '50' ) : null;
				get_post_meta( $_POST["post_id"], $post->post_type == 'appliances' ? 'exempt-in_country_and_statutory_instrument_wales_status' : 'authorised_country_and_statutory_instrument_wales_status', true ) ? update_post_meta( $_POST["post_id"], $post->post_type == 'appliances' ? 'exempt-in_country_and_statutory_instrument_wales_status' : 'authorised_country_and_statutory_instrument_wales_status', '50' ) : null;
				get_post_meta( $_POST["post_id"], $post->post_type == 'appliances' ? 'exempt-in_country_and_statutory_instrument_scotland_status' : 'authorised_country_and_statutory_instrument_scotland_status', true ) ? update_post_meta( $_POST["post_id"], $post->post_type == 'appliances' ? 'exempt-in_country_and_statutory_instrument_scotland_status' : 'authorised_country_and_statutory_instrument_scotland_status', '50' ) : null;
				get_post_meta( $_POST["post_id"], $post->post_type == 'appliances' ? 'exempt-in_country_and_statutory_instrument_n_ireland_status' : 'authorised_country_and_statutory_instrument_n_ireland_status', true ) ? update_post_meta( $_POST["post_id"], $post->post_type == 'appliances' ? 'exempt-in_country_and_statutory_instrument_n_ireland_status' : 'authorised_country_and_statutory_instrument_n_ireland_status', '50' ) : null;

				if(!empty($_POST["comments_to_defra_da"])) {
					// add comments
					$comment_to_defra_data = array(
						'comment_post_ID' => $_POST["post_id"], 
						'comment_content' => $_POST["comments_to_defra_da"],
						'comment_author' => $user->data->user_email,
						'comment_author_email' => $user->data->user_email,
						'comment_date' => $datetime->format('Y-m-d H:i:s'),
						'user_id' => $_POST["user_id"],
						'comment_approved' => 1, 
					);
					$comment_id = wp_insert_comment($comment_to_defra_data);
					update_comment_meta($comment_id, 'comment_type_id', '2');
					update_comment_meta($comment_id, 'comment_action_id', '2');
				}

				if(!empty($_POST["user_comments"])) {
					// add comments
					$user_comment_data = array(
						'comment_post_ID' => $_POST["post_id"], 
						'comment_content' => $_POST["user_comments"],
						'comment_author' => $user->data->user_email,
						'comment_author_email' => $user->data->user_email,
						'comment_date' => $datetime->format('Y-m-d H:i:s'),
						'user_id' => $_POST["user_id"],
						'comment_approved' => 1, 
					);
					  
					$comment_id = wp_insert_comment($user_comment_data);
					// update comment meta
					update_comment_meta($comment_id, 'comment_type_id', '2');
					update_comment_meta($comment_id, 'comment_action_id', '2');
				}

				// create audit
				$audit->defra_audit_log($_POST["user_id"], $post->post_type == 'appliances' ? 'appliance' : 'fuel' . '_country', $_POST["post_id"], 'Changed appliance to status_id: (50) Submitted', $_SERVER["REMOTE_ADDR"]);
				$this->notify_appliance_data_approve($_POST["post_id"]);

			}
			if($_POST["status"] == 'approved-by-da') {

				get_post_meta( $_POST["post_id"], $countries[$country], true ) ? update_post_meta( $_POST["post_id"], $countries[$country], '600' ) : null;
				update_post_meta( $_POST["post_id"], $post->post_type == 'appliances' ? 'exempt-in_country_and_statutory_instrument_'.$country_meta_slugs[$country].'_publish_date' : 'authorised_country_and_statutory_instrument_'.$country_meta_slugs[$country].'_publish_date', $this->set_next_logical_publish_date() );
				$this->defra_update_post_status($_POST["post_id"], 'publish');

				if(!empty($_POST["user_comments"])) {
					// add comments
					$user_comment_data = array(
						'comment_post_ID' => $_POST["post_id"], 
						'comment_content' => $_POST["user_comments"],
						'comment_author' => $user->data->user_email,
						'comment_author_email' => $user->data->user_email,
						'comment_date' => $datetime->format('Y-m-d H:i:s'),
						'user_id' => $_POST["user_id"],
						'comment_approved' => 1, 
					);
					  
					$comment_id = wp_insert_comment($user_comment_data);
					// update comment meta
					update_comment_meta($comment_id, 'comment_type_id', '3');
					update_comment_meta($comment_id, 'comment_action_id', '2');
				}

				// create audit
				$audit->defra_audit_log($_POST["user_id"], $post->post_type == 'appliances' ? 'appliance' : 'fuel' . '_country', $_POST["post_id"], 'Approve '.$post->post_type == 'appliances' ? 'appliance' : 'fuel' . ' for '.$status_country[$country].' and set status_id: (70) Approved', $_SERVER["REMOTE_ADDR"]);
				$this->notify_data_approved_by_da($_POST["post_id"]);

			}
			if($_POST["status"] == 'rejected-by-da') {

				get_post_meta( $_POST["post_id"], $countries[$country], true ) ? update_post_meta( $_POST["post_id"], $countries[$country], '80' ) : null;
				update_post_meta( $_POST["post_id"], $post->post_type == 'appliances' ? 'exempt-in' : 'authorised' . '_country_and_statutory_instrument_'.$country_meta_slugs[$country].'_reject_date', $datetime->format('Y-m-d H:i:s') );


				if(!empty($_POST["user_comments"])) {
					// add comments
					$user_comment_data = array(
						'comment_post_ID' => $_POST["post_id"], 
						'comment_content' => $_POST["user_comments"],
						'comment_author' => $user->data->user_email,
						'comment_author_email' => $user->data->user_email,
						'comment_date' => $datetime->format('Y-m-d H:i:s'),
						'user_id' => $_POST["user_id"],
						'comment_approved' => 1, 
					);
					  
					$comment_id = wp_insert_comment($user_comment_data);
					// update comment meta
					update_comment_meta($comment_id, 'comment_type_id', '3');
					update_comment_meta($comment_id, 'comment_action_id', '3');
				}

				// create audit
				$audit->defra_audit_log($_POST["user_id"], $post->post_type == 'appliances' ? 'appliance' : 'fuel' . '_country', $_POST["post_id"], $post->post_type == 'appliances' ? 'Appliance' : 'Fuel' . ' rejected for '.$countries[$country].' and set status_id: (80) Rejected', $_SERVER["REMOTE_ADDR"]);
				$this->notify_data_rejected_by_da($_POST["post_id"]);

			}
			if($_POST["status"] == 'cancel') {

				// generic update of all by country to submitted to data reviewer
				foreach ( $country_meta_slugs as $k => $slug ) {

					update_post_meta( $_POST["post_id"], $post->post_type == 'appliances' ? 'exempt-in_country_and_statutory_instrument_'.$slug.'_revoke_requested' : 'authorised_country_and_statutory_instrument_'.$slug.'_revoke_requested', '1' );
					update_post_meta( $_POST["post_id"], $post->post_type == 'appliances' ? 'exempt-in_country_and_statutory_instrument_'.$slug.'_revoke_status_id' : 'authorised_country_and_statutory_instrument_'.$slug.'_revoke_status_id', '200' );

				}


				if(!empty($_POST["user_comments"])) {
					// add comments
					$user_comment_data = array(
						'comment_post_ID' => $_POST["post_id"], 
						'comment_content' => $_POST["user_comments"],
						'comment_author' => $user->data->user_email,
						'comment_author_email' => $user->data->user_email,
						'comment_date' => $datetime->format('Y-m-d H:i:s'),
						'user_id' => $_POST["user_id"],
						'comment_approved' => 1, 
					);
					  
					$comment_id = wp_insert_comment($user_comment_data);
					// update comment meta
					update_comment_meta($comment_id, 'comment_type_id', '3');
					update_comment_meta($comment_id, 'comment_action_id', '3');
				}

				// create audit
				$audit->defra_audit_log($_POST["user_id"], 'appliance_country', $_POST["post_id"], 'Revoked for '.$countries[$country].' and set status_id: (20) Revoked', $_SERVER["REMOTE_ADDR"]);
				//$this->notify_data_rejected_by_da($_POST["post_id"]); // @TODO

			}
			if($_POST["status"] == 'approve-revocation') { // approved revoke by reviewer
				// generic update of all by country to submitted to data reviewer
				foreach ( $country_meta_slugs as $k => $slug ) {
					update_post_meta( $_POST["post_id"], $post->post_type == 'appliances' ? 'exempt-in_country_and_statutory_instrument_'.$slug.'_revoke_status_id' : 'authorised_country_and_statutory_instrument_'.$slug.'_revoke_status_id', '200' );

				}


				if(!empty($_POST["user_comments"])) {
					// add comments
					$user_comment_data = array(
						'comment_post_ID' => $_POST["post_id"], 
						'comment_content' => $_POST["user_comments"],
						'comment_author' => $user->data->user_email,
						'comment_author_email' => $user->data->user_email,
						'comment_date' => $datetime->format('Y-m-d H:i:s'),
						'user_id' => $_POST["user_id"],
						'comment_approved' => 1, 
					);
					  
					$comment_id = wp_insert_comment($user_comment_data);
					// update comment meta
					update_comment_meta($comment_id, 'comment_type_id', '3');
					update_comment_meta($comment_id, 'comment_action_id', '3');
				}

				// create audit
				$audit->defra_audit_log($_POST["user_id"], 'appliance_country', $_POST["post_id"], 'Revoked for '.$countries[$country].' and set status_id: (200) approved revoke by reviewer', $_SERVER["REMOTE_ADDR"]);
				//$this->notify_data_rejected_by_da($_POST["post_id"]); // @TODO

			}

			if($_POST["status"] == 'approved-revocation-by-da') { // approved revoke by data approver

				update_post_meta( $_POST["post_id"], $post->post_type == 'appliances' ? 'exempt-in_country_and_statutory_instrument_'.$country_meta_slugs[$country].'_revoke_status_id' : 'authorised_country_and_statutory_instrument_'.$country_meta_slugs[$country].'_revoke_status_id', '400' );
				
				if(!empty($_POST["user_comments"])) {
					// add comments
					$user_comment_data = array(
						'comment_post_ID' => $_POST["post_id"], 
						'comment_content' => $_POST["user_comments"],
						'comment_author' => $user->data->user_email,
						'comment_author_email' => $user->data->user_email,
						'comment_date' => $datetime->format('Y-m-d H:i:s'),
						'user_id' => $_POST["user_id"],
						'comment_approved' => 1, 
					);
					  
					$comment_id = wp_insert_comment($user_comment_data);
					// update comment meta
					update_comment_meta($comment_id, 'comment_type_id', '4');
					update_comment_meta($comment_id, 'comment_action_id', '4');
				}

				// check if all DA's have revoked, if so set main status to 400 so not published to the frontend
				$revoked_status = array();
				foreach ( $country_meta_slugs as $k => $slug ) {
					$revoked_status[$k] = get_post_meta( $_POST["post_id"], $post->post_type == 'appliances' ? 'exempt-in_country_and_statutory_instrument_'.$slug.'_revoke_status_id' : 'authorised_country_and_statutory_instrument_'.$slug.'_revoke_status_id', true );
				}
				if ( $this->defra_all_values_are( $revoked_status, '400' ) ) {
					foreach ( $country_meta_slugs as $k => $slug ) {
						update_post_meta( $_POST["post_id"], $post->post_type == 'appliances' ? 'exempt-in_country_and_statutory_instrument_'.$slug.'_status' : 'authorised_country_and_statutory_instrument_'.$slug.'_status', '400' );
					}
				}

				
				// create audit
				$audit->defra_audit_log($_POST["user_id"], 'appliance_country', $_POST["post_id"], 'Revoked for '.$countries[$country].' and set status_id: (300) approved revoke by approver', $_SERVER["REMOTE_ADDR"]);
				//$this->notify_data_rejected_by_da($_POST["post_id"]); // @TODO
				
			}


			$url = add_query_arg( 'refer', 'status-updated', home_url().'/data-entry/dashboard/' );
			wp_redirect( $url );
			exit;

		}

	}

	/**
	 * check if all values are the same
	 *
	 * @param [type] $array
	 * @param [type] $value
	 * @return void
	 */
	public function defra_all_values_are($array, $value) {
		// Filter the array, keeping only elements that are not equal to $value
		$filteredArray = array_filter($array, function($item) use ($value) {
			return $item !== $value;
		});
		
		// If the filtered array is empty, then all elements were equal to $value
		return empty($filteredArray);
	}

	/**
	 * Update post_status wrapper
	 *
	 * @param int $post_id
	 * @param string $new_status
	 * @return void
	 */
	public function defra_update_post_status($post_id, $new_status) {
		// Create an array with the post data
		$post_data = array(
			'ID'           => $post_id,
			'post_status'  => $new_status,
		);
	
		// Update the post
		$result = wp_update_post( $post_data );
	
		// Check for errors
		if (is_wp_error($result)) {
			$error_message = $result->get_error_message();
			error_log( "Error updating post status: $error_message" );
		} else {
			error_log( "Post status updated successfully!" );
		}
	}
	

	/**
	 * get specific table list for this page
	 *
	 * @param int $id
	 * @return void
	 */
	public function defra_table_list_callback($id) {
		$table_list = get_post_meta( $id, 'table_list_to_include', true );
		if($table_list) {
			require_once plugin_dir_path( __FILE__ ) . 'table-lists/'.$table_list.'.php';
		}
	}

	/**
	 * Helper function to sort by fuel id
	 *
	 * @param [type] $a
	 * @param [type] $b
	 * @return void
	 */
	public function sort_by_asc_fuel_id($a, $b) {
		return $a->fuel_id - $b->fuel_id;
	}

	/**
	 * Helper function to sort by appliance title
	 *
	 * @param [type] $a
	 * @param [type] $b
	 * @return void
	 */

	public function sort_by_asc_appliance_name($a, $b) {
		return $a->post_title - $b->post_title;
	}

	/**
	 * Get table list from the args
	 *
	 * @param [type] $arguments
	 * @return void
	 */
	public function get_table_list($arguments) {

		if(is_array($arguments['post_meta_key'])) {
			$args_array = array();
			foreach ($arguments['post_meta_key'] as $k => $v) {
				$args_array[$k]['key'] = $v;
				$args_array[$k]['value'] = '600';
				$args_array[$k]['compare'] = 'LIKE';
			}
		}
		
		$args = array(
			'post_type' => $arguments['post_type'],
			'post_status' => 'publish',
			'posts_per_page' => -1,
			!is_array($arguments['post_meta_key']) ? 'meta_key' : 'meta_query' => !is_array($arguments['post_meta_key']) ? $arguments['post_meta_key'] : $args_array,
			'order' => 'ASC',
			'orderby' => 'title'
		);
		if(is_array($arguments['post_meta_key'])) {
			$args['meta_query']['relation'] = 'OR';
		} else {
			$args['meta_value'] = '600';
		}

		
		$posts = get_posts($args);
		foreach($posts as $k => $post) {
			$fuel_id = get_post_meta($post->ID, $arguments['fuel_meta_key'], true);
			$manufacturer_meta_key = get_post_meta($post->ID, $arguments['manufacturer_meta_key'], true);
			$manufacturer = get_post($manufacturer_meta_key);
		
			$posts[$k]->manufacturer_name = $manufacturer->post_title;
			$posts[$k]->fuel_id = $fuel_id;
		}
		
		if($arguments['post_type'] == 'fuels') {
			usort($posts, array($this, 'sort_by_asc_fuel_id'));
		}
		// if($arguments['post_type'] == 'appliances') {
		// 	usort($posts, array($this, 'sort_by_asc_appliance_name'));
		// }


		return $posts;
		
	}

	/**
	 * get custom post type template from within the plugin
	 *
	 * @param [type] $template
	 * @return void
	 */
	public function defra_single_template_callback( $template ) {

		global $post;
	
		if ( 'fuels' === $post->post_type && locate_template( array( 'single-fuels.php' ) ) !== $template ) {
			/*
			 * This is a 'fuels' post
			 * AND a 'single movie template' is not found on
			 * theme or child theme directories, so load it
			 * from our plugin directory.
			 */


			if (is_user_logged_in()) {
				$status = $this->viewing_updating($post);
				if($status != 'updating') {
					$template = plugin_dir_path( __FILE__ ) . 'partials/data-entry/fuel-view.php';
				} else {
					// if ownership and updating
					$template = plugin_dir_path( __FILE__ ) . 'partials/data-entry/update-fuel.php';
				}
			} else {
				$template = plugin_dir_path( __FILE__ ) . 'cpt-templates/single-fuels.php';
			}


			// $template = plugin_dir_path( __FILE__ ) . 'cpt-templates/single-fuels.php';
		}

		if ( 'appliances' === $post->post_type && locate_template( array( 'single-appliances.php' ) ) !== $template ) {
			/*
			 * This is a 'appliances' post
			 * AND a 'single movie template' is not found on
			 * theme or child theme directories, so load it
			 * from our plugin directory.
			 */

			if (is_user_logged_in()) {
				$status = $this->viewing_updating($post);
				if($status != 'updating') {
					// if viewing
					$template = plugin_dir_path( __FILE__ ) . 'partials/data-entry/appliance-view.php';
				} else {
					// if ownership and updating
					$template = plugin_dir_path( __FILE__ ) . 'partials/data-entry/update-appliance.php';
				}
			} else {
				$template = plugin_dir_path( __FILE__ ) . 'cpt-templates/single-appliances.php';
			}
			
			//$template = plugin_dir_path( __FILE__ ) . 'cpt-templates/single-appliances.php';

		}

		return $template;
	}

	/**
	 * Determine if current user is the data entry user
	 * and if not submitted for review
	 *
	 * @param object $post
	 * @return string $status
	 */
	public function viewing_updating($post) {
		$current_user = wp_get_current_user();
		$status = 'viewing';
		$metas = array_map( function( $a ){ return $a[0]; }, get_post_meta( $post->ID ) );
		$prefix = '_status';
		// Use array_filter to pluck elements with matching keys
		$filtered_array = array_filter(
			$metas,
			function ($key) use ($prefix) {
				return substr($key, -strlen($prefix)) === $prefix; // Check if the key starts with the specified prefix
			},
			ARRAY_FILTER_USE_KEY
		);
		$filtered_array = array_values(array_unique($filtered_array));
		if(in_array('10', $filtered_array) && get_post_meta( $post->ID, 'entry_user_id', true ) == $current_user->ID) {
			$status = 'updating';
		}
		return $status;
	}
	
	/**
	 * Set Appliance parameters for query
	 *
	 * @param object $query
	 * @return void
	 */
	public function get_appliance_posts($query) {
		if ( ! is_admin() && $query->is_main_query() ) {
			$query->set( 'posts_per_page', -1 );
		}
	}

	/**
	 * Set Fuel parameters for query
	 *
	 * @param object $query
	 * @return void
	 */
	public function get_fuel_posts($query) {
		if ( ! is_admin() && is_post_type_archive( 'fuels' ) && $query->is_main_query() ) {
			$query->set( 'posts_per_page', -1 );
		}

	}

	/**
	 * get username by id
	 *
	 * @param int $user_id
	 * @return string $user->user_login
	 */
	public function data_entry_username($user_id) {
		$user = get_userdata( $user_id );
		return $user->user_login;
	}

	/**
	 * Get Manufacturer Name
	 *
	 * @param [type] $post_id
	 * @return void
	 */
	public function get_manufacturer_title_by_id($post_id) {
		if(empty($post_id)) {
			return;
		}
		$manufacturer_id = get_post_meta($post_id, 'manufacturer_id', true);
		$post = get_post($manufacturer_id);
		return $post->post_title;
	}

	/**
	 * Get post title by post id
	 *
	 * @param [type] $post_id
	 * @return void
	 */
	public function get_post_title_by_id($post_id) {
		if(empty($post_id)) {
			return;
		}
		$post = get_post($post_id);
		return $post->post_title;
	}

	/**
	 * Get comment type
	 *
	 * @param string $key
	 * @return void
	 */
	public function get_comment_type_by_key($key) {
		$comment_type = array(
			'1' => 'Data Entry User',
			'2' => 'Reviewer',
			'3' => 'Approver',
			'4' => 'Devolved Admin'
		);
		return $comment_type[$key];
	}

	/**
	 * Get comment action
	 *
	 * @param string $key
	 * @return void
	 */
	public function get_comment_action_by_key($key) {
		$comment_action = array(
			'1' => 'Data Entry',
			'2' => 'Approved',
			'3' => 'Rejected',
			'4' => 'Cancelled'
		);
		return $comment_action[$key];
	}


	public function get_term_titles($post_id, $taxonomy) {
		$terms = wp_get_post_terms( $post_id, $taxonomy );
		$term_list = wp_list_pluck( $terms, 'name' );
		return join(',',$term_list);
	}

	/**
	 * Setup or set output units
	 *
	 * @param string $key
	 * @return void
	 */
	public function output_units($key = null) {
		$units = array(
			'1' => 'kW',
			'2' => 'MW',
			'3' => 'n/a'
		);
		if($key) {
			$units = $units[$key];
		}
		return $units;
	}

	public function get_appliance_output_unit($output_key) {
		return $this->output_units($output_key);
	}

	/**
	 * Get additional conditions from the database
	 *
	 * @param [type] $key
	 * @return void
	 */
	public function appliance_conditions($key = null) {
		$db_class = new Defra_Data_DB_Requests();
		$conditions = $db_class->get_additional_conditions();
		$conditions = wp_list_pluck( $conditions, 'condition_name' );
		if($key) {
			$conditions = $conditions[$key];
		}
		return $conditions;

	}

	public function si_status($key) {
		$status = array(
			'10' => 'Assigned to Data Entry',
			'20' => 'Submitted for Review',
			'30' => 'Assigned to Data Reviewer',
			'40' => 'Reviewer rejected',
			'50' => 'Submitted to Devolved Admin',
			'60' => 'Assigned to Devolved Admin',
			'70' => 'Approved by Devolved Admin',
			'80' => 'Rejected by Devolved Admin',
			'90' => 'Submitted for Cancellation',
			'100' => 'Approved for Cancellation',
			'200' => 'Submitted for Revocation',
			'300' => 'Approved for Revocation',
			'400' => 'Revoked',
			'500' => 'Approved for Publication',
			'600' => 'Published'
		);
		return $status[$key];
	}

	public function get_appliance_condition($key) {
		return $this->appliance_conditions($key);
	}

	/**
	 * Ajax events
	 */
	public function update_fuel_type() {
		$nonce = $_POST['nextNonce'];
		if ( ! wp_verify_nonce( $nonce, 'create_nonce' ) ) {
			wp_die('Sorry, security did not verify.');
		} else {
			// process form data
			$db = new Defra_Data_DB_Requests();
			$db->update_fuel_type($_POST);

		}
		
	
		// Don't forget to stop execution afterward.
		wp_die();
	}

	public function update_appliance_type() {
		$nonce = $_POST['nextNonce'];
		if ( ! wp_verify_nonce( $nonce, 'create_nonce' ) ) {
			wp_die('Sorry, security did not verify.');
		} else {
			// process form data
			$db = new Defra_Data_DB_Requests();
			$db->update_appliance_type($_POST);

		}
		
	
		// Don't forget to stop execution afterward.
		wp_die();
	}

	public function update_additional_condition() {
		$nonce = $_POST['nextNonce'];
		if ( ! wp_verify_nonce( $nonce, 'create_nonce' ) ) {
			wp_die('Sorry, security did not verify.');
		} else {
			// process form data
			$db = new Defra_Data_DB_Requests();
			$db->update_additional_condition($_POST);

		}
		
	
		// Don't forget to stop execution afterward.
		wp_die();
	}

	
	public function update_permitted_fuel() {
		$nonce = $_POST['nextNonce'];
		if ( ! wp_verify_nonce( $nonce, 'create_nonce' ) ) {
			wp_die('Sorry, security did not verify.');
		} else {
			// process form data
			$db = new Defra_Data_DB_Requests();
			$db->update_permitted_fuel($_POST);

		}
		
	
		// Don't forget to stop execution afterward.
		wp_die();
	}

	public function delete_fuel_type() {
		$nonce = $_POST['nextNonce'];
		if ( ! wp_verify_nonce( $nonce, 'create_nonce' ) ) {
			wp_die('Sorry, security did not verify.');
		} else {
			// process form data
			$db = new Defra_Data_DB_Requests();
			$db->delete_fuel_type($_POST);

		}
		
	
		// Don't forget to stop execution afterward.
		wp_die();

	}

	public function delete_appliance_type() {
		$nonce = $_POST['nextNonce'];
		if ( ! wp_verify_nonce( $nonce, 'create_nonce' ) ) {
			wp_die('Sorry, security did not verify.');
		} else {
			// process form data
			$db = new Defra_Data_DB_Requests();
			$db->delete_appliance_type($_POST);

		}
		
	
		// Don't forget to stop execution afterward.
		wp_die();

	}

	public function delete_additional_condition() {
		$nonce = $_POST['nextNonce'];
		if ( ! wp_verify_nonce( $nonce, 'create_nonce' ) ) {
			wp_die('Sorry, security did not verify.');
		} else {
			// process form data
			$db = new Defra_Data_DB_Requests();
			$db->delete_additional_condition($_POST);

		}
		
	
		// Don't forget to stop execution afterward.
		wp_die();

	}

	
	public function delete_permitted_fuel() {
		$nonce = $_POST['nextNonce'];
		if ( ! wp_verify_nonce( $nonce, 'create_nonce' ) ) {
			wp_die('Sorry, security did not verify.');
		} else {
			// process form data
			$db = new Defra_Data_DB_Requests();
			$db->delete_permitted_fuel($_POST);

		}
		
	
		// Don't forget to stop execution afterward.
		wp_die();

	}

	/**
	 * Trigger recommended download letter
	 *
	 * @return void
	 */
	public function download_recommendation_letter($post) {
		$id = $post["id"];
		$now = new DateTime('now', new DateTimeZone('Europe/London'));

		$date = $now->format('d/m/Y'); // fuel & appliance
		$post_obj = get_post($id); // fuel & appliance

		$user = get_user_by('id', get_post_meta($post_obj->ID,'entry_user_id', true)); 

		$data_entry = $user->first_name .' '. $user->last_name; // appliance

		$manufacturer = get_post(get_post_meta($post_obj->ID,'manufacturer_id', true)); // fuel & appliance

		if($post["type"] != 'fuels') {
			$application_number = get_post_meta($post_obj->ID,'appliance_additional_details_application_number', true); // appliance
		} else {
			$application_number = get_post_meta($post_obj->ID,'fuel_additional_details_application_number', true); // fuel
			$fuel_id = get_post_meta($post_obj->ID,'fuel_id', true); // fuel
		}
		$permitted_fuels = wp_get_post_terms( $post_obj->ID, 'permitted_fuels' ); // appliance
		if ( ! empty( $permitted_fuels ) && ! is_wp_error( $permitted_fuels ) ) {
			$fuels_array = array();
			foreach($permitted_fuels as $permitted_fuel) {
				$fuels_array[] = $permitted_fuel->description;
			}
			$permitted_fuel = join( ', ', $fuels_array );
		}

		$instructions = get_post_meta($post_obj->ID,'instructions_instruction_manual_title', true) . ' ' . get_post_meta($post_obj->ID,'instructions_instruction_manual_date', true) . ' ' . get_post_meta($post_obj->ID,'instructions_instruction_manual_reference', true);
		
		$servicing_installation = get_post_meta($post_obj->ID,'servicing_and_installation_servicing_install_manual_title', true) . ' ' . get_post_meta($post_obj->ID,'servicing_and_installation_servicing_install_manual_date', true) . ' ' . get_post_meta($post_obj->ID,'servicing_and_installation_servicing_install_manual_reference', true);

		$conditions = get_post_meta($post_obj->ID,'additional_conditions_additional_condition_comment', true);

		if($post["type"] != 'fuels') {
			$templateFile = plugin_dir_path( __FILE__ ) . 'file-templates/Appliance-Letter.docx';
		} else {
			$templateFile = plugin_dir_path( __FILE__ ) . 'file-templates/Fuel-Letter.docx';
		}
		$phpWord = new \PhpOffice\PhpWord\TemplateProcessor($templateFile);

		if($post["type"] != 'fuels') {
			$phpWord->setValues([
				'TodayDate' => $date,
				'ApplicationNumber' => $application_number,
				'Manufacturer' => $manufacturer->post_title,
				'ApplianceName' => $post_obj->post_title,
				'PermittedFuels' => $permitted_fuel,
				'ManufacturerContact' => $manufacturer->post_title,
				'DataEntryUser' => $data_entry,
				'Instructions' => $instructions,
				'ServiceInstallation' => $servicing_installation,
				'Conditions' => $conditions
			]);
		} else {
			$phpWord->setValues([
				'TodayDate' => $date,
				'ApplicationNumber' => $application_number,
				'Manufacturer' => $manufacturer->post_title,
				'FuelName' => $post_obj->post_title,
				'FuelID' => $fuel_id,
				'ManufacturerContact' => $manufacturer->post_title,
			]);

		}


		$filepath = $phpWord->save();

		if($post["type"] != 'fuels') {
			$file = 'Appliance-Letter-'.$post_obj->ID.'.doc';
		} else {
			$file = 'Fuel-Letter-'.$post_obj->ID.'.doc';
		}
		header("Content-Description: File Transfer");
		header('Content-Disposition: attachment; filename="' . $file . '"');
		header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
		header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
		header('Expires: 0');
		readfile($filepath);
	}

	/**
	 * Generate a pdf download
	 *
	 * @param array $post
	 * @return void
	 */
	public function pdf_fuel_download($post) {
		$data = base64_decode(maybe_unserialize($post["data"]));
		$data = maybe_unserialize($data);
		if ($data) {

			$html = require plugin_dir_path( dirname( __FILE__ ) ) . 'public/file-templates/fuel-pdf-html.php';
			$html2pdf = new Html2Pdf('P','A4','en', false, 'UTF-8', array(30, 15, 30, 15));
			$html2pdf->writeHTML($html);
			$html2pdf->output('fuel.pdf', 'D');
	
		} else {
			// Error handling if the request fails
			error_log('Failed to retrieve the HTML content.');
		}

	}

	/**
	 * Generate a pdf download
	 *
	 * @param array $post
	 * @return void
	 */
	public function pdf_appliance_download($post) {
		$data = base64_decode(maybe_unserialize($post["data"]));
		$data = maybe_unserialize($data);
		if ($data) {

			ob_start();
			require plugin_dir_path( dirname( __FILE__ ) ) . 'public/file-templates/appliance-pdf-html.php';
			$html = ob_get_clean();
			$html2pdf = new Html2Pdf('P','A4','en', true, 'UTF-8', 5);
			$html2pdf->writeHTML($html);
			$html2pdf->output('appliance.pdf', 'D');
	
		} else {
			// Error handling if the request fails
			error_log('Failed to retrieve the HTML content.');
		}

	}

	/**
	 * Generate a csv download
	 *
	 * @param array $post
	 * @return void
	 */
	public function csv_fuel_download($post) {
		$data = base64_decode(maybe_unserialize($post["data"]));
		$data = maybe_unserialize($data);
		if ($data) {

			$html = require plugin_dir_path( dirname( __FILE__ ) ) . 'public/file-templates/fuel-csv.php';
	
		} else {
			// Error handling if the request fails
			error_log('Failed to retrieve the HTML content.');
		}

	}

	/**
	 * Generate a csv download
	 *
	 * @param array $post
	 * @return void
	 */
	public function csv_appliance_download($post) {
		$data = base64_decode(maybe_unserialize($post["data"]));
		$data = maybe_unserialize($data);
		if ($data) {

			$html = require plugin_dir_path( dirname( __FILE__ ) ) . 'public/file-templates/appliance-csv.php';
	
		} else {
			// Error handling if the request fails
			error_log('Failed to retrieve the HTML content.');
		}

	}

	/**
	 * Get desired post meta for fuel data view and download
	 *
	 * @param [type] $post_id
	 * @return array $fuel_data_details
	 */
	public function fuel_data_details($post_id) {
		$fuel_data_details = array();
		$fuel_meta = $this->defra_merge_postmeta($post_id);
		$manufacturer_meta = $this->defra_merge_postmeta($fuel_meta["manufacturer"]);

		$fuel_data_details['fuel_id'] = $fuel_meta["fuel_id"];
		$fuel_data_details['fuel_name'] = get_the_title($post_id);
		$fuel_data_details['manufacturer'] = $this->manufacturer_composite_address($fuel_meta["manufacturer_id"]);
		$fuel_data_details['a'] = $fuel_meta["point_a"];
		$fuel_data_details['b'] = $fuel_meta["point_b"];
		$fuel_data_details['c'] = $fuel_meta["point_c"];
		$fuel_data_details['d'] = $fuel_meta["point_d"];
		$fuel_data_details['e'] = $fuel_meta["point_e"];
		$fuel_data_details['f'] = $fuel_meta["point_f"];
		return $fuel_data_details;

	}

	/**
	 * Get desired post meta for fuel data view and download
	 *
	 * @param [type] $post_id
	 * @return array $appliance_data_details
	 */
	public function appliance_data_details($post_id) {
		$appliance_data_details = array();
		$appliance_meta = $this->defra_merge_postmeta($post_id);
		$manufacturer_meta = $this->defra_merge_postmeta($appliance_meta["manufacturer"]);

		$taxonomy = 'permitted_fuels'; // replace with your taxonomy
		$terms = wp_get_post_terms($post_id, $taxonomy);
		$permitted_fuels = array();
		if (!is_wp_error($terms) && !empty($terms)) {
			foreach ($terms as $term) {
				$permitted_fuels[] = $term->description;
			}
		}
		$permitted_fuels = join( ',',$permitted_fuels );

		$appliance_data_details['appliance_id'] = $appliance_meta["appliance_id"];
		$appliance_data_details['appliance_name'] = get_the_title($post_id);
		$appliance_data_details['output'] = $appliance_meta["output_unit_output_unit_id"] == '3' ? 'n/a' : $appliance_meta["output_unit_output_value"] . $this->output_units($appliance_meta["output_unit_output_unit_id"]);
		$appliance_data_details['fuel_types'] = $this->get_fuel_type($post_id);
		$appliance_data_details['appliance_type'] = $this->get_appliance_type($post_id);
		$appliance_data_details['manufacturer'] = $this->manufacturer_composite_address($appliance_meta["manufacturer"]);
		$appliance_data_details['instructions_instruction_manual_title'] = $appliance_meta["instructions_instruction_manual_title"] ? $appliance_meta["instructions_instruction_manual_title"] : 'See conditions if applicable';
		$appliance_data_details['instructions_instruction_manual_date'] = $appliance_meta["instructions_instruction_manual_date"] ? $appliance_meta["instructions_instruction_manual_date"] : 'See conditions if applicable';
		$appliance_data_details['instructions_instruction_manual_reference'] = $appliance_meta["instructions_instruction_manual_reference"] ? $appliance_meta["instructions_instruction_manual_reference"] : 'See conditions if applicable';
		$appliance_data_details['servicing_and_installation_servicing_install_manual_title'] = $appliance_meta["servicing_and_installation_servicing_install_manual_title"] ? $appliance_meta["servicing_and_installation_servicing_install_manual_title"] : 'See conditions if applicable';
		$appliance_data_details['servicing_and_installation_servicing_install_manual_date'] = $appliance_meta["servicing_and_installation_servicing_install_manual_date"] ? $appliance_meta["servicing_and_installation_servicing_install_manual_date"] : 'See conditions if applicable';
		$appliance_data_details['servicing_and_installation_servicing_install_manual_reference'] = $appliance_meta["servicing_and_installation_servicing_install_manual_reference"] ? $appliance_meta["servicing_and_installation_servicing_install_manual_reference"] : 'See conditions if applicable';
		$appliance_data_details['additional_conditions_additional_condition_comment'] = $appliance_meta["additional_conditions_additional_condition_comment"] ? $appliance_meta["additional_conditions_additional_condition_comment"] : 'n/a';
		$appliance_data_details['permitted_fuels'] = $permitted_fuels;

		$appliance_data_details['exempt-in_country_and_statutory_instrument_england_si_id'] = $appliance_meta["exempt-in_country_and_statutory_instrument_england_si"];
		$appliance_data_details['exempt-in_country_and_statutory_instrument_england_si'] = $appliance_meta["exempt-in_country_and_statutory_instrument_england_si"] ? get_the_title($appliance_meta["exempt-in_country_and_statutory_instrument_england_si"]) : NULL;

		$appliance_data_details['exempt-in_country_and_statutory_instrument_wales_si_id'] = $appliance_meta["exempt-in_country_and_statutory_instrument_wales_si"];
		$appliance_data_details['exempt-in_country_and_statutory_instrument_wales_si'] = $appliance_meta["exempt-in_country_and_statutory_instrument_wales_si"] ? get_the_title($appliance_meta["exempt-in_country_and_statutory_instrument_wales_si"]) : NULL;

		$appliance_data_details['exempt-in_country_and_statutory_instrument_scotland_si_id'] = $appliance_meta["exempt-in_country_and_statutory_instrument_scotland_si"];
		$appliance_data_details['exempt-in_country_and_statutory_instrument_scotland_si'] = $appliance_meta["exempt-in_country_and_statutory_instrument_scotland_si"] ? get_the_title($appliance_meta["exempt-in_country_and_statutory_instrument_scotland_si"]) : NULL;

		$appliance_data_details['exempt-in_country_and_statutory_instrument_n_ireland_si_id'] = $appliance_meta["exempt-in_country_and_statutory_instrument_n_ireland_si"];
		$appliance_data_details['exempt-in_country_and_statutory_instrument_n_ireland_si'] = $appliance_meta["exempt-in_country_and_statutory_instrument_n_ireland_si"] ? get_the_title($appliance_meta["exempt-in_country_and_statutory_instrument_n_ireland_si"]) : NULL;

		return $appliance_data_details;

	}

	/**
	 * Get Appliance fuel types
	 *
	 * @param [type] $appliance_id
	 * @return void
	 */
	public function get_fuel_type($appliance_id) {
		$fuel_types = get_the_terms( $appliance_id, 'fuel_types' );
		if($fuel_types) {
			$terms_string = join(', ', wp_list_pluck($fuel_types, 'name'));
		}
		return $terms_string;
	}

	/**
	 * Get terms of a given custom taxonomy
	 *
	 * @param string $taxonomy
	 * @return object $terms
	 */
	public function get_appliance_taxonomy_terms($taxonomy) {
		$args = array(
			'taxonomy' => $taxonomy,
			'hide_empty' => false, // Set to true if you want to hide empty terms
		);
		$terms = get_terms($args);
		return $terms;
	}

	/**
	 * Get Appliance appliance types
	 *
	 * @param [type] $appliance_id
	 * @return void
	 */
	public function get_appliance_type($appliance_id) {
		$appliance_types = get_the_terms( $appliance_id, 'appliance_types' );
		if($appliance_types) {
			$terms_string = join(', ', wp_list_pluck($appliance_types, 'name'));
		}
		return $terms_string;
	}
	
	

	/**
	 * Get the post title by id
	 *
	 * @param int $post_id
	 * @return string
	 */
	public function get_the_defra_title_by_id($post_id) {
		if(empty($post_id)) {
			return;
		}
		$post = get_post( $post_id );
		return $post->post_title;
	}

	/**
	 * Get the post content by id
	 *
	 * @param int $post_id
	 * @return string
	 */
	public function get_the_defra_content_by_id($post_id) {
		if(empty($post_id)) {
			return;
		}
		$post = get_post( $post_id );
		return $post->post_content;
	}

	/**
	 * Get country name for country id
	 *
	 * @param [type] $country_id
	 * @return void
	 */
	public function set_country_str($country_id) {
		global $wpdb;
		$country = $wpdb->get_results(
			$wpdb->prepare(
				"SELECT *
				FROM wp_defra_countries c
				WHERE c.id = %d",
				array($country_id)
			)
		);
		return $country[0]->country;

	}

	/**
	 * Create a composite Manufacturers address
	 *
	 * @param int $manufacturer_post_id
	 * @return string
	 */
	public function manufacturer_composite_address($manufacturer_post_id) {
		$meta_array = $this->defra_merge_postmeta($manufacturer_post_id);
		$meta_array = array_filter($meta_array);
		unset($meta_array["id"]);
		if(isset($meta_array["country"]) & !empty($meta_array["country"])) {
			$meta_array["country"] = $this->set_country_str($meta_array["country"]);
		}
		$manufacturer_composite_address = join(', ',$meta_array);
		if(empty($manufacturer_composite_address)) {
			$manufacturer_composite_address = get_the_title( $manufacturer_post_id );
		}
		return $manufacturer_composite_address;
	}

	/**
	 * Helper to wrap all postmeta into a single array
	 *
	 * @param int $post_id
	 * @return array
	 */
	public function defra_merge_postmeta($post_id) {
		if(null == $post_id) {
			return;
		}
		$meta_array = array_map(
			function( $a ){
				return $a[0];
			},
			get_post_meta($post_id)
		);
		return $meta_array;
	}
	
	public function do_users_update_callback() {

		$roles = array(
			'1' => 'administrator',
			'2' => 'data_entry',
			'3' => 'data_reviewer',
			'4' => 'data_approver'
		);

		$user_metas = array(
			'first_name',
			'last_name',
			'approver_country_id',
			'active'
		);

		global $wpdb;
        $results = $wpdb->get_results(
            "SELECT *
            FROM wp_users_copy"
        );
		$i = 0;

		foreach($results as $k => $v) {

			$old_roles = $wpdb->get_results(
				"SELECT *
				FROM wp_defra_roles
				WHERE user_id = $v->ID"
			);

			$old_user_data = $wpdb->get_results(
				"SELECT *
				FROM wp_defra_user
				WHERE id = $v->ID"
			);

			foreach($user_metas as $user_meta) {
				update_user_meta( $v->ID, $user_meta, $old_user_data[0]->$user_meta );
				error_log('user meta updated');
			}

			$u = new WP_User( $v->ID );
			foreach($old_roles as $id => $value) {
				$u->add_role( $roles[$value->role_type_id] );
				error_log('user role updated');
			}
			error_log('user update complete');

	
		}


		// foreach($results as $k => $v) {
		// 	$i++;
		// 	$userdata = array();
		// 	if($k == 0) {
		// 		continue;
		// 	}
		// 	//$userdata['ID'] = (int)$v->id;
		// 	$userdata['user_login'] = $v->email_address;
		// 	$userdata['user_email'] = $v->email_address;
		// 	$userdata['first_name'] = $v->first_name;
		// 	$userdata['last_name'] = $v->last_name;
		// 	$userdata['user_registered'] = $v->created;
		// 	$userdata['role'] = 'administrator';
		// 	$user_id = wp_insert_user( $userdata );

		// 	for($i; $i != (int)$v->id; $i++) {
		// 		wp_delete_user( $user_id );
		// 		$user_id = wp_insert_user( $userdata );
		// 	}

		// 	if ( ! is_wp_error( $user_id ) ) {
	
		// 		echo "User ID : ". $user_id;
					
		// 	} else {

		// 		error_log('there was an error');
		// 	}	
		// }

        // return $results;

	}

	/**
	 * If user is logged in and viewing 'data-entry' then do not return the sidebar navigation
	 *
	 * @return void
	 */
	public function defra_public_navigation_callback() {
		$url = $_SERVER["REQUEST_URI"];
		if (strpos($url, "data-entry") === false) {
			// data-entry not found
			require_once plugin_dir_path( __FILE__ ) . 'partials/template-part/defra-public-navigation.php';
		}

	}

	/**
	 * Public verse 'data-entry' opening container div
	 *
	 * @return void
	 */
	public function defra_public_data_entry_opening_container_callback() {
		$url = $_SERVER["REQUEST_URI"];
		if (strpos($url, "data-entry") !== false) {
			// data-entry not found
			echo '<div class="col-sm-12">';
		} else {
			echo '<div class="col-sm-10">';
		}

	}

	/**
	 * If the user is logged in then include the data entry navigation 
	 *
	 * @return void
	 */
	public function data_entry_navigation_callback() {
		$user = wp_get_current_user();
		$allowed_roles = array( 'administrator','data_entry','data_reviewer','data_approver');
		if(is_user_logged_in() && array_intersect( $allowed_roles, $user->roles )) {
			require_once plugin_dir_path( __FILE__ ) . 'partials/data-entry/navigation-data-entry-logged-in.php';
		}
	}

	public function defra_wp_nav_menu_objects($items, $args) {

		// Get current user
		$user = wp_get_current_user();
		$allowed_roles = array( 'data_reviewer','data_approver');

		// Loop through menu items  
		foreach($items as $k => $item) {
		  
			// Check if menu item is only for admins
			if($item->title != "Dashboard" && array_intersect( $allowed_roles, $user->roles )) {
				unset($items[$k]); 
			}
	  
		}
	  
		return $items;
	  
	}

	public function defra_view_assign_link_callback() {
		include plugin_dir_path( __FILE__ ) . 'partials/template-part/view-assign-link.php';
	}

	/**
	 * Determine in a field is required based on the status
	 *
	 * @return boolean
	 */
	public function is_a_required_field() {
		global $post;
		$bool = false;
		$post_id = $post->ID;
		$status = array(
			get_post_meta( $post_id, $post->post_type == 'appliances' ? 'exempt-in_country_and_statutory_instrument_england_status' : 'authorised_country_and_statutory_instrument_england_status', true ),
			get_post_meta( $post_id, $post->post_type == 'appliances' ? 'exempt-in_country_and_statutory_instrument_scotland_status' : 'authorised_country_and_statutory_instrument_scotland_status', true ),
			get_post_meta( $post_id, $post->post_type == 'appliances' ? 'exempt-in_country_and_statutory_instrument_wales_status' : 'authorised_country_and_statutory_instrument_wales_status', true ),
			get_post_meta( $post_id, $post->post_type == 'appliances' ? 'exempt-in_country_and_statutory_instrument_n_ireland_status' : 'authorised_country_and_statutory_instrument_n_ireland_status', true ),
		);
		if( in_array( '600', $status ) || in_array( '20', $status ) || in_array( '30', $status ) || in_array( '50', $status ) ) {
			$bool = true;
		}
		return $bool;
	}
	
	/**
	 * Determine if approve reject button should show based on the current users role
	 *
	 * @param [type] $post_id
	 * @return void
	 */
	public function reviewer_approve_reject_callback($post_id) {


		$post = get_post($post_id);

		$approver_counties = $this->get_exemption_countries();
		$user = wp_get_current_user();
		$post = get_post($post_id);
		$status = array(
			get_post_meta( $post_id, $post->post_type == 'appliances' ? 'exempt-in_country_and_statutory_instrument_england_status' : 'authorised_country_and_statutory_instrument_england_status', true ),
			get_post_meta( $post_id, $post->post_type == 'appliances' ? 'exempt-in_country_and_statutory_instrument_scotland_status' : 'authorised_country_and_statutory_instrument_scotland_status', true ),
			get_post_meta( $post_id, $post->post_type == 'appliances' ? 'exempt-in_country_and_statutory_instrument_wales_status' : 'authorised_country_and_statutory_instrument_wales_status', true ),
			get_post_meta( $post_id, $post->post_type == 'appliances' ? 'exempt-in_country_and_statutory_instrument_n_ireland_status' : 'authorised_country_and_statutory_instrument_n_ireland_status', true ),
		);

		$status = array_unique($status);
		$count = count($status);

		$revoked = array(
			get_post_meta( $post_id, $post->post_type == 'appliances' ? 'exempt-in_country_and_statutory_instrument_england_revoke_requested' : 'authorised_country_and_statutory_instrument_england_revoke_requested', true ),
			get_post_meta( $post_id, $post->post_type == 'appliances' ? 'exempt-in_country_and_statutory_instrument_scotland_revoke_requested' : 'authorised_country_and_statutory_instrument_scotland_revoke_requested', true ),
			get_post_meta( $post_id, $post->post_type == 'appliances' ? 'exempt-in_country_and_statutory_instrument_wales_revoke_requested' : 'authorised_country_and_statutory_instrument_wales_revoke_requested', true ),
			get_post_meta( $post_id, $post->post_type == 'appliances' ? 'exempt-in_country_and_statutory_instrument_n_ireland_revoke_requested' : 'authorised_country_and_statutory_instrument_n_ireland_revoke_requested', true ),
		);
		$revoked = array_unique($revoked);
		$revoked = array_filter($revoked);

		
		if( current_user_can( 'data_reviewer' ) || current_user_can( 'data_entry' ) || current_user_can( 'administrator' ) ) {
			if( !empty( $revoked[0] ) ) {

				$status = array(
					get_post_meta( $post_id, $post->post_type == 'appliances' ? 'exempt-in_country_and_statutory_instrument_england_revoke_status_id' : 'authorised_country_and_statutory_instrument_england_revoke_status_id', true ),
					get_post_meta( $post_id, $post->post_type == 'appliances' ? 'exempt-in_country_and_statutory_instrument_scotland_revoke_status_id' : 'authorised_country_and_statutory_instrument_scotland_revoke_status_id', true ),
					get_post_meta( $post_id, $post->post_type == 'appliances' ? 'exempt-in_country_and_statutory_instrument_wales_revoke_status_id' : 'authorised_country_and_statutory_instrument_wales_revoke_status_id', true ),
					get_post_meta( $post_id, $post->post_type == 'appliances' ? 'exempt-in_country_and_statutory_instrument_n_ireland_revoke_status_id' : 'authorised_country_and_statutory_instrument_n_ireland_revoke_status_id', true ),
				);
				$status = array_unique($status);

				if( in_array( '200', $status ) || in_array( '300', $status ) ) {
					include plugin_dir_path( __FILE__ ) . 'partials/template-part/status-information.php';
				}
				if( in_array( '20', $status ) || in_array( '30', $status ) ) {
					include plugin_dir_path( __FILE__ ) . 'partials/template-part/reviewer-approve-reject.php';
				}				

			} elseif ( !empty( $status[0] ) && in_array( '20', $status ) || in_array( '600', $status ) || in_array( '30', $status ) ) {
				if( !current_user_can( 'data_entry' ) ) {
					include plugin_dir_path( __FILE__ ) . 'partials/template-part/reviewer-approve-reject.php';
				}
			}

		}

		if(current_user_can( 'data_approver' )) {
			$country_approver_key = get_user_meta( $user->ID, 'approver_country_id', true );
			$approver_id = get_post_meta( $post_id, $post->post_type == 'appliances' ? 'exempt-in_country_and_statutory_instrument_'.$approver_counties[$country_approver_key].'_user' : 'authorised_country_and_statutory_instrument_'.$approver_counties[$country_approver_key].'_user', true );

			if($revoked) {
				$status = get_post_meta( $post_id, $post->post_type == 'appliances' ? 'exempt-in_country_and_statutory_instrument_'.$approver_counties[$country_approver_key].'_revoke_status_id' : 'authorised_country_and_statutory_instrument_'.$approver_counties[$country_approver_key].'_revoke_status_id', true );
			} else {
				$status = get_post_meta( $post_id, $post->post_type == 'appliances' ? 'exempt-in_country_and_statutory_instrument_'.$approver_counties[$country_approver_key].'_status' : 'authorised_country_and_statutory_instrument_'.$approver_counties[$country_approver_key].'_status', true );
			}
			if( $status == '80' || $status == '500' || $status == '300' ) {

				include plugin_dir_path( __FILE__ ) . 'partials/template-part/status-information.php';

			} else if( !empty($approver_id) && $approver_id == $user->ID || $revoked ) {

				include plugin_dir_path( __FILE__ ) . 'partials/template-part/approver-approve-reject.php';

			}
		}
	}

	/**
	 * statutory instrument assignment
	 *
	 * @param [type] $post_id
	 * @param [type] $country
	 * @return void
	 */
	public function statutory_instrument_assignment( $post_id, $country, $type = null ) {
		$count = $type == 'appliance' ? get_post_meta( $post_id, 'exempt-in_country_and_statutory_instrument_'.$country.'_si', true ) : get_post_meta( $post_id, 'authorised_country_and_statutory_instrument_'.$country.'_si', true );
		$statutory_instruments = array();
		for ($i=0; $i < $count; $i++) { 
			$si_id = $type == 'appliance' ? get_post_meta( $post_id, 'exempt-in_country_and_statutory_instrument_'.$country.'_si_'.$i.'_si_id', true ) : get_post_meta( $post_id, 'authorised_country_and_statutory_instrument_'.$country.'_si_'.$i.'_si_id', true );
			$statutory_instruments[$i]['id'] = $si_id;
			$statutory_instruments[$i]['title'] = get_the_title($si_id);
			$statutory_instruments[$i]['publish_date'] = $type == 'appliance' ? get_post_meta( $post_id, 'exempt-in_country_and_statutory_instrument_'.$country.'_publish_date', true ) : get_post_meta( $post_id, 'authorised_country_and_statutory_instrument_'.$country.'_publish_date', true );
			$statutory_instruments[$i]['publish_status'] = $type == 'appliance' ? get_post_meta( $post_id, 'exempt-in_country_and_statutory_instrument_'.$country.'_status', true ) : get_post_meta( $post_id, 'authorised_country_and_statutory_instrument_'.$country.'_status', true );
			$revoke_requested = $type == 'appliance' ? get_post_meta( $post_id, 'exempt-in_country_and_statutory_instrument_'.$country.'_revoke_requested', true ) : get_post_meta( $post_id, 'authorised_country_and_statutory_instrument_'.$country.'_revoke_requested', true );
			// if revocation has been requested asign to array
			if(!empty( $revoke_requested )) {
				$statutory_instruments[$i]['revoke_requested'] = $type == 'appliance' ? get_post_meta( $post_id, 'exempt-in_country_and_statutory_instrument_'.$country.'_revoke_requested', true ) : get_post_meta( $post_id, 'authorised_country_and_statutory_instrument_'.$country.'_revoke_requested', true );
			}
			if(strpos(get_the_title($si_id), 'Footnote') !== false) {
				$statutory_instruments[$i]['url'] = get_permalink($si_id);
				$statutory_instruments[$i]['status'] = 0;
			} else {
				$statutory_instruments[$i]['url'] = get_post_field('post_content', $si_id);
				$statutory_instruments[$i]['status'] = 1;
			}

			
		}
		return $statutory_instruments;
	}

	/**
	 * Get all terms used or unused for a give taxonomy
	 *
	 * @param string $taxonomy
	 * @return void
	 */
	public function defra_get_terms( $taxonomy ) {
		$terms = get_terms(array(
			'taxonomy' => $taxonomy, // Replace 'your_custom_taxonomy' with the name of your taxonomy
			'hide_empty' => false, // Set to true to hide terms with no posts
		));
		return $terms;
	}

	/**
	 * Get SI posts by term
	 *
	 * @param [type] $term
	 * @return void
	 */
	public function get_list_sis_by_term( $term ) {

		$list_appliance_sis = array();
		// First, let's retrieve the term object for the 'appliance' slug
		$term = get_term_by('slug', $term, 'si_types');

		// Check if the term exists
		if ($term) {
			// Now, let's retrieve all posts of the custom post type 'statutory_instrument' with the 'appliance' term
			$args = array(
				'post_type' => 'statutory_instrument',
				'post_status' => 'publish',
				'tax_query' => array(
					array(
						'taxonomy' => 'si_types',
						'field' => 'slug',
						'terms' => $term->slug
					)
				),
				'posts_per_page' => -1 // Retrieve all posts
			);

			$si_query = get_posts($args);

		}
		foreach (  $si_query as $k => $si ) {
			$terms = get_the_terms( $si->ID, 'si_countries' );
			$list_appliance_sis[$si->ID]['id'] = $si->ID;
			$list_appliance_sis[$si->ID]['number'] = $si->post_title;
			$list_appliance_sis[$si->ID]['link'] = $si->post_content;
			foreach($terms as $t => $term) {
				$list_appliance_sis[$si->ID]['country_term_id'][$t] = $term->term_id;
			}
		}

		return $list_appliance_sis;
	}

	/**
	 * Get appliance count based on a status number and 
	 *
	 * @param [type] $status
	 * @param [type] $meta_status
	 * @return void
	 */
	public function count_appliance( $status, $country = null ) {
		$db = new Defra_Data_DB_Requests();
		$appliance_data = $db->get_post_country_status( 'appliances', $status, $country );

		$appliances = defra_data_by_appliance_id( $appliance_data );

		if( !empty( $appliances ) ) {
			return count( $appliances );
		} else {
			return 0;
		}

	}

	/**
	 * Conditional check for footnote output or SI link
	 *
	 * @param [type] $array
	 * @return void
	 */
	public function footnote_output( $array ) {
		if(strpos($array['title'], 'Footnote') !== false) {
			return $array['title'];
		} else {
			return '<a href="'.$array['url'].'" target="_blank">'.$array['title'].'</a>';
		}
	}

	/**
	 * cURL Tests
	 */
	public function test_post_new_appliance_callback() {
		$nonce = wp_create_nonce( 'create_nonce' );
		$dateTime = new DateTime('now', new DateTimeZone('Europe/London'));
		$post_author = 63;
		$data = array(
			'post_author' => $post_author,
			'manufacturer_id' => "42462",
			'appliance_name' => 'Created by cURL ' . $dateTime->format('Y-m-d H:i:s'),
			'permitted_fuel_id' => array("209", "300"),
			'fuel_types' => "liquid",
			'type_terms' => "roomheater",
			'output_unit_output_unit_id' => "2",
			'output_unit_output_value' => "testing",
			'instructions_instruction_manual_date' => "2023-08-15",
			'instructions_instruction_manual_title' => "testing",
			'instructions_instruction_manual_reference' => "testing",
			'servicing_and_installation_servicing_install_manual_date' => "2023-08-15",
			'servicing_and_installation_servicing_install_manual_title' => "testing",
			'servicing_and_installation_servicing_install_manual_reference' => "testing",
			'additional_conditions_additional_condition_id' => "1",
			'additional_conditions_additional_condition_comment' => "testing",
			'appliance_additional_details_application_number' => "testing",
			'appliance_additional_details_linked_applications' => "testing",
			'appliance_additional_details_comments' => "testing",
			'exempt-in_country_and_statutory_instrument_england_enabled' => "on",
			'exempt-in_country_and_statutory_instrument_england_si' => array("50073"),
			'exempt-in_country_and_statutory_instrument_england_status' => "20",
			'exempt-in_country_and_statutory_instrument_england_user' => "",
			'exempt-in_country_and_statutory_instrument_england' => "",
			'exempt-in_country_and_statutory_instrument_scotland_enabled' => "on",
			'exempt-in_country_and_statutory_instrument_scotland_si' => array("50073"),
			'exempt-in_country_and_statutory_instrument_scotland_status' => "20",
			'exempt-in_country_and_statutory_instrument_scotland_user' => "",
			'exempt-in_country_and_statutory_instrument_scotland' => "",
			'exempt-in_country_and_statutory_instrument_n_ireland_enabled' => "on",
			'exempt-in_country_and_statutory_instrument_n_ireland_si' => array("50073"),
			'exempt-in_country_and_statutory_instrument_n_ireland_status' => "20",
			'exempt-in_country_and_statutory_instrument_n_ireland_user' => "",
			'exempt-in_country_and_statutory_instrument_n_ireland' => "",
			'exempt-in_country_and_statutory_instrument_wales_enabled' => "on",
			'exempt-in_country_and_statutory_instrument_wales_si' => array("50073"),
			'exempt-in_country_and_statutory_instrument_wales_status' => "20",
			'exempt-in_country_and_statutory_instrument_wales_user' => "",
			'exempt-in_country_and_statutory_instrument_wales' => "",
			'exempt-in_country_and_statutory_instrument' => "",
			// include mock ACF fields
			'_exempt-in_country_and_statutory_instrument_england_enabled' => 'field_6194c7f2ec2e9',
			'_exempt-in_country_and_statutory_instrument_england_si_0_si_id' => 'field_64aeae1af92fc',
			'_exempt-in_country_and_statutory_instrument_england_si' => 'field_6194c808ec2ea',
			'_exempt-in_country_and_statutory_instrument_england_status' => 'field_61af85aeb072d',
			'_exempt-in_country_and_statutory_instrument_england_user' => 'field_61af87b71c4e8',
			'_exempt-in_country_and_statutory_instrument_england' => 'field_6194c3c6f8736',
			'_exempt-in_country_and_statutory_instrument_wales_enabled' => 'field_6194c838ec2eb',
			'_exempt-in_country_and_statutory_instrument_wales_si_0_si_id' => 'field_64aeae8e31c0c',
			'_exempt-in_country_and_statutory_instrument_wales_si' => 'field_6194c842ec2ec',
			'_exempt-in_country_and_statutory_instrument_wales_status' => 'field_61af86a3b072e',
			'_exempt-in_country_and_statutory_instrument_wales_user' => 'field_61af87d01c4e9',
			'_exempt-in_country_and_statutory_instrument_wales' => 'field_6194c7c0ec2e8',
			'_exempt-in_country_and_statutory_instrument_scotland_enabled' => 'field_6194c858ec2ee',
			'_exempt-in_country_and_statutory_instrument_scotland_si_0_si_id' => 'field_64aeaec131c0d',
			'_exempt-in_country_and_statutory_instrument_scotland_si' => 'field_6194c858ec2ef',
			'_exempt-in_country_and_statutory_instrument_scotland_status' => 'field_61af86bbb072f',
			'_exempt-in_country_and_statutory_instrument_scotland_user' => 'field_61af87e31c4ea',
			'_exempt-in_country_and_statutory_instrument_scotland' => 'field_6194c858ec2ed',
			'_exempt-in_country_and_statutory_instrument_n_ireland_enabled' => 'field_6194c8c2ec2f1',
			'_exempt-in_country_and_statutory_instrument_n_ireland_si_0_si_id' => 'field_64aeaedc31c0e',
			'_exempt-in_country_and_statutory_instrument_n_ireland_si' => 'field_6194c8c2ec2f2',
			'_exempt-in_country_and_statutory_instrument_n_ireland_status' => 'field_61af86d0b0730',
			'_exempt-in_country_and_statutory_instrument_n_ireland_user' => 'field_61af87f61c4eb',
			'_exempt-in_country_and_statutory_instrument_n_ireland' => 'field_6194c8c2ec2f0',
			'_exempt-in_country_and_statutory_instrument' => 'field_6194bbacf8735',
			'comment_to_da' => "",
			'user_comment' => "",
			'process' => "create-appliance",
			'create_nonce_field' => $nonce,
			'_wp_http_referer' => "/data-entry/appliances/create-new-appliance/",
			'submit-type' => "submit-review"
		);

		$curl = curl_init();

		curl_setopt_array($curl, array(
			CURLOPT_URL => 'https://defra.test/data-entry/form-process/',
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => 'application/json',
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_FOLLOWLOCATION => false,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => 'POST',
			CURLOPT_POSTFIELDS => json_encode( $data )
		));

		$response = curl_exec($curl);

		curl_close($curl);
		echo $response;

	}

	/**
	 * random testing
	 *
	 * @return void
	 */
	public function set_next_logical_publish_date() {
		$datetime = new DateTime('now', new DateTimeZone('Europe/London'));
		$publish_date = $datetime->modify('midnight first day of next month');
		$publish_date = $datetime->format('Y-m-d H:i:s');
		return $publish_date;
	}


	/**
	 * random testing
	 *
	 * @return void
	 */
	public function test_logic_callback() {
		$datetime = new DateTime('now', new DateTimeZone('Europe/London'));
		$publish = $datetime->modify('midnight first day of next month');
		$publish = $datetime->format('Y-m-d H:i:s');
		return $publish;
	}
 }