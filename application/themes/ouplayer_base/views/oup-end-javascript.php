<script>
<?php if ('jquery' == $this->theme->js_lib): ?>
$(document).ready(function ouplayer_launch($){
<?php else:
  //Ender?  $.domReady(function(){ ?>
(function ouplayer_launch(){
<?php endif; ?>

var player = new MediaElementPlayer('#player1'<?php //document.getElementById('player1') ?>, {

<?php if ($params->poster_url): ?>
  // url to poster (to fix iOS 3.x) 
  poster:'<?php echo $params->poster_url ?>',
<?php endif; ?>

  // Keyboard accessibility: disable shortcuts!
  enableKeyboard:false,

<?php //if ($params->use_shim): ?>
  mode: 'shim',
<?php //endif; ?>

<?php if ($params->duration): ?>
  duration: <?php echo $params->duration ?>,
<?php endif; ?>

<?php if ($this->theme->origin): ?>
  origin:'<?php echo $this->theme->origin ?>',
<?php endif; ?>

<?php if ($this->theme->features): ?>
  features:
'<?php echo $this->theme->features ?>'
.split(','),
<?php endif; ?>

<?php
  require_once 'oup-mep-international.php';
?>

  //titleId:'',
  titleText:
'<div class="logo"></div><h1><?=$params->title ?></h1> <a href="<?=$params->_related_url ?>" target="_blank" title="Related link opens in new window"><?=$params->_related_text ?></a>',

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

  success: function(mediaElement, domObject) {
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
  $.log('mejs.version: '+ mejs.version);
  $.log('Browser: <?php echo $this->agent->browser_code() ?>'); //'+$('html').attr('class'));
  $.log(player.options);

  setTimeout(function(){
    $.log('Media height px: '+ $('.mejs-poster.mejs-layer').css('height'));
  }, 400);

<?php if ('jquery' == $this->theme->js_lib): ?>
});
<?php else: ?>
})();
<?php endif; ?>
</script>