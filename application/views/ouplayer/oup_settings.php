<?php
/** Settings and title/toolbar panels.
 *
 * @author Anthony McEvoy.
 * @author Nick Freear.
 */
?>

<div id="title" class="oup-title panel titletoolbar">
  <?php /*<a class="ou-home" href="http://www.open.ac.uk/"><img class="logo" alt="The Open University" src="<?=site_url('assets/0.gif') ?>" height="38" width="32" /></a>*/ ?>
  <img class="ou-home logo" alt="Open University logo" src="<?=site_url('assets/0.gif') ?>" height="38" width="32" />
  <ul class="mediatitle">
  <li><h1><?=$meta->title; /*substr_replace($meta->title, '…', 62)*/ ?></h1></li>
  <li><?php if($meta->summary): ?><span class="summary"><?=substr_replace($meta->summary, '…', 100) ?></span><?php endif; ?>
  <?php if($meta->_related_url)echo anchor($meta->_related_url, $meta->_related_text, array('class'=>'rel-2','target'=>'_blank','title'=>t('New window'))); ?></li>
  </li></ul>


<?php
  // Embed code - uses jQuery-oEmbed plugin.
  $em_title = substr_replace($meta->title, '…', 36);
  $jq_oembed=<<<EOF
<a class="embed" href="$meta->_short_url">$em_title</a>

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.5.2/jquery.min.js"></script>
<script src="http://embed.open.ac.uk/scripts/jquery.oembed.js"></script>
<script>
$(document).ready(function(){
  $("a.embed").oembed(null,{oupodcast:{_theme:"$theme"}});
});
</script>
EOF;
?>

<div role="menu" class="optionalnav" aria-label="<?=t('Player options') ?>">
  <div class="col1">
  <a class="help" href="#help/TODO"  title="<?=t('New window') ?>"><span><?=t('Player help') ?></span></a>
  <a class="about" href="#about/TODO" title="<?=t('New window') ?>"><span><?=t('About') ?></span></a>
<?php /*<button class="decreasesize" aria-label="<?=t('Decrease text size') ?>"><span>-A</span></button>
  <button class="increasesize" aria-label="<?=t('Increase text size') ?>"><span>A+</span></button>*/ ?>
  <label role="button" class="themeoption" for="theme-menu" aria-label="Style changer"><span><?=t('Theme') ?><?php /*<img class="styleicon" alt="Style icon" src="a6../styleicon.jpg" height="16" width="16">Style*/ ?></span></label>
  <select id="theme-menu" name="_theme">
    <option value="ouice-dark">OUICE Dark</option>
    <option value="ouice-bold" selected>OUICE Bold</option>
  </select>
  </div>
  <div class="col2">
  <label role="button" class="embed" for="embed-code"><span><?=t('Embed code') ?></span></label></a>
  <textarea id="embed-code" readonly title="Javascript-based embed (oEmbed)"><?=str_replace('<','&lt;', $jq_oembed) ?></textarea>
  <a class="embed-opt" href="#embed/TODO" title="<?=t('New window') ?>"><span><?=t('More embeds…') ?></span></a>
<?php /*<button class=""><span>Option</span></button>
  <button class=""><span>Text</span></button>
  <button class=""><span>Subs</span></button>*/ ?>
  </div>
  <div class="col3">
  <a class="media-url" href="<?=$meta->media_url ?>" target="_blank" title="<?=t('New window') ?>"><span><?=t('Download media') ?></span></a>
  <a class="script-pdf" href="<?=$meta->transcript_url ?>" target="_blank" title="<?=t('New window: PDF') ?>"><span><?=t('Download transcript') ?></span></a>
  <a class="short-url" rel="bookmark" href="<?=$meta->_short_url ?>" target="_blank" title="<?=t('New window: perma-link') ?>"><span><?=t('View on Podcasts') ?></span></a>
  </div>
  </div>
</div>



<div role="menu" id="more" class="oup-settings panel" aria-label="<?=t('Player options') ?>">
  <button class="more-close" title="<?=t('Close settings') ?>"><span>X</span></button>
  <a class="help" href="#help/TODO"  title="<?=t('New window') ?>"><span><?=t('Player help') ?></span></a>
  <a class="about" href="#about/TODO" title="<?=t('New window') ?>"><span><?=t('About the player') ?></span></a>
  <?php /*<a class="embed" href="#embed-code">*/ ?><label class="embed" for="embed-code"><span><?=t('Embed code') ?></span></label></a>
  <textarea id="embed-code" readonly title="Javascript-based embed (oEmbed)"><?=str_replace('<','&lt;', $jq_oembed) ?></textarea>
  <a class="embed-opt" href="#embed/TODO"><span><?=t('More embed options') ?></span></a>
  <a class="media-url" href="<?=$meta->media_url ?>" target="_blank" title="<?=t('New window') ?>"><span><?=t('Download media') ?></span></a>
  <a class="script-pdf" href="<?=$meta->transcript_url ?>" target="_blank" title="<?=t('New window: PDF') ?>"><span><?=t('Download transcript') ?></span></a>
  <a class="short-url" rel="bookmark" href="<?=$meta->_short_url ?>" target="_blank" title="<?=t('New window: perma-link') ?>"><span><?=t('View on OU podcasts') ?></span></a>
</div>


