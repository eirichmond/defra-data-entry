<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://squareone.software
 * @since             1.0.0
 * @package           Defra_Data_Entry
 *
 * @wordpress-plugin
 * Plugin Name:       Defra Data Entry
 * Plugin URI:        https://www.hetas.co.uk
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            Elliott Richmond
 * Author URI:        https://squareone.software
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       defra-data-entry
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

define( 'DEFRA_DATA_ENTRY_NAME', 'Defra Data Entry' );
/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'DEFRA_DATA_ENTRY_VERSION', '1.0.0' );

function config_setup() {

	$config = array(
		'data_entry_pages' => array(
			array(
				'title' => 'Dashboard',
				'slug' => 'dashboard',
				'template' => 'partials/data-entry/dashboard.php'
			),
			array(
				'title' => 'Appliances',
				'slug' => 'appliances',
				'template' => 'partials/data-entry/appliances.php',
				'child' => array(
					array(
						'title' => 'Appliance View',
						'slug' => 'appliance-view',
						'template' => 'partials/data-entry/appliance-view.php',	
					),
					array(
						'title' => 'Appliance Audit Log',
						'slug' => 'appliance-audit-log',
						'template' => 'partials/data-entry/appliance-audit-log.php',	
					),
					array(
						'title' => 'Appliance Change Log',
						'slug' => 'appliance-change-log',
						'template' => 'partials/data-entry/appliance-change-log.php',	
					),
					array(
						'title' => 'Create new appliance',
						'slug' => 'create-new-appliance',
						'template' => 'partials/data-entry/create-new-appliance.php',	
					),
					array(
						'title' => 'Update appliance',
						'slug' => 'update-appliance',
						'template' => 'partials/data-entry/update-appliance.php',	
					)
				) 
			),
			array(
				'title' => 'Fuels',
				'slug' => 'fuels',
				'template' => 'partials/data-entry/fuels.php',
				'child' => array(
					array(
						'title' => 'Fuel View',
						'slug' => 'fuel-view',
						'template' => 'partials/data-entry/fuel-view.php',	
					),
					array(
						'title' => 'Fuel Audit Log',
						'slug' => 'fuel-audit-log',
						'template' => 'partials/data-entry/fuel-audit-log.php',	
					),
					array(
						'title' => 'Fuel Change Log',
						'slug' => 'fuel-change-log',
						'template' => 'partials/data-entry/fuel-change-log.php',	
					),
					array(
						'title' => 'Create new fuel',
						'slug' => 'create-new-fuel',
						'template' => 'partials/data-entry/create-new-fuel.php',
					),
					array(
						'title' => 'Update fuel',
						'slug' => 'update-fuel',
						'template' => 'partials/data-entry/update-fuel.php',	
					)
				)
			),
			array(
				'title' => 'Manufacturers',
				'slug' => 'manufacturers',
				'template' => 'partials/data-entry/manufacturers.php',
				'child' => array(
					array(
						'title' => 'Create new Manufacturer',
						'slug' => 'create-new-manufacturer',
						'template' => 'partials/data-entry/create-new-manufacturer.php',
					)
				)
			),
			array(
				'title' => 'Statutory Instruments',
				'slug' => 'si',
				'template' => 'partials/data-entry/si.php',
				'child' => array(
					array(
						'title' => 'Create new SI',
						'slug' => 'create-new-si',
						'template' => 'partials/data-entry/create-new-si.php'
					),
					array(
						'title' => 'SI Appliance',
						'slug' => 'si-appliance',
						'template' => 'partials/data-entry/si-appliance.php'
					),
					array(
						'title' => 'SI Fuel',
						'slug' => 'si-fuel',
						'template' => 'partials/data-entry/si-fuel.php',	
					)
				)
			),
			array(
				'title' => 'Permitted Fuels',
				'slug' => 'permitted-fuels',
				'template' => 'partials/data-entry/permitted-fuels.php',
				'child' => array(
					array(
						'title' => 'Create new Permitted Fuel',
						'slug' => 'create-new-permitted-fuel',
						'template' => 'partials/create-new-permitted-fuel.php'
					)
				)
			),
			array(
				'title' => 'Additional Conditions',
				'slug' => 'additionalconditions',
				'template' => 'partials/data-entry/additionalconditions.php',
				'child' => array(
					array(
						'title' => 'Create new Additional Condition',
						'slug' => 'create-new-additional-condition',
						'template' => 'partials/data-entry/create-new-additional-condition.php'
					)
				)
			),
			array(
				'title' => 'Appliance Types',
				'slug' => 'appliance-types',
				'template' => 'partials/data-entry/appliance-types.php',
				'child' => array(
					array(
						'title' => 'Create new Appliance Type',
						'slug' => 'create-new-appliance-type',
						'template' => 'partials/data-entry/create-new-appliance-type.php'
					)
				)

			),
			array(
				'title' => 'Fuel Types',
				'slug' => 'fuel-types',
				'template' => 'partials/data-entry/fuel-types.php',
				'child' => array(
					array(
						'title' => 'Create new Fuel Type',
						'slug' => 'create-new-fuel-type',
						'template' => 'partials/data-entry/create-new-fuel-type.php'
					)
				)

			),
			array(
				'title' => 'Form Process',
				'slug' => 'form-process',
				'template' => 'partials/form-process.php',
			),

		),
		'menu_navigation' => array(
			array(
				'name' => 'Data Entry',
				'location' => 'data-entry'
			),
			array(
				'name' => 'Data Reviewer',
				'location' => 'data-reviewer'
			),
			array(
				'name' => 'Data Approver',
				'location' => 'data-approver'
			)
		)
	);

	return $config;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-defra-data-entry-activator.php
 */
function activate_defra_data_entry() {
	$config = config_setup();
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-defra-data-entry-activator.php';
	Defra_Data_Entry_Activator::activate($config);
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-defra-data-entry-deactivator.php
 */
function deactivate_defra_data_entry() {
	$config = config_setup();
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-defra-data-entry-deactivator.php';
	Defra_Data_Entry_Deactivator::deactivate($config);
}

register_activation_hook( __FILE__, 'activate_defra_data_entry' );
register_deactivation_hook( __FILE__, 'deactivate_defra_data_entry' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-defra-data-entry.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_defra_data_entry() {

	$plugin = new Defra_Data_Entry();
	$plugin->run();

}
run_defra_data_entry();
