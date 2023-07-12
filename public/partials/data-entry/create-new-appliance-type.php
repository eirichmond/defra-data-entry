<?php 
$class = new Defra_Data_Entry_Public('DEFRA_DATA_ENTRY','DEFRA_DATA_ENTRY_VERSION');
get_header();
?>

<?php do_action('before_main_content'); ?>

<h1 class="entry-title"><?php the_title(); ?></h1>

<?php if(isset($_GET['post']) && 'success' == $_GET['post']) { ?>
	<div class="bg-green-700 text-white font-bold py-2 px-4 rounded">New Fuel Type Successfully Added!</div>
<?php } else { ?>

	<form class="w-full" action="/data-entry/form-process/" method="post">


		<div class="col-4">
			<label for="appliance-type" class="form-label">Appliance Type</label>
			<input type="text" class="form-control" name="appliance-type" id="appliance-type" value="" required>
			<input type="hidden" name="entry" value="defra_appliance_types">
			<input type="hidden" name="process" value="create-appliance-type">
			<?php wp_nonce_field( 'create_nonce', 'create_nonce_field' ); ?>

			<button type="submit" class="btn btn-primary mt-3">Save</button>
		</div>
		
	</form>
	
<?php } ?>


<?php do_action('after_main_content'); ?>


<?php get_footer(); ?>