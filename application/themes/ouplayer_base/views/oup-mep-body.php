
<!--Body classes - player flags. -->
<body role="application" id="ouplayer" class="oup mtype-<?php echo $params->media_type ?> mode-<?php echo $mode ?> ctx-<?php echo get_class($params) ?> hide-tscript lang-<?php
  echo $this->lang->lang_code() ?> theme <?php echo $this->theme->name ?> <?php echo $this->theme->rgb ?> bg-<?php echo $this->theme->background ?> ua-<?php echo $this->agent->browser_code()
  ?> br-<?php echo $this->agent->browser() ?> p-<?php echo $this->agent->platform_code() ?> <?php
  if($this->agent->is_mobile()): ?>is<?php else: ?>not<?php endif; ?>-mobile jslib-<?php echo $this->theme->jslib ?>">

<?php /* Body classes:
Mediaelement: "oup-mode-video tscript-hide lang-en oup_light ouvle-default-blue ua-webkit p-win jslib-jquery width-large"

Flowplayer:  <body role="application" id="ouplayer" class=
  "oup mtype-video width-640 theme-ouice-light hide-tscript hide-captions hide-settings oup-paused lang-en -webkit ctx-Podcast_player mode-embed no-debug has-poster has-captions has-tscript has-rel-link not-private -no-docmode use-flash js"
  style="cursor: default">*/ ?>

<div id="oup-noscript" class="error">
  <p class="msg"><?php echo t('Sorry, your browser appears to have Javascript disabled, or there has been an error.') ?>
  <a href="<?php echo $params->media_url ?>"><?php
  echo 'video'==$params->media_type ? t('Download video file') : t('Download audio file') ?></a>
  <h1><?php echo $params->title ?></h1>
<?php if ($params->poster_url): ?>
  <img alt="" src="<?php echo $params->poster_url ?>" />
<?php endif; ?>
</div>

<div id="oup-noflash" class="error hide">
  <p class="msg"><?php echo t('Sorry, your browser does not have Adobe Flash Player installed or it has been disabled.') ?>
  <a href="<?php echo OUP_FLASH_URL ?>" target="_blank" title="<?php echo t('Opens in new window') ?>"><?php echo t('Get Adobe Flash') ?>.</a>
</div>


<?php if ('Podcast_player'==get_class($params)): ?>
<div class="oup-mejs-panel mejs-title-panel mejs-play" <?php //id="mep_0-ttl-panel" ?>>
<div class="logo"></div>
<h1 title="<?php echo html_chars($params->title) ?>"><?php echo html_chars($params->title) ?></h1>
  <?php if (isset($params->_related_url)): ?>
  <a href="<?php echo $params->_related_url ?>" target="_blank" title="<?php echo t('Related link opens in new window')
  ?><?php if ('audio'==$params->media_type): ?>: 
<?php echo html_chars($params->_related_text) ?><?php endif; ?>"
  ><?php echo html_chars($params->_related_text) ?></a>
  <?php endif; ?>
</div>
<?php endif; ?>

<?php
  // Video/ audio height.
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
 id="player1"
 x-class="mejs-player"
 <?php echo $size_attr ?> <?php echo $size_style ?>
 controls="controls" preload="none" <?php if ('video'==$params->media_type): ?>poster="<?php echo $params->poster_url ?>"<?php endif; ?>>
 <source type="<?php echo $params->mime_type; #video/mp4 ?>" src="<?php echo $params->media_url ?>">
<?php if ($params->caption_url): ?>
<track kind="subtitles" srclang="en" type="text/vtt" src="<?php
  // Bug #1334, VLE caption redirect bug [iet-it-bugs:1477] [ltsredmine:6937]
  echo $_caption_url ?>" />
<?php endif; ?>
<p>[Fallback]</p>
<?php if ('video'==$params->media_type): ?>
</video>
<?php else: ?>
</audio>
<?php endif; ?>


<?php if ('Podcast_player' == get_class($params)): ?>
<div id="oup-options" class="oup-options hide" role="menu" aria-label="<?php echo t('Player options') ?>">
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


<div id="oup-pauser"></div>
</body>
