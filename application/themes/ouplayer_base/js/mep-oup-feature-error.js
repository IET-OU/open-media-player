/**
* Open Media Player: error handler.
* Copyright 2012 The Open University.
* Author: Nick Freear.
*/
/*jslint browser: true, devel: true */
/*global mejs */

(function ($) {
	'use strict';

	$.extend(mejs.MepDefaults, {
		mediaerrorText: 'Media error',
		mediaerrorUnknown: '[unknown error]',
		// http://whatwg.org/specs/web-apps/current-work/multipage/the-video-element.html#error-codes
		MEDIA_ERR_ABORTED: "The fetching process for the media resource was aborted by the user agent at the user's request.",
		MEDIA_ERR_NETWORK: "A network error of some description caused the user agent to stop fetching the media resource, after the resource was established to be usable.",
		MEDIA_ERR_DECODE: "An error of some description occurred while decoding the media resource, after the resource was established to be usable.",
		MEDIA_ERR_SRC_NOT_SUPPORTED: "The media resource indicated by the `src` attribute was not suitable. <small>(Includes 404 'Not Found')</small>"
	});

	$.oup_error_handler = function (e, selector, player) {
		var op = player.options,
			code = -1,
			msg = op.mediaerrorUnknown,
			error = '',
			errors = [
				'MEDIA_ERR_ABORTED',
				'MEDIA_ERR_NETWORK',
				'MEDIA_ERR_DECODE',
				'MEDIA_ERR_SRC_NOT_SUPPORTED'
			];
		if ('error' === e.type) {
			code = e.target && e.target.error && e.target.error.code;
			if (code > 0 && code <= errors.length) {
				error = errors[code - 1];
				msg = op[error];
			}
			$.log(code + ' ' + msg);

			$(selector).prepend('<p class=error><em>' + op.mediaerrorText + ':</em> ' + msg + ' <small>' + error + ' [' + code + ']</small></p>');
			$(selector).removeClass('hide').addClass('show');
		}
	};

})(mejs.$);
