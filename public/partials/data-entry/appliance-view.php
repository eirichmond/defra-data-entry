<?php 
$class = new Defra_Data_Entry_Public('DEFRA_DATA_ENTRY','DEFRA_DATA_ENTRY_VERSION');
$user = wp_get_current_user();
$roles = $user->roles;

$taxonomy = 'permitted_fuels'; // Replace with the taxonomy you want to retrieve terms from
$permitted_fuels = wp_get_post_terms(get_the_ID(), $taxonomy);

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
	<h2>Appliance Name</h2>
	<?php the_title(); ?>
</figure>

<figure class="border border-solid border-gray-300 rounded-lg p-4 mb-4">
	<h2>Appliance Fuels</h2>
	<small>Permitted Fuels (other than authorised fuels)</small><br>
	<?php foreach ($permitted_fuels as $term) { ?>
	<div><?php echo esc_html( $term->name ); ?></div>
	<?php } ?>
</figure>

<!-- <figure class="border border-solid border-gray-300 rounded-lg p-4 mb-4">
		<h2>Categories</h2>
		<p>Appliance categorisation is for web search functionality only</p>

		<div class="flex space-x-4">
			<div>
				<strong>Fuel: </strong>
				<?php //echo esc_html( $class->get_term_titles(get_the_ID(),'fuel_types') ); ?>
			</div>
			<div>
				<strong>Appliance: </strong>
				<?php //echo esc_html( $class->get_term_titles(get_the_ID(),'appliance_types') ); ?>
			</div>
		</div>
	</figure>
 -->
<figure class="border border-solid border-gray-300 rounded-lg p-4 mb-4">
	<h2>Appliance Output</h2>
	<div class="flex space-x-4">
		<div>
			<strong>Unit: </strong>
			<?php echo esc_html( $class->get_appliance_output_unit(get_post_meta(get_the_ID(), 'output_unit_output_unit_id', true))); ?>
		</div>
		<div>
			<strong>Value: </strong>
			<?php echo esc_html( get_post_meta(get_the_ID(), 'output_unit_output_value', true )); ?>
		</div>
	</div>
</figure>

<figure class="border border-solid border-gray-300 rounded-lg p-4 mb-4">
	<h2>Instructions</h2>
	<div class="flex space-x-4">
		<div>
			<strong>Manual Date: </strong>
			<?php echo esc_html( get_post_meta(get_the_ID(), 'instructions_instruction_manual_date', true)); ?>
		</div>
		<div>
			<strong>Manual Title: </strong>
			<?php echo esc_html( get_post_meta(get_the_ID(), 'instructions_instruction_manual_title', true)); ?>
		</div>
		<div>
			<strong>Manual Reference: </strong>
			<?php echo esc_html( get_post_meta(get_the_ID(), 'instructions_instruction_manual_reference', true )); ?>
		</div>
	</div>
</figure>


<figure class="border border-solid border-gray-300 rounded-lg p-4 mb-4">
	<h2>Servicing and Installation</h2>
	<div class="flex space-x-4">
		<div>
			<strong>Manual Date: </strong>
			<?php echo esc_html( get_post_meta(get_the_ID(), 'servicing_and_installation_servicing_install_manual_date', true)); ?>
		</div>
		<div>
			<strong>Manual Title: </strong>
			<?php echo esc_html( get_post_meta(get_the_ID(), 'servicing_and_installation_servicing_install_manual_title', true)); ?>
		</div>
		<div>
			<strong>Manual Reference: </strong>
			<?php echo esc_html( get_post_meta(get_the_ID(), 'servicing_and_installation_servicing_install_manual_reference', true )); ?>
		</div>
	</div>
</figure>

<figure class="border border-solid border-gray-300 rounded-lg p-4 mb-4">
	<h2>Additional Conditions</h2>
	<div class="flex space-x-4">
		<div>
			<strong>Condition: </strong>
			<?php echo esc_html( $class->get_appliance_condition(get_post_meta(get_the_ID(), 'additional_conditions_additional_condition_id', true))); ?>
		</div>
		<div>
			<strong>Condition Comments: </strong>
			<?php echo esc_html( get_post_meta(get_the_ID(), 'additional_conditions_additional_condition_comment', true)); ?>
		</div>
	</div>
</figure>

<figure class="border border-solid border-gray-300 rounded-lg p-4 mb-4">
	<h2>Appliance Additional Details</h2>
	<div class="flex space-x-4">
		<div>
			<strong>Application Number: </strong>
			<?php echo esc_html( get_post_meta(get_the_ID(), 'appliance_additional_details_application_number', true)); ?>
		</div>
		<div>
			<strong>Linked Applications: </strong>
			<?php echo esc_html( get_post_meta(get_the_ID(), 'appliance_additional_details_linked_applications', true)); ?>
		</div>
	</div>

	<strong>Comments: </strong>
	<?php echo esc_html( get_post_meta(get_the_ID(), 'appliance_additional_details_comments', true )); ?>
</figure>

<?php if ( !in_array('data_approver', $roles) ) { ?>

<figure class="border border-solid border-gray-300 rounded-lg p-4 mb-4">
	<h2>Exempt-In Country and Statutory Instrument</h2>

	<figure class="border p-4 mb-4">
		<div class="row align-items-start">

			<div class="col">
				<span><?php echo esc_html(get_post_meta(get_the_ID(), 'exempt-in_country_and_statutory_instrument_england_enabled', true )) ? '<i class="gg-check-o"></i>' : '' ;?></span>
			</div>

			<div class="col">
				<span>England</span>
			</div>

			<div class="col">
				<?php if (get_post_meta(get_the_ID(), 'exempt-in_country_and_statutory_instrument_england_revoke_status_id', true) == '400' || get_post_meta(get_the_ID(), 'exempt-in_country_and_statutory_instrument_england_is_published', true) == '0') { ?>
				No
				<?php } else { ?>
				<span class="flex-grow"><?php echo esc_html($class->get_post_title_by_id(get_post_meta(get_the_ID(), 'exempt-in_country_and_statutory_instrument_england_si_0_si_id', true))); ?></span>
				<?php } ?>

			</div>

			<div class="col">
				<span class="flex-grow"><?php echo esc_html($class->si_status(get_post_meta(get_the_ID(), 'exempt-in_country_and_statutory_instrument_england_status', true))); ?></span>
			</div>
		</div>

	</figure>

	<figure class="border p-4 mb-4">
		<div class="row align-items-start">

			<div class="col">
				<span><?php echo esc_html(get_post_meta(get_the_ID(), 'exempt-in_country_and_statutory_instrument_wales_enabled', true )) ? '<i class="gg-check-o"></i>' : '' ;?></span>
			</div>

			<div class="col">
				<span>Wales</span>
			</div>

			<div class="col">
				<?php if (get_post_meta(get_the_ID(), 'exempt-in_country_and_statutory_instrument_wales_revoke_status_id', true) == '400' || get_post_meta(get_the_ID(), 'exempt-in_country_and_statutory_instrument_wales_is_published', true) == '0') { ?>
				No
				<?php } else { ?>
				<span class="flex-grow"><?php echo esc_html($class->get_post_title_by_id(get_post_meta(get_the_ID(), 'exempt-in_country_and_statutory_instrument_wales_si_0_si_id', true))); ?></span>
				<?php } ?>
			</div>

			<div class="col">
				<span class="flex-grow"><?php echo esc_html($class->si_status(get_post_meta(get_the_ID(), 'exempt-in_country_and_statutory_instrument_wales_status', true))); ?></span>
			</div>
		</div>

	</figure>

	<figure class="border p-4 mb-4">
		<div class="row align-items-start">

			<div class="col">
				<span><?php echo esc_html(get_post_meta(get_the_ID(), 'exempt-in_country_and_statutory_instrument_scotland_enabled', true )) ? '<i class="gg-check-o"></i>' : '' ;?></span>
			</div>

			<div class="col">
				<span>Scotland</span>
			</div>

			<div class="col">
				<span class="flex-grow">
					<?php if (get_post_meta(get_the_ID(), 'exempt-in_country_and_statutory_instrument_scotland_revoke_status_id', true) == '400' || get_post_meta(get_the_ID(), 'exempt-in_country_and_statutory_instrument_scotland_is_published', true) == '0') { ?>
					No
					<?php } else { ?>
					<?php echo esc_html($class->get_post_title_by_id(get_post_meta(get_the_ID(), 'exempt-in_country_and_statutory_instrument_scotland_si_0_si_id', true))); ?>

					<?php } ?>

				</span>
			</div>

			<div class="col">
				<span class="flex-grow"><?php echo esc_html($class->si_status(get_post_meta(get_the_ID(), 'exempt-in_country_and_statutory_instrument_scotland_status', true))); ?></span>
			</div>
		</div>

	</figure>

	<figure class="border p-4 mb-4">
		<div class="row align-items-start">

			<div class="col">
				<span><?php echo esc_html(get_post_meta(get_the_ID(), 'exempt-in_country_and_statutory_instrument_n_ireland_enabled', true )) ? '<i class="gg-check-o"></i>' : '' ;?></span>
			</div>

			<div class="col">
				<span>N_ireland</span>
			</div>

			<div class="col">
				<?php if (get_post_meta(get_the_ID(), 'exempt-in_country_and_statutory_instrument_n_ireland_revoke_status_id', true) == '400' || get_post_meta(get_the_ID(), 'exempt-in_country_and_statutory_instrument_n_ireland_is_published', true) == '0') { ?>
				No
				<?php } else { ?>
				<span class="flex-grow"><?php echo esc_html($class->get_post_title_by_id(get_post_meta(get_the_ID(), 'exempt-in_country_and_statutory_instrument_n_ireland_si_0_si_id', true))); ?></span>
				<?php } ?>

			</div>

			<div class="col">
				<span class="flex-grow"><?php echo esc_html($class->si_status(get_post_meta(get_the_ID(), 'exempt-in_country_and_statutory_instrument_n_ireland_status', true))); ?></span>
			</div>
		</div>

	</figure>



</figure>

<?php } ?>


<form class="needs-validation" method="post" action="/data-entry/form-process/" novalidate>

	<?php if ( !in_array('data_approver', $roles) ) { ?>
	<div class="mb-3">
		<label class="form-label" for="comments_to_defra_da">Comments to DEFRA / Devolved Administrations</label>
		<textarea class="form-control" id="comments_to_defra_da" name="comments_to_defra_da" required></textarea>
		<div class="invalid-feedback">
			Please provide a comment.
		</div>
	</div>
	<?php } ?>

	<div class="mb-3">
		<label class="form-label" for="user_comments">User Comments</label>
		<textarea class="form-control" id="user_comments" name="user_comments" required></textarea>

		<div class="invalid-feedback">
			Please provide a comment.
		</div>

	</div>

	<input type="hidden" name="process" value="status-change">
	<input type="hidden" name="post_type" value="appliance">
	<input type="hidden" name="post_id" value="<?php echo esc_attr( get_the_ID() ); ?>">
	<input type="hidden" name="submit_nonce" value="<?php echo wp_create_nonce('submit_form'); ?>">

	<?php do_action('reviewer_approve_reject', get_the_ID()); ?>

</form>


<?php include(plugin_dir_path( __FILE__ ) . 'appliance-comments.php'); ?>

<?php endwhile; ?>
<?php endif; ?>


<?php do_action('after_main_content'); ?>


<?php get_footer(); ?>
