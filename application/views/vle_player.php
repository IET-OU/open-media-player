<?php
/** OUVLE player iframe.  NDF, 22 March 2011.
 *
 * @copyright Copyright 2011 The Open University.
 */

# Media: 512 x 288.
# Player:512 x 318;
  $player_height = $meta->height; #+ 30.
  $media_height = $meta->height - 60;
  $legacy_height = $meta->height - 30;
  // Hold poster image for audio-player.
  $audio_poster = null;


  $inner=$poster='';
  if ($meta->poster_url) {
    $poster = "<img class=\"poster\" alt=\"\" src=\"$meta->poster_url\" />";
  }
  if ($meta->media_html5 && 'video' == $meta->media_type) {
    $inner =<<<EOF
  <video poster="$meta->poster_url" width="$meta->width" height="$player_height" controls>
    <source src="$meta->media_url" type='video/mp4; codecs="bogus"' /><!--Was: codecs="bogus", avc1.4D401E, mp4a.40.2 -->
    $poster<div>Your browser does not support the 'video' element.</div>
  </video>
EOF;
  }
  elseif ($meta->media_html5 && 'audio' == $meta->media_type) {
	$audio_poster = $poster;
	$inner =<<<EOF
  <audio src="$meta->media_url" style="width:{$meta->width}px; height:{$meta->object_height}px;" controls>Your browser does not support the 'audio' element.</audio>
EOF;
  }
?>
<!DOCTYPE html><html lang="en"><meta charset="utf-8" /><title><?php echo $meta->title ?> | OUVLE player</title>
<!--[if lt IE 9]><?php /*http://diveintohtml5.org/semantics.html#new-elements*/ ?>

<script>
var e = ("abbr,audio,figure,time,video").split(',');
for (var i=0; i < e.length; i++){ document.createElement(e[i]); }
</script>
<![endif]-->
<style>
html,body{margin:0; padding:0; background:#ccc;}
object,img,audio,video{display:block;}
</style>
<meta name="copyright" value="&copy; 2011 The Open University" />

<?php echo $audio_poster ?>
<object tabindex="0" aria-label="Media player" type="application/x-shockwave-flash"
 width="<?php echo $meta->width ?>" height="<?php echo $meta->object_height ?>"
 data="http://learn.open.ac.uk/local/mediaplayer.swf">
 <param name="movie" value="http://learn.open.ac.uk/local/mediaplayer.swf" />
 <param name="allowfullscreen" value="true" />
 <param name="flashvars" value=
"file=<?php echo $meta->media_url ?>&amp;width=<?php echo $meta->width ?>&amp;height=<?php echo $meta->object_height ?>&amp;captions=<?php echo $meta->caption_url ?>" />
<?php echo $inner ?>

</object>
<div id="media-links" style="display:none">
  <a href="<?php echo $meta->media_url ?>">Download <?php echo $meta->title ?></a>
</div>
</html>