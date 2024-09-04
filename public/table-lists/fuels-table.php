<table id="table_id" class="display">
    <thead>
        <tr>
            <th>Fuel ID</th>
            <th>Fuel</th>
            <th>Manufacturer</th>
            <th>England</th>
            <th>Wales</th>
            <th>Scotland</th>
            <th>Northern Ireland</th>
        </tr>
    </thead>
    <tbody>
		<?php foreach($fuels as $k => $v) { ?>
			<tr>
				<td><?php echo esc_html( $v->fuel_id ); ?></td>
				<td><?php echo esc_html( $v->post_title ); ?></td>
				<td><?php echo esc_html( $v->manufacturer_name ); ?></td>
				<td>

                    <?php $si_assignment = $public_class->statutory_instrument_assignment( $v->ID, 'england', 'fuel' ); 

                    if( $si_assignment[0]['publish_status'] != '600' ) { ?>
                        <span>No</span>
                    <?php } elseif ( $si_assignment[0]['status'] == 0 ) { ?>

                        <a href="<?php echo esc_url( get_permalink($v) ); ?>">View detailed information</a>

                    <?php } elseif ( $si_assignment[0]['status'] == 1 ) { ?>

                        <a href="<?php echo esc_url( $si_assignment[0]['url'] ); ?>"><?php echo esc_html( $si_assignment[0]['title'] ); ?></a>
                                        
                    <?php } ?>

                </td>
				<td>

                    <?php
					$si_assignment = $public_class->statutory_instrument_assignment( $v->ID, 'wales', 'fuel'  ); 
					if( $si_assignment[0]['publish_status'] != '600' ) { ?>
						<span>No</span>
					<?php } elseif ( $si_assignment[0]['status'] == 0 ) { ?>

						<a href="<?php echo esc_url( get_permalink($v) ); ?>">View detailed information</a>

					<?php } elseif ( $si_assignment[0]['status'] == 1 ) { ?>

						<a href="<?php echo esc_url( $si_assignment[0]['url'] ); ?>"><?php echo esc_html( $si_assignment[0]['title'] ); ?></a>
										
					<?php } ?>

                </td>
				<td>

                    <?php
					$si_assignment = $public_class->statutory_instrument_assignment( $v->ID, 'scotland', 'fuel'  ); 
					if( $si_assignment[0]['publish_status'] != '600' )  { ?>
						<span>No</span>
					<?php } elseif ( $si_assignment[0]['status'] == 0 ) { ?>

						<a href="<?php echo esc_url( get_permalink($v) ); ?>">View detailed information</a>

					<?php } elseif ( $si_assignment[0]['status'] == 1 ) { ?>

						<a href="<?php echo esc_url( $si_assignment[0]['url'] ); ?>"><?php echo esc_html( $si_assignment[0]['title'] ); ?></a>
										
					<?php } ?>

                </td>
				<td>

                    <?php
					$si_assignment = $public_class->statutory_instrument_assignment( $v->ID, 'n_ireland', 'fuel'  ); 
					if( $si_assignment[0]['publish_status'] != '600')  { ?>
						<span>No</span>
					<?php } elseif ( $si_assignment[0]['status'] == 0 ) { ?>

						<a href="<?php echo esc_url( get_permalink($v) ); ?>">View detailed information</a>

					<?php } elseif ( $si_assignment[0]['status'] == 1 ) { ?>

						<a href="<?php echo esc_url( $si_assignment[0]['url'] ); ?>"><?php echo esc_html( $si_assignment[0]['title'] ); ?></a>
										
					<?php } ?>

                </td>
			</tr>

		<?php } ?>
    </tbody>
</table>

<div class="pb-4">
	<?php include plugin_dir_path( __DIR__ ) . 'partials/fuel-footnotes.php'; ?>
</div>
