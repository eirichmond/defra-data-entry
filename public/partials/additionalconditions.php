<?php 
$class = new Defra_Data_Entry_Public('DEFRA_DATA_ENTRY','DEFRA_DATA_ENTRY_VERSION');
$class->defra_get_header('data-entry');
$db = new Defra_Data_DB_Requests();
$list_additional_conditions = $db->list_additional_conditions();

?>

<?php do_action('before_main_content'); ?>

<h1 class="entry-title"><?php the_title(); ?></h1>

<table id="table_id" class="display">
    <thead>
        <tr>
            <th>ID</th>
            <th>Additional Condition</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
		<?php foreach($list_additional_conditions as $k => $v) { ?>
			<tr id="rendered-<?php echo esc_html( $v['additional_condition_id'] ); ?>">
				<td style="width:5%"><?php echo esc_html( $v['additional_condition_id'] ); ?></td>
				<td style="width:55%">
					<span id="output-<?php echo esc_html( $v['additional_condition_id'] ); ?>" class="appliance-type-name"><?php echo esc_html( $v['additional_condition_name'] ); ?></span>
					<input id="input-<?php echo esc_html( $v['additional_condition_id'] ); ?>" class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-purple-500 hide" type="text" value="<?php echo esc_html( $v['additional_condition_name'] ); ?>">
				</td>
				<td style="width:20%; text-align:right;">
			
					<ul class="icon-component">
						<li>
							<a class="edit" href="#" data-id="<?php echo esc_html( $v['additional_condition_id'] ); ?>"><i class="gg-pen"></i></a>
						</li>
						<li class="delete" data-id="<?php echo esc_html( $v['additional_condition_id'] ); ?>" data-type="defra_additional_conditions" data-action="delete_additional_condition">
							<a href="#"><i class="gg-trash"></i></a>
						</li>
						<li id="save-<?php echo esc_html( $v['additional_condition_id'] ); ?>" class="save bg-green-500 rounded-md text-white hide" data-id="<?php echo esc_html( $v['additional_condition_id'] ); ?>" data-type="defra_additional_conditions" data-action="update_additional_condition">
							<a href="#"><i class="gg-arrow-down"></i></a>
						</li>
					</ul>


				</td>

			</tr>

		<?php } ?>
    </tbody>
</table>


<?php do_action('after_main_content'); ?>


<?php get_footer(); ?>