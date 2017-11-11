<?php get_header(); ?>

	<?php if( have_posts() ) : while ( have_posts() ) : the_post(); ?>

		<?php partial( 'headers/standard', [
			'title'    => get_the_title(),
			'subtitle' => '',
		]); ?>

		<section class="row articleBody">
			<article class="col c12">
				<?php if ( has_post_thumbnail() ) { ?>
    				<?php echo '<img src="' . get_the_post_thumbnail_url( get_the_ID(), 'full' ) . '" alt="' . esc_attr( get_the_title() ) . '" style="max-width: 100%" />'; ?>
				<?php } ?> 
		
				<?php the_content(); ?>
			</article>
		</section>

	<?php endwhile; endif; ?>

<?php get_footer(); ?>