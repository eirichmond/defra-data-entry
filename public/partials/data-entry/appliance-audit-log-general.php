<?php
$public_class = new Defra_Data_Entry_Public(DEFRA_DATA_ENTRY_NAME, DEFRA_DATA_ENTRY_VERSION);
$db = new Defra_Data_DB_Requests;
$audit_logs = $db->get_general_audit_log($post_id, 'appliance');
?>

<table class="table table-bordered table-striped">
    <thead>
        <tr class="table-dark">
            <th scope="col">Email</th>
            <th scope="col">Message</th>
            <th scope="col">IP Address</th>
            <th scope="col">Created Date</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($audit_logs as $audit_log) {  ?>
            <tr>
                <td><?php echo esc_html( $audit_log->user_id ); ?></td>
                <td><?php echo esc_html( $audit_log->message ); ?></td>
                <td><?php echo esc_html( $audit_log->ip_address ); ?></td>
                <td><?php echo esc_html( date('d/m/Y H:i:s', strtotime($audit_log->created_date)) ); ?></td>
            </tr>
        <?php } ?>
    </tbody>
</table>