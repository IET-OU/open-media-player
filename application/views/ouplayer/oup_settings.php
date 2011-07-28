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
  <?php if (isset($meta->_access['intranet_only']) && 'Y'==$meta->_access['intranet_only']): ?>
  <li class="restrict-text"><?=t('Staff/student access only') ?></li>
  <?php endif; ?>
  <li><?php /*if($meta->summary): ?><span class="summary"><?=substr_replace($meta->summary, '…', 95) ?></span><?php endif;*/ ?>
  <?php if(isset($meta->_related_url) && $meta->_related_url){
    #$rel_text = 'video'==$meta->media_type ? $meta->_related_text : substr_replace($meta->_related_text, '…', 55);
    echo anchor($meta->_related_url, $meta->_related_text, array('class'=>'rel-2','target'=>'_blank','title'=>t('New window')));
  } ?></li>
  </ul>


<?php
// Embed code - uses jQuery-oEmbed plugin or Iframe.
$embed_code=null;
if ('Vle_player'!=get_class($meta)): #('podcast'==$context)
  $em_title = substr_replace($meta->title, '…', 36);
  $copy_text = t('Copy and paste');
  if (isset($meta->_short_url)) {
    $param_theme = OUP_PARAM_THEME;
    $jq_plugin_url = site_url('scripts/jquery.oembed.js');
    $embed_method = t('Javascript-based embed (oEmbed)');
    $embed_code = <<<EOF
<!--$copy_text--><a class="embed" href="$meta->_short_url">$em_title</a>

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.5.2/jquery.min.js"></script>
<script src="$jq_plugin_url"></script>
<script>
$(document).ready(function(){
$("a.embed").oembed(null,{oupodcast:{{$param_theme}:"$theme->name"}});
});
</script>
EOF;
  } else {
    $embed_method = t('Iframe-based embed');
	$embed_label = t('OU player');
    $embed_url = current_url().'?'.$this->input->server('QUERY_STRING');
    $embed_url = str_replace('/popup/', '/embed/', $embed_url);
    $embed_code = <<<EOF
<!--$copy_text--><iframe class="ouplayer $meta->media_type" title="$embed_label" width=640 height=410 src=
"$embed_url"
></iframe>
EOF;
  }
endif;
?>

<?php
// Help/ about links.
$docs = $this->config->item('player_docs');
$help_url = isset($docs['help']) ? $docs['help'] : '#help/TODO';
$about_url= isset($docs['about'])? $docs['about']: '#about/TODO';
$embedopts_url = isset($docs['embed']) ? $docs['embed'] : '#embed/TODO';
?>


<div role="menu" class="optionalnav" aria-label="<?=t('Player options') ?>">
  <div class="col1">
  <a rel="help" class="help" href="#help/TODO"  title="<?=t('New window') ?>"><span><?=t('Player help') ?></span></a>
  <a class="about" href="#about/TODO" title="<?=t('New window') ?>"><span><?=t('About') ?></span></a>
<?php /*<button class="decreasesize" aria-label="<?=t('Decrease text size') ?>"><span>-A</span></button>
  <button class="increasesize" aria-label="<?=t('Increase text size') ?>"><span>A+</span></button>*/ ?>
  <label role="button" class="themeoption" for="theme-menu" title="<?=t('Choose the theme') ?>"><span><?=t('Theme') ?><?php /*<img class="styleicon" alt="Style icon" src="a6../styleicon.jpg" height="16" width="16">Style*/ ?></span></label>
  <select id="theme-menu" name="<?=OUP_PARAM_THEME ?>">
    <option value="ouice-dark">OUICE Dark</option>
    <option value="ouice-bold" selected>OUICE Bold</option>
  </select>
  </div>
  <div class="col2">
<?php if ($embed_code): ?>
  <label role="button" class="embed" for="embed-code" title="<?=t('Embed on other sites') ?>"><span><?=t('Embed code') ?></span></label></a>
  <textarea id="embed-code" class="emcode-opt" readonly title="<?=$embed_method ?>"><?=str_replace('<','&lt;', $embed_code) ?></textarea>
  <a class="embed-opt" href="#embed/TODO" title="<?=t('New window') ?>"><span><?=t('More embeds…') ?></span></a>
<?php endif; ?>
<?php /*<button class=""><span>Option</span></button>
  <button class=""><span>Text</span></button>
  <button class=""><span>Subs</span></button>*/ ?>
  </div>
  <div class="col3">
  <a class="media-url" href="<?=$meta->media_url ?>" target="_blank" title="<?=t('New window') ?>"><span><?=t('Download media') ?></span></a>
<?php if (isset($meta->transcript_url)): ?>
  <a class="script-pdf" href="<?=$meta->transcript_url ?>" target="_blank" title="<?=t('New window: %s', t('PDF')) ?>"><span><?=t('Download transcript') ?></span></a>
<?php endif; ?>
<?php if (isset($meta->_short_url)): ?>
<?php ///Translators: 'View on OU Podcasts web site' ?>
  <a class="short-url" rel="bookmark" href="<?=$meta->_short_url ?>" target="_blank" title="<?=t('New window: %s', t('perma-link')) ?>"><span><?=t('View on Podcasts') ?></span></a>
<?php endif; ?>
  </div>
  </div>
</div>


<div role="menu" id="more" class="oup-settings panel" aria-label="<?=t('Player options') ?>">
  <button class="more-close" title="<?=t('Close settings') ?>"><span>X</span></button>
  <a rel="help" class="help" href="<?=$help_url ?>" title="<?=t('New window') ?>"><span><?=t('Player help') ?></span></a>
  <a class="about" href="<?=$about_url ?>" title="<?=t('New window') ?>"><span><?=t('About the player') ?></span></a>
<?php if ($embed_code): ?>
  <?php /*<a class="embed" href="#embed-code">*/ ?><label class="embed" for="emcode-more"><span><?=t('Embed code') ?></span></label></a>
  <textarea id="emcode-more" class="emcode-more" readonly title="<?=$embed_method ?>"><?=str_replace('<','&lt;', $embed_code) ?></textarea>
  <a class="embed-opt" href="<?=$embedopts_url ?>" title="<?=t('New window') ?>"><span><?=t('More embed options') ?></span></a>
<?php endif; ?>
  <a class="media-url" href="<?=$meta->media_url ?>" target="_blank" title="<?=t('New window') ?>"><span><?=t('Download media') ?></span></a>
<?php if (isset($meta->transcript_url)): ?>
  <a class="script-pdf" href="<?=$meta->transcript_url ?>" target="_blank" title="<?=t('New window: %s', t('PDF')) ?>"><span><?=t('Download transcript') ?></span></a>
<?php endif; ?>
<?php if (isset($meta->_short_url)): ?>
  <a class="short-url" rel="bookmark" href="<?=$meta->_short_url ?>" target="_blank" title="<?=t('New window: %s', t('perma-link')) ?>"><span><?=t('View on Podcasts site') ?></span></a>
<?php endif; ?>
</div>


