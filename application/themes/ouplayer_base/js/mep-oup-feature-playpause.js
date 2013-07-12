/*
* OU player: MEP play/ pause feature, our version with dynamic 'title' attribute.
* Copyright 2012 The Open University.
*/
(function($) {

	$.extend(mejs.MepDefaults, {
		playText: 'Play',
		pauseText: 'Pause'
	});

	// PLAY/pause BUTTON
	$.extend(MediaElementPlayer.prototype, {
		buildoup_playpause: function(player, controls, layers, media) {
			var 
				t = this,
				op = t.options,
				cl_play = 'mejs-play',
				cl_pause= 'mejs-pause',
				body = $('body'),
				play = 
				$('<div class="mejs-button mejs-playpause-button mejs-play" >' +
					'<button type="button" aria-controls="' + t.id + '" title="' + op.playText + '"></button>' +
				'</div>')
				.appendTo(controls)
				.click(function(e) {
					e.preventDefault();

					if (media.paused) {
						media.play();
					} else {
						media.pause();
					}

					return false;
				}),
				btn_play = play.find('button');

			function togglePlayPause(which) {
				if ('play' == which) {
					play.removeClass(cl_play).addClass(cl_pause);
					body.removeClass(cl_play).addClass(cl_pause);
					btn_play.attr('title', op.pauseText);
				} else {
					play.removeClass(cl_pause).addClass(cl_play);
					body.removeClass(cl_pause).addClass(cl_play);
					btn_play.attr('title', op.playText);
				}
			};


			media.addEventListener('play',function() {
				togglePlayPause('play');
			}, false);
			media.addEventListener('playing',function() {
				togglePlayPause('play');
			}, false);


			media.addEventListener('pause',function() {
				togglePlayPause('pse');
			}, false);
			media.addEventListener('paused',function() {
				togglePlayPause('pse');
			}, false);
		}
	});

})(mejs.$);