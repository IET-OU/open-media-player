
<!--Body classes - player flags. -->
<body role="application" id="ouplayer" class="oup mtype-<?= $params->media_type ?> mode-<?= $mode ?> ctx-<?= get_class($params) ?> hide-tscript lang-<?php
  echo $this->lang->lang_code() ?> theme <?= $this->theme->name ?> <?= $this->theme->rgb ?> bg-<?= $this->theme->background ?> ua-<?= $this->agent->browser_code()
  ?> jslib-<?=$this->theme->jslib ?>">

<?php /* Body classes:
Mediaelement: "oup-mode-video tscript-hide lang-en oup_light ouvle-default-blue ua-webkit jslib-jquery width-large"

Flowplayer:  <body role="application" id="ouplayer" class=
  "oup mtype-video width-640 theme-ouice-light hide-tscript hide-captions hide-settings oup-paused lang-en -webkit ctx-Podcast_player mode-embed no-debug has-poster has-captions has-tscript has-rel-link not-private -no-docmode use-flash js"
  style="cursor: default">*/ ?>

<div id="oup-noscript">
  <p class="msg"><?=t('Your browser appears to have Javascript disabled, or there has been an error.') ?>
  <a href="<?php echo $params->media_url ?>"><?php
  echo 'video'==$params->media_type ? t('Download video file') : t('Download audio file') ?></a>
  <h1><?=$params->title ?></h1>
<?php if ($params->poster_url): ?>
  <img alt="" src="<?=$params->poster_url ?>" />
<?php endif; ?>
</div>


<?php if ('Podcast_player'==get_class($params)): ?>
<div class="oup-mejs-panel mejs-title-panel mejs-play" <?php //id="mep_0-ttl-panel" ?>>
<div class="logo"></div>
<h1 title="<?php echo json_encode_str($params->title) ?>"><?php echo json_encode_str($params->title) ?></h1>
  <?php if (isset($params->_related_url)): ?>
  <a href="<?php echo $params->_related_url ?>" target="_blank" title="<?php echo t('Related link opens in new window')
  ?><?php if ('audio'==$params->media_type): ?>: 
<?php echo json_encode_str($params->_related_text) ?><?php endif; ?>"
  ><?php echo json_encode_str($params->_related_text) ?></a>
  <?php endif; ?>
</div>
<?php endif; ?>

<?php
  // Video/ audio height.
  // (Can't use '100%' - Ender/jeesh chokes on .parent(), .width() or el.style)
  // (Mediaelement.js seems to choke on <audio.. style="height:100%"> in MSIE)
  $height_attr = 'height="360"';
  $height_style= '';

  if ('jquery' == $this->theme->jslib) {
    $height_attr = '';
    $height_style= ' height:100%';
  }
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
 <source type="<?=$params->mime_type; #video/mp4 ?>" src="<?php echo $params->media_url ?>">
<?php if ($params->caption_url): ?>
<track kind="subtitles" srclang="en" type="text/vtt" src="<?php
  // Bug #1334, VLE caption redirect bug.
  //if (FALSE === strpos($params->caption_url, '.srt')):
    echo site_url('timedtext/webvtt').'?url='. $params->caption_url;
  /*else:
    echo $params->caption_url;
  endif;/**/ ?>" />
<?php endif; ?>
<p>[Fallback]</p>
<?php if ('video'==$params->media_type): ?>
</video>
<?php else: ?>
</audio>
<?php endif; ?>


<?php if ('Podcast_player' == get_class($params)): ?>
<div id="oup-options" class="oup-options hide" role="menu" aria-label="<?=t('Player options') ?>">
  <button title="<?php echo t('Close options menu') ?>"><span>X</span></button>
<?php $this->load->theme_view('oup-options-menu') ?>
</div>
<?php endif; ?>

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
