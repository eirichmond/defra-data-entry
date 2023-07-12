<?php 
$class = new Defra_Data_Entry_Public('DEFRA_DATA_ENTRY','DEFRA_DATA_ENTRY_VERSION');
$post_id = $class->resolve_id($_GET, 'appliance');
$appliance = get_post($post_id);
$appliance_id = get_post_meta( $post_id, 'appliance_id', true );
// $class->defra_get_header('data-entry');
get_header();
?>
<?php do_action('before_main_content'); ?>
<h2><?php echo esc_html( $appliance->post_title ); ?></h2>
<?php include(plugin_dir_path( __FILE__ ) . 'appliance-audit-log-details.php'); ?>

<h3>Approval Status</h3>
<?php include(plugin_dir_path( __FILE__ ) . 'appliance-audit-log-approval-status.php'); ?>

<h3>Comment History</h3>
<?php include(plugin_dir_path( __FILE__ ) . 'appliance-comments.php'); ?>

<h3>General Audit Log</h3>
<?php include(plugin_dir_path( __FILE__ ) . 'appliance-audit-log-general.php'); ?>


<?php do_action('after_main_content'); ?>

<?php get_footer(); ?>