<body class="articlePage <?php echo ( get_post_type() == 'post' ) ? 'newsArticlePage' : ''; ?>">

	<header id="top">
		<?php partial( 'header-nav' ); ?>

		<div class="articleHeader row">
			<div class="title">
				<h6>
					<span>
						<?php if($game_tags = wp_get_post_terms( get_the_ID(), 'game' ) ) { ?>
							<?php foreach($game_tags as $tag) { ?>
								<?php echo $tag->name; ?>
							<?php } ?>
						<?php } ?>
						
						<?php echo ucwords( get_post_type() ); ?>

					</span> 

					<?php echo timeago( get_post_time( 'U', true ) ); ?>
				</h6>
				
				<h1><?php the_title(); ?></h1>
			</div>
		</div>
	</header>