<?php
// The Query
$sponsors = new WP_Query([
	'post_type'		=> [ 'sponsor' ],
	'post_status'	=> [ 'publish' ],
	'cache_results'	=> true,
    'meta_key'		=> 'position',
    'orderby' 		=> 'meta_value_num',
    'order' 		=> 'ASC'
]);

// The Loop
if ( $sponsors->have_posts() ) {
	while ( $sponsors->have_posts() ) {
		$sponsors->the_post();

		if ( has_post_thumbnail() ) {
			echo '<a href="' . get_post_meta( get_the_ID(), 'website_url', true ) . '" title="' . esc_attr( get_the_title() ) . '" target="_blank">';
				echo '<img src="' . get_the_post_thumbnail_url() . '" alt="' . esc_attr( get_the_title() ) . '" height="30" />';
			echo '</a>';
		}
	}

	wp_reset_postdata();
}