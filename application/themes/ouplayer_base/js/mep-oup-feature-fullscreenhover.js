/**
* OU player: Show the Flash fullscreen button on mouseover the Flash movie (not just mouseover the controlbar FS button).
* Internet Explorer only.
* Copyright 2012 The Open University.

Circa line (136) 198 - mep-feature-fullscreen.js

// on hover, kill the fullscreen button's HTML handling, allowing clicks down to Flash
						fullscreenBtn
							.mouseover(function() {
*/

(function($) {

	$.extend(MediaElementPlayer.prototype, {
		buildoup_fullscreenhover: function(player, controls, layers, media) {

			if (!player.isVideo)
				return;

			if (!$('body').hasClass('ua-msie') && !$('body').hasClass('br-Internet'))
				return;

			if (typeof $.fn.jquery==='undefined' || /^1\.(0|1|2|3|4|5|6)/.test($.fn.jquery)) {
				$.log("Warning: MSIE fullscreen shim requires jQuery 1.7+ - upgrade needed.");
				return;
			}
			$.log("Fullscreen shim loading.. "+ $.fn.jquery);

    		media.addEventListener('play', function() {

				var hideTimeout = null,
					flash = $('#me_flash_0');

				//if (! flash) return;

				//on: jQuery 1.7+ required (.mejs-container)
				$(player.container).on('mouseover', '.mejs-layer, .mejs-mediaelement', function(ev) {

					//$.log("Layer mouseover.");

					if (media.positionFullscreenButton) {

						if (hideTimeout !== null) {
							clearTimeout(hideTimeout);
							delete hideTimeout;
						}

						//var buttonPos = fullscreenBtn.offset(), containerPos = player.container.offset();

						media.positionFullscreenButton(
							//buttonPos.left - containerPos.left, buttonPos.top - containerPos.top
							$(flash).width() - 75, $(flash).height() - 35, true); //ev.offsetX..
					}
				});

				$(player.container).on('mouseout', '.mejs-layer, .mejs-mediaelement', function(ev) {

					//$.log("Layer mouseout.");

					if (media.hideFullscreenButton) {

						if (hideTimeout !== null) {
							clearTimeout(hideTimeout);
							delete hideTimeout;
						}
								
						hideTimeout = setTimeout(function() {
							media.hideFullscreenButton();
						}, 300); //1600;
					}
				});
			}, false);
		}
	});

})(mejs.$);