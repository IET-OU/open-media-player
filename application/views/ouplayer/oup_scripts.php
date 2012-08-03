<?php

$base_url = base_url();
$compress = config_item('player_scripts_compress');

if ($compress):
  $script_key = 'scripts_embed_ouplayer.min.js';
  if (cache_exists($script_key)) {
?>
<script src="<?php echo $base_url
    ?>scripts/embed_ouplayer_js/t_<?php echocache_time($script_key) ?>"></script>
<?php } else { ?>
<script src="<?php echo $base_url ?>scripts/embed_ouplayer_js"></script>
<?php } 
else: ?>
<script src="<?php echo $base_url ?>swf/flowplayer-3.2.6.min.js"></script>
<?php /*<!--
<script src="<?php echo $base_url ?>swf/flowplayer-src-r652.js"></script>
<script src="<?php echo $base_url ?>swf/flashembed.min.js"></script>
-->*/ ?>
<script src="<?php echo $base_url ?>swf/flowplayer.controls-OUP.js"></script>
<script src="<?php echo $base_url ?>assets/ouplayer/ouplayer.tooltips.js"></script>
<script src="<?php echo $base_url ?>assets/ouplayer/ouplayer.behaviors.js?r=<?php echorand() ?>"></script>
<?php endif; ?>
