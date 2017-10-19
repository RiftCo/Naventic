<?php
class Naventic_Event
{
	// Register our post type slug
	private $post_type = 'event';

	// Set our translation family
	private $translation = 'naventic';

	// Set our singular and plural terminology
	private $singular = 'Event';
	private $plural = 'Events';

	public function __construct() {
		// Register the post type
		add_action('init', [$this, 'register_post_type'], 0);
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
			'taxonomies'          => [ 'game' ],
			'hierarchical'        => false,
			'public'              => true,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'menu_position'       => 5,
			'menu_icon'           => 'dashicons-tickets-alt',
			'show_in_admin_bar'   => true,
			'show_in_nav_menus'   => true,
			'can_export'          => true,
			'rewrite'			  => [ 'slug' => 'events', 'with_front' => false, 'hierarchical' => true ],
			'has_archive'         => false,		
			'exclude_from_search' => false,
			'publicly_queryable'  => true,
			'capability_type'     => 'page',
		);

		register_post_type( $this->post_type, $args );
	}
}

new Naventic_Event;