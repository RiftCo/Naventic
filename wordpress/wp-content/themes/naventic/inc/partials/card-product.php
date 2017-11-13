<a class="card card-store" href="<?php echo theme( 'external_link', false, false, $post->ID ); ?>" rel="prefetch" target="_blank">
	<div class="card-container">
		<div class="thumb product-photo">
			<!--<div class="price sale"><h6><?php echo theme( 'price', false, false, $post->ID ); ?></h6></div>-->
			<?php if ( has_post_thumbnail($post->ID) ) { ?>
				<img src="<?php echo get_the_post_thumbnail_url( $post->ID, 'full' ); ?>" alt="<?php echo esc_attr( get_the_title() ); ?>" width="294" height="360" />
			<?php } else { ?>
				<img src="<?php echo get_asset('store/default/photo@2x.png' ); ?>" alt="<?php echo esc_attr( get_the_title() ); ?>" width="294" height="360" />
			<?php } ?>
		</div>
		<div class="details">
			<h5><?php echo get_the_title(); ?></h5>

			<?php if( $subtitle = theme( 'subtitle', false, false, $post->ID ) ) { ?>
				<h6><?php echo $subtitle; ?></h6>
			<?php } ?>

			<?php echo theme( 'shopify_buy_button', false, '', $post->ID ); ?>
		</div>
	</div>
</a>