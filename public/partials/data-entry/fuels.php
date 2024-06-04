<?php 
$class = new Defra_Data_Entry_Public('DEFRA_DATA_ENTRY','DEFRA_DATA_ENTRY_VERSION');
$db = new Defra_Data_DB_Requests();

if(isset($_GET['status'])) {
	$status = $_GET['status'];
	$fuels = $db->get_fuels_country_status($status);
} elseif ( isset($_GET['revoked']) ) {
	$fuels = $db->get_revoked_requested( $_GET['key'], $_GET['value'], 'fuels' );
}
$fuels = defra_data_query_by_fuels_id($fuels);

get_header();
?>

<?php do_action('before_main_content'); ?>

	<h1 class="entry-title"><?php the_title(); ?></h1>

	<table id="table_id" class="display">
		<thead>
			<tr>
				<th>ID</th>
				<th>Fuel Name</th>
				<th>Status</th>
				<th>Info</th>
				<th>Actions</th>
			</tr>
		</thead>
		<tbody>
			<?php if ( $fuels->have_posts() ) : ?>
				<?php while ( $fuels->have_posts() ) : $fuels->the_post(); ?>

					<?php include(plugin_dir_path( __FILE__ ) . 'fuel-list.php'); ?>

				<?php endwhile; ?>
			<?php endif; ?>

		</tbody>
	</table>

<?php do_action('after_main_content'); ?>


<?php get_footer(); ?>