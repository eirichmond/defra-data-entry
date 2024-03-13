<?php get_header(); ?>

    <?php do_action('before_main_content'); ?>

    <div class="alert alert-danger" role="alert">
        Unauthorised, you need to login to view this page!
    </div>

    
    <?php do_action('after_main_content'); ?>

<?php get_footer(); ?>