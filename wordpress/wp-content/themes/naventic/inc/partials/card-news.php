<a class="card card-news" href="<?php echo get_the_permalink( $post->ID ); ?>" rel="prefetch" target="_self">
	<div class="card-container">
		<div class="details">
			<ul class="metadata">
				<li class="date"><h6><?php echo timeago( get_post_time( 'U', true, $post->ID ) ); ?></h6></li>

				<?php if( $label = news_game_label( $post->ID, true ) ) { ?>
					<li class="tag"><h6><?php echo $label; ?></h6></li>
				<?php } ?>

				<li class="tag"><h6><?php echo news_category_label( $post->ID ); ?></h6></li>
			</ul>

			<h3 class="title"><?php echo get_the_title( $post->ID ); ?></h3>
		</div>
	</div>

	<?php if ( has_post_thumbnail($post->ID) ) { ?>
		<div class="bg-image" style="background-image: url(<?php echo get_the_post_thumbnail_url( $post->ID, 'full' ); ?>)"> <span class="overlay hover"></span> </div>
	<?php } else { ?>
		<div class="bg-image" style="background-image: url(<?php echo get_asset( 'article/thumbs/thumb-3.jpg' ); ?>)"> <span class="overlay hover"></span> </div>
	<?php } ?>
</a>