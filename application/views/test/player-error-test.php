
<h2>Error tests</h2>

<p>Iframe tests. Note, the error page adapts (using Javascript) to suit the size of the Iframe.
 Also, the error pages may be visible on OU and non-OU branded pages, hence the OU branding.


<h4>404 Not found errors</h4>
<p>Audio: 404.1 Podcast collection not found
<iframe
 class="ou player oembed podcast audio e-404-1"
 width="360" height="80" scrolling="no"
 src="<?php echo site_url('embed/pod/404/abcdef0123#!Collection-not-found') ?>"
 ></iframe>

<p>Video: 404.2 Podcast item not found.
<iframe
 class="ou player oembed podcast video e-404-2"
 width="640" height="400" scrolling="no"
 src="<?php echo site_url('embed/pod/student-experiences/abcdef0123#!404-Item-not-found') ?>"
 ></iframe>

<p>Site: <a href="<?php echo site_url('404-Page-not-found') ?>">404 Page not found</a>.


<h4>400 Bad request errors</h4>
<p>Audio: 400.1 Podcast shortcode too long.
<iframe
 class="ou player oembed podcast audio e-400-1"
 width="360" height="80" scrolling="no"
 src="<?php echo site_url('embed/pod/400/abcdef0123456789#!400-Shortcode-too-long') ?>"
 ></iframe>

<p>Audio: 400.2 Podcast shortcode unexpected characters.
<iframe
 class="ou player oembed podcast audio e-400-2"
 width="360" height="80" scrolling="no"
 src="<?php echo site_url('embed/pod/400/Unexpected#!shortcode') ?>"
 ></iframe>



<h4>Other error texts - for comparison</h4>

<p>YouTube: 404 Video not found/ doesn't exist (just shows the player).
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

