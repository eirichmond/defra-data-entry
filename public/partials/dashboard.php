<?php 
$class = new Defra_Data_Entry_Public('DEFRA_DATA_ENTRY','DEFRA_DATA_ENTRY_VERSION');
$class->defra_get_header('data-entry');
$db = new Defra_Data_DB_Requests();

?>

<?php do_action('before_main_content'); ?>

    <div class="bg-warning rounded text-white p-1">
        <h1 class="m-0"><?php the_title(); ?></h1>
    </div>


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

                                <div class="col">
                                    <div class="card">
                                        <div class="card-header bg-primary text-white">
                                            Draft
                                        </div>
                                        <div class="card-body">
                                            <a href="/data-entry/appliances/?status=10" class="">View (<?php echo esc_html( $db->count_appliance_draft() ); ?>)</a>
                                        </div>
                                    </div>
                                </div>

                                <div class="col">
                                    <div class="card">
                                        <div class="card-header bg-info text-white">
                                            Awaiting Reviewer
                                        </div>
                                        <div class="card-body">
                                            <a href="#" class="">View (<?php echo esc_html( $db->count_appliance_awaiting_review() ); ?>)</a>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col">
                                    <div class="card">
                                        <div class="card-header bg-secondary-subtle">
                                            Being Reviewed
                                        </div>
                                        <div class="card-body">
                                            <a href="#" class="">View (<?php echo esc_html( $db->count_appliance_being_reviewed() ); ?>)</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="card">
                                        <div class="card-header bg-danger text-white">
                                            Reviewer Rejected
                                        </div>
                                        <div class="card-body">
                                        <a href="#" class="">View (<?php echo esc_html( $db->count_appliance_reviewer_rejected() ); ?>)</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="card">
                                        <div class="card-header bg-success text-white">
                                            Submitted to DA
                                        </div>
                                        <div class="card-body">
                                            <a href="#" class="">View (<?php echo esc_html( $db->count_appliance_submitted_to_da() ); ?>)</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
    
                        <div class="mb-2">
                            <div class="row">

                                <div class="col">
                                    <div class="card">
                                        <div class="card-header bg-success-subtle">
                                            Assigned to DA
                                        </div>
                                        <div class="card-body">
                                            <a href="#" class="">View (<?php echo esc_html( $db->count_appliance_assigned_to_da() ); ?>)</a>
                                        </div>
                                    </div>
                                </div>

                                <div class="col">
                                    <div class="card">
                                        <div class="card-header bg-primary-subtle">
                                            Approved by DA
                                        </div>
                                        <div class="card-body">
                                        <a href="#" class="">View (<?php echo esc_html( $db->count_appliance_approved_by_da() ); ?>)</a>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col">
                                    <div class="card">
                                        <div class="card-header bg-danger text-white">
                                            Rejected by DA
                                        </div>
                                        <div class="card-body">
                                            <a href="#" class="">View (<?php echo esc_html( $db->count_appliance_rejected_by_da() ); ?>)</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="card">
                                        <div class="card-header bg-success-subtle">
                                            Awaiting Publication
                                        </div>
                                        <div class="card-body">
                                            <a href="#" class="">View (<?php echo esc_html( $db->count_appliance_awaiting_publication() ); ?>)</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="card">
                                        <div class="card-header bg-success text-white">
                                            Submitted to DA
                                        </div>
                                        <div class="card-body">
                                            <a href="#" class="">View (<?php echo esc_html( $db->count_appliance_submitted_to_da() ); ?>)</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="status-block mb-5">
                        <div class="bg-secondary rounded text-white p-1 mb-2">
                            <h5 class="m-2">Revocation Requests</h5>
                        </div>

                        <div class="container mb-2">
                            <div class="row">

                                <div class="col">
                                    <div class="card">
                                        <div class="card-header bg-success text-white">
                                            Draft
                                        </div>
                                        <div class="card-body">
                                            <a href="#" class="">View ( xx )</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="card">
                                        <div class="card-header bg-success text-white">
                                            Awaiting Review
                                        </div>
                                        <div class="card-body">
                                            <a href="#" class="">View ( xx )</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="card">
                                        <div class="card-header bg-success text-white">
                                            Being Reviewed
                                        </div>
                                        <div class="card-body">
                                            <a href="#" class="">View ( xx )</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="card">
                                        <div class="card-header bg-success text-white">
                                            Reviewer Rejected
                                        </div>
                                        <div class="card-body">
                                            <a href="#" class="">View ( xx )</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="card">
                                        <div class="card-header bg-success text-white">
                                            Submitted to DA
                                        </div>
                                        <div class="card-body">
                                            <a href="#" class="">View ( xx )</a>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
    
                        <div class="container mb-2">
                            <div class="row">

                                <div class="col">
                                    <div class="card">
                                        <div class="card-header bg-success text-white">
                                            Draft
                                        </div>
                                        <div class="card-body">
                                            <a href="#" class="">View ( xx )</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="card">
                                        <div class="card-header bg-success text-white">
                                            Awaiting Review
                                        </div>
                                        <div class="card-body">
                                            <a href="#" class="">View ( xx )</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="card">
                                        <div class="card-header bg-success text-white">
                                            Being Reviewed
                                        </div>
                                        <div class="card-body">
                                            <a href="#" class="">View ( xx )</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="card">
                                        <div class="card-header bg-success text-white">
                                            Reviewer Rejected
                                        </div>
                                        <div class="card-body">
                                            <a href="#" class="">View ( xx )</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="card">
                                        <div class="card-header bg-success text-white">
                                            Submitted to DA
                                        </div>
                                        <div class="card-body">
                                            <a href="#" class="">View ( xx )</a>
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

                        <div class="container mb-2">
                            <div class="row">

                                <div class="col">
                                    <div class="card">
                                        <div class="card-header bg-success text-white">
                                            Draft
                                        </div>
                                        <div class="card-body">
                                            <a href="#" class="">View ( xx )</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="card">
                                        <div class="card-header bg-success text-white">
                                            Awaiting Review
                                        </div>
                                        <div class="card-body">
                                            <a href="#" class="">View ( xx )</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="card">
                                        <div class="card-header bg-success text-white">
                                            Being Reviewed
                                        </div>
                                        <div class="card-body">
                                            <a href="#" class="">View ( xx )</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="card">
                                        <div class="card-header bg-success text-white">
                                            Reviewer Rejected
                                        </div>
                                        <div class="card-body">
                                            <a href="#" class="">View ( xx )</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="card">
                                        <div class="card-header bg-success text-white">
                                            Submitted to DA
                                        </div>
                                        <div class="card-body">
                                            <a href="#" class="">View ( xx )</a>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
    
                        <div class="container mb-2">
                            <div class="row">

                                <div class="col">
                                    <div class="card">
                                        <div class="card-header bg-success text-white">
                                            Draft
                                        </div>
                                        <div class="card-body">
                                            <a href="#" class="">View ( xx )</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="card">
                                        <div class="card-header bg-success text-white">
                                            Awaiting Review
                                        </div>
                                        <div class="card-body">
                                            <a href="#" class="">View ( xx )</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="card">
                                        <div class="card-header bg-success text-white">
                                            Being Reviewed
                                        </div>
                                        <div class="card-body">
                                            <a href="#" class="">View ( xx )</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="card">
                                        <div class="card-header bg-success text-white">
                                            Reviewer Rejected
                                        </div>
                                        <div class="card-body">
                                            <a href="#" class="">View ( xx )</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="card">
                                        <div class="card-header bg-success text-white">
                                            Submitted to DA
                                        </div>
                                        <div class="card-body">
                                            <a href="#" class="">View ( xx )</a>
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

                    <div class="status-block mb-5">
                        <div class="bg-secondary rounded text-white p-1 mb-2">
                            <h5 class="m-2">Requests</h5>
                        </div>
    
                        <div class="container mb-2">
                            <div class="row">

                                <div class="col">
                                    <div class="card">
                                        <div class="card-header bg-primary text-white">
                                            Draft
                                        </div>
                                        <div class="card-body">
                                            <a href="/data-entry/appliances/?status=draft" class="">View (<?php echo esc_html( $db->count_appliance_draft() ); ?>)</a>
                                        </div>
                                    </div>
                                </div>

                                <div class="col">
                                    <div class="card">
                                        <div class="card-header bg-info text-white">
                                            Awaiting Reviewer
                                        </div>
                                        <div class="card-body">
                                            <a href="#" class="">View (<?php echo esc_html( $db->count_appliance_awaiting_review() ); ?>)</a>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col">
                                    <div class="card">
                                        <div class="card-header bg-secondary-subtle">
                                            Being Reviewed
                                        </div>
                                        <div class="card-body">
                                            <a href="#" class="">View (<?php echo esc_html( $db->count_appliance_being_reviewed() ); ?>)</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="card">
                                        <div class="card-header bg-danger text-white">
                                            Reviewer Rejected
                                        </div>
                                        <div class="card-body">
                                        <a href="#" class="">View (<?php echo esc_html( $db->count_appliance_reviewer_rejected() ); ?>)</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="card">
                                        <div class="card-header bg-success text-white">
                                            Submitted to DA
                                        </div>
                                        <div class="card-body">
                                            <a href="#" class="">View (<?php echo esc_html( $db->count_appliance_submitted_to_da() ); ?>)</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
    
                        <div class="container mb-2">
                            <div class="row">

                                <div class="col">
                                    <div class="card">
                                        <div class="card-header bg-success-subtle">
                                            Assigned to DA
                                        </div>
                                        <div class="card-body">
                                            <a href="#" class="">View (<?php echo esc_html( $db->count_appliance_assigned_to_da() ); ?>)</a>
                                        </div>
                                    </div>
                                </div>

                                <div class="col">
                                    <div class="card">
                                        <div class="card-header bg-primary-subtle">
                                            Approved by DA
                                        </div>
                                        <div class="card-body">
                                        <a href="#" class="">View (<?php echo esc_html( $db->count_appliance_approved_by_da() ); ?>)</a>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col">
                                    <div class="card">
                                        <div class="card-header bg-danger text-white">
                                            Rejected by DA
                                        </div>
                                        <div class="card-body">
                                            <a href="#" class="">View (<?php echo esc_html( $db->count_appliance_rejected_by_da() ); ?>)</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="card">
                                        <div class="card-header bg-success-subtle">
                                            Awaiting Publication
                                        </div>
                                        <div class="card-body">
                                            <a href="#" class="">View (<?php echo esc_html( $db->count_appliance_awaiting_publication() ); ?>)</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="card">
                                        <div class="card-header bg-success text-white">
                                            Submitted to DA
                                        </div>
                                        <div class="card-body">
                                            <a href="#" class="">View (<?php echo esc_html( $db->count_appliance_submitted_to_da() ); ?>)</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="status-block mb-5">
                        <div class="bg-secondary rounded text-white p-1 mb-2">
                            <h4 class="m-0">Revocation Requests</h1>
                        </div>
    
                        <div class="container mb-2">
                            <div class="row">

                                <div class="col">
                                    <div class="card">
                                        <div class="card-header bg-success text-white">
                                            Draft
                                        </div>
                                        <div class="card-body">
                                            <a href="#" class="">View ( xx )</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="card">
                                        <div class="card-header bg-success text-white">
                                            Awaiting Review
                                        </div>
                                        <div class="card-body">
                                            <a href="#" class="">View ( xx )</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="card">
                                        <div class="card-header bg-success text-white">
                                            Being Reviewed
                                        </div>
                                        <div class="card-body">
                                            <a href="#" class="">View ( xx )</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="card">
                                        <div class="card-header bg-success text-white">
                                            Reviewer Rejected
                                        </div>
                                        <div class="card-body">
                                            <a href="#" class="">View ( xx )</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="card">
                                        <div class="card-header bg-success text-white">
                                            Submitted to DA
                                        </div>
                                        <div class="card-body">
                                            <a href="#" class="">View ( xx )</a>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
    
                        <div class="container mb-2">
                            <div class="row">

                                <div class="col">
                                    <div class="card">
                                        <div class="card-header bg-success text-white">
                                            Draft
                                        </div>
                                        <div class="card-body">
                                            <a href="#" class="">View ( xx )</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="card">
                                        <div class="card-header bg-success text-white">
                                            Awaiting Review
                                        </div>
                                        <div class="card-body">
                                            <a href="#" class="">View ( xx )</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="card">
                                        <div class="card-header bg-success text-white">
                                            Being Reviewed
                                        </div>
                                        <div class="card-body">
                                            <a href="#" class="">View ( xx )</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="card">
                                        <div class="card-header bg-success text-white">
                                            Reviewer Rejected
                                        </div>
                                        <div class="card-body">
                                            <a href="#" class="">View ( xx )</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="card">
                                        <div class="card-header bg-success text-white">
                                            Submitted to DA
                                        </div>
                                        <div class="card-body">
                                            <a href="#" class="">View ( xx )</a>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                    </div>

                    <div class="status-block">
                        <div class="bg-secondary rounded text-white p-1 mb-2">
                            <h4 class="m-0">Cancellation Requests</h1>
                        </div>
    
                        <div class="container mb-2">
                            <div class="row">

                                <div class="col">
                                    <div class="card">
                                        <div class="card-header bg-success text-white">
                                            Draft
                                        </div>
                                        <div class="card-body">
                                            <a href="#" class="">View ( xx )</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="card">
                                        <div class="card-header bg-success text-white">
                                            Awaiting Review
                                        </div>
                                        <div class="card-body">
                                            <a href="#" class="">View ( xx )</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="card">
                                        <div class="card-header bg-success text-white">
                                            Being Reviewed
                                        </div>
                                        <div class="card-body">
                                            <a href="#" class="">View ( xx )</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="card">
                                        <div class="card-header bg-success text-white">
                                            Reviewer Rejected
                                        </div>
                                        <div class="card-body">
                                            <a href="#" class="">View ( xx )</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="card">
                                        <div class="card-header bg-success text-white">
                                            Submitted to DA
                                        </div>
                                        <div class="card-body">
                                            <a href="#" class="">View ( xx )</a>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
    
                        <div class="container mb-2">
                            <div class="row">

                                <div class="col">
                                    <div class="card">
                                        <div class="card-header bg-success text-white">
                                            Draft
                                        </div>
                                        <div class="card-body">
                                            <a href="#" class="">View ( xx )</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="card">
                                        <div class="card-header bg-success text-white">
                                            Awaiting Review
                                        </div>
                                        <div class="card-body">
                                            <a href="#" class="">View ( xx )</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="card">
                                        <div class="card-header bg-success text-white">
                                            Being Reviewed
                                        </div>
                                        <div class="card-body">
                                            <a href="#" class="">View ( xx )</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="card">
                                        <div class="card-header bg-success text-white">
                                            Reviewer Rejected
                                        </div>
                                        <div class="card-body">
                                            <a href="#" class="">View ( xx )</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="card">
                                        <div class="card-header bg-success text-white">
                                            Submitted to DA
                                        </div>
                                        <div class="card-body">
                                            <a href="#" class="">View ( xx )</a>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                    </div>

               </div>
            </div>
        </div>
    </div>

<?php do_action('after_main_content'); ?>          

<?php //include(plugin_dir_path( __FILE__ ) . 'template-part/dashboard-removed.php'); ?>

<?php get_footer(); ?>