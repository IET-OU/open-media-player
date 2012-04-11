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

<!--
 Todo: CDN plus fallback.
-->
<?php if ('jquery'==$this->theme->js_lib /*if ($params->jquery*/): ?>
<script src="<?php echo base_url().'application/'. $this->theme->plugin_path ?>jquery.js"></script>
<?php else: ?>

<?php if ($params->debug): ?>
<script src="http://cdn.enderjs.com/jeesh.js"></script>
<?php else: ?>
<script src="http://cdn.enderjs.com/jeesh.min.js"></script>
<?php endif;
  //<script src="../src/js/jeesh.js"></script>
  ?>
<script src="<?php echo base_url().'application/'. $this->theme->js_path ?>jeesh-extras.js"></script>

<?php endif; ?>

<?php
  if ($this->config->item('debug')):
    foreach ($this->theme->javascripts as $js_file): ?>
<script src="<?php echo base_url().'application/'. $js_file ?>"></script>
<?php
    endforeach;
  else:
?>
<script src="<?php echo base_url().'application/'. $this->theme->plugin_path ?>/build/mediaelement-and-player.min.js"></script>
<?php endif; ?>

<?php foreach ($this->theme->styles as $css_file): ?>
<link rel="stylesheet" href="<?php echo base_url().'application/'. $css_file ?>" />
<?php endforeach; ?>

<?php if ('mejs-ted'==$this->theme->name || 'mejs-wmp'==$this->theme->name): ?>
<link rel="stylesheet" href="../build/mejs-skins.css" />
<?php endif; ?>


<style>
</style>
