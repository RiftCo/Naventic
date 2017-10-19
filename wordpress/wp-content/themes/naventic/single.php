<?php get_header(); ?>

	<?php if( have_posts() ) : while ( have_posts() ) : the_post(); ?>

		<?php partial( 'headers/article' ); ?>

		<section class="row articleBody">
			<article class="col c8">
				<?php if ( has_post_thumbnail() ) { ?>
    				<?php the_post_thumbnail(); ?>
				<?php } ?> 
		
				<?php the_content(); ?>
			</article>

			<aside class="col c4">
				<?php if( $related_content = theme( 'related_content' ) ) { ?>
					<ul class="relatedContent">
						<?php foreach( $related_content as $related ) { ?>
							<li>
								<?php partial( 'card-' . $related['content_type'], [ 'post' => $related[$related['content_type']], 'show_team' => $related['show_team_players'] ] ); ?>
							</li>
						<?php } ?>
					</ul>
				<?php } ?>

				<?php if( $related_post = theme( 'related_post' ) ) { ?>
					<ul class="recommendedContent">
	 					<li class="recommendedContentTitle"><h6>Recommended:</h6></li>
	 					<li>
	 						<?php partial( 'card-news', [ 'post' => $related_post ] ); ?>
						</li>
					</ul>
				<?php } ?>
			</aside>
		</section>

	<?php endwhile; endif; ?>

<?php get_footer(); ?>