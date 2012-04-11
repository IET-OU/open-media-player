/**
* OU player: MEP postmessage feature - experimental!
* Copyright 2012 The Open University.
* Author: Nick Freear.
*/

(function($) {

$.extend(mejs.MepDefaults, {
	origin: '*',
	messagePrefix: 'OUPLAYER_MESSAGE'
});

$.extend(MediaElementPlayer.prototype, {
	buildoup_postmessage: function(player, controls, layers, media) {

		// If not in an Iframe, or no support for postMessage, return.
		//return !!window.postMessage;
		if (window.location == window.parent.location
			|| typeof window.postMessage=='undefined') return;

		var op = this.options;
		//Media + OUP events http://w3.org/TR/html5/the-iframe-element.html#mediaevents
		'play pause ended transcript_show transcript_hide'.replace(/\w+/g, 
		function(ev) {
			media.addEventListener(ev, function(mev) {
				// Security, origin / referer.
				window.parent.postMessage(op.messagePrefix+':'+mev.type, op.origin);
				$.log('OUP:message sent, '+mev.type);
			}, false);
		})
	}
});

})(mejs.$);