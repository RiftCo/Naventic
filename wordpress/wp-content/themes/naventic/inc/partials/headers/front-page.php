<body class="homePage">
	
	<header id="top">
		<?php partial( 'header-nav' ); ?>

		<div class="homepageHeader">
			<div class="header-left">
				<?php
				// Get our featured post
				$featured_post = theme( 'featured_news_post' );

				// If we don't have a featured post, we need to fill this space
				if( ! $featured_post ) {
					// Get our latest post
					$featured_post = get_posts(['post_type' => ['post', 'event'], 'posts_per_page' => 1]);

					// We also need to reset our array
					$featured_post = $featured_post[0];
				}

				partial( 'card-news', [ 'post' => $featured_post ] );
				?>
			</div>

			<div class="header-right">
				<div class="header-right-top">
					<?php partial( 'team-nav' ); ?>
				</div>

				<div class="header-right-bottom">
					<a class="card card-page card-page-store" href="<?php echo site_url( '/products/' ); ?>" rel="prefetch" target="_self">
						<div class="card-container">
							<div class="details">
								<h6><?php echo theme( 'store', 'subtitle', 'Get yours!' ); ?></h6>
								<h3 class="title"><?php echo theme( 'store', 'title', '2017 Jerseys In Store!' ); ?></h3>
							</div>

							<?php
							// Set our default store image
							$image = get_asset( 'store/default/photo.png' );

							// Try and get our specified store image
							if( $updated_image = theme( 'store', 'tshirt_image' ) ) {
								$image = $updated_image['url'];
							}
							?>
							<img class="card-page-overimg" src="<?php echo $image; ?>" width="294" height="360" />
						</div>

						<div class="bg-image" style="background-image: url('<?php echo get_asset( 'teamflag.png' ); ?>')">
							<span class="overlay"></span>
						</div>
					</a>
					
					<a class="card card-page" href="<?php echo theme( 'page', 'link', site_url( '/about/' ) ); ?>" rel="prefetch" target="_self">
						<div class="card-container">
							<div class="details">
								<h6><?php echo theme( 'page', 'subtitle', 'Learn More' ); ?></h6>
								<h3 class="title"><?php echo theme( 'page', 'title', 'About Naventic' ); ?></h3>
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