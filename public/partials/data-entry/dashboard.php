<?php 
$class = new Defra_Data_Entry_Public('DEFRA_DATA_ENTRY','DEFRA_DATA_ENTRY_VERSION');
$db = new Defra_Data_DB_Requests();
$user = wp_get_current_user();
// only set the country if user is a data approver
if ( in_array('data_approver', $user->roles )) {
	$country = get_user_meta( $user->ID, 'approver_country_id', true );
    $country_slug = $class->country_meta_slugs($country);
} else {
	$country = null;
}

$data_entry_review_users = array( 'data_entry','data_reviewer','administrator' );
$all_users = array( 'data_entry','data_reviewer','data_approver','administrator' );
get_header();

?>

<?php do_action('before_main_content'); ?>

<h1 class="entry-title"><?php the_title(); ?></h1>

<?php if(!empty($_GET) && isset($_GET['refer'])) { ?>

<div class="alert alert-success" role="alert">
	Status updated!
</div>

<?php } ?>

<div class="accordion" id="accordionPanelsStayOpenExample">
	<div class="accordion-item mt-2">
		<h2 class="accordion-header">
			<button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseOne" aria-expanded="true" aria-controls="panelsStayOpen-collapseOne">
				Appliance Status
			</button>
		</h2>
		<div id="panelsStayOpen-collapseOne" class="accordion-collapse collapse show">
			<div class="accordion-body">

				<?php require_once(plugin_dir_path( __FILE__ ) . 'components/appliance/appliance-statuses.php'); ?>

			</div>
		</div>
	</div>

	<div class="accordion-item">
		<h2 class="accordion-header">
			<button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseTwo" aria-expanded="false" aria-controls="panelsStayOpen-collapseTwo">
				Fuel Status
			</button>
		</h2>
		<div id="panelsStayOpen-collapseTwo" class="accordion-collapse collapse show">
			<div class="accordion-body">

				<?php require_once(plugin_dir_path( __FILE__ ) . 'components/fuel/fuel-statuses.php'); ?>

			</div>
		</div>
	</div>
</div>

<?php do_action('after_main_content'); ?>

<?php //include(plugin_dir_path( __FILE__ ) . 'template-part/dashboard-removed.php'); ?>

<?php get_footer(); ?>
