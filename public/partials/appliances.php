<?php 
$class = new Defra_Data_Entry_Public('DEFRA_DATA_ENTRY','DEFRA_DATA_ENTRY_VERSION');
$class->defra_get_header('data-entry');
// $db = new Defra_Data_DB_Requests();
// $appliances = $db->get_appliance_country_status($_GET['status']);
// defra_data_query_by_appliance_id($appliances);
?>

<?php do_action('before_main_content'); ?>

<div class="px-4 sm:px-6 lg:px-8">

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
		<?php if ( have_posts() ) : ?>
			<?php while ( have_posts() ) : the_post(); ?>
				<tr>
					<td style="width:5%"><?php echo get_post_meta(get_the_ID(), 'appliance_id', true ); ?></td>
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
						<ul class="icon-component">
							<li>
								<a href="<?php echo the_permalink(); ?>"><i class="gg-eye"></i></a>
							</li>
							<li>
								<a href="#"><i class="gg-file-document"></i></a>
							</li>
							<li>
								<a href="#"><i class="gg-folder"></i></a>
							</li>
							<li>
								<a href="#"><i class="gg-attribution"></i></a>
							</li>
						</ul>
					</td>
				</tr>

			<?php endwhile; ?>

		<?php endif; ?>

		<!-- <?php foreach($list_appliances as $k => $v) { ?>
			<tr>
				<td style="width:5%"><?php echo esc_html( $v['appliance_id'] ); ?></td>
				<td style="width:20%"><?php echo esc_html( $v['appliance_name'] ); ?></td>
				<td style="width:30%">
					<?php foreach($v['status'] as $key => $value) { ?>
						<strong><?php echo esc_html( $value['country_name'] ); ?>:</strong> <?php echo esc_html( $value['status'] ); ?> <br>
					<?php } ?>
				</td>
				<td style="width:30%">
					<?php foreach($v['info'] as $key => $value) { ?>
						<strong><?php echo esc_html( $value['user_type'] ); ?><br></strong>
						<?php echo esc_html( $value['user_email'] ); ?><br>
					<?php } ?>
				</td>
				<td style="width:15%">
					<ul class="icon-component">
						<li>
							<a href="/appliance-view/?appliance-id=<?php echo esc_html( $v['appliance_id'] ); ?>"><i class="gg-eye"></i></a>
						</li>
						<li>
							<a href="#"><i class="gg-file-document"></i></a>
						</li>
						<li>
							<a href="#"><i class="gg-folder"></i></a>
						</li>
						<li>
							<a href="#"><i class="gg-attribution"></i></a>
						</li>
					</ul>
				</td>
			</tr>

		<?php } ?> -->
	</tbody>
	</table>

</div>

<?php do_action('after_main_content'); ?>


<?php get_footer(); ?>