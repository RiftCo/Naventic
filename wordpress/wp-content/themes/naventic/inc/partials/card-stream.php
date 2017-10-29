<?php
// Start up our Twitch API
$twitch = twitch_api();

// Ensure we have a Twitch user ID to avoid errors
if( get_post_meta( $post->ID, 'twitch_user_id', true ) ) {
	$user   = $twitch->getUser( get_post_meta( $post->ID, 'twitch_user_id', true ) );
	$stream = $twitch->getStreamByUser( get_post_meta( $post->ID, 'twitch_user_id', true ) );
	?>

	<a class="card card-livestream" href="<?php echo get_the_permalink( $post->ID ); ?>" rel="prefetch" target="_self">
		<div class="card-container">
			<div class="thumb">
				<?php if( $stream['stream'] != NULL ) { ?>
					<div class="live"><h6>LIVE</h6></div>

					<div class="bg-image" style="background-image: url(<?php echo $stream['preview']['large']; ?>)"></div>
				<?php } else { ?>
					<div class="offline"><h6>OFFLINE</h6></div>

					<div class="bg-image" style="background-image: url(<?php echo $user['logo']; ?>)"></div>
				<?php } ?>
			</div>

			<div class="details">
				<?php if( $ingame_name = theme( 'game_name', false, false, $post->ID ) ) { ?>
					<h3><?php echo $ingame_name; ?></h3>
				<?php } ?>

				<?php if( $twitch = theme( 'twitch', false, false, $post->ID ) ) { ?>
					<h6>twitch.tv/<?php echo $twitch; ?></h6>
				<?php } ?>
			</div>
		</div>
	</a>
<?php } ?>