    <footer>
        <div class="logo">
            <span href="#top">
                <img src="<?php echo get_asset( 'logo-icon.svg' ); ?>" alt="Naventic" width="50.6" height="60"/>
            </span>
        </div>

        <section class="sponsorContainer">
            <?php partial( 'sponsors' ); ?>
        </section>

        <div class="row">
            <div class="col c8">
                <p>&copy; 2017 <span>Naventic</span>. All Rights Reserved.</p>

                <h6 class="credit">Website by <a href="//digitalrift.co" title="Website by Digital Rift" target="_blank">Digital Rift</a>.</h6>
            </div>

            <?php wp_nav_menu( array( 'theme_location' => 'footer_nav', 'menu_class' => 'col c4 footerLinks', 'container' => 'ul' ) ); ?>
        </div>
    
        <div class="legal"></div>

    </footer>

    <?php if( $background = theme( 'background_image' ) ) { ?>
        <style>
        header::after {
            background-image: url(<?php echo $background; ?>) !important;
        }
        </style>
    <?php } ?>

    <?php echo theme( 'tracking_code' ); ?>

    <?php wp_footer(); ?>
</body>
</html>