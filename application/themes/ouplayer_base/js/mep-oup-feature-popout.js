/**
* Open Media Player: Pop out player feature.
* Copyright 2012 The Open University.
* Author: Nick Freear.
*/
(function($) {

	$.extend(mejs.MepDefaults, {
		popoutText: 'Pop out player',
		popoutlabelText: 'Pop out player, opens in new window',
		popoutTarget: '_blank', //(valid browsing context name|_blank|_top)
		popoutUrl: '#',
		popoutParams: [
			'height=' + screen.height,
			'width=' + screen.width,
			//NO msie9: 'fullscreen=1',
			'resizable=1',
			'location=1',
			'toolbar=0',
			'menubar=0',
			'status=1'
		]
	});

	// Popout LINK
	$.extend(MediaElementPlayer.prototype, {
		buildoup_popout: function(player, controls, layers, media) {

			var
				t = this,
				op = t.options;

			// Android and iOS: popout player is not relevant.
			// OR, no popoutUrl..
			if (mejs.MediaFeatures.hasTouch || '#'===op.popoutUrl /*&& this.options.hideVolumeOnTouchDevices*/ )
				return;

			var
				pop_ctl =
				$('<div class="oup-mejs-link mejs-popout-link">'+
					'<a role="button" href="'+ op.popoutUrl +'" target="'+ op.popoutTarget + '" aria-controls="' + t.id + '" title="' +
					op.popoutText + '" aria-label="'+ op.popoutlabelText +'"></a>' +
				'</div>')
				.appendTo(controls)
				.click(function(e) {
					e.preventDefault();

					if('#'===op.popoutUrl) {

				    	alert("OU pop out player: missing 'popoutUrl' !");

						return false;
					}

				//TODO: Fire an event for postMessage?


					// Experimental, but seems to work in Fx, Webkit..!

					// 1. Pause the media if playing..
					var autoplay = ! media.paused;
					if (! media.paused) {
						media.pause();
					}
					// 2. Get the timestamp, format a hash '#t=31m08s'
					//http://www.mattcutts.com/blog/link-to-youtube-minute-second/
					var time = mejs.Utility.secondsToTimeCode(media.currentTime),
					  hash = '#t='+time.replace(':', 'm')+'s' + (autoplay ? '&play=1' : ''),
					  params = op.popoutParams.join(','),
					// 3. Append timestamp to 'href' attribute..
					  pop_win = window.open(op.popoutUrl + hash, op.popoutTarget, params);
					pop_win.moveTo(0, 0);
					//pop_win.resizeTo(screen.width, screen.height);

					$.log('Popout open: '+ hash, op.popoutParams);


				//TODO: catch the '#t=..' on the popout side..

					return false;
				});

		}
	});

})(mejs.$);
