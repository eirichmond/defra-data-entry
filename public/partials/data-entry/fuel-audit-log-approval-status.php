<?php
/**
 * $post_id int
 * $appliance post object
 * $appliance_id legacy int id
 */

$public_class = new Defra_Data_Entry_Public(DEFRA_DATA_ENTRY_NAME, DEFRA_DATA_ENTRY_VERSION);
$approved_statuses = data_setup_approval_status($post_id);

?>

<table class="table table-bordered table-striped mb-4">
    <thead>
        <tr class="table-dark">
            <th scope="col">Country</th>
            <th scope="col">Email</th>
            <th scope="col">Assign Date</th>
            <th scope="col">Approve Date</th>
            <th scope="col">Reject Date</th>
            <th scope="col">Publish Date</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($approved_statuses as $key => $approved_status) { ?>

            <?php if($approved_status['authorised_country_and_statutory_instrument_'.$key.'_is_published'] == '1') { ?>
                <tr>
                    <td><?php echo esc_html( str_replace('_', '. ', ucwords($key)) ); ?></td>
                    <td><?php echo esc_html( $approved_status["authorised_country_and_statutory_instrument_{$key}_user"] ); ?></td>
                    <td><?php echo esc_html( $approved_status["authorised_country_and_statutory_instrument_{$key}_assigned_date"] ); ?></td>
                    <td><?php echo esc_html( $approved_status["authorised_country_and_statutory_instrument_{$key}_approve_date"] ); ?></td>
                    <td><?php echo esc_html( isset($approved_status["authorised_country_and_statutory_instrument_{$key}_reject_date"]) ? $approved_status["authorised_country_and_statutory_instrument_{$key}_reject_date"] : '' ); ?></td>
                    <td><?php echo esc_html( $approved_status["authorised_country_and_statutory_instrument_{$key}_publish_date"] ); ?></td>
                </tr>
            <?php } ?>

        <?php } ?>
    </tbody>
</table>