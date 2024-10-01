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

			<?php } ?>
			<?php if ( array_intersect( $all_users, $user->roles ) ) { ?>
			<div class="col">
				<div class="card">
					<div class="card-header bg-success-subtle">
						Submitted to DA
					</div>
					<div class="card-body">
						<?php if( $db->count_fuel_submitted_to_da($country) > 0 ) { ?>
						<a href="/data-entry/fuels/?status=50" class="">View (<?php echo esc_html( $db->count_fuel_submitted_to_da($country) ); ?>)</a>
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
						<?php if( $db->count_fuel_assigned_to_da() > 0 ) { ?>
						<a href="/data-entry/fuels/?status=60" class="">View (<?php echo esc_html( $db->count_fuel_assigned_to_da() ); ?>)</a>
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
						<?php if( $db->count_fuel_approved_by_da() > 0 ) { ?>
						<a href="/data-entry/fuels/?status=70" class="">View (<?php echo esc_html( $db->count_fuel_approved_by_da() ); ?>)</a>
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
						<?php if( $db->count_fuel_rejected_by_da() > 0 ) { ?>
						<a href="/data-entry/fuels/?status=80" class="">View (<?php echo esc_html( $db->count_fuel_rejected_by_da() ); ?>)</a>
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
						<?php if( $db->count_fuel_awaiting_publication() > 0 ) { ?>
						<a href="/data-entry/fuels/?status=500" class="">View (<?php echo esc_html( $db->count_fuel_awaiting_publication() ); ?>)</a>
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
						<?php if( $db->count_fuel_published() > 0 ) { ?>
						<a href="/data-entry/fuels/?status=600" class="">View (<?php echo esc_html( $db->count_fuel_published() ); ?>)</a>
						<?php } ?>
					</div>
				</div>
			</div>
			<?php } ?>
		</div>
	</div>

</div>

<div class="status-block mb-5">
	<div class="bg-secondary rounded text-white p-1 mb-2">
		<h4 class="m-0">Revocation Requests</h1>
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
						<a href="#" class="">View (0)</a>
					</div>
				</div>
			</div>
			<div class="col">
				<div class="card">
					<div class="card-header bg-info text-white">
						Awaiting Review
					</div>
					<div class="card-body">
						<a href="/data-entry/fuels/?revoked=true&key=%_revoke_status_id&value=20" class="">View (<?php echo esc_html( count( $db->get_revoked_requested( '%_revoke_status_id', '20', 'fuels' ) ) ); ?>)</a>
					</div>
				</div>
			</div>
			<div class="col">
				<div class="card">
					<div class="card-header bg-secondary-subtle">
						Being Reviewed
					</div>
					<div class="card-body">
						<a href="/data-entry/fuels/?revoked=true&key=%_revoke_status_id&value=30" class="">View (<?php echo esc_html( count( $db->get_revoked_requested( '%_revoke_status_id', '30', 'fuels' ) ) ); ?>)</a>
					</div>
				</div>
			</div>
			<div class="col">
				<div class="card">
					<div class="card-header bg-danger text-white">
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
						<?php if ( count( $db->get_revoked_requested( '%'.$country_slug.'_revoke_status_id', '200', 'fuels' ) ) > 0 ) { ?>
						<a href="/data-entry/fuels/?revoked=true&key=%<?php echo esc_html( $country_slug ); ?>_revoke_status_id&value=200" class="">View (<?php echo esc_html( count( $db->get_revoked_requested( '%'.$country_slug.'_revoke_status_id', '200', 'fuels' ) ) ); ?>)</a>
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
						<?php if ( count( $db->get_revoked_requested( '%'.$country_slug.'_revoke_status_id', '60', 'fuels' ) ) ) { ?>
						<a href="/data-entry/fuels/?revoked=true&key=%<?php echo esc_html( $country_slug ); ?>_revoke_status_id&value=60" class="">View (<?php echo esc_html( count( $db->get_revoked_requested( '%'.$country_slug.'_revoke_status_id', '60', 'fuels' ) ) ); ?>)</a>
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
						<?php if ( count( $db->get_revoked_requested( '%'.$country_slug.'_revoke_status_id', '300', 'fuels' ) ) ) { ?>
						<a href="/data-entry/fuels/?revoked=true&key=%<?php echo esc_html( $country_slug ); ?>_revoke_status_id&value=300" class="">View (<?php echo esc_html( count( $db->get_revoked_requested( '%'.$country_slug.'_revoke_status_id', '300', 'fuels' ) ) ); ?>)</a>
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
						<?php if ( count( $db->get_revoked_requested( '%'.$country_slug.'_revoke_status_id', '400', 'fuels' ) ) ) { ?>
						<a href="/data-entry/fuels/?revoked=true&key=%<?php echo esc_html( $country_slug ); ?>_revoke_status_id&value=400" class="">View (<?php echo esc_html( count( $db->get_revoked_requested( '%'.$country_slug.'_revoke_status_id', '400', 'fuels' ) ) ); ?>)</a>
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
        <h4 class="m-0">Cancellation Requests</h1>
    </div>

    <div class="mb-2">
        <div class="row">
        <?php if ( array_intersect( $data_entry_review_users, $user->roles ) ) { ?>
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
        <?php } ?>
        <?php if ( array_intersect( $all_users, $user->roles ) ) { ?>
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
        <?php } ?>
        </div>
    </div>

    <div class="mb-2">
        <div class="row">
        <?php if ( array_intersect( $all_users, $user->roles ) ) { ?>

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
        <?php } ?>

        </div>
    </div>

</div> -->
