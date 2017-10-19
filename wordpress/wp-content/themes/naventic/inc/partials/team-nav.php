<div class="card card-team card-page-team">
	<ul class="teamNav">
		<?php if( $teams = get_posts([ 'post_type' => 'team' ]) ) { ?>
			<?php foreach( $teams as $team ) { ?>
				<li>
					<a href="<?php echo get_the_permalink( $team->ID ); ?>" title="<?php echo esc_attr( get_the_title( $team->ID ) ); ?>" <?php if( $team->ID == get_the_ID() ) { echo 'class="active"'; } ?>>
						<img src="<?php echo theme( 'team_icon', 'url', false, $team->ID ); ?>" alt="<?php echo esc_attr( get_the_title( $team->ID ) ); ?>" height="30" />
					</a>
				</li>
			<?php } ?>
		<?php } ?>
	</ul>

	<div class="card-container">
		<div class="details">
			<h3 class="title"><?php echo get_the_title(); ?></h3>
			<h6>Meet the team</h6>
		</div>
	</div>

	<div class="bg-image" style="background-image: url(<?php echo theme( 'background_image', 'url', false, $team->ID ); ?>)"></div>
</div>