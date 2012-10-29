<script>
<?php if ('jquery' == $this->theme->jslib): ?>
$(document).ready(function ouplayer_launch($){
<?php else: ?>
$.domReady(function ouplayer_launch(){
<?php endif; ?>

var player = new mejs.MediaElementPlayer('#player1'<?php //document.getElementById('player1') ?>, {

<?php if ($params->poster_url): ?>
  // url to poster (to fix iOS 3.x) 
  poster:'<?php echo $params->poster_url ?>',
<?php endif; ?>

  // Keyboard accessibility: disable shortcuts!
  enableKeyboard:false,

<?php /*if ($params->use_shim): ?>
  mode: 'shim',
<?php endif;*/ ?>

<?php if ($popup_url): ?>
  popoutUrl:'<?php echo $popup_url ?>',
<?php endif; ?>

<?php if ('Podcast_player'==get_class($params)): ?>
  tooltipOffsetX:9, tooltipOffsetY:9,
<?php endif; ?>

<?php if ($params->duration): ?>
  duration: <?php echo $params->duration ?>,
<?php endif; ?>

<?php if ($this->theme->origin): ?>
  origin:'<?php echo $this->theme->origin ?>',
<?php endif; ?>

<?php if (isset($this->theme->mobile_native_controls)): ?>
  iPadUseNativeControls:true,
  iPhoneUseNativeControls:true,
  AndroidUseNativeControls:true,
<?php endif; ?>

<?php if ($this->theme->features): ?>
  features:
'<?php echo $this->theme->features ?>'
.split(','),
<?php endif; ?>

<?php
  require_once 'oup-mep-international.php';
?>

<?php /*if ('Podcast_player'==get_class($params)): ?>
  titleText:
"<div class='logo'></div><h1><?php echo json_encode_str($params->title) ?></h1>"
<?php if (isset($params->_related_url)): ?>+" <a href='<?php echo $params->_related_url ?>' target='_blank' title='<?php echo t('Related link') ?> <?php echo t('opens in new window') ?>'><?php echo json_encode_str($params->_related_text) ?></a>"<?php endif ?>,
  embedcodeId:'embed-code',
<?php endif;*/ ?>

<?php if(isset($params->transcript_id) && $params->transcript_id): ?>
  transcriptId: '<?php echo $params->transcript_id ?>',
<?php endif; ?>

  alwaysShowControls: true,
  usePluginFullScreen: true,
  // path to Flash and Silverlight plugins
  pluginPath: '<?php echo base_url().'application/'. $this->theme->plugin_path ?>',

<?php if ($params->debug): ?>
  enablePluginDebug: true,
<?php endif; ?>

  success: function(media, node, player) {
	var events = ['loadstart', 'play', 'pause', 'ended', 'error'];
	for (var i=0, il=events.length; i<il; i++) {
		media.addEventListener(events[i], function (e) {

			$.oup_error_handler(e, '#oup-noscript', player);

		});
	}

<?php #if (! $this->agent->is_browser('Opera')): ?>
	$('#oup-noscript').addClass('hide');
    $.log("MEP/OUP: success, hiding #oup-noscript.");
<?php #endif; ?>
  },
  error: function(ex) {
    $.log("MEP/OUP: error");
    $.log(ex);
  }

});

<?php if ('audio'==$params->media_type && !$this->agent->is_mobile('operamini')): ?>
// Audio: 'success:function' not fired - WHY? :(.
  $('#oup-noscript').addClass('hide');
  $.log("MEP/OUP: warning, hiding #oup-noscript.");
<?php endif; ?>

  $('#mejs-version').html(mejs.version);
  if(typeof CDN_fallback!='undefined'){
    $.log('CDN fail: used local jslib.');
  }
  $.log('mejs.version: '+ mejs.version);
  $.log('Browser: <?php echo $this->agent->browser_code() ?>'); //'+$('html').attr('class'));
  $.log(player.options);

  setTimeout(function(){
    $.log('Media height px: '+ $('.mejs-poster.mejs-layer').css('height'));
  }, 400);

<?php //if ('jquery' == $this->theme->jslib): ?>
});
<?php /*else: ?>
})();
<?php endif;*/ ?>
</script>