jQuery(function($) {

	$( '.card-slider-team .js-team-slider' ).click(function(e) {
		// Prevent the link from going to the team page
		e.preventDefault();

		// Set the fade speed
		var fade_speed = 300;

		// Calculate which team we're showing
		var team_class = $(this).data('team');
		var $team = $('.js-team--' + team_class)

		// Update the menu active states
		$(this).parents('.teamNav').find('.js-team-slider').removeClass('active');
		$(this).addClass('active');

		// Turn off current team
		$( '.js-team' ).fadeOut(fade_speed, function() {
			// Show new team
			setTimeout(function() {
				$team.fadeIn(fade_speed);
			}, fade_speed);
		});
	});

});