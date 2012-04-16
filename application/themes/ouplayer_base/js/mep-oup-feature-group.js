/*
* OU player: MEP group feature, used to group secondary controls in the controlbar for styling.
*     See, mep-oup-feature-shim.js for controls.group() function.
* Copyright 2012 The Open University.
*/
(function($) {

	/*$.extend(mejs.MepDefaults, {
		groupId: 'oup-group'
	});*/

	//
	$.extend(MediaElementPlayer.prototype, {
		buildoup_group: function(player, controls, layers, media) {
			var 
				//t = this,
				group = $('<div class="oup-group">'+'</div>')
				.appendTo(controls);

			controls.oup_group = group;

			$.log('Init. controls group');
		}
	});

})(mejs.$);