<?php get_header(); ?>

	<?php partial( 'headers/standard', [
		'title'    => 'Naventic Apparel Store',
		'subtitle' => 'Powered by Arma Centrum',
	] ); ?>

	<?php
	if( have_posts() ) {
		echo '<div class="row">';

		while( have_posts() ) {
			the_post();

			echo '<div class="col c4">';
				partial( 'card-product', [ 'post' => get_post() ] );
			echo '</div>';
		}

		echo '</div>';
	}

	get_pagination();
	?>

<?php get_footer(); ?>