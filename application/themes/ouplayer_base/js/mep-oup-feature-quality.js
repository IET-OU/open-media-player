/**
* OU player: Quality/ resolution/ high-definition selection feature.
* Copyright 2012 The Open University.
* Author: Nick Freear.
*/
(function($) {

	$.extend(mejs.MepDefaults, {
		qualityText: 'Quality selection/ High definition'
	});

	// Quality BUTTON
	$.extend(MediaElementPlayer.prototype, {
		buildoup_quality: function(player, controls, layers, media) {
			var 
				t = this,
				transcript = 
				$('<div class="oup-mejs-button mejs-quality-button mejs-high-res" >' +
					'<button type="button" aria-controls="' + t.id + '" title="' + t.options.qualityText + '"></button>' +
				'</div>')
				.appendTo(controls.group())
				.click(function(e) {
					e.preventDefault();

				    alert("Quality/ high definition: not yet functional!");

					return false;
				});

		}
	});
	
})(mejs.$);