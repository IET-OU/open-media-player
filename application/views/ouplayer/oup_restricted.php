<?php
/** Open Media Player iframe - restricted access/ access control.
 *
 * @copyright Copyright 2011 The Open University.
 */

///Translators: access control.
$restrict_text = t('Public access');
$restrict_class= 'public';

if ($meta->is_deleted_podcast()) {
  $restrict_text = t('Deleted'); // Woops!
  $restrict_class= 'deleted';
}
elseif ($meta->is_private_podcast()) {
  $restrict_text = t('Private access only');
  $restrict_class= 'private';
}
elseif (! $meta->is_published_podcast()) {
  $restrict_text = t('Unpublished');
  $restrict_class= 'unpublished';
}
elseif ($meta->is_restricted_podcast()) {
  $restrict_text = t('Staff/student access only');
  $restrict_class= 'intranet';
}


// Help/ about links.
$docs = config_item('player_docs');
$about_url= isset($docs['about'])? $docs['about']: '#about/TODO';


$base_url = site_url();

?>
<!doctype html><html lang="en"><meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1" />
<meta charset="utf-8" /><title><?php #echo $meta->title .' | ' ?><?php echo $restrict_text ?> | Podcast | <?php echo site_name() ?></title>
<meta name="copyright" value="&copy; 2011 The Open University" />

<link rel="stylesheet" href="<?php echo $base_url ?>assets/ouplayer/ouplayer.core.css" />
<?php #if (isset($theme->styles)): ?>
<link rel="stylesheet" href="<?php echo $base_url ?>assets/<?php echo 'ouplayer/ouice-light/ouice-light.css?r='. rand(0,100) #$theme->styles ?>" />
<?php #endif; ?>
<link rel="icon" href="<?php echo $base_url ?>assets/favicon.ico" />

<?php
$this->load->view('ouplayer/oup_analytics');
?>
<body id="ouplayer" class="oup mode-embed restrict access-<?php echo $restrict_class ?>">

<div id="ouplayer-div">
<?php if ($meta->poster_url): ?>
  <img class="oup-poster" alt="" src="<?php echo $meta->poster_url ?>" />
<?php endif; ?>
</div>

<div id="title" class="oup-title panel titletoolbar">
  <?php /*<a class="ou-home" href="http://www.open.ac.uk/"><img class="logo" alt="The Open University" src="<?php echo site_url('assets/0.gif') ?>" height="38" width="32" /></a>*/ ?>
  <img class="ou-home logo" alt="Open University logo" src="<?php echo site_url('assets/0.gif') ?>" height="38" width="32" />
  <ul class="mediatitle">
  <li><h1><?php echo $meta->title; /*substr_replace($meta->title, '…', 62)*/ ?></h1></li>
  <?php #if ($meta->is_restricted_podcast()): ?>
  <li class="restrict-text"><?php echo $restrict_text #t('Staff/student access only') ?></li>
  <?php #endif; ?>

  <li><a target="_blank" href="<?php echo Sams_Auth::login_link($popup_url) ?>"
	class="login popout" ><?php echo t('Log in and launch the player in a new window') ?></a></li>

  <?php /*<li>  <?php if(isset($meta->_related_url) && $meta->_related_url){
    echo anchor($meta->_related_url, $meta->_related_text, array('class'=>'rel-2','target'=>'_blank','title'=>t('New window')));
  } ?></li>*/ ?>
  <li><a class="about" href="<?php echo str_replace('__SITE__/', site_url(), $about_url) ?>" title="<?php echo t('New window') ?>"><?php echo t('About the player') ?></a></li>
  </ul>
</div>


</body></html>
