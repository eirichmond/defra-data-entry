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
                        <a href="/data-entry/fuels/?status=10" class="">View (<?php echo esc_html( $db->count_fuel_draft() ); ?>)</a>
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="card">
                    <div class="card-header bg-info text-white">
                        Awaiting Review
                    </div>
                    <div class="card-body">
                        <a href="/data-entry/fuels/?status=20" class="">View (<?php echo esc_html( $db->count_fuel_awaiting_review() ); ?>)</a>
                    </div>
                </div>
            </div>
            
            <div class="col">
                <div class="card">
                    <div class="card-header bg-secondary-subtle">
                        Being Reviewed
                    </div>
                    <div class="card-body">
                        <a href="/data-entry/fuels/?status=30" class="">View (<?php echo esc_html( $db->count_fuel_being_reviewed() ); ?>)</a>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card">
                    <div class="card-header bg-danger text-white">
                        Reviewer Rejected
                    </div>
                    <div class="card-body">
                    <a href="/data-entry/fuels/?status=40" class="">View (<?php echo esc_html( $db->count_fuel_reviewer_rejected() ); ?>)</a>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card">
                    <div class="card-header bg-success text-white">
                        Submitted to DA
                    </div>
                    <div class="card-body">
                        <a href="/data-entry/fuels/?status=50" class="">View (<?php echo esc_html( $db->count_fuel_submitted_to_da() ); ?>)</a>
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
                        <a href="/data-entry/fuels/?status=60" class="">View (<?php echo esc_html( $db->count_fuel_assigned_to_da() ); ?>)</a>
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="card">
                    <div class="card-header bg-primary-subtle">
                        Approved by DA
                    </div>
                    <div class="card-body">
                    <a href="/data-entry/fuels/?status=70" class="">View (<?php echo esc_html( $db->count_fuel_approved_by_da() ); ?>)</a>
                    </div>
                </div>
            </div>
            
            <div class="col">
                <div class="card">
                    <div class="card-header bg-danger text-white">
                        Rejected by DA
                    </div>
                    <div class="card-body">
                        <a href="/data-entry/fuels/?status=80" class="">View (<?php echo esc_html( $db->count_fuel_rejected_by_da() ); ?>)</a>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card">
                    <div class="card-header bg-success-subtle">
                        Awaiting Publication
                    </div>
                    <div class="card-body">
                        <a href="/data-entry/fuels/?status=500" class="">View (<?php echo esc_html( $db->count_fuel_awaiting_publication() ); ?>)</a>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card">
                    <div class="card-header bg-success text-white">
                        Submitted to DA
                    </div>
                    <div class="card-body">
                        <a href="/data-entry/fuels/?status=600" class="">View (<?php echo esc_html( $db->count_fuel_published() ); ?>)</a>
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

    <div class="mb-2">
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

    <div class="mb-2">
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

    <div class="mb-2">
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

    <div class="mb-2">
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