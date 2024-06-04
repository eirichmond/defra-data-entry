<?php 
get_header();
?>

<?php do_action('before_main_content'); ?>

<h1 class="entry-title"><?php the_title(); ?></h1>

<?php if(isset($_GET['post']) && 'success' == $_GET['post']) { ?>
	<div class="alert alert-success" role="alert">
		New Fuel Type Successfully Added!
	</div>
<?php } else { ?>

	<form class="row" action="/data-entry/form-process/" method="post">

		<div class="col-4">
			<label for="fuel-type" class="form-label">Fuel Type</label>
			<input type="text" class="form-control" name="fuel-type" id="fuel-type" value="" required>
			<input type="hidden" name="entry" value="defra_fuel_types">
			<input type="hidden" name="process" value="create-fuel-type">
			<?php wp_nonce_field( 'create_nonce', 'create_nonce_field' ); ?>

			<button type="submit" class="btn btn-primary mt-3">Save</button>
		</div>



		
	</form>
	
<?php } ?>

<?php do_action('after_main_content'); ?>


<?php get_footer(); ?>