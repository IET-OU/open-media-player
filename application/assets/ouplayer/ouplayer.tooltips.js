/*!
 * OU player 'Fixed ToolTip script'.
 * ©Dynamic Drive (www.dynamicdrive.com)
 * Modifications, ©2011 The Open University.
 */
//The OU player object. (N.D.Freear, 2011-04-08)
var OUP = OUP || {};
(function(){
/***********************************************
* Fixed ToolTip script- © Dynamic Drive (www.dynamicdrive.com)
* This notice MUST stay intact for legal use
* Visit http://www.dynamicdrive.com/ for full source code
***********************************************/

var tooltip_id='oup-tooltips',
    tip_attr='aria-label',
    tipwidth='150px', //default tooltip width
    tipbgcolor='lightyellow',  //tooltip bgcolor
    disappeardelay=250,  //tooltip disappear speed onMouseout (in miliseconds)
    vertical_offset="-47px", //"0px"; //-28; //vertical offset of tooltip from anchor link
    horizontal_offset="0px"; //"-3px"; //horizontal offset of tooltip from anchor link

/////No further editting needed
var delayhidetip=false,
    dropmenuobj =false;

var ie4=document.all,
    ns6=document.getElementById&&!document.all;

/*Not required. if(ie4||ns6){
  window.onload = function(){
    var e=document.createElement("div");
    e.id="fixedtipdiv";
    document.getElementsByTagName("body")[0].appendChild(e);
  }
  //document.write('<div id="fixedtipdiv" data-style="visibility:hidden;width:'+tipwidth+';background-color:'+tipbgcolor+'" ></div>')
}*/

function getposOffset(what, offsettype){
  var totaloffset=(offsettype=="left")? what.offsetLeft : what.offsetTop;
  var parentEl=what.offsetParent;
  while (parentEl!=null){
    totaloffset=(offsettype=="left")? totaloffset+parentEl.offsetLeft : totaloffset+parentEl.offsetTop;
    parentEl=parentEl.offsetParent;
  }
  return totaloffset;
}

function showhide(obj, e, visible, hidden, tipwidth){
  if (ie4||ns6){
    dropmenuobj.style.left=dropmenuobj.style.top=-500;
  }
  /*MSIE bug/ not required. if(tipwidth!=""){
    dropmenuobj.widthobj=dropmenuobj.style;
    dropmenuobj.widthobj.width=tipwidth;
  }*/
  //NDF: added 'focus'.
  if (e.type=="click" && obj.visibility==hidden || e.type=="mouseover" || e.type=="focus") {
    obj.visibility=visible;
  } else if (e.type=="click") {
    obj.visibility=hidden;
  }
}

function iecompattest(){
  return (document.compatMode && document.compatMode!="BackCompat")? document.documentElement : document.body;
}

function clearbrowseredge(obj, whichedge){
  var edgeoffset=(whichedge=="rightedge")? parseInt(horizontal_offset)*-1 : parseInt(vertical_offset)*-1;
  if (whichedge=="rightedge"){
    var windowedge=ie4 && !window.opera? iecompattest().scrollLeft+iecompattest().clientWidth-15 : window.pageXOffset+window.innerWidth-15;
    dropmenuobj.contentmeasure=dropmenuobj.offsetWidth;
    if (windowedge-dropmenuobj.x < dropmenuobj.contentmeasure){
      edgeoffset=dropmenuobj.contentmeasure-obj.offsetWidth;
	}
  }
  else{
    var windowedge=ie4 && !window.opera? iecompattest().scrollTop+iecompattest().clientHeight-15 : window.pageYOffset+window.innerHeight-18;
    dropmenuobj.contentmeasure=dropmenuobj.offsetHeight;
    if (windowedge-dropmenuobj.y < dropmenuobj.contentmeasure){
      edgeoffset=dropmenuobj.contentmeasure+obj.offsetHeight
	}
  }
  return edgeoffset
}
//Public methods.
//TODO: voffset
OUP.fixedtooltip=function(menucontents, obj, e, voffset, tipwidth, className){
  if (window.event) event.cancelBubble=true;
  else if (e && e.stopPropagation) e.stopPropagation();
  clearhidetip();
  dropmenuobj=document.getElementById? document.getElementById(tooltip_id) : fixedtipdiv;
  var tip=obj.getAttribute(tip_attr);
  dropmenuobj.innerHTML = tip ? tip : menucontents;
  OUP.log('tt-'+className);
  if (typeof className==='string'){
    dropmenuobj.className='tt-'+className;
  }
  if (ie4||ns6){
    showhide(dropmenuobj.style, e, "visible", "hidden", voffset, tipwidth);
    dropmenuobj.x=getposOffset(obj, "left");
    dropmenuobj.y=getposOffset(obj, "top");
    dropmenuobj.style.left=dropmenuobj.x-clearbrowseredge(obj, "rightedge")+"px";
    dropmenuobj.style.top=dropmenuobj.y-clearbrowseredge(obj, "bottomedge")+/*obj.offsetTop+"px";*/obj.offsetHeight+"px";
  }
}

OUP.hidetip=function(e){
  if (typeof dropmenuobj!="undefined"){
    if (ie4||ns6){
      if(dropmenuobj.style)dropmenuobj.style.visibility="hidden";
    }
  }
}

OUP.delayhidetip=function(){
  if (ie4||ns6){
    delayhide=setTimeout("OUP.hidetip()",disappeardelay);
  }
}

function clearhidetip(){
  if (typeof delayhide!="undefined"){
    clearTimeout(delayhide);
  }
}
})();
/*
<div id="fixedtipdiv"></div>
<button
  onmouseover="OUP.fixedtooltip(this.getAttribute('aria-label'), this, event)"
  onmouseout="OUP.delayhidetip()"
  onfocus="OUP.fixedtooltip(this.getAttribute('aria-label'), this, event)"
  onblur="OUP.delayhidetip()"
  aria-label="Play (@aria-label)"
  >Play</button>
*/