<?php

/**
 * Query based on data entry
 *
 * @param [type] $data_array
 * @return void
 */
function defra_data_query_statutory_instrument( $taxonomy = null, $term = null, $type = null ) {

    $args = array(
        'post_status' => 'any',
        'posts_per_page' => -1,
        'post_type' => 'statutory_instrument'
    );

    if($taxonomy) {
        $args['tax_query'] = array(
            'relation' => 'AND',
            array(
                'taxonomy' => $taxonomy, // Replace with your custom taxonomy slug
                'field' => 'slug',
                'terms' => $term // Replace with the slug of the term you want to query
            ),
            array(
                'taxonomy' => 'si_types',
                'field'    => 'slug',
                'terms'    => $type
            ),
        );
    }
    $statutory_instruments = get_posts($args);

    return $statutory_instruments;
}

/**
 * Data based on data entry, ** uses get_posts instead of WP_Query class **
 *
 * @param [type] $data_array
 * @return void
 */
function defra_data_by_appliance_id($data_array) {
    if( empty( $data_array ) ) {
        return; // return early if there is no data
    }
    $appliances = wp_list_pluck( $data_array, 'post_id' );

    foreach($appliances as $k => $appliance) {
        $meta_keys = get_post_meta($appliance);
        foreach ($meta_keys as $key => $value) {
            if (strpos($key, '_revoke_status_id') !== false && $value == '400' ) { // 'partial_key' is the part of the key you're looking for
                unset($appliances[$k]);
            }
        }
    }

    if($appliances) {
        $args = array(
            'post_status' => 'any',
            'posts_per_page' => -1,
            'post_type' => 'appliances',
            'post__in' => $appliances
        );
        $appliances = get_posts($args);
    }

    return $appliances;
}


/**
 * Query based on data entry
 *
 * @param [type] $data_array
 * @return void
 */
function defra_data_query_by_appliance_id($data_array) {
    $appliances = wp_list_pluck( $data_array, 'post_id' );

    $args = array(
        'post_status' => 'any',
        'posts_per_page' => -1,
        'post_type' => 'appliances',
        'post__in' => $appliances
    );
    $appliances = new WP_Query($args);

    return $appliances;
}
/**
 * Query based on data entry
 *
 * @param [type] $data_array
 * @return void
 */
function defra_data_query_by_fuels_id($data_array) {
    $fuels = wp_list_pluck( $data_array, 'post_id' );

    $args = array(
        'post_status' => 'any',
        'posts_per_page' => -1,
        'post_type' => 'fuels',
        'post__in' =>  $fuels
    );
    $fuels = new WP_Query($args);

    return  $fuels;
}

function get_user_login($user_id) {
    $userdata = get_user_by( 'ID', $user_id );
    return $userdata->user_login;
}

function approval_status_metas($post_type) {
    if($post_type == 'fuels') {
        $si_status = 'authorised';
    } else {
        $si_status = 'exempt-in';
    }
    $meta_keys = array(
        'england' => array(
            $si_status . '_country_and_statutory_instrument_england_is_published',
            $si_status . '_country_and_statutory_instrument_england_status',
            $si_status . '_country_and_statutory_instrument_england_user',
            $si_status . '_country_and_statutory_instrument_england_assigned_date',
            $si_status . '_country_and_statutory_instrument_england_approve_date',
            $si_status . '_country_and_statutory_instrument_england_publish_date'
        ),
        'scotland' => array(
            $si_status . '_country_and_statutory_instrument_scotland_is_published',
            $si_status . '_country_and_statutory_instrument_scotland_status',
            $si_status . '_country_and_statutory_instrument_scotland_user',
            $si_status . '_country_and_statutory_instrument_scotland_assigned_date',
            $si_status . '_country_and_statutory_instrument_scotland_approve_date',
            $si_status . '_country_and_statutory_instrument_scotland_publish_date'
        ),
        'wales' => array(
            $si_status . '_country_and_statutory_instrument_wales_is_published',
            $si_status . '_country_and_statutory_instrument_wales_status',
            $si_status . '_country_and_statutory_instrument_wales_user',
            $si_status . '_country_and_statutory_instrument_wales_assigned_date',
            $si_status . '_country_and_statutory_instrument_wales_approve_date',
            'exempt-in_country_and_statutory_instrument_wales_publish_date'
        ),
        'n_ireland' => array(
            $si_status . '_country_and_statutory_instrument_n_ireland_is_published',
            $si_status . '_country_and_statutory_instrument_n_ireland_status',
            $si_status . '_country_and_statutory_instrument_n_ireland_user',
            $si_status . '_country_and_statutory_instrument_n_ireland_assigned_date',
            $si_status . '_country_and_statutory_instrument_n_ireland_approve_date',
            $si_status . '_country_and_statutory_instrument_n_ireland_publish_date'
        )
    );
    return $meta_keys;
}

function data_setup_approval_status($post_id) {
    $meta_keys = approval_status_metas(get_post_type($post_id));
    $approved_statuses = array();
    foreach ($meta_keys as $k => $metas) { 
        foreach($metas as $meta_key) {
            $approved_statuses[$k][$meta_key] = get_post_meta( $post_id, $meta_key, true );
        }
    }
    return $approved_statuses;
}

/**
 * Check exemption
 *
 * @param [type] $post_id
 * @param [type] $country
 * @return void
 */
function exempt_statutory_instrument($post_id, $country) {
	$count = get_post_meta( $post_id, 'exempt-in_country_and_statutory_instrument_'.$country.'_si', true );
	$sis = array();
	for ($i=0; $i < $count; $i++) { 
		$sis[] = get_post_meta( $post_id, 'exempt-in_country_and_statutory_instrument_'.$country.'_si_'.$i.'_si_id', true );
	}
	return $sis;
}

/**
 * Check authorised
 *
 * @param [type] $post_id
 * @param [type] $country
 * @return void
 */
function authorised_statutory_instrument($post_id, $country) {
	$count = get_post_meta( $post_id, 'authorised_country_and_statutory_instrument_'.$country.'_si', true );
	$ais = array();
	for ($i=0; $i < $count; $i++) { 
		$ais[] = get_post_meta( $post_id, 'authorised_country_and_statutory_instrument_'.$country.'_si_'.$i.'_si_id', true );
	}
	return $ais;
}
