﻿<?php
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
    $inner =<<<EOF
  <video poster="$meta->poster_url" width="$meta->width" height="$player_height" controls>
    <source src="$meta->media_url" type='video/mp4; codecs="bogus"' /><!--Was: codecs="bogus", avc1.4D401E, mp4a.40.2 -->
    $poster<div>Your browser does not support the 'video' element.</div>
  </video>
EOF;
  }
  elseif ($meta->media_html5 && 'audio' == $meta->media_type) {
	$audio_poster = $poster;
	$inner =<<<EOF
  <audio src="$meta->media_url" style="width:{$meta->width}px; height:{$meta->object_height}px;" controls>Your browser does not support the 'audio' element.</audio>
EOF;
  }
?>
<!DOCTYPE html><html lang="en"><meta charset="utf-8" /><title><?=$meta->title ?> | OUVLE player</title>
<meta name="copyright" value="&copy; 2011 The Open University" />
<!--[if lt IE 9]><?php /*http://diveintohtml5.org/semantics.html#new-elements*/ ?>

<script>
var e = ("abbr,audio,figure,time,video").split(',');
for (var i=0; i < e.length; i++){ document.createElement(e[i]); }
</script>
<![endif]-->
<script src="<?=$base_url ?>swf/flowplayer-3.2.6.min.js"></script>
<script src="<?=$base_url ?>swf/flowplayer.controls-OUP.js"></script>
<script src="<?=$base_url ?>assets/ouplayer/ouplayer.tooltips.js"></script>

<link rel="stylesheet" href="<?=$base_url ?>assets/ouplayer/ouplayer.core.css" />
<link rel="icon" href="<?=$base_url ?>assets/favicon.ico" />

<body role="application" id="ouplayer oup-paused">

<?=$audio_poster ?>
<div id="ouplayer-div" style="width:<?=$meta->width ?>px; height:<?=$meta->object_height ?>px;">
<?=$inner ?>

</div>

<noscript>
<?php
  // Basic no-script Flash-Flowplayer solution.
  $view_data = array('inner'=>$inner);
  $this->load->view('ouplayer/player_noscript.php', $view_data);
?>
</noscript>

<div id="oup-controls" role="toolbar">
<!-- These events will be attached unobtrusively!! -->
<button
  class="play oup-play-control"
  <?php /*onmouseover="OUP.fixedtooltip(this.getAttribute('aria-label'), this, event)"
  onmouseout="OUP.delayhidetip()"
  onfocus="OUP.fixedtooltip(this.getAttribute('aria-label'), this, event)"
  onblur="OUP.delayhidetip()" */ ?>
  aria-label="Play video"
  data-play-label="Play video"
  data-pause-label="Pause video"
  ><span>P</span></button>
<button class="back" aria-label="Seek back">&lt;</button>
<div class="track">
  <div class="buffer"></div>
  <div class="progress"></div>
  <div class="playhead"></div>
</div>
<button class="forward" aria-label="Seek forward">&gt;</button>
<span class="time"></span>
<input class="x-time" style="display:none" />

<button class="mute" aria-label="Mute">mute</button>
<button class="louder"  aria-label="Louder">+</button>
<button class="quieter" aria-label="Quieter">&ndash;</button>

<button class="script" aria-label="Show/hide transcript">T</button>
<a href="#" target="_blank" class="popout" aria-label="New window: pop out player">pop</a>
<a href="<?=$meta->_related_url ?>" target="_blank" class="related" aria-label="New window: related link...">rel</a>
<button class="more" aria-label="More...">more</button>
</div>

<div id="media-links" style="display:none">
  <a href="<?=$meta->media_url ?>">Download <?=$meta->title ?></a>
</div>

<script>
flashembed.domReady(function(){
  var div=document.getElementById("ouplayer-div");
  var controls=document.getElementById("oup-controls");
  div.style.display="block";
  controls.style.display="block";

  //var f=$f("ouplayer-div");

  $f("ouplayer-div", "<?=$base_url ?>swf/flowplayer-3.2.7.swf", {

    "playlist":[
      {"url":"<?=$meta->poster_url ?>"},
      {"url":"<?=$meta->media_url ?>", "autoPlay":false,"autoBuffering":true}
    ],

	// disable default controls
	//plugins: {controls: null}
	plugins: {controls:{autohide:false}}

  // install HTML controls inside element whose id is "hulu"
  }).controls("oup-controls", {duration: 25});

  	function byClass(name) {
		var els = wrap.getElementsByTagName("*");		
		var re = new RegExp("(^|\\s)" + name + "(\\s|$)");
		for (var i = 0; i < els.length; i++) {
			if (re.test(els[i].className)) {
				return els[i];
			}
		}
	}

	var wrap = controls; //document.getElementById('oup-controls');

	function attachTooltip(name) {
	  var btn = byClass(name);
	  var tip = btn.getAttribute('aria-label');
	  btn.onmouseover=function(){ OUP.fixedtooltip(tip, btn, {type:"mouseover"}); }
	  btn.onmouseout =function(){ OUP.delayhidetip(); }
	  //Hmm, spoofing an event?! {type:"X"}
      btn.onfocus    =function(){OUP.fixedtooltip(this.getAttribute('aria-label'), this, {type:"focus"});}
      btn.onblur     =function(){ OUP.delayhidetip(); }
	}
	var controls = ("play,back,forward,quieter,louder,mute,script,popout,related,more").split(',');
    for (var i=0; i < controls.length; i++){
    	attachTooltip(controls[i]);
	}
});
</script>

<div id="oup-tooltips"></div>
</body></html>