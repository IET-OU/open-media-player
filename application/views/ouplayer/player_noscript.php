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
<style>body{margin:0; background:#eee; color:#222; min-width:300px; min-height:200px;} object{position:fixed; top:0; bottom:0; width:100%; height:100%} #oup-fallback_links{display:none;}</style>

<!--[if IE]>
<style>._object{height:<?=$meta->object_height ?>px;}</style>
<![endif]-->

<?php else: ?>

<div id="oup-fallback-div">
<?php endif; ?>
<object id="oup-fallback-obj" tabindex="0" aria-label="Video player" type="application/x-shockwave-flash"
 width="<?=$meta->width ?>" data-X-height="<?=$meta->object_height ?>"
 data="<?=$base_url ?>swf/flowplayer-3.2.7.swf">
 <param name="movie" value="<?=$base_url ?>swf/flowplayer-3.2.7.swf" />
 <param name="allowfullscreen" value="true" />
 <param name="allowscriptaccess" value="always" />
 <?php /*<param name="wmode" value="opaque" /><!--Important: wmode=opaque is not accessible, w/o Javascript controls!-->*/ ?>
<param name="flashvars" value='config={
<?php if ($this->config->item('debug')): ?>
"log": {"level":"debug", "filter":"org.flowplayer.captions.*"},
"debug":true,
<?php endif; ?>
"playlist":[
<?php if ('video'==$meta->media_type && $meta->poster_url): ?>
{"url":"<?=$meta->poster_url ?>"},
<?php endif; ?>
{"url":"<?=$meta->media_url ?>", "autoPlay":false, "autoBuffering":false <?php if ($meta->caption_url): ?>
,
 "captionUrl":"<?=$meta->caption_url ?>"<?php endif;?>}]
<?php /*"clip":{"url":"<?=$meta->media_url ?>", "autoPlay":false, "autoBuffering":true <?php if ($meta->caption_url): ?>
, "captionUrl":"<?=$meta->caption_url ?>"<?php endif;?>
}*/?>, "plugins":{
<?php if ($meta->caption_url): ?>
"captions":{"url":"flowplayer.captions-3.2.3.swf", "captionTarget":"content"},
"content": {
  "url":"flowplayer.content-3.2.0.swf",
<?php /*"width":"90%"<-?=($meta->width - 60) //Percent fails - why? */ ?>
  "bottom":30,
  "backgroundColor":"#000",
  "style": {
    "body":{
      "fontSize":15,
	  "textAlign":"center",
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
