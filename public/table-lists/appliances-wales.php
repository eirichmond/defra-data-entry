<?php
$public_class = new Defra_Data_Entry_Public('DEFRA_DATA_ENTRY_NAME', 'DEFRA_DATA_ENTRY_VERSION');
$args = array(
	'post_type' => 'appliances',
	'post_meta_key' => 'exempt-in_country_and_statutory_instrument_wales_enabled',
	'fuel_meta_key' => 'appliance_fuels_permitted_fuel_id',
	'manufacturer_meta_key' => 'manufacturer',
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
			$app_types = get_the_terms( $v->ID, 'appliance_types' );
			if($app_types) {
				$terms_string = join(', ', wp_list_pluck($app_types, 'name'));
			}
			
			?>
			<tr>
				<td style="width:30%"><?php echo esc_html( $v->post_title ); ?></td>
				<td style="width:30%"><?php echo esc_html( $v->manufacturer_name ); ?></td>
				<td style="width:20%"><?php echo get_the_title( $v->fuel_id ); ?></td>
				<td style="width:20%"><?php echo esc_html($terms_string); ?></td>
				<td style="width:20%"><a href="<?php echo esc_url( get_permalink($v) ); ?>">Veiw details information</a></td>
			</tr>

		<?php } ?>
    </tbody>
</table>

