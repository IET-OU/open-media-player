/**
* OU player: Quality/ resolution/ high-definition selection feature.
* Copyright 2012 The Open University.
* Author: Nick Freear.
*/
(function($) {

	$.extend(mejs.MepDefaults, {
		qualityText: 'Quality',
		qualityhighText:'High definition',
		qualitylowText: 'Standard definition'
	});

	// Quality BUTTON
	$.extend(MediaElementPlayer.prototype, {
		buildoup_quality: function(player, controls, layers, media) {

			// Audio / Android and iOS: high-definition is not relevant.
			if (!player.isVideo || mejs.MediaFeatures.hasTouch)
				return;

			var 
				t = this,
				op = t.options,
				transcript = 
				$('<div class="oup-mejs-button mejs-quality-button mejs-high-res" >' +
					'<button type="button" aria-controls="' + t.id + '" title="' + op.qualityhighText + '"></button>' +
				'</div>')
				.appendTo(controls.group())
				.click(function(e) {
					e.preventDefault();

				    alert("High definition: not yet functional!");

					return false;
				});

		}
	});
	
})(mejs.$);