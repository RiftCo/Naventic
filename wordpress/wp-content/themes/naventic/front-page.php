<?php get_header(); ?>

	<?php
	// Load our homepage header
	partial( 'headers/front-page' );

	// Get our news posts
	$news = theme( 'featured_news', false, get_posts([ 'posts_per_page' => 2, 'post_type' => 'post' ]) );

	// Get our players
	$players = theme( 'featured_players', false, get_posts([ 'posts_per_page' => 3, 'post_type' => 'player' ]) );

	// Get our streams
	$streams = theme( 'featured_streams', false, get_posts([ 'posts_per_page' => 3, 'post_type' => 'player' ]) );
	?>

	<section class="demo">

		<!-- News Cards -->
		<?php if( $news ) { ?>
			<div class="row">
				<?php foreach( $news as $post ) { ?>
					<div class="col c6">
						<?php partial( 'card-news', [ 'post' => $post ] ); ?>
					</div>
				<?php } ?>
			</div>
		<?php } ?>


		<!-- Player Cards -->
		<?php if( $players ) { ?>
			<div class="row">
				<?php foreach( $players as $post ) { ?>
					<div class="col c4">
						<?php partial( 'card-player', [ 'post' => $post ] ); ?>
					</div>
				<?php } ?>
			</div>
		<?php } ?>


		<!-- Livestream Cards -->
		<?php if( $streams ) { ?>
			<div class="row">
				<?php foreach( $streams as $post ) { ?>
					<div class="col c4">
						<?php partial( 'card-stream', [ 'post' => $post ] ); ?>
					</div>
				<?php } ?>
			</div>
		<?php } ?>


		<!-- Store Cards -->
		<?php if( $posts = get_posts([ 'posts_per_page' => 3, 'post_type' => 'product' ]) ) { ?>
			<div class="row">
				<?php foreach( $posts as $post ) { ?>
					<div class="col c4">
						<?php partial( 'card-product', [ 'post' => $post ] ); ?>
					</div>
				<?php } ?>
			</div>
		<?php } ?>

	</section>

<?php get_footer(); ?>