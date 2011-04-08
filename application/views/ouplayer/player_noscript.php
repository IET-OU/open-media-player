<?php
  $base_url = base_url();
?>

<div id="oup-fallback-div">
<object id="oup-fallback-obj" tabindex="0" aria-label="Video player" type="application/x-shockwave-flash"
 width="<?=$meta->width ?>" height="<?=$meta->object_height ?>"
 data="<?=$base_url ?>swf/flowplayer-3.2.7.swf">
 <param name="movie" value="<?=$base_url ?>swf/flowplayer-3.2.7.swf" />
 <param name="allowfullscreen" value="true" />
 <param name="allowscriptaccess" value="always" />
 <?php /*<param name="wmode" value="opaque" /><!--Important: wmode=opaque is not accessible, w/o Javascript controls!-->*/ ?>
<param name="flashvars" value='config={"playlist":[
{"url":"<?=$meta->poster_url ?>"},
{"url":"<?=$meta->media_url ?>","autoPlay":false,"autoBuffering":true}
], "plugins":{"controls":{
"url":"<?=$base_url ?>swf/flowplayer.controls-3.2.5.swf",
"tooltips":{
"buttons":true, "fullscreen":"Enter fullscreen mode"
}, "autoHide":false }}}' />
<?=$inner ?>

</object>
<div id="oup-fallback_links">
  <a href="<?=$meta->media_url ?>">Download <?=$meta->title ?></a>
</div>
</div>
