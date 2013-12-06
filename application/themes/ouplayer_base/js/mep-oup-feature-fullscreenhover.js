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
		fsHoverPosX: 85,  //Was: 75,
		fsHoverPosY: 17,  //Popup:30; Embed:20; Was: -35, +17,
		fsHoverTimeout: 2500, //Was: 300~1600;
		fsHoverAltButton: false
	});

	$.extend(MediaElementPlayer.prototype, {
		buildoup_fullscreenhover: function (player, controls, layers, media) {

			var op = this.options,
				hideTimeout;

			if (!player.isVideo)
				return;


			/* LtsRedmine:7911 */
			if (op.fsHoverAltButton === true) {
				$('body').addClass('fullscreen-alt-btn');
			}
			else if (typeof op.fsHoverAltButton === 'string') {
				$('body').addClass('fullscreen-alt-btn-' + op.fsHoverAltButton);
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
					myPositionFullscreenButton();
				}, 500);
			}


			media.addEventListener('play', function () {

				//if (! flash) return;

				/* LtsRedmine:7911 */
				if (op.fsHoverAltButton) {

					myClearTimeout();

					hideTimeout = setTimeout(function () {
						media.hideFullscreenButton();
					}, op.fsHoverTimeout);

					//Was: return;
				}


				//on: jQuery 1.7+ required (.mejs-container)
				$(player.container).on('mouseover', '.mejs-layer, .mejs-mediaelement', function (ev) {

					//$.log("Layer mouseover.");

					if (media.positionFullscreenButton) {

						myClearTimeout();

						/* Video offset bug: [Ltsredmine:6932] */
						myPositionFullscreenButton();
					}
				});

				$(player.container).on('mouseout', '.mejs-layer, .mejs-mediaelement', function (ev) {

					//$.log("Layer mouseout.");

					/* (LtsRedmine:7911) */
					if (media.hideFullscreenButton) { //Was: && !op.fsHoverAltButton) {

						myClearTimeout();

						hideTimeout = setTimeout(function () {
							media.hideFullscreenButton();
						}, op.fsHoverTimeout);
					}
				});
			}, false);



			media.addEventListener('pause', function () {

				myClearTimeout();

				/* LtsRedmine:7911 */
				if (op.fsHoverAltButton) {
					myPositionFullscreenButton();
				}

			}, false);



			function myPositionFullscreenButton() {
				var flash = $('#me_flash_0');

				/* Video offset bug: [Ltsredmine:6932] */
				media.positionFullscreenButton(
					//buttonPos.left - containerPos.left, buttonPos.top - containerPos.top
					flash.width() - op.fsHoverPosX, flash.height() - op.fsHoverPosY, true);
			}

			function myClearTimeout() {
				if (hideTimeout !== null) {
					clearTimeout(hideTimeout);
					delete hideTimeout;
				}
			}
		}
	});

})(mejs.$);