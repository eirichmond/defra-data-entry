<?php
/**
 * $post_id int
 * $fuel post object
 * $fuel_id legacy int id
 */

$public_class = new Defra_Data_Entry_Public(DEFRA_DATA_ENTRY_NAME, DEFRA_DATA_ENTRY_VERSION);

?>

<table class="table table-bordered table-striped mb-4">
    <tbody>
        <tr>
            <td width="50%"><strong>Data Entry User</strong></td>
            <td><?php echo esc_html( get_user_login( get_post_meta( $post_id, 'entry_user_id', true ) ) ); ?></td>
        </tr>
        <tr>
            <td><strong>Entry Creation Date</strong></td>
            <td><?php echo esc_html( date('d/m/Y H:i:s', strtotime($fuel->post_date)) ); ?></td>
        </tr>
        <tr>
            <td><strong>Data Reviewer User</strong></td>
            <td><?php echo esc_html( get_user_login( get_post_meta( $post_id, 'reviewer_user_id', true ) ) ); ?></td>
        </tr>
        <tr>
            <td><strong>Review Assigned Date</strong></td>
            <td><?php echo esc_html( get_post_meta( $post_id, 'reviewer_assign_date', true ) ? date('d/m/Y H:i:s', strtotime(get_post_meta( $post_id, 'reviewer_assign_date', true ))) : '' ); ?></td>
        </tr>
        <tr>
            <td><strong>Review Approved Date</strong></td>
            <td><?php echo esc_html( get_post_meta( $post_id, 'reviewer_approve_date', true ) ? date('d/m/Y H:i:s', strtotime(get_post_meta( $post_id, 'reviewer_approve_date', true ))) : '' ); ?></td>
        </tr>
        <tr>
            <td><strong>Review Rejected Date</strong></td>
            <td><?php echo esc_html( get_post_meta( $post_id, 'reviewer_reject_date', true ) ? date('d/m/Y H:i:s', strtotime(get_post_meta( $post_id, 'reviewer_reject_date', true ))) : '' ); ?></td>
        </tr>
    </tbody>
</table>