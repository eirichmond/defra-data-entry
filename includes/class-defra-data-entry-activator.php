<?php

/**
 * Fired during plugin activation
 *
 * @link       https://squareone.software
 * @since      1.0.0
 *
 * @package    Defra_Data_Entry
 * @subpackage Defra_Data_Entry/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Defra_Data_Entry
 * @subpackage Defra_Data_Entry/includes
 * @author     Elliott Richmond <elliott@squareonemd.co.uk>
 */
class Defra_Data_Entry_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate($config) {

		$author_id = 1;


		$data_entry_id = wp_insert_post(
			array(
				'comment_status'	=>	'closed',
				'ping_status'		=>	'closed',
				'post_author'		=>	$author_id,
				'post_name'		=>	'data-entry',
				'post_title'		=>	'Data Entry',
				'post_status'		=>	'publish',
				'post_type'		=>	'page'
			)
		);

		$pages = $config['data_entry_pages'];
		
		foreach ($pages as $page) {

			$title = $page['title'];
			$slug = $page['slug'];

			// If the page doesn't already exist, then create it
			if( null == get_page_by_title( $title ) ) {
		
				// Set the post ID so that we know the post was created successfully
				$post_id = wp_insert_post(
					array(
						'comment_status'	=>	'closed',
						'ping_status'		=>	'closed',
						'post_author'		=>	$author_id,
						'post_name'		=>	$slug,
						'post_title'		=>	$title,
						'post_status'		=>	'publish',
						'post_type'		=>	'page',
						'post_parent'		=>	$data_entry_id
					)
				);
		
			// Otherwise, we'll stop
			} else {
		
	    		// Arbitrarily use -2 to indicate that the page with the title already exists
	    		$users_page = -2;
		
			} // end if

			if(!empty($page['child'])) {
				foreach($page['child'] as $child) {

					$subslug = $child['slug'];
					$subtitle = $child['title'];

					// If the page doesn't already exist, then create it
					if( null == get_page_by_title( $subtitle ) ) {

						// Set the post ID so that we know the post was created successfully
						$sub_post_id = wp_insert_post(
							array(
								'comment_status'	=>	'closed',
								'ping_status'		=>	'closed',
								'post_author'		=>	$author_id,
								'post_name'		=>	$subslug,
								'post_title'		=>	$subtitle,
								'post_status'		=>	'publish',
								'post_type'		=>	'page',
								'post_parent'		=>	$post_id
							)
						);

					}

				}
			}

		}

		// set menus and locations
		// foreach($config["menu_navigation"] as $navmenu) {
		// 	$menu_name = $navmenu['name'];
		// 	$menu_location = $navmenu['location'];

		// 	$menu_id = wp_create_nav_menu( $menu_name );

		// 	if ( ! is_wp_error( $menu_id ) ) {
		// 		// Menu created successfully, now assign it to the menu location
		// 		$menu_location_id = get_term_by( 'slug', $menu_location, 'nav_menu' );
		// 		if ( $menu_location_id ) {
		// 			$locations = get_theme_mod( 'nav_menu_locations' );
		// 			$locations[ $menu_location_id->slug ] = $menu_id;
		// 			set_theme_mod( 'nav_menu_locations', $locations );
		// 		}
		// 	}

		// 	// set pages up in menus
		// 	foreach ($pages as $page) {
		
		// 		$title = $page['title'];
		// 		$slug = $page['slug'];
	
		// 		// If the page doesn't already exist, then create it
		// 		$page_object = get_page_by_title( $title );
				
		// 		$menu_item_data = array(
		// 			'menu-item-object-id' => $page_object->ID,
		// 			'menu-item-object' => 'page',
		// 			'menu-item-type' => 'post_type',
		// 			'menu-item-status' => 'publish',
		// 		);
				
		// 		if($menu_location == 'data-entry') {
		// 			wp_update_nav_menu_item( $menu_id, 0, $menu_item_data );
		// 			if(!empty($page['child'])) {
		// 				foreach($page['child'] as $child) {
		// 					$subslug = $child['slug'];
		// 					$subtitle = $child['title'];
		// 					$subpage_object = get_page_by_title( $subtitle );

		// 					$submenu_item_data = array(
		// 						'menu-item-object-id' => $subpage_object->ID,
		// 						'menu-item-object' => 'page',
		// 						'menu-item-parent-id' => $page_object->ID,
		// 						'menu-item-type' => 'post_type',
		// 						'menu-item-title' => $subtitle,
		// 						'menu-item-status' => 'publish',
		// 						'menu-item-position' => 1
		// 					);
		// 					wp_update_nav_menu_item( $menu_id, 0, $submenu_item_data );
			
		// 				}
		// 			}

		// 		}

		// 	}
		// }

		


		// create array of caps per type
		$manufacturer_caps = array(
			'edit_post' => 'edit_manufacturer',
			'read_post' => 'read_manufacturers',
			//'delete_post' => 'delete_manufacturer',

			'edit_posts' => 'edit_manufacturers',
			'edit_others_posts' => 'edit_others_manufacturers',
			'publish_posts' => 'publish_manufacturers',
			'read_private_posts' => 'read_private_manufacturers',
		);

		// create array of caps per type
		$fuel_caps = array(
			'edit_post' => 'edit_fuel',
			'read_post' => 'read_fuels',
			//'delete_post' => 'delete_fuel',

			'edit_posts' => 'edit_fuels',
			'edit_others_posts' => 'edit_others_fuels',
			'publish_posts' => 'publish_fuels',
			'read_private_posts' => 'read_private_fuels',
		);

		// create array of caps per type
		$appliance_caps = array(
			'edit_post' => 'edit_appliance',
			'read_post' => 'read_appliances',
			//'delete_post' => 'delete_appliance',

			'edit_posts' => 'edit_appliances',
			'edit_others_posts' => 'edit_others_appliances',
			'publish_posts' => 'publish_appliances',
			'read_private_posts' => 'read_private_appliances',
		);

		$statutory_instrument_caps = array(
			'edit_post' => 'edit_statutory_instrument',
			'read_post' => 'read_statutory_instruments',
			//'delete_post' => 'delete_statutory_instrument',

			'edit_posts' => 'edit_statutory_instruments',
			'edit_others_posts' => 'edit_others_statutory_instruments',
			'publish_posts' => 'publish_statutory_instruments',
			'read_private_posts' => 'read_private_statutory_instruments',
		);
		$permitted_fuel_caps = array(
			'edit_post' => 'edit_permitted_fuel',
			'read_post' => 'read_permitted_fuels',
			//'delete_post' => 'delete_permitted_fuel',

			'edit_posts' => 'edit_permitted_fuels',
			'edit_others_posts' => 'edit_others_permitted_fuels',
			'publish_posts' => 'publish_permitted_fuels',
			'read_private_posts' => 'read_private_permitted_fuels',
		);

		$administrator = get_role('administrator');
		
		// create the role
		$data_entry = add_role(
			'data_entry',
			'Data Entry',
			array(
				'read' => true
			)
		);

		$data_reviewer = add_role(
			'data_reviewer',
			'Data Reveiwer',
			array(
				'read' => true
			)
		);

		$data_approver = add_role(
			'data_approver',
			'Data Approver',
			array(
				'read' => true
			)
		);

		// get the role
		$data_entry_role = get_role('data_entry');
		$data_reviewer_role = get_role('data_reviewer');
		$data_approver_role = get_role('data_approver');

		// add the caps to the role
		foreach ($manufacturer_caps as $manufacturer_cap) {
			$data_entry_role->add_cap($manufacturer_cap);
			$administrator->add_cap($manufacturer_cap);
		}
		foreach ($fuel_caps as $fuel_cap) {
			$data_entry_role->add_cap($fuel_cap);
			$administrator->add_cap($fuel_cap);

		}
		foreach ($appliance_caps as $appliance_cap) {
			$data_entry_role->add_cap($appliance_cap);
			$data_reviewer_role->add_cap($appliance_cap);
			$data_approver_role->add_cap($appliance_cap);
			$administrator->add_cap($appliance_cap);
		}
		foreach ($statutory_instrument_caps as $statutory_instrument_cap) {
			$data_entry_role->add_cap($statutory_instrument_cap);
			$administrator->add_cap($statutory_instrument_cap);
		}
		foreach ($permitted_fuel_caps as $permitted_fuel_cap) {
			$data_entry_role->add_cap($permitted_fuel_cap);
			$administrator->add_cap($permitted_fuel_cap);
		}

		$data_entry_role->remove_cap('publish_manufacturers');		
		$data_entry_role->remove_cap('publish_fuels');		
		$data_entry_role->remove_cap('publish_appliances');		
		$data_entry_role->remove_cap('publish_statutory_instruments');		
		$data_entry_role->remove_cap('publish_permitted_fuels');

		$data_reviewer_role->remove_cap('publish_manufacturers');		
		$data_reviewer_role->remove_cap('publish_fuels');		
		$data_reviewer_role->remove_cap('publish_appliances');		
		$data_reviewer_role->remove_cap('publish_statutory_instruments');		
		$data_reviewer_role->remove_cap('publish_permitted_fuels');

		$administrator->add_cap('delete_manufacturer');
		$administrator->add_cap('delete_fuel');
		$administrator->add_cap('delete_appliance');
		$administrator->add_cap('delete_statutory_instrument');
		$administrator->add_cap('delete_permitted_fuel');
		

		$super_user = add_role( 'super_user', 'Super User', get_role( 'administrator' )->capabilities );

		$brian = get_user_by( 'id', 58 );
		$brian->add_role('data_reviewer');

		$calvin = get_user_by( 'id', 60 );
		$calvin->add_role('data_reviewer');
		$calvin->add_role('data_entry');


	}

}
