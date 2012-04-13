/**
* OU player: Title panel feature.
* Copyright 2012 The Open University.
*/
(function($) {

	$.extend(mejs.MepDefaults, {
		titleText:null //'[OU logo] [Title] <a href="#">[link]</a>'
	});

	// OUP title panel
	$.extend(MediaElementPlayer.prototype, {
		buildoup_titlepanel: function(player, controls, layers, media) {
			var 
				t = this,
				op = t.options;

			// Return early if there is no title-text (expected for VLE player).
			if (! op.titleText) {
				$.log('Warning: no title.');
				return;
			}

			var
				titlepanel = 
				$('<div class="oup-mejs-panel mejs-title-panel mejs-play" id="'+t.id+'-ttl-panel">' + op.titleText +
				'</div>')
				.appendTo(controls)
				/*.click(function(e) {
					e.preventDefault();

				    alert("Title panel: mostly functional - needs more styling!");

					return false;
				})*/;

			media.addEventListener('play',function() {
				titlepanel.removeClass('mejs-play').addClass('mejs-pause');
			}, false);
			media.addEventListener('playing',function() {
				titlepanel.removeClass('mejs-play').addClass('mejs-pause');
			}, false);

            media.addEventListener('pause',function() {
				titlepanel.removeClass('mejs-pause').addClass('mejs-play');
			}, false);
			media.addEventListener('paused',function() {
				titlepanel.removeClass('mejs-pause').addClass('mejs-play');
			}, false);
		}
	});
	
})(mejs.$);