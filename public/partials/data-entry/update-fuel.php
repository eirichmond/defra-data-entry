<?php
$class = new Defra_Data_Entry_Public('DEFRA_DATA_ENTRY','1.0');
$db = new Defra_Data_DB_Requests();

$list_manufacturers = $db->list_manufacturers();
$statutory_instrument_england = defra_data_query_statutory_instrument('si_countries','england', 'fuel' );
$statutory_instrument_wales = defra_data_query_statutory_instrument('si_countries','wales', 'fuel' );
$statutory_instrument_scotland = defra_data_query_statutory_instrument('si_countries','scotland', 'fuel' );
$statutory_instrument_nireland = defra_data_query_statutory_instrument('si_countries','n-ireland', 'fuel' );

if(!empty($_GET['p'])) {
	$manufacturer_id = get_post_meta( $_GET['p'], 'manufacturer_id', true );
} else {
	global $post;
	$_GET['p'] = $post->ID;
}

get_header(); ?>

<?php do_action('before_main_content'); ?>

<h1 class="entry-title"><?php the_title(); ?></h1>

<?php if(isset($_GET['post']) && 'success' == $_GET['post']) { ?>
<div class="alert alert-success" role="alert">
	New Fuel Successfully Saved!
</div>
<?php } ?>

<form class="w-full" action="/data-entry/form-process/" method="post">

	<fieldset>
		<legend>Manufacturer</legend>

		<div class="mb-3">
			<select class="form-select js-example-basic-single" id="manufacturer_id" name="manufacturer_id">
				<option selected value="">Select a Manufacturer</option>
				<?php foreach($list_manufacturers as $k => $v) { ?>
				<option value="<?php echo esc_attr( $k ); ?>" <?php echo esc_html( !empty($manufacturer_id) && $manufacturer_id ==  $k ? ' selected' : '' ); ?>><?php echo esc_attr( $v['manufacturer_name'] ); ?></option>
				<?php } ?>
			</select>
		</div>
	</fieldset>

	<fieldset>
		<legend>Fuel ID</legend>

		<div class="mb-3">
			<input type="text" class="form-control" id="fuel_id" name="fuel_id" value="<?php echo esc_attr( isset($_GET['p']) && null != $_GET['p']) ? get_post_meta( $_GET['p'], 'fuel_id', true ) : ''; ?>">
		</div>
	</fieldset>


	<fieldset>
		<legend>Fuel Name</legend>


		<div class="mb-3">
			<textarea class="form-control" id="fuel_name" rows="3" name="fuel_name" value="<?php echo esc_attr( isset($_GET['p']) && null != $_GET['p']) ? get_the_title( $_GET['p'] ) : ''; ?>"><?php echo esc_attr( isset($_GET['p']) && null != $_GET['p'] ? get_the_title( $_GET['p'] ) : '' ); ?></textarea>
		</div>
		<div class="mb-3 row">

			<label for="point_a" class="col-sm-1 col-form-label">a)</label>
			<div class="col-sm-11">
				<textarea class="form-control" id="point_a" rows="3" name="point_a" value="<?php echo esc_attr( isset($_GET['p']) && null != $_GET['p']) ? get_post_meta( $_GET['p'], 'point_a', true ) : ''; ?>"><?php echo esc_attr( isset($_GET['p']) && null != $_GET['p'] ? get_post_meta( $_GET['p'], 'point_a', true ) : '' ); ?></textarea>
			</div>

		</div>
		<div class="mb-3 row">
			<label for="point_b" class="col-sm-1 col-form-label">b)</label>
			<div class="col-sm-11">
				<textarea class="form-control" id="point_b" rows="3" name="point_b" value="<?php echo esc_attr( isset($_GET['p']) && null != $_GET['p']) ? get_post_meta( $_GET['p'], 'point_b', true ) : ''; ?>"><?php echo esc_attr( isset($_GET['p']) && null != $_GET['p'] ? get_post_meta( $_GET['p'], 'point_b', true ) : '' ); ?></textarea>
			</div>

		</div>
		<div class="mb-3 row">
			<label for="point_c" class="col-sm-1 col-form-label">c)</label>
			<div class="col-sm-11">
				<textarea class="form-control" id="point_c" rows="3" name="point_c" value="<?php echo esc_attr( isset($_GET['p']) && null != $_GET['p']) ? get_post_meta( $_GET['p'], 'point_c', true ) : ''; ?>"><?php echo esc_attr( isset($_GET['p']) && null != $_GET['p'] ? get_post_meta( $_GET['p'], 'point_c', true ) : '' ); ?></textarea>
			</div>
		</div>
		<div class="mb-3 row">
			<label for="point_d" class="col-sm-1 col-form-label">d)</label>
			<div class="col-sm-11">
				<textarea class="form-control" id="point_d" rows="3" name="point_d" value="<?php echo esc_attr( isset($_GET['p']) && null != $_GET['p']) ? get_post_meta( $_GET['p'], 'point_d', true ) : ''; ?>"><?php echo esc_attr( isset($_GET['p']) && null != $_GET['p'] ? get_post_meta( $_GET['p'], 'point_d', true ) : '' ); ?></textarea>
			</div>
		</div>

		<div class="mb-3 row">
			<label for="point_e" class="col-sm-1 col-form-label">e)</label>
			<div class="col-sm-11">
				<textarea class="form-control" id="point_e" rows="3" name="point_e" value="<?php echo esc_attr( isset($_GET['p']) && null != $_GET['p']) ? get_post_meta( $_GET['p'], 'point_e', true ) : ''; ?>"><?php echo esc_attr( isset($_GET['p']) && null != $_GET['p'] ? get_post_meta( $_GET['p'], 'point_e', true ) : '' ); ?></textarea>
			</div>
		</div>
		<div class="mb-3 row">
			<label for="point_f" class="col-sm-1 col-form-label">f)</label>
			<div class="col-sm-11">
				<textarea class="form-control" id="point_f" rows="3" name="point_f" value="<?php echo esc_attr( isset($_GET['p']) && null != $_GET['p']) ? get_post_meta( $_GET['p'], 'point_f', true ) : ''; ?>"><?php echo esc_attr( isset($_GET['p']) && null != $_GET['p'] ? get_post_meta( $_GET['p'], 'point_f', true ) : '' ); ?></textarea>
			</div>
		</div>
	</fieldset>

	<fieldset>
		<legend>Fuel Additional Details</legend>
		<div class="mb-3">

			<div class="row">
				<div class="col-4">

					<label for="fuel_additional_details_application_number" class="form-label">Application Number</label>
					<input type="text" class="form-control" id="fuel_additional_details_application_number" name="fuel_additional_details_application_number" value="<?php echo esc_attr( isset($_GET['p']) && null != $_GET['p']) ? get_post_meta( $_GET['p'], 'fuel_additional_details_application_number', true ) : ''; ?>">

				</div>
				<div class="col-8">

					<label for="fuel_additional_details_linked_applications" class="form-label">Linked Applications</label>
					<input type="text" class="form-control" id="fuel_additional_details_linked_applications" name="fuel_additional_details_linked_applications" value="<?php echo esc_attr( isset($_GET['p']) && null != $_GET['p']) ? get_post_meta( $_GET['p'], 'fuel_additional_details_linked_applications', true ) : ''; ?>">

				</div>
			</div>

			<div class="row">
				<div class="col-12">

					<label for="fuel_additional_details_comments" class="form-label">Comments</label>
					<textarea class="form-control" id="fuel_additional_details_comments" name="fuel_additional_details_comments" rows="3" value="<?php echo esc_attr( isset($_GET['p']) && null != $_GET['p']) ? get_post_meta( $_GET['p'], 'fuel_additional_details_comments', true ) : ''; ?>"><?php echo esc_attr( isset($_GET['p']) && null != $_GET['p']) ? get_post_meta( $_GET['p'], 'fuel_additional_details_comments', true ) : ''; ?></textarea>

				</div>
			</div>

		</div>
	</fieldset>


	<fieldset>
		<legend>Authorised Country and Statutory Instrument</legend>
		<div class="mb-3">

			<div class="row">
				<div class="col-2">

					<input class="form-check-input" type="checkbox" id="authorised_country_and_statutory_instrument_england_enabled" name="authorised_country_and_statutory_instrument_england_enabled" <?php echo esc_attr(isset($_GET['p']) && get_post_meta( $_GET['p'], 'authorised_country_and_statutory_instrument_england_enabled', true ) ? 'checked' : '' ); ?>>

					<label class="form-check-label" for="authorised_country_and_statutory_instrument_england_enabled">
						England
					</label>

				</div>
				<div class="col-8">

					<select class="form-select js-multiple" id="authorised_country_and_statutory_instrument_england_si" name="authorised_country_and_statutory_instrument_england_si[]" multiple="multiple">
						<option value="" disabled>Select</option>
						<?php foreach($statutory_instrument_england as $k => $v) {
                                    
                                    $ais = authorised_statutory_instrument( $_GET['p'], 'england' ) ?>
						<option value="<?php echo esc_attr( $v->ID ); ?>" <?php echo esc_attr( in_array( $v->ID, $ais ) ? 'selected' : '' ); ?>><?php echo esc_attr( $v->post_title ); ?></option>
						<?php } ?>
					</select>

				</div>
			</div>
		</div>

		<div class="mb-3">

			<div class="row">
				<div class="col-2">

					<input class="form-check-input" type="checkbox" id="authorised_country_and_statutory_instrument_wales_enabled" name="authorised_country_and_statutory_instrument_wales_enabled" <?php echo esc_attr( isset($_GET['p']) && get_post_meta( $_GET['p'], 'authorised_country_and_statutory_instrument_wales_enabled', true ) ? 'checked' : '' ); ?>>
					<label class="form-check-label" for="authorised_country_and_statutory_instrument_wales_enabled">
						Wales
					</label>

				</div>
				<div class="col-8">

					<select class="form-select js-multiple" id="authorised_country_and_statutory_instrument_wales_si" name="authorised_country_and_statutory_instrument_wales_si[]" multiple="multiple">
						<option value="" disabled>Select</option>
						<?php foreach($statutory_instrument_england as $k => $v) {
                                    $ais = authorised_statutory_instrument( $_GET['p'], 'wales' ) ?>
						<option value="<?php echo esc_attr( $v->ID ); ?>" <?php echo esc_attr( in_array( $v->ID, $ais ) ? 'selected' : '' ); ?>><?php echo esc_attr( $v->post_title ); ?></option>
						<?php } ?>
					</select>


				</div>
			</div>


		</div>
		<div class="mb-3">

			<div class="row">
				<div class="col-2">

					<input class="form-check-input" type="checkbox" id="authorised_country_and_statutory_instrument_scotland_enabled" name="authorised_country_and_statutory_instrument_scotland_enabled" <?php echo esc_attr( isset($_GET['p']) && get_post_meta( $_GET['p'], 'authorised_country_and_statutory_instrument_scotland_enabled', true ) ? 'checked' : '' ); ?>>
					<label class="form-check-label" for="authorised_country_and_statutory_instrument_scotland_enabled">
						Scotland
					</label>

				</div>
				<div class="col-8">

					<select class="form-select js-multiple" id="authorised_country_and_statutory_instrument_scotland_si" name="authorised_country_and_statutory_instrument_scotland_si[]" multiple="multiple">
						<option value="" disabled>Select</option>
						<?php foreach($statutory_instrument_scotland as $k => $v) {
                                    $ais = authorised_statutory_instrument( $_GET['p'], 'scotland' ) ?>
						<option value="<?php echo esc_attr( $v->ID ); ?>" <?php echo esc_attr( in_array( $v->ID, $ais ) ? 'selected' : '' ); ?>><?php echo esc_attr( $v->post_title ); ?></option>
						<?php } ?>
					</select>


				</div>
			</div>

		</div>
		<div class="mb-3">

			<div class="row">
				<div class="col-2">

					<input class="form-check-input" type="checkbox" id="authorised_country_and_statutory_instrument_n_ireland_enabled" name="authorised_country_and_statutory_instrument_n_ireland_enabled" <?php echo esc_attr( isset($_GET['p']) && get_post_meta( $_GET['p'], 'authorised_country_and_statutory_instrument_n_ireland_enabled', true ) ? 'checked' : '' ); ?>>
					<label class="form-check-label" for="authorised_country_and_statutory_instrument_n_ireland_enabled">
						N. Ireland
					</label>

				</div>
				<div class="col-8">

					<select class="form-select js-multiple" id="authorised_country_and_statutory_instrument_n_ireland_si" name="authorised_country_and_statutory_instrument_n_ireland_si[]" multiple="multiple">
						<option value="" disabled>Select</option>
						<?php foreach($statutory_instrument_nireland as $k => $v) {
                                    $ais = authorised_statutory_instrument( $_GET['p'], 'scotland' ) ?>
						<option value="<?php echo esc_attr( $v->ID ); ?>" <?php echo esc_attr( in_array( $v->ID, $ais ) ? 'selected' : '' ); ?>><?php echo esc_attr( $v->post_title ); ?></option>
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

	<input type="hidden" name="process" value="create-fuel">
	<input type="hidden" name="post_id" value="<?php echo esc_attr( $_GET['p'] ); ?>">
	<?php wp_nonce_field( 'create_nonce', 'create_nonce_field' ); ?>

	<button type="submit" class="btn btn-primary mt-3 save-draft" name="submit-type" value="save-draft">Save as draft</button>
	<button type="submit" class="btn btn-primary mt-3 submit" name="submit-type" value="submit-review">Save and Send for Review</button>
	<button type="submit" id="delete-post" class="btn btn-danger mt-3 delete-post" name="submit-type" value="delete-post">Delete</button>

</form>



<?php do_action('after_main_content'); ?>


<?php get_footer(); ?>
