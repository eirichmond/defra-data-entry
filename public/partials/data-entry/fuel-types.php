<?php 
$class = new Defra_Data_Entry_Public('DEFRA_DATA_ENTRY','DEFRA_DATA_ENTRY_VERSION');
$list_fuel_types = $class->defra_get_terms('fuel_types');
get_header();

?>

<?php do_action('before_main_content'); ?>

	<h1 class="entry-title"><?php the_title(); ?></h1>

	<table id="table_id" class="display">
		<thead>
			<tr>
				<th>ID</th>
				<th>Fuel Type</th>
				<th>Actions</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach($list_fuel_types as $k => $v) { ?>
				<tr id="rendered-<?php echo esc_html( $v->term_id ); ?>">
					<td style="width:5%"><?php echo esc_html( $v->term_id ); ?></td>
					<td style="width:55%">
						<span id="output-<?php echo esc_html( $v->term_id ); ?>" class="fuel-type-name"><?php echo esc_html( $v->name ); ?></span>
						<input id="input-<?php echo esc_html( $v->term_id ); ?>" class="hide" type="text" value="<?php echo esc_html( $v->name ); ?>">
						
					</td>
					<td style="width:20%; text-align:right;">
						<ul class="icon-component list-unstyled">
							<li>
								<a class="edit" href="#" data-id="<?php echo esc_html( $v->term_id ); ?>"><i class="gg-pen"></i></a>
							</li>
							<li class="delete" data-id="<?php echo esc_html( $v->term_id ); ?>" data-type="defra_fuel_types" data-action="delete_fuel_type">
								<a href="#"><i class="gg-trash"></i></a>
							</li>
							<li id="save-<?php echo esc_html( $v->term_id ); ?>" class="save hide" data-id="<?php echo esc_html( $v->term_id ); ?>" data-type="defra_fuel_types" data-action="update_fuel_type">
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