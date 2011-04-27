<?php
//NDF, 2011-04-08.
/** OU player iframe.
 *
 * @copyright Copyright 2011 The Open University.
 
Test, video:  /ouplayer/embed/pod/mst209-fun-of-the-fair/a67918b334?width=640&height=420
Test, audio:  /ouplayer/embed/pod/l314-spanish/fe481a4d1d?width=400&height=60&poster=0
 */
  $base_url = base_url();

# Media: 512 x 288.
# Player:512 x 318;
  $player_height = $meta->height; #+ 30.
  $media_height = $meta->height - 60;
  $legacy_height = $meta->height - 30;
  // Hold poster image for audio-player.
  $audio_poster = null;

  $inner=$poster='';
  if ($meta->poster_url) {
    $poster = "<img class=\"poster\" alt=\"\" src=\"$meta->poster_url\" />";
  }
  if ($meta->media_html5 && 'video' == $meta->media_type) {
    $support_text = t('Your browser does not support the "video" element.');
	$inner =<<<EOF
  <video poster="$meta->poster_url" width="$meta->width" height="$player_height" controls>
    <source src="$meta->media_url" type='video/mp4; codecs="bogus"' /><!--Was: codecs="bogus", avc1.4D401E, mp4a.40.2 -->
    $poster<div>$support_text</div>
  </video>
EOF;
  }
  elseif ($meta->media_html5 && 'audio' == $meta->media_type) {
	$audio_poster = $poster;
	$support_text = t('Your browser does not support the "audio" element.');
	$inner =<<<EOF
  <audio src="$meta->media_url" style="width:{$meta->width}px; height:{$meta->object_height}px;" controls
   >$suppport_text</audio>
EOF;
  }
?>
<!DOCTYPE html><html lang="en"><meta charset="utf-8" /><title><?=$meta->title ?> | <?=t('OU player') ?></title>
<meta name="copyright" value="&copy; 2011 The Open University" />
<!--[if lt IE 9]><?php /*http://diveintohtml5.org/semantics.html#new-elements*/ ?>

<script>
var e = ("abbr,audio,figure,time,video").split(',');
for (var i=0; i < e.length; i++){ document.createElement(e[i]); }
</script>
<![endif]-->

<link rel="stylesheet" href="<?=$base_url ?>assets/ouplayer/ouplayer.core.css" />
<link rel="icon" href="<?=$base_url ?>assets/favicon.ico" />

<?php /*
<script type="text/javascript" src="http://www.universalsubtitles.org/site_media/js/mirosubs-widgetizer.js">
        </script>
*/ ?>
<body role="application" id="ouplayer" class="oup oup-paused <?=$meta->media_type ?> w<?=$meta->width ?> hide-script">

<?=$audio_poster ?>
<div id="ouplayer-div" style="width:<?=$meta->width ?>px; height:<?=$meta->object_height ?>px;">
<?=$inner ?>

</div>

<div id="ouplayer-panel" >
<button class="t-close" aria-label="<?=('Close')?>">X</button>
<div class="transcript">
<?= $meta->transcript_html ?>
</div>
</div>

<noscript>
<?php
  // Basic no-script Flash-Flowplayer solution.
  $view_data = array('inner'=>$inner);
  $this->load->view('ouplayer/player_noscript.php', $view_data);
?>
</noscript>

<div id="oup-controls" role="toolbar" aria-label="<?=t('Player controls')?>" class="hulu">
<!-- These events will be attached unobtrusively!! -->
<button
  class="play oup-play-control" <?php /*onmouseover="OUP.fixedtooltip(this.getAttribute('aria-label'), this, event)"
  onmouseout="OUP.delayhidetip()"
  onfocus="OUP.fixedtooltip(this.getAttribute('aria-label'), this, event)"
  onblur="OUP.delayhidetip()" */
  //Play video ?  ?>
  aria-label="<?=t('Play')?>"
  data-play-text="<?=t('Play')?>" data-pause-text="<?=t('Pause')?>"><span>P</span></button>
<div class="oupc-r1">
 <button class="back" aria-label="<?=t('Rewind')?>">&lt;</button>
 <div class="sl track">
  <span class="sl buffer"></span>
  <span class="sl progress"></span>
  <span class="sl playhead"></span>
 </div>
 <button class="forward" aria-label="<?=t('Fast forward')?>">&gt;</button>
 <span class="time" aria-label="<?=t('Progress')?>"></span>
 <input class="x-time" readonly style="display:none" />
</div>
<div class="oupc-r2">
 <button class="mute" aria-label="<?=t('Mute')?>"
  data-mute-text="<?=t('Mute')?>" data-unmute-text="<?=t('Unmute')?>">mute</button>
 <button class="louder"  aria-label="<?=t('Louder')?>">+</button>
 <button class="quieter" aria-label="<?=t('Quieter')?>">&ndash;</button>
 <input class="x-volume" readonly aria-label="<?=t('Volume')?>" style="display:none" />

 <button class="captn" aria-label="<?=t('Captions')?>">CC</button>
 <button class="script" aria-label="<?=t('Show script')?>"
  data-show-text="<?=t('Show script')?>" data-hide-text="<?=t('Hide script')?>">T</button>

 <a href="<?=$meta->_related_url ?>" target="_blank" class="related" aria-label="<?=t('New window: related link…')?>">rel</a>
 <a href="#" target="_blank" class="popout" aria-label="<?=t('New window: pop out player')?>">pop</a>
 <button class="fulls" aria-label="<?=t('Full screen')?>">F</button>
 <button class="more" aria-label="<?=t('More&hellip;')?>">more</button>
</div>
</div>

<div id="media-links" style="display:none">
  <a href="<?=$meta->media_url ?>"><?=t('Download')." $meta->title" ?></a>
</div>

<div id="oup-tooltips"></div>

<script src="<?=$base_url ?>swf/flowplayer-3.2.6.min.js"></script>
<script src="<?=$base_url ?>swf/flowplayer.controls-OUP.js"></script>
<script src="<?=$base_url ?>assets/ouplayer/ouplayer.tooltips.js"></script>
<script src="<?=$base_url ?>assets/ouplayer/ouplayer.behaviors.js"></script>
<script>
flashembed.domReady(function(){
  //var f=$f("ouplayer-div");

  $f("ouplayer-div", "<?=$base_url ?>swf/flowplayer-3.2.7.swf", {

    clip:{
	  //url: "<?=$meta->media_url ?>",
	  scaling: 'fit',
	  autoPlay:false,
	  autoBuffering:true
	},

    playlist:[
      {"url":"<?=$meta->poster_url ?>", duration:1},
      {"url":"<?=$meta->media_url ?>", "autoPlay":false,"autoBuffering":true}
    ],

    // disable default controls
    plugins: {controls: null}
    //plugins: {controls:{autohide:false}}

  // install HTML controls inside element whose id is "hulu"
  }).controls("oup-controls", {duration: <?=$meta->duration ?>});

  OUP.initialize();
});
</script>

</body></html>