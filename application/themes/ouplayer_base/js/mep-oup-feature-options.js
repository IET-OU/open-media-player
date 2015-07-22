/**
* Open Media Player: Player options menu feature.
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
				cl_off = 'mejs-off',
				cl_on = 'mejs-on',
				opts_menu = $('#'+op.optionsId),
				opts_visible = false,
				btn_options =
				// Is aria-controls appropriate for this secondary button?
				$('<div class="oup-mejs-button mejs-options-button">' +
					'<button type="button" aria-controls="' + t.id + '" title="' + op.optionsText + '"></button>' +
				'</div>')
				.appendTo(controls)
				.click(function(e) {
					return toggleOptionsMenu(e);
				})
                , btn = btn_options.find('button')
                , wrap = btn.parent()
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
						wrap.removeClass(cl_on).addClass(cl_off);
					} else {
						opts_menu.removeClass('hide').addClass('show');
						wrap.removeClass(cl_off).addClass(cl_on);
					}
					opts_visible = !opts_visible;

					return false;
				};

				btn_xo.click(toggleOptionsMenu);
		}
	});

})(mejs.$);
