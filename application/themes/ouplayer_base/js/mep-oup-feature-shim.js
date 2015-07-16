/**
* Open Media Player: various shims and fixes.
* Copyright 2012 The Open University.
* Author: Nick Freear.
*/
(function ($) {

	/*$.log = function (s) {if (typeof console === 'object' && $.oup_debug) {console.log(arguments.length <= 1 ? s : arguments); } }*/

	/** Fire/dispatch cross-browser native events.
	* (jQuery trigger/ ender emit/ bean fire aren't sufficient.)
	* http://stackoverflow.com/questions/2490825/how-to-trigger-event-in-javascript
	* https://developer.mozilla.org/Creating_and_triggering_custom_events
	*/
	$.oup_fire = function (el, type) { //, data) {
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


	if (typeof $.ender === 'undefined') {
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
		buildoup_shim: function (player, controls, layers, media) {
			var
				t = this,
				op = t.options,
				body = $('body'),
				con = controls,
				track = null,
				reset = 0,
				at = 'aria-label',
				cl_progress = 'in-progress',
				cl_nop  = 'no-progress',
				current = con.find('.mejs-currenttime'),
				duration = con.find('.mejs-duration');

			con.attr(at, op.controlsText).attr('role', 'toolbar').attr('lang', op.startLanguage);
			current.attr(at, op.currentText);
			duration.attr(at, op.durationText);

			// Get a ref. to the grouping element in the controlbar.
			controls.group = function () {
				var t = this;
				return typeof t.oup_group==='undefined' ? t : t.oup_group;
			}


			// Reset current time at 'ended' - Video/ MSIE(8), http://ltsredmine.open.ac.uk/issues/6987
			media.addEventListener('loadedmetadata', function (e) {
				$.log(">> loadedmetadata", e);

				// Also, set a flag to say if playback is in progress [Ltsredmine:6912].
				body.removeClass(cl_nop).addClass(cl_progress);

				if (typeof e.ended !== 'undefined' && e.ended) {
					// Is this a fix for Flash?
					t.media.currentTime = 0;
					t.updateCurrent();

					body.removeClass(cl_progress).addClass(cl_nop);

					reset++;
				}

			}, false);

			media.addEventListener('play', function (e) {
				reset++;

				if (t.media.currentTime > 0 || reset < 2) {
					return;
				}

				$.log(">> (re-)play", e);

				// Set a flag to say if playback is in progress [Ltsredmine:6912].
				body.removeClass(cl_nop).addClass(cl_progress);

			}, false);

			// Reset current time at 'ended' - Audio/ MSIE(8) [Ltsredmine:6987], http://ltsredmine.open.ac.uk/issues/6987
			media.addEventListener('ended', function (e) {
				$.log(">> ended", e);

				// Is this a fix for Flash?
				t.media.currentTime = reset = 0;
				t.updateCurrent();

				body.removeClass(cl_progress).addClass(cl_nop);

			}, false);

			body.removeClass(cl_progress).addClass(cl_nop);
		}
	});

	$(document).ready(function () {
		// Set a flag for narrow/ standard/ wide players (POPUP = wide).
		var body = $('body'),
			small = 'width-small',
			medium = 'width-medium',
			large = 'width-large';

		function oup_check_size() {
			if (body.width() <= 450) {
				body.addClass(small).removeClass(medium).removeClass(large);
			} else if (body.width() >= 720) {
				body.removeClass(small).removeClass(medium).addClass(large);
			} else {
				body.removeClass(small).addClass(medium).removeClass(large);
			}
			$.log('>> check_size, width px: '+body.width());
		};
		$(window).resize(oup_check_size);
		oup_check_size();

		//$.log(mejs.MepOptions);
	});

})(mejs.$);
