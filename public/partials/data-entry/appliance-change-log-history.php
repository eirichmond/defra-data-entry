<?php
$public_class = new Defra_Data_Entry_Public(DEFRA_DATA_ENTRY_NAME, DEFRA_DATA_ENTRY_VERSION);
$db = new Defra_Data_DB_Requests;
$history_logs = $db->get_general_history_log($post_id);
?>

<table class="table table-bordered table-striped">
    <thead>
        <tr class="table-dark">
            <th scope="col">Id</th>
            <th scope="col">Appliance Id</th>
            <th scope="col">Appliance Name</th>
            <th scope="col">Users</th>
            <th scope="col">Creation Date</th>
            <th scope="col">Action</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($history_logs as $history_log) {  ?>
            <tr>
                <td><?php echo esc_html( $history_log->id ); ?></td>
                <td><?php echo esc_html( $history_log->appliance_id ); ?></td>
                <td><?php echo esc_html( $history_log->appliance_name ); ?></td>
                <td><?php echo esc_html( ($history_log->entry_user_id ? 'Entry User' : '') . ' ' . ($history_log->reviewer_user_id ? 'Reviewer User' : '') ); ?></td>
                <td><?php echo esc_html( date('d/m/Y H:i:s', strtotime($history_log->last_updated)) ); ?></td>
                <td><a href="#">View</a></td>
            </tr>
        <?php } ?>
    </tbody>
</table>