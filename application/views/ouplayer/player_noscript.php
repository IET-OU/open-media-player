<?php
/** Basic no-script Flash player, with caption support. Standalone or within a <noscript> tag.
*/
$base_url = base_url();

/*, "fullscreen":"Enter fullscreen mode"*/
$flowplayer_config = array( );

if ($standalone):
?>
<!DOCTYPE html><html lang="en"><meta charset="utf-8" /><title><?=$meta->title ?> | <?=t('OU player') ?></title>
<meta name="copyright" value="&copy; 2011 The Open University" />
<style>body{margin:0; background:#bbb;} #oup-fallback_links{display:none;}</style>

<?php else: ?>

<div id="oup-fallback-div">
<?php endif; ?>
<object id="oup-fallback-obj" tabindex="0" aria-label="Video player" type="application/x-shockwave-flash"
 width="<?=$meta->width ?>" height="<?=$meta->object_height ?>"
 data="<?=$base_url ?>swf/flowplayer-3.2.7.swf">
 <param name="movie" value="<?=$base_url ?>swf/flowplayer-3.2.7.swf" />
 <param name="allowfullscreen" value="true" />
 <param name="allowscriptaccess" value="always" />
 <?php /*<param name="wmode" value="opaque" /><!--Important: wmode=opaque is not accessible, w/o Javascript controls!-->*/ ?>
<param name="flashvars" value='config={"playlist":[
{"url":"<?=$meta->poster_url ?>"},
{"url":"<?=$meta->media_url ?>", "autoPlay":false, "autoBuffering":true <?php if ($meta->caption_url): ?>
,
 "captionUrl":"<?=$meta->caption_url ?>"<?php endif;?>}]
<?php /*"clip":{"url":"<?=$meta->media_url ?>", "autoPlay":false, "autoBuffering":true <?php if ($meta->caption_url): ?>
, "captionUrl":"<?=$meta->caption_url ?>"<?php endif;?>
}*/?>, "plugins":{
<?php if ($meta->caption_url): ?>
"captions":{"url":"flowplayer.captions-3.2.3.swf", "captionTarget":"content"},
"content": {
  "url":"flowplayer.content-3.2.0.swf",
  "width":<?=($meta->width - 60) ?>,
  "bottom":30,
  "backgroundColor":"#000",
  "style": {
    "body":{
      "fontSize":15,
      "color":"#ffffff"
    }
  }
  <?php /*"width": "87%",
  "height":55,
  "backgroundColor": "#000",
  "backgroundGradient": "low",
  "border": 0,
  "borderRadius": 8,
  "textDecoration": "outline",
  "style":{
    "body":{
    "fontFamily":"Arial",
	"fontWeight":"bold",
	"fontSize":15,  
    "textAlign":"center",
	"color":"#ffffff"
    }
  }*/ ?>
},
<?php endif; ?>
"controls":{
"url":"flowplayer.controls-3.2.5.swf",
"tooltips":{
"buttons":true
}, "autoHide":false }}}' />
<?php if (isset($inner)) echo $inner; ?>
</object>
<div id="oup-fallback_links">
  <a href="<?=$meta->media_url ?>">Download <?=$meta->title ?></a>
</div>

<?php if ($standalone): ?>
</html>
<?php else: ?>
</div>
<?php endif;
