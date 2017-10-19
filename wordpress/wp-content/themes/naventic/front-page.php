<?php get_header(); ?>

	<?php partial( 'headers/front-page' ); ?>

	<section class="demo">

		<!-- News Cards -->
		<?php if( $posts = get_posts([ 'posts_per_page' => 2, 'post_type' => 'post' ]) ) { ?>
			<div class="row">
				<?php foreach( $posts as $post ) { ?>
					<div class="col c6">
						<?php partial( 'card-news', [ 'post' => $post ] ); ?>
					</div>
				<?php } ?>
			</div>
		<?php } ?>


		<!-- Player Cards -->
		<?php if( $posts = get_posts([ 'posts_per_page' => 3, 'post_type' => 'player' ]) ) { ?>
			<div class="row">
				<?php foreach( $posts as $post ) { ?>
					<div class="col c4">
						<?php partial( 'card-player', [ 'post' => $post ] ); ?>
					</div>
				<?php } ?>
			</div>
		<?php } ?>


		<!-- Livestream Cards -->
		<?php if( $posts = get_posts([ 'posts_per_page' => 3, 'post_type' => 'player' ]) ) { ?>
			<div class="row">
				<?php foreach( $posts as $post ) { ?>
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