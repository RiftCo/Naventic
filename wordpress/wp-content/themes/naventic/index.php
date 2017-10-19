<?php get_header(); ?>

	<?php partial( 'headers/news' ); ?>

	<section>
		<?php
		$i = 0;
		
		if( have_posts() ) {
			while( have_posts() ) {
				the_post();
	
				if( $i == 0 || $i % 2 == 1 ) {
					echo '<div class="row">';
				}

				if( $i == 0 ) {
					echo '<div class="col c12">';
				} else {
					echo '<div class="col c6">';
				}

				partial( 'card-news', [ 'post' => get_post() ] );

				echo '</div>';

				if( $i % 2 == 0 ) {
					echo '</div>';
				}

				++$i;
			}

			// If we still have an open div, close it
			if( $i % 2 == 1 ) {
				echo '</div>';
			}
		}

		get_pagination();
		?>

	</section>

<?php get_footer(); ?>