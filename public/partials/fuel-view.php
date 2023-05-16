<?php 
$class = new Defra_Data_Entry_Public('DEFRA_DATA_ENTRY','DEFRA_DATA_ENTRY_VERSION');
$class->defra_get_header('data-entry');
?>

<?php do_action('before_main_content'); ?>


<?php if ( have_posts() ) : ?>
	<?php while ( have_posts() ) : the_post(); ?>
	
	<figure class="border border-solid border-gray-300 rounded-lg p-4 mb-4">
		<h2>Manufacturer</h2>
		<?php echo esc_html($class->get_post_title_by_id(get_post_meta(get_the_ID(), 'manufacturer', true))); ?>
	</figure>

	<figure class="border border-solid border-gray-300 rounded-lg p-4 mb-4">
		<h2>Fuel Name</h2>
		<div class="mb-2"><?php the_title(); ?></div>
		<ul>
			<li class="mb-2">a&#41; <?php echo esc_html( get_post_meta(get_the_ID(), 'point_a', true )); ?></li>
			<li class="mb-2">b&#41; <?php echo esc_html( get_post_meta(get_the_ID(), 'point_b', true )); ?></li>
			<li class="mb-2">c&#41; <?php echo esc_html( get_post_meta(get_the_ID(), 'point_c', true )); ?></li>
			<li class="mb-2">d&#41; <?php echo esc_html( get_post_meta(get_the_ID(), 'point_d', true )); ?></li>
			<li class="mb-2">e&#41; <?php echo esc_html( get_post_meta(get_the_ID(), 'point_e', true )); ?></li>
			<li class="mb-2">f&#41; <?php echo esc_html( get_post_meta(get_the_ID(), 'point_f', true )); ?></li>
		</ul>
	</figure>

	
	<figure class="border border-solid border-gray-300 rounded-lg p-4 mb-4">
		<h2>Fuel Additional Details</h2>
		<div class="flex space-x-4">
			<span>
				<strong>Application Number: </strong>
				<?php echo esc_html( get_post_meta(get_the_ID(), 'fuel_additional_details_application_number', true)); ?>
			</span>
			<span>
				<strong>Linked Applications: </strong>
				<p><?php echo esc_html( get_post_meta(get_the_ID(), 'fuel_additional_details_linked_applications', true)); ?>
			</span>
		</div>

		<strong>Comments: </strong>
		<?php echo esc_html( get_post_meta(get_the_ID(), 'fuel_additional_details_comments', true )); ?>
	</figure>

	<figure class="border border-solid border-gray-300 rounded-lg p-4 mb-4">
		<h2>Exempt-In Country and Statutory Instrument</h2>
		<figure class="border border-solid border-gray-300 rounded-lg p-4 mb-4">
			<div class="flex space-x-4">
				<span class="flex-grow"><?php echo esc_html(get_post_meta(get_the_ID(), 'exempt-in_country_and_statutory_instrument_england_enabled', true )) ? '<i class="gg-check-o"></i>' : '' ;?></span>
				<span class="flex-grow">England</span>
				<span class="flex-grow"><?php echo esc_html($class->get_post_title_by_id(get_post_meta(get_the_ID(), 'exempt-in_country_and_statutory_instrument_england_si', true))); ?></span>
				<span class="flex-grow"><?php echo esc_html($class->si_status(get_post_meta(get_the_ID(), 'exempt-in_country_and_statutory_instrument_england_status', true))); ?></span>
			</div>
		</figure>

		<figure class="border border-solid border-gray-300 rounded-lg p-4 mb-4">
			<div class="flex space-x-4">
				<span class="flex-grow"><?php echo esc_html(get_post_meta(get_the_ID(), 'exempt-in_country_and_statutory_instrument_wales_enabled', true )) ? '<i class="gg-check-o"></i>' : '<i class="gg-radio-check"></i>' ;?></span>
				<span class="flex-grow">Wales</span>
				<span class="flex-grow"><?php echo esc_html($class->get_post_title_by_id(get_post_meta(get_the_ID(), 'exempt-in_country_and_statutory_instrument_wales_si', true))); ?></span>
				<span class="flex-grow"><?php echo esc_html($class->si_status(get_post_meta(get_the_ID(), 'exempt-in_country_and_statutory_instrument_wales_status', true))); ?></span>
			</div>
		</figure>

		<figure class="border border-solid border-gray-300 rounded-lg p-4 mb-4">
			<div class="flex space-x-4">
				<span class="flex-grow"><?php echo esc_html(get_post_meta(get_the_ID(), 'exempt-in_country_and_statutory_instrument_scotland_enabled', true )) ? '<i class="gg-check-o"></i>' : '' ;?></span>
				<span class="flex-grow">Scotland</span>
				<span class="flex-grow"><?php echo esc_html($class->get_post_title_by_id(get_post_meta(get_the_ID(), 'exempt-in_country_and_statutory_instrument_scotland_si', true))); ?></span>
				<span class="flex-grow"><?php echo esc_html($class->si_status(get_post_meta(get_the_ID(), 'exempt-in_country_and_statutory_instrument_scotland_status', true))); ?></span>
			</div>
		</figure>

		<figure class="border border-solid border-gray-300 rounded-lg p-4 mb-4">
			<div class="flex space-x-4">
				<span class="flex-grow"><?php echo esc_html(get_post_meta(get_the_ID(), 'exempt-in_country_and_statutory_instrument_n_ireland_enabled', true )) ? '<i class="gg-check-o"></i>' : '' ;?></span>
				<span class="flex-grow">N.Ireland</span>
				<span class="flex-grow"><?php echo esc_html($class->get_post_title_by_id(get_post_meta(get_the_ID(), 'exempt-in_country_and_statutory_instrument_n_ireland_si', true))); ?></span>
				<span class="flex-grow"><?php echo esc_html($class->si_status(get_post_meta(get_the_ID(), 'exempt-in_country_and_statutory_instrument_n_ireland_status', true))); ?></span>
			</div>
		</figure>

	</figure>
	
	<figure class="border border-solid border-gray-300 rounded-lg p-4 mb-4">
		<h2>Comments to DEFRA / Devolved Administrations</h2>
	</figure>

	<figure class="border border-solid border-gray-300 rounded-lg p-4 mb-2">

		<h2 class="mb-2">User Comments</h2>

		<?php $comments = get_comments( array( 'post_id' => get_the_ID() ) ); ?>
		<?php
		if($comments):
		foreach ( $comments as $comment ) { ?>

			<figure class="flex border border-solid border-gray-z00 rounded-xl p-2">
				<div class="w-1/3 p-2 text-left">
					<p class="font-semibold m-0 p-0">Comment Type: <span class="font-normal"><?php echo esc_html( $class->get_comment_type_by_key( get_comment_meta($comment->comment_ID, 'comment_type_id', true) ) );?></span></p>
					<p class="font-semibold m-0 p-0">Action Type: <span class="font-normal"><?php echo esc_html( $class->get_comment_action_by_key( get_comment_meta($comment->comment_ID, 'comment_action_id', true) ) );?></span></p>
					<p class="font-semibold m-0 p-0">User: <span class="font-normal"><?php echo esc_html( $class->data_entry_username( $comment->user_id ) );?></span></p>
					<p class="font-semibold m-0 p-0">Date: <span class="font-normal"><?php echo esc_html( $comment->comment_date );?></span></p>
				</div>
				<div class="w-2/3 p-2 text-left">
					<p><?php echo esc_html( $comment->comment_content );?></p>
				</div>
			</figure>

		<?php } endif; ?>

	</figure>

	

	



	<?php endwhile; ?>
<?php endif; ?>


<?php do_action('after_main_content'); ?>


<?php get_footer(); ?>