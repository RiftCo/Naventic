<a class="card card-news" href="<?php echo get_the_permalink( $post->ID ); ?>" rel="prefetch" target="_self">
	<div class="card-container">
		<div class="details">
			<h3 class="title"><?php echo get_the_title( $post->ID ); ?></h3>
		</div>
	</div>

	<?php if ( has_post_thumbnail($post->ID) ) { ?>
		<div class="bg-image" style="background-image: url(<?php echo get_the_post_thumbnail_url( $post->ID, 'full' ); ?>)"> <span class="overlay hover"></span> </div>
	<?php } else { ?>
		<div class="bg-image" style="background-image: url(<?php echo get_asset( 'article/thumbs/thumb-3.jpg' ); ?>)"> <span class="overlay hover"></span> </div>
	<?php } ?>
</a>