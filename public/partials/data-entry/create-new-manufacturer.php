<?php 
$class = new Defra_Data_Entry_Public('DEFRA_DATA_ENTRY','DEFRA_DATA_ENTRY_VERSION');
$db = new Defra_Data_DB_Requests();
$manufacturer_types = $db->get_manufacturer_types();
$countries = $db->get_countries();
get_header();
?>

<?php do_action('before_main_content'); ?>

<h1 class="entry-title"><?php the_title(); ?></h1>

<?php if(isset($_GET['post']) && 'success' == $_GET['post']) { ?>
	<div class="alert alert-success" role="alert">
		New Manufacturer Successfully Added!
	</div>
<?php } else { ?>

<form class="mt-2" action="/data-entry/form-process/" method="post">

	<div class="row mb-3">
		<label for="manufacturer_type" class="col-sm-2 col-form-label">Manufacturer Type</label>
		<div class="col-sm-10">
			<select class="form-select" aria-label="Manufacturer Type" id="manufacturer_type" name="manufacturer_type">
				<option selected disabled>Please select</option>
				<?php foreach ($manufacturer_types as $manufacturer_type) { ?>
					<option value="<?php echo esc_attr( $manufacturer_type->term_id ); ?>"><?php echo esc_attr( $manufacturer_type->name ); ?></option>
				<?php } ?>
			</select>
		</div>
	</div>

	<div class="row mb-3">
		<label for="manufacturer-name" class="col-sm-2 col-form-label">Manufacturers Name</label>
		<div class="col-sm-10">
			<input type="text" class="form-control" placeholder="Manufacturers Name" aria-label="Manufacturers Name" name="manufacturers_name" id="manufacturer-name" value="" required>
		</div>
	</div>

	<div class="row mb-3">
		<label for="address_1" class="col-sm-2 col-form-label">Address 1</label>
		<div class="col-sm-10">
			<input type="text" class="form-control" placeholder="Address 1" aria-label="Address 1" name="address_1" id="address_1" value="" required>
		</div>
	</div>

	<div class="row mb-3">
		<label for="address_2" class="col-sm-2 col-form-label">Address 2</label>
		<div class="col-sm-10">
			<input type="text" class="form-control" placeholder="Address 2" aria-label="Address 2" name="address_2" id="address_2" value="">
		</div>
	</div>

	<div class="row mb-3">
		<label for="address_3" class="col-sm-2 col-form-label">Address 3</label>
		<div class="col-sm-10">
			<input type="text" class="form-control" placeholder="Address 3" aria-label="Address 3" name="address_3" id="address_3" value="">
		</div>
	</div>

	<div class="row mb-3">
		<label for="address_4" class="col-sm-2 col-form-label">Address 4</label>
		<div class="col-sm-10">
			<input type="text" class="form-control" placeholder="Address 4" aria-label="Address 4" name="address_4" id="address_4" value="">
		</div>
	</div>

	<div class="row mb-3">
		<label for="town__city" class="col-sm-2 col-form-label">Town / City</label>
		<div class="col-sm-10">
			<input type="text" class="form-control" placeholder="Town / City" aria-label="Town / City" name="town__city" id="town__city" value="" required>
		</div>
	</div>

	<div class="row mb-3">
		<label for="county" class="col-sm-2 col-form-label">County</label>
		<div class="col-sm-10">
			<input type="text" class="form-control" placeholder="County" aria-label="County" name="county" id="county" value="">
		</div>
	</div>

	<div class="row mb-3">
		<label for="postcode" class="col-sm-2 col-form-label">Post Code</label>
		<div class="col-sm-10">
			<input type="text" class="form-control" placeholder="Post Code" aria-label="Post Code" name="postcode" id="postcode" value="">
		</div>
	</div>

	<div class="row mb-6">
		<label for="country" class="col-sm-2 col-form-label">Country</label>
		<div class="col-sm-10">
			<select class="form-select" aria-label="Country" id="country" name="country">
				<option selected disabled>Please select</option>
				<?php foreach ($countries as $country) { ?>
					<option value="<?php echo esc_attr( $country->id ); ?>"><?php echo esc_attr( $country->country ); ?></option>
				<?php } ?>
			</select>
		</div>
		
	</div>

	<input type="hidden" name="process" value="create-manufacturer">
	<?php wp_nonce_field( 'create_manufacturer', 'create_manufacturer_field' ); ?>

	<button type="submit" class="btn btn-primary mt-3 submit">Save</button>
	
</form>

<?php } ?>

<?php do_action('after_main_content'); ?>

<?php get_footer(); ?>