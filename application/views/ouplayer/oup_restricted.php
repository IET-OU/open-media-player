<?php
/** OU player iframe - restricted access/ access control.
 *
 * @copyright Copyright 2011 The Open University.
 */

///Translators: access control.
$restrict_text = t('Public access');
$restrict_class= 'public';

if (1==$meta->_access['deleted']) {
  $restrict_text = t('Deleted'); // Woops!
  $restrict_class= 'deleted';
}
elseif ('Y'==$meta->_access['private']) {
  $restrict_text = t('Private access only');
  $restrict_class= 'private';
}
elseif ('Y'==$meta->_access['intranet_only']) {
  $restrict_text = t('Staff/student access only');
  $restrict_class= 'intranet';
}
elseif ('N'==$meta->_access['published']) {
  $restrict_text = t('Unpublished');
  $restrict_class= 'unpublished';
}


// Help/ about links.
$docs = config_item('player_docs');
$about_url= isset($docs['about'])? $docs['about']: '#about/TODO';


$base_url = base_url();

?>
<!DOCTYPE html><html lang="en"><meta charset="utf-8" /><title><?=$meta->title ?> | <?=$restrict_text ?> | <?=t('OU player') ?></title>
<meta name="copyright" value="&copy; 2011 The Open University" />

<link rel="stylesheet" href="<?=$base_url ?>assets/ouplayer/ouplayer.core.css" />
<?php if (isset($theme->styles)): ?>
<link rel="stylesheet" href="<?=$base_url ?>assets/<?=$theme->styles ?>" />
<?php endif; ?>
<link rel="icon" href="<?=$base_url ?>assets/favicon.ico" />

<?php
$this->load->view('ouplayer/oup_analytics');
?>
<body id="ouplayer" class="oup mode-embed restrict access-<?=$restrict_class ?>">

<div id="ouplayer-div">
<?php if ($meta->poster_url): ?>
  <img class="oup-poster" alt="" src="<?=$meta->poster_url ?>" />
<?php endif; ?>
</div>

<div id="title" class="oup-title panel titletoolbar">
  <?php /*<a class="ou-home" href="http://www.open.ac.uk/"><img class="logo" alt="The Open University" src="<?=site_url('assets/0.gif') ?>" height="38" width="32" /></a>*/ ?>
  <img class="ou-home logo" alt="Open University logo" src="<?=site_url('assets/0.gif') ?>" height="38" width="32" />
  <ul class="mediatitle">
  <li><h1><?=$meta->title; /*substr_replace($meta->title, '…', 62)*/ ?></h1></li>
  <?php if ('Y'==$meta->_access['intranet_only']): ?>
  <li class="restrict-text"><?=t('Staff/student access only') ?></li>
  <?php endif; ?>

  <li><a target="_blank" href="https://msds.open.ac.uk/signon/SAMSDefault/SAMS001_Default.aspx?URL=<?=/*urlencode*/($popup_url) ?>"
	class="login popout" ><?=t('Log in and launch the player in a new window') ?></a></li>

  <li>  <?php if(isset($meta->_related_url) && $meta->_related_url){
    echo anchor($meta->_related_url, $meta->_related_text, array('class'=>'rel-2','target'=>'_blank','title'=>t('New window')));
  } ?></li>
  <li><a class="about" href="<?=$about_url ?>" title="<?=t('New window') ?>"><?=t('About the player') ?></a></li>
  </ul>
</div>


</body></html>
