<a class="card card-news" href="<?php echo get_the_permalink( $post->ID ); ?>" rel="prefetch" target="_self">
	<div class="card-container">
		<div class="details">
			<ul class="metadata">
				<li class="date"><h6><?php echo timeago( get_post_time( 'U', true, $post->ID ) ); ?></h6></li>

				<?php if($game_tags = wp_get_post_terms( $post->ID, 'game' ) ) { ?>
					<?php foreach($game_tags as $tag) { ?>
						<li class="tag"><h6><?php echo $tag->name; ?></h6></li>
					<?php } ?>
				<?php } ?>

				<li class="tag"><h6><?php echo ucwords( get_post_type( $post->ID ) ); ?></h6></li>
			</ul>

			<h3 class="title"><?php echo get_the_title( $post->ID ); ?></h3>
		</div>
	</div>

	<div class="bg-image" style="background-image: url(<?php echo get_asset( 'article/thumbs/thumb-3.jpg' ); ?>)"> <span class="overlay hover"></span> </div>
</a>