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
<meta name="generator" content="OU Player by IET" />
<link rel="license" title="©2012 The Open University" href="http://www.open.ac.uk/copyright" />

<!--
 CDN + fallback: jQuery / Ender
-->
<?php if ('jquery'==$this->theme->jslib):
    /* jQuery via CDN, with local fallback.
       Note, '//ajax..' is not a mistake - works for HTTP and HTTP-S!
       <script src="http://www8.open.ac.uk/platform/misc/jquery.js?Y"></script>  -- v1.3.2.
       http://stackoverflow.com/questions/1014203/best-way-to-use-googles-hosted-jquery-but-fall-back-to-my- ..
    */
?>
<script src="<?=OUP_JS_CDN_JQUERY_MIN ?>"></script>
<script>
if(typeof jQuery=='undefined'){
  document.write(unescape("%3Cscript src='<?php player_res_url($this->theme->plugin_path .'jquery.js') ?>' %3E%3C/script%3E"));
  CDN_fallback = true;
}
</script>

<?php else:
      /* Ender/jeesh.js via CDN, with local fallback.
      */
      if ($this->config->item('debug') > OUP_DEBUG_MIN): ?>
<script src="<?=OUP_JS_CDN_ENDER ?>"></script>
<?php else: ?>
<script src="<?=OUP_JS_CDN_ENDER_MIN ?>"></script>
<?php endif; ?>
<script>
if(typeof $=='undefined'){
  document.write(unescape("%3Cscript src='<?= base_url().'application/'. $this->theme->js_path ?>jeesh.js' %3E%3C/script%3E"));
  CDN_fallback = true;
}
</script>
<script src="<?php player_res_url($this->theme->js_path. 'jeesh-extras.js') ?>"></script>
<?php endif; ?>

<?php
  if ($this->config->item('debug') > OUP_DEBUG_MIN):
    foreach ($this->theme->javascripts as $js_file): ?>
<script src="<?php player_res_url($js_file) ?>"></script>
<?php
    endforeach;
  else:
?>
<script src="<?php player_res_url($this->theme->js_min) ?>"></script>
<?php endif; ?>

<?php foreach ($this->theme->styles as $css_file): ?>
<link rel="stylesheet" href="<?php player_res_url($css_file) ?>" />
<?php endforeach; ?>

<?php if ('mejs-ted'==$this->theme->name || 'mejs-wmp'==$this->theme->name): ?>
<link rel="stylesheet" href="../build/mejs-skins.css" />
<?php endif; ?>


<?php
  // Google/ ComScore analytics (from the legacy player).
  $this->load->view('ouplayer/oup_analytics');
?>
