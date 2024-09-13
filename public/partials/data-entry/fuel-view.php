<?php 
$class = new Defra_Data_Entry_Public('DEFRA_DATA_ENTRY','DEFRA_DATA_ENTRY_VERSION');
$required = $class->is_a_required_field();
$user = wp_get_current_user();
$roles = $user->roles;

get_header();
?>

<?php do_action('before_main_content'); ?>


<?php if ( have_posts() ) : ?>
<?php while ( have_posts() ) : the_post(); ?>

<figure class="border border-solid border-gray-300 rounded-lg p-4 mb-4">
	<h2>Manufacturer</h2>
	<?php echo esc_html($class->get_manufacturer_title_by_id(get_the_ID())); ?>
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
		<div>
			<strong>Application Number: </strong>
			<?php echo esc_html( get_post_meta(get_the_ID(), 'fuel_additional_details_application_number', true)); ?>
		</div>
		<div>
			<strong>Linked Applications: </strong>
			<?php echo esc_html( get_post_meta(get_the_ID(), 'fuel_additional_details_linked_applications', true)); ?>
		</div>
	</div>

	<strong>Comments: </strong>
	<?php echo esc_html( get_post_meta(get_the_ID(), 'fuel_additional_details_comments', true )); ?>
</figure>

<?php if ( !in_array('data_approver', $roles) ) { ?>

<figure class="border border-solid border-gray-300 rounded-lg p-4 mb-4">
	<h2>Authorised Country and Statutory Instrument</h2>

	<figure class="border p-4 mb-4">
		<div class="row align-items-start">

			<div class="col">
				<span><?php echo esc_html(get_post_meta(get_the_ID(), 'authorised_country_and_statutory_instrument_england_enabled', true )) ? '<i class="gg-check-o"></i>' : '' ;?></span>
			</div>

			<div class="col">
				<span>England</span>
			</div>

			<div class="col">
				<?php if (get_post_meta(get_the_ID(), 'authorised_country_and_statutory_instrument_england_revoke_status_id', true) == '400') { ?>
				No
				<?php } else { ?>
				<span class="flex-grow"><?php echo esc_html($class->get_post_title_by_id(get_post_meta(get_the_ID(), 'authorised_country_and_statutory_instrument_england_si_0_si_id', true))); ?></span>
				<?php } ?>
			</div>

			<div class="col">
				<span class="flex-grow"><?php echo esc_html($class->si_status(get_post_meta(get_the_ID(), 'authorised_country_and_statutory_instrument_england_status', true))); ?></span>
			</div>
		</div>

	</figure>

	<figure class="border p-4 mb-4">
		<div class="row align-items-start">

			<div class="col">
				<span><?php echo esc_html(get_post_meta(get_the_ID(), 'authorised_country_and_statutory_instrument_wales_enabled', true )) ? '<i class="gg-check-o"></i>' : '' ;?></span>
			</div>

			<div class="col">
				<span>Wales</span>
			</div>

			<div class="col">

				<?php if (get_post_meta(get_the_ID(), 'authorised_country_and_statutory_instrument_wales_revoke_status_id', true) == '400') { ?>
				No
				<?php } else { ?>
				<span class="flex-grow"><?php echo esc_html($class->get_post_title_by_id(get_post_meta(get_the_ID(), 'authorised_country_and_statutory_instrument_wales_si_0_si_id', true))); ?></span>
				<?php } ?>

			</div>

			<div class="col">
				<span class="flex-grow"><?php echo esc_html($class->si_status(get_post_meta(get_the_ID(), 'authorised_country_and_statutory_instrument_wales_status', true))); ?></span>
			</div>
		</div>

	</figure>

	<figure class="border p-4 mb-4">
		<div class="row align-items-start">

			<div class="col">
				<span><?php echo esc_html(get_post_meta(get_the_ID(), 'authorised_country_and_statutory_instrument_scotland_enabled', true )) ? '<i class="gg-check-o"></i>' : '' ;?></span>
			</div>

			<div class="col">
				<span>Scotland</span>
			</div>

			<div class="col">
				<?php if (get_post_meta(get_the_ID(), 'authorised_country_and_statutory_instrument_scotland_revoke_status_id', true) == '400') { ?>
				No
				<?php } else { ?>
				<span class="flex-grow"><?php echo esc_html($class->get_post_title_by_id(get_post_meta(get_the_ID(), 'authorised_country_and_statutory_instrument_scotland_si_0_si_id', true))); ?></span>
				<?php } ?>

			</div>

			<div class="col">
				<span class="flex-grow"><?php echo esc_html($class->si_status(get_post_meta(get_the_ID(), 'authorised_country_and_statutory_instrument_scotland_status', true))); ?></span>
			</div>
		</div>

	</figure>

	<figure class="border p-4 mb-4">
		<div class="row align-items-start">

			<div class="col">
				<span><?php echo esc_html(get_post_meta(get_the_ID(), 'authorised_country_and_statutory_instrument_n_ireland_enabled', true )) ? '<i class="gg-check-o"></i>' : '' ;?></span>
			</div>

			<div class="col">
				<span>N. Ireland</span>
			</div>

			<div class="col">
				<?php if (get_post_meta(get_the_ID(), 'authorised_country_and_statutory_instrument_n_ireland_revoke_status_id', true) == '400') { ?>
				No
				<?php } else { ?>
				<span class="flex-grow"><?php echo esc_html($class->get_post_title_by_id(get_post_meta(get_the_ID(), 'authorised_country_and_statutory_instrument_n_ireland_si_0_si_id', true))); ?></span>
				<?php } ?>

			</div>

			<div class="col">
				<span class="flex-grow"><?php echo esc_html($class->si_status(get_post_meta(get_the_ID(), 'authorised_country_and_statutory_instrument_n_ireland_status', true))); ?></span>
			</div>
		</div>

	</figure>

</figure>

<?php } ?>


<form <?php if($required) { echo esc_attr( 'class=needs-validation' ); } ?> method="post" action="/data-entry/form-process/" <?php if($required) { echo esc_attr( 'novalidate' ); } ?>>

	<?php if ( !in_array('data_approver', $roles) ) { ?>
	<div class="mb-3">
		<label class="form-label" for="comments_to_defra_da">Comments to DEFRA / Devolved Administrations</label>
		<textarea class="form-control" id="comments_to_defra_da" name="comments_to_defra_da" <?php if($required) { echo esc_attr( 'required' ); } ?>></textarea>
		<?php if($required) { ?>
		<div class="invalid-feedback">
			Please provide a comment.
		</div>
		<?php } ?>
	</div>
	<?php } ?>

	<div class="mb-3">
		<label class="form-label" for="user_comments">User Comments</label>
		<textarea class="form-control" id="user_comments" name="user_comments" <?php if($required) { echo esc_attr( 'required' ); } ?>></textarea>
		<?php if($required) { ?>
		<div class="invalid-feedback">
			Please provide a comment.
		</div>
		<?php } ?>

	</div>

	<input type="hidden" name="process" value="status-change">
	<input type="hidden" name="post_type" value="fuel">
	<input type="hidden" name="post_id" value="<?php echo esc_attr( get_the_ID() ); ?>">
	<input type="hidden" name="submit_nonce" value="<?php echo wp_create_nonce('submit_form'); ?>">

	<?php do_action('reviewer_approve_reject', get_the_ID()); ?>

</form>


<?php include(plugin_dir_path( __FILE__ ) . 'fuel-comments.php'); ?>

<?php endwhile; ?>
<?php endif; ?>


<?php do_action('after_main_content'); ?>


<?php get_footer(); ?>
