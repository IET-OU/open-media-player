/**
* OU player: Pop out player feature.
* Copyright 2012 The Open University.
* Author: Nick Freear.
*/
(function($) {

	$.extend(mejs.MepDefaults, {
		popoutText: 'New window: pop out player',
		popoutTarget: '_blank', //(valid browsing context name|_blank|_top)
		popoutUrl: '#'
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
				popout = 
				$('<div class="oup-mejs-link mejs-popout-link">'+
					'<a href="'+ op.popoutUrl +'" target="'+ op.popoutTarget + '" aria-controls="' + t.id + '" title="' + op.popoutText + '"></a>' +
				'</div>')
				.appendTo(controls.group())
				.click(function(e) {

					if('#'===op.popoutUrl) {
						e.preventDefault();

				    	alert("OU pop out player: missing 'popoutUrl' !");

						return false;
					}
					//TODO: Fire an event?
				});

		}
	});
	
})(mejs.$);