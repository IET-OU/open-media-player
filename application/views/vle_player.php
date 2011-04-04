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

  $inner=$poster='';
  if ($meta->image_url) {
    $poster = "<img alt=\"\" src=\"$meta->image_url\" />";
EOF;
  }
  if ($meta->html5 && 'video' == $meta->media_type) {
    $inner =<<<EOF
  <video poster="$meta->image_url" width="$meta->width" height="$player_height" controls>
    <source src="$meta->media_url" type='video/mp4; codecs="bogus"' /><!--Was: codecs="bogus", avc1.4D401E, mp4a.40.2 -->
    $poster<div>Your browser does not support the 'video' element.</div>
  </video>
EOF;
  }
  elseif ($meta->html5 && 'audio' == $meta->media_type) {
    $inner =<<<EOF
  $poster
  <audio src="$meta->media_url" style="width:{$meta->width}px; height:{$player_height}px;" controls>Your browser does not support the 'audio' element.</audio>
EOF;
  }
?>
<!DOCTYPE html><html lang="en" role="application"><meta charset="utf-8" /><title><?=$meta->title ?> | OUVLE player</title>
<style>
html,body{margin:0; padding:0; background:#ccc;}
._object{display:block; width:100%; height:100%;}
</style>
<meta name="copyright" value="&copy; 2011 The Open University" />


<object tabindex="0" aria-label="Media player" type="application/x-shockwave-flash"
 width="<?=$meta->width ?>" height="<?=$legacy_height ?>"
 data="http://learn.open.ac.uk/local/mediaplayer.swf">
 <param name="movie" value="http://learn.open.ac.uk/local/mediaplayer.swf" />
 <param name="allowfullscreen" value="true" />
 <param name="flashvars" value=
"file=<?=$meta->media_url ?>&amp;width=<?=$meta->width ?>&amp;height=<?=$legacy_height ?>&amp;captions=<?=$meta->caption_url ?>" />
<?=$inner ?>

</object>
<div id="media-links" style="display:none">
  <a href="<?=$meta->media_url ?>">Download <?=$meta->title ?></a>
</div>
</html>