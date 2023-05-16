<?php

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

