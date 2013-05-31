/**
* OU player: shim for the Mediaelement tracks (captions/ subtitles) feature.
* Copyright 2012 The Open University.
* Author: Nick Freear.
*/
(function($) {

	// add extra default options 
	$.extend(mejs.MepDefaults, {
		showtracksText: 'Show captions',
		hidetracksText: 'Hide captions'
	});

	// Shims / fixes.
	$.extend(MediaElementPlayer.prototype, {
		buildoup_tracks_shim: function(player, controls, layers, media) {
			var
				t = this,
				op = t.options,
				cl_show = 'mejs-show',
				cl_hide = 'mejs-hide',
				track = null,
				btn_cc = controls.find('.mejs-captions-button button'),
				wrap_cc = btn_cc.parent();

			$.log('Tracks..');
			$.log(player.tracks[0]);
			//$.log(btn_cc);

			if (typeof player.tracks[0] !== 'undefined') {
				track = player.tracks[0];
				//btn_cc = btn_cc[0];

			btn_cc.click(function() {

				if (player.selectedTrack==null) {
					//player.captions.show();
					player.selectedTrack = track; //player.tracks[0];
					player.captions.attr('lang', track.srclang);
					player.displayCaptions();

					btn_cc.attr('title', op.hidetracksText);
					wrap_cc.removeClass(cl_show).addClass(cl_hide);
				} else {
					player.captions.hide();
					track = player.selectedTrack;
					player.selectedTrack = null;

					btn_cc.attr('title', op.showtracksText);
					wrap_cc.removeClass(cl_hide).addClass(cl_show);
				}
			});
			}
		}
	});



})(mejs.$);
