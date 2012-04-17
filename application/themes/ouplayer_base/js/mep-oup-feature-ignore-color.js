/**
* OU player: Detect high contrast/ ignore colours browser/OS mode.
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

$(document).ready(function () {

  /*
    The following code detects high contrast mode.
    It works because in high contrast mode the reported background color will not
    be the same as it was explicitly set. 
  */
  // add an element with explicit background color set
  $("body").append("<p id='hcmtest' style='position:absolute;top:0;left:-99999px;background-color:#878787;'>T</p>");
  var testcolor = $("#hcmtest").css("background-color").toLowerCase(); // now get the background color
  $("#hcmtest").remove(); // no longer needed
  // different browsers return the color in different ways
  if (testcolor != "#878787" && testcolor != "rgb(135, 135, 135)") {
    // make any specific changes for high contrast mode here
    $("#msg").html("<p>FYI: In high contrast mode.</p>");
  }

  /*
  $(".disclose1, .disclose2").click(function() {
    $(this).toggleClass("closed").parent().next("p").eq(0).toggleClass("closed");
  });

  fixIcons($("#case2"));
  */
});
	
})(mejs.$);