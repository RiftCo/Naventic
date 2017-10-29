<?php
/* Template Name: Teams */

get_header();

partial( 'headers/standard', [
	'title'    => 'Naventic <span>Esports</span> Family',
	'subtitle' => 'Meet the Teams',
]);

// Teams
$teams = get_posts([ 'post_type' => 'team', 'posts_per_page' => -1 ]);
?>

	<section>
		<?php
		$i = 0;
		
		if( $teams ) {
			foreach( $teams as $i => $team ) {
				if( $i == 0 || $i % 2 == 1 ) {
					echo '<div class="row">';
				}

				if( $i == 0 ) {
					echo '<div class="col c12">';
				} else {
					echo '<div class="col c6">';
				}

				partial( 'card-team', [ 'post' => get_post( $team->ID ) ] );

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
		?>

	</section>

<?php get_footer(); ?>