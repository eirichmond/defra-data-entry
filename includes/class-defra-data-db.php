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
	 * Get appliance status
	 *
	 * @param string $status
	 * @return array $results
	 */
    public function get_appliance_country_status($status) {
        global $wpdb;
        $results = $wpdb->get_results(
			$wpdb->prepare(
				"SELECT DISTINCT pm.post_id
				FROM wp_postmeta pm
				LEFT JOIN wp_posts p ON pm.post_id = p.ID
				WHERE pm.meta_key LIKE %s
				AND pm.meta_value = %d
				AND p.post_type = 'appliances'",
				array('%_status',$status)
			)
        );
        return $results;
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
		$defra_permitted_fuels = $this->get_permitted_fuels();
		foreach($defra_permitted_fuels as $k => $v) {
			$list_permitted_fuels[$v->permitted_fuel_id]['permitted_fuel_id'] = $v->permitted_fuel_id;
			$list_permitted_fuels[$v->permitted_fuel_id]['permitted_fuel_name'] = $v->permitted_fuel_name;
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
			$list_appliance_types[$v->id]['appliance_type_id'] = $v->id;
			$list_appliance_types[$v->id]['appliance_type_name'] = $v->name;
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
	public function list_manufacturers() {
		$list_manufacturers = array();
		$defra_manufacturers = $this->get_manufacturers();
		foreach($defra_manufacturers as $k => $v) {
			$list_manufacturers[$v->id]['manufacturer_id'] = $v->id;
			$list_manufacturers[$v->id]['manufacturer_name'] = $v->name;
			$list_manufacturers[$v->id]['manufacturer_address'] = $this->composite_address($v);
			$list_manufacturers[$v->id]['manufacturer_action'] = $v->format_type;
		}
        return $list_manufacturers;

	}

	public function composite_address($object) {

		$address = array();
		$address[] = $object->address_line_1;
		$address[] = $object->address_line_2;
		$address[] = $object->address_line_3;
		$address[] = $object->address_line_4;
		$address[] = $object->town;
		$address[] = $object->county;
		$address[] = $object->post_code;

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
	public function get_additional_conditions() {
		global $wpdb;
        $results = $wpdb->get_results(
            "SELECT *
            FROM `wp_defra_additional_conditions`
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
	public function get_appliance_types() {
		global $wpdb;
        $results = $wpdb->get_results(
            "SELECT *
            FROM `wp_defra_appliance_types`
			"
        );
		return $results;

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
	public function get_manufacturers() {
		global $wpdb;
        $results = $wpdb->get_results(
            "SELECT *
            FROM `wp_defra_manufacturers`
			ORDER BY name
			"
        );
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
		$count = $this->get_appliance_country_status('10');
		return count($count);
	}

	/**
	 * Count appliance country awaiting review
	 *
	 * @return string $count
	 */
	public function count_appliance_awaiting_review() {
		$count = $this->get_appliance_country_status('20');
		return count($count);
	}

	/**
	 * Count appliance country being reviewed
	 *
	 * @return string $count
	 */
	public function count_appliance_being_reviewed() {
		$count = $this->get_appliance_country_status('30');
		return count($count);
	}

	/**
	 * Count appliance country reviewer rejected
	 *
	 * @return string $count
	 */
	public function count_appliance_reviewer_rejected() {
		$count = $this->get_appliance_country_status('40');
		return count($count);
	}

	/**
	 * Count appliance country submitted to da
	 *
	 * @return string $count
	 */
	public function count_appliance_submitted_to_da() {
		$count = $this->get_appliance_country_status('50');
		return count($count);
	}
	

	/**
	 * Count appliance country assigned to da
	 *
	 * @return string $count
	 */
	public function count_appliance_assigned_to_da() {
		$count = $this->get_appliance_country_status('60');
		return count($count);
	}

	/**
	 * Count appliance country approved by da
	 *
	 * @return string $count
	 */
	public function count_appliance_approved_by_da() {
		$count = $this->get_appliance_country_status('70');
		return count($count);
	}

	/**
	 * Count appliance country rejected by da
	 *
	 * @return string $count
	 */
	public function count_appliance_rejected_by_da() {
		$count = $this->get_appliance_country_status('80');
		return count($count);
	}

	/**
	 * Count appliance country rejected by da
	 *
	 * @return string $count
	 */
	public function count_cancellation_appliance_submitted_to_da() {
		$count = $this->get_appliance_country_status('90');
		return count($count);
	}

	/**
	 * Count appliance country rejected by da
	 *
	 * @return string $count
	 */
	public function count_cancellation_appliance_approved_by_da() {
		$count = $this->get_appliance_country_status('100');
		return count($count);
	}

	/**
	 * Count appliance country submitted to da
	 *
	 * @return string $count
	 */
	public function count_revocated_appliance_submitted_to_da() {
		$count = $this->get_appliance_country_status('200');
		return count($count);
	}

	/**
	 * Count appliance country submitted to da
	 *
	 * @return string $count
	 */
	public function count_revocated_appliance_approved_by_da() {
		$count = $this->get_appliance_country_status('300');
		return count($count);
	}

	/**
	 * Count appliance country submitted to da
	 *
	 * @return string $count
	 */
	public function count_revocated_appliance_published() {
		$count = $this->get_appliance_country_status('400');
		return count($count);
	}

	

	/**
	 * Count appliance country awaiting publication
	 *
	 * @return string $count
	 */
	public function count_appliance_awaiting_publication() {
		$count = $this->get_appliance_country_status('500');
		return count($count);
	}

	/**
	 * Count appliance country published
	 *
	 * @return string $count
	 */
	public function count_appliance_published() {
		$count = $this->get_appliance_country_status('600');
		$uniqe_appliance = $this->refine_appliances_by_id($count);
		return count($uniqe_appliance);
	}

	/**
	 * Count fuel country drafts
	 *
	 * @return string $count
	 */
	public function count_fuel_draft() {
		$count = $this->get_fuel_country_status('10');
		return count($count);
	}

	/**
	 * Count fuel country awaiting review
	 *
	 * @return string $count
	 */
	public function count_fuel_awaiting_review() {
		$count = $this->get_fuel_country_status('20');
		return count($count);
	}

	/**
	 * Count fuel country being reviewed
	 *
	 * @return string $count
	 */
	public function count_fuel_being_reviewed() {
		$count = $this->get_fuel_country_status('30');
		return count($count);
	}

	/**
	 * Count fuel country reviewer rejected
	 *
	 * @return string $count
	 */
	public function count_fuel_reviewer_rejected() {
		$count = $this->get_fuel_country_status('40');
		return count($count);
	}

	/**
	 * Count fuel country submitted to da
	 *
	 * @return string $count
	 */
	public function count_fuel_submitted_to_da() {
		$count = $this->get_fuel_country_status('50');
		return count($count);
	}
	

	/**
	 * Count fuel country assigned to da
	 *
	 * @return string $count
	 */
	public function count_fuel_assigned_to_da() {
		$count = $this->get_fuel_country_status('60');
		return count($count);
	}

	/**
	 * Count fuel country approved by da
	 *
	 * @return string $count
	 */
	public function count_fuel_approved_by_da() {
		$count = $this->get_fuel_country_status('70');
		return count($count);
	}

	/**
	 * Count fuel country rejected by da
	 *
	 * @return string $count
	 */
	public function count_fuel_rejected_by_da() {
		$count = $this->get_fuel_country_status('80');
		return count($count);
	}

	/**
	 * Count fuel country rejected by da
	 *
	 * @return string $count
	 */
	public function count_cancellation_fuel_submitted_to_da() {
		$count = $this->get_fuel_country_status('90');
		return count($count);
	}

	/**
	 * Count fuel country rejected by da
	 *
	 * @return string $count
	 */
	public function count_cancellation_fuel_approved_by_da() {
		$count = $this->get_fuel_country_status('100');
		return count($count);
	}

	/**
	 * Count fuel country submitted to da
	 *
	 * @return string $count
	 */
	public function count_revocated_fuel_submitted_to_da() {
		$count = $this->get_fuel_country_status('200');
		return count($count);
	}

	/**
	 * Count fuel country submitted to da
	 *
	 * @return string $count
	 */
	public function count_revocated_fuel_approved_by_da() {
		$count = $this->get_fuel_country_status('300');
		return count($count);
	}

	/**
	 * Count fuel country submitted to da
	 *
	 * @return string $count
	 */
	public function count_revocated_fuel_published() {
		$count = $this->get_fuel_country_status('400');
		return count($count);
	}

	

	/**
	 * Count fuel country awaiting publication
	 *
	 * @return string $count
	 */
	public function count_fuel_awaiting_publication() {
		$count = $this->get_fuel_country_status('500');
		return count($count);
	}

	/**
	 * Count fuel country published
	 *
	 * @return string $count
	 */
	public function count_fuel_published() {
		$count = $this->get_fuel_country_status('600');
		$uniqe_appliance = $this->refine_fuels_by_id($count);
		return count($uniqe_appliance);
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
        global $wpdb;
        $results = $wpdb->get_results(
            "SELECT *
            FROM `wp_defra_manufacturer_type`
            ORDER BY `id`"
        );
		$results = array_reverse($results);
        return $results;
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
	 * Insert a new manufacturer
	 *
	 * @param [type] $postdata
	 * @return void
	 */
	public function insert_new_manufacturer($postdata) {
		$current_user = wp_get_current_user();
		$table = $this->wpdb->prefix.'defra_manufacturers';
		$data = array(
			'name' => $postdata['manufacturers_name'],
			'address_line_1' => $postdata['address_line_1'],
			'address_line_2' => $postdata['address_line_2'],
			'address_line_3' => $postdata['address_line_3'],
			'address_line_4' => $postdata['address_line_4'],
			'town' => $postdata['town'],
			'county' => $postdata['county'],
			'post_code' => $postdata['post_code'],
			'country_id' => $postdata['country_id'],
			'created_on' => date('Y-m-d H:i:s'),
			'created_by' => $current_user->ID,
			'updated_on' => date('Y-m-d H:i:s'),
			'updated_by' => $current_user->ID,
			'type' => $postdata['manufacturer_type'],
			'format_type' => 0,
		);
		$format = array(
			'%s',
			'%s',
			'%s',
			'%s',
			'%s',
			'%s',
			'%s',
			'%s',
			'%d',
			'%s',
			'%d',
			'%s',
			'%d',
			'%d',
			'%d'
		);
		$this->wpdb->insert($table,$data,$format);
		$manufacturer_id = $this->wpdb->insert_id;

	}

	
	/**
	 * insert a new permitted fuel in to the database
	 *
	 * @param array $postdata
	 * @return void
	 */
	public function insert_new_permitted_fuel($postdata) {
		$now = $this->create_timestamp();
		$current_user = wp_get_current_user();
		$table = $this->wpdb->prefix.$postdata['entry'];
		$data = array(
			'permitted_fuel_name' => $postdata['permitted-fuel'],
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
		$table = $this->wpdb->prefix.$postdata['entry'];
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
		$now = $this->create_timestamp();
		$current_user = wp_get_current_user();
		$table = $this->wpdb->prefix.$postdata['entry'];
		$data = array(
			'name' => $postdata['appliance-type'],
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
	public function update_appliance_type($postdata) {
		$now = $this->create_timestamp();
		$current_user = wp_get_current_user();
		$table = $this->wpdb->prefix.$postdata['type'];
		$data = array(
			'name' => $postdata['input'],
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
		$now = $this->create_timestamp();
		$current_user = wp_get_current_user();
		$table = $this->wpdb->prefix.$postdata['type'];
		$data = array(
			'name' => $postdata['input'],
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

	public function delete_fuel_type($postdata) {
		$table = $this->wpdb->prefix.$postdata['type'];
		$where = array(
			'ID' => $postdata['id']
		);
		$format = array(
			'%d'
		);
		$this->wpdb->delete($table,$where,$format);

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
