<?php

$public_class = new Defra_Data_Entry_Public(DEFRA_DATA_ENTRY_NAME, DEFRA_DATA_ENTRY_VERSION);

$args = array(
	'post_id' => get_the_ID()
);
$comments = get_comments( $args );

?>

<table class="table table-bordered table-striped">
    <thead>
        <tr class="table-dark">
            <th scope="col">Comment Type</th>
            <th scope="col">Action Type</th>
            <th scope="col">User</th>
            <th scope="col">Country</th>
            <th scope="col">Date</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($comments as $comment) { $userdata = get_user_by( 'ID', $comment->user_id ); ?>
            <tr>
                <td><?php echo esc_html( $public_class->get_comment_action_by_key(get_comment_meta($comment->comment_ID, 'comment_type_id', true )) ); ?></td>
                <td><?php echo esc_html( $public_class->get_comment_type_by_key(get_comment_meta($comment->comment_ID, 'comment_action_id', true )) ); ?></td>
                <td><?php echo esc_html( $userdata->user_login ); ?></td>
                <td></td>
                <td><?php echo esc_html( date('d/m/Y H:i', strtotime($comment->comment_date)) ); ?></td>
            </tr>
            <tr>
                <td colspan="5"><strong>User comment: </strong><?php echo esc_html( $comment->comment_content ); ?></td>
            </tr>
        <?php } ?>
    </tbody>
</table>