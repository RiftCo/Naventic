<body class="homePage">
	
	<header id="top">
		<?php partial( 'header-nav' ); ?>

		<div class="homepageHeader">
			<div class="header-left">
				<?php partial( 'card-news', [ 'post' => get_post(1) ] ); ?>
			</div>

			<div class="header-right">
				<div class="header-right-top">
					<?php partial( 'team-nav' ); ?>
				</div>

				<div class="header-right-bottom">
					<a class="card card-page card-page-store" href="<?php echo site_url( '/products/' ); ?>" rel="prefetch" target="_self">
						<div class="card-container">
							<div class="details">
								<h6>Get yours!</h6>
								<h3 class="title">2017 Jerseys In Store!</h3>
							</div>
							
							<img class="card-page-overimg" src="<?php echo get_asset( 'store/default/photo.png' ); ?>" width="294" height="360" />
						</div>

						<div class="bg-image" style="background-image: url('<?php echo get_asset( 'teamflag.png' ); ?>')">
							<span class="overlay"></span>
						</div>
					</a>
					
					<a class="card card-page" href="<?php echo site_url( '/about/' ); ?>" rel="prefetch" target="_self">
						<div class="card-container">
							<div class="details">
								<h6>Learn More</h6>
								<h3 class="title">About Naventic</h3>
							</div>
						</div>

						<div class="bg-image" style="background-image: url('<?php echo get_asset( 'article/thumbs/thumb-3.jpg' ); ?>')">
							<span class="overlay"></span>
						</div>
					</a>
				</div>
			</div>
		</div>

		<section class="sponsorContainer">
			<?php partial( 'sponsors' ); ?>
		</section>
	</header>