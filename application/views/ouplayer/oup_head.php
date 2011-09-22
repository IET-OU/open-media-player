<?php

  $base_url = base_url();

  //<meta> below - try to ensure the most recent MSIE rendering engine
  //@header('X-UA-Compatible: IE=edge');
?>
<!DOCTYPE html><html lang="en"><meta charset="utf-8" /><title><?=$meta->title ?> | <?=t('OU player') ?></title>
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<meta name="copyright" value="&copy; 2011 The Open University" />

<!--[if lt IE 9]><?php /*http://diveintohtml5.org/semantics.html#new-elements*/ ?>

<script>
var e = ("abbr,audio,figure,output,time,video").split(',');
for (var i=0; i < e.length; i++){ document.createElement(e[i]); }
</script>
<![endif]-->

<link rel="stylesheet" href="<?=$base_url ?>assets/ouplayer/ouplayer.core.css" />
<?php
if (isset($theme->styles)):
  $n_themes=0;
  foreach (config_item('player_themes') as $tname => $theme_r):
    if (!$theme_r['styles'] || !isset($theme_r['menu'])) continue;
    $trel = 'alternate ';
    if ($tname == $theme->name) {
      $trel = '';
      $n_themes++;
    }
?>
<link rel="<?=$trel ?>stylesheet" href="<?=$base_url ?>assets/<?=$theme_r['styles'] ?>" title="<?=t('OU player') ?>: <?=t($theme_r['title']) ?>" />
<?php
  endforeach;
  if (!$n_themes): ?>
<link rel="stylesheet" href="<?=$base_url ?>assets/<?=$theme->styles ?>" />
<?php
  endif;
endif; ?>
<link rel="icon" href="<?=$base_url ?>assets/favicon.ico" />

<?php /*
<script type="text/javascript" src="http://www.universalsubtitles.org/site_media/js/mirosubs-widgetizer.js">
        </script>
*/ 
$this->load->view('ouplayer/oup_analytics');
?>