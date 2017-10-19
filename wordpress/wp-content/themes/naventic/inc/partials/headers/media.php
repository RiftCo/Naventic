<body class="mediaPage">

	<header id="top">
		<?php partial( 'header-nav' ); ?>

		<div class="newsHeader row">
			<div class="title">
				<h6>Digital Media</h6>
				<h1><?php echo $title ?? get_the_title(); ?></h1>

				<ul class="mediaFilter">
					<li><a href="<?php echo site_url( '/media/streams/' ); ?>" title="Livestreams" class="active"><p>Livestreams</p></a></li>
					<li><a href="<?php echo site_url( '/media/videos/' ); ?>" title="Videos"><p>Videos</p></a></li>
				</ul>
			</div>
		</div>
	</header>