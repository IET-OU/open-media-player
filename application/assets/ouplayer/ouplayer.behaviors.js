/*!
 * OU Player behaviours.
 * ©2011 The Open University.
 */
//(N.D.Freear, 2011-04-08/-04-27/-05-18)
//The OU player object.
//var OUP = OUP || {};
(function(){

  OUP.player=null;

  var player_id= 'ouplayer',
      div_id   = 'ouplayer-div',
      play_btn_id= 'oup-play-control',
      script_btn = 'tscript',
      controls_id= 'controls',
      controls_class=("play,back,forward,quieter,louder,mute,tscript,popout,related,more,captn,fulls").split(','),
      wrap;

  //Utilities.
  OUP.log=function(o){ if(window.console&&console.log){console.log('OUP: '+o);} };//{ typeof window.console=='object' && typeof console.log!='undefined' && console.log('OUP: '+o); };
  OUP.dir=function(o){ if(window.console&&console.dir){console.dir(o);} };

  function byId(id){
    return document.getElementById(id);
  }
  function byClass(name) {
    var par = wrap ? wrap : document,
        els = par.getElementsByTagName("*"),
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
      ele.className=ele.className.replace(reg,' '); //+-
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
	  var btn = byClass(name);
	  if(!btn)return;
	  //var tip = btn.getAttribute('aria-label');
	  btn.onmouseover=function(){ OUP.fixedtooltip(false, btn, {type:'mouseover'}, false,false, name); }
	  btn.onmouseout =function(){ OUP.delayhidetip(); }
	  //Hmm, spoofing an event?! {type:"X"}
	  btn.onfocus    =function(){OUP.fixedtooltip(false, btn, {type:'focus'}, false,false, name);} //this?
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

    //Beware: MSIE 8 sniffing!
    if (typeof document.documentMode!=='undefined') {
      ply.className += ' -docmode'+document.documentMode;
    } else {
      ply.className += ' -no-docmode';
    }
    /*if (typeof document.compatMode!=='undefined') {
      ply.className += ' -cmode'+document.compatMode;
    }*/

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
	addEvent(byClass(script_btn), 'click', toggleScript);
	addEvent(byClass('tscript-close'), 'click', toggleScript);
	addEvent(byClass('tscript-close-end'), 'click', toggleScript);
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

	function handleEmbedCode(cn){
	  var events=['focus','click'/*,'dblclick','select','keypress'*/],
	      elem=byClass(cn),
		  ev;
	  for (ev in events){
	    addEvent(elem, events[ev], function em(e){
		  if(elem){ elem.select() }
	      self.log('embedCode: '+cn+', '+e.type);
	    });
	  }
	  //preventDefault: https://bugs.webkit.org/show_bug.cgi?id=22691
	  addEvent(elem, 'mouseup', function(e){
	    if(typeof e.preventDefault!=='undefined'){ e.preventDefault() }
	  });
	}
	handleEmbedCode('emcode-opt');
	handleEmbedCode('emcode-more');

    function toggleCtlFocus(){
      if (hasClass(ply, 'ctl-focus')) {
	    removeClass(ply, 'ctl-focus');
	    addClass(ply, 'ctl-blur');
	    self.log('toggleCtl: blur');
	  } else {
	    removeClass(ply, 'ctl-blur');
	    addClass(ply, 'ctl-focus');
	    self.log('toggleCtl: focus');
	  }
    };
    addEvent(byClass('oup-controls'), 'focus', toggleCtlFocus, true);
    addEvent(byClass('oup-controls'), 'blur', toggleCtlFocus, true);

    function toggleVolFocus(){
      if (hasClass(ply, 'vol-focus')) {
	    removeClass(ply, 'vol-focus');
	    addClass(ply, 'vol-blur');
	    self.log('toggleVol: blur');
	  } else {
	    removeClass(ply, 'vol-blur');
	    addClass(ply, 'vol-focus');
	    self.log('toggleVol: focus');
	  }
    };
    addEvent(byClass('volume-inner'), 'focus', toggleVolFocus, true);
    addEvent(byClass('volume-inner'), 'blur', toggleVolFocus, true);

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

	function toggleFullScreen(){
	  self.player.toggleFullscreen();
	  self.log('fullscreen');
	}
	addEvent(byClass('fulls'), 'click', toggleFullScreen);

	self.player.onVolume(plVolume = function(vol){
		var v=parseInt(vol);
		byClass('volume-out').value = v+'%';
		byClass('vol-bg-inner').style.width = v+'%';
		byClass('volume-fg').title = v+'%';
		self.log('onVolume: '+v+'%');
	});

	function plPlay(clip){
	  var tx=play_btn.getAttribute('data-pause-text');
	  play_btn.setAttribute('aria-label', tx);
	  play_btn.title=tx;
	  removeClass(ply, 'oup-paused');
	  addClass(ply, 'oup-playing');
	  self.log('plPlay: clip '+clip.index+'; text '+tx);
	}
	function plPause(clip){
	  var tx=play_btn.getAttribute('data-play-text');
	  play_btn.setAttribute('aria-label', tx);
	  play_btn.title=tx;
	  removeClass(ply, 'oup-playing');
	  addClass(ply, 'oup-paused');
	  self.log('plPause: clip '+clip.index+'; text '+tx);
	}

    /*self.player.onError(function(code, message){
      self.log('onError '+code+', '+message);
    });*/
	self.player.onStart(function(clip){
	  plVolume(self.player.getVolume());
	  self.log('onStart: clip '+clip.index);
    });
	self.player.onBegin(function(clip){
	  plPlay(clip);
	  self.log('onBegin: clip '+clip.index);
	});
    self.player.onResume(function(clip){
	  plPlay(clip);
    });

	self.player.onPause(function(clip){
	  plPause(clip);
    });
	self.player.onStop(function(clip){
	  plPause(clip);
	  self.log('onStop: clip '+clip.index);
    });
	//onLastSecond?
	self.player.onFinish(function(clip){
	  plPause(clip);
	  self.log('onFinish: clip '+clip.index);
    });

    addClass(ply, 'use-flash js');
  };//OUP.initialize

  //M.Pilgrim|http://diveintohtml5.org/everything.html#video
  /*function supports_video(){
    return !!document.createElement('video').canPlayType;
  }*/

  function supports_h264_baseline_video(){
    var v = document.createElement('video');
    return !!(v.canPlayType && v.canPlayType('video/mp4; codecs="avc1.42E01E, mp4a.40.2"').replace(/no/, ''));
  };
  function supports_mp3_audio(){
    var a = document.createElement('audio');
    return !!(a.canPlayType && a.canPlayType('audio/mpeg;').replace(/no/, ''));
  };
  OUP.supports_flash = function() {
    var ua=navigator.userAgent;
    if (ua.indexOf('Android') !== -1) {
      OUP.log('Android');
      //alert('Android');
    }
	//TODO: check minimum Flash requirement!
	return (flashembed.isSupported([6,0,65]) && ua.indexOf('Android')===-1/* && ua.indexOf('WebKit')!==-1*/);
  };

  OUP.html5_fallback = function(type){
	var html5_media = byClass('oup-html5-media'),
	    poster = byClass('oup-poster'),
	    ctrl = byClass('oup-controls'),
	    //ttl = byClass('oup-title panel'),
	    ply = byId(player_id),
	    div = byId(div_id);

	div.style.display='block';

	if (('video'===type && supports_h264_baseline_video())
	 || ('audio'===type && supports_mp3_audio())) {

	  OUP.log(html5_media);
	  addClass(ply, 'html5-fallback use-html5-media js');

	  html5_media.style.display = 'block';
	  poster.style.display = 'none';
	  ctrl.style.display = 'none';
	  //ttl.style.display='none';
      OUP.log('html5 fallback');
	} else {
	  OUP.log('Error, unexpected type value: '+type);
	}
  };

})();
