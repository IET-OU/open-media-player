<?php

  $player_url = isset($player_url) ? $player_url : site_url();

?>


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
  to embed content in <a href="<?php echo OUP_DRUPAL_URL ?>" title="Drupal 7 at the OU">OU Drupal</a>,
  <a href="<?php echo OUP_BLOG_URL ?>">Cloudworks</a> <em>(&ldquo;Add embedded content&rdquo;)</em>,
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



<div id=log >
<h2>Log</h2>
<pre id=ajax-log >[ Sorry, this URL is not supported by `jQuery-oEmbed` or a cross-domain request was made. ]</pre>

<script>
$.oup_log = function(o){if(typeof console!=='undefined'){console.log(arguments.length > 1 ? arguments : o)}};

$(document).ajaxStart(function (ev) {
  $.oup_log("Ajax start handler.", ev);
  $("#ajax-log").text("AJAX call started.\n"); //Note, .text() here, .append() below.
  $.oup_timestamp = ev.timeStamp;
});
$(document).ajaxError(function (ev, req, op, ex) {
  $.oup_log("Ajax error handler.", ev, req, op, ex);
  $("#ajax-log").append('AJAX error: "<b>' + (req.responseText ? req.responseText : 'Unknown error') + '</b>"\n');
});
$(document).ajaxComplete(function (ev, req, op) {
  var diff = ev.timeStamp - $.oup_timestamp;
  $.oup_log("Ajax complete handler.", ev, req, op, diff + 'ms');
  $("#ajax-log").append('AJAX call completed. Status: ' + req.statusText + '\n * <a href="' + op.url + '">' + op.url + '</a>\n');
});
</script>
</div>


<?php endif; ?>
