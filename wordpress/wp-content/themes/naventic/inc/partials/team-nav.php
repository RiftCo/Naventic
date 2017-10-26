<div class="card card-team <?php echo is_front_page() ? 'card-slider-team' : 'card-page-team'; ?>">
	<ul class="teamNav">
		<?php if( $teams = get_posts([ 'post_type' => 'team' ]) ) { ?>
			<?php foreach( $teams as $i => $team ) { ?>
				<li>
					<a href="<?php echo get_the_permalink( $team->ID ); ?>" title="<?php echo esc_attr( get_the_title( $team->ID ) ); ?>" class="js-team-slider <?php if( $team->ID == get_the_ID() || ( is_front_page() && $i == 0 ) ) { echo 'active'; } ?>" data-team="<?php echo $team->ID; ?>">
						<img src="<?php echo theme( 'team_icon', 'url', false, $team->ID ); ?>" alt="<?php echo esc_attr( get_the_title( $team->ID ) ); ?>" height="30" />
					</a>
				</li>
			<?php } ?>
		<?php } ?>
	</ul>

	<?php if( $teams = get_posts([ 'post_type' => 'team' ]) ) { ?>
		<?php foreach( $teams as $i => $team ) { ?>
			<?php if( is_front_page() ) { ?>
				<a href="<?php echo get_the_permalink( $team->ID ); ?>" title="<?php echo esc_attr( get_the_title( $team->ID ) ); ?>" class="js-team js-team--<?php echo $team->ID; ?> <?php if( is_front_page() && $i == 0 ) { echo 'active'; } ?>">
			<?php } else { ?>
				<div class="js-team js-team--<?php echo $team->ID; ?> <?php if( $team->ID == get_the_ID() ) { echo 'active'; } ?>">
			<?php } ?>
				<div class="card-container">
					<div class="details">
						<h3 class="title"><?php echo get_the_title( $team->ID ); ?></h3>
						<h6><?php echo __( 'Meet the team', 'naventic' ); ?></h6>
					</div>
				</div>

				<div class="bg-image" style="background-image: url(<?php echo theme( 'background_image', 'url', false, $team->ID ); ?>)"></div>
			<?php if( is_front_page() ) { ?></a><?php } else { ?></div><?php } ?>
		<?php } ?>
	<?php } ?>
</div>