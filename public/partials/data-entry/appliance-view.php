<?php 
$class = new Defra_Data_Entry_Public('DEFRA_DATA_ENTRY','DEFRA_DATA_ENTRY_VERSION');
get_header();
?>

<?php do_action('before_main_content'); ?>


<?php if ( have_posts() ) : ?>
	<?php while ( have_posts() ) : the_post(); ?>
	
	<figure class="border border-solid border-gray-300 rounded-lg p-4 mb-4">
		<h2>Manufacturer</h2>
		<?php echo esc_html($class->get_post_title_by_id(get_post_meta(get_the_ID(), 'manufacturer', true))); ?>
	</figure>

	<figure class="border border-solid border-gray-300 rounded-lg p-4 mb-4">
		<h2>Appliance Name</h2>
		<?php the_title(); ?>
	</figure>

	<figure class="border border-solid border-gray-300 rounded-lg p-4 mb-4">
		<h2>Appliance Fuels</h2>
		<small>Permitted Fuels (other than authorised fuels)</small><br>
		<?php echo esc_html($class->get_post_title_by_id(get_post_meta(get_the_ID(), 'appliance_fuels_permitted_fuel_id', true))); ?>
	</figure>

	<figure class="border border-solid border-gray-300 rounded-lg p-4 mb-4">
		<h2>Categories</h2>
		<p>Appliance categorisation is for web search functionality only</p>

		<div class="flex space-x-4">
			<span>
				<strong>Fuel: </strong>
				<?php echo esc_html( $class->get_term_titles(get_the_ID(),'fuel_types') ); ?><br>
			</span>
			<span>
				<strong>Appliance: </strong>
				<?php echo esc_html( $class->get_term_titles(get_the_ID(),'appliance_types') ); ?><br>
			</span>
		</div>
	</figure>

	<figure class="border border-solid border-gray-300 rounded-lg p-4 mb-4">
		<h2>Appliance Output</h2>
		<div class="flex space-x-4">
			<span>
				<strong>Unit: </strong>
				<?php echo esc_html( $class->get_appliance_output_unit(get_post_meta(get_the_ID(), 'output_unit_output_unit_id', true))); ?>
			</span>
			<span>
				<strong>Value: </strong>
				<?php echo esc_html( get_post_meta(get_the_ID(), 'output_unit_output_value', true )); ?>
			</span>
		</div>
	</figure>

	<figure class="border border-solid border-gray-300 rounded-lg p-4 mb-4">
		<h2>Instructions</h2>
		<div class="flex space-x-4">
			<span>
				<strong>Manual Date: </strong>
				<?php echo esc_html( get_post_meta(get_the_ID(), 'instructions_instruction_manual_date', true)); ?>
			</span>
			<span>
				<strong>Manual Title: </strong>
				<?php echo esc_html( get_post_meta(get_the_ID(), 'instructions_instruction_manual_title', true)); ?>
			</span>
			<span>
				<strong>Manual Reference: </strong>
				<?php echo esc_html( get_post_meta(get_the_ID(), 'instructions_instruction_manual_reference', true )); ?>
			</span>
		</div>
	</figure>


	<figure class="border border-solid border-gray-300 rounded-lg p-4 mb-4">
		<h2>Servicing and Installation</h2>
		<div class="flex space-x-4">
			<span>
				<strong>Manual Date: </strong>
				<?php echo esc_html( get_post_meta(get_the_ID(), 'servicing_and_installation_servicing_install_manual_date', true)); ?>
			</span>
			<span>
				<strong>Manual Title: </strong>
				<?php echo esc_html( get_post_meta(get_the_ID(), 'servicing_and_installation_servicing_install_manual_title', true)); ?>
			</span>
			<span>
				<strong>Manual Reference: </strong>
				<?php echo esc_html( get_post_meta(get_the_ID(), 'servicing_and_installation_servicing_install_manual_reference', true )); ?>
			</span>
		</div>
	</figure>

	<figure class="border border-solid border-gray-300 rounded-lg p-4 mb-4">
		<h2>Additional Conditions</h2>
		<div class="flex space-x-4">
			<span>
				<strong>Condition: </strong>
				<?php echo esc_html( $class->get_appliance_condition(get_post_meta(get_the_ID(), 'additional_conditions_additional_condition_id', true))); ?>
			</span>
			<span>
				<strong>Condition Comments: </strong>
				<?php echo esc_html( get_post_meta(get_the_ID(), 'additional_conditions_additional_condition_comment', true)); ?>
			</span>
		</div>
	</figure>

	<figure class="border border-solid border-gray-300 rounded-lg p-4 mb-4">
		<h2>Appliance Additional Details</h2>
		<div class="flex space-x-4">
			<span>
				<strong>Application Number: </strong>
				<?php echo esc_html( get_post_meta(get_the_ID(), 'appliance_additional_details_application_number', true)); ?>
			</span>
			<span>
				<strong>Linked Applications: </strong>
				<p><?php echo esc_html( get_post_meta(get_the_ID(), 'appliance_additional_details_linked_applications', true)); ?>
			</span>
		</div>

		<strong>Comments: </strong>
		<?php echo esc_html( get_post_meta(get_the_ID(), 'appliance_additional_details_comments', true )); ?>
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

	<figure class="border border-solid border-gray-300 rounded-lg p-4 mb-4">
		<h2>User Comments</h2>
	</figure>

	<?php include(plugin_dir_path( __FILE__ ) . 'appliance-comments.php'); ?>

	<?php endwhile; ?>
<?php endif; ?>


<?php do_action('after_main_content'); ?>


<?php get_footer(); ?>