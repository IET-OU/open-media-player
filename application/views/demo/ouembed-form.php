<?php

  $player_url = isset($player_url) ? $player_url : site_url();

?>
<style>
h2{ margin-top:1.2em; }
input, textarea{ max-width:99%; }
textarea, #share-link-fm{ width:97%; }
.ouembed-form{ font-size:1.05em; }
.ouembed-form input, #share-link-fm{ font-size:1.2em; padding:.6em 4px; background:#ddd; color:#333; border:1px solid #d0d0d0; margin:0; }
input#url{ background:#f8f8f8; border-right-width:0 }
input[type=submit]{ cursor:pointer; padding:.6em; }
.X-ouembed-form .reset:before { position:relative; top:35px; left:-3em; }
.ouembed-form input[type=submit]:hover{ background:#e8e8e8; }
#examples li{ margin:3px 0; width:60%; white-space:nowrap; overflow: hidden; text-overflow:ellipsis; /*#1388, truncate too-long titles..*/ }
#X-oembed-out{ margin:1em auto; x-resize:both; x-overflow:auto; }
textarea, #oembed-out, #share-link-fm{ background:#f8f8f8; border:1px solid #ccc; padding:6px; }

input#url:focus, textarea:focus{ box-shadow:0 0 25px #c0c0c0; background:#fff; }
#oembed-out:hover, textarea:hover, #share-link-fm:hover{ background:#fff; }
#X-oembed-js-fm{ white-space:nowrap; overflow:hidden; }
#show-sharing{ margin:1.6em 0; padding:.5em; font-size:1.1em; }
#X-static-embed .ifr:before{content:'('}

.copy-fm{ cursor:pointer; }
</style>


<p id=page-nav role="navigation"><a href="#examples">Example URLs</a> &darr; <a href="#preview">Preview</a> &darr; <a href="#show-sharing">Sharing options</a></p>


<div class=ouembed-form>

<form id=form>
  <p><label for=url >URL to embed</label> &ndash; <a class=reset href="?" title="Reset form &crarr;">reset</a>
  <p><input id=url name=url type=url required value="<?php echo $url ?>" size=85 maxlength=140 placeholder="<?php echo array_pop(array_slice($examples, 0, 1)) ?>"
  /><input type=submit value="Embed" />
</form>

<div id=examples >
<p>Example URLs to try:
<ul>
<?php foreach ($examples as $example_name => $example_url): ?>
  <li><a href="?url=<?php echo urlencode($example_url) ?>"
    title="<?php echo $example_name ?>" data-url_chars="<?php echo strlen($example_url) ?>"
    ><?php echo $example_url ?></a>
<?php endforeach; ?>
</ul>
</div>
</div>


<?php if ($url): ?>
<h2 id=preview >Preview</h2>
<div id=oembed-out >
<a class=embed href="<?php echo $url ?>"><?php echo $url ?></a>
</div>
<?php endif; ?>


<?php if ($url): ?>
<p><button id=show-sharing >Show/ hide sharing options</button>
<div id=sharing >
<h2>Sharing and embedding</h2>
You have three options to share this content: <ol>
<li id=share-link >
<p><label for=share-link-fm >Use this <a class=orig href="<?php echo $drupal_safe_url ?>" title="Original URL">URL</a>
  to embed content in <a href="http://www.open.ac.uk/wikis/drupal/" title="Drupal 7 at the OU">OU Drupal</a>,
  <a href="http://cloudworks.ac.uk/tag/view/oembed">Cloudworks</a> <em>(&ldquo;Add embedded content&rdquo;)</em>,
  <a href="http://codex.wordpress.org/Embeds">Wordpress</a> and in emails:</label>
<p><input id=share-link-fm class=copy-fm value="<?php echo $drupal_safe_url ?>" size=85 readonly />
</li>


<li id=static-embed >
<p><label for=static-embed-fm >The static embed code, for other blogs and content managment systems <span></span>:</label>
<p><textarea id=static-embed-fm class=copy-fm cols=95 rows=6 readonly ></textarea>
</li>


<li id=oembed-js >
<?php ob_start() ?>
<a class="embed" href="<?php echo $url ?>">My embed<?php #echo $url ?></a>

<script src="<?php echo OUP_JS_CDN_JQUERY_MIN ?>"></script>
<script src="<?php echo $player_url .'scripts/jquery.oembed.js' ?>"></script>
<script>
$(document).ready(function() {
&nbsp; $("a.embed").oembed(<?php #null, { "maxwidth": 800 } ?>);
});
</script><?php
    $jquery_oembed = ob_get_clean();
?>
<p><label for=oembed-js-fm >Developers, quickly integrate embedding in any Web app. using <a class=js href="<?php echo $player_url .'scripts/jquery.oembed.js' ?>">jQuery-oEmbed</a>:</label>
<p><textarea id=oembed-js-fm class=copy-fm cols=95 rows=9 readonly ><?php echo str_replace('<', '&lt;', $jquery_oembed) ?></textarea>
</li>
</ol>
<p class=oembed-api >[ <a href="<?php echo $player_url. 'oembed' ?>?format=json&amp;url=<?php echo urlencode($url) ?>">JSON oEmbed</a>
 | <a rel=help href="http://oembed.com/">What is oEmbed?</a> ]
</div>


<script>
$.log = function(ob){if(typeof console!=='undefined'){console.log(arguments)}};

$(document).ready(function () {
  setTimeout(function () {
    // MSIE: http://stackoverflow.com/questions/2873326/convert-html-tag-to-lowercase
    var snippet = $('#oembed-out').html().replace(/\n|=""/g, ''),
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
</script>
<?php endif; ?>
