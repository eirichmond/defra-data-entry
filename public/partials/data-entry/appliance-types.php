<?php 
$class = new Defra_Data_Entry_Public('DEFRA_DATA_ENTRY','DEFRA_DATA_ENTRY_VERSION');
$db = new Defra_Data_DB_Requests();
$list_appliance_types = $db->list_appliance_types();
get_header();

?>

<?php do_action('before_main_content'); ?>

	<h1 class="entry-title"><?php the_title(); ?></h1>

	<table id="table_id" class="display">
		<thead>
			<tr>
				<th>ID</th>
				<th>Appliance Type</th>
				<th>Actions</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach($list_appliance_types as $k => $v) { ?>
				<tr id="rendered-<?php echo esc_html( $v['appliance_type_id'] ); ?>">
					<td style="width:5%"><?php echo esc_html( $v['appliance_type_id'] ); ?></td>

					<td style="width:55%">
						<span id="output-<?php echo esc_html( $v['appliance_type_id'] ); ?>" class="appliance-type-name"><?php echo esc_html( $v['appliance_type_name'] ); ?></span>
						<input id="input-<?php echo esc_html( $v['appliance_type_id'] ); ?>" class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-purple-500 hide" type="text" value="<?php echo esc_html( $v['appliance_type_name'] ); ?>">
						
					</td>

					<td style="width:20%; text-align:right;">
				
				
						<ul class="icon-component list-unstyled">
							<li>
								<a class="edit" href="#" data-id="<?php echo esc_html( $v['appliance_type_id'] ); ?>"><i class="gg-pen"></i></a>
							</li>
							<li class="delete" data-id="<?php echo esc_html( $v['appliance_type_id'] ); ?>" data-type="defra_appliance_types" data-action="delete_appliance_type">
								<a href="#"><i class="gg-trash"></i></a>
							</li>
							<li id="save-<?php echo esc_html( $v['appliance_type_id'] ); ?>" class="save bg-green-500 rounded-md text-white hide" data-id="<?php echo esc_html( $v['appliance_type_id'] ); ?>" data-type="defra_appliance_types" data-action="update_appliance_type">
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