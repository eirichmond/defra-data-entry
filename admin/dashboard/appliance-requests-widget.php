<table class="widefat">
	<thead>
		<tr>
			<th class="row-title draft text-white">Draft</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td class="row-title">
				<label for="tablecell"><a href="<?php echo admin_url() . 'edit.php?post_status=draft&post_type=appliances'; ?>">View (<?php echo esc_html( $draft_appliances_count ); ?>)</a></label>
			</td>
		</tr>
	</tbody>
</table>

<table class="widefat">
	<thead>
		<tr>
			<th class="row-title awiating-review text-white">Awaiting Review</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td class="row-title">
				<label for="tablecell"><a href="<?php echo admin_url() . 'edit.php?post_status=pending&post_type=appliances'; ?>">View (<?php echo esc_html( $pending_appliances_count ); ?>)</a></label>
			</td>
		</tr>
	</tbody>
</table>

<table class="widefat">
	<thead>
		<tr>
			<th class="row-title being-reviewed text-white">Being Reviewed</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td class="row-title">
				<label for="tablecell"><a href="#">View (x) << surely this is the same as above? Awaiting Review?? if this is the case doesn't it make this status redundant? </a></label>
			</td>
		</tr>
	</tbody>
</table>

<table class="widefat">
	<thead>
		<tr>
			<th class="row-title reviewer-rejected text-white">Reviewer Rejected</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td class="row-title">
				<label for="tablecell"><a href="<?php echo admin_url() . 'edit.php?post_status=rejected&post_type=appliances'; ?>">View (<?php echo esc_html( $reveiwer_rejected_appliances_count ); ?>)</a></label>
			</td>
		</tr>
	</tbody>
</table>

<table class="widefat">
	<thead>
		<tr>
			<th class="row-title submitted-to-da text-white">Submitted to DA</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td class="row-title">
				<label for="tablecell"><a href="<?php echo admin_url() . 'edit.php?post_status=approved&post_type=appliances'; ?>">View (<?php echo esc_html( $reveiwer_approved_appliances_count ); ?>)</a></label>
			</td>
		</tr>
	</tbody>
</table>

<table class="widefat">
	<thead>
		<tr>
			<th class="row-title assigned-to-da text-white">Assigned to DA</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td class="row-title">
				<label for="tablecell"><a href="#">View (x)</a></label>
			</td>
		</tr>
	</tbody>
</table>

<table class="widefat">
	<thead>
		<tr>
			<th class="row-title approved-by-da text-white">Approved by DA</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td class="row-title">
				<label for="tablecell"><a href="#">View (x)</a></label>
			</td>
		</tr>
	</tbody>
</table>

<table class="widefat">
	<thead>
		<tr>
			<th class="row-title rejected-by-da text-white">Rejected by DA</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td class="row-title">
				<label for="tablecell"><a href="#">View (x)</a></label>
			</td>
		</tr>
	</tbody>
</table>

<table class="widefat">
	<thead>
		<tr>
			<th class="row-title awaiting-publication text-white">Awaiting Publication</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td class="row-title">
				<label for="tablecell"><a href="#">View (x)</a></label>
			</td>
		</tr>
	</tbody>
</table>

<table class="widefat">
	<thead>
		<tr>
			<th class="row-title published text-white">Published</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td class="row-title">
				<label for="tablecell"><a href="<?php echo admin_url() . 'edit.php?post_status=publish&post_type=appliances'; ?>">View (<?php echo esc_html( $published_appliances_count ); ?>)</a></label>
			</td>
		</tr>
	</tbody>
</table>