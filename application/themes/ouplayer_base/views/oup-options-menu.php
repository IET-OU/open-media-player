
<?php
// Embed code - uses jQuery-oEmbed plugin or Iframe.
$embed_code=null;
if ($this->theme->player_embed_code):
  $em_title = substr_replace($meta->title, '…', 36);
  ///Translators: Player options (settings) menus or panels.
  $copy_text = t('Copy and paste');
  if ('jquery-oembed' == $this->theme->player_embed_code
      && isset($meta->_short_url)) {
    $param_theme = OUP_PARAM_THEME;
    $jq_plugin_url = site_url('scripts/jquery.oembed.js');
    $jq_url = OUP_JS_CDN_JQUERY_MIN;
    $embed_method = t('Javascript-based embed (oEmbed)');
    $embed_code = <<<EOF
<!--$copy_text--><a class="embed" href="$meta->_short_url">$em_title</a>

<script src="$jq_url"></script>
<script src="$jq_plugin_url"></script>
<script>
$(document).ready(function(){
$("a.embed").oembed(null,{oupodcast:{{$param_theme}:"$theme->name"}});
});
</script>
EOF;
  }
  elseif ('iframe' == $this->theme->player_embed_code) {
    $embed_method = t('Iframe-based embed');
	$embed_label = t('OU player');
    $embed_url = current_url().'?'.$this->input->server('QUERY_STRING');
    $embed_url = str_replace('/popup/', '/embed/', $embed_url);
    // Todo: needs work!
    $embed_code = <<<EOF
<iframe class="ouplayer $meta->media_type" title="$embed_label" width="640" height="410" src="$embed_url" frameborder="0" allowfullscreen></iframe>
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

$help_url = str_replace('__SITE__/', site_url(), $help_url);
$about_url= str_replace('__SITE__/', site_url(), $about_url);
?>


<ul>
<?php if ($help_url && $about_url): ?>
  <li><a rel="help" class="help" href="<?php echo $help_url ?>" target="_blank" title="<?php echo t('New window') ?>"><span><?php echo t('Player help') ?></span></a>
  <li><a class="about" href="<?php echo $about_url ?>" target="_blank" title="<?php echo t('New window') ?>"><span><?php echo t('About the player') ?></span></a>
<?php else: ?>
  <li><a rel="help" class="help" href="<?php echo $about_url ? $about_url : $help_url ?>" target="_blank" title="<?php echo t('New window') ?>"><span><?php echo t('Help and about') ?></span></a>
<?php endif; ?>
  <li><a class="media-url" href="<?php echo $meta->media_url ?>" target="_blank" title="<?php echo t('New window') ?>"><span><?php echo t('Download media') ?></span></a>
<?php if (isset($meta->transcript_url) && $meta->transcript_url): ?>
  <li><a class="script-pdf" href="<?php echo $meta->transcript_url ?>" target="_blank" title="<?php echo t('New window: %s', t('PDF')) ?>"><span><?php echo t('Download transcript') ?></span></a>
<?php endif; ?>
<?php if (isset($meta->_short_url)): ?>
  <li><a class="short-url" rel="bookmark" href="<?php echo $meta->_short_url ?>" target="_blank" title="<?php echo t('New window: %s', t('perma-link')) ?>"><span><?php echo t('View on Podcasts site') ?></span></a>
<?php endif; ?>
<?php if ($embed_code): ?>
  <li><?php /*<a class="embed" href="#embed-code">*/ ?><label class="embed" for="embed-code"><span><?php echo t('Share') ?> &rarr; <?php echo t('Embed') ?></span></label></a>
  <textarea id="embed-code" class="embed-code" readonly title="<?php echo t('Copy and paste') ?>: <?php echo $embed_method ?>"><?php echo str_replace('<','&lt;', $embed_code) ?></textarea>
  <li><a class="embed-opt" href="<?php echo $embedopts_url ?>" target="_blank" title="<?php echo t('New window') ?>"><span><?php echo t('More embed options') ?></span></a>
<?php endif; ?>
</ul>

