<?php

/**
 * The file that defines the audit logs.
 *
 * @link       https://squareone.software
 * @since      1.0.0
 *
 * @package    Defra_Data_Audit_Log
 * @subpackage Defra_Data_Audit_Log/includes
 */

/**
 *
 * @since      1.0.0
 * @package    Defra_Data_Audit_Log
 * @subpackage Defra_Data_Audit_Log/includes
 * @author     Elliott Richmond <elliott@squareonemd.co.uk>
 */
class Defra_Data_Audit_Log {
	
	private $db;

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
		global $wpdb;
        $this->db = $wpdb;
	}

	/**
	 * Set and insert an audit log
	 *
	 * @param int $user_id
	 * @param int $post_id
	 * @param array $post_data
	 * @return void
	 */
    public function defra_audit_log($user_id, $related_entity, $post_id, $message, $ip_address) {
        // Get the current date and time
        $timestamp = current_time('mysql');

        // Prepare the data for insertion
        $data = array(
            'user_id' => $user_id,
            'related_entity' => $related_entity,
            'related_id' => $post_id,
            'message' => $message,
            'ip_address' => $ip_address,
            'created_date' => $timestamp,
        );

        // Insert data into the database table
        $result = $this->db->insert(
			'wp_defra_audit_log_new',
			$data
		);

        return $result !== false;
    }

	public function set_appliance_audit_data($user_id, $post_id, $post_data) {
		// Prefix to match
		$prefix = 'exempt-in_country_and_statutory_instrument_';

		// Use array_filter to pluck elements with matching keys
		$filtered_array = array_filter(
			$post_data,
			function ($key) use ($prefix) {
				return strpos($key, $prefix) === 0; // Check if the key starts with the specified prefix
			},
			ARRAY_FILTER_USE_KEY
		);
		
		if($post_data["submit-type"] == 'save-draft') {
			$this->defra_audit_log( $user_id, 'appliance', $post_id, 'New appliance created', $_SERVER['REMOTE_ADDR']);
		} else {
			$this->defra_audit_log( $user_id, 'appliance', $post_id, 'Appliance saved', $_SERVER['REMOTE_ADDR']);
			$this->defra_audit_log( $user_id, 'appliance_country', $post_id, 'Changed appliance to status_id: (20) Awaiting Review', $_SERVER['REMOTE_ADDR']);
		}
		foreach($filtered_array as $key => $value) {
			if (strpos($key, 'england_enabled') !== false) {
				$this->defra_audit_log( $user_id, 'appliance_country', $post_id, 'Exemption country england_exemptin selected', $_SERVER['REMOTE_ADDR']);
			}
			if (strpos($key, 'england_si') !== false) {
				$si = get_post($filtered_array["exempt-in_country_and_statutory_instrument_england_si"][0]);
				$this->defra_audit_log( $user_id, 'appliance_country_and_si', $post_id, 'si_england saved as Appliance SI: '.$si->post_title, $_SERVER['REMOTE_ADDR']);
			}
			if (strpos($key, 'wales_enabled') !== false) {
				$this->defra_audit_log( $user_id, 'appliance_country', $post_id, 'Exemption country wales_exemptin selected', $_SERVER['REMOTE_ADDR']);
			}
			if (strpos($key, 'wales_si') !== false) {
				$si = get_post($filtered_array["exempt-in_country_and_statutory_instrument_wales_si"][0]);
				$this->defra_audit_log( $user_id, 'appliance_country_and_si', $post_id, 'si_wales saved as Appliance SI: '.$si->post_title, $_SERVER['REMOTE_ADDR']);
			}
			if (strpos($key, 'scotland_enabled') !== false) {
				$this->defra_audit_log( $user_id, 'appliance_country', $post_id, 'Exemption country scotland_exemptin selected', $_SERVER['REMOTE_ADDR']);
			}
			if (strpos($key, 'scotland_si') !== false) {
				$si = get_post($filtered_array["exempt-in_country_and_statutory_instrument_scotland_si"][0]);
				$this->defra_audit_log( $user_id, 'appliance_country_and_si', $post_id, 'si_scotland saved as Appliance SI: '.$si->post_title, $_SERVER['REMOTE_ADDR']);
			}
			if (strpos($key, 'n_ireland_enabled') !== false) {
				$this->defra_audit_log( $user_id, 'appliance_country', $post_id, 'Exemption country n_ireland_exemptin selected', $_SERVER['REMOTE_ADDR']);
			}
			if (strpos($key, 'n_ireland_si') !== false) {
				$si = get_post($filtered_array["exempt-in_country_and_statutory_instrument_n_ireland_si"][0]);
				$this->defra_audit_log( $user_id, 'appliance_country_and_si', $post_id, 'si_northernireland saved as Appliance SI: '.$si->post_title, $_SERVER['REMOTE_ADDR']);
			}
		}
	}


}
