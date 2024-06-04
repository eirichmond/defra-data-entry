<?php 
$class = new Defra_Data_Entry_Public('DEFRA_DATA_ENTRY','DEFRA_DATA_ENTRY_VERSION');
$list_fuel_sis = $class->get_list_sis_by_term( 'fuel' );

get_header();
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
            <?php foreach($list_fuel_sis as $k => $v) { ?>
                <tr>
                    <td style="width:5%"><?php echo esc_html( $v['id'] ); ?></td>
                    <td style="width:55%"><?php echo esc_html( $v['number'] ); ?></td>
                    <td style="width:55%"><?php echo esc_html( $v['link'] ); ?></td>
                    <td style="width:20%; text-align:right;"><?php echo edit_post_link( 'Edit', '', '', $k );?></td>

                </tr>

            <?php } ?>
        </tbody>
    </table>


<?php do_action('after_main_content'); ?>


<?php get_footer(); ?>