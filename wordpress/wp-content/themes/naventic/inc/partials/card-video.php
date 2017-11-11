<a class="card card-livestream" href="<?php echo theme( 'video_url', false, '#', $post->ID ); ?>" rel="prefetch" target="_self">
	<div class="card-container">
		<div class="thumb">
			<?php if ( has_post_thumbnail($post->ID) ) { ?>
				<div class="bg-image" style="background-image: url(<?php echo get_the_post_thumbnail_url( $post->ID, 'full' ); ?>)"></div>
			<?php } else { ?>
				<div class="bg-image" style="background-image: url(<?php echo get_asset( 'article/thumbs/thumb-3.jpg' ); ?>)"></div>
			<?php } ?>
		</div>

		<div class="details">
			<h3><?php echo get_the_title(); ?></h3>

			<?php if( $subtitle = theme( 'video_description', false, false, $post->ID ) ) { ?>
				<h6><?php echo $subtitle; ?></h6>
			<?php } ?>
		</div>
	</div>
</a>