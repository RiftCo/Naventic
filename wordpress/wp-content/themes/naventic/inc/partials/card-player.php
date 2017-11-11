<div class="card card-player <?php echo ( theme( 'profile_image_type', false, true, $post->ID ) == 'thumb' ) ? 'noAvi' : 'hasAvi'; ?>">
	<div class="card-container">
		<div class="avatar-container avi-default">
			<div class="avatar">
				<img src="<?php echo theme( 'profile_image', 'url', get_asset( 'player/default/avatar@2x.jpg' ), $post->ID ); ?>" alt="<?php echo esc_attr( get_the_title( $post->ID ) ); ?>" width="120" height="120"/>
			</div>

			<div class="bg-image" style="background-image: url('<?php echo get_asset( 'article/thumbs/thumb-3.jpg' ); ?>')"></div>
		</div>

		<div class="avatar-container avi-photo">
			<img src="<?php echo theme( 'profile_image', 'url', get_asset( 'player/default/photo@2x.png' ), $post->ID ); ?>" alt="<?php echo esc_attr( get_the_title( $post->ID ) ); ?>" width="294" height="530" />
		</div>

		<div class="details">
			<?php if( $ingame_name = theme( 'game_name', false, false, $post->ID ) ) { ?>
				<h3><?php echo $ingame_name; ?></h3>
			<?php } ?>

			<?php if( $full_name = theme( 'full_name', false, false, $post->ID ) ) { ?>
				<h6><?php echo $full_name; ?></h6>
			<?php } ?>

			<ul class="metadata">
				<?php if( $age = theme( 'age', false, false, $post->ID ) ) { ?>
					<li><h6>Age: <span><?php echo $age; ?></span></h6></li>
				<?php } ?>

				<?php if( $twitter = theme( 'twitter', false, false, $post->ID ) ) { ?>
					<li class="social"><h6>Twitter: <a href="https://twitter.com/<?php echo $twitter; ?>" target="_blank" rel="nofollow">@<?php echo $twitter; ?></a></h6></li>
				<?php } ?>

				<?php if( $twitch = theme( 'twitch', false, false, $post->ID ) ) { ?>
					<li class="social"><h6>Twitch: <a href="https://twitch.tv/<?php echo $twitch; ?>" target="_blank" rel="nofollow">twitch.tv/<?php echo $twitch; ?></a></h6></li>
				<?php } ?>

				<?php if( $facebook = theme( 'facebook', false, false, $post->ID ) ) { ?>
					<li class="social"><h6>Facebook: <a href="<?php echo $facebook; ?>" target="_blank" rel="nofollow"><?php echo $facebook; ?></a></h6></li>
				<?php } ?>
			</ul>
		</div>
	</div>
</div>