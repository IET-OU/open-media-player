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
				play = 
				$('<div class="mejs-button mejs-playpause-button mejs-play" >' +
					'<button type="button" aria-controls="' + t.id + '" title="' + t.options.playText + '"></button>' +
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
			//console.log(btn);

			media.addEventListener('play',function() {
				play.removeClass('mejs-play').addClass('mejs-pause');
				btn_play.attr('title', t.options.pauseText);
			}, false);
			media.addEventListener('playing',function() {
				play.removeClass('mejs-play').addClass('mejs-pause');
				btn_play.attr('title', t.options.pauseText);
			}, false);


			media.addEventListener('pause',function() {
				play.removeClass('mejs-pause').addClass('mejs-play');
				btn_play.attr('title', t.options.playText);
			}, false);
			media.addEventListener('paused',function() {
				play.removeClass('mejs-pause').addClass('mejs-play');
				btn_play.attr('title', t.options.playText);
			}, false);
		}
	});
	
})(mejs.$);