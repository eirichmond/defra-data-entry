<?php

/**
 * Query based on data entry
 *
 * @param [type] $data_array
 * @return void
 */
function defra_data_query_statutory_instrument($taxonomy = null, $term = null) {

    $args = array(
        'post_status' => 'any',
        'posts_per_page' => -1,
        'post_type' => 'statutory_instrument'
    );

    if($taxonomy) {
        $args['tax_query'] = array(
            array(
                'taxonomy' => $taxonomy, // Replace with your custom taxonomy slug
                'field' => 'slug',
                'terms' => $term // Replace with the slug of the term you want to query
            )
        );
    }
    $statutory_instruments = get_posts($args);

    return $statutory_instruments;
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