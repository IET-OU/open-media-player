/**
* OU player: Transcript feature.
* Copyright 2012 The Open University.
* Author: Nick Freear.
*/
(function($) {

	$.extend(mejs.MepDefaults, {
		// User testing suggests that 'Script' is more comprehensible than 'Transcript'.
		showscriptText: 'Show script',
		hidescriptText: 'Hide script',
		transcriptId: null //'oup-tscript'
	});

	// Transcript BUTTON
	$.extend(MediaElementPlayer.prototype, {
		buildoup_transcript: function(player, controls, layers, media) {
			var 
				t = this,
				op = t.options,
				tscript = $('#'+op.transcriptId);

			// Return early if no transcript is flagged.
			if (0 == tscript.length) {
				$.log('Warning: no transcript.');
				return;
			}

			var
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
				btn_x = $('#'+op.transcriptId+' button'),
				toggleScript = function(e) {
					//if (e)
					e.preventDefault();

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

			btn_x.click(toggleScript );
		}
	});
	
})(mejs.$);