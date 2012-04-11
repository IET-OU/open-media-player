
<!--Body classes - player flags. -->
<body class="oup-mode-<?php echo ($params->is_video) ? 'video' : 'audio' ?> tscript-hide lang-<?php
  echo $params->lang ?> <?php echo $params->skin ?> <?php echo $params->rgb ?> <?php echo $params->ua ?>">

<div id="oup-noscript">
Your browser appears to have Javascript disabled, or there has been an error.
<a href="<?php echo $params->media_url ?>">Download audio/video file.</a>
</div>

<?php
  // Video/ audio height.
  // (Can't use '100%' - Ender/jeesh chokes on .parent(), .width() or el.style)
  // (Mediaelement.js seems to choke on <audio.. style="height:100%"> in MSIE)
  $height_attr = 'height="360"';
  $height_style= '';  #' height:100%';
?>

<?php if ($params->is_video): ?>
<video
<?php else: ?>
<audio
<?php endif; ?>
 id="player1"
 x-class="mejs-player"
 x-width="640" <?php echo $height_attr ?> style="width:100%; <?php echo $height_style ?>"
 controls="controls" preload="none" <?php if ($params->is_video): ?>poster="<?php echo $params->poster_url ?>"<?php endif; ?>>
 <source type="video/mp4" src="<?php echo $params->media_url ?>">
<?php if ($params->caption_url): ?>
<track kind="subtitles" srclang="en" type="text/vtt" src="<?php
    echo $params->caption_url ?>" />
<?php endif; ?>
<p>[Fallback]</p>
<?php if ($params->is_video): ?>
</video>
<?php else: ?>
</audio>
<?php endif; ?>


<div id="oup-options" class="hide">
  <button title="<?php echo t('Close options menu') ?>"><span>X</span></button>
 [ OPTIONS MENU ]
</div>

<div id="oup-tscript">
  <button title="<?php echo t('Hide script') ?>"><span>X</span></button>
 [ TRANSCRIPT ]
</div>


</body>
