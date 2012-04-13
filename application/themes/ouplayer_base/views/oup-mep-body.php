
<!--Body classes - player flags. -->
<body role="application" id="ouplayer" class="oup-mode-<?php echo $params->media_type ?> tscript-hide lang-<?php
  echo $this->lang->lang_code() ?> <?php echo $this->theme->name ?> <?php echo $this->theme->rgb ?> ua-<?php echo $this->agent->browser_code() ?>">

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

<?php if ('video'==$params->media_type): ?>
<video
<?php else: ?>
<audio
<?php endif; ?>
 id="player1"
 x-class="mejs-player"
 x-width="640" <?php echo $height_attr ?> style="width:100%; <?php echo $height_style ?>"
 controls="controls" preload="none" <?php if ('video'==$params->media_type): ?>poster="<?php echo $params->poster_url ?>"<?php endif; ?>>
 <source type="video/mp4" src="<?php echo $params->media_url ?>">
<?php if ($params->caption_url): ?>
<track kind="subtitles" srclang="en" type="text/vtt" src="<?php
    echo site_url('timedtext/webvtt').'?url='. $params->caption_url ?>" />
<?php endif; ?>
<p>[Fallback]</p>
<?php if ('video'==$params->media_type): ?>
</video>
<?php else: ?>
</audio>
<?php endif; ?>


<div id="oup-options" class="hide">
  <button title="<?php echo t('Close options menu') ?>"><span>X</span></button>
 [ OPTIONS MENU ]
</div>

<?php
  $params->transcript_id = NULL;
  if(isset($params->transcript_html) && $params->transcript_html):
      $params->transcript_id = 'oup-tscript'; ?>
<div id="<?php echo $params->transcript_id ?>">
  <button title="<?php echo t('Hide script') ?>"><span>X</span></button>
<?php echo $params->transcript_html ?>
  <button title="<?php echo t('Hide script') ?>"><span>X</span></button>
</div>
<?php endif; ?>


</body>
