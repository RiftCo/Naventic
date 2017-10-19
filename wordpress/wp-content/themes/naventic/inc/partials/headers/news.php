<body class="newsPage">

  <header id="top">
    <?php partial( 'header-nav' ); ?>
    
    <?php
    // Create our news page subtitle
    $title = 'Naventic News';

    if( isset( $_GET['filter'] ) ) {
      $game = get_term_by( 'slug', $_GET['filter'], 'game' );

      if( $game ) {
        $title = 'Naventic <span>' . $game->name . '</span> News';
      }
    }
    ?>

    <div class="newsHeader row">
      <div class="title">
        <h6>Latest updates from Naventic</h6>
        <h1><?php echo $title; ?></h1>
      </div>
    </div>

    <ul class="newsFilter newsFilterType row" style="display: none">
      <li><a href="." class="active"><p>Event</p></a></li>
      <li><a href="." class="active"><p>Video</p></a></li>
      <li><a href="."><p>League</p></a></li>
    </ul>

    <?php if( $teams = get_posts([ 'post_type' => 'team' ]) ) { ?>
      <ul class="newsFilter newsFilterGame row">
        <?php foreach( $teams as $team ) { ?>
          <?php
          // Get our team game taxonomy
          $game_taxonomy = wp_get_post_terms( $team->ID, 'game' );

          // Only select the first taxonomy value
          $game_taxonomy = $game_taxonomy[0];

          // Set a variable for if our game filter is active
          $game_is_active = !! ( isset( $_GET['filter'] ) && $_GET['filter'] == $game_taxonomy->slug );

          // Set our link
          $game_link = ( $game_is_active ) ? '?' : '?filter=' . $game_taxonomy->slug;
          ?>
          <li>
            <a href="<?php echo $game_link; ?>" title="<?php echo esc_attr( get_the_title( $team->ID ) ); ?>" <?php if( $game_is_active ) { echo 'class="active"'; } ?>>
              <img src="<?php echo theme( 'team_icon', 'url', false, $team->ID ); ?>" alt="<?php echo esc_attr( get_the_title( $team->ID ) ); ?>" height="30" />
            </a>
          </li>
        <?php } ?>
      </ul>
    <?php } ?>
  </header>