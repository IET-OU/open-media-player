<script>
<?php if ($this->theme->with_credentials): ?>
$.ajaxSetup({
  xhrFields: {
    withCredentials: true
  }
});

<?php endif; ?>
<?php if ('jquery' == $this->theme->jslib): ?>
$(document).ready(function ouplayer_launch($){
<?php else: ?>
$.domReady(function ouplayer_launch(){
<?php endif; ?>

(function () {
  // Horrible MSIE 11+ hacks :((.
  var ua = navigator.userAgent,
    tri_match = ua.match(/Trident\/([1789]\d?(\.\d)?)/),
    rv_match = ua.match(/rv:(\d+(\.\d)?)/);
  if (tri_match) {
    $('body').addClass('trident-7-');
    $('#oup-noscript').hide();
    $.log('MSIE 11+ in IE 7 compat mode? Trident/' + tri_match[1]);
  }
  if (rv_match) {
    $('body').addClass('ie-rv-' + rv_match[1]);
    $('#oup-noscript').hide();
    $.log('MSIE 11+ - rv:' + rv_match[1]);
  }
})();

$.oup_debug = <?php echo json_encode((bool) $params->debug) ?>,
$.ouplayer = new mejs.MediaElementPlayer('#player1'<?php //document.getElementById('player1') ?>, {

<?php if ('jquery' == $this->theme->jslib): //Includes MSIE 7 and 9 (iet-it-bugs:1474) ?>
  videoWidth:'100%',
  videoHeight:'100%',
<?php endif; ?>

  timeAndDurationSeparator: ' <span class="sep"> / </span> ',

  <?php echo json_encode_bare($this->theme->config, $function = TRUE) ?>,

<?php /*if ($params->use_shim): ?>
  mode: 'shim',
<?php endif;*/ ?>

  can_play_maybe:<?php echo $this->theme->can_play_maybe ?>,

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
  pluginPath: '<?php player_res_url($this->theme->plugin_path, $ver = false) ?>',

<?php if ($params->debug): ?>
  enablePluginDebug: true,
<?php endif; ?>

  success: function(media, node, player) {
	var events = ['loadstart', 'play', 'pause', 'ended', 'error'];
	for (var i=0, il=events.length; i<il; i++) {
		media.addEventListener(events[i], function (e) {
			$.log(e.type);
			$.oup_error_handler(e, '#oup-noscript', player);

		});
	}


	/* LtsRedmine:7911 "Go Fullscreen" */
	$(".mejs-fullscreen-button button").html("<span><?php echo t('Toggle Fullscreen') ?></span>");


	$("#oup-pauser").click(function (e) {
		media.pause();
	});

<?php #if (! $this->agent->is_browser('Opera')): ?>
	$('#oup-noscript').addClass('hide');
    $.log("MEP/OUP: success, hiding #oup-noscript.");
<?php #endif; ?>

    $.log("mejs.plugin-type: " + media.pluginType);
    $('body').addClass('plugin-' + media.pluginType);


<?php //QQ: Do we need a setTimeout()? ?>
    // Detect Flash disabled/not installed.
    setTimeout(function () {
      if (media.pluginType !== 'native' && $('.mejs-poster.mejs-layer').css('height') === undefined) {
        $('body').addClass('no-flash');
        $('#oup-noscript').hide();
        $('#oup-noflash').show().removeClass('hide');
        $.log("MEP/OUP: Flash disabled/not installed.");
      }
    }, <?php echo $this->theme->js_timeout ?>);

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
  $.log('Browser: <?php echo $this->agent->agent_code() ?>'); //'+$('html').attr('class'));

  setTimeout(function(){

<?php if('video'==$params->media_type && 'ender'==$this->theme->jslib && $this->agent->is_browser('Firefox')): ?>
// Video/Moz/Ender: 'success:function' not fired - WHY? :(.
    if (! $("video").get(0).currentSrc) {
      $('#oup-noscript').hide();
      $.log("MEP/OUP: warning [2], hiding #oup-noscript.");
    }
<?php endif; ?>

<?php /*    $.log('Media height px: '+ $('.mejs-poster.mejs-layer').css('height'));*/ ?>
    $.log($.ouplayer.options);

  }, <?php echo $this->theme->js_timeout ?>); //200~500 ms.

<?php //if ('jquery' == $this->theme->jslib): ?>
});
<?php /*else: ?>
})();
<?php endif;*/ ?>
</script>