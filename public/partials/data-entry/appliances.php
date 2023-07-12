<?php 
$class = new Defra_Data_Entry_Public('DEFRA_DATA_ENTRY','DEFRA_DATA_ENTRY_VERSION');
$db = new Defra_Data_DB_Requests();

$appliances = $db->get_appliance_country_status($_GET['status']);
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