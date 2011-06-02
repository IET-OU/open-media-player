<?php
/** OU player iframe.
 *
 * @copyright Copyright 2011 The Open University.

Test, video:  /ouplayer/embed/pod/mst209-fun-of-the-fair/a67918b334?width=640&height=420
Test, audio:  /ouplayer/embed/pod/l314-spanish/fe481a4d1d?width=400&height=60&poster=0
 */
//NDF, 2011-04-08/-05-19.
  $base_url = base_url();

  // Add switches to body-class (no 'hulu').
  $body_classes = "oup mtype-$meta->media_type width-$meta->width theme-{$theme} hide-tscript hide-settings oup-paused ";
  $body_classes.= "mode-$mode "; #(embed|popup).
  $body_classes.= $debug ? 'debug ':'no-debug ';
  $body_classes.= $meta->poster_url  ? 'has-poster ':'no-poster ';
  $body_classes.= $meta->caption_url ? 'has-captions ':'no-captions ';
  $body_classes.= $meta->transcript_html? 'has-tscript ':'no-tscript '; //Was 'hide-script'
  $body_classes.= $meta->_related_url? 'has-rel-link ':'no-rel-link ';
  $body_classes.= 'Y'==$meta->_access['private'] ? 'is-private ':'not-private ';

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
	$inner =<<<EOF
  $poster
  <video class="oup-html5-media" poster="$meta->poster_url" width="$meta->width" height="$player_height" controls>
    <source src="$meta->media_url" type='video/mp4; codecs="bogus"' /><!--Was: codecs="bogus", avc1.4D401E, mp4a.40.2 -->
    <div id="no-support">$support_text</div>
  </video>
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
?>
<!DOCTYPE html><html lang="en"><meta charset="utf-8" /><title><?=$meta->title ?> | <?=t('OU player') ?></title>
<meta name="copyright" value="&copy; 2011 The Open University" />
<!--[if lt IE 9]><?php /*http://diveintohtml5.org/semantics.html#new-elements*/ ?>

<script>
var e = ("abbr,audio,figure,output,time,video").split(',');
for (var i=0; i < e.length; i++){ document.createElement(e[i]); }
</script>
<![endif]-->

<link rel="stylesheet" href="<?=$base_url ?>assets/ouplayer/ouplayer.core.css" />
<?php if('ouice-dark'==$theme): ?>
<link rel="stylesheet" href="<?=$base_url ?>assets/ouplayer/ouice-dark/ouice-dark.css" />
<?php elseif('ouice-bold'==$theme): ?>
<link rel="stylesheet" href="<?=$base_url ?>assets/ouplayer/ouice-bold/ouice-bold.css" />
<?php endif; ?>
<link rel="icon" href="<?=$base_url ?>assets/favicon.ico" />

<!--[if lt IE 9]>
<style>
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
*/ ?>
<body role="application" id="ouplayer" class="<?=$body_classes ?>">

<div id="XX-ouplayer-outer">

<?php //=$audio_poster ?>
<div id="ouplayer-div" data-XX-style="width:<?=$meta->width ?>px; height:<?=$meta->object_height ?>px;">
<?=$inner ?>

</div>

<?php if($meta->transcript_html || $debug): ?>
<div role="document" id="transcript" class="oup-tscript-panel" >
<button class="tscript-close" aria-label="<?=('Close')?>" title="<?=t('Close script') ?>"><span>X</span></button>
<div class="transcript">
<?= $meta->transcript_html ? $meta->transcript_html : '[No transcript - debug]'; ?>
</div>
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
  <a href="<?=$meta->media_url ?>"><?=t('Download')." $meta->title" ?></a>
</div>

<div role="tooltip" id="oup-tooltips"></div>


<script src="<?=$base_url ?>swf/flowplayer-3.2.6.min.js"></script>
<!--
<script src="<?=$base_url ?>swf/flowplayer-src-r652.js"></script>
<script src="<?=$base_url ?>swf/flashembed.min.js"></script>
-->
<script src="<?=$base_url ?>swf/flowplayer.controls-OUP.js"></script>
<script src="<?=$base_url ?>assets/ouplayer/ouplayer.tooltips.js"></script>
<script src="<?=$base_url ?>assets/ouplayer/ouplayer.behaviors.js"></script>
<script>
flashembed.domReady(function(){
  //var f=$f("ouplayer-div");

//OUP.dir(flashembed);
OUP.log('domReady');

//TODO: check minimum Flash requirement!
if (flashembed.isSupported([6,0,65])) {
  //Accessibility: wmode=opaque would be bad if we relied on Flash controls.
  OUP.player = $f("ouplayer-div", {src:"<?=$base_url ?>swf/flowplayer-3.2.7.swf", wmode:'opaque'}, {

    onError: function(code, message){
      OUP.log('onError: '+code+', '+message);
    },

    clip:{
<?php /*url: "<?=$meta->media_url ?->",*/ ?>
	  scaling: 'fit',
	  autoPlay:false,
	  autoBuffering:true
	},

    playlist:[
<?php /*{"url":"<?=$meta->poster_url ?->"}, //duration:1},*/ ?>
      {"url":"<?=$meta->media_url ?>", "autoPlay":false,"autoBuffering":true <?php if ($meta->caption_url): ?>
      ,
      "captionUrl":"<?=$meta->caption_url ?>"<?php endif; ?>}
    ],

    plugins: {
<?php if ($meta->caption_url): ?>
"captions":{"url":"flowplayer.captions-3.2.3.swf", "captionTarget":"content"},
"content": {
  "url":"flowplayer.content-3.2.0.swf",
  "bottom":5, //30,
<?php /*"width":"90%"<-?=($meta->width - 60) //Percent fails - why? */
  $captions_background = true;
  if ($captions_background): ?>
  "backgroundColor":"#000000",
  "backgroundGradient":"low",
  "borderRadius":8,
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
	  controls: null //Disable default controls.
	}
    //plugins: {controls:{autohide:false}}

  // install HTML controls inside element whose id is "X".
  }).controls("controls", {duration: <?=$meta->duration ?>});

  OUP.initialize();
}
else{
  OUP.html5_fallback('<?=$meta->media_type ?>');

  OUP.log('fallback');
}
});
</script>

</body></html>