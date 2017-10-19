<?php
/**
 *	Template Name: Media
 */

$media = new WP_Query([
	'post_type'		 => [ 'player', 'video' ],
	'post_status'	 => [ 'publish' ],
	'posts_per_page' => 6,
]);

get_header(); ?>

	<?php partial( 'headers/media', [ 'title' => get_the_title() ]); ?>

	<section>
		<div class="row">
			<?php if ( $media->have_posts() ) { ?>
				<?php while ( $media->have_posts() ) { $media->the_post(); ?>
					<div class="col c4">
						<?php partial( 'card-stream', [ 'post' => get_post() ] ); ?>
					</div>
				<?php } ?>
			<?php } ?>
		</div>

		<?php get_pagination(2, $media); ?>
	
	</section>

<?php get_footer(); ?>