<?php
class ACF_Config
{
    public function __construct()
    {
        // 0. Set up our custom option pages
        if( function_exists('acf_add_options_page') ) {
            $this->add_options_page();
        }

        // 1. Hide ACF field group menu item
        if( ! defined( 'WP_DEBUG' ) || WP_DEBUG == false ) {
            add_filter('acf/settings/show_admin', '__return_false');
        }

        // 2. Save ACF dynamically
        add_filter('acf/settings/save_json', [$this, 'set_acf_json_save_point']);

        // 3. Set ACF to load from JSON
        add_filter('acf/settings/load_json', [$this, 'set_acf_json_load_point']);
    }

    public function add_options_page()
    {
        acf_add_options_page([
            'page_title'    => 'Theme Settings',
            'menu_title'    => 'Theme Settings',
            'menu_slug'     => 'theme-settings',
            'capability'    => 'edit_posts',
            'redirect'      => false
        ]);
    }

    public function set_acf_json_save_point($path)
    {
        return get_template_directory() . '/inc/acf';
    }

    public function set_acf_json_load_point($paths)
    {
        // remove original path (optional)
        unset($paths[0]);

        // append path
        $paths[] = get_template_directory() . '/inc/acf';

        // return
        return $paths;
    }
}

new ACF_Config;