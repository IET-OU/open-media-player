/**
* OU player: Transcript feature.
* Copyright 2012 The Open University.
* Author: Nick Freear.
*/
(function($) {

	$.extend(mejs.MepDefaults, {
		showscriptText: 'Show script',
		hidescriptText: 'Hide script'
		, scriptId: 'oup-tscript'
	});

	// Transcript BUTTON
	$.extend(MediaElementPlayer.prototype, {
		buildoup_transcript: function(player, controls, layers, media) {
			var 
				t = this,
				op = t.options,
				//template = $('#'+ op.scriptId),
				body = $('body'),
				ts_visible = false,
				btn_script =
				// Is aria-controls appropriate for this secondary button?
				$('<div class="oup-mejs-button mejs-transcript-button mejs-show-ts" >' +
					'<button type="button" aria-controls="' + t.id + '" title="' + op.showscriptText + '"></button>' +
				'</div>')
				.appendTo(controls.group())
				.click(function(e) {
					return toggleScript(e);
				}),
				btn = btn_script.find('button'),
				btn_x = $('#'+op.scriptId+' button'),
				toggleScript = function(e) {
					if (e) e.preventDefault();

					if (ts_visible) {
						body.addClass('tscript-hide').removeClass('tscript-show');
						btn.attr('title', op.showscriptText);

						$.oup_fire(media, 'transcript_hide');
						//$(media).emit('transcript_hide', ['Custom','event']);
					} else {
						body.removeClass('tscript-hide').addClass('tscript-show');
						btn.attr('title', op.hidescriptText);

						$.oup_fire(media, 'transcript_show');
					}
					ts_visible = !ts_visible;

					return false;
				};

			/*media.addEventListener('transcript_hide',function() {
			}, false);

			media.addEventListener('transcript_show',function() {
			}, false);*/

			btn_x.click(function(e) {
				return toggleScript(e);
			});
		}
	});
	
})(mejs.$);