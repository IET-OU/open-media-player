/**
* OU player: Show the Flash fullscreen button on mouseover the Flash movie (not just mouseover the controlbar FS button).
* Internet Explorer only.
* Copyright 2012 The Open University.

Circa line (136) 198 - mep-feature-fullscreen.js

// on hover, kill the fullscreen button's HTML handling, allowing clicks down to Flash
						fullscreenBtn
							.mouseover(function() {
*/

(function ($) {

	$.extend(mejs.MepDefaults, {
		fsHoverPosX: 75,
		fsHoverPosY: 35,  //Was: -35, +17,
		fsHoverTimeout: 2500, //Was: 300~1600;
		fsHoverAltButton: false
	});

	$.extend(MediaElementPlayer.prototype, {
		buildoup_fullscreenhover: function (player, controls, layers, media) {

			var op = this.options;

			if (!player.isVideo)
				return;


			/* LtsRedmine:7911 */
			if (op.fsHoverAltButton) {
				$('body').addClass('fullscreen-alt-btn');
			}


			if (!$('body').hasClass('ua-msie') && !$('body').hasClass('br-MSIE'))
				return;

			if (typeof $.fn.jquery==='undefined' || /^1\.(0|1|2|3|4|5|6)/.test($.fn.jquery)) {
				$.log("Warning: MSIE fullscreen shim requires jQuery 1.7+ - upgrade needed.");
				return;
			}
			$.log("Fullscreen shim loading.. "+ $.fn.jquery);


			/* LtsRedmine:7911 */
			if (op.fsHoverAltButton) {
				setTimeout(function () {
					var flash = $('#me_flash_0');

					media.positionFullscreenButton(
						$(flash).width() - op.fsHoverPosX, $(flash).height() - op.fsHoverPosY, true);
				}, 500);
			}


			media.addEventListener('play', function () {

				var hideTimeout = null,
					flash = $('#me_flash_0');

				//if (! flash) return;

				/* LtsRedmine:7911 */
				if (op.fsHoverAltButton) {
					hideTimeout = setTimeout(function () {
						media.hideFullscreenButton();
					}, op.fsHoverTimeout);

					return;
				}


				//on: jQuery 1.7+ required (.mejs-container)
				$(player.container).on('mouseover', '.mejs-layer, .mejs-mediaelement', function (ev) {

					//$.log("Layer mouseover.");

					if (media.positionFullscreenButton) {

						if (hideTimeout !== null) {
							clearTimeout(hideTimeout);
							delete hideTimeout;
						}

						/* Video offset bug: [Ltsredmine:6932] */
						media.positionFullscreenButton(
							//buttonPos.left - containerPos.left, buttonPos.top - containerPos.top
							$(flash).width() - op.fsHoverPosX, $(flash).height() - op.fsHoverPosY, true);
					}
				});

				$(player.container).on('mouseout', '.mejs-layer, .mejs-mediaelement', function (ev) {

					//$.log("Layer mouseout.");

					/* (LtsRedmine:7911) */
					if (media.hideFullscreenButton && !op.fsHoverAltButton) {

						if (hideTimeout !== null) {
							clearTimeout(hideTimeout);
							delete hideTimeout;
						}

						hideTimeout = setTimeout(function () {
							media.hideFullscreenButton();
						}, op.fsHoverTimeout);
					}
				});
			}, false);



			media.addEventListener('pause', function () {
				var flash = $('#me_flash_0');

				/* LtsRedmine:7911 */
				if (op.fsHoverAltButton) {
					media.positionFullscreenButton(
						$(flash).width() - op.fsHoverPosX, $(flash).height() - op.fsHoverPosY, true);
					return;
				}

			}, false);
		}
	});

})(mejs.$);