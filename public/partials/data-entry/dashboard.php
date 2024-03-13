<?php 
$class = new Defra_Data_Entry_Public('DEFRA_DATA_ENTRY','DEFRA_DATA_ENTRY_VERSION');
$db = new Defra_Data_DB_Requests();
$user = wp_get_current_user();
$country = get_user_meta( $user->ID, 'approver_country_id', true );
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

                    <div class="status-block mb-5">
                        <div class="bg-secondary rounded text-white p-1 mb-2">
                            <h5 class="m-2">Requests</h5>
                        </div>
    
                        <div class="mb-2">
                            <div class="row">
                                <?php if ( array_intersect( $data_entry_review_users, $user->roles ) ) { ?>
                                    <div class="col">
                                        <div class="card">
                                            <div class="card-header bg-primary text-white">
                                                Draft
                                            </div>
                                            <div class="card-body">
                                                <a href="/data-entry/appliances/?status=10" class="app-draft">View (<?php echo esc_html( $db->count_appliance_draft() ); ?>)</a>
                                            </div>
                                        </div>
                                    </div>
    
                                    <div class="col">
                                        <div class="card">
                                            <div class="card-header bg-info text-white">
                                             Awaiting Review
                                            </div>
                                            <div class="card-body">
                                                <a href="/data-entry/appliances/?status=20" class="app-awaiting-review">View (<?php echo esc_html( $db->count_appliance_awaiting_review() ); ?>)</a>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="col">
                                        <div class="card">
                                            <div class="card-header bg-secondary-subtle">
                                                Being Reviewed
                                            </div>
                                            <div class="card-body">
                                                <a href="/data-entry/appliances/?status=30" class="">View (<?php echo esc_html( $db->count_appliance_being_reviewed() ); ?>)</a>
                                            </div>
                                        </div>
                                    </div>
    
                                    <div class="col">
                                        <div class="card">
                                            <div class="card-header bg-danger text-white">
                                                Reviewer Rejected
                                            </div>
                                            <div class="card-body">
                                            <a href="/data-entry/appliances/?status=40" class="">View (<?php echo esc_html( $db->count_appliance_reviewer_rejected() ); ?>)</a>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>

                                <?php if ( array_intersect( $all_users, $user->roles ) ) { ?>
                                    <div class="col">
                                        <div class="card">
                                            <div class="card-header bg-success text-white">
                                                Submitted to DA
                                            </div>
                                            <div class="card-body">
                                                <a href="/data-entry/appliances/?status=50" class="app-submitted-to-da">View (<?php echo esc_html( $db->count_appliance_submitted_to_da($country) ); ?>)</a>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>

                            </div>
                        </div>
    
                        <div class="mb-2">
                            <div class="row">
                                <?php if ( array_intersect( $all_users, $user->roles ) ) { ?>
                                    <div class="col">
                                        <div class="card">
                                            <div class="card-header bg-success-subtle">
                                                Assigned to DA
                                            </div>
                                            <div class="card-body">
                                                <a href="/data-entry/appliances/?status=60" class="app-assigned-to-da">View (<?php echo esc_html( $db->count_appliance_assigned_to_da($country) ); ?>)</a>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col">
                                        <div class="card">
                                            <div class="card-header bg-primary-subtle">
                                                Approved by DA
                                            </div>
                                            <div class="card-body">
                                            <a href="/data-entry/appliances/?status=70" class="app-approved-by-da">View (<?php echo esc_html( $db->count_appliance_approved_by_da($country) ); ?>)</a>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="col">
                                        <div class="card">
                                            <div class="card-header bg-danger text-white">
                                                Rejected by DA
                                            </div>
                                            <div class="card-body">
                                                <a href="/data-entry/appliances/?status=80" class="app-rejected-by-da">View (<?php echo esc_html( $db->count_appliance_rejected_by_da($country) ); ?>)</a>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col">
                                        <div class="card">
                                            <div class="card-header bg-success-subtle">
                                                Awaiting Publication
                                            </div>
                                            <div class="card-body">
                                                <a href="/data-entry/appliances/?status=500" class="app-awaiting-publication">View (<?php echo esc_html( $db->count_appliance_awaiting_publication($country) ); ?>)</a>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col">
                                        <div class="card">
                                            <div class="card-header bg-success text-white">
                                                Published
                                            </div>
                                            <div class="card-body">
                                                <a href="/data-entry/appliances/?status=600" class="app-published">View (<?php echo esc_html( $db->count_appliance_published($country) ); ?>)</a>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>

                    </div>

                    <div class="status-block mb-5">
                        <div class="bg-secondary rounded text-white p-1 mb-2">
                            <h5 class="m-2">Revocation Requests</h5>
                        </div>

                        <div class="mb-2">
                            <div class="row">

                                <div class="col">
                                    <div class="card">
                                        <div class="card-header bg-secondary-subtle">
                                            Draft
                                        </div>
                                        <div class="card-body">
                                            <a href="#" class=""></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="card">
                                        <div class="card-header bg-secondary-subtle">
                                            Awaiting Review
                                        </div>
                                        <div class="card-body">
                                            <a href="#" class=""></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="card">
                                        <div class="card-header bg-secondary-subtle">
                                            Being Reviewed
                                        </div>
                                        <div class="card-body">
                                            <a href="#" class=""></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="card">
                                        <div class="card-header bg-secondary-subtle">
                                            Reviewer Rejected
                                        </div>
                                        <div class="card-body">
                                            <a href="#" class=""></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="card">
                                        <div class="card-header bg-secondary-subtle">
                                            Submitted to DA
                                        </div>
                                        <div class="card-body">
                                            <a href="#" class=""></a>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
    
                        <div class="mb-2">
                            <div class="row">

                                <div class="col">
                                    <div class="card">
                                        <div class="card-header bg-secondary-subtle">
                                            Assigned to DA
                                        </div>
                                        <div class="card-body">
                                            <a href="#" class=""></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="card">
                                        <div class="card-header bg-secondary-subtle">
                                            Approved by DA
                                        </div>
                                        <div class="card-body">
                                            <a href="#" class=""></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="card">
                                    <div class="card-header bg-secondary-subtle">
                                            Rejected by DA
                                        </div>
                                        <div class="card-body">
                                            <a href="#" class=""></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="card">
                                        <div class="card-header bg-secondary-subtle">
                                            Awaiting Publication
                                        </div>
                                        <div class="card-body">
                                            <a href="#" class=""></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="card">
                                        <div class="card-header bg-success text-white">
                                            Published
                                        </div>
                                        <div class="card-body">
                                            <a href="/data-entry/appliances/?status=600&revoked=1" class="app-submitted-to-da">View (<?php echo esc_html( $db->count_appliance_is_revoked_is_published($country) ); ?>)</a>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                    </div>

                    <div class="status-block">
                        <div class="bg-secondary rounded text-white p-1 mb-2">
                            <h5 class="m-2">Cancellation Requests</h5>
                        </div>

                        <div class="mb-2">
                            <div class="row">

                                <div class="col">
                                    <div class="card">
                                        <div class="card-header bg-secondary-subtle">
                                            Draft
                                        </div>
                                        <div class="card-body">
                                            <!-- <a href="/data-entry/appliances/?status=10&cancel=1" class="app-draft">View (<?php //echo esc_html( $db->count_appliance_cancel_draft() ); ?>)</a> -->
                                            <a href="#" class="app-draft"></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="card">
                                        <div class="card-header bg-secondary-subtle">
                                            Awaiting Review
                                        </div>
                                        <div class="card-body">
                                            <!-- <a href="/data-entry/appliances/?status=20&cancel=1" class="app-draft">View (<?php //echo esc_html( $db->count_appliance_cancel_awaiting_review() ); ?>)</a> -->
                                            <a href="#" class="app-draft"></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="card">
                                        <div class="card-header bg-secondary-subtle">
                                            Being Reviewed
                                        </div>
                                        <div class="card-body">
                                            <!-- <a href="/data-entry/appliances/?status=30&cancel=1" class="app-draft">View (<?php //echo esc_html( $db->count_appliance_cancel_being_reviewed() ); ?>)</a> -->
                                            <a href="#" class="app-draft"></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="card">
                                        <div class="card-header bg-danger text-white">
                                            Reviewer Rejected
                                        </div>
                                        <div class="card-body">
                                            <a href="/data-entry/appliances/?status=40&cancel=1" class="app-draft">View (<?php echo esc_html( $db->count_appliance_cancel_reviewer_rejected() ); ?>)</a>
                                            <!-- <a href="#" class="app-draft"></a> -->
                                        </div>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="card">
                                        <div class="card-header bg-secondary-subtle">
                                            Submitted to DA
                                        </div>
                                        <div class="card-body">
                                            <a href="/data-entry/appliances/?status=50&cancel=1" class="app-draft">View (<?php echo esc_html( $db->count_appliance_cancel_submitted_to_da() ); ?>)</a>
                                            <!-- <a href="#" class="app-draft"></a> -->
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
    
                        <div class="mb-2">
                            <div class="row">

                                <div class="col">
                                    <div class="card">
                                        <div class="card-header bg-success text-white">
                                            Assigned to DA
                                        </div>
                                        <div class="card-body">
                                            <!-- <a href="/data-entry/appliances/?status=60&cancel=1" class="app-draft">View (<?php //echo esc_html( $db->count_appliance_cancel_assigned_to_da() ); ?>)</a> -->
                                            <a href="#" class="app-draft"></a>

                                        </div>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="card">
                                        <div class="card-header bg-success text-white">
                                            Approved by DA
                                        </div>
                                        <div class="card-body">
                                            <!-- <a href="/data-entry/appliances/?status=70&cancel=1" class="app-draft">View (<?php //echo esc_html( $db->count_appliance_cancel_approved_by_da() ); ?>)</a> -->
                                            <a href="#" class="app-draft"></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="card">
                                        <div class="card-header bg-success text-white">
                                            Rejected by DA
                                        </div>
                                        <div class="card-body">
                                            <!-- <a href="/data-entry/appliances/?status=80&cancel=1" class="app-draft">View (<?php //echo esc_html( $db->count_appliance_cancel_rejected_by_da() ); ?>)</a> -->
                                            <a href="#" class="app-draft"></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="card">
                                        <div class="card-header bg-success text-white">
                                            Awaiting Publication
                                        </div>
                                        <div class="card-body">
                                            <!-- <a href="/data-entry/appliances/?status=500&cancel=1" class="app-draft">View (<?php //echo esc_html( $db->count_appliance_cancel_awaiting_publication() ); ?>)</a> -->
                                            <a href="#" class="app-draft"></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="card">
                                        <div class="card-header bg-success text-white">
                                            Published
                                        </div>
                                        <div class="card-body">
                                            <!-- <a href="/data-entry/appliances/?status=600&cancel=1" class="app-draft">View (<?php //echo esc_html( $db->count_appliance_cancel_published() ); ?>)</a> -->
                                            <a href="#" class="app-draft"></a>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                    </div>

               </div>
            </div>
        </div>

        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseTwo" aria-expanded="false" aria-controls="panelsStayOpen-collapseTwo">
                    Fuel Status
                </button>
            </h2>
            <div id="panelsStayOpen-collapseTwo" class="accordion-collapse collapse">
                <div class="accordion-body">

                    <?php require_once(plugin_dir_path( __FILE__ ) . 'components/fuel/fuel-statuses.php'); ?>

               </div>
            </div>
        </div>
    </div>

<?php do_action('after_main_content'); ?>          

<?php //include(plugin_dir_path( __FILE__ ) . 'template-part/dashboard-removed.php'); ?>

<?php get_footer(); ?>