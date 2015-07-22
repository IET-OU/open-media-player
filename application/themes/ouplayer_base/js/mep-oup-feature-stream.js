/**
* Open Media Player: stream-indicator feature.
* Copyright 2015 The Open University.
* Author: Nick Freear.
*/
(function($) {

	$.extend(mejs.MepDefaults, {
		streamText: 'Live'
	});

	// Stream indicator
	$.extend(MediaElementPlayer.prototype, {
		buildoup_stream: function(player, controls, layers, media) {

			// Only YouTube?
			//if (!player.isVideo) return;

			var
				t = this,
				op = t.options,
				stream_indicator =
				$('<div class="oup-mejs-stream oup-widget"><i></i>' + op.streamText + '</div>')
				.appendTo(controls)
			;
		}
	});

})(mejs.$);
