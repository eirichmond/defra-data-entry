<tr>
    <td style="width:5%"><?php echo get_post_meta(get_the_ID(), 'appliance_id', true ); ?></td>
    <td style="width:20%"><?php the_title(); ?></td>
    <td style="width:30%">
        <strong>England:</strong> <?php echo esc_html($class->si_status(get_post_meta(get_the_ID(), 'exempt-in_country_and_statutory_instrument_england_status', true))); ?><br>
        <strong>Wales:</strong> <?php echo esc_html($class->si_status(get_post_meta(get_the_ID(), 'exempt-in_country_and_statutory_instrument_wales_status', true))); ?><br>
        <strong>Scotland:</strong> <?php echo esc_html($class->si_status(get_post_meta(get_the_ID(), 'exempt-in_country_and_statutory_instrument_scotland_status', true))); ?><br>
        <strong>N. Ireland:</strong> <?php echo esc_html($class->si_status(get_post_meta(get_the_ID(), 'exempt-in_country_and_statutory_instrument_n_ireland_status', true))); ?>
    </td>
    <td style="width:30%">
        <?php if(get_post_meta(get_the_ID(), 'entry_user_id', true )) { ?>
            <strong>Entry User</strong><br>
            <?php echo $class->data_entry_username(get_post_meta(get_the_ID(), 'entry_user_id', true )); ?><br>
        <?php } ?>

        <?php if(get_post_meta(get_the_ID(), 'reviewer_user_id', true )) { ?>
            <strong>Reviewer User</strong><br>
            <?php echo $class->data_entry_username(get_post_meta(get_the_ID(), 'reviewer_user_id', true )); ?>
        <?php } ?>
    </td>
    <td style="width:15%">
    <form action="/data-entry/form-process/" method="post">
        <ul class="list-unstyled icon-component">
            <li>
                <?php echo do_action('defra_view_assign_link'); ?>
            </li>
            <li>
                <button type="submit"><i class="gg-file-document"></i></button>
            </li>
            <li>
                <a href="<?php echo esc_html( '/appliance-audit-log/?appliance='.get_the_ID() ); ?>"><i class="gg-folder"></i></a>
            </li>
            <li>
                <a href="<?php echo esc_html( '/appliance-change-log/?appliance='.get_the_ID() ); ?>"><i class="gg-attribution"></i></a>
            </li>
        </ul>
        <input type="hidden" name="type" value="appliances">
        <input type="hidden" name="id" value="<?php echo esc_html( get_the_ID() ); ?>">
        <input type="hidden" name="process" value="download-recommendation-letter" />
    </form>
    </td>
</tr>
