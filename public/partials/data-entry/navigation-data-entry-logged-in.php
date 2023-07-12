<div class="bg-light mt-3">
    <div class="container-sm">
        <?php wp_nav_menu(
            array(
            'theme_location' => 'data-entry',
            'menu_id'        => 'navbarSupportedContent',
            'menu_class' => 'navbar-nav me-auto mb-2 mb-lg-0 collapse navbar-collapse',
            'container' => 'nav',
            'container_class' => 'navbar navbar-expand-lg bg-body-tertiary',
            'depth' => 10,
            'walker' => new WP_Bootstrap_Nav_Walker()
            )
        ); ?>
    </div>
</div>