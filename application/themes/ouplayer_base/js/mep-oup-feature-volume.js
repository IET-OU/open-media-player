/*
* OU player: MEP volume feature - replace volume slider with buttons etc. TODO:complete.
* Copyright 2012 The Open University.
* Author: Nick Freear.
*/
(function($) {

	$.extend(mejs.MepDefaults, {
		muteonText: 'Mute',
		// Accessibility: screen readers pronounce 'Unmute' OK.
		//+http://en.wiktionary.org/wiki/unmute
		muteoffText: 'Unmute',
		quieterText: 'Quieter',
		louderText: 'Louder',
		quieterKey: '',  //"["
		louderKey:  '',  //"]"
		volumeText: 'Volume'
		//hideVolumeOnTouchDevices: true
	});

	$.extend(MediaElementPlayer.prototype, {
		buildoup_volume: function(player, controls, layers, media) {

			$.log('Container...');
			$.log(controls.group());

			// Android and iOS don't support volume controls
			if (mejs.MediaFeatures.hasTouch && this.options.hideVolumeOnTouchDevices)
				return;


			var t = this,
				op = t.options,
				//ctr = typeof controls.group==='undefined' ? controls : controls.group,
				volume =
				$('<div class="oup-volume-widget x-mejs-button mejs-mute">'+
					'<button type="button" aria-controls="' + t.id + '" title="' + op.muteonText + '" class="oup-mute"></button>'+
					'<span class="oup-display" title="' +
					op.volumeText + '">11</span>' +
					'<button type="button" aria-controls="' + t.id + '" title="' +
					op.quieterText + '" class="oup-quieter"></button>'+
					'<button type="button" aria-controls="' + t.id + '" title="' +
					op.louderText + '" class="oup-louder"></button>'+
				'</div>')
				.appendTo(controls.group()),
			btn_mute = volume.find('.oup-mute'),
			btn_quieter = volume.find('.oup-quieter'),
			btn_louder = volume.find('.oup-louder'),
			display = volume.find('.oup-display'),

			displayVolume = function(volume) {
				var vol = Math.round( 10 * volume );
				display.html(vol);
				display.attr('title', op.volumeText+': '+vol);
			};

			btn_quieter.attr('accesskey', op.quieterKey);
			btn_louder.attr('accesskey', op.louderKey);

/*volumeSlider functionality..
			volumeSlider = mute.find('.mejs-volume-slider'),

			positionVolumeHandle = function(volume) {
			}
*/
			// MUTE button
			btn_mute.click(function() {
				media.setMuted( !media.muted );
				btn_mute.attr('title', media.muted ? op.muteoffText : op.muteonText);
			});

			btn_quieter.click(function() {
				//#1369, Flash volume is at 1 (10) prior to media loading/buffering.
				if (media.pluginType !== 'native' && 0 == media.currentTime) return;

				var v = media.volume;
				// Prevent '-1' volume and "Uncaught Error: INDEX_SIZE_ERR: DOM Exception 1" (was 0)
				if (v > 0.1) {
					media.setVolume( v - 0.1 );
				}
			});
			btn_louder.click(function() {
				var v = media.volume;
				if (v < 1) {
					media.setVolume( v + 0.1 );
				}
			});

			// listen for volume change events from other sources
			media.addEventListener('volumechange', function(e) {
				//if (!mouseIsDown) {
					if (media.muted) {
						//positionVolumeHandle(0);
						displayVolume(0);
						volume.removeClass('mejs-mute').addClass('mejs-unmute');
					} else {
						//positionVolumeHandle(media.volume);
						displayVolume(media.volume);
						volume.removeClass('mejs-unmute').addClass('mejs-mute');
					}
				//}
				$.log('oup_volumechange: '+media.volume+' | '+Math.round(10 * media.volume));
			}, false);

			if (t.container.is(':visible')) {
				// set initial volume
				displayVolume(op.startVolume);

				// shim gets the startvolume as a parameter, but we have to set it on the native <video> and <audio> elements
				if (media.pluginType === 'native') {
					media.setVolume(op.startVolume);
				}
			}
		}
	});

})(mejs.$);
