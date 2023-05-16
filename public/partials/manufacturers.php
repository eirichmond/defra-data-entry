<?php 
$class = new Defra_Data_Entry_Public('DEFRA_DATA_ENTRY','DEFRA_DATA_ENTRY_VERSION');
$class->defra_get_header('data-entry');
$db = new Defra_Data_DB_Requests();
$list_manufacturers = $db->list_manufacturers();

?>

<?php do_action('before_main_content'); ?>

<h1 class="entry-title"><?php the_title(); ?></h1>

<table id="table_id" class="display">
    <thead>
        <tr>
            <th>ID</th>
            <th>Manufacturer Name</th>
            <th>Address</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
		<?php foreach($list_manufacturers as $k => $v) { ?>
			<tr id="rendered-<?php echo esc_html( $v['manufacturer_id'] ); ?>">

				<td style="width:5%"><?php echo esc_html( $v['manufacturer_id'] ); ?></td>

				<td style="width:55%">

					<span id="output-<?php echo esc_html( $v['manufacturer_id'] ); ?>" class="manufacturer-name"><?php echo esc_html( $v['manufacturer_name'] ); ?></span>

				</td>

				<td style="width:20%">

					<?php echo esc_html( $v['manufacturer_address'] ); ?>

				</td>

				<td style="width:20%; text-align:right;">
				
					<?php echo esc_html( $v['manufacturer_action'] ); ?>
				
				
					<ul class="icon-component">
						<li>
							<a class="edit" href="#" data-id="<?php echo esc_html( $v['manufacturer_id'] ); ?>"><i class="gg-pen"></i></a>
						</li>
						<li class="delete" data-id="<?php echo esc_html( $v['manufacturer_id'] ); ?>" data-type="defra_defra_manufacturers" data-action="delete_defra_manufacturer">
							<a href="#"><i class="gg-trash"></i></a>
						</li>
					</ul>

				
				</td>

			</tr>

		<?php } ?>
    </tbody>
</table>


<?php do_action('after_main_content'); ?>


<?php get_footer(); ?>