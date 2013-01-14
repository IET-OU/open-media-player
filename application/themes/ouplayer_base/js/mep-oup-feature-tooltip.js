/**
* OU player: Tooltip feature - only for keyboard ('title' attribute for mouse users) - experimental!
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
				is_mouse = false,
				tip_visible = false,
				tip = 
				$('<div class="oup-tooltip hide" role="tooltip">TIP</div>')
				//.appendTo(controls),
				.appendTo($('body')),
				toggleTip = function(ev) { //,btn)
					var tg = ev.target
					, offset = $(tg).offset()
					, body_width = $('body').width() //Ender doesn't like $(window).width()
					, left
					, offY
					;

					//if (tg.tagName!='BUTTON' || tg.tagName!='A') return;
					//$.log(ev);

					if (tip_visible) {
				  		//tip.className = 'oup-tooltip hide';
				  		tip.addClass('hide').removeClass('show');
						$.log('Tooltip hide..');
					  } else if (! is_mouse) {
						//tip.className = 'oup-tooltip show';
				  		tip.removeClass('hide').addClass('show');
				  		tip.html(tg.title);
				  		// Woops, Ender & jQuery disagree for 'top' - .height() maybe?
						offY = typeof $.ender=='undefined' ? op.tooltipOffsetY : op.tooltipOffsetY - 6; //10?
						tip.css('top', (offset.top - tip.height() - offY) +'px');
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

			$('button,.oup-mejs-link a').mouseover( function(e){
				//IF op.tooltipEvents contains 'mouseover', return
				if (op.tooltipEvents.indexOf('mouse') != -1) return;
				is_mouse = true;
			});
			$('button,.oup-mejs-link a').mouseout( function(e){
				is_mouse = false;
			});
			
		}
	});

})(mejs.$);