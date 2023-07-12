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
		wp_enqueue_script( $this->plugin_name . '-datatables', plugin_dir_url( __FILE__ ) . 'js/datatables.min.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script( $this->plugin_name . '-select2', plugin_dir_url( __FILE__ ) . 'js/select2.full.min.js', array( 'jquery' ), $this->version, false );

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

		// if ( is_post_type_archive('appliances') ) {
		// 	if (is_user_logged_in()) {
		// 		$original_template = plugin_dir_path( __FILE__ ) . 'partials/appliances.php';
		// 	} else {
		// 		$original_template = plugin_dir_path( __FILE__ ) . 'partials/not-logged-in.php';
		// 	}
		// }

		// if ( is_post_type_archive('fuels') ) {
		// 	if (is_user_logged_in()) {
		// 		$original_template = plugin_dir_path( __FILE__ ) . 'partials/fuels.php';
		// 	} else {
		// 		$original_template = plugin_dir_path( __FILE__ ) . 'partials/not-logged-in.php';
		// 	}
		// }


		return $original_template;
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
		if($_POST['process'] == 'create-appliance') {
			$this->process_create_appliance();
		}
		if($_POST['process'] == 'create-statutory-instrument') {
			$this->process_create_statutory_instrument();
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
		if($_POST['process'] == 'download-recommendation-letter') {
			$this->download_recommendation_letter($_POST['appliance_id']);
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
			$db = new Defra_Data_DB_Requests();
			$post_id = $db->insert_new_appliance($_POST);
			// redirect with success
			$url = home_url().'/data-entry/appliances/create-new-appliance/?post=success&id='.$post_id;
			wp_redirect( $url );
			exit;

		}
	}

	/**
	 * Create a new statutory instrument
	 *
	 * @return void
	 */
	public function process_create_statutory_instrument() {

		wp_die('This needs recoding for wp post type.');

		if ( ! isset( $_POST['create_nonce_field'] ) || ! wp_verify_nonce( $_POST['create_nonce_field'], 'create_nonce' ) ) {
			wp_die('Sorry, security did not verify.');
		} else {
			// process form data
			$db = new Defra_Data_DB_Requests();
			$db->insert_new_permitted_fuel($_POST);
			// redirect with success
			$url = home_url().'/data-entry/permitted-fuels/create-new-permitted-fuel/?post=success';
			wp_redirect( $url );
			exit;

		}
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
			$db->insert_new_permitted_fuel($_POST);
			// redirect with success
			$url = home_url().'/data-entry/permitted-fuels/create-new-permitted-fuel/?post=success';
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
			// process form data
			$db = new Defra_Data_DB_Requests();
			$db->insert_new_fuel_type($_POST);
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
			$db->insert_new_manufacturer($_POST);
			// redirect with success
			$url = home_url().'/data-entry/manufacturers/create-new-manufacturer/?post=success';
			wp_redirect( $url );
			exit;
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
				$args_array[$k]['value'] = '1';
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
			$args['meta_value'] = '1';
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
				$template = plugin_dir_path( __FILE__ ) . 'partials/data-entry/fuel-view.php';
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
				$template = plugin_dir_path( __FILE__ ) . 'partials/data-entry/appliance-view.php';
			} else {
				$template = plugin_dir_path( __FILE__ ) . 'cpt-templates/single-appliances.php';
			}
			
			//$template = plugin_dir_path( __FILE__ ) . 'cpt-templates/single-appliances.php';

		}

		return $template;
	}
	
	/**
	 * Set Appliance parameters for query
	 *
	 * @param object $query
	 * @return void
	 */
	public function get_appliance_posts($query) {
		if ( ! is_admin() && is_post_type_archive( 'appliances' ) && $query->is_main_query() ) {
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
			'1' => 'Data Entry',
			'2' => 'Approved',
			'3' => 'Rejected',
			'4' => 'Cancelled'
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
			'1' => 'Data Entry User',
			'2' => 'Reviewer',
			'3' => 'Approver',
			'4' => 'Devolved Admin'
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

	public function appliance_conditions($key = null) {
		$conditions = array(
			'1' => 'Permanent Stop',
			'2' => 'Cyclone',
			'3' => 'Conversion Kit',
			'4' => 'None',
			'5' => 'Not applicable'
		);
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
	public function download_recommendation_letter($id) {
		$now = new DateTime('now', new DateTimeZone('Europe/London'));
		$date = $now->format('d/m/Y');
		$appliance = get_post($id);
		$user = get_user_by('id', get_post_meta($appliance->ID,'entry_user_id', true));
		$data_entry = $user->first_name .' '. $user->last_name;
		$manufacturer = get_post(get_post_meta($appliance->ID,'manufacturer', true));
		$application_number = get_post_meta($appliance->ID,'appliance_additional_details_application_number', true);
		$permitted_fuel = get_post(get_post_meta($appliance->ID,'appliance_fuels_permitted_fuel_id', true));
		$instructions = get_post_meta($appliance->ID,'instructions_instruction_manual_title', true) . ' ' . get_post_meta($appliance->ID,'instructions_instruction_manual_date', true) . ' ' . get_post_meta($appliance->ID,'instructions_instruction_manual_reference', true);

		$templateFile = plugin_dir_url( __FILE__ ) . 'file-templates/Appliance-Letter.docx';
		$phpWord = new \PhpOffice\PhpWord\TemplateProcessor($templateFile);

		$phpWord->setValue('TodayDate',$date);
		$phpWord->setValue('ApplicationNumber',$application_number);
		$phpWord->setValue('Manufacturer',$manufacturer->post_title);
		$phpWord->setValue('ApplianceName',$appliance->post_title);
		$phpWord->setValue('PermittedFuels',$permitted_fuel->post_title);
		$phpWord->setValue('ManufacturerContact',$manufacturer->post_title);
		$phpWord->setValue('DataEntryUser',$data_entry);
		$phpWord->setValue('Instructions',$instructions);

		$filepath = $phpWord->save();

		$file = 'Appliance-Letter.docx';
		header("Content-Description: File Transfer");
		header('Content-Disposition: attachment; filename="' . $file . '"');
		header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
		header('Content-Transfer-Encoding: binary');
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

			$html = require plugin_dir_path( dirname( __FILE__ ) ) . 'public/file-templates/appliance-pdf-html.php';
			$html2pdf = new Html2Pdf('P','A4','en', false, 'UTF-8', array(30, 15, 30, 15));
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
		$fuel_data_details['manufacturer'] = $this->manufacturer_composite_address($fuel_meta["manufacturer"]);
		$fuel_data_details['a'] = $fuel_meta["point_a"];
		$fuel_data_details['b'] = $fuel_meta["point_b"];
		$fuel_data_details['c'] = $fuel_meta["point_c"];
		$fuel_data_details['d'] = $fuel_meta["point_d"];
		$fuel_data_details['e'] = $fuel_meta["point_e"];
		$fuel_data_details['f'] = $fuel_meta["point_f"];
		$fuel_data_details['exempt-in_country_and_statutory_instrument_england_si_content'] = $this->get_the_defra_content_by_id($fuel_meta["exempt-in_country_and_statutory_instrument_england_si"]) ? $this->get_the_defra_content_by_id($fuel_meta["exempt-in_country_and_statutory_instrument_england_si"]) : NULL;
		$fuel_data_details['exempt-in_country_and_statutory_instrument_england_si_title'] = $this->get_the_defra_title_by_id($fuel_meta["exempt-in_country_and_statutory_instrument_england_si"]) ? $this->get_the_defra_title_by_id($fuel_meta["exempt-in_country_and_statutory_instrument_england_si"]) : NULL;
		$fuel_data_details['exempt-in_country_and_statutory_instrument_england_si_authorised'] = $fuel_meta["exempt-in_country_and_statutory_instrument_england_publish_date"] ? $fuel_meta["exempt-in_country_and_statutory_instrument_england_publish_date"] : NULL;
		$fuel_data_details['exempt-in_country_and_statutory_instrument_wales_si_content'] = $this->get_the_defra_content_by_id($fuel_meta["exempt-in_country_and_statutory_instrument_wales_si"]) ? $this->get_the_defra_content_by_id($fuel_meta["exempt-in_country_and_statutory_instrument_wales_si"]) : NULL;
		$fuel_data_details['exempt-in_country_and_statutory_instrument_wales_si_title'] = $this->get_the_defra_title_by_id($fuel_meta["exempt-in_country_and_statutory_instrument_wales_si"]) ? $this->get_the_defra_title_by_id($fuel_meta["exempt-in_country_and_statutory_instrument_wales_si"]) : NULL;
		$fuel_data_details['exempt-in_country_and_statutory_instrument_wales_si_authorised'] = $fuel_meta["exempt-in_country_and_statutory_instrument_wales_publish_date"] ? $fuel_meta["exempt-in_country_and_statutory_instrument_wales_publish_date"] : NULL;
		$fuel_data_details['exempt-in_country_and_statutory_instrument_scotland_si_content'] = $this->get_the_defra_content_by_id($fuel_meta["exempt-in_country_and_statutory_instrument_scotland_si"]) ? $this->get_the_defra_content_by_id($fuel_meta["exempt-in_country_and_statutory_instrument_scotland_si"]) : NULL;
		$fuel_data_details['exempt-in_country_and_statutory_instrument_scotland_si_title'] = $this->get_the_defra_title_by_id($fuel_meta["exempt-in_country_and_statutory_instrument_scotland_si"]) ? $this->get_the_defra_title_by_id($fuel_meta["exempt-in_country_and_statutory_instrument_scotland_si"]) : NULL;
		$fuel_data_details['exempt-in_country_and_statutory_instrument_scotland_si_authorised'] = $fuel_meta["exempt-in_country_and_statutory_instrument_scotland_publish_date"] ? $fuel_meta["exempt-in_country_and_statutory_instrument_scotland_publish_date"] : NULL;
		$fuel_data_details['exempt-in_country_and_statutory_instrument_n_ireland_si_content'] = $this->get_the_defra_content_by_id($fuel_meta["exempt-in_country_and_statutory_instrument_n_ireland_si"]) ? $this->get_the_defra_content_by_id($fuel_meta["exempt-in_country_and_statutory_instrument_n_ireland_si"]) : NULL;
		$fuel_data_details['exempt-in_country_and_statutory_instrument_n_ireland_si_title'] = $this->get_the_defra_title_by_id($fuel_meta["exempt-in_country_and_statutory_instrument_n_ireland_si"]) ? $this->get_the_defra_title_by_id($fuel_meta["exempt-in_country_and_statutory_instrument_n_ireland_si"]) : NULL;
		$fuel_data_details['exempt-in_country_and_statutory_instrument_n_ireland_si_authorised'] = $fuel_meta["exempt-in_country_and_statutory_instrument_n_ireland_publish_date"] ? $fuel_meta["exempt-in_country_and_statutory_instrument_n_ireland_publish_date"] : NULL;
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
		$appliance_data_details['appliance_fuels_permitted_fuel_id'] = $appliance_meta["appliance_fuels_permitted_fuel_id"] ? get_the_title($appliance_meta["appliance_fuels_permitted_fuel_id"]) : NULL;

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
		$meta_array["country"] = $this->set_country_str($meta_array["country"]);
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
		$meta_array = array_map( function( $a ){ return $a[0]; }, get_post_meta($post_id) );
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

	public function data_entry_navigation_callback() {
		$user = wp_get_current_user();
		$allowed_roles = array( 'administrator','data_entry');
		if(is_user_logged_in() && array_intersect( $allowed_roles, $user->roles )) {
			require_once plugin_dir_path( __FILE__ ) . 'partials/data-entry/navigation-data-entry-logged-in.php';
		}
	}


}
