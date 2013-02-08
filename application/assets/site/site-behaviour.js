/*
 OU Embed/Player site behaviours - especially 'ouembed-form' view.
*/
$.log = function(s){if(typeof console!=='undefined' && $.oup_site_debug){console.log(arguments.length <= 1 ? s : arguments)}};

$(document).ready(function () {

  setTimeout(function () {
    // MSIE: http://stackoverflow.com/questions/2873326/convert-html-tag-to-lowercase
    var snippet = $('#oembed-out').html(),
        snippet = snippet ? snippet.replace(/\n|=""/g, '') : '',
        src = snippet.match(/src="(.+?)"/);
    $.log(src);
    if (src) {
	  $('#static-embed span').html(' &ndash; <a class=ifr href="' + src + '" title="The iframe \'SRC\'">iframe</a>');
    }
    $('#static-embed-fm').val(snippet);
  }, 2000);

  $('#show-sharing').click(function () {
    $('#sharing').slideToggle();
  });

  function hashChange(search) {
    if (!search) search = 'sharing';
    if (document.location.hash.indexOf(search) == -1) {
    //if (e.newURL.indexOf('sharing') == -1) {
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
	.bind('focus click', function(ev){
	this.select();

    var id = ev.target.id;

	// Work around Chrome's little problem
	//preventDefault: https://bugs.webkit.org/show_bug.cgi?id=22691
	//http://stackoverflow.com/questions/5797539/jquery-select-all-text-from-a-textarea
	$('#'+id).mouseup(function(e) {
		if(typeof e.preventDefault!=='undefined'){ e.preventDefault() }
		// Prevent further mouseup intervention
	});
	$.log('Embed code selected, #' + id, ev.target);
  });
});
