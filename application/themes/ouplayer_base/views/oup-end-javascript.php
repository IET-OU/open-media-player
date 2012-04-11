<script>
<?php if ('jquery' == $params->jslib): ?>
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

<?php if ($params->use_shim): ?>
  mode: 'shim',
<?php endif; ?>

<?php if ($params->duration): ?>
  duration: <?php echo $params->duration ?>,
<?php endif; ?>

<?php if ($params->origin): ?>
  origin:'<?php echo $params->origin ?>',
<?php endif; ?>

  features:
'<?php echo $params->features ?>'
.split(','),

<?php
  require_once 'oup-mep-international.php';
?>

  //titleId:'',
  titleText:
'<div class="logo"></div><h1><?php echo $params->title ?></h1> <a href="#" target="_blank" title="Related link opens in new window">The Student Experience in Study at The Open University</a>',

  alwaysShowControls: true,
  usePluginFullScreen: true,
  // path to Flash and Silverlight plugins
  pluginPath: '../build/',

<?php if ($params->debug): ?>
  enablePluginDebug: true,
<?php endif; ?>

  success: function(mediaElement, domObject) {
    $('#oup-noscript').addClass('hide');
    $.log("MEP/OUP: success, hiding #oup-noscript.");
  },
  error: function(ex) {
    $.log("MEP/OUP: error");
    $.log(ex);
  }

});


  $('#mejs-version').html(mejs.version);
  $.log('mejs.version: '+ mejs.version);
  $.log('Browser: <?php echo $params->ua ?>'); //'+$('html').attr('class'));
  $.log(player.options);

  setTimeout(function(){
    $.log('Media height px: '+ $('.mejs-poster.mejs-layer').css('height'));
  }, 400);

<?php if ('jquery' == $params->jslib): ?>
});
<?php else: ?>
})();
<?php endif; ?>
</script>