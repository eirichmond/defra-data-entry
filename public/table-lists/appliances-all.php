<?php
$public_class = new Defra_Data_Entry_Public('DEFRA_DATA_ENTRY_NAME', 'DEFRA_DATA_ENTRY_VERSION');
$args = array(
	'post_type' => 'appliances',
	'post_meta_key' => array(
		'exempt-in_country_and_statutory_instrument_england_status',
		'exempt-in_country_and_statutory_instrument_wales_status',
		'exempt-in_country_and_statutory_instrument_scotland_status',
		'exempt-in_country_and_statutory_instrument_n_ireland_status'
	),
	'fuel_meta_key' => 'appliance_fuels_permitted_fuel_id',
	'manufacturer_meta_key' => 'manufacturer_id',
);
$appliances = $public_class->get_table_list($args);

?>

<table id="table_id" class="display">
    <thead>
        <tr>
            <th>Appliance name</th>
            <th>Manufacturer</th>
            <th>England</th>
            <th>Wales</th>
            <th>Scotland</th>
            <th>Northern Ireland</th>
        </tr>
    </thead>
    <tbody>
		<?php foreach($appliances as $k => $v) {
			$app_types = get_the_terms( $v->ID, 'appliance_types' );
			if($app_types) {
				$terms_string = join(', ', wp_list_pluck($app_types, 'name'));
			}
			
			?>
			<tr>
				<td style="width:30%"><?php echo esc_html( $v->post_title ); ?></td>
				<td style="width:30%"><?php echo esc_html( $v->manufacturer_name ); ?></td>
				<td style="width:20%">
				
					<?php $si_assignment = $public_class->statutory_instrument_assignment( $v->ID, 'england', 'appliance' ); 

					if( $si_assignment[0]['publish_status'] != '600' ) { ?>
						<span>No</span>
					<?php } elseif ( $si_assignment[0]['status'] == 0 ) { ?>

						<a href="<?php echo esc_url( get_permalink($v) ); ?>">View detailed information</a>

					<?php } elseif ( $si_assignment[0]['status'] == 1 ) { ?>

						<a href="<?php echo esc_url( $si_assignment[0]['url'] ); ?>"><?php echo esc_html( $si_assignment[0]['title'] ); ?></a>
										
					<?php } ?>

				
				</td>
				<td style="width:20%">
				
					<?php
					$si_assignment = $public_class->statutory_instrument_assignment( $v->ID, 'wales', 'appliance'  ); 
					if( $si_assignment[0]['publish_status'] != '600' ) { ?>
						<span>No</span>
					<?php } elseif ( $si_assignment[0]['status'] == 0 ) { ?>

						<a href="<?php echo esc_url( get_permalink($v) ); ?>">View detailed information</a>

					<?php } elseif ( $si_assignment[0]['status'] == 1 ) { ?>

						<a href="<?php echo esc_url( $si_assignment[0]['url'] ); ?>"><?php echo esc_html( $si_assignment[0]['title'] ); ?></a>
										
					<?php } ?>

				</td>
				<td style="width:20%">
				
					<?php
					$si_assignment = $public_class->statutory_instrument_assignment( $v->ID, 'scotland', 'appliance'  ); 
					if( $si_assignment[0]['publish_status'] != '600' )  { ?>
						<span>No</span>
					<?php } elseif ( $si_assignment[0]['status'] == 0 ) { ?>

						<a href="<?php echo esc_url( get_permalink($v) ); ?>">View detailed information</a>

					<?php } elseif ( $si_assignment[0]['status'] == 1 ) { ?>

						<a href="<?php echo esc_url( $si_assignment[0]['url'] ); ?>"><?php echo esc_html( $si_assignment[0]['title'] ); ?></a>
										
					<?php } ?>


				</td>

				<td style="width:20%">
			
					<?php
					$si_assignment = $public_class->statutory_instrument_assignment( $v->ID, 'n_ireland', 'appliance'  ); 
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
	<?php include plugin_dir_path( __DIR__ ) . 'partials/appliance-footnotes.php'; ?>
</div>
