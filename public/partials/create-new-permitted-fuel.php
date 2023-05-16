<?php 
$class = new Defra_Data_Entry_Public('DEFRA_DATA_ENTRY','DEFRA_DATA_ENTRY_VERSION');
$class->defra_get_header('data-entry');
?>

<?php do_action('before_main_content'); ?>

<h1 class="entry-title"><?php the_title(); ?></h1>

<?php if(isset($_GET['post']) && 'success' == $_GET['post']) { ?>
	<div class="bg-green-700 text-white font-bold py-2 px-4 rounded">New Permitted Fuels Successfully Added!</div>
<?php } else { ?>

	<form class="w-full" action="/data-entry/form-process/" method="post">

		<div class="md:flex md:items-center mb-6">
			<div class="md:w-1/4">
				<label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4" for="permitted-fuel">Permitted Fuel</label>
			</div>
			<div class="md:w-3/4">
				<input class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-purple-500" type="text" name="permitted-fuel" id="permitted-fuel" value="" required>
			</div>
		</div>




		<input type="hidden" name="entry" value="defra_permitted_fuels">
		<input type="hidden" name="process" value="create-permitted-fuel">
		<?php wp_nonce_field( 'create_nonce', 'create_nonce_field' ); ?>

		<div class="md:flex md:items-center">
			<div class="md:w-1/4"></div>
			<div class="md:w-3/4">
				<button class="shadow bg-green-700 hover:bg-green-600 focus:shadow-outline focus:outline-none text-white font-bold py-2 px-4 rounded" type="submit">Save</button>
			</div>
		</div>
		
	</form>
	
<?php } ?>


<?php do_action('after_main_content'); ?>


<?php get_footer(); ?>