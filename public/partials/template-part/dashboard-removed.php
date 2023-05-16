<div class="section-panel">
        <p class="block bg-gray-500 text-white px-2 py-1 my-2">Revocation Requests</p>
        <div class="flex space-x-2 justify-between my-2">
            <div class="object-contain w-full">
                <div class="block bg-blue-900 px-2 py-1 text-white">Draft</div>
                <div class="px-2 py-1">
                    <!-- <a href="#" class="block">View (<?php echo esc_html( $db->count_appliance_draft() ); ?>)</a> -->
                </div>
            </div>
            <div class="object-contain w-full">
                <div class="block bg-blue-700 px-2 py-1 text-white">Awaiting Review</div>
                <div class="px-2 py-1">
                    <!-- <a href="#" class="block">View (<?php echo esc_html( $db->count_appliance_awaiting_review() ); ?>)</a> -->
                </div>
            </div>
            <div class="object-contain w-full">
                <div class="block bg-gray-200 px-2 py-1">Being Reviewed</div>
                <div class="px-2 py-1">
                    <!-- <a href="#" class="block">View (<?php echo esc_html( $db->count_appliance_being_reviewed() ); ?>)</a> -->
                </div>
            </div>
            <div class="object-contain w-full">
                <div class="block bg-gray-200 px-2 py-1">Reviewer Rejected</div>
                <div class="px-2 py-1">
                    <!-- <a href="#" class="block">View (<?php echo esc_html( $db->count_appliance_reviewer_rejected() ); ?>)</a> -->
                </div>
            </div>
            <div class="object-contain w-full">
                <div class="block bg-green-900 px-2 py-1 text-white">Submitted to DA</div>
                <div class="px-2 py-1">
                    <a href="#" class="block">View (<?php echo esc_html( $db->count_revocated_appliance_submitted_to_da() ); ?>)</a>
                </div>
            </div>
        </div>
        <div class="flex space-x-2 justify-between my-2">
            <div class="object-contain w-full">
                <div class="block bg-green-600 px-2 py-1 text-white">Assigned to DA</div>
                <div class="px-2 py-1">
                    <!-- <a href="#" class="block">View (<?php echo esc_html( $db->count_appliance_assigned_to_da() ); ?>)</a> -->
                </div>
            </div>
            <div class="object-contain w-full">
                <div class="block bg-green-700 px-2 py-1 text-white">Approved by DA</div>
                <div class="px-2 py-1">
                    <a href="#" class="block">View (<?php echo esc_html( $db->count_revocated_appliance_approved_by_da() ); ?>)</a>
                </div>
            </div>
            <div class="object-contain w-full">
                <div class="block bg-red-600 px-2 py-1 text-white">Rejected by DA</div>
                <div class="px-2 py-1">
                    <!-- <a href="#" class="block">View (<?php echo esc_html( $db->count_appliance_rejected_by_da() ); ?>)</a> -->
                </div>
            </div>
            <div class="object-contain w-full">
                <div class="block bg-green-400 px-2 py-1">Awaiting Publication</div>
                <div class="px-2 py-1">
                    <!-- <a href="#" class="block">View (<?php echo esc_html( $db->count_appliance_awaiting_publication() ); ?>)</a> -->
                </div>
            </div>
            <div class="object-contain w-full">
                <div class="block bg-green-900 px-2 py-1 text-white">Published</div>
                <div class="px-2 py-1">
                    <a href="#" class="block">View (<?php echo esc_html( $db->count_revocated_appliance_published() ); ?>)</a>
                </div>
            </div>
        </div>
    </div>

    <div class="section-panel">
        <p class="block bg-gray-500 text-white px-2 py-1 my-2">Cancellation Requests</p>
        <div class="flex space-x-2 justify-between my-2">
            <div class="object-contain w-full">
                <div class="block bg-blue-900 px-2 py-1 text-white">Draft</div>
                <div class="px-2 py-1">
                    <!-- <a href="#" class="block">View (<?php echo esc_html( $db->count_appliance_draft() ); ?>)</a> -->
                </div>
            </div>
            <div class="object-contain w-full">
                <div class="block bg-blue-700 px-2 py-1 text-white">Awaiting Review</div>
                <div class="px-2 py-1">
                    <!-- <a href="#" class="block">View (<?php echo esc_html( $db->count_appliance_awaiting_review() ); ?>)</a> -->
                </div>
            </div>
            <div class="object-contain w-full">
                <div class="block bg-gray-200 px-2 py-1">Being Reviewed</div>
                <div class="px-2 py-1">
                    <!-- <a href="#" class="block">View (<?php echo esc_html( $db->count_appliance_being_reviewed() ); ?>)</a> -->
                </div>
            </div>
            <div class="object-contain w-full">
                <div class="block bg-gray-200 px-2 py-1">Reviewer Rejected</div>
                <div class="px-2 py-1">
                    <!-- <a href="#" class="block">View (<?php echo esc_html( $db->count_appliance_reviewer_rejected() ); ?>)</a> -->
                </div>
            </div>
            <div class="object-contain w-full">
                <div class="block bg-green-900 px-2 py-1 text-white">Submitted to DA</div>
                <div class="px-2 py-1">
                    <a href="#" class="block">View (<?php echo esc_html( $db->count_cancellation_appliance_submitted_to_da() ); ?>)</a>
                </div>
            </div>
        </div>
        <div class="flex space-x-2 justify-between my-2">
            <div class="object-contain w-full">
                <div class="block bg-green-600 px-2 py-1 text-white">Assigned to DA</div>
                <div class="px-2 py-1">
                    <!-- <a href="#" class="block">View (<?php echo esc_html( $db->count_appliance_assigned_to_da() ); ?>)</a> -->
                </div>
            </div>
            <div class="object-contain w-full">
                <div class="block bg-green-700 px-2 py-1 text-white">Approved by DA</div>
                <div class="px-2 py-1">
                    <a href="#" class="block">View (<?php echo esc_html( $db->count_cancellation_appliance_approved_by_da() ); ?>)</a>
                </div>
            </div>
            <div class="object-contain w-full">
                <div class="block bg-red-600 px-2 py-1 text-white">Rejected by DA</div>
                <div class="px-2 py-1">
                    <!-- <a href="#" class="block">View (<?php echo esc_html( $db->count_appliance_rejected_by_da() ); ?>)</a> -->
                </div>
            </div>
            <div class="object-contain w-full">
                <div class="block bg-green-400 px-2 py-1">Awaiting Publication</div>
                <div class="px-2 py-1">
                    <!-- <a href="#" class="block">View (<?php echo esc_html( $db->count_appliance_awaiting_publication() ); ?>)</a> -->
                </div>
            </div>
            <div class="object-contain w-full">
                <div class="block bg-green-900 px-2 py-1 text-white">Published</div>
                <div class="px-2 py-1">
                    <!-- <a href="#" class="block">View (<?php echo esc_html( $db->count_appliance_published() ); ?>)</a> -->
                </div>
            </div>
        </div>
    </div>

    <h2 class="entry-title">Fuel Statuses</h2>

    <div class="section-panel">
        <p class="block bg-gray-500 text-white px-2 py-1 my-2">Requests</p>
        <div class="flex space-x-2 justify-between my-2">
            <div class="object-contain w-full">
                <div class="block bg-blue-900 px-2 py-1 text-white">Draft</div>
                <div class="px-2 py-1">
                    <a href="#" class="block">View (<?php echo esc_html( $db->count_fuel_draft() ); ?>)</a>
                </div>
            </div>
            <div class="object-contain w-full">
                <div class="block bg-blue-700 px-2 py-1 text-white">Awaiting Review</div>
                <div class="px-2 py-1">
                    <a href="#" class="block">View (<?php echo esc_html( $db->count_fuel_awaiting_review() ); ?>)</a>
                </div>
            </div>
            <div class="object-contain w-full">
                <div class="block bg-gray-200 px-2 py-1">Being Reviewed</div>
                <div class="px-2 py-1">
                    <a href="#" class="block">View (<?php echo esc_html( $db->count_fuel_being_reviewed() ); ?>)</a>
                </div>
            </div>
            <div class="object-contain w-full">
                <div class="block bg-gray-200 px-2 py-1">Reviewer Rejected</div>
                <div class="px-2 py-1">
                    <a href="#" class="block">View (<?php echo esc_html( $db->count_fuel_reviewer_rejected() ); ?>)</a>
                </div>
            </div>
            <div class="object-contain w-full">
                <div class="block bg-green-900 px-2 py-1 text-white">Submitted to DA</div>
                <div class="px-2 py-1">
                    <a href="#" class="block">View (<?php echo esc_html( $db->count_fuel_submitted_to_da() ); ?>)</a>
                </div>
            </div>
        </div>
        <div class="flex space-x-2 justify-between my-2">
            <div class="object-contain w-full">
                <div class="block bg-green-600 px-2 py-1 text-white">Assigned to DA</div>
                <div class="px-2 py-1">
                    <a href="#" class="block">View (<?php echo esc_html( $db->count_fuel_assigned_to_da() ); ?>)</a>
                </div>
            </div>
            <div class="object-contain w-full">
                <div class="block bg-green-700 px-2 py-1 text-white">Approved by DA</div>
                <div class="px-2 py-1">
                    <a href="#" class="block">View (<?php echo esc_html( $db->count_fuel_approved_by_da() ); ?>)</a>
                </div>
            </div>
            <div class="object-contain w-full">
                <div class="block bg-red-600 px-2 py-1 text-white">Rejected by DA</div>
                <div class="px-2 py-1">
                    <a href="#" class="block">View (<?php echo esc_html( $db->count_fuel_rejected_by_da() ); ?>)</a>
                </div>
            </div>
            <div class="object-contain w-full">
                <div class="block bg-green-400 px-2 py-1">Awaiting Publication</div>
                <div class="px-2 py-1">
                    <a href="#" class="block">View (<?php echo esc_html( $db->count_fuel_awaiting_publication() ); ?>)</a>
                </div>
            </div>
            <div class="object-contain w-full">
                <div class="block bg-green-900 px-2 py-1 text-white">Published</div>
                <div class="px-2 py-1">
                    <a href="#" class="block">View (<?php echo esc_html( $db->count_fuel_published() ); ?>)</a>
                </div>
            </div>
        </div>
    </div>

    <div class="section-panel">
        <p class="block bg-gray-500 text-white px-2 py-1 my-2">Revocation Requests</p>
        <div class="flex space-x-2 justify-between my-2">
            <div class="object-contain w-full">
                <div class="block bg-blue-900 px-2 py-1 text-white">Draft</div>
                <div class="px-2 py-1">
                    <!-- <a href="#" class="block">View (<?php echo esc_html( $db->count_fuel_draft() ); ?>)</a> -->
                </div>
            </div>
            <div class="object-contain w-full">
                <div class="block bg-blue-700 px-2 py-1 text-white">Awaiting Review</div>
                <div class="px-2 py-1">
                    <!-- <a href="#" class="block">View (<?php echo esc_html( $db->count_fuel_awaiting_review() ); ?>)</a> -->
                </div>
            </div>
            <div class="object-contain w-full">
                <div class="block bg-gray-200 px-2 py-1">Being Reviewed</div>
                <div class="px-2 py-1">
                    <!-- <a href="#" class="block">View (<?php echo esc_html( $db->count_fuel_being_reviewed() ); ?>)</a> -->
                </div>
            </div>
            <div class="object-contain w-full">
                <div class="block bg-gray-200 px-2 py-1">Reviewer Rejected</div>
                <div class="px-2 py-1">
                    <!-- <a href="#" class="block">View (<?php echo esc_html( $db->count_fuel_reviewer_rejected() ); ?>)</a> -->
                </div>
            </div>
            <div class="object-contain w-full">
                <div class="block bg-green-900 px-2 py-1 text-white">Submitted to DA</div>
                <div class="px-2 py-1">
                    <a href="#" class="block">View (<?php echo esc_html( $db->count_revocated_fuel_submitted_to_da() ); ?>)</a>
                </div>
            </div>
        </div>
        <div class="flex space-x-2 justify-between my-2">
            <div class="object-contain w-full">
                <div class="block bg-green-600 px-2 py-1 text-white">Assigned to DA</div>
                <div class="px-2 py-1">
                    <!-- <a href="#" class="block">View (<?php echo esc_html( $db->count_fuel_assigned_to_da() ); ?>)</a> -->
                </div>
            </div>
            <div class="object-contain w-full">
                <div class="block bg-green-700 px-2 py-1 text-white">Approved by DA</div>
                <div class="px-2 py-1">
                    <a href="#" class="block">View (<?php echo esc_html( $db->count_revocated_fuel_approved_by_da() ); ?>)</a>
                </div>
            </div>
            <div class="object-contain w-full">
                <div class="block bg-red-600 px-2 py-1 text-white">Rejected by DA</div>
                <div class="px-2 py-1">
                    <!-- <a href="#" class="block">View (<?php echo esc_html( $db->count_fuel_rejected_by_da() ); ?>)</a> -->
                </div>
            </div>
            <div class="object-contain w-full">
                <div class="block bg-green-400 px-2 py-1">Awaiting Publication</div>
                <div class="px-2 py-1">
                    <!-- <a href="#" class="block">View (<?php echo esc_html( $db->count_fuel_awaiting_publication() ); ?>)</a> -->
                </div>
            </div>
            <div class="object-contain w-full">
                <div class="block bg-green-900 px-2 py-1 text-white">Published</div>
                <div class="px-2 py-1">
                    <a href="#" class="block">View (<?php echo esc_html( $db->count_revocated_fuel_published() ); ?>)</a>
                </div>
            </div>
        </div>
    </div>

    <div class="section-panel">
        <p class="block bg-gray-500 text-white px-2 py-1 my-2">Cancellation Requests</p>
        <div class="flex space-x-2 justify-between my-2">
            <div class="object-contain w-full">
                <div class="block bg-blue-900 px-2 py-1 text-white">Draft</div>
                <div class="px-2 py-1">
                    <!-- <a href="#" class="block">View (<?php echo esc_html( $db->count_fuel_draft() ); ?>)</a> -->
                </div>
            </div>
            <div class="object-contain w-full">
                <div class="block bg-blue-700 px-2 py-1 text-white">Awaiting Review</div>
                <div class="px-2 py-1">
                    <!-- <a href="#" class="block">View (<?php echo esc_html( $db->count_fuel_awaiting_review() ); ?>)</a> -->
                </div>
            </div>
            <div class="object-contain w-full">
                <div class="block bg-gray-200 px-2 py-1">Being Reviewed</div>
                <div class="px-2 py-1">
                    <!-- <a href="#" class="block">View (<?php echo esc_html( $db->count_fuel_being_reviewed() ); ?>)</a> -->
                </div>
            </div>
            <div class="object-contain w-full">
                <div class="block bg-gray-200 px-2 py-1">Reviewer Rejected</div>
                <div class="px-2 py-1">
                    <!-- <a href="#" class="block">View (<?php echo esc_html( $db->count_fuel_reviewer_rejected() ); ?>)</a> -->
                </div>
            </div>
            <div class="object-contain w-full">
                <div class="block bg-green-900 px-2 py-1 text-white">Submitted to DA</div>
                <div class="px-2 py-1">
                    <a href="#" class="block">View (<?php echo esc_html( $db->count_cancellation_fuel_submitted_to_da() ); ?>)</a>
                </div>
            </div>
        </div>
        <div class="flex space-x-2 justify-between my-2">
            <div class="object-contain w-full">
                <div class="block bg-green-600 px-2 py-1 text-white">Assigned to DA</div>
                <div class="px-2 py-1">
                    <!-- <a href="#" class="block">View (<?php echo esc_html( $db->count_fuel_assigned_to_da() ); ?>)</a> -->
                </div>
            </div>
            <div class="object-contain w-full">
                <div class="block bg-green-700 px-2 py-1 text-white">Approved by DA</div>
                <div class="px-2 py-1">
                    <a href="#" class="block">View (<?php echo esc_html( $db->count_cancellation_fuel_approved_by_da() ); ?>)</a>
                </div>
            </div>
            <div class="object-contain w-full">
                <div class="block bg-red-600 px-2 py-1 text-white">Rejected by DA</div>
                <div class="px-2 py-1">
                    <!-- <a href="#" class="block">View (<?php echo esc_html( $db->count_fuel_rejected_by_da() ); ?>)</a> -->
                </div>
            </div>
            <div class="object-contain w-full">
                <div class="block bg-green-400 px-2 py-1">Awaiting Publication</div>
                <div class="px-2 py-1">
                    <!-- <a href="#" class="block">View (<?php echo esc_html( $db->count_fuel_awaiting_publication() ); ?>)</a> -->
                </div>
            </div>
            <div class="object-contain w-full">
                <div class="block bg-green-900 px-2 py-1 text-white">Published</div>
                <div class="px-2 py-1">
                    <!-- <a href="#" class="block">View (<?php echo esc_html( $db->count_fuel_published() ); ?>)</a> -->
                </div>
            </div>
        </div>
    </div>

