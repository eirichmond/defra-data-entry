<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://squareone.software
 * @since      1.0.0
 *
 * @package    Defra_Data_Entry
 * @subpackage Defra_Data_Entry/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Defra_Data_Entry
 * @subpackage Defra_Data_Entry/includes
 * @author     Elliott Richmond <elliott@squareonemd.co.uk>
 */
class Defra_Data_Entry {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Defra_Data_Entry_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		if ( defined( 'DEFRA_DATA_ENTRY_VERSION' ) ) {
			$this->version = DEFRA_DATA_ENTRY_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'defra-data-entry';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Defra_Data_Entry_Loader. Orchestrates the hooks of the plugin.
	 * - Defra_Data_Entry_i18n. Defines internationalization functionality.
	 * - Defra_Data_Entry_Admin. Defines all hooks for the admin area.
	 * - Defra_Data_Entry_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {
		/**
		 * lookup funcitons
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/functions-defra-data-lookup.php';

		/**
		 * helper funcitons
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/functions-defra-data-helper.php';
		
		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-defra-data-entry-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-defra-data-entry-i18n.php';

		/**
		 * The class database interactions
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-defra-data-db.php';
		
		/**
		 * The class responsible for audits
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-defra-audit-log.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-defra-data-entry-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-defra-data-entry-public.php';

		$this->loader = new Defra_Data_Entry_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Defra_Data_Entry_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Defra_Data_Entry_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Defra_Data_Entry_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );

		$this->loader->add_action( 'admin_menu', $plugin_admin, 'remove_menu_post_edit' );

		$this->loader->add_action( 'wp_dashboard_setup', $plugin_admin, 'defra_db_widgets' );

		
		$this->loader->add_action( 'post_submitbox_misc_actions', $plugin_admin, 'defra_process_status', 10, 1 );
		$this->loader->add_action( 'init', $plugin_admin, 'defra_custom_post_status_rejected', 10 );
		$this->loader->add_action( 'init', $plugin_admin, 'defra_custom_post_status_approved', 10 );
		
		$this->loader->add_action( 'save_post_appliances', $plugin_admin, 'defra_save_appliances', 10, 3 );
		$this->loader->add_action( 'save_post_fuels', $plugin_admin, 'defra_save_fuels', 10, 3 );

		$this->loader->add_action( 'comment_text', $plugin_admin, 'show_defra_comments_admin', 10, 1 );

		$this->loader->add_filter( 'login_headerurl', $plugin_admin, 'defra_logo_url_link', 10, 1 );
  
	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Defra_Data_Entry_Public( $this->get_plugin_name(), $this->get_version() );
		$ajaxevents = $plugin_public->defra_public_ajax_events();

		foreach($ajaxevents as $ajaxevent) {
			$this->loader->add_action( 'wp_ajax_nopriv_'.$ajaxevent, $plugin_public, $ajaxevent );
			$this->loader->add_action( 'wp_ajax_'.$ajaxevent, $plugin_public, $ajaxevent );
        }


		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );


		$this->loader->add_action( 'login_enqueue_scripts', $plugin_public, 'defra_login_logo' );

		$this->loader->add_filter( 'template_include', $plugin_public, 'defra_page_includes', 10, 1 );
		$this->loader->add_filter( 'single_template', $plugin_public, 'defra_single_template_callback', 10, 1 );
		
		$this->loader->add_filter( 'wp_mail_from', $plugin_public, 'defra_mail_from', 10, 1 );
		$this->loader->add_filter( 'wp_mail_from_name', $plugin_public, 'defra_mail_from_name', 10, 1 );
		$this->loader->add_filter( 'wp_mail', $plugin_public, 'defra_check_mail_env', 10, 1 );

		
		$this->loader->add_filter( 'nav_menu_link_attributes', $plugin_public, 'defra_nav_menu_link_attributes_callback', 10, 3 );

		$this->loader->add_action( 'init', $plugin_public, 'html_markup_components_callback' );
		$this->loader->add_action( 'init', $plugin_public, 'defra_register_menu_callback' );
		$this->loader->add_action( 'init', $plugin_public, 'defra_register_cpts');
		$this->loader->add_action( 'init', $plugin_public, 'defra_register_ctts');
		$this->loader->add_action( 'defra_public_navigation', $plugin_public, 'defra_public_navigation_callback');
		$this->loader->add_action( 'defra_public_data_entry_opening_container', $plugin_public, 'defra_public_data_entry_opening_container_callback');
		$this->loader->add_action( 'defra_view_assign_link', $plugin_public, 'defra_view_assign_link_callback');
		$this->loader->add_action( 'wp_ajax_defra_assign_link', $plugin_public, 'defra_assign_link');

		$this->loader->add_action( 'defra_table_list', $plugin_public, 'defra_table_list_callback', 10, 1 );
		$this->loader->add_action( 'data_entry_navigation', $plugin_public, 'data_entry_navigation_callback', 10);
		$this->loader->add_action( 'reviewer_approve_reject', $plugin_public, 'reviewer_approve_reject_callback', 10, 1);

		$this->loader->add_action( 'process_form', $plugin_public, 'process_form_callback' );

		$this->loader->add_action( 'do_users_update', $plugin_public, 'do_users_update_callback' );
		$this->loader->add_action( 'do_manufacturers_update', $plugin_public, 'do_manufacturers_update_callback' );

		$this->loader->add_action( 'pre_get_posts', $plugin_public, 'get_appliance_posts' );
		$this->loader->add_action( 'pre_get_posts', $plugin_public, 'get_fuel_posts' );
		$this->loader->add_filter( 'login_redirect', $plugin_public, 'defra_login_redirect', 10, 3 );
		
		$this->loader->add_filter( 'wp_nav_menu_objects', $plugin_public, 'defra_wp_nav_menu_objects', 10, 2 );


		/**
		 * cURL form tests
		 */
		$this->loader->add_action( 'test_post_new_appliance', $plugin_public, 'test_post_new_appliance_callback' );
		
		
	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Defra_Data_Entry_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

}
