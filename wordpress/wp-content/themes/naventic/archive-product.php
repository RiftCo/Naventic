<?php get_header(); ?>

	<?php partial( 'headers/standard', [
		'title'    => 'Naventic Apparel Store',
		'subtitle' => 'Powered by Arma Centrum',
	] ); ?>

	<?php
	if( have_posts() ) {
		while( have_posts() ) {
			the_post();

			partial( 'card-product', [ 'post' => get_post() ] );
		}
	}

	get_pagination();
	?>

<?php get_footer(); ?>