<?php
/* Settings and title/toolbar panels.
*/
?>

<div id="title" class="oup-title panel titletoolbar">
  <a class="ou-home" href="http://www.open.ac.uk/"><img class="logo" alt="The Open University" src="<?=site_url('assets/0.gif') ?>" height="38" width="32" /></a>
  <ul class="mediatitle">
  <li><h1><?=$meta->title ?></h1></li>
  <li><span class="summary"><?=$meta->summary ?></span>
  <?php if($meta->_related_url)echo anchor($meta->_related_url, $meta->_related_text, array('class'=>'rel-2','target'=>'_blank','title'=>t('New window'))); ?></li>
  </li></ul>

  <div class="optionalnav">
  <div class="col1">
  <button class="decreasesize" aria-label="<?=t('Decrease text size') ?>"><span>-A</span></button>
  <button class="increasesize" aria-label="<?=t('Increase text size') ?>"><span>A+</span></button>
  <button class="styleoption" aria-label="Style changer"><span><?=t('Theme') ?><?php /*<img class="styleicon" alt="Style icon" src="a6../styleicon.jpg" height="16" width="16">Style*/ ?></span></button>
  </div>
  <div class="col2">
  <button class=""><span>Option</span></button>
  <button class=""><span>Text</span></button>
  <button class=""><span>Subs</span></button>
  </div>
  <div class="col3">
  <button class=""><span>Option</span></button>
  <button class=""><span>Option</span></button>
  <button class=""><span>Option</span></button>
  </div>
  </div>
</div>

<?php
  $em_title = substr_replace($meta->title, '…', 30);
  $jq_oembed=<<<EOF
<a class="embed" href="$meta->_short_url">$em_title</a>

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.5.2/jquery.min.js"></script>
<script src="http://embed.open.ac.uk/scripts/jquery.oembed.js"></script>
<script>
$(document).ready(function(){
  $("a.embed").oembed(null,{oupodcast:{_theme:"ouice-dark"}});
});
</script>
EOF;
?>

<div id="more" class="oup-settings panel">
  <a class="help"  href="#help/TODO"  title="<?=t('New window') ?>"><span><?=t('Help') ?></span></a>
  <a class="about" href="#about/TODO" title="<?=t('New window') ?>"><span><?=t('About the player') ?></span></a>
  <?php /*<a class="embed" href="#embed-code">*/ ?><label class="embed" for="embed-code"><span><?=t('Embed code') ?></span></label></a>
  <textarea id="embed-code" readonly title="Javascript-based embed (oEmbed)"><?=str_replace('<','&lt;', $jq_oembed) ?></textarea>
  <a class="embed-opt" href="#embed/TODO"><span><?=t('More embed options') ?></span></a>
  <a class="media-url" href="<?=$meta->media_url ?>" target="_blank" title="<?=t('New window') ?>"><span><?=t('Download media') ?></span></a>
  <a class="script-pdf" href="<?=$meta->transcript_url ?>" target="_blank" title="<?=t('New window: PDF') ?>"><span><?=t('Download transcript') ?></span></a>
  <a class="short-url" rel="bookmark" href="<?=$meta->_short_url ?>" target="_blank" title="<?=t('New window: perma-link') ?>"><span><?=t('View on podcast site') ?></span></a>
</div>




