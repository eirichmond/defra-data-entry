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
                            <a href="/data-entry/appliances/?status=10" class="app-draft">View (<?php echo esc_html( $class->count_appliance( 10 ) ); ?>)</a>
                        </div>
                    </div>
                </div>

                <div class="col">
                    <div class="card">
                        <div class="card-header bg-info text-white">
                            Awaiting Review
                        </div>
                        <div class="card-body">
                            <a href="/data-entry/appliances/?status=20" class="app-awaiting-review">View (<?php echo esc_html( $class->count_appliance( 20 ) ); ?>)</a>
                        </div>
                    </div>
                </div>
                
                <div class="col">
                    <div class="card">
                        <div class="card-header bg-secondary-subtle">
                            Being Reviewed
                        </div>
                        <div class="card-body">
                            <a href="/data-entry/appliances/?status=30" class="">View (<?php echo esc_html( $class->count_appliance( 30 ) ); ?>)</a>
                        </div>
                    </div>
                </div>

                <div class="col">
                    <div class="card">
                        <div class="card-header bg-danger text-white">
                            Reviewer Rejected
                        </div>
                        <div class="card-body">
                        <a href="/data-entry/appliances/?status=40" class="">View (<?php echo esc_html( $class->count_appliance( 40 ) ); ?>)</a>
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
                            <?php if ($db->count_appliance_submitted_to_da($country) > 0 ) { ?>
                                <a href="/data-entry/appliances/?status=50" class="app-submitted-to-da">View (<?php echo esc_html( $db->count_appliance_submitted_to_da($country) ); ?>)</a>
                            <?php } ?>
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
                            <?php if ($db->count_appliance_assigned_to_da($country) > 0 ) { ?>
                                <a href="/data-entry/appliances/?status=60" class="app-assigned-to-da">View (<?php echo esc_html( $db->count_appliance_assigned_to_da($country) ); ?>)</a>
                            <?php } ?>
                        </div>
                    </div>
                </div>

                <div class="col">
                    <div class="card">
                        <div class="card-header bg-primary-subtle">
                            Approved by DA
                        </div>
                        <div class="card-body">
                            <?php if ($db->count_appliance_approved_by_da($country) > 0 ) { ?>
                                <a href="/data-entry/appliances/?status=70" class="app-approved-by-da">View (<?php echo esc_html( $db->count_appliance_approved_by_da($country) ); ?>)</a>
                            <?php } ?>
                        </div>
                    </div>
                </div>
                
                <div class="col">
                    <div class="card">
                        <div class="card-header bg-danger text-white">
                            Rejected by DA
                        </div>
                        <div class="card-body">
                            <?php if ($db->count_appliance_rejected_by_da($country) > 0 ) { ?>
                                <a href="/data-entry/appliances/?status=80" class="app-rejected-by-da">View (<?php echo esc_html( $db->count_appliance_rejected_by_da($country) ); ?>)</a>
                            <?php } ?>
                        </div>
                    </div>
                </div>

                <div class="col">
                    <div class="card">
                        <div class="card-header bg-success-subtle">
                            Awaiting Publication
                        </div>
                        <div class="card-body">
                            <?php if ($db->count_appliance_awaiting_publication($country) > 0 ) { ?>
                                <a href="/data-entry/appliances/?status=500" class="app-awaiting-publication">View (<?php echo esc_html( $db->count_appliance_awaiting_publication($country) ); ?>)</a>
                            <?php } ?>
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
        <?php if ( array_intersect( $data_entry_review_users, $user->roles ) ) { ?>
            <div class="col">
                <div class="card">
                    <div class="card-header bg-secondary-subtle">
                        Draft
                    </div>
                    <div class="card-body">
                        <a href="#" class="">View (0)</a>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card">
                    <div class="card-header bg-secondary-subtle">
                        Awaiting Review
                    </div>
                    <div class="card-body">
                        <a href="/data-entry/appliances/?revoked=true&key=%_revoke_status_id&value=20" class="">View (<?php echo esc_html( count( $db->get_revoked_requested( '%_revoke_status_id', '20', 'appliances' ) ) ); ?>)</a>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card">
                    <div class="card-header bg-secondary-subtle">
                        Being Reviewed
                    </div>
                    <div class="card-body">
                        <a href="#" class="">View (0)</a>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card">
                    <div class="card-header bg-secondary-subtle">
                        Reviewer Rejected
                    </div>
                    <div class="card-body">
                        <a href="#" class="">View (0)</a>
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
                        <?php if (count( $db->get_revoked_requested( '%'.$country_slug.'_revoke_status_id', '200', 'appliances' ) ) > 0 ) { ?>
                            <a href="/data-entry/appliances/?revoked=true&key=%<?php echo esc_html( $country_slug ); ?>_revoke_status_id&value=200" class="">View (<?php echo esc_html( count( $db->get_revoked_requested( '%'.$country_slug.'_revoke_status_id', '200', 'appliances' ) ) ); ?>)</a>
                        <?php } ?>
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
                        <?php if(count( $db->get_revoked_requested( '%'.$country_slug.'_revoke_status_id', '60', 'appliances' ) )) { ?>
                            <a href="/data-entry/appliances/?revoked=true&key=%<?php echo esc_html( $country_slug ); ?>_revoke_status_id&value=60" class="">View (<?php echo esc_html( count( $db->get_revoked_requested( '%'.$country_slug.'_revoke_status_id', '60', 'appliances' ) ) ); ?>)</a>
                        <?php } ?>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card">
                <div class="card-header bg-primary-subtle">
                        Approved by DA
                    </div>
                    <div class="card-body">
                        <!-- <a href="#" class="">View (0)</a> -->
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card">
                    <div class="card-header bg-danger text-white">
                        Rejected by DA
                    </div>
                    <div class="card-body">
                        <!-- <a href="#" class="">View (0)</a> -->
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card">
                <div class="card-header bg-success-subtle">
                        Awaiting Publication
                    </div>
                    <div class="card-body">
                        <?php if ( count( $db->get_revoked_requested( '%'.$country_slug.'_revoke_status_id', '300', 'appliances' ) ) ) { ?>
                            <a href="/data-entry/appliances/?revoked=true&key=%<?php echo esc_html( $country_slug ); ?>_revoke_status_id&value=300" class="">View (<?php echo esc_html( count( $db->get_revoked_requested( '%'.$country_slug.'_revoke_status_id', '300', 'appliances' ) ) ); ?>)</a>
                        <?php } ?>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card">
                    <div class="card-header bg-success text-white">
                        Published
                    </div>
                    <div class="card-body">
                        <?php if ( count( $db->get_revoked_requested( '%'.$country_slug.'_revoke_status_id', '400', 'appliances' ) ) ) { ?>
                            <a href="/data-entry/appliances/?revoked=true&key=%<?php echo esc_html( $country_slug ); ?>_revoke_status_id&value=400" class="">View (<?php echo esc_html( count( $db->get_revoked_requested( '%'.$country_slug.'_revoke_status_id', '400', 'appliances' ) ) ); ?>)</a>
                        <?php } ?>
                    </div>
                </div>
            </div>
        <?php } ?>

        </div>
    </div>

</div>

<!-- <div class="status-block">
    <div class="bg-secondary rounded text-white p-1 mb-2">
        <h5 class="m-2">Cancellation Requests</h5>
    </div>

    <div class="mb-2">
        <div class="row">
        <?php if ( array_intersect( $data_entry_review_users, $user->roles ) ) { ?>
            <div class="col">
                <div class="card">
                    <div class="card-header bg-secondary-subtle">
                        Draft
                    </div>
                    <div class="card-body">
                        <a href="/data-entry/appliances/?status=10&cancel=1" class="app-draft">View (<?php echo esc_html( $db->count_appliance_cancel_draft() ); ?>)</a>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card">
                    <div class="card-header bg-secondary-subtle">
                        Awaiting Review
                    </div>
                    <div class="card-body">
                        <a href="/data-entry/appliances/?status=20&cancel=1" class="app-draft">View (<?php echo esc_html( $db->count_appliance_cancel_awaiting_review() ); ?>)</a>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card">
                    <div class="card-header bg-secondary-subtle">
                        Being Reviewed
                    </div>
                    <div class="card-body">
                        <a href="/data-entry/appliances/?status=30&cancel=1" class="app-draft">View (<?php echo esc_html( $db->count_appliance_cancel_being_reviewed() ); ?>)</a>
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
                    </div>
                </div>
            </div>
        <?php } ?>

        <?php if ( array_intersect( $all_users, $user->roles ) ) { ?>
            <div class="col">
                <div class="card">
                    <div class="card-header bg-secondary-subtle">
                        Submitted to DA
                    </div>
                    <div class="card-body">
                        <a href="/data-entry/appliances/?status=50&cancel=1" class="app-draft">View (<?php echo esc_html( $db->count_appliance_cancel_submitted_to_da() ); ?>)</a>
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
                    <div class="card-header bg-success text-white">
                        Assigned to DA
                    </div>
                    <div class="card-body">
                        <a href="/data-entry/appliances/?status=60&cancel=1" class="app-draft">View (<?php echo esc_html( $db->count_appliance_cancel_assigned_to_da() ); ?>)</a>

                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card">
                    <div class="card-header bg-success text-white">
                        Approved by DA
                    </div>
                    <div class="card-body">
                        <a href="/data-entry/appliances/?status=70&cancel=1" class="app-draft">View (<?php echo esc_html( $db->count_appliance_cancel_approved_by_da() ); ?>)</a>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card">
                    <div class="card-header bg-success text-white">
                        Rejected by DA
                    </div>
                    <div class="card-body">
                        <a href="/data-entry/appliances/?status=80&cancel=1" class="app-draft">View (<?php echo esc_html( $db->count_appliance_cancel_rejected_by_da() ); ?>)</a>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card">
                    <div class="card-header bg-success text-white">
                        Awaiting Publication
                    </div>
                    <div class="card-body">
                        <a href="/data-entry/appliances/?status=500&cancel=1" class="app-draft">View (<?php echo esc_html( $db->count_appliance_cancel_awaiting_publication() ); ?>)</a>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card">
                    <div class="card-header bg-success text-white">
                        Published
                    </div>
                    <div class="card-body">
                        <a href="/data-entry/appliances/?status=600&cancel=1" class="app-draft">View (<?php echo esc_html( $db->count_appliance_cancel_published() ); ?>)</a>
                    </div>
                </div>
            </div>
        <?php } ?>
        </div>
    </div>

</div> -->

