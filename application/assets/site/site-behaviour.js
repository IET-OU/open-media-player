/*
 OU Embed/Player site behaviours - especially 'ouembed-form' view.
*/

(function ($) {
  $.log = function (s) {
    if (typeof console !== 'undefined' && $.oup_site_debug) {
      console.log(arguments.length <= 1 ? s : arguments);
    }
  };
})(window.jQuery);

window.jQuery(function ($) {
  'use strict';

  setTimeout(function () {
    // MSIE: http://stackoverflow.com/questions/2873326/convert-html-tag-to-lowercase
    var snippet = $('#oembed-out').html();
    snippet = snippet ? snippet.replace(/\n|=""/g, '') : '';
    var mSrc = snippet.match(/src="(.+?)"/);

    $.log(mSrc);

    if (mSrc) {
      $('#static-embed span').html(' &ndash; <a class=ifr href="' + mSrc[ 1 ] + '" title="The iframe \'SRC\'">iframe</a>');
    }

    $('#static-embed-fm').val(snippet);
  }, 2000);

  $('#show-sharing').click(function () {
    $('#sharing').slideToggle();
  });

  function hashChange (search) {
    if (!search) search = 'sharing';
    if (document.location.hash.indexOf(search) === -1) {
    // if (e.newURL.indexOf('sharing') == -1) {
      $('#' + search).hide();
    } else {
      $('#' + search).show();
    }
  }
  // See: http://stackoverflow.com/questions/3090478/jquery-hash-change-event
  $(window).bind('hashchange', function (e) {
    hashChange();
  });
  hashChange();

  // "Select all".
  // https://github.com/IET-OU/ouplayer/blob/master/application/themes/ouplayer_base/js/mep-oup-feature-copyembed.js
  $('.copy-fm')
    .attr('title', 'Copy me!')
  .bind('focus click', function (ev) {
    this.select();

    var id = ev.target.id;

  // Work around Chrome's little problem
  // preventDefault: https://bugs.webkit.org/show_bug.cgi?id=22691
  // http://stackoverflow.com/questions/5797539/jquery-select-all-text-from-a-textarea
    $('#' + id).mouseup(function (e) {
      if (typeof e.preventDefault !== 'undefined') { e.preventDefault(); }
      // Prevent further mouseup intervention
    });

    $.log('Embed code selected, #' + id, ev.target);
  });
});

window.jQuery(function ($) {
  var panel = $('#ajax-log');

  if (typeof $(document).ajaxStart !== 'function') {
    return;
  }

  $(document).ajaxStart(function (ev) {
    $.oup_site_debug = true;

    $.log('Ajax start handler.', ev);
    panel.text('AJAX call started.\n'); // Note, .text() here, .append() below.
    $.oup_timestamp = ev.timeStamp;
  });

  $(document).ajaxError(function (ev, req, op, ex) {
    $.log('Ajax error handler.', ev, req, op, ex);

    panel.append('AJAX error: "<b>' + (req.responseText ? req.responseText : 'Unknown error') + '</b>"\n');
  });

  $(document).ajaxComplete(function (ev, req, op) {
    var diff = ev.timeStamp - $.oup_timestamp;
    $.log('Ajax complete handler.', ev, req, op, diff + 'ms');

    panel.append('AJAX call completed. Status: ' + req.statusText + '\n * <a href="' + op.url + '">' + op.url + '</a>\n');

    if (req.status === 200) {
      var json = jsonPrettyPrint(req.responseText);
      panel.append(' * oEmbed response:' + json.replace(/</g, '&lt;'));
    }
  });

  $(document).ajaxSuccess(function (r) {
    $.log('Ajax success.');
  });

  function jsonPrettyPrint (json) {
    // Convert JSON-P.
    json = json.replace(/^[^(]+\(\{/, '{').replace(/\}\);?$/, '}');
    // Add line breaks.
    json = json.replace(/\{"/g, ' {\n"').replace(/\}/g, '\n}').replace(/:/g, ': ');
    return json;
  }

  // .
});
