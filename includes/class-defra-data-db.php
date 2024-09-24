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
 * @package    Defra_Data_DB_Requests
 * @subpackage Defra_Data_DB_Requests/includes
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
 * @package    Defra_Data_DB_Requests
 * @subpackage Defra_Data_DB_Requests/includes
 * @author     Elliott Richmond <elliott@squareonemd.co.uk>
 */
class Defra_Data_DB_Requests {

    /**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $data;

	protected $wpdb;

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
		$this->wpdb = $wpdb;
	}

	/**
	 * Get appliance revoked
	 *
	 * @param string $status
	 * @return array $results
	 */

	public function get_appliance_is_revoked_is_published() {
		global $wpdb;
		$results = $wpdb->get_results(
			$wpdb->prepare(
				"SELECT pm.post_id
				FROM wp_postmeta pm
				LEFT JOIN wp_posts p ON pm.post_id = p.ID
				WHERE p.post_type = %s
				AND pm.meta_key LIKE %s
				AND pm.meta_value = %s
				GROUP BY pm.post_id",
				array('appliances', '%_is_revoked', '1')
			)
		);
		return $results;
	}

	/**
	 * Get appliance cancel status by cancel status id
	 *
	 * @param [type] $cancel_status
	 * @return void
	 */
	public function get_appliance_cancel_status($cancel_status) {
		global $wpdb;
		$results = $wpdb->get_results(
			$wpdb->prepare(
				"SELECT pm.post_id
				FROM wp_postmeta pm
				LEFT JOIN wp_posts p ON pm.post_id = p.ID
				WHERE p.post_type = %s
				AND pm.meta_key LIKE %s AND pm.meta_value = %s
				GROUP BY pm.post_id",
				array('appliances', '%_cancel_status_id', $cancel_status)
			)
		);
		return $results;

	}

	/**
	 * Get appliance status
	 * 
	 * Test case ref not working 50846 new case test 50848
	 *
	 * @param string $status
	 * @return array $results
	 */
    public function get_post_country_status( $post_type, $status = null, $country = null ) {

		$countries = array(
			'1' => 'exempt-in_country_and_statutory_instrument_england_enabled',
			'2' => 'exempt-in_country_and_statutory_instrument_wales_enabled',
			'3' => 'exempt-in_country_and_statutory_instrument_scotland_enabled',
			'4' => 'exempt-in_country_and_statutory_instrument_n_ireland_enabled',
		);
		$statuses = array(
			'1' => 'exempt-in_country_and_statutory_instrument_england_status',
			'2' => 'exempt-in_country_and_statutory_instrument_wales_status',
			'3' => 'exempt-in_country_and_statutory_instrument_scotland_status',
			'4' => 'exempt-in_country_and_statutory_instrument_n_ireland_status',
		);

        global $wpdb;
		if(empty($country) && !empty($status)) {
			$results = $wpdb->get_results(
				$wpdb->prepare(
					"SELECT DISTINCT pm.post_id
					FROM wp_postmeta pm
					LEFT JOIN wp_posts p ON pm.post_id = p.ID
					WHERE pm.meta_key LIKE %s
					AND pm.meta_value LIKE %s
					AND p.post_type = %s",
					array('%_status', $status, $post_type)
				)
		
			);
		} else {
			$results = $wpdb->get_results(
				$wpdb->prepare(
					"SELECT
						p.ID AS post_id,
						p.post_title
					FROM
						wp_posts p
					INNER JOIN
						wp_postmeta m1 ON (p.ID = m1.post_id AND m1.meta_key = %s AND m1.meta_value = '1')
					INNER JOIN
						wp_postmeta m2 ON (p.ID = m2.post_id AND m2.meta_key = %s AND m2.meta_value = %s)
					WHERE
						p.post_type = %s
					ORDER BY
						p.ID DESC;",
					array( $countries[$country], $statuses[$country], $status, $post_type )
				)
			);
		}
        return $results;
    }
	
	/**
	 * Get fuels status
	 *
	 * @param string $status
	 * @return array $results
	 */
    public function get_fuels_country_status($status = null) {
        global $wpdb;
		if(empty($status)) {
			$results = $wpdb->get_results(
				$wpdb->prepare(
					"SELECT DISTINCT pm.post_id
					FROM wp_postmeta pm
					LEFT JOIN wp_posts p ON pm.post_id = p.ID
					WHERE pm.meta_key LIKE %s
					AND p.post_type = 'fuels'",
					array('%_status')
				)
			);
		} else {
			$results = $wpdb->get_results(
				$wpdb->prepare(
					"SELECT DISTINCT pm.post_id
					FROM wp_postmeta pm
					LEFT JOIN wp_posts p ON pm.post_id = p.ID
					WHERE pm.meta_key LIKE %s
					AND pm.meta_value = %d
					AND p.post_type = 'fuels'",
					array('%_status',$status)
				)
			);
		}
        return $results;
    }

	/**
	 * Get the General Audit log by the appliance post id
	 *
	 * @param int $post_id
	 * @return object $audit_logs
	 */
	public function get_general_audit_log($post_id, $related){
		global $wpdb;
		$audit_logs = $wpdb->get_results(
			$wpdb->prepare(
				"SELECT *
				FROM wp_defra_audit_log_new al
				WHERE al.related_id = %d
				AND al.related_entity LIKE %s",
				array($post_id, $related.'%')
			)
		);
		return $audit_logs;
	}

	/**
	 * Get the General history log by the appliance post id
	 *
	 * @param int $post_id
	 * @return object $audit_logs
	 */
	public function get_general_history_log($post_id){
		global $wpdb;
		$history_logs = $wpdb->get_results(
			$wpdb->prepare(
				"SELECT *
				FROM wp_defra_history_appliance_new hl
				WHERE hl.appliance_id = %d",
				array($post_id)
			)
		);
		return $history_logs;
	}
	
	/**
	 * Get fuel comments
	 *
	 * @param string $ref_id
	 * @return array $results
	 */

	public function get_comments($table, $col_key, $ref_id) {
		global $wpdb;
		$results = $wpdb->get_results(
            "SELECT *
            FROM `wp_$table`
            WHERE `$col_key` = '$ref_id'"
        );
        return $results;

	}

	/**
	 * List and combine data for all fuels
	 *
	 * @return array $list_fuels
	 */
	public function list_fuels() {
		$list_fuels = array();
		$defra_fuels = $this->defra_fuels();
		$defra_fuel_countries = $this->defra_fuel_country();
		$defra_countries = $this->defra_exemption_countries();
		foreach($defra_fuels as $k => $v) {
			$countries = $this->defra_fuel_country_by_id($v->fuel_id);
			$list_fuels[$v->fuel_id]['fuel_id'] = $v->fuel_id;
			$list_fuels[$v->fuel_id]['fuel_name'] = $v->fuel_name;
			$list_fuels[$v->fuel_id]['status'] = $this->get_status_by_country($defra_countries, $countries);
			$list_fuels[$v->fuel_id]['info'] = $this->appliance_info_by_user($v);
		}
        return $list_fuels;

	}

	/**
	 * List and combine data for all appliances
	 *
	 * @return array $list_appliances
	 */
	public function list_appliances() {
		$list_appliances = array();
		$defra_appliances = $this->defra_appliances();
		$defra_appliance_countries = $this->defra_appliance_country();
		$defra_countries = $this->defra_exemption_countries();
		foreach($defra_appliances as $k => $v) {
			$countries = $this->defra_appliance_country_by_id($v->appliance_id);
			$list_appliances[$v->appliance_id]['appliance_id'] = $v->appliance_id;
			$list_appliances[$v->appliance_id]['appliance_name'] = $v->appliance_name;
			$list_appliances[$v->appliance_id]['status'] = $this->get_status_by_country($defra_countries, $countries);
			$list_appliances[$v->appliance_id]['info'] = $this->appliance_info_by_user($v);
		}
        return $list_appliances;

	}

	/**
	 * List and combine data for all appliance types
	 *
	 * @return array $list_fuel_sis
	 */
	public function list_fuel_sis() {
		$list_fuel_sis = array();
		$defra_fuel_sis = $this->get_fuel_sis();
		foreach($defra_fuel_sis as $k => $v) {
			$list_fuel_sis[$v->fsi_id]['fuel_si_id'] = $v->fsi_id;
			$list_fuel_sis[$v->fsi_id]['fuel_si_number'] = $v->si_number;
			$list_fuel_sis[$v->fsi_id]['fuel_si_link'] = $v->si_link;
		}
        return $list_fuel_sis;

	}

	/**
	 * List and combine data for all appliance types
	 *
	 * @return array $list_appliance_sis
	 */
	public function list_appliance_sis() {
		$list_appliance_sis = array();
		$defra_appliance_sis = $this->get_appliance_sis();
		foreach($defra_appliance_sis as $k => $v) {
			$list_appliance_sis[$v->asi_id]['appliance_si_id'] = $v->asi_id;
			$list_appliance_sis[$v->asi_id]['appliance_si_number'] = $v->si_number;
			$list_appliance_sis[$v->asi_id]['appliance_si_link'] = $v->si_link;
		}
        return $list_appliance_sis;

	}

	/**
	 * List and combine data for all appliance types
	 *
	 * @return array $list_appliance_types
	 */
	public function list_permitted_fuels() {
		$list_permitted_fuels = array();
		$permitted_fuels = get_terms( array( 'taxonomy' => 'permitted_fuels', 'hide_empty' => false ) );
		foreach($permitted_fuels as $k => $v) {
			$list_permitted_fuels[$v->term_id]['permitted_fuel_id'] = $v->term_id;
			$list_permitted_fuels[$v->term_id]['permitted_fuel_name'] = $v->description;
		}
        return $list_permitted_fuels;

	}


	
	/**
	 * List and combine data for all appliance types
	 *
	 * @return array $list_appliance_types
	 */
	public function list_additional_conditions() {
		$list_additional_conditions = array();
		$defra_additional_conditions = $this->get_additional_conditions();
		foreach($defra_additional_conditions as $k => $v) {
			$list_additional_conditions[$v->id]['additional_condition_id'] = $v->id;
			$list_additional_conditions[$v->id]['additional_condition_name'] = $v->condition_name;
		}
        return $list_additional_conditions;

	}

	/**
	 * List and combine data for all appliance types
	 *
	 * @return array $list_appliance_types
	 */
	public function list_appliance_types() {
		$list_appliance_types = array();
		$defra_appliance_types = $this->get_appliance_types();
		foreach($defra_appliance_types as $k => $v) {
			$list_appliance_types[$v->term_id]['term_id'] = $v->term_id;
			$list_appliance_types[$v->term_id]['name'] = $v->name;
		}
        return $list_appliance_types;

	}

	/**
	 * List and combine data for all fuel types
	 *
	 * @return array $list_manufacturers
	 */
	public function list_fuel_types() {
		$list_fuel_types = array();
		$defra_fuel_types = $this->get_fuel_types();
		foreach($defra_fuel_types as $k => $v) {
			$list_fuel_types[$v->id]['fuel_type_id'] = $v->id;
			$list_fuel_types[$v->id]['fuel_type_name'] = $v->name;
		}
        return $list_fuel_types;

	}


	/**
	 * List and combine data for all appliances
	 *
	 * @return array $list_manufacturers
	 */
	public function list_manufacturers( $term = null ) {
		$list_manufacturers = array();
		$defra_manufacturers = $this->get_manufacturers( $term );
		foreach($defra_manufacturers as $k => $v) {
			$list_manufacturers[$v->ID]['manufacturer_id'] = $v->ID;
			$list_manufacturers[$v->ID]['manufacturer_name'] = $v->post_title;
			$list_manufacturers[$v->ID]['manufacturer_address'] = $this->composite_address($v);
			$list_manufacturers[$v->ID]['manufacturer_action'] = $v->format_type; // unknown what this is currently used for
		}
        return $list_manufacturers;

	}

	public function composite_address($object) {

		$address = array();
		$address[] = get_post_meta( $object->ID, 'address_1', true );
		$address[] = get_post_meta( $object->ID, 'address_2', true );
		$address[] = get_post_meta( $object->ID, 'address_3', true );
		$address[] = get_post_meta( $object->ID, 'address_4', true );
		$address[] = get_post_meta( $object->ID, 'town__city', true );
		$address[] = get_post_meta( $object->ID, 'county', true );
		$address[] = get_post_meta( $object->ID, 'postcode', true );

		$address = array_filter($address);

		$composite = join(',',$address);
		return $composite;
	}

	/**
	 * get view data for appliance
	 *
	 * @return object $defra_appliance
	 */
	public function view_appliance() {
		$id = $_GET['appliance-id'];
		$appliance = $this->get_appliance_by_id($id);
		$permitted_fuel_ids = $this->get_permitted_fuel_ids($id);
		$manufacturer = $this->get_manufacturer_by_id($appliance->manufacturer_id);
		return $appliance;
	}

	/**
	 * Get appliance record from database
	 *
	 * @param string $id
	 * @return array $result
	 */
	public function get_appliance_by_id($id) {
		global $wpdb;
        $result = $wpdb->get_results(
            "SELECT *
            FROM `wp_defra_appliance`
			WHERE `appliance_id` = $id
			"
        );
		return $result[0];

	}

	

	/**
	 * Get appliance types 
	 *
	 * @param string $id
	 * @return array $results
	 */
	public function get_fuel_sis() {
		global $wpdb;
        $results = $wpdb->get_results(
            "SELECT *
            FROM `wp_defra_fuel_si`
			"
        );
		return $results;

	}


	/**
	 * Get appliance types 
	 *
	 * @param string $id
	 * @return array $results
	 */
	public function get_appliance_sis() {
		global $wpdb;
        $results = $wpdb->get_results(
            "SELECT *
            FROM `wp_defra_appliance_si`
			"
        );
		return $results;

	}

	/**
	 * Get appliance types 
	 *
	 * @param string $id
	 * @return array $results
	 */
	public function get_permitted_fuels() {
		global $wpdb;
        $results = $wpdb->get_results(
            "SELECT *
            FROM `wp_defra_permitted_fuels`
			",
			OBJECT_K
        );

		// logic changed back to original for data import
		// $args = array(
		// 	'numberposts' => -1,
		// 	'post_type' => 'permitted_fuels',
		// 	'post_status' => 'publish'
		// );
		// $results = get_posts( $args );
		
		
		return $results;

	}

	/**
	 * Get appliance types 
	 *
	 * @param string $id
	 * @return array $results
	 */
	public function get_additional_conditions() {
		global $wpdb;
        $results = $wpdb->get_results(
            "SELECT *
            FROM `wp_defra_additional_conditions`
			",
			OBJECT_K
        );
		return $results;

	}

	/**
	 * Get appliance types 
	 *
	 * @param string $id
	 * @return array $results
	 */
	public function get_appliance_types() {

		$taxonomy = 'appliance_types';
		$terms = get_terms( array(
			'taxonomy' => $taxonomy, 
			'hide_empty' => true,
		) );

		return $terms;
		// global $wpdb;
        // $results = $wpdb->get_results(
        //     "SELECT *
        //     FROM `wp_defra_appliance_types`
		// 	"
        // );
		// return $results;

	}


	/**
	 * Get fuel types 
	 *
	 * @param string $id
	 * @return array $results
	 */
	public function get_fuel_types() {
		global $wpdb;
        $results = $wpdb->get_results(
            "SELECT *
            FROM `wp_defra_fuel_types`
			"
        );
		return $results;

	}

	/**
	 * Get manufacturers 
	 *
	 * @param string $id
	 * @return array $results
	 */
	public function get_manufacturers( $term = null ) {
		// create a standard array for other references
		$args = array(
			'numberposts' => -1,
			'post_type' => 'manufacturers',
			'post_status' => 'publish'
		);

		// if term exists then append to the array
		if( $term ) {
			$args['tax_query'] = array(
				array(
					'taxonomy' => 'manufacturer_types',
					'field'    => 'slug',
					'terms'    => $term,
				),
			);
		}

		$results = get_posts( $args );
		return $results;

	}

	/**
	 * Get manufacturer record by it
	 *
	 * @param string $id
	 * @return array $results
	 */
	public function get_manufacturer_by_id($id) {
		global $wpdb;
        $result = $wpdb->get_results(
            "SELECT *
            FROM `wp_defra_manufacturers`
			WHERE `id` = $id
			"
        );
		return $result[0];

	}

	public function get_permitted_fuel_ids($id) {
		global $wpdb;
        $result = $wpdb->get_results(
            "SELECT *
            FROM `wp_defra_appliance_permitted_fuels`
			WHERE `appliance_id` = $id
			"
        );
		return $result;

	}

	/**
	 * Appliance user info by appliance object
	 *
	 * @param object $appliance
	 * @return array $array
	 */
	public function appliance_info_by_user($appliance) {
		$array = array();
		$array[0]['user_type'] = 'Entry User';
		$array[0]['user_email'] = $this->get_defra_users_email_by_id($appliance->entry_user_id);
		$array[1]['user_type'] = 'Reviewer User';
		$array[1]['user_email'] = $this->get_defra_users_email_by_id($appliance->reviewer_user_id);
		return $array;
	}

	/**
	 * Map appliance status by country
	 *
	 * @param [type] $defra_countries
	 * @param [type] $countries
	 * @return $array
	 */
	public function get_status_by_country($defra_countries, $countries) {
		$array = array();
		foreach($countries as $k => $v) {
			$array[$k]['country_name'] = $defra_countries[$v->country_id]['country_name'];
			$array[$k]['status'] = $this->get_defra_status($v->status_id);
		}
		return $array;
	}

	/**
	 * Get status name by id from db
	 *
	 * @param string $status_id
	 * @return void
	 */
	public function get_defra_status($status_id) {
		global $wpdb;
        $results = $wpdb->get_results(
            "SELECT *
            FROM `wp_defra_status`
			WHERE `id` = $status_id
			"
        );
		return $results[0]->status_name;

	}


	/**
	 * Get users email by id from db
	 *
	 * @param string $status_id
	 * @return void
	 */
	public function get_defra_users_email_by_id($user_id) {
		if(null == $user_id) {
			return 'no email address';
		}
		global $wpdb;
        $results = $wpdb->get_results(
            "SELECT *
            FROM `wp_defra_user`
			WHERE `id` = $user_id"
        );
		return $results[0]->email_address;

	}
	/**
	 * Extract all appliances from database
	 *
	 * @return void
	 */
	public function defra_appliances(){
		global $wpdb;
        $results = $wpdb->get_results(
            "SELECT *
            FROM `wp_defra_appliance`
			"
        );
		return $results;
	}

	/**
	 * Extract all fuels from database
	 *
	 * @return void
	 */
	public function defra_fuels(){
		global $wpdb;
        $results = $wpdb->get_results(
            "SELECT *
            FROM `wp_defra_fuel`
			"
        );
		return $results;
	}
	/**
	 * Extract all fuel country table from database
	 *
	 * @return void
	 */
	public function defra_fuel_country(){
		global $wpdb;
        $results = $wpdb->get_results(
            "SELECT *
            FROM `wp_defra_fuel_country`
			"
        );
		return $results;
	}

	/**
	 * Extract all appliance country table from database
	 *
	 * @return void
	 */
	public function defra_appliance_country(){
		global $wpdb;
        $results = $wpdb->get_results(
            "SELECT *
            FROM `wp_defra_appliance_country`
			"
        );
		return $results;
	}

	/**
	 * Extract appliance countries by appliance_id from database
	 *
	 * @return void
	 */
	public function defra_fuel_country_by_id($fuel_id){
		global $wpdb;
        $results = $wpdb->get_results(
            "SELECT *
            FROM `wp_defra_fuel_country`
			WHERE `fuel_id` = $fuel_id
			"
        );
		return $results;
	}

	/**
	 * Extract appliance countries by appliance_id from database
	 *
	 * @return void
	 */
	public function defra_appliance_country_by_id($appliance_id){
		global $wpdb;
        $results = $wpdb->get_results(
            "SELECT *
            FROM `wp_defra_appliance_country`
			WHERE `appliance_id` = $appliance_id
			"
        );
		return $results;
	}

	/**
	 * Get exemption countires
	 *
	 * @return void
	 */
	public function defra_exemption_countries() {
		$countries = array();
		global $wpdb;
        $results = $wpdb->get_results(
            "SELECT *
            FROM `wp_defra_exemption_countries`
			"
        );
		foreach($results as $k => $v) {
			$countries[$v->country_id]['country_id'] = $v->country_id;
			$countries[$v->country_id]['country_name'] = $v->country_name;
			$countries[$v->country_id]['url_name'] = $v->url_name;
			$countries[$v->country_id]['is_system'] = $v->is_system;
		}
		return $countries;

	}


	/**
	 * Get appliance status
	 *
	 * @param string $status
	 * @return array $results
	 */
    public function get_fuel_country_status($status) {
        global $wpdb;
        $results = $wpdb->get_results(
            "SELECT *
            FROM `wp_defra_fuel_country`
            WHERE `status_id` = '$status'
            ORDER BY `status_id`"
        );
        return $results;
    }

	/**
	 * Count appliance country drafts
	 *
	 * @return string $count
	 */
	public function count_appliance_draft() {
		$count = $this->get_post_country_status( 'appliances', '10' );
		return count($count);
	}

	/**
	 * Count appliance country awaiting review
	 *
	 * @return string $count
	 */
	public function count_appliance_awaiting_review() {
		$count = $this->get_post_country_status( 'appliances', '20' );
		return count($count);
	}

	/**
	 * Count appliance country being reviewed
	 *
	 * @return string $count
	 */
	public function count_appliance_being_reviewed() {
		$count = $this->get_post_country_status( 'appliances', '30' );
		return count($count);
	}

	/**
	 * Count appliance country reviewer rejected
	 *
	 * @return string $count
	 */
	public function count_appliance_reviewer_rejected() {
		$count = $this->get_post_country_status( 'appliances', '40' );
		return count($count);
	}

	/**
	 * Count appliance country submitted to da
	 *
	 * @return string $count
	 */
	public function count_appliance_submitted_to_da($country) {
		$count = $this->get_post_country_status( 'appliances', '50', $country );
		return count($count);
	}
	

	/**
	 * Count appliance country assigned to da
	 *
	 * @return string $count
	 */
	public function count_appliance_assigned_to_da($country) {
		$count = $this->get_post_country_status( 'appliances', '60', $country );
		return count($count);
	}

	/**
	 * Count appliance country approved by da
	 *
	 * @return string $count
	 */
	public function count_appliance_approved_by_da($country) {
		$count = $this->get_post_country_status( 'appliances', '70', $country );
		return count($count);
	}

	/**
	 * Count appliance country rejected by da
	 *
	 * @return string $count
	 */
	public function count_appliance_rejected_by_da($country) {
		$count = $this->get_post_country_status( 'appliances', '80', $country );
		return count($count);
	}

	/**
	 * Count appliance country rejected by da
	 *
	 * @return string $count
	 */
	public function count_cancellation_appliance_submitted_to_da() {
		$count = $this->get_post_country_status( 'appliances',  '90' );
		return count($count);
	}

	/**
	 * Count appliance country rejected by da
	 *
	 * @return string $count
	 */
	public function count_cancellation_appliance_approved_by_da() {
		$count = $this->get_post_country_status( 'appliances', '100' );
		return count($count);
	}

	/**
	 * Count appliance country submitted to da
	 *
	 * @return string $count
	 */
	public function count_revocated_appliance_submitted_to_da() {
		$count = $this->get_post_country_status( 'appliances', '200' );
		return count($count);
	}

	/**
	 * Count appliance country submitted to da
	 *
	 * @return string $count
	 */
	public function count_revocated_appliance_approved_by_da() {
		$count = $this->get_post_country_status( 'appliances', '300' );
		return count($count);
	}

	/**
	 * Count appliance country submitted to da
	 *
	 * @return string $count
	 */
	public function count_revocated_appliance_published() {
		$count = $this->get_post_country_status( 'appliances', '400' );
		return count($count);
	}

	

	/**
	 * Count appliance country awaiting publication
	 *
	 * @return string $count
	 */
	public function count_appliance_awaiting_publication($country) {
		$count = $this->get_post_country_status( 'appliances', '500', $country );
		return count($count);
	}

	/**
	 * Count appliance country published
	 *
	 * @return string $count
	 */
	public function count_appliance_published($country) {
		$count = $this->get_post_country_status( 'appliances', '600', $country );
		return count($count);
	}

	/**
	 * Count appliance revoked and is published
	 *
	 * @return string $count
	 */
	public function count_appliance_is_revoked_is_published($country) {
		$count = $this->get_appliance_is_revoked_is_published();
		return count($count);
	}

	/**
	 * Count appliance canelled status
	 *
	 * @return string $count
	 */
	public function count_appliance_cancel_draft() {
		$count = $this->get_appliance_cancel_status('10');
		return count($count);
	}

	/**
	 * Count appliance canelled status
	 *
	 * @return string $count
	 */
	public function count_appliance_cancel_awaiting_review() {
		$count = $this->get_appliance_cancel_status('20');
		return count($count);
	}

	/**
	 * Count appliance canelled status
	 *
	 * @return string $count
	 */
	public function count_appliance_cancel_being_reviewed() {
		$count = $this->get_appliance_cancel_status('30');
		return count($count);
	}

	/**
	 * Count appliance canelled status
	 *
	 * @return string $count
	 */
	public function count_appliance_cancel_reviewer_rejected() {
		$count = $this->get_appliance_cancel_status('40');
		return count($count);
	}

	/**
	 * Count appliance canelled status
	 *
	 * @return string $count
	 */
	public function count_appliance_cancel_submitted_to_da() {
		$count = $this->get_appliance_cancel_status('50');
		return count($count);
	}

	/**
	 * Count appliance canelled status
	 *
	 * @return string $count
	 */
	public function count_appliance_cancel_assigned_to_da() {
		$count = $this->get_appliance_cancel_status('60');
		return count($count);
	}

	/**
	 * Count appliance canelled status
	 *
	 * @return string $count
	 */
	public function count_appliance_cancel_approved_by_da() {
		$count = $this->get_appliance_cancel_status('70');
		return count($count);
	}

	/**
	 * Count appliance canelled status
	 *
	 * @return string $count
	 */
	public function count_appliance_cancel_rejected_by_da() {
		$count = $this->get_appliance_cancel_status('80');
		return count($count);
	}

	/**
	 * Count appliance canelled status
	 *
	 * @return string $count
	 */
	public function count_appliance_cancel_awaiting_publication() {
		$count = $this->get_appliance_cancel_status('500');
		return count($count);
	}

	/**
	 * Count appliance canelled status
	 *
	 * @return string $count
	 */
	public function count_appliance_cancel_published() {
		$count = $this->get_appliance_cancel_status('600');
		return count($count);
	}

	/**
	 * Count fuel country drafts
	 *
	 * @return string $count
	 */
	public function count_fuel_draft() {
		$count = $this->get_post_country_status( 'fuels', '10');
		return count($count);
	}

	/**
	 * Count fuel country awaiting review
	 *
	 * @return string $count
	 */
	public function count_fuel_awaiting_review() {
		$count = $this->get_post_country_status( 'fuels', '20' );
		return count($count);
	}

	/**
	 * Count fuel country being reviewed
	 *
	 * @return string $count
	 */
	public function count_fuel_being_reviewed() {
		$count = $this->get_post_country_status( 'fuels', '30' );
		return count($count);
	}

	/**
	 * Count fuel country reviewer rejected
	 *
	 * @return string $count
	 */
	public function count_fuel_reviewer_rejected() {
		$count = $this->get_post_country_status( 'fuels', '40' );
		return count($count);
	}

	/**
	 * Count fuel country submitted to da
	 *
	 * @return string $count
	 */
	public function count_fuel_submitted_to_da() {
		$count = $this->get_post_country_status( 'fuels', '50' );
		return count($count);
	}
	

	/**
	 * Count fuel country assigned to da
	 *
	 * @return string $count
	 */
	public function count_fuel_assigned_to_da() {
		$count = $this->get_post_country_status( 'fuels', '60' );
		return count($count);
	}

	/**
	 * Count fuel country approved by da
	 *
	 * @return string $count
	 */
	public function count_fuel_approved_by_da() {
		$count = $this->get_post_country_status( 'fuels', '70' );
		return count($count);
	}

	/**
	 * Count fuel country rejected by da
	 *
	 * @return string $count
	 */
	public function count_fuel_rejected_by_da() {
		$count = $this->get_post_country_status( 'fuels', '80' );
		return count($count);
	}

	/**
	 * Count fuel country rejected by da
	 *
	 * @return string $count
	 */
	public function count_cancellation_fuel_submitted_to_da() {
		$count = $this->get_post_country_status( 'fuels', '90' );
		return count($count);
	}

	/**
	 * Count fuel country rejected by da
	 *
	 * @return string $count
	 */
	public function count_cancellation_fuel_approved_by_da() {
		$count = $this->get_post_country_status( 'fuels', '100' );
		return count($count);
	}

	/**
	 * Count fuel country submitted to da
	 *
	 * @return string $count
	 */
	public function count_revocated_fuel_submitted_to_da() {
		$count = $this->get_post_country_status( 'fuels', '200' );
		return count($count);
	}

	/**
	 * Count fuel country submitted to da
	 *
	 * @return string $count
	 */
	public function count_revocated_fuel_approved_by_da() {
		$count = $this->get_post_country_status( 'fuels', '300' );
		return count($count);
	}

	/**
	 * Count fuel country submitted to da
	 *
	 * @return string $count
	 */
	public function count_revocated_fuel_published() {
		$count = $this->get_post_country_status( 'fuels', '400' );
		return count($count);
	}

	

	/**
	 * Count fuel country awaiting publication
	 *
	 * @return string $count
	 */
	public function count_fuel_awaiting_publication() {
		$count = $this->get_post_country_status( 'fuels', '500' );
		return count($count);
	}

	/**
	 * Count fuel country published
	 *
	 * @return string $count
	 */
	public function count_fuel_published() {
		$count = $this->get_post_country_status( 'fuels', '600' );
		// $uniqe_appliance = $this->refine_fuels_by_id($count);
		return count($count);
	}

	/**
	 * Get revoked by key, value and post type
	 *
	 * @param string $key
	 * @param string $value
	 * @param string $post_type
	 * @return void
	 */
	public function get_revoked_requested( $key, $value, $post_type ) {
		global $wpdb;
		$results = $wpdb->get_results(
			$wpdb->prepare(
				"SELECT DISTINCT pm.post_id
				FROM wp_postmeta pm
				LEFT JOIN wp_posts p ON pm.post_id = p.ID
				WHERE pm.meta_key LIKE %s
				AND pm.meta_value LIKE %s
				AND p.post_type = %s",
				array( $key, $value, $post_type)
			)
		);
		return $results;
	}

	/**
	 * Reduce results to count unique id
	 *
	 * @param [type] $count
	 * @return void
	 */
	public function refine_appliances_by_id($count) {
		$array = array();
		foreach ($count as $counted) {
			$array[] = $counted->appliance_id;
		}
		$array = array_unique($array);
		return $array;
	}

	/**
	 * Reduce results to count unique id
	 *
	 * @param [type] $count
	 * @return void
	 */
	public function refine_fuels_by_id($count) {
		$array = array();
		foreach ($count as $counted) {
			$array[] = $counted->fuel_id;
		}
		$array = array_unique($array);
		return $array;
	}

	/**
	 * Get manufacturer types
	 *
	 * @return array $results
	 */
    public function get_manufacturer_types() {
        $taxonomy = 'manufacturer_types'; // Replace with your taxonomy name
		$terms = get_terms( array(
			'taxonomy'   => $taxonomy,
			'hide_empty' => false, // Set to true to only get terms with posts
		) );
		return $terms;
    }

	/**
	 * Get countries
	 *
	 * @return array $results
	 */
    public function get_countries() {
        global $wpdb;
        $results = $wpdb->get_results(
            "SELECT *
            FROM `wp_defra_countries`
            ORDER BY `id`"
        );
        return $results;
    }

	/**
	 * create a standard timestamp for the time now
	 *
	 * @return string $time_stamp
	 */
	public function create_timestamp() {
		$timezone = new DateTimeZone('Europe/London'); 
		$now = new DateTime('now', $timezone);
		$time_stamp = $now->format('Y-m-d H:i:s');
		return $time_stamp;
	}

	/**
	 * 
	 * Any inserts to the db should no longer update the legacy data,
	 * all create, updates and delete should use native WP functions
	 * 
	 */

	/**
	 * Insert a new fuel
	 *
	 * @param [type] $postdata
	 * @return void
	 */
	public function insert_new_fuel($postdata) {
		$current_user = wp_get_current_user();
		
		$new_fuel = $this->set_fuel_post_array($postdata);
		if(isset($postdata["post_id"]) && !empty($postdata["post_id"])) {
			$post_id = $postdata["post_id"];
			$new_fuel['ID'] = $post_id;
			wp_update_post( $new_fuel );
		} else {
			$post_id = wp_insert_post( $new_fuel );
		}

		$metas = $this->set_fuel_meta_array($post_id, $postdata);
		foreach($metas as $k => $v){
			update_post_meta( $post_id, $k, $v );
		}

		return $post_id;

	}

		/**
	 * Setup appliance metas
	 *
	 * @return void
	 */
	public function fuel_metas() {
		$fuel_metas = array(
			'manufacturer_id',
			'fuel_id',
			'point_a',
			'point_b',
			'point_c',
			'point_d',
			'point_e',
			'point_f',
			'fuel_additional_details_application_number',
			'fuel_additional_details_linked_applications',
			'fuel_additional_details_comments',

			'authorised_country_and_statutory_instrument_england_enabled',
			'authorised_country_and_statutory_instrument_england_si',
			'authorised_country_and_statutory_instrument_england_status',
			
			'authorised_country_and_statutory_instrument_wales_enabled',
			'authorised_country_and_statutory_instrument_wales_si',
			'authorised_country_and_statutory_instrument_wales_status',
			
			'authorised_country_and_statutory_instrument_scotland_enabled',
			'authorised_country_and_statutory_instrument_scotland_si',
			'authorised_country_and_statutory_instrument_scotland_status',
			
			'authorised_country_and_statutory_instrument_n_ireland_enabled',
			'authorised_country_and_statutory_instrument_n_ireland_si',
			'authorised_country_and_statutory_instrument_n_ireland_status',
		);
		return $fuel_metas;
	}


	/**
	 * Setup fuel post meta
	 *
	 * @param array $postdata
	 * @return array $metas
	 */
	public function set_fuel_meta_array($post_id, $postdata) {
		// setup meta keys
		$fuel_metas = $this->fuel_metas();
		if(isset($postdata["post_author"])) {
			$user_id = $postdata["post_author"];
		} else {
			$current_user = wp_get_current_user();
			$user_id = $current_user->ID;
		}

		// add user id to the metas
		$metas = array(
			'entry_user_id' => $user_id,
			'fuel_id' => $post_id
		);

		foreach($fuel_metas as $k) {
			if($k === 'authorised_country_and_statutory_instrument_england_enabled'
			|| $k === 'authorised_country_and_statutory_instrument_wales_enabled'
			|| $k === 'authorised_country_and_statutory_instrument_scotland_enabled'
			|| $k === 'authorised_country_and_statutory_instrument_n_ireland_enabled') {
				$metas[$k] = $postdata[$k] === 'on' ? '1' : '';
			} else if($k === 'authorised_country_and_statutory_instrument_england_si') {
				$n = $postdata[$k] ? count($postdata[$k]) : 0;
				for($i = 0; $i < $n; $i++) {
					$metas['authorised_country_and_statutory_instrument_england_si_'.$i .'_si_id'] = $postdata[$k][$i];
				}
				$metas[$k] = $n;
			} else if($k === 'authorised_country_and_statutory_instrument_wales_si') {
				$n = $postdata[$k] ? count($postdata[$k]) : 0;
				for($i = 0; $i < $n; $i++) {
					$metas['authorised_country_and_statutory_instrument_wales_si_'.$i .'_si_id'] = $postdata[$k][$i];
				}
				$metas[$k] = $n;
			} else if($k === 'authorised_country_and_statutory_instrument_scotland_si') {
				$n = $postdata[$k] ? count($postdata[$k]) : 0;
				for($i = 0; $i < $n; $i++) {
					$metas['authorised_country_and_statutory_instrument_scotland_si_'.$i .'_si_id'] = $postdata[$k][$i];
				}
				$metas[$k] = $n;
			} else if($k === 'authorised_country_and_statutory_instrument_n_ireland_si') {
				$n = $postdata[$k] ? count($postdata[$k]) : 0;
				for($i = 0; $i < $n; $i++) {
					$metas['authorised_country_and_statutory_instrument_n_ireland_si_'.$i .'_si_id'] = $postdata[$k][$i];
				}
				$metas[$k] = $n;
			} else if($k === 'authorised_country_and_statutory_instrument_england_status') {
				$metas[$k] = $postdata["submit-type"] === 'save-draft' ? '10' : '20';
			} else if($k === 'authorised_country_and_statutory_instrument_wales_status') {
				$metas[$k] = $postdata["submit-type"] === 'save-draft' ? '10' : '20';
			} else if($k === 'authorised_country_and_statutory_instrument_scotland_status') {
				$metas[$k] = $postdata["submit-type"] === 'save-draft' ? '10' : '20';
			} else if($k === 'authorised_country_and_statutory_instrument_n_ireland_status') {
				$metas[$k] = $postdata["submit-type"] === 'save-draft' ? '10' : '20';
			} else {
				$metas[$k] = $postdata[$k];
			}
		}

		return $metas;
	}


	/**
	 * Insert a new application
	 *
	 * @param [type] $postdata
	 * @return void
	 */
	public function insert_new_appliance($postdata) {
		$current_user = wp_get_current_user();
		
		$new_appliance = $this->set_appliance_post_array($postdata);
		if(isset($postdata["post_id"]) && !empty($postdata["post_id"])) {
			$post_id = $postdata["post_id"];
			$new_appliance['ID'] = $post_id;
			wp_update_post( $new_appliance );
		} else {
			$post_id = wp_insert_post( $new_appliance );
		}

		$metas = $this->set_appliance_meta_array($post_id, $postdata);
		foreach($metas as $k => $v){
			update_post_meta( $post_id, $k, $v );
		}

		wp_set_post_terms( $post_id, array_map('intval', $postdata["permitted_fuel_id"]), 'permitted_fuels' );

		$app_type_terms = get_term_by( 'slug', $postdata["type_terms"], 'appliance_types' );
		wp_set_post_terms( $post_id, $app_type_terms->name, 'appliance_types' );

		$fuel_type_terms = get_term_by( 'slug', $postdata["fuel_types"], 'fuel_types' );
		wp_set_post_terms( $post_id, $fuel_type_terms->name, 'fuel_types' );

		return $post_id;

	}

	/**
	 * Setup appliance metas
	 *
	 * @return void
	 */
	public function appliance_metas() {
		$appliance_metas = array(
			'manufacturer_id',
			'appliance_id',
			'output_unit_output_unit_id',
			'output_unit_output_value',
			'instructions_instruction_manual_title',
			'instructions_instruction_manual_reference',
			'instructions_instruction_manual_date',
			'servicing_and_installation_servicing_install_manual_date',
			'servicing_and_installation_servicing_install_manual_title',
			'servicing_and_installation_servicing_install_manual_reference',
			'additional_conditions_additional_condition_id',
			'additional_conditions_additional_condition_comment',
			'appliance_additional_details_application_number',
			'appliance_additional_details_linked_applications',
			'appliance_additional_details_comments',

			'exempt-in_country_and_statutory_instrument_england_enabled',
			'exempt-in_country_and_statutory_instrument_england_si',
			'exempt-in_country_and_statutory_instrument_england_status',
			
			'exempt-in_country_and_statutory_instrument_wales_enabled',
			'exempt-in_country_and_statutory_instrument_wales_si',
			'exempt-in_country_and_statutory_instrument_wales_status',
			
			'exempt-in_country_and_statutory_instrument_scotland_enabled',
			'exempt-in_country_and_statutory_instrument_scotland_si',
			'exempt-in_country_and_statutory_instrument_scotland_status',
			
			'exempt-in_country_and_statutory_instrument_n_ireland_enabled',
			'exempt-in_country_and_statutory_instrument_n_ireland_si',
			'exempt-in_country_and_statutory_instrument_n_ireland_status',	
		);
		return $appliance_metas;
	}
	
	/**
	 * Setup appliance post meta
	 *
	 * @param array $postdata
	 * @return array $metas
	 */
	public function set_appliance_meta_array($post_id, $postdata) {
		// setup meta keys
		$appliance_metas = $this->appliance_metas();
		if(isset($postdata["post_author"])) {
			$user_id = $postdata["post_author"];
		} else {
			$current_user = wp_get_current_user();
			$user_id = $current_user->ID;
		}

		// add user id to the metas
		$metas = array(
			'entry_user_id' => $user_id,
			'appliance_id' => $post_id
		);

		foreach($appliance_metas as $k) {
			if($k === 'exempt-in_country_and_statutory_instrument_england_enabled'
			|| $k === 'exempt-in_country_and_statutory_instrument_wales_enabled'
			|| $k === 'exempt-in_country_and_statutory_instrument_scotland_enabled'
			|| $k === 'exempt-in_country_and_statutory_instrument_n_ireland_enabled') {
				$metas[$k] = $postdata[$k] === 'on' ? '1' : '';
			} else if($k === 'exempt-in_country_and_statutory_instrument_england_si') {
				$n = $postdata[$k] ? count($postdata[$k]) : 0;
				for($i = 0; $i < $n; $i++) {
					$metas['exempt-in_country_and_statutory_instrument_england_si_'.$i .'_si_id'] = $postdata[$k][$i];
				}
				$metas[$k] = $n;
			} else if($k === 'exempt-in_country_and_statutory_instrument_wales_si') {
				$n = $postdata[$k] ? count($postdata[$k]) : 0;
				for($i = 0; $i < $n; $i++) {
					$metas['exempt-in_country_and_statutory_instrument_wales_si_'.$i .'_si_id'] = $postdata[$k][$i];
				}
				$metas[$k] = $n;
			} else if($k === 'exempt-in_country_and_statutory_instrument_scotland_si') {
				$n = $postdata[$k] ? count($postdata[$k]) : 0;
				for($i = 0; $i < $n; $i++) {
					$metas['exempt-in_country_and_statutory_instrument_scotland_si_'.$i .'_si_id'] = $postdata[$k][$i];
				}
				$metas[$k] = $n;
			} else if($k === 'exempt-in_country_and_statutory_instrument_n_ireland_si') {
				$n = $postdata[$k] ? count($postdata[$k]) : 0;
				for($i = 0; $i < $n; $i++) {
					$metas['exempt-in_country_and_statutory_instrument_n_ireland_si_'.$i .'_si_id'] = $postdata[$k][$i];
				}
				$metas[$k] = $n;
			} else if($k === 'exempt-in_country_and_statutory_instrument_england_status') {
				$metas[$k] = $postdata["submit-type"] === 'save-draft' ? '10' : '20';
			} else if($k === 'exempt-in_country_and_statutory_instrument_wales_status') {
				$metas[$k] = $postdata["submit-type"] === 'save-draft' ? '10' : '20';
			} else if($k === 'exempt-in_country_and_statutory_instrument_scotland_status') {
				$metas[$k] = $postdata["submit-type"] === 'save-draft' ? '10' : '20';
			} else if($k === 'exempt-in_country_and_statutory_instrument_n_ireland_status') {
				$metas[$k] = $postdata["submit-type"] === 'save-draft' ? '10' : '20';
			} else {
				$metas[$k] = $postdata[$k];
			}
		}

		return $metas;
	}

	/**
	 * Setup appliance post array
	 *
	 * @return array 
	 */
	public function set_appliance_post_array($postdata) {
		if(isset($postdata["post_author"])) {
			$user_id = $postdata["post_author"];
		} else {
			$current_user = wp_get_current_user();
			$user_id = $current_user->ID;
		}
		$new_appliance = array(
			'post_title'   => $postdata["appliance_name"],
			'post_status'  => 'draft',
			'post_author'  => $user_id,
			'post_type' => 'appliances'
		);
		return $new_appliance;
	}

	/**
	 * Setup appliance post array
	 *
	 * @return array 
	 */
	public function set_fuel_post_array($postdata) {
		if(isset($postdata["post_author"])) {
			$user_id = $postdata["post_author"];
		} else {
			$current_user = wp_get_current_user();
			$user_id = $current_user->ID;
		}
		$new_fuel = array(
			'post_title'   => $postdata["fuel_name"],
			'post_status'  => 'draft',
			'post_author'  => $user_id,
			'post_type' => 'fuels'
		);
		return $new_fuel;
	}


	public function set_manufacturer_post_array($postdata) {
		$current_user = wp_get_current_user();
		$new_manufacturer = array(
			'post_title'   => $postdata["manufacturers_name"],
			'post_status'  => 'publish',
			'post_author'  => $current_user->ID,
			'post_type' => 'manufacturers'
		);
		return $new_manufacturer;

	}

	public function set_statutory_instrument_post_array($postdata) {
		$current_user = wp_get_current_user();
		$new_statutory_instrument = array(
			'post_title'   => $postdata["post_title"],
			'post_content'   => $postdata["post_content"],
			'post_status'  => 'publish',
			'post_author'  => $current_user->ID,
			'post_type' => 'statutory_instrument'
		);
		return $new_statutory_instrument;

	}

	/**
	 * Setup post manufacturers metas array
	 *
	 * @param [type] $post_id
	 * @param [type] $postdata
	 * @return void
	 */
	public function set_manufacturer_meta_array($post_id, $postdata) {
		$metas = array(
			'address_1',
			'address_2',
			'address_3',
			'address_4',
			'town__city',
			'county',
			'postcode',
			'country'
		);
		return $metas;
	}

	/**
	 * Insert a new manufacturer
	 *
	 * @param [type] $postdata
	 * @return void
	 */
	public function insert_new_manufacturer($postdata) {
		$current_user = wp_get_current_user();
		$new_manufacturer = $this->set_manufacturer_post_array($postdata);
		$post_id = wp_insert_post( $new_manufacturer );
		
		$metas = $this->set_manufacturer_meta_array($post_id, $postdata);
		foreach($metas as $k => $v){
			update_post_meta( $post_id, $v, $postdata[$v] );
		}
		update_post_meta($post_id, 'id', $post_id);
		$term = get_term_by( 'id', intval( $postdata["manufacturer_type"] ), 'manufacturer_types' );
		wp_set_post_terms( $post_id, $term->slug, 'manufacturer_types' );
	}

	
	/**
	 * insert a new permitted fuel in to the database
	 *
	 * @param array $postdata
	 * @return void
	 */
	public function insert_new_statutory_instrument($postdata) {
		$now = $this->create_timestamp();
		$current_user = wp_get_current_user();
		$new_statutory_instrument = $this->set_statutory_instrument_post_array($postdata);
		$post_id = wp_insert_post( $new_statutory_instrument );

		wp_set_post_terms( $post_id, $postdata["si_type"], 'si_types' );
		wp_set_post_terms( $post_id, $postdata["si_countries"], 'si_countries' );

	}

	/**
	 * insert a new permitted fuel in to the database
	 *
	 * @param array $postdata
	 * @return void
	 */
	public function insert_new_permitted_fuel($postdata) {
		$current_user = wp_get_current_user();

		$term_name = $postdata['permitted-fuel'];
		$term_slug = sanitize_title($term_name);
		$taxonomy = 'permitted_fuels';
		
		$args = array(
			'description' => $postdata['permitted-fuel'],
			'slug' => $term_slug,
		);
		
		// Insert the term
		$term = wp_insert_term($term_name, $taxonomy, $args);
		return $term;

	}

	/**
	 * Update appliance type
	 *
	 * @param array $postdata
	 * @return void
	 */
	public function update_permitted_fuel($postdata) {
		$now = $this->create_timestamp();
		$current_user = wp_get_current_user();
		$table = $this->wpdb->prefix.$postdata['type'];
		$data = array(
			'permitted_fuel_name' => $postdata['input'],
			'edited_by_user_id' => $current_user->ID,
			'date_updated' => $now,
		);
		$where = array(
			'permitted_fuel_id' => $postdata['id']
		);
		$format = array(
			'%s',
			'%s',
			'%s'
		);
		$this->wpdb->update($table,$data,$where,$format);

	}	

	/**
	 * insert a new appliance type in to the database
	 *
	 * @param array $postdata
	 * @return void
	 */
	public function insert_new_additional_condition($postdata) {
		$now = $this->create_timestamp();
		$current_user = wp_get_current_user();
		$table = $this->wpdb->prefix.'defra_additional_conditions';
		$data = array(
			'condition_name' => $postdata['additional-condition'],
			'created_by_user_id' => $current_user->ID,
			'date_added' => $now,
			'date_updated' => $now,
		);
		$format = array(
			'%s',
			'%s',
			'%s',
			'%s'
		);
		$this->wpdb->insert($table,$data,$format);
	}

	/**
	 * Update appliance type
	 *
	 * @param array $postdata
	 * @return void
	 */
	public function update_additional_condition($postdata) {
		$now = $this->create_timestamp();
		$current_user = wp_get_current_user();
		$table = $this->wpdb->prefix.$postdata['type'];
		$data = array(
			'condition_name' => $postdata['input'],
			'edited_by_user_id' => $current_user->ID,
			'date_updated' => $now,
		);
		$where = array(
			'ID' => $postdata['id']
		);
		$format = array(
			'%s',
			'%s',
			'%s'
		);
		$this->wpdb->update($table,$data,$where,$format);

	}

	/**
	 * insert a new appliance type in to the database
	 *
	 * @param array $postdata
	 * @return void
	 */
	public function insert_new_appliance_type($postdata) {

		$current_user = wp_get_current_user();

		$term_name = $postdata['appliance-type'];
		$term_slug = sanitize_title($term_name);
		$taxonomy = 'appliance_types';
		
		$args = array(
			'description' => $term_name,
			'slug' => $term_slug,
		);
		
		// Insert the term
		$term = wp_insert_term($term_name, $taxonomy, $args);
		return $term;

	}

	/**
	 * Update appliance type
	 *
	 * @param array $postdata
	 * @return void
	 */
	public function update_appliance_type($postdata) {
		// Arguments for updating the term
		$args = array(
			'name' => $postdata['input'],
			'description' => 'User updated appliance type'
		);
	
		// Update the term
		$term_updated = wp_update_term( $postdata['id'], 'appliance_types', $args); // Replace 'your_custom_taxonomy' with your taxonomy name
	
		if (is_wp_error($term_updated)) {
			// Handle error, for example, log it or display a message
			wp_die('Error updating term: ' . $term_updated->get_error_message());
		}

	}

	/**
	 * insert a new fuel type in to the database
	 *
	 * @param array $postdata
	 * @return void
	 */
	public function insert_new_fuel_type($postdata) {
		$now = $this->create_timestamp();
		$current_user = wp_get_current_user();
		$table = $this->wpdb->prefix.'defra_fuel_types';
		$data = array(
			'name' => $postdata['fuel-type'],
			'created_by_user_id' => $current_user->ID,
			'date_added' => $now,
			'date_updated' => $now,
		);
		$format = array(
			'%s',
			'%s',
			'%s',
			'%s'
		);
		$this->wpdb->insert($table,$data,$format);
	}

	/**
	 * Update fuel type
	 *
	 * @param array $postdata
	 * @return void
	 */
	public function update_fuel_type($postdata) {

		// Arguments for updating the term
		$args = array(
			'name' => $_POST["input"],
			'description' => 'User updated fuel type'
		);
	
		// Update the term
		$term_updated = wp_update_term( $_POST["id"], 'fuel_types', $args); // Replace 'your_custom_taxonomy' with your taxonomy name
	
		if (is_wp_error($term_updated)) {
			// Handle error, for example, log it or display a message
			wp_die('Error updating term: ' . $term_updated->get_error_message());
		}

	}

	public function delete_fuel_type($postdata) {
		// Delete the term
		$term_deleted = wp_delete_term($postdata['id'], 'fuel_types'); // Replace 'your_custom_taxonomy' with your taxonomy name

		if (is_wp_error($term_deleted)) {
			// Handle error, for example, log it or display a message
			wp_die('Error deleting term: ' . $term_deleted->get_error_message());
		}

	}

	public function delete_appliance_type($postdata) {
		$table = $this->wpdb->prefix.$postdata['type'];
		$where = array(
			'ID' => $postdata['id']
		);
		$format = array(
			'%d'
		);
		$this->wpdb->delete($table,$where,$format);

	}

	public function delete_additional_condition($postdata) {
		$table = $this->wpdb->prefix.$postdata['type'];
		$where = array(
			'ID' => $postdata['id']
		);
		$format = array(
			'%d'
		);
		$this->wpdb->delete($table,$where,$format);

	}

	public function delete_permitted_fuel($postdata) {
		$table = $this->wpdb->prefix.$postdata['type'];
		$where = array(
			'permitted_fuel_id' => $postdata['id']
		);
		$format = array(
			'%d'
		);
		$this->wpdb->delete($table,$where,$format);

	}

	


}
