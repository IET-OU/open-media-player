/**
* OU player: Player options menu feature.
* Copyright 2012 The Open University.
*/
(function($) {

	$.extend(mejs.MepDefaults, {
		optionsText: 'More options&hellip;',
		//hideoptionsText: 'Hide options',
		optionsId: 'oup-options'
	});

	// Options BUTTON
	$.extend(MediaElementPlayer.prototype, {
		buildoup_options: function(player, controls, layers, media) {
			var 
				t = this,
				op = t.options,
				opts_menu = $('#'+op.optionsId),
				opts_visible = false,
				btn_options =
				// Is aria-controls appropriate for this secondary button?
				$('<div class="oup-mejs-button mejs-options-button">' +
					'<button type="button" aria-controls="' + t.id + '" title="' + op.optionsText + '"></button>' +
				'</div>')
				.appendTo(controls.group())
				.click(function(e) {
					return toggleOptionsMenu(e);
				})
				, btn_xo = $('#'+op.optionsId+' button')
				/*.bind('mouseover', function(e) { //mouseenter.
					opts_visible = false;
					return toggleOptionsMenu(e);
				})
				.bind('mouseout', function(e) { //mouseleave.
					return toggleOptionsMenu(e);
				})*/;

				function toggleOptionsMenu(e) {
					e.preventDefault();

					if (opts_visible) {
						opts_menu.addClass('hide').removeClass('show');
					} else {
						opts_menu.removeClass('hide').addClass('show');
					}
					opts_visible = !opts_visible;

					return false;
				};

				btn_xo.click(toggleOptionsMenu);
		}
	});
	
})(mejs.$);