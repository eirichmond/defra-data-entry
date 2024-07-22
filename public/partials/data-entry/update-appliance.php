<?php 
$class = new Defra_Data_Entry_Public('DEFRA_DATA_ENTRY','DEFRA_DATA_ENTRY_VERSION');

$db = new Defra_Data_DB_Requests();
$list_manufacturers = $db->list_manufacturers();
$permitted_fuels = $db->list_permitted_fuels();
$appliance_fuel_terms = $class->get_appliance_taxonomy_terms('fuel_types');
$appliance_type_terms = $class->get_appliance_taxonomy_terms('appliance_types');

$output_units = $class->output_units();
$additional_conditions = $class->appliance_conditions();
$statutory_instrument_england = defra_data_query_statutory_instrument('si_countries','england');
$statutory_instrument_wales = defra_data_query_statutory_instrument('si_countries','wales');
$statutory_instrument_scotland = defra_data_query_statutory_instrument('si_countries','scotland');
$statutory_instrument_nireland = defra_data_query_statutory_instrument('si_countries','n-ireland');

if(!empty($_GET['p'])) {
	$set_fuel_types = wp_get_post_terms( $_GET['p'], 'fuel_types');
	$set_appliance_types = wp_get_post_terms( $_GET['p'], 'appliance_types');
	$set_permitted_fuels = wp_get_post_terms( $_GET['p'], 'permitted_fuels');
	$manufacturer_id = get_post_meta( $_GET['p'], 'manufacturer_id', true );
}

function find_set_key($array, $value, $type) {
	foreach ($array as $key => $item) {
		if ($value == $item->$type) {
			return true;
		}
	}
	return false;
}


get_header();
?>


<?php do_action('before_main_content'); ?>

<h1 class="entry-title"><?php the_title(); ?></h1>

<?php if(isset($_GET['post']) && 'success' == $_GET['post']) { ?>
	<div class="alert alert-success" role="alert">
		New Appliance Successfully Saved!
	</div>
<?php } ?>


<form class="w-full" action="/data-entry/form-process/" method="post">


<!-- to insert duplication functionality -->


	<fieldset>
		<legend>Manufacturer</legend>

		<div class="mb-3">
			<select class="form-select js-example-basic-single" id="manufacturer_id" name="manufacturer_id">
				<option selected value="">Select a Manufacturer</option>
				<?php foreach($list_manufacturers as $k => $v) { ?>
					<option value="<?php echo esc_attr( $k ); ?>"<?php echo esc_html( !empty($manufacturer_id) && $manufacturer_id ==  $k ? ' selected' : '' ); ?>><?php echo esc_attr( $v['manufacturer_name'] ); ?></option>
				<?php } ?>
			</select>
		</div>
	</fieldset>

	<fieldset>
		<legend>Appliance Name</legend>
		<div class="mb-3">
			<textarea class="form-control" id="appliance_name" rows="3" name="appliance_name" value="<?php echo esc_attr( isset($_GET['p']) && null != $_GET['p']) ? get_the_title( $_GET['p'] ) : ''; ?>"><?php echo esc_attr( isset($_GET['p']) && null != $_GET['p'] ? get_the_title( $_GET['p'] ) : '' ); ?></textarea>
		</div>
	</fieldset>

	<fieldset>
		<legend>Appliance Fuels</legend>
		<div class="mb-3">
			<label for="permitted_fuels" class="form-label">Permitted Fuels <small>(other than authorised fuels)</small></label>
			<select class="form-select js-multiple" id="permitted_fuel_id" name="permitted_fuel_id[]" multiple="multiple">
				<?php foreach($permitted_fuels as $k => $v) {
					$key = find_set_key( $set_permitted_fuels, $k, 'slug' ); ?>

					<option value="<?php echo esc_attr( $k ); ?>" <?php echo esc_attr( false != $key ? 'selected' : '' ); ?>><?php echo esc_attr( $v["permitted_fuel_name"] ); ?></option>
				<?php } ?>
			</select>
		</div>
	</fieldset>

	<fieldset>
		<legend>Categories</legend>
		<div class="mb-3">
			<p>Appliance categorisation is for web search functionality only</p>

			<div class="row">
				<div class="col-3">

					<label for="fuel_types" class="form-label">Fuel</label>
					<select class="form-select" id="fuel_types" name="fuel_types">
						<?php foreach($appliance_fuel_terms as $k => $v) {
							$key = find_set_key( $set_fuel_types, $v->slug, 'slug' ); ?>
							<option value="<?php echo esc_attr( $v->slug ); ?>" <?php echo esc_attr( false != $key ? 'selected' : '' ); ?>> <?php echo esc_attr( $v->name ); ?> </option>
						<?php } ?>
					</select>

				</div>
				<div class="col-3">

					<label for="type_terms" class="form-label">Appliance</label>
					<select class="form-select" id="type_terms" name="type_terms">
						<?php foreach($appliance_type_terms as $k => $v) { 
							$key = find_set_key( $set_appliance_types, $v->slug, 'slug' ); ?>
							<option value="<?php echo esc_attr( $v->slug ); ?>" <?php echo esc_attr( false != $key ? 'selected' : '' ); ?>><?php echo esc_attr( $v->name ); ?></option>
						<?php } ?>
					</select>

				</div>
			</div>

		</div>
	</fieldset>

	<fieldset>
		<legend>Appliance Output</legend>
		<div class="mb-3">
			<div class="row">
				<div class="col-3">

					<label for="output_unit_output_unit_id" class="form-label">Unit</label>
					<select class="form-select" id="output_unit_output_unit_id" name="output_unit_output_unit_id">
						<option selected value="">Please select</option>
						<?php foreach($output_units as $k => $v) {
							$output_unit_output_unit_id = get_post_meta( $_GET['p'], 'output_unit_output_unit_id', true );
							?>
							<option value="<?php echo esc_attr( $k ); ?>" <?php echo esc_attr( $output_unit_output_unit_id == $k ? 'selected' : '' ); ?>><?php echo esc_attr( $v ); ?></option>
						<?php } ?>
					</select>

				</div>
				<div class="col-3">

					<label for="output_unit_output_value" class="form-label">Value</label>
					<input type="text" class="form-control" id="output_unit_output_value" name="output_unit_output_value" value="<?php echo esc_attr( get_post_meta( $_GET['p'], 'output_unit_output_value', true ) ? get_post_meta( $_GET['p'], 'output_unit_output_value', true ) : '' ); ?>">

				</div>
			</div>

		</div>
	</fieldset>

	<fieldset>
		<legend>Instructions</legend>
		<div class="mb-3">
			<div class="row">
				<div class="col-3">

					<label for="instructions_instruction_manual_date" class="form-label">Manual Date</label>
					<input type="date" class="form-control" id="instructions_instruction_manual_date" name="instructions_instruction_manual_date" value="<?php echo esc_attr( get_post_meta( $_GET['p'], 'instructions_instruction_manual_date', true ) ? get_post_meta( $_GET['p'], 'instructions_instruction_manual_date', true ) : '' ); ?>">
					
				</div>
				<div class="col-6">
					
					<label for="instructions_instruction_manual_title" class="form-label">Manual Title</label>
					<input type="text" class="form-control" id="instructions_instruction_manual_title" name="instructions_instruction_manual_title" value="<?php echo esc_attr( get_post_meta( $_GET['p'], 'instructions_instruction_manual_title', true ) ? get_post_meta( $_GET['p'], 'instructions_instruction_manual_title', true ) : '' ); ?>">

				</div>
				<div class="col-3">
					
					<label for="instructions_instruction_manual_reference" class="form-label">Manual Reference</label>
					<input type="text" class="form-control" id="instructions_instruction_manual_reference" name="instructions_instruction_manual_reference" value="<?php echo esc_attr( get_post_meta( $_GET['p'], 'instructions_instruction_manual_reference', true ) ? get_post_meta( $_GET['p'], 'instructions_instruction_manual_reference', true ) : '' ); ?>">

				</div>
			</div>

		</div>
	</fieldset>

	<fieldset>
		<legend>Servicing and Installation</legend>
		<div class="mb-3">
			<div class="row">
				<div class="col-3">

					<label for="servicing_and_installation_servicing_install_manual_date" class="form-label">Manual Date</label>
					<input type="date" class="form-control" id="servicing_and_installation_servicing_install_manual_date" name="servicing_and_installation_servicing_install_manual_date" value="<?php echo esc_attr( get_post_meta( $_GET['p'], 'servicing_and_installation_servicing_install_manual_date', true ) ? get_post_meta( $_GET['p'], 'servicing_and_installation_servicing_install_manual_date', true ) : '' ); ?>">
					
				</div>
				<div class="col-6">
					
					<label for="servicing_and_installation_servicing_install_manual_title" class="form-label">Manual Title</label>
					<input type="text" class="form-control" id="servicing_and_installation_servicing_install_manual_title" name="servicing_and_installation_servicing_install_manual_title" value="<?php echo esc_attr( get_post_meta( $_GET['p'], 'servicing_and_installation_servicing_install_manual_title', true ) ? get_post_meta( $_GET['p'], 'servicing_and_installation_servicing_install_manual_title', true ) : '' ); ?>">

				</div>
				<div class="col-3">
					
					<label for="servicing_and_installation_servicing_install_manual_reference" class="form-label">Manual Reference</label>
					<input type="text" class="form-control" id="servicing_and_installation_servicing_install_manual_reference" name="servicing_and_installation_servicing_install_manual_reference" value="<?php echo esc_attr( get_post_meta( $_GET['p'], 'servicing_and_installation_servicing_install_manual_reference', true ) ? get_post_meta( $_GET['p'], 'servicing_and_installation_servicing_install_manual_reference', true ) : '' ); ?>">

				</div>
			</div>

		</div>
	</fieldset>

	<fieldset>
		<legend>Additional Conditions</legend>
		<div class="mb-3">
			<div class="row">
				<div class="col-3">

					<label for="additional_conditions_additional_condition_id" class="form-label">Condition</label>
					<select class="form-select" id="additional_conditions_additional_condition_id" name="additional_conditions_additional_condition_id">
						<option selected value="">Please select</option>
						<?php foreach($additional_conditions as $k => $v) {
							$additional_conditions_additional_condition_id = get_post_meta( $_GET['p'], 'additional_conditions_additional_condition_id', true );
							?>
							<option value="<?php echo esc_attr( $k ); ?>" <?php echo esc_attr( $additional_conditions_additional_condition_id == $k ? 'selected' : '' ); ?>><?php echo esc_attr( $v ); ?></option>
						<?php } ?>
					</select>

				</div>
				<div class="col-9">

					<label for="additional_conditions_additional_condition_comment" class="form-label">Value</label>
					<textarea class="form-control" id="additional_conditions_additional_condition_comment" name="additional_conditions_additional_condition_comment" rows="3"><?php echo esc_attr( get_post_meta( $_GET['p'], 'additional_conditions_additional_condition_comment', true ) ); ?></textarea>

				</div>
			</div>

		</div>
	</fieldset>

	<fieldset>
		<legend>Appliance Additional Details</legend>
		<div class="mb-3">

			<div class="row">
				<div class="col-4">

					<label for="appliance_additional_details_application_number" class="form-label">Application Number</label>
					<input type="text" class="form-control" id="appliance_additional_details_application_number" name="appliance_additional_details_application_number" value="<?php echo esc_attr( get_post_meta( $_GET['p'], 'appliance_additional_details_application_number', true ) ? get_post_meta( $_GET['p'], 'appliance_additional_details_application_number', true ) : '' ); ?>">
					
				</div>
				<div class="col-8">
					
					<label for="appliance_additional_details_linked_applications" class="form-label">Linked Applications</label>
					<input type="text" class="form-control" id="appliance_additional_details_linked_applications" name="appliance_additional_details_linked_applications" value="<?php echo esc_attr( get_post_meta( $_GET['p'], 'appliance_additional_details_linked_applications', true ) ? get_post_meta( $_GET['p'], 'appliance_additional_details_linked_applications', true ) : '' ); ?>">

				</div>
			</div>

			<div class="row">
				<div class="col-12">

					<label for="appliance_additional_details_comments" class="form-label">Comments</label>
					<textarea class="form-control" id="appliance_additional_details_comments" name="appliance_additional_details_comments" rows="3"><?php echo esc_attr( get_post_meta( $_GET['p'], 'appliance_additional_details_comments', true ) ); ?></textarea>
					
				</div>
			</div>

		</div>
	</fieldset>

	<fieldset>
		<legend>Exempt-In Country and Statutory Instrument</legend>
		<div class="mb-3">

			<div class="row">
				<div class="col-2">

					<input class="form-check-input" type="checkbox" id="exempt-in_country_and_statutory_instrument_england_enabled" name="exempt-in_country_and_statutory_instrument_england_enabled" <?php echo esc_attr( get_post_meta( $_GET['p'], 'exempt-in_country_and_statutory_instrument_england_enabled', true ) ? 'checked' : '' ); ?>>
					<label class="form-check-label" for="exempt-in_country_and_statutory_instrument_england_enabled">
						England
					</label>

				</div>
				<div class="col-8">

					<select class="form-select js-multiple" id="exempt-in_country_and_statutory_instrument_england_si" name="exempt-in_country_and_statutory_instrument_england_si[]" multiple="multiple">
						<option value="" disabled>Select</option>
						<?php foreach($statutory_instrument_england as $k => $v) { 

							$sis = exempt_statutory_instrument( $_GET['p'], 'england' ); ?>
							<option value="<?php echo esc_attr( $v->ID ); ?>" <?php echo esc_attr( in_array( $v->ID, $sis ) ? 'selected' : '' ); ?>><?php echo esc_attr( $v->post_title ); ?></option>
						<?php } ?>
					</select>

				
				</div>
			</div>


		</div>
		<div class="mb-3">

			<div class="row">
				<div class="col-2">

					<input class="form-check-input" type="checkbox" id="exempt-in_country_and_statutory_instrument_wales_enabled" name="exempt-in_country_and_statutory_instrument_wales_enabled" <?php echo esc_attr( get_post_meta( $_GET['p'], 'exempt-in_country_and_statutory_instrument_wales_enabled', true ) ? 'checked' : '' ); ?>>
					<label class="form-check-label" for="exempt-in_country_and_statutory_instrument_wales_enabled">
						Wales
					</label>

				</div>
				<div class="col-8">

					<select class="form-select js-multiple" id="exempt-in_country_and_statutory_instrument_wales_si" name="exempt-in_country_and_statutory_instrument_wales_si[]" multiple="multiple">
						<option value="" disabled>Select</option>
						<?php foreach($statutory_instrument_england as $k => $v) {
							$sis = exempt_statutory_instrument( $_GET['p'], 'wales' ); ?>
							<option value="<?php echo esc_attr( $v->ID ); ?>" <?php echo esc_attr( in_array( $v->ID, $sis ) ? 'selected' : '' ); ?>><?php echo esc_attr( $v->post_title ); ?></option>
						<?php } ?>
					</select>

				
				</div>
			</div>


		</div>
		<div class="mb-3">

			<div class="row">
				<div class="col-2">

					<input class="form-check-input" type="checkbox" id="exempt-in_country_and_statutory_instrument_scotland_enabled" name="exempt-in_country_and_statutory_instrument_scotland_enabled" <?php echo esc_attr( get_post_meta( $_GET['p'], 'exempt-in_country_and_statutory_instrument_scotland_enabled', true ) ? 'checked' : '' ); ?>>
					<label class="form-check-label" for="exempt-in_country_and_statutory_instrument_scotland_enabled">
						Scotland
					</label>

				</div>
				<div class="col-8">

					<select class="form-select js-multiple" id="exempt-in_country_and_statutory_instrument_scotland_si" name="exempt-in_country_and_statutory_instrument_scotland_si[]" multiple="multiple">
						<option value="" disabled>Select</option>
						<?php foreach($statutory_instrument_scotland as $k => $v) {
							$sis = exempt_statutory_instrument( $_GET['p'], 'scotland' ); ?>
							<option value="<?php echo esc_attr( $v->ID ); ?>" <?php echo esc_attr( in_array( $v->ID, $sis ) ? 'selected' : '' ); ?>><?php echo esc_attr( $v->post_title ); ?></option>
						<?php } ?>
					</select>

				
				</div>
			</div>

		</div>
		<div class="mb-3">

			<div class="row">
				<div class="col-2">

					<input class="form-check-input" type="checkbox" id="exempt-in_country_and_statutory_instrument_n_ireland_enabled" name="exempt-in_country_and_statutory_instrument_n_ireland_enabled" <?php echo esc_attr( get_post_meta( $_GET['p'], 'exempt-in_country_and_statutory_instrument_n_ireland_enabled', true ) ? 'checked' : '' ); ?>>
					<label class="form-check-label" for="exempt-in_country_and_statutory_instrument_n_ireland_enabled">
						N. Ireland
					</label>

				</div>
				<div class="col-8">

					<select class="form-select js-multiple" id="exempt-in_country_and_statutory_instrument_n_ireland_si" name="exempt-in_country_and_statutory_instrument_n_ireland_si[]" multiple="multiple">
						<option value="" disabled>Select</option>	
						<?php foreach($statutory_instrument_nireland as $k => $v) {
							$sis = exempt_statutory_instrument( $_GET['p'], 'n_ireland' ); ?>
							<option value="<?php echo esc_attr( $v->ID ); ?>" <?php echo esc_attr( in_array( $v->ID, $sis ) ? 'selected' : '' ); ?>><?php echo esc_attr( $v->post_title ); ?></option>
						<?php } ?>
					</select>

				
				</div>
			</div>


		</div>
	</fieldset>

	<fieldset>
		<legend>Comments to DEFRA / Devolved Administrations</legend>
		<div class="mb-3">
			<textarea class="form-control" id="??" rows="3" name="comment_to_da"></textarea>
		</div>
	</fieldset>

	<fieldset>
		<legend>User Comments</legend>
		<div class="mb-3">
			<textarea class="form-control" id="??" rows="3" name="user_comment"></textarea>
		</div>
	</fieldset>

	<input type="hidden" name="process" value="create-appliance">
	<input type="hidden" name="post_id" value="<?php echo esc_attr( $_GET['p'] ); ?>">
	<?php wp_nonce_field( 'create_nonce', 'create_nonce_field' ); ?>

	<button type="submit" class="btn btn-primary mt-3 save-draft" name="submit-type" value="save-draft">Save as draft</button>
	<button type="submit" class="btn btn-primary mt-3 submit" name="submit-type" value="submit-review">Save and Send for Review</button>
	
</form>


<?php do_action('after_main_content'); ?>


<?php get_footer(); ?>