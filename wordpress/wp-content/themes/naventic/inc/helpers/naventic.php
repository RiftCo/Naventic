<?php
// Load config variables from Redux and ACF
function theme( $key, $child_key = false, $default = '', $post_id = false ) {

    if ( function_exists( 'get_field' ) ) {

        $var = ( is_numeric( $post_id ) || ( gettype( $post_id ) == 'object' && get_class( $post_id ) == 'WP_Term' ) ) ? get_field( $key, $post_id ) : get_field( $key );

        if ( ! $var ) {
            if ( function_exists( 'get_sub_field' ) ) {
                $var = ( is_numeric( $post_id ) || ( gettype( $post_id ) == 'object' && get_class( $post_id ) == 'WP_Term' ) ) ? get_sub_field( $key, $post_id ) : get_sub_field( $key );
            }
        }

        if ( $var ) {
            if ( $child_key ) {

                if ( is_array( $var ) && count( $var ) == 1 ) {
                    $var = reset( $var );
                }

                if( isset( $var[ $child_key ] ) ) {
                    return $var[ $child_key ];
                }

                return false;
            }

            return $var;
        }

        if ( $var = get_field( $key, 'option' ) ) {
            return $var;
        }
    }

    return $default;
}

// Load asset by path
function get_asset( $file, $type = 'images' ) {
    return get_template_directory_uri() . '/assets/' . $type . '/' . $file;
}

// Load Partials.
function partial( $partial, $vars = array() ) {
    if( $partial ) {
        if( $vars ) {
            extract( $vars );
        }

        $template = locate_template( '/inc/partials/' . $partial . '.php' );

        if( $template ) {
            include( $template );
        }
    }
}

// Load Blocks.
function get_page_structure( $field_name, $post_id = false ) {
    if ( have_rows( $field_name, $post_id ) ) {
        while ( have_rows( $field_name, $post_id ) ) {
            the_row();

            include( locate_template( '/inc/blocks/' . get_row_layout() . '.php' ) );
        }
    }
}

// Check if we are on a blog page
function is_blog() {
    global $post;
    $posttype = get_post_type( $post );

    return ( ( ( is_archive() ) || ( is_author() ) || ( is_category() ) || ( is_home() ) || ( is_single() ) || ( is_tag() ) ) && ( $posttype == 'post' ) ) ? true : false;
}

function get_top_parent_page_id() {

    global $post;

    $ancestors = $post->ancestors;

    // Check if page is a child page (any level)
    if ( $ancestors ) {

        //  Grab the ID of top-level page from the tree
        return end( $ancestors );

    } else {

        // Page is the top level, so use  it's own id
        return $post->ID;

    }

}

/**
 * Find url strings and username strings and make them link
 **/
if ( ! function_exists( 'parse_facebook' ) ):
    function parse_facebook( $text ) {
        // Shorten to an excerpt
        if ( strlen( $text ) > 140 ) {
            $text = substr( $text, 0, 140 ) . '..';
        }

        // Match URLs
        $text = preg_replace( '`\b(([\w-]+://?|www[.])[^\s()<>]+(?:\([\w\d]+\)|([^[:punct:]\s]|/)))`', '<a href="$0" target="_blank">$0</a>', $text );

        // Match #hashtag
        $text = preg_replace( '/(#)([a-zA-Z0-9\_]+)/', '<a href="https://www.facebook.com/hashtag/$2" target="_blank">#$2</a>', $text );

        return $text;
    }
endif;

function parse_tweet( $status_text ) {

    // linkify URLs
    $status_text = preg_replace(
        '/(https?:\/\/\S+)/',
        '<a href="\1" target="_blank">\1</a>',
        $status_text
    );

    // linkify twitter users
    $status_text = preg_replace(
        '/(^|\s)(\.?)@(\w+)/',
        '\1\2<a href="http://twitter.com/\3" target="_blank">@\3</a>',
        $status_text
    );

    // linkify tags
    $status_text = preg_replace(
        '/(^|\s)#(\w+)/',
        '\1<a href="http://twitter.com/search?q=%23\2" target="_blank">#\2</a>',
        $status_text
    );

    return $status_text;
}

function display_404() {
    status_header( 404 );
    nocache_headers();
    include( get_404_template() );
    exit;
}

function get_instagram( $user_id, $api_key, $count = 10 ) {
    if ( WP_DEBUG or false === ( $request = get_transient( 'instagram_feed_' . $user_id ) ) ) {
        // It wasn't there, so regenerate the data and save the transient
        // $request = file_get_contents( 'https://api.instagram.com/v1/users/285563651/media/recent?access_token=183019831.3a81a9f.c6dbc7e7bb804bd89df290eb4405097d&count=' . $count );
        // $request = file_get_contents( 'https://api.instagram.com/v1/users/' . $user_id . '/media/recent?access_token=' . $api_key . '&count=' . $count );
        $request = file_get_contents( 'https://www.instagram.com/' . $user_id . '/media/' );

        set_transient( 'instagram_feed_' . $user_id, $request );
    }

    // Ensure we have the request back
    if ( $request ) {
        // Make sure it's the correct JSON format
        if ( $request = json_decode( $request ) ) {
            // return $request->data;
            return array_slice( $request->items, 0, $count );
        }
    }

    return false;
}

function get_facebook( $limit = 3 ) {
    $version      = 'v2.3';
    $page_id      = theme( 'facebook_page_id' );
    $access_token = theme( 'facebook_access_token' );

    $url = 'https://graph.facebook.com/' . $version . '/' . $page_id . '/posts?fields=created_time,message,caption,full_picture,id,link&limit=' . $limit . '&access_token=' . $access_token;

    $results = file_get_contents( $url );

    if ( $results ) {
        if ( $results = json_decode( $results ) ) {
            return $results->data;
        }
    }

    return array();
}

function get_menu_active( $object_id ) {
    return ( $object_id == get_the_ID() ) ? 'active current_page_item' : '';
}

function get_pagination( $range = 2, $query = false ) {
    global $paged;

    $showitems = ($range * 2)+1;  
    
    if(empty($paged)) $paged = 1;

    if( ! $query ) {
        global $wp_query;

        $query = $wp_query;
    }   

    $pages = $query->max_num_pages;

    if( $pages != 1 ) {
        partial( 'pagination', array( 'paged' => $paged, 'pages' => $pages, 'range' => $range, 'showitems' => $showitems ) );
    }
}

// Helper function to get top level term ID
function top_level_term_id( $term_id, $taxonomy ) {
    // Be ready to store our top level ID
    $filter_parent = $term_id;

    // Find top level term
    $ancestors = get_ancestors( $term_id, 'product_category', 'taxonomy' );

    // If no ancestors, we're already at the top!
    if( $ancestors ) {
        $filter_parent = $ancestors[0];
    }

    return $filter_parent;
}

function timeago( $time ) {
    $periods = array(
        __( 'second', 'hallmark' ),
        __( 'minute', 'hallmark' ),
        __( 'hour', 'hallmark' ),
        __( 'day', 'hallmark' ),
        __( 'week', 'hallmark' ),
        __( 'month', 'hallmark' ),
        __( 'year', 'hallmark' ),
        __( 'decade', 'hallmark' ),
    );
    $lengths = array( "60", "60", "24", "7", "4.35", "12", "10" );

    $now = time();

    $difference = $now - $time;
    $tense      = "ago";

    for ( $j = 0; $difference >= $lengths[ $j ] && $j < count( $lengths ) - 1; $j ++ ) {
        $difference /= $lengths[ $j ];
    }

    $difference = round( $difference );

    if ( $difference != 1 ) {
        $periods = array(
            __( 'seconds', 'hallmark' ),
            __( 'minutes', 'hallmark' ),
            __( 'hours', 'hallmark' ),
            __( 'days', 'hallmark' ),
            __( 'weeks', 'hallmark' ),
            __( 'months', 'hallmark' ),
            __( 'years', 'hallmark' ),
            __( 'decades', 'hallmark' ),
        );
    }

    return $difference . " " . $periods[ $j ] . " " . __( 'ago', 'hallmark' );
}

// Trigger our Twitch API
function twitch_api() {
    return new \TwitchApi\TwitchApi([
        'client_id' => 'e6ik3fi0szie1ynidj1cx6jn9kwds1',
        'api_version' => 5,
    ]);
}

// Set up filter links
function filter_link( $key, $value, $single = false ) {
    // Prefill our filter if none are set
    if( ! isset( $_GET['filter'] ) ) {
        $_GET['filter'] = [ 'post', 'event', 'video' ];
    }

    // Cache our $_GET values so that we aren't updating the global
    $get = $_GET;

    // Check if our field is currently active
    $current = filter_link_class($key, $value);

    if( $current && ! $single ) {
        foreach( $get[$key] as $i => $filter ) {
            if( $filter == $value ) {
                unset( $get[$key][$i] );
            }
        }
    } else {
        if( $single ) {
            $get[$key] = $value;
        } else {
            $get[$key][] = $value;
        }
    }

    // Build our query
    return '?' . urldecode(http_build_query($get));
}

function filter_link_class( $key, $value ) {
    // Our active class
    $active_class = 'active';

    // Check if our GET variable is set
    if( ! isset( $_GET[$key] ) ) {
        return '';
    }

    // If the filter is an array, check the values
    if( is_array( $_GET[$key] ) && ! in_array( $value, $_GET[$key] ) ) {
        return '';
    }

    // If the filter is a string, check the value
    if( ! is_array( $_GET[$key] ) && $_GET[$key] != $value ) {
        return '';
    }

    return $active_class;
}
