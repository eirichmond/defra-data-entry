<?php

/**
 * Fired during plugin deactivation
 *
 * @link       https://squareone.software
 * @since      1.0.0
 *
 * @package    Defra_Data_Entry
 * @subpackage Defra_Data_Entry/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    Defra_Data_Entry
 * @subpackage Defra_Data_Entry/includes
 * @author     Elliott Richmond <elliott@squareonemd.co.uk>
 */
class Defra_Data_Entry_Deactivator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function deactivate($config) {

		// $data_entry_id = get_page_by_title( 'Data Entry' );

		// $args = array(
		// 	'post_type' => 'page',
		// 	'posts_per_page' => -1,
		// 	'post_status' => 'publish',
		// 	'post_parent' => $data_entry_id->ID
		// );
		// $data_entry_pages = get_posts($args);

		// foreach($data_entry_pages as $data_entry_page){
		// 	$args = array(
		// 		'post_type' => 'page',
		// 		'posts_per_page' => -1,
		// 		'post_status' => 'publish',
		// 		'post_parent' => $data_entry_page->ID
		// 	);
		// 	$data_entry_sub_pages = get_posts($args);
		// 	foreach($data_entry_sub_pages as $data_entry_sub_page) {
		// 		wp_delete_post( $data_entry_sub_page->ID, true );
		// 	}
		// 	wp_delete_post( $data_entry_page->ID, true );
		// }
		// wp_delete_post( $data_entry_id->ID, true );


		// // unset menus and locations
		// foreach($config["menu_navigation"] as $navmenu) {
		// 	$menu_name = $navmenu['name'];
		// 	$menu_location = $navmenu['location'];

		// 	wp_delete_nav_menu( $menu_location );


		// }
		

	}

}
