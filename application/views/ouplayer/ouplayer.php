<?php
/** OU player iframe.
 *
 * @copyright Copyright 2011 The Open University.

Test, video: /embed/pod/mst209-fun-of-the-fair/a67918b334?
Test, audio: /embed/pod/l314-spanish/fe481a4d1d?poster=0
 */
//NDF, 2011-04-08/-05-19.
  $base_url = base_url();
  //$base_url = str_replace('http://', '//', $base_url);


  //TODO: move $body_classes to controller function?

  // Add switches to body-class (no 'hulu').
  $body_classes = "oup mtype-$meta->media_type width-$meta->width theme-{$theme->name} hide-tscript hide-captions hide-settings oup-paused ";

  //Experimental.
  if ($req->hide_controls /*&& 'video'==$meta->media_type*/) {
    $body_classes.= "ctl-overlay ";
  }

  // Language/locale, 'context' (ctx-), 'mode' etc.
  $body_classes.= ' lang-'.$this->lang->lang_code();
  $body_classes.= ' -'.$this->agent->browser_code();
  $body_classes.= ' ctx-'.get_class($meta);
  $body_classes.= " mode-$mode "; #(embed|popup).
  $body_classes.= $debug ? 'debug ':'no-debug ';
  $body_classes.= $meta->poster_url  ? 'has-poster ':'no-poster ';
  $body_classes.= $meta->caption_url ? 'has-captions ':'no-captions ';
  $body_classes.= isset($meta->transcript_html)&&$meta->transcript_html ? 'has-tscript ':'no-tscript '; //Was 'hide-script'
  $body_classes.= isset($meta->_related_url)&&$meta->_related_url ? 'has-rel-link ':'no-rel-link ';
  $body_classes.= isset($meta->_access)&&'Y'==$meta->_access['private'] ? 'is-private ':'not-private ';

# Media: 512 x 288.
# Player:512 x 318;
  $player_height = $meta->height; #+ 30.
  $media_height = $meta->height - 60;
  $legacy_height = $meta->height - 30;
  // Hold poster image for audio-player.
  $audio_poster = null;

  $inner=$poster='';
  if ($meta->poster_url) {
    $poster = "<img class=\"oup-poster\" alt=\"\" src=\"$meta->poster_url\" />";
  }
  if ($meta->media_html5 && 'video' == $meta->media_type) {
    $support_text = t('Your browser does not support the "video" element.');
    // HTML5 video type/codec, see http://wiki.whatwg.org/wiki/Video_type_parameters
    $type = config_item('ouplayer_video_type'); //Was: '_codec'.
    $type = $type ? $type : 'type=\'video/mp4; codecs="avc1.42E01E, mp4a.40.2"\' '; //<!--Was: codecs="bogus", avc1.4D401E, mp4a.40.2 -->
    $html5_media_url = str_replace('podcast.', 'media-podcast.', $meta->media_url);
    $inner =<<<EOF
  $poster
  <video class="oup-html5-media" poster="$meta->poster_url" width="$meta->width" height="$player_height" controls>
    <source src="$meta->media_url" $type/>
    <div id="no-support">$support_text</div>
  </video>
  <a href="$meta->media_url" class="html5-dload">[Download]</a>
EOF;
  }
  elseif ($meta->media_html5 && 'audio' == $meta->media_type) {
	$audio_poster = $poster;
	$support_text = t('Your browser does not support the "audio" element.');
	$inner =<<<EOF
  $poster
  <audio class="oup-html5-media" src="$meta->media_url" style="width:{$meta->width}px; height:{$meta->object_height}px;" controls
   ><div id="no-support">$support_text</div></audio>
EOF;
  }

  //<meta> below - try to ensure the most recent MSIE rendering engine
  //@header('X-UA-Compatible: IE=edge');
?>
<!DOCTYPE html><html lang="en"><meta charset="utf-8" /><title><?=$meta->title ?> | <?=t('OU player') ?></title>
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<meta name="copyright" value="&copy; 2011 The Open University" />

<!--[if lt IE 9]><?php /*http://diveintohtml5.org/semantics.html#new-elements*/ ?>

<script>
var e = ("abbr,audio,figure,output,time,video").split(',');
for (var i=0; i < e.length; i++){ document.createElement(e[i]); }
</script>
<![endif]-->

<link rel="stylesheet" href="<?=$base_url ?>assets/ouplayer/ouplayer.core.css" />
<?php if (isset($theme->styles)): ?>
<link rel="stylesheet" href="<?=$base_url ?>assets/<?=$theme->styles ?>" />
<?php endif; ?>
<link rel="icon" href="<?=$base_url ?>assets/favicon.ico" />

<!--[if lt IE 9]>
<style>
.oupc .time-out{top:-3px;}

/*MSIE hack - border is required?! No longer needed? */
.X-oup.mode-embed.mtype-audio .oup-title .rel-2{
  position:relative;
  top:-16px;

  border:1px solid transparent;
}

.X-oup-controls a{
  display:inline-block;
  position:relative;
  top:3px;
}
</style>
<![endif]-->

<?php /*
<script type="text/javascript" src="http://www.universalsubtitles.org/site_media/js/mirosubs-widgetizer.js">
        </script>
*/ 
$this->load->view('ouplayer/oup_analytics');
?>
<body role="application" id="ouplayer" class="<?=$body_classes ?>">

<div id="XX-ouplayer-outer">

<?php //=$audio_poster ?>
<div id="ouplayer-div" data-XX-style="width:<?=$meta->width ?>px; height:<?=$meta->object_height ?>px;">
<?=$inner ?>

</div>

<?php if(isset($meta->transcript_html) && ($meta->transcript_html || $debug)): ?>
<div role="document" id="transcript" class="oup-tscript-panel" >
<button class="tscript-close" aria-label="<?=('Close')?>" title="<?=t('Close script') ?>"><span>X</span></button>
<a class="pdf icon" href="<?=$meta->transcript_url ?>" target="_blank" title="<?=t('New window: %s', t('PDF')) ?>"><span><?=t('Download transcript') ?></span></a>
<div class="transcript">
<?= $meta->transcript_html ? $meta->transcript_html : '[No transcript - debug]'; ?>
</div>
<button class="tscript-close tscript-close-end" aria-label="<?=('Close')?>" title="<?=t('Close script') ?>"><span>X</span></button>
</div>
<?php endif; ?>

<noscript>
<?php
  // Basic no-script Flash-Flowplayer solution.
  $view_data = array('inner'=>$inner);
  $this->load->view('ouplayer/player_noscript.php', $view_data);
?>
</noscript>

</div>

<?php
  $this->load->view('ouplayer/oup_settings.php');

  $this->load->view('ouplayer/oup_controls.php');
?>

<div id="media-links" style="display:none">
  <a href="<?=$meta->media_url ?>"><?=t('Download %s', $meta->title) ?></a>
</div>

<div role="tooltip" id="oup-tooltips"></div>


<?php
  $this->load->view('ouplayer/oup_scripts');
?>
<script>
flashembed.domReady(function(){
  //var f=$f("ouplayer-div");

//OUP.dir(flashembed);
OUP.log('domReady');

//TODO: check minimum Flash requirement!
if (flashembed.isSupported([6,0,65])) {
<?php
  $flow_key = config_item('flowplayer_key');

  function _flowplayer_flash() {
    $CI =& get_instance();
    $flowplayer_dev= $CI->config->item('flowplayer_dev');
    $flow_key      = $CI->config->item('flowplayer_key');
    $flow_commercial= $flow_key ? '.commercial' : '';
    $flow_version  = $CI->config->item('flowplayer_version');
    if(!$flow_version || !$flow_key){$flow_version='3.2.7';}

	if ($flowplayer_dev) {
	  return "assets/flowplayer_dev/flowplayer$flow_commercial.swf";
	}
	return "swf/flowplayer$flow_commercial-$flow_version.swf";
  }

  function _flowplayer_plugin($name, $version) {
    $flowplayer_dev = config_item('flowplayer_dev');
	if ($flowplayer_dev) {
	  return "flowplayer.$name.swf";
	}
	return "flowplayer.$name-$version.swf";
  }
?>
  //Accessibility: wmode=opaque would be inaccessible if we relied on Flash controls.
  OUP.player = $f("ouplayer-div", {src:"<?=$base_url ?><?=_flowplayer_flash() ?>", wmode:'opaque'}, {

    onError: function(code, message){
      OUP.log('onError: '+code+', '+message);
    },

<?php if ($flow_key){ echo "key:'$flow_key',"; } ?>

    clip:{
<?php /*url: "<?=$meta->media_url ?->",*/ ?>
	  scaling: 'fit',
	  autoPlay:false,
	  autoBuffering:true,
	  eventCategory: 'ouplayer'
	  //showCaptions:false //Initially hide.
	},

    playlist:[
      {"url":"<?=$meta->media_url ?>" <?php if ('audio'==$meta->media_type && $meta->poster_url): ?>
, coverImage:{"url":"<?=$meta->poster_url ?>"}<?php endif; ?><?php if ($meta->caption_url): ?>
      ,
      "captionUrl":"<?=$meta->caption_url ?>"<?php endif; ?>}
    ],

    plugins: {
<?php if ($meta->caption_url): ?>
"captions":{"url":"<?=_flowplayer_plugin('captions', '3.2.3') ?>", "captionTarget":"content", "button":null},
"content": {
  "url":"<?=_flowplayer_plugin('content', '3.2.0') ?>",
  "display":"none",
  "bottom":5, //30,
<?php /*"width":"90%"<-?=($meta->width - 60) //Percent fails - why? */
  $captions_background = true;
  if ($captions_background): ?>
  "backgroundColor":"#222222",
  "backgroundGradient":"none",
  "borderRadius":8,
  "opacity":0.95,
<?php else: ?>
  backgroundColor:'transparent',
  backgroundGradient:'none',
  border:0,
  textDecoration:'outline',
<?php endif; ?>
  "style": { //Note, TTML can override.
    "body":{
      "fontSize":15,
      "textAlign":"center",
      "color":"#e8e8e8"
    }
  }
  <?php /*"width": "87%",
  "height":55,
  "opacity": 50,
  "style":{
    "body":{
    "fontFamily":"Arial",
	"fontWeight":"bold",
    }
  }*/ ?>
},
<?php endif; ?>

<?php if(isset($google_analytics) && $google_analytics): ?>
    gatracker: {
      url:"<?=_flowplayer_plugin('analytics', '3.2.2') ?>",

<?php // track all possible events. By default only Start and Stop 
      // are tracked with their corresponding playhead time. ?>
      events:{ all:true, finish:'Finish' },
      //debug: true,
      accountId: "<?=$google_analytics ?>" // your Google Analytics id here
	},
<?php endif; ?>

	  controls: null //Disable default controls.
	}
    //plugins: {controls:{autohide:false}}

  // install HTML controls inside element whose id is "X".
  }).controls("controls", {duration: <?=$meta->duration ? $meta->duration : 0 ?>});

  OUP.initialize();
}
else{
  OUP.html5_fallback('<?=$meta->media_type ?>');

  OUP.log('fallback');
}
});
</script>

</body></html>