<?php
class Naventic_Game
{
	// Register our taxonomy slug
	private $post_type = 'game';

	// Set our translation family
	private $translation = 'naventic';

	// Set our singular and plural terminology
	private $singular = 'Game';
	private $plural = 'Games';

	public function __construct() {
		// Register Custom Taxonomy
		add_action( 'init', [$this, 'register_taxonomy'], 0 );
	}

	public function register_taxonomy() {
		$labels = [
			'name'                       => _x( $this->plural, 'Taxonomy General Name', $this->translation ),
			'singular_name'              => _x( $this->singular, 'Taxonomy Singular Name', $this->translation ),
			'menu_name'                  => __( $this->plural, $this->translation ),
			'all_items'                  => __( 'All Items', $this->translation ),
			'parent_item'                => __( 'Parent Item', $this->translation ),
			'parent_item_colon'          => __( 'Parent Item:', $this->translation ),
			'new_item_name'              => __( 'New Item Name', $this->translation ),
			'add_new_item'               => __( 'Add New Item', $this->translation ),
			'edit_item'                  => __( 'Edit Item', $this->translation ),
			'update_item'                => __( 'Update Item', $this->translation ),
			'view_item'                  => __( 'View Item', $this->translation ),
			'separate_items_with_commas' => __( 'Separate items with commas', $this->translation ),
			'add_or_remove_items'        => __( 'Add or remove items', $this->translation ),
			'choose_from_most_used'      => __( 'Choose from the most used', $this->translation ),
			'popular_items'              => __( 'Popular Items', $this->translation ),
			'search_items'               => __( 'Search Items', $this->translation ),
			'not_found'                  => __( 'Not Found', $this->translation ),
			'no_terms'                   => __( 'No items', $this->translation ),
			'items_list'                 => __( 'Items list', $this->translation ),
			'items_list_navigation'      => __( 'Items list navigation', $this->translation ),
		];

		$args = [
			'labels'                     => $labels,
			'hierarchical'               => true,
			'public'                     => true,
			'show_ui'                    => true,
			'show_admin_column'          => true,
			'show_in_nav_menus'          => true,
			'show_tagcloud'              => true,
			'rewrite'                    => false,
		];

		register_taxonomy( 'game', [ 'event', 'product', 'post', 'team', 'video' ], $args );
	}
}

new Naventic_Game;