
<h2>Error tests</h2>

<p>The error pages may be visible on OU and non-OU branded pages, hence the OU branding.
<p>These are Iframe-based tests. Note, the error page adapts (using Javascript) to suit the size of the iframe.


<h4 id=404 >404 Not found errors</h4>
<p id=404-1 >Audio: 404.1 Podcast collection not found
<iframe
 class="ou player oembed podcast audio x-small e-404-1"
 width="360" height="80" scrolling="no" frameborder=0
 src="<?php echo site_url('embed/pod/404/abcdef0123#!Collection-not-found') ?>"
 ></iframe>

<p id=404-2 >Video: 404.2 Podcast item not found.
<iframe
 class="ou player oembed podcast video small e-404-2" scrolling="no" frameborder=0
 width="480" height="270"
 style="width:480px; height:270px;"
 src="<?php echo site_url('embed/pod/student-experiences/abcdef0123#!404-Item-not-found') ?>"
 ></iframe>

<p>Site: <a href="<?php echo site_url('404-Page-not-found') ?>">404 Page not found</a>.


<h4 id=400 >400 Bad request errors</h4>
<p id=400-1 >Video: 400.1 Podcast shortcode too long.
<iframe
 class="ou player oembed podcast video medium e-400-1" scrolling="no" frameborder=0
 width="560" height="315"
 style="width:560px; height:315px;"
 src="<?php echo site_url('embed/pod/400/abcdef0123456789#!400-Shortcode-too-long') ?>"
 ></iframe>

<p id=400-2 >Video: 400.2 Podcast shortcode unexpected characters.
<iframe
 class="ou player oembed podcast video large e-400-2" scrolling="no" frameborder=0
 width="640" height="360"
 style="width:640px; height:360px;"
 src="<?php echo site_url('embed/pod/400/Unexpected#!shortcode') ?>"
 ></iframe>



<h4 id=other >Other error texts - for comparison</h4>

<p id=404-yt >YouTube: 404 Video not found/ doesn't exist (just shows the player).
<iframe
 width="420" height="315"
 src="http://www.youtube.com/embed/404-Not-found"
 data-X-src="http://www.youtube.com/embed/TW5faQAjOIw"
 frameborder="0" allowfullscreen></iframe>

<!--
<p>404 Page not found.
<iframe
 width="320" height="200" style="border:1px solid #aaa"
 src="http://www.youtube.com/404_test"></iframe>
-->

<pre>


Todo:

** XML parsing errors..
** 'Missing' data..

* jquery-oembed embed errors..
* VLE error tests
* Caption error tests
* PDF transcript error tests..

See:
* http://podcast.open.ac.uk/404_ERROR
* http://www.open.ac.uk/404_ERROR

</pre>
