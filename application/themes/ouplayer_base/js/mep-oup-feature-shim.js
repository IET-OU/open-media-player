/**
* OU player: various shims and fixes.
* Copyright 2012 The Open University.
* Author: Nick Freear.
*/
(function($) {

	$.log = function(o){if(typeof console!=='undefined'){console.log(o)}};

	/** Fire/dispatch cross-browser native events.
	* (jQuery trigger/ ender emit/ bean fire aren't sufficient.)
	* http://stackoverflow.com/questions/2490825/how-to-trigger-event-in-javascript
	* https://developer.mozilla.org/Creating_and_triggering_custom_events
	*/
	$.oup_fire = function(el, type) { //, data) {
		var event,
			d=document;
		if (d.createEvent) {
			event = d.createEvent("Event"); //HTMLEvents.
			event.initEvent(type, true, true);
		} else {
			event = d.createEventObject();
			event.eventType = "on" + type;
		}

		if (d.createEvent) {
			el.dispatchEvent(event);
		} else if (el.fireEvent) { //MSIE: media isn't a HTMLElement :(.
			el.fireEvent(event.eventType, event);
		} else {
			//$(el).trigger();
		}
	}


	if (typeof $.ender==='undefined') {
		$.log('Using jquery.');
	} else {
		$.log('Using ender.');
	}

	$.extend(mejs.MepDefaults, {
		controlsText: 'Player controls',
		loadingText: 'loading',
		currentText: 'Current time',
		durationText: 'Total time'
		//, widthNarrow: 450
	});

	// Shims / fixes.
	$.extend(MediaElementPlayer.prototype, {
		buildoup_shim: function(player, controls, layers, media) {
			var
				t = this,
				op = t.options
				con = controls,
				track = null,
				at = 'aria-label',
				current = con.find('.mejs-currenttime'),
				duration = con.find('.mejs-duration')
				btn_cc = con.find('.mejs-captions-button button');

			con.attr(at, op.controlsText).attr('role', 'toolbar').attr('lang', op.startLanguage);
			current.attr(at, op.currentText);
			duration.attr(at, op.durationText);

			$.log(player.tracks[0]);

			btn_cc.click(function() {
				if (player.selectedTrack==null) {
					//player.captions.show();
					player.selectedTrack = track; //player.tracks[0];
					player.captions.attr('lang', track.srclang);
					player.displayCaptions();
				} else {
					player.captions.hide();
					track = player.selectedTrack;
					player.selectedTrack = null;
				}
			});

			// Get a ref. to the grouping element in the controlbar.
			controls.group = function(){
				var t = this;
				return typeof t.oup_group==='undefined' ? t : t.oup_group;
			}


			$(window).resize(function(){
				$.log('>> Resize.. 1');
			});
		}
	});

	$(document).ready(function(){
		// Set a flag for narrow/ standard width players.
		var body = $('body');
		function oup_check_size(){
			if (body.width() <= 450) {
				body.addClass('width-narrow').removeClass('width-standard');
			} else {
				body.removeClass('width-narrow').addClass('width-standard');
			}
			$.log('>> check_size, width px: '+body.width());
		};
		$(window).resize(oup_check_size);
		oup_check_size();

		//$.log(mejs.MepOptions);
	});

})(mejs.$);
