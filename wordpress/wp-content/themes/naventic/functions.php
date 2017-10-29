<?php
/**
 *  Naventic.
 *
 *  Set up the theme and provides some helper functions, which are used in the
 *  theme as custom template tags. Others are attached to action and filter
 *  hooks in WordPress to change core functionality.
 *
 *  Documentation standards:
 *  https://make.wordpress.org/core/handbook/best-practices/inline-documentation-standards/php/
 *
 *  @package    WordPress
 *  @subpackage naventic
 *  @since      1.0.6
 */


/**
 *  ❤ Autoloading
 *
 *  @since 1.0.1
 */

require_once get_template_directory() . '/vendor/autoload.php';


/**
 *  Load our ACF configuration information.
 *
 *  This is required to set up ACF Local JSON.
 *
 *  @since 1.0.1
 */

require_once get_template_directory() . '/inc/acf/config.php';


/**
 *  Register our custom post types.
 *
 *  Some additional functionality relating to post type creation, for example
 *  WP column alterations and meta registration may also be contained within
 *  the relevant post type file.
 *
 *  @since 1.0.1
 */

require_once get_template_directory() . '/inc/post-types/event.php';
require_once get_template_directory() . '/inc/post-types/player.php';
require_once get_template_directory() . '/inc/post-types/product.php';
require_once get_template_directory() . '/inc/post-types/sponsor.php';
require_once get_template_directory() . '/inc/post-types/team.php';
require_once get_template_directory() . '/inc/post-types/video.php';


/**
 *  Register our custom taxonomies.
 *
 *  @since 1.0.1
 */

require_once get_template_directory() . '/inc/taxonomies/game.php';


/**
 *  Load our custom helper functions.
 *
 *  @since 1.0.1
 */

require_once get_template_directory() . '/inc/helpers/naventic.php';


/**
 *  Load our custom menu walker.
 *
 *  @since 1.0.1
 */

// require_once get_template_directory() . '/inc/walkers/wp_bootstrap_navwalker.php';


/**
 *  Load our libraries for additional functionality.
 *
 *  @since 1.0.2
 */

require_once get_template_directory() . '/inc/libraries/disable-wp-json-api.php';

if( ! defined( 'WP_DEBUG' ) || ! WP_DEBUG ) {
    require_once get_template_directory() . '/inc/libraries/disable-wordpress-updates.php';
}


/**
 *  Core theme class.
 *
 *  Sets up WordPress hooks for actions and filters that are used in the theme.
 *
 *  @since 1.0.1
 */

class Naventic {

    /**
     *  Construct method to house all WordPress action and filter hooks.
     *
     *  @since 1.0.1
     *  @access public
     */

    public function __construct() {

        /**
         *  Remove unused widgets to speed up the platform.
         *
         *  @since 1.0.1
         */

        add_action( 'widgets_init', [ $this, 'unregister_default_widgets' ], 8 );


        /**
         *  Set up images sizes, register nav menus and other small updates.
         *
         *  @since 1.0.1
         */

        add_action( 'after_setup_theme', [ $this, 'naventic_global_setup' ] );


        /**
         *  Register internal and external javascript.
         *
         *  @since 1.0.1
         */

        add_action( 'wp_enqueue_scripts', [ $this, 'naventic_global_scripts' ] );


        /**
         *  Disable Emojis to speed up website and because they are lame.
         *
         *  @since 1.0.1
         */

        remove_action( 'admin_print_styles', 'print_emoji_styles' );
        remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
        remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
        remove_action( 'wp_print_styles', 'print_emoji_styles' );
        remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
        remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
        remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
        add_filter( 'tiny_mce_plugins', [ $this, 'disable_emojicons_tinymce' ] );


        /**
         *  Create a nicer search results URL in the format '/search/[term]'
         *
         *  @since 1.0.1
         */

        add_action( 'template_redirect', [ $this, 'cws_nice_search_redirect' ] );


        /**
         *  Allow for SVGs to be uploaded to the media library.
         *
         *  @since 1.0.1
         */

        add_filter( 'upload_mimes', [ $this, 'cc_mime_types' ] );


        /**
         *  Since WP 4.7.1 we need additional functionality to allow for SVGs to be uploaded.
         *
         *  @since 1.0.3
         */

        // add_filter( 'wp_check_filetype_and_ext', [ $this, 'cc_mime_types_extra' ], 10, 3 );

        
        /**
         *  Add login page styling for the admin area.
         *
         *  @since 1.0.1
         */

        add_action( 'login_enqueue_scripts', [ $this, 'naventic_login_logo' ] );


        /**
         *  Add customer class to wp_nav links.
         * 
         *  @since 1.0.1
         */

        add_filter( 'nav_menu_link_attributes', [ $this, 'custom_menu_classes' ], 10, 4 );


        /**
         *  Add post types to the main page archive.
         * 
         *  @since 1.0.1
         */

        add_filter( 'pre_get_posts', [ $this, 'naventic_add_custom_types' ] );

    }


    /**
     *  Unregister all widgets we dont need
     *
     *  @since 1.0.1
     *  @access public
     */

    public function unregister_default_widgets() {
        unregister_widget( 'WP_Widget_Calendar' );
        unregister_widget( 'WP_Widget_Recent_Comments' );
        unregister_widget( 'WP_Widget_Search' );
        unregister_widget( 'WP_Widget_Archives' );
        unregister_widget( 'WP_Widget_Meta' );
        unregister_widget( 'WP_Widget_Categories' );
        unregister_widget( 'WP_Widget_Tag_Cloud' );
        unregister_widget( 'WP_Widget_RSS' );
        unregister_widget( 'WP_Widget_Recent_Posts' );
        unregister_widget( 'WP_Widget_Pages' );
    }


    /**
     *  Set up the theme information.
     * 
     *  This assigns image sizes, registers nav menus and enables HTML5 components.
     * 
     *  @since 1.0.1
     *  @access public
     */

    public function naventic_global_setup() {
        // If we are lazy loading, trigger the ob_start method
        if ( function_exists( 'lazyload_images_add_placeholders' ) ) {
            ob_start( 'lazyload_images_add_placeholders' );
        }

        // Enable support for Post Thumbnails, and declare two sizes.
        add_theme_support( 'post-thumbnails' );
        set_post_thumbnail_size( 400, 400, true );

        // Set up misc. image sizes
        add_image_size( 'cta-page_link', 155, 110, true );

        // Add RSS feed links to <head> for posts and comments.
        add_theme_support( 'automatic-feed-links' );

        // This theme uses wp_nav_menu().
        register_nav_menus([
            // Main navigation
            'main_nav' => __( 'Main Menu', 'naventic' ),

            // Footer navigation
            'footer_nav' => __( 'Footer Navigation', 'naventic' ),
        ]);

        // Switch default core markup for search form, comment form, and comments to output valid HTML5.
        add_theme_support( 'html5', ['search-form', 'comment-form', 'comment-list', 'gallery', 'caption' ]);

        // Remove some of the default WordPress meta tags
        remove_action( 'wp_head', 'wp_generator' );
    }


    /**
     *  Enqueue scripts and styles for the front end.
     * 
     *  @since 1.0.1
     *  @access public
     */

    public function naventic_global_scripts() {

        // Load our CSS
        wp_enqueue_style( 'naventic-inline', get_template_directory_uri() . '/assets/css/inline.css', [], '1.0.1' );
        wp_enqueue_style( 'naventic-base', get_template_directory_uri() . '/assets/css/style.css', [ 'naventic-inline' ], '1.0.1' );
        wp_enqueue_style( 'naventic-blame', get_template_directory_uri() . '/assets/css/blame.css', [ 'naventic-base' ], '1.0.1' );

        // Load the Internet Explorer specific stylesheet.
        // wp_enqueue_style( 'ie', get_template_directory_uri() . '/assets/css/ie.css' );
        // wp_style_add_data( 'ie', 'conditional', 'lt IE 9' );

        // Load our JS
        wp_deregister_script( 'jquery' );
        wp_enqueue_script( 'jquery', '//code.jquery.com/jquery-3.1.1.min.js', array(), '3.1.1', true );
        
        wp_enqueue_script( 'naventic-bundle', get_template_directory_uri() . '/assets/js/app.js', array(), '1.0.1', true );
    }


    /**
     *  Remove the emoji plugin from the WordPress installation.
     * 
     *  @param array $plugins List of currently enabled plugins.
     * 
     *  @return array Updated list of plugins.
     * 
     *  @since 1.0.1
     *  @access public
     */

    public function disable_emojicons_tinymce( $plugins ) {
        if ( is_array( $plugins ) ) {
            return array_diff( $plugins, array( 'wpemoji' ) );
        } else {
            return array();
        }
    }


    /**
     *  Update styling on the login page.
     * 
     *  @since 1.0.1
     *  @access public
     */

    public function naventic_login_logo() { ?>
        <style type="text/css">
            #login h1 a, .login h1 a {
                background-image: url(<?php echo get_asset( 'admin-logo.png' ); ?>);
                background-size: 100%;
                height: 100px;
                width: 100%;
            }
        </style>
    <?php }


    /**
     *  Add SVG to the valid upload mime types.
     * 
     *  @param array $mimes Existing valid mime types.
     * 
     *  @return array Updated array of valid mime types.
     * 
     *  @since 1.0.1
     *  @access public
     */

    public function cc_mime_types( $mimes ) {
      $mimes['svg'] = 'image/svg+xml';

      return $mimes;
    }


    /**
     *  Add SVG to the valid upload mime types on WP 4.7.1+.
     * 
     *  @param array  $data     File data array containing 'ext', 'type', and 'proper_filename' keys.
     *  @param string $file     Full path to the file.
     *  @param string $filename The name of the file (may differ from $file due to $file being in a tmp directory).
     *  @param array  $mimes    Key is the file extension with value as the mime type.
     * 
     *  @return array Updated array of valid mime types.
     * 
     *  @since 1.0.3
     *  @access public
     */

    public function cc_mime_types_extra( $data, $file, $filename, $mimes ) {
        global $wp_version;

        // Validate our WordPress version against
        // We check that it's either 4.7 or less than 4.7.x
        if( $wp_version == '4.7' || ( (float) $wp_version < 4.7 ) ) {
            return $data;
        }

        $filetype = wp_check_filetype( $filename, $mimes );

        return array(
            'ext'             => $filetype['ext'],
            'type'            => $filetype['type'],
            'proper_filename' => $data['proper_filename']
        );
    }


    /**
     *  Update the search results URL structure to make it prettier.
     * 
     *  @since 1.0.1
     *  @access public
     */

    public function cws_nice_search_redirect() {
        global $wp_rewrite;

        if ( !isset( $wp_rewrite ) || !is_object( $wp_rewrite ) || !$wp_rewrite->using_permalinks() ) {
            return;
        }

        $search_base = $wp_rewrite->search_base;

        if ( is_search() && !is_admin() && strpos( $_SERVER['REQUEST_URI'], "/{$search_base}/" ) === false ) {
            wp_redirect( home_url( "/{$search_base}/" . urlencode( get_query_var( 's' ) ) ) );
            exit();
        }
    }


    /**
     * Filters the HTML attributes applied to a menu item's anchor element.
     *
     * @since 3.6.0
     * @since 4.1.0 The `$depth` parameter was added.
     *
     * @param array $atts {
     *     The HTML attributes applied to the menu item's `<a>` element, empty strings are ignored.
     *
     *     @type string $title  Title attribute.
     *     @type string $target Target attribute.
     *     @type string $rel    The rel attribute.
     *     @type string $href   The href attribute.
     * }
     * @param WP_Post  $item  The current menu item.
     * @param stdClass $args  An object of wp_nav_menu() arguments.
     * @param int      $depth Depth of menu item. Used for padding.
     */

    public function custom_menu_classes( $atts, $item, $args, $depth ) {
        $atts['class'] = 'nav-item';
    
        return $atts;
    }


    /**
     *  Add post types to main page archive and add optional game filter.
     * 
     *  @param WP_Query $query
     *  
     *  @return WP_Query $query Updated WP_Query
     * 
     *  @since 1.0.1
     *  @access public
     */

    public function naventic_add_custom_types( $query ) {
        if( ( is_home() || is_category() || is_tag() ) && $query->is_main_query() && empty( $query->query_vars['suppress_filters'] ) ) {
            // Filter our results by post type
            if( isset( $_GET['filter'] ) ) {
                // If we have a filter set then show those specific post types only
                $query->set( 'post_type', (array) $_GET['filter'] );
            } else {
                // If we don't have any filters set then show all post types
                $query->set( 'post_type', [ 'post', 'event', 'video' ]);
            }

            // Check if we are filtering by game
            if( isset( $_GET['game'] ) ) {
                $query->set( 'tax_query', [
                    'relation' => 'AND',
                    [
                        'taxonomy' => 'game',
                        'field'    => 'slug',
                        'terms'    => $_GET['game'],
                        'compare'  => 'IN',
                    ]
                ]);
            }
            
            return $query;
        }
    }
}

// Ok. - Rammus 2017
new Naventic;