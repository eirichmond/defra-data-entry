<?php
$public_class = new Defra_Data_Entry_Public('DEFRA_DATA_ENTRY_NAME', 'DEFRA_DATA_ENTRY_VERSION');
$args = array(
	'post_type' => 'appliances',
	'post_meta_key' => 'exempt-in_country_and_statutory_instrument_england_status',
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
			<th>Permitted fuels</th>
			<th>Appliance Type</th>
			<th>Exemption Reference</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach($appliances as $k => $v) {
			$revoke_status_id = get_post_meta( $v->ID, 'exempt-in_country_and_statutory_instrument_england_revoke_status_id' );
			$app_types = get_the_terms( $v->ID, 'appliance_types' );
			$permitted_fuels = wp_get_post_terms( $v->ID, 'permitted_fuels' );
			if($app_types) {
				$terms_string = join(', ', wp_list_pluck($app_types, 'name'));
			}
			if($permitted_fuels) {
				$fuels_array = array();
				foreach ( $permitted_fuels as $permitted_fuel ) {
					$fuels_array[] = $permitted_fuel->description;
				}
				$permitted_fuels = join( ', ', $fuels_array  );
			}
			
			?>
		<tr>
			<td style="width:30%"><?php echo esc_html( $v->post_title ); ?></td>
			<td style="width:30%"><?php echo esc_html( $v->manufacturer_name ); ?></td>
			<td style="width:20%"><?php echo esc_html( $permitted_fuels ); ?></td>
			<td style="width:20%"><?php echo esc_html($terms_string); ?></td>
			<td style="width:20%">
				<?php if($revoke_status_id[0] == '400') { ?>
				No
				<?php } else { ?>
				<a href="<?php echo esc_url( get_permalink($v) ); ?>">View detailed information</a>
				<?php } ?>
			</td>
		</tr>

		<?php } ?>
	</tbody>
</table>

<div class="pb-4">
	<?php include plugin_dir_path( __DIR__ ) . 'partials/appliance-footnotes.php'; ?>
</div>
