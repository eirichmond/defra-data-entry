<?php 
$class = new Defra_Data_Entry_Public('DEFRA_DATA_ENTRY','DEFRA_DATA_ENTRY_VERSION');
get_header();
?>

<?php do_action('before_main_content'); ?>

<h1 class="entry-title"><?php the_title(); ?></h1>

<?php if(isset($_GET['post']) && 'success' == $_GET['post']) { ?>
	<div class="alert alert-success" role="alert">
	New Permitted Fuels Successfully Added!
	</div>
<?php } else { ?>

	<form class="row" action="/data-entry/form-process/" method="post">

		<div class="col-12">
			<label for="permitted-fuel" class="form-label">Permitted Fuel</label>
			<input type="text" class="form-control" name="permitted-fuel" id="permitted-fuel" value="" required>
			<input type="hidden" name="entry" value="defra_permitted_fuels">
			<input type="hidden" name="process" value="create-permitted-fuel">
			<?php wp_nonce_field( 'create_nonce', 'create_nonce_field' ); ?>

			<button type="submit" class="btn btn-primary mt-3">Save</button>
		</div>
		
	</form>
	
<?php } ?>


<?php do_action('after_main_content'); ?>


<?php get_footer(); ?>