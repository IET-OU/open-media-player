/**
* OU player: MEP tooltip feature - experimental!
* Copyright 2012 The Open University.
* Author: Nick Freear, 12 march,16 april 2012.
*/

(function($) {

	$.extend(mejs.MepDefaults, {
		// Offset: 2 x padding + 2 x border.
		tooltipOffsetX: 6, //8
		tooltipOffsetY: 2,
		tooltipEvents: 'focus blur' //'mouseover mouseout focus blur'
	});

	$.extend(MediaElementPlayer.prototype, {
		buildoup_tooltip: function(player, controls, layers, media) {
			var 
				t = this,
				op = t.options,
				tip_visible = false,
				tip = 
				$('<div class="oup-tooltip hide" role="tooltip">TIP</div>')
				.appendTo(controls),
				toggleTip = function(ev) { //,btn)
					var tg = ev.target
					, offset = $(tg).offset()
					, body_width = $('body').width() //Ender doesn't like $(window).width()
					, left
					;

					//if (tg.tagName!='BUTTON' || tg.tagName!='A') return;
					//$.log(ev);

					if (tip_visible) {
				  		//tip.className = 'oup-tooltip hide';
				  		tip.addClass('hide').removeClass('show');
						$.log('Tooltip hide..');
					  } else {
						//tip.className = 'oup-tooltip show';
				  		tip.removeClass('hide').addClass('show');
				  		tip.html(tg.title);
						tip.css('top', (offset.top - tip.height() - op.tooltipOffsetY) +'px');
						left = offset.left;
						if (left + tip.width() >= body_width) {
							left = body_width - tip.width() - op.tooltipOffsetX;
						}
						tip.css('left', left +'px');

						$.log('Tooltip show..')
					  }
					  tip_visible = ! tip_visible;

					return false;
				}
				, buttons = controls.find('button')
				;

			if (! op.tooltipEvents) return;


			$('button,.oup-mejs-link a').bind(op.tooltipEvents, function(e){
				toggleTip(e);
			});
			
		}
	});

})(mejs.$);