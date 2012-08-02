/**
* OU player: Title panel feature.
* Copyright 2012 The Open University.
*/
(function($) {

	$.extend(mejs.MepDefaults, {
		titleClass:'mejs-title-panel:first' //iet-it-bugs: #1385
		//titleText:null //'[OU logo] [Title] <a href="#">[link]</a>'
	});

	// OUP title panel
	$.extend(MediaElementPlayer.prototype, {
		buildoup_titlepanel: function(player, controls, layers, media) {
			var 
				t = this
				, op = t.options
				, cl_play = 'mejs-play'
				, cl_pause= 'mejs-pause'
				;

			/*// Return early if there is no title-text (expected for VLE player).
			if (! op.titleText) {
				$.log('Warning: no title.');
				return;
			}*/

			var
				titlepanel = $('.'+ op.titleClass);
				/*
				$('<div class="oup-mejs-panel mejs-title-panel mejs-play" id="'+t.id+'-ttl-panel">' + op.titleText +
				'</div>')
				.appendTo(controls)
				/*.click(function(e) {
					e.preventDefault();

				    alert("Title panel: mostly functional - needs more styling!");

					return false;
				})*/;

			// Return early if there is no title-text (expected for VLE player).
			if (! titlepanel) {
				$.log('Warning: no title.');
				return;
			}

			titlepanel[0].id = t.id +'-ttl-panel';

			media.addEventListener('play',function() {
				titlepanel.removeClass(cl_play).addClass(cl_pause);
			}, false);
			media.addEventListener('playing',function() {
				titlepanel.removeClass(cl_play).addClass(cl_pause);
			}, false);

            media.addEventListener('pause',function() {
				titlepanel.removeClass(cl_pause).addClass(cl_play);
			}, false);
			media.addEventListener('paused',function() {
				titlepanel.removeClass(cl_pause).addClass(cl_play);
			}, false);
		}
	});
	
})(mejs.$);