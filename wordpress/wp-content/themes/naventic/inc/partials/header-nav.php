<nav>
    <a class="logo" href="<?php echo site_url(); ?>" title="Naventic">
        <img src="<?php echo get_asset( 'logo.svg' ); ?>" width="185" height="60" alt="Naventic" />
    </a>

    <?php wp_nav_menu([ 'theme_location' => 'main_nav', 'menu_class' => 'menu', 'container' => 'ul' ]); ?>
</nav>