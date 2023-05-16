<?php 
$class = new Defra_Data_Entry_Public('DEFRA_DATA_ENTRY','DEFRA_DATA_ENTRY_VERSION');
$class->defra_get_header('data-entry');
$db = new Defra_Data_DB_Requests();
$list_appliance_sis = $db->list_appliance_sis();
?>

<?php do_action('before_main_content'); ?>

<h1 class="entry-title"><?php the_title(); ?></h1>

<table id="table_id" class="display">
    <thead>
        <tr>
            <th>ID</th>
            <th>Number</th>
            <th>Link</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
		<?php foreach($list_appliance_sis as $k => $v) { ?>
			<tr>
				<td style="width:5%"><?php echo esc_html( $v['appliance_si_id'] ); ?></td>
				<td style="width:55%"><?php echo esc_html( $v['appliance_si_number'] ); ?></td>
				<td style="width:55%"><?php echo esc_html( $v['appliance_si_link'] ); ?></td>
				<td style="width:20%; text-align:right;">??</td>

			</tr>

		<?php } ?>
    </tbody>
</table>


<?php do_action('after_main_content'); ?>


<?php get_footer(); ?>