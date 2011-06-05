/*!
 * OU Player behaviours.
 * Copyright 2011 The Open University.
 * http://embed.open.ac.uk
 */
//(NDF, 2011-04-08/-04-27/-05-18)
//The OU player object.
var OUP = OUP || {};
(function(){

  OUP.player=null;

  var player_id= 'ouplayer',
      div_id   = 'ouplayer-div',
      play_btn_id= 'oup-play-control',
      script_btn = 'tscript',
      controls_id= 'controls',
      controls_class=("X-play,back,forward,quieter,louder,mute,tscript,popout,related,more,captn,fulls").split(','),
      wrap;

  //Utilities.
  OUP.log=function(o){ if(window.console&&console.log){console.log('OUP: '+o);} };
  OUP.dir=function(o){ if(window.console&&console.dir){console.dir(o);} };

  function byId(id){
    return document.getElementById(id);
  }
  function byClass(name) {
    var par = wrap ? wrap : document,
        els = par.getElementsByTagName("*");
        re = new RegExp("(^|\\s)" + name + "(\\s|$)"),
        i=0;
    for (i in els) {
      if (re.test(els[i].className)) {
        return els[i];
	  }
    }
  }

  //http://snipplr.com/view/3561/addclass-removeclass-hasclass/
  function hasClass(ele,cls) {
    return ele.className.match(new RegExp('(\\s|^)'+cls+'(\\s|$)'));
  }

  function addClass(ele,cls) {
    if (!hasClass(ele,cls)) ele.className += " "+cls;
    ele.className.replace(/ +/g,' '); //+
  }

  function removeClass(ele,cls) {
    if (hasClass(ele,cls)) {
      var reg = new RegExp('(\\s|^)'+cls+'(\\s|$)');
      ele.className=ele.className.replace(reg,''); //+-
    }
  }

  //Geoffrey Summerhayes|http://bytes.com/topic/javascript/answers/640929-obtain-function-name
  function fnName(fn){
    var name=/\W*function\s+([\w\$]+)\(/.exec(fn);
    if(!name)return 'No name';
    return name[1];
  };

  //Scott Andrew|http://dustindiaz.com/top-ten-javascript
  function addEvent(elm, evType, fn, useCapture) {
	if (!elm || !evType){
      OUP.log('Warning, addEvent el:'+elm+', '+evType+', '+fnName(fn));
    } else if(elm.addEventListener){
      OUP.log('OK, addEvent el:'+elm+', '+evType+', '+fnName(fn));
	  elm.addEventListener(evType, fn, useCapture);
      return true;
    } else if(elm.attachEvent){
      return elm.attachEvent('on' + evType, fn);
    } else{
      elm['on' + evType] = fn;
    }
  };

  function attachTooltip(name) {
	  var tip,
	      btn = byClass(name);
	  if(!btn)return;
	  tip = btn.getAttribute('aria-label');
	  btn.onmouseover=function(){ OUP.fixedtooltip(tip, btn, {type:'mouseover'}); }
	  btn.onmouseout =function(){ OUP.delayhidetip(); }
	  //Hmm, spoofing an event?! {type:"X"}
      btn.onfocus    =function(){OUP.fixedtooltip(tip, btn, {type:'focus'});} //this?
      btn.onblur     =function(){OUP.delayhidetip();}
  }

  function setFocus(el){
    if (el){
      el.focus();
      OUP.log('setFocus: '+el);
    }
    return false;//Stop event propagation (needs more work!)
  };


  OUP.initialize=function() {
    var self = this,
        ply = byId(player_id),
        div = byId(div_id),
        controls_div = byId(controls_id),
        play_btn = byId(play_btn_id),
        ctl;

    div.style.display='block';
    controls_div.style.display='block';

    //TODO: Explicitly add/remove wait-cursor/ spinner.
    setTimeout(function(){ply.style.cursor='default';}, 4000);

    //var wrap = controls_div; //document.getElementById('oup-controls');

    if (OUP.fixedtooltip && OUP.delayhidetip) {
      for (ctl in controls_class) {
        attachTooltip(controls_class[ctl]);
      }
    }

	//Transcript button.
	function toggleScript() {
	  //var panel = document.getElementById('ouplayer-panel');
	  if (hasClass(ply, 'hide-tscript')) {
	    removeClass(ply, 'hide-tscript');
        addClass(ply, 'show-tscript');
        self.log('toggleScript: show');
	  } else {
	    removeClass(ply, 'show-tscript');
        addClass(ply, 'hide-tscript');
        self.log('toggleScript: hide');
      }
	};
	byClass(script_btn).onclick = toggleScript;
	addEvent(byClass('tscript-close'), 'click', toggleScript);
	//byClass('t-close').onclick = toggleScript;

	//More/settings button.
	function toggleSettings() {
	  //var panel = document.getElementById('ouplayer-panel');
	  if (hasClass(ply, 'hide-settings')) {
	    removeClass(ply, 'hide-settings');
	    addClass(ply, 'show-settings');
	    self.log('toggleSettings: show');
	    return setFocus(byClass('more-close'));
	  } else {
	    removeClass(ply, 'show-settings');
	    addClass(ply, 'hide-settings');
	    self.log('toggleSettings: hide');
	    return setFocus(byClass('more'));
	  }
	};
	addEvent(byClass('more'), 'click', toggleSettings);
	addEvent(byClass('more-close'), 'click', toggleSettings);

	function embedCode(){
	  this.select(); self.log('embedSelect');
	};
	addEvent(byClass('emcode-opt'), 'focus', embedCode);
	addEvent(byClass('emcode-more'), 'focus', embedCode);

	//Captions button.
	function toggleCaptions() {
	  if (hasClass(ply, 'hide-captions')) {
	    removeClass(ply, 'hide-captions');
        addClass(ply, 'show-captions');
		//self.player.getClip().update({'showCaptions':true});
		self.player.getPlugin('content').css({"display":"block"}); //show();//enable(true);
        self.log('toggleCaptions: show');
	  } else {
	    removeClass(ply, 'show-captions');
        addClass(ply, 'hide-captions');
		//self.player.getClip().update({'showCaptions':false});
		self.player.getPlugin('content').css({"display":"none"}); //hide();//enable(false);
        self.log('toggleCaptions: hide');
      }
	};
	addEvent(byClass('captn'), 'click', toggleCaptions);

	addEvent(byClass('fulls'), 'click',(function toggleFullScreen(){
	  self.log('fullscreen');
	  self.player.toggleFullscreen();
	}));

	self.player.onVolume(function(vol){
		byClass('volume-out').value = parseInt(vol)+'%';
		self.log('onVolume: '+parseInt(vol)+'%');
	});

    /*self.player.onError(function(code, message){
      self.log('onError '+code+', '+message);
    });*/
	self.player.onStart(function(clip){
	  self.log('onStart: clip '+clip.index);
    });

    self.player.onResume(function(clip){
	  var tx=play_btn.getAttribute('data-pause-text');
	  play_btn.setAttribute('aria-label', tx);
	  play_btn.title=tx;
	  removeClass(ply, 'oup-paused');
	  addClass(ply, 'oup-playing');
	  self.log('onResume: clip '+clip.index+'; text '+tx);
    });

	self.player.onPause(function(clip){
	  var tx=play_btn.getAttribute('data-play-text');
	  play_btn.setAttribute('aria-label', tx);
	  play_btn.title=tx;
	  removeClass(ply, 'oup-playing');
	  addClass(ply, 'oup-paused');
	  self.log('onPause: clip '+clip.index+'; text '+tx);
    });

  };//OUP.initialize

  //M.Pilgrim|http://diveintohtml5.org/everything.html#video
  function supports_video(){
    return !!document.createElement('video').canPlayType;
  };

  OUP.supports_h264_baseline_video = function() {
    var v = document.createElement('video');
    return !!(v.canPlayType && v.canPlayType('video/mp4; codecs="avc1.42E01E, mp4a.40.2"').replace(/no/, ''));
  };

  OUP.supports_mp3_audio = function(){
    var a = document.createElement('audio');
    return !!(a.canPlayType && a.canPlayType('audio/mpeg;').replace(/no/, ''));
  };

  OUP.html5_fallback = function(type){
	var html5_media = byClass('oup-html5-media'),
	    poster = byClass('oup-poster'),
	    ctrl = byClass('oup-controls');

	if (('video'===type && OUP.supports_h264_baseline_video())
	 || ('audio'===type && OUP.supports_mp3_audio())) {

	  html5_media.style.display = 'block';
	  poster.style.display = 'none';
	  ctrl.style.display = 'none';
	} else {
	  OUP.log('Error, unexpected type value: '+type);
	}
  };

})();
