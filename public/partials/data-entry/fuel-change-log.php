<?php 
$class = new Defra_Data_Entry_Public('DEFRA_DATA_ENTRY','DEFRA_DATA_ENTRY_VERSION');
$post_id = $class->resolve_id($_GET, 'appliance');
$appliance = get_post($post_id);
get_header();
?>
<?php do_action('before_main_content'); ?>
<h2><?php echo esc_html( $appliance->post_title ); ?></h2>

<?php include(plugin_dir_path( __FILE__ ) . 'appliance-change-log-history.php'); ?>

<?php do_action('after_main_content'); ?>

<?php get_footer(); ?>