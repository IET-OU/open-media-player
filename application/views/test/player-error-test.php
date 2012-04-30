<?php
  $input = $this->input;
  $body_classes = ' oup-jquery-test';
  $body_classes .= $input->get('edge') ? ' oup-edge' :'';
  $body_classes .= $input->get('size') ? ' oup-'.$input->get('size') :'';
?>
<!doctype html><html lang="en" class="<?php echo $body_classes ?>"><meta charset="utf-8"/><title>*OU player - Error tests</title>

<meta name="viewport" content="width=device-width, user-scalable=yes, initial-scale=0.8" />
<meta name="ROBOTS" content="noindex,nofollow" />

<link rel="stylesheet" href="<?php echo base_url() ?>assets/client/site-embed.css" />


<h1>OU player</h1> <h2>Error tests</h2>

<p>Iframe tests..

<p>Audio: 404 Podcast collection not found.
<iframe
 class="ou player oembed podcast audio"
 scrolling="no"
 src="<?php echo site_url('embed/pod/404/Collection-not-found') ?>"
 ></iframe>


<p>Video: 404 Podcast item not found.
<iframe
 class="ou player oembed podcast video"
 scrolling="no"
 src="<?php echo site_url('embed/pod/student-experiences/404-Item-not-found') ?>"
 ></iframe>


<p>Site: <a href="<?php echo site_url('404-Page-not-found') ?>">404 Page not found</a>.



<pre>


Todo:

** XML parsing errors..

* jquery-oembed embed errors..
* VLE error tests
* Caption error tests
* PDF transcript error tests..

See:
* http://podcast.open.ac.uk/404_ERROR
* http://www.open.ac.uk/404_ERROR

</html>