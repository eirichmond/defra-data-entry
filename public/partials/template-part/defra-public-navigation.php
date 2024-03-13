<div class="col-sm-2 bg-white">
    <nav id="site-navigation" class="main-navigation">

        <button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false"><?php esc_html_e( 'Primary Menu', 'bootstrap' ); ?></button>

        <?php wp_nav_menu(
            array(
                'theme_location' => 'menu-1',
                'menu_id'        => 'primary-menu',
            )
        ); ?>
    </nav><!-- #site-navigation -->
</div>
