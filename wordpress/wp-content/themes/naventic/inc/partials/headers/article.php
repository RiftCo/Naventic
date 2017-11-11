<body <?php body_class( ( get_post_type() == 'post' ) ? 'newsArticlePage articlePage' : 'articlePage' ); ?>>

	<header id="top">
		<?php partial( 'header-nav' ); ?>

		<div class="articleHeader row">
			<div class="title">
				<h6>
					<span>
						<?php echo news_game_label( get_the_ID(), false ); ?>
						
						<?php echo news_category_label( get_the_ID() ); ?>
					</span> 

					<?php echo timeago( get_post_time( 'U', true ) ); ?>
				</h6>
				
				<h1><?php the_title(); ?></h1>
			</div>
		</div>
	</header>