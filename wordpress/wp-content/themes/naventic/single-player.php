<?php get_header(); ?>

<body class="articlePage">

	<header id="top">
		<?php partial( 'header-nav' ); ?>

		<div class="articleHeader row">
			<div class="title">
				<h6><span>Twitch Livestream</span></h6>
				<h1><?php echo get_the_title(); ?></h1>
			</div>
		</div>
	</header>


	<section class="row articleBody">
		<article class="col c8 twitchStream">
			<div class="video">
				<iframe src="https://player.twitch.tv/?channel=<?php echo theme( 'twitch' ); ?>" frameborder="0" allowfullscreen="true" scrolling="no" height="540" width="960"></iframe>
			</div>
			
			<div class="videoChat">
				<iframe src="https://www.twitch.tv/<?php echo theme( 'twitch' ); ?>/chat?popout=" frameborder="0" scrolling="no" height="500" width="350"></iframe>
			</div>
		</article>
	
		<aside class="col c4">
			<?php partial( 'card-player', [ 'post' => get_post() ] ); ?>
		</aside>
	</section>

<?php get_footer(); ?>