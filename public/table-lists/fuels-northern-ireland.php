<?php
$public_class = new Defra_Data_Entry_Public('DEFRA_DATA_ENTRY_NAME', 'DEFRA_DATA_ENTRY_VERSION');
$args = array(
	'post_type' => 'fuels',
	'post_meta_key' => 'exempt-in_country_and_statutory_instrument_n_ireland_enabled',
	'fuel_meta_key' => 'fuel_id',
	'manufacturer_meta_key' => 'manufacturer',
);
$fuels = $public_class->get_table_list($args);

?>

<table id="table_id" class="display">
    <thead>
        <tr>
            <th>Fuel ID</th>
            <th>Fuel</th>
            <th>Manufacturer</th>
            <th>Exemption Reference</th>
        </tr>
    </thead>
    <tbody>
		<?php foreach($fuels as $k => $v) { ?>
			<tr>
				<td style="width:5%"><?php echo esc_html( $v->fuel_id ); ?></td>
				<td style="width:25%"><?php echo esc_html( $v->post_title ); ?></td>
				<td style="width:60%"><?php echo esc_html( $v->manufacturer_name ); ?></td>
				<td style="width:10%"><a href="<?php echo esc_url( get_permalink($v) ); ?>">Veiw details information</a></td>
			</tr>

		<?php } ?>
    </tbody>
</table>

