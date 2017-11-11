<?php get_header(); ?>

	<?php partial( 'headers/team' ); ?>

	<?php
	// Get our team game taxonomy
	$game_taxonomy = wp_get_post_terms( get_the_ID(), 'game' );

	// Only select the first taxonomy value
	$game_taxonomy = $game_taxonomy[0];
	?>

	<?php if( $team_news = get_posts([ 'post_type' => 'post', 'posts_per_page' => 4, 'tax_query' => [['taxonomy' => 'game', 'field' => 'slug', 'terms' => $game_taxonomy]] ]) ) { ?>
		<section class="wideNews">
			<?php foreach( $team_news as $post ) { ?>
				<div class="col c3">
					<?php partial( 'card-news', [ 'post' => $post ] ); ?>
				</div>
			<?php } ?>
		</section>
	<?php } ?>

	<?php if( $team_players = get_posts([ 'post_type' => 'player', 'tax_query' => [['taxonomy' => 'game', 'field' => 'slug', 'terms' => $game_taxonomy]] ]) ) { ?>
		<section class="row">
			<?php foreach( $team_players as $post ) { ?>
				<div class="col c4">
					<?php partial( 'card-player', [ 'post' => $post ] ); ?>
				</div>
			<?php } ?>
		</section>
	<?php } ?>

<?php get_footer(); ?>