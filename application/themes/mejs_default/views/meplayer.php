<?php
/**
* A basic MediaElement.js player.
*
* @author N.D.Freear, 26 July 2012.
*/

  $base_url = base_url() .'application/engines/mediaelement/';
?>
<!doctype html><html lang="en"><meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1" />
<meta charset="utf-8" /><title> | MediaElement player</title>
<!--[if lt IE 9]>
<script src="http://html5shim.googlecode.com/svn/trunk/html5-els.js"></script>
<![endif]-->

<meta name="robots" content="noindex,nofollow" />
<link rel="generator" content="MediaElement.js" href="http://mediaelementjs.com/" />
<link rel="license" title="MediaElement.js License: GPLv2/MIT" href="https://github.com/johndyer/mediaelement#readme" />

<script src="<?=$base_url ?>build/jquery.js"></script>
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

<link rel="stylesheet" href="<?=$base_url ?>build/mediaelementplayer.min.css" />

<!--TODO: fix audio/video player size. -->
<style>
body{ margin:0; background:transparent; /*#f8f8f8*/ }
</style>

<body role="application">

<?php if ('video'==$params->media_type): ?>
<video
<?php else: ?>
<audio
<?php endif; ?>
 id="player1" <?php if ('video'==$params->media_type): ?>width="640" height="360"<?php else: ?>width="380"<?php endif; ?>
 src="<?php echo $params->media_url ?>" type="<?=$params->mime_type; #video/mp4 ?>"
 controls="controls" preload="none" <?php if ('video'==$params->media_type): ?>poster="<?php echo $params->poster_url ?>"<?php endif; ?>>

<?php if ('video'==$params->media_type): ?>
</video>
<?php else: ?>
</audio>
<?php endif; ?>


<!-- simple single file method -->
<!--
<video width="640" height="360" src="../media/echo-hereweare.mp4" type="video/mp4" 
	id="player1" poster="../media/echo-hereweare.jpg" 
	controls="controls" preload="none"></video>
-->

<script>
$(document).ready(function($){
  var player = new mejs.MediaElementPlayer('#player1', { });
});
</script>

</body></html>