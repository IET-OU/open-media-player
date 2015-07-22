/*
* Open Media Player: MEP group feature, used to group secondary controls in the controlbar for styling.
*     See, mep-oup-feature-shim.js for controls.group() function.
* Copyright 2012 The Open University.
*/
(function($) {

	$.extend(mejs.MepDefaults, {
		// Comma-separated ordered list of controls to put in the group [Bug: #38]
		groupMoveControls: null
		//groupId: 'oup-group'
	});

	$.extend(MediaElementPlayer.prototype, {
		buildoup_group: function(player, controls, layers, media) {
			var
				t = this,
				op = t.options;

      if (!op.groupMoveControls) {
				return;
			}

			var group = $('<div class="oup-group"></div>')
				.appendTo(controls);

			controls.oup_group = group;

			// Move the selected controls
			$(op.groupMoveControls).appendTo(group);

			$.log('Init controls group', op.groupMoveControls);
		}
	});

})(mejs.$);
