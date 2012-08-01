/**
* OU player: Detect high contrast/ ignore colours browser/OS modes - accessibility.
* Copyright 2012 The Open University.
* Author: Nick Freear, 2012-04-17
* Author: John Snyder, 2009-11-04
*/
/*
Based on John Snyder's work.
http://stackoverflow.com/questions/1921047/how-to-check-if-user-is-in-high-contrast-mode-via-javascript-or-css
http://hardlikesoftware.com/weblog/2009/11/04/css-sprites-vs-high-contrast-mode/
http://hardlikesoftware.com/projects/HCMtest.html
*/
(function($) {

function oup_detect_ignore_color(){
  /*
    The following code detects high contrast mode.
    It works because in high contrast mode the reported background color will not
    be the same as it was explicitly set. 
  */
  var body = $("body")
  , hcmclass = "no-ignore-color"
  // (No need to append or remove the element.)
  // add an element with explicit background color set, and now get the background color.
  , hcm = $("<p style='position:absolute;top:0;left:-999px;background-color:#878787;'>T</p>")
  , testcolor = hcm.css("background-color").toLowerCase()
  ;
  // different browsers return the color in different ways - beware spaces!
  mejs.isIgnoreColor = (testcolor != "#878787" && testcolor != "rgb(135, 135, 135)");
  if (mejs.isIgnoreColor) {
    hcmclass = "ignore-color";
  }
  body.removeClass('ignore-color no-ignore-color').addClass(hcmclass);
  $.log('> '+hcmclass);
};
// Resize event seems to be fired on change to/from Windows high-contrast.
$(window).resize(oup_detect_ignore_color);

$(document).ready(function(){
  oup_detect_ignore_color();

  //? http://darcyclarke.me/development/detect-attribute-changes-with-jquery/
  /*if (typeof $.browser!='undefined' && $.browser.mozilla){
	$(document).bind("DOMAttrModified", oup_detect_ignore_color);
  }
  */

  // Experimental: works when MSIE/Mozilla enter 'ignore colour' mode (and Mozilla leaves).
  setInterval(oup_detect_ignore_color, 5000);
});

})(mejs.$);