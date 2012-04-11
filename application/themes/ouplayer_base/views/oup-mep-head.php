<?php

#require_once 'oup-mep-config.php';


/*
 A minimal HTML5 shim for Internet Explorer.
 For discussion and comments, see: http://remysharp.com/2009/01/07/html5-enabling-script/
 (credit to @jdalton for minif)
*/
?>
<!--[if lt IE 9]>
<script src="http://html5shim.googlecode.com/svn/trunk/html5-els.js"></script>
<![endif]-->

<meta name="robots" content="noindex,nofollow" />
<link rel="license" title="©2012 The Open University" href="http://www.open.ac.uk/copyright" />

<?php if ('jquery'==$params->jslib /*if ($params->jquery*/): ?>
<script src="../build/jquery.js"></script>
<?php else: ?>

<?php if ($params->debug): ?>
<script src="http://cdn.enderjs.com/jeesh.js"></script>
<?php else: ?>
<script src="http://cdn.enderjs.com/jeesh.min.js"></script>
<?php endif;
  //<script src="../src/js/jeesh.js"></script>
  ?>
<script src="../src/js/jeesh-extras.js"></script>

<?php
  //<script src="../oup/oup-js/bonzo-ender.js"></script>
?>
<?php endif; ?>

<?php
  if ($params->debug):
    foreach ($mep_scripts as $meps_file): ?>
<script src="<?php echo $meps_file ?>"></script>
<?php
    endforeach;
  else:
?>
<script src="../build/mediaelement-and-player.min.js"></script>
<?php endif; ?>

<link rel="stylesheet" href="../build/mediaelementplayer.css" />
<!--
<link rel="stylesheet" href="css/mediaelementplayer.css" /><!--Edited 200312 PETER-|->
-->
<?php if ('mejs-ted'==$params->skin || 'mejs-wmp'==$params->skin): ?>
<link rel="stylesheet" href="../build/mejs-skins.css" />
<?php endif; ?>


<link rel="stylesheet" href="css/mep-ouplayer.css" />

<link rel="stylesheet" href="css/oup-theme1.css" />
-->
<!--
<link rel="stylesheet" href="http://iet-embed-acct.open.ac.uk/mediaelement/oup-0/css/mep-ouplayer.css" />
-->

<style>
</style>
