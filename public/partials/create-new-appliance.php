<?php 
$class = new Defra_Data_Entry_Public('DEFRA_DATA_ENTRY','DEFRA_DATA_ENTRY_VERSION');
$class->defra_get_header('data-entry');
$db = new Defra_Data_DB_Requests();
$list_manufacturers = $db->list_manufacturers();
?>


<?php do_action('before_main_content'); ?>

<h1 class="entry-title"><?php the_title(); ?></h1>

<form class="w-full" action="/data-entry/form-process/" method="post">

	<div class="md:flex md:items-center mb-6">

		<div class="md:w-1/4">
			<label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4" for="manufacturer_type">Manufacturer</label>
		</div>

		<div class="md:w-3/4">
			<div class="inline-block relative">
				<select class="js-example-basic-single w-full" name="state">
					<?php foreach($list_manufacturers as $k => $v) { ?>
						<option value="<?php echo esc_attr( $v['manufacturer_id'] ); ?>"><?php echo esc_attr( $v['manufacturer_name'] ); ?></option>
					<?php } ?>
				</select>
			</div>
		</div>

	</div>

	<div class="md:flex md:items-center mb-6">

		<div class="md:w-1/4">
			<label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4" for="manufacturer_type">Manufacturer Type</label>
		</div>

		<div class="md:w-3/4">
			<div class="inline-block relative">

				<select class="block appearance-none w-full bg-white border border-gray-400 hover:border-gray-500 px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline" id="manufacturer_type" name="manufacturer_type">
					<?php foreach ($manufacturer_types as $manufacturer_type) { ?>
						<option value="<?php echo esc_attr( $manufacturer_type->id ); ?>"><?php echo esc_attr( $manufacturer_type->type_name ); ?></option>
					<?php } ?>
				</select>
				<div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
					<svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
				</div>
			</div>
		</div>

	</div>


	<div class="md:flex md:items-center mb-6">
		<div class="md:w-1/4">
			<label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4" for="manufacturer-name">Manufacturer Name</label>
		</div>
		<div class="md:w-3/4">
			<input class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-purple-500" type="text" name="manufacturers_name" id="manufacturer-name" value="" required>
		</div>
	</div>


	<div class="md:flex md:items-center mb-6">
		<div class="md:w-1/4">
			<label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4" for="address_line_1">Address 1</label>
		</div>
		<div class="md:w-3/4">
			<input class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-purple-500" type="text" name="address_line_1" id="address_line_1" value="" required>
		</div>
	</div>


	<div class="md:flex md:items-center mb-6">
		<div class="md:w-1/4">
			<label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4" for="address_line_2">Address 2</label>
		</div>
		<div class="md:w-3/4">
			<input class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-purple-500" type="text" name="address_line_2" id="address_line_2" value="">
		</div>
	</div>


	<div class="md:flex md:items-center mb-6">
		<div class="md:w-1/4">
			<label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4" for="address_line_3">Address 3</label>
		</div>
		<div class="md:w-3/4">
			<input class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-purple-500" type="text" name="address_line_3" id="address_line_3" value="">
		</div>
	</div>


	<div class="md:flex md:items-center mb-6">
		<div class="md:w-1/4">
			<label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4" for="address_line_4">Address 4</label>
		</div>
		<div class="md:w-3/4">
			<input class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-purple-500" type="text" name="address_line_4" id="address_line_4" value="">
		</div>
	</div>


	<div class="md:flex md:items-center mb-6">
		<div class="md:w-1/4">
			<label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4" for="town">Town / City</label>
		</div>
		<div class="md:w-3/4">
			<input class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-purple-500" type="text" name="town" id="town" value="" required>
		</div>
	</div>


	<div class="md:flex md:items-center mb-6">
		<div class="md:w-1/4">
			<label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4" for="county">County</label>
		</div>
		<div class="md:w-3/4">
			<input class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-purple-500" type="text" name="county" id="county" value="">
		</div>
	</div>


	<div class="md:flex md:items-center mb-6">
		<div class="md:w-1/4">
			<label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4" for="post_code">Post Code</label>
		</div>
		<div class="md:w-3/4">
			<input class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-purple-500" type="text" name="post_code" id="post_code" value="">
		</div>
	</div>

	<div class="md:flex md:items-center mb-6">

		<div class="md:w-1/4">
			<label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4" for="country_id">Country</label>
		</div>

		<div class="md:w-3/4">
			<div class="inline-block relative">
				<select class="block appearance-none w-full bg-white border border-gray-400 hover:border-gray-500 px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline" id="country_id" name="country_id">
					<?php foreach ($countries as $country) { ?>
						<option value="<?php echo esc_attr( $country->id ); ?>"><?php echo esc_attr( $country->country ); ?></option>
					<?php } ?>
				</select>
				<div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
					<svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
				</div>
			</div>
		</div>

	</div>


	<input type="hidden" name="process" value="create-manufacturer">
	<?php wp_nonce_field( 'create_manufacturer', 'create_manufacturer_field' ); ?>

	<div class="md:flex md:items-center">
		<div class="md:w-1/4"></div>
		<div class="md:w-3/4">
			<button class="shadow bg-green-700 hover:bg-green-600 focus:shadow-outline focus:outline-none text-white font-bold py-2 px-4 rounded" type="submit">Save</button>
		</div>
	</div>
	
</form>


<?php do_action('after_main_content'); ?>


<?php get_footer(); ?>