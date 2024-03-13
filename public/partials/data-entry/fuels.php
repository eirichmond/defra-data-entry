<?php 
$class = new Defra_Data_Entry_Public('DEFRA_DATA_ENTRY','DEFRA_DATA_ENTRY_VERSION');
$db = new Defra_Data_DB_Requests();

if(isset($_GET['status'])) {
	$status = $_GET['status'];
} else {
	$status = NULL;
}
$fuels = $db->get_fuels_country_status($status);
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
					<tr>
						<td style="width:5%"><?php echo get_post_meta(get_the_ID(), 'fuel_id', true ); ?></td>
						<td style="width:20%"><?php the_title(); ?></td>
						<td style="width:30%">
							<strong>England:</strong> <?php echo esc_html($class->si_status(get_post_meta(get_the_ID(), 'exempt-in_country_and_statutory_instrument_england_status', true))); ?><br>
							<strong>Wales:</strong> <?php echo esc_html($class->si_status(get_post_meta(get_the_ID(), 'exempt-in_country_and_statutory_instrument_wales_status', true))); ?><br>
							<strong>Scotland:</strong> <?php echo esc_html($class->si_status(get_post_meta(get_the_ID(), 'exempt-in_country_and_statutory_instrument_scotland_status', true))); ?><br>
							<strong>N. Ireland:</strong> <?php echo esc_html($class->si_status(get_post_meta(get_the_ID(), 'exempt-in_country_and_statutory_instrument_n_ireland_status', true))); ?>
						</td>
						<td style="width:30%">
							<?php if(get_post_meta(get_the_ID(), 'entry_user_id', true )) { ?>
								<strong>Entry User</strong><br>
								<?php echo $class->data_entry_username(get_post_meta(get_the_ID(), 'entry_user_id', true )); ?><br>
							<?php } ?>

							<?php if(get_post_meta(get_the_ID(), 'reviewer_user_id', true )) { ?>
								<strong>Reviewer User</strong><br>
								<?php echo $class->data_entry_username(get_post_meta(get_the_ID(), 'reviewer_user_id', true )); ?>
							<?php } ?>
						</td>
						<td style="width:15%">
							<ul class="list-unstyled icon-component">
								<li>
									<a href="<?php echo the_permalink(); ?>"><i class="gg-eye"></i></a>
								</li>
								<li>
									<a href="#"><i class="gg-file-document"></i></a>
								</li>
								<li>
									<a href="<?php echo esc_html( '/fuel-audit-log/?fuel='.get_the_ID() ); ?>"><i class="gg-folder"></i></a>
								</li>
								<li>
									<a href="#"><i class="gg-attribution"></i></a>
								</li>
							</ul>
						</td>
					</tr>

				<?php endwhile; ?>

			<?php endif; ?>

		</tbody>
	</table>

<?php do_action('after_main_content'); ?>


<?php get_footer(); ?>