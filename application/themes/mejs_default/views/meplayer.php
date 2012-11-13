<?php
/**
* A basic MediaElement.js player.
*
* @author N.D.Freear, 26 July 2012.
*/

  $engine_path = 'application/engines/mediaelement/';
  $base_url = base_url() . $engine_path;

?>
<!doctype html><html lang="en"><meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1" />
<meta charset="utf-8" /><title><?php echo $params->title ?> | <?php //MediaElement ?>OU Player*</title>
<!--[if lt IE 9]>
<script src="http://html5shim.googlecode.com/svn/trunk/html5-els.js"></script>
<![endif]-->

<meta name="robots" content="noindex,nofollow" />
<link rel="generator" content="MediaElement.js" href="http://mediaelementjs.com/" />
<link rel="license" title="MediaElement.js License: GPLv2/MIT" href="https://github.com/johndyer/mediaelement#readme" />

<!--
 CDN + fallback: jQuery.
-->
<script src="<?php echo OUP_JS_CDN_JQUERY_MIN ?>"></script>
<script>
if(typeof jQuery=='undefined'){
  document.write(unescape("%3Cscript src='<?php player_res_url($this->theme->plugin_path .'jquery.js') ?>' %3E%3C/script%3E"));
  CDN_fallback = true;
}
</script>
<?php
  if ($this->config->item('debug') > OUP_DEBUG_MIN):
	foreach ($this->theme->javascripts as $js_file): ?>
<script src="<?php player_res_url($js_file) ?>"></script>
<?php
    endforeach;
  else:
?>
<script src="<?php player_res_url($this->theme->js_min) ?>"></script>
<?php endif; ?>	

<?php if ($this->config->item('debug') > OUP_DEBUG_MIN): ?>
<link rel="stylesheet" href="<?php player_res_url($engine_path . 'src/css/mediaelementplayer.css') ?>" />
<?php else: ?>
<link rel="stylesheet" href="<?php player_res_url($engine_path . 'build/mediaelementplayer.min.css') ?>" />
<?php endif; ?>

<style>
/*TODO: fix audio/video player size. */

body.mode-embed{ margin:0; background:transparent; }
body.mode-popup{ margin:0; background:#f8f8f8; }
.mejs-container{ margin:0 auto; }

.XX-mode-embed .mejs-container.mejs-audio{ position:fixed; bottom:0; }
.XX-mode-popup .mejs-container.mejs-audio{ margin-top:20px; }


/*Accessibility: allow keyboard focus. */

.mejs-controls .mejs-time-rail .mejs-time-handle{
  display:block !important;
  background:transparent;
  border:none;

  /*width:10px; height:10px; background:yellow;*/
}

.mejs-controls .mejs-time-rail:hover .mejs-time-handle,
.mejs-controls .mejs-time-rail .mejs-time-handle:focus {
  border: solid 2px #444;
  background: #f4f4f4;
}
/*-*/
</style>

<?php
  // Google/ ComScore analytics (from the legacy player).
  $this->load->view('ouplayer/oup_analytics');
?>

<body role="application" class="mode-<?php echo $mode ?>">

<?php
  // Video/ audio height. (iet-it-bugs:1414)
  // (Can't use '100%' - Ender/jeesh chokes on .parent(), .width() or el.style)
  // (Mediaelement.js seems to choke on <audio.. style="height:100%"> in MSIE)
  $size_attr = 'height="360"';
  $size_style= 'style="width:100%;"';

  if ('jquery' == $this->theme->jslib) {
    $size_attr = 'width="100%" height="100%"';
    $size_style= '';
  }
?>

<?php if ('video'==$params->media_type): ?>
<video
<?php else: ?>
<audio
<?php endif; ?>
 id="player1" <?php echo $size_attr ?> <?php echo $size_style ?>
 src="<?php echo $params->media_url ?>" type="<?php echo $params->mime_type; #video/mp4 ?>"
 controls="controls" preload="none" <?php if ('video'==$params->media_type): ?>poster="<?php echo $params->poster_url ?>"<?php endif; ?>
>
<?php if ('video'==$params->media_type): ?>
</video>
<?php else: ?>
</audio>
<?php endif; ?>

<?php /*
<!-- simple single file method -->
<video width="640" height="360" src="../media/echo-hereweare.mp4" type="video/mp4" 
	id="player1" poster="../media/echo-hereweare.jpg" 
	controls="controls" preload="none"></video>
*/ ?>

<script>
$(document).ready(function($){
  var player = new mejs.MediaElementPlayer('#player1', {

    // Keyboard accessibility: disable shortcuts!
    enableKeyboard:false,

    alwaysShowControls: true,

    // path to Flash and Silverlight plugins
    pluginPath: '<?php echo $base_url ?>build/'

  });
});
</script>

</body></html>