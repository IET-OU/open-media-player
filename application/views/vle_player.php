<?php
/** OUVLE player iframe.
 *
 * @copyright Copyright 2011 The Open University.
 */

# Media: 512 x 288.
# Player:512 x 318;
  $player_height = $height; #+ 30.
  $media_height = $height - 30;

  $inner=$poster='';
  if ($image_url) {
    $poster =<<<EOF
  <img alt="" src="$image_url"/>
EOF;
  }
  if ($html5 && 'video' == $media_type) {
    $inner =<<<EOF
  <video poster="$image_url" width="$width" height="$player_height" controls>
    <src src="$media_url" type='video/mp4' />
    $poster<div>Your browser does not support the 'video' element.</div>
  </video>
EOF;
  echo $inner; exit;
  }
  elseif ($html5 && 'audio' == $media_type) {
    $inner =<<<EOF
  $poster
  <audio src="$media_url" style="width:{$width}px; height:{$player_height}px;" controls>Your browser does not support the 'audio' element.</audio>
EOF;
  }
?>
<!DOCTYPE html><html lang="en" role="application"><meta charset="utf-8" /><title><?=$title ?> | OUVLE player</title>
<style>
html,body{margin:0; padding:0;}
._object{display:block; width:100%; height:100%;}
</style>
<meta name="copyright" value="&copy; 2011 The Open University" />

<object tabindex="0" aria-label="Media player" type="application/x-shockwave-flash"
 width="<?=$width ?>" height="<?=$player_height ?>"
 data="http://learn.open.ac.uk/local/mediaplayer.swf">
 <param name="movie" value="http://learn.open.ac.uk/local/mediaplayer.swf" />
 <param name="allowfullscreen" value="true" />
 <param name="flashvars" value=
"file=<?=$media_url ?>&amp;width=<?=$width ?>&amp;height=<?=$player_height ?>&amp;captions=<?=$caption_url ?>" />
<?=$inner ?>

</object>

<?=$inner ?>

<div id="media-links" style="display:none">
  <a href="<?=$media_url ?>">Download <?=$title ?></a>
</div>
</html>