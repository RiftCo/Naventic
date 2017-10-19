<?php
class Naventic_Player
{
	// Register our post type slug
	private $post_type = 'player';

	// Set our translation family
	private $translation = 'naventic';

	// Set our singular and plural terminology
	private $singular = 'Player';
	private $plural = 'Players';

	public function __construct() {
        /**
         *  Register the post type.
         *
         *  @since 1.0.1
         */

		add_action( 'init', [ $this, 'register_post_type' ], 0 );

        /**
         *  Get Twitch User ID on save.
         *
         *  These hooks will convert address information to lat/lng co-ordinates
         *  programatically to ensure that we can plot them onto maps.
         *
         *  @since 1.0.1
         */

		add_action( 'save_post', [ $this, 'get_twitch_user_id' ], 10, 2 );
	}

	public function register_post_type() {
		$labels = array(
			'name'                => _x( $this->plural, 'Post Type General Name', $this->translation ),
			'singular_name'       => _x( $this->singular, 'Post Type Singular Name', $this->translation ),
			'menu_name'           => __( $this->plural, $this->translation ),
			'name_admin_bar'      => __( $this->plural, $this->translation ),
			'parent_item_colon'   => __( 'Parent ' . $this->plural . ':', $this->translation ),
			'all_items'           => __( 'All ' . $this->plural, $this->translation ),
			'add_new_item'        => __( 'Add New ' . $this->singular, $this->translation ),
			'add_new'             => __( 'Add New', $this->translation ),
			'new_item'            => __( 'New ' . $this->singular, $this->translation ),
			'edit_item'           => __( 'Edit ' . $this->singular, $this->translation ),
			'update_item'         => __( 'Update ' . $this->singular, $this->translation ),
			'view_item'           => __( 'View ' . $this->singular, $this->translation ),
			'search_items'        => __( 'Search ' . $this->plural, $this->translation ),
			'not_found'           => __( 'Not found', $this->translation ),
			'not_found_in_trash'  => __( 'Not found in Trash', $this->translation ),
		);
		
		$args = array(
			'label'               => __( $this->post_type, $this->translation ),
			'description'         => __( $this->plural, $this->translation ),
			'labels'              => $labels,
			'supports'            => [ 'title', 'thumbnail', 'revisions' ],
			'taxonomies'          => [ ],
			'hierarchical'        => false,
			'public'              => true,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'menu_position'       => 5,
			'menu_icon'           => 'dashicons-groups',
			'show_in_admin_bar'   => true,
			'show_in_nav_menus'   => true,
			'can_export'          => true,
			'rewrite'			  => [ 'slug' => 'players', 'with_front' => false, 'hierarchical' => true ],
			'has_archive'         => false,		
			'exclude_from_search' => false,
			'publicly_queryable'  => true,
			'capability_type'     => 'page',
		);

		register_post_type( $this->post_type, $args );
	}

    /**
     *  Get Twitch User ID on save.
     * 
     *  @param int $post_id The ID of the post being saved.
     *  @param WP_Post $post_obj Post object belonging to post being saved.
     * 
     *  @return int The ID of the post being saved.
     * 
     *  @since 1.0.1
     *  @access public
     */

	public function get_twitch_user_id( $post_id, $post_obj ) {

        // Only run this for players
        if ( $post_obj->post_type != $this->post_type ) {
            return $post_id;
        }

        // If this is an autosave, our form has not been submitted, so we don't want to do anything.
        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
            return $post_id;
        }

        // Check the user's permissions.
        if ( ! current_user_can( 'edit_post', $post_id ) ) {
            return $post_id;
        }

        // Don't process if the user doesn't have a Twitch username assigned
        if ( ! ( $twitch_username = get_post_meta( $post_id, 'twitch', true ) ) ) {
        	// We also need to delete the existing Twitch user ID
        	update_post_meta( $post_id, 'twitch_user_id', '' );

            return $post_id;
        }

        // Try and get the user from Twitch
        $twitch = twitch_api();
        $twitch_user = $twitch->getUserByUsername( $twitch_username );

        // Make sure we got an array of users back
        if ( $twitch_user['users'] ) {
        	// Update the user's meta data to store the Twitch ID
        	update_post_meta( $post_id, 'twitch_user_id', $twitch_user['users'][0]['_id'] );
        }

        // We're done here.
        return $post_id;
	}
}

new Naventic_Player;