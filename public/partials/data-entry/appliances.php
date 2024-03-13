<?php 
$class = new Defra_Data_Entry_Public('DEFRA_DATA_ENTRY','DEFRA_DATA_ENTRY_VERSION');
$db = new Defra_Data_DB_Requests();

$user = wp_get_current_user();
$country = get_user_meta( $user->ID, 'approver_country_id', true );

if(isset($_GET['revoked']) && '1' === $_GET['revoked']) {
	$appliances = $db->get_appliance_is_revoked_is_published();
} else {
	$appliances = $db->get_appliance_country_status($_GET['status'], $country);
}

$appliances = defra_data_query_by_appliance_id($appliances);

get_header();
?>

<?php do_action('before_main_content'); ?>

	<h1 class="entry-title">Appliances</h1>

	<table id="table_id" class="display">
	<thead>
		<tr>
			<th>ID</th>
			<th>Appliance Name</th>
			<th>Status</th>
			<th>Info</th>
			<th>Actions</th>
		</tr>
	</thead>
	<tbody>
		<?php if ( $appliances->have_posts() ) : ?>
			<?php while ( $appliances->have_posts() ) : $appliances->the_post(); ?>
				
				<?php include(plugin_dir_path( __FILE__ ) . 'appliance-list.php'); ?>

			<?php endwhile; ?>

		<?php endif; ?>
	</tbody>
	</table>

<?php do_action('after_main_content'); ?>

<?php get_footer(); ?>