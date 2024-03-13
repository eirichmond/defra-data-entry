<?php 
$class = new Defra_Data_Entry_Public('DEFRA_DATA_ENTRY','DEFRA_DATA_ENTRY_VERSION');
$post_id = $class->resolve_id($_GET, 'fuel');
$fuel = get_post($post_id);
$fuel_id = get_post_meta( $post_id, 'fuel_id', true );
// $class->defra_get_header('data-entry');
get_header();
?>
<?php do_action('before_main_content'); ?>
<h2><?php echo esc_html( $fuel->post_title ); ?></h2>
<?php include(plugin_dir_path( __FILE__ ) . 'fuel-audit-log-details.php'); ?>

<h3>Approval Status</h3>
<?php include(plugin_dir_path( __FILE__ ) . 'fuel-audit-log-approval-status.php'); ?>

<h3>Comment History</h3>
<?php include(plugin_dir_path( __FILE__ ) . 'fuel-comments.php'); ?>

<h3>General Audit Log</h3>
<?php include(plugin_dir_path( __FILE__ ) . 'fuel-audit-log-general.php'); ?>


<?php do_action('after_main_content'); ?>

<?php get_footer(); ?>