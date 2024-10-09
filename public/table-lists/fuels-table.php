<table id="table_id" class="display">
	<thead>
		<tr>
			<th>Fuel ID</th>
			<th>Fuel</th>
			<th>Manufacturer</th>
			<?php foreach ( $args['countries'] as $k => $country ) { ?>
				<th><?php echo esc_html( $country ); ?></th>
			<?php } ?>
		</tr>
	</thead>
	<tbody>
		<?php foreach($fuels as $k => $v) {
				$footnote8 = get_post_meta( $v->ID, 'authorised_country_and_statutory_instrument_england_si_0_si_id', true );
			?>
		<tr>
			<td><?php echo esc_html( $footnote8 == '55361' ? 'MSF' . str_pad($v->fuel_id, 4, '0', STR_PAD_LEFT) : str_pad($v->fuel_id, 4, '0', STR_PAD_LEFT) ); ?></td>
			<td><?php echo esc_html( $v->post_title ); ?></td>
			<td><?php echo esc_html( $v->manufacturer_name ); ?></td>

			<?php foreach ( $args['countries'] as $k => $country ) {  ?>
				<td>
					<?php $si_assignment = $public_class->statutory_instrument_assignment( $v->ID, $k, 'fuel' ); 

						if( $si_assignment[0]['publish_status'] != '600' || !empty( $si_assignment[0]['revoke_status_id'] ) ) { ?>
					<span>No</span>
					<?php } elseif ( $si_assignment[0]['status'] == 0 ) { ?>

					<a href="<?php echo esc_url( get_permalink($v) ); ?>">View detailed information</a>

					<?php } elseif ( $si_assignment[0]['status'] == 1 ) { ?>

					<a href="<?php echo esc_url( $si_assignment[0]['url'] ); ?>"><?php echo esc_html( $si_assignment[0]['title'] ); ?></a>

					<?php } ?>

				</td>
			<?php } ?>

		</tr>

		<?php } ?>
	</tbody>
</table>

<div class="pb-4">
	<?php include plugin_dir_path( __DIR__ ) . 'partials/fuel-footnotes.php'; ?>
</div>
