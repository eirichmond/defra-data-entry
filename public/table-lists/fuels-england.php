<?php
$public_class = new Defra_Data_Entry_Public('DEFRA_DATA_ENTRY_NAME', 'DEFRA_DATA_ENTRY_VERSION');
$args = array(
	'post_type' => 'fuels',
	// 'post_meta_key' => 'exempt-in_country_and_statutory_instrument_england_enabled',
	'post_meta_key' => 'authorised_country_and_statutory_instrument_england_status',
	'fuel_meta_key' => 'fuel_id',
	'manufacturer_meta_key' => 'manufacturer_id',
	'countries' => array(
		'england' => 'England'
	)
);
$fuels = $public_class->get_table_list($args);

?>

<?php include(plugin_dir_path(__FILE__) . 'fuels-table.php'); ?>

