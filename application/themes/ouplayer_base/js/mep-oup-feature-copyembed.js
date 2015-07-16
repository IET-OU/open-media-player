/**
* Open Media Player: select/ copy embed code feature.
* Copyright 2012 The Open University.
* Author: Nick Freear, 2012-04-22.
*/
(function($) {

	$.extend(mejs.MepDefaults, {
		embedcodeId: null
	});

	$.extend(MediaElementPlayer.prototype, {
		buildoup_copyembed: function(player, controls, layers, media) {
			var
				op = this.options,
				embed = $('#'+ op.embedcodeId);

			if (! embed) {
				$.log('Warning: no embed code found');
				return;
			}

			embed.bind('focus click', function(ev){
				var el=document.getElementById(op.embedcodeId);
				//$this = $(this);
    			el.select();

			// Work around Chrome's little problem
			//preventDefault: https://bugs.webkit.org/show_bug.cgi?id=22691
			//http://stackoverflow.com/questions/5797539/jquery-select-all-text-from-a-textarea
				embed.mouseup(function(e) {
					if(typeof e.preventDefault!=='undefined'){ e.preventDefault() }
        			// Prevent further mouseup intervention
        			//embed.unbind("mouseup");
        			//return false;
    			});
				$.log('Embed code selected');
			});
		}
	});

})(mejs.$);
