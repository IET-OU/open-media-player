<?php
/**
*
* Form:			https://msds.open.ac.uk/tutorhome/contactus.aspx?t=Z
* Help Centre:	https://msds.open.ac.uk/students/help.aspx
* Contacts:		https://msds.open.ac.uk/students/help-contacts.aspx
*/
?>

<p>The OU Media Player is an online audio and video player, developed at <a href="http://www.open.ac.uk/">The Open University</a>
 and used in student, public and staff facing services. Here are <a href=
"http://freear.org.uk/content/ou-media-player-project">introductory blog</a>  <a href="http://freear.org.uk/content/ou-embed-proposal">posts</a>.


<h2>Giving feedback</h2>

<p><label for="app-info">If you need to report an issue, or give feedback to the <a href="http://www.open.ac.uk/students/help/" rel="nofollow">Student Computing Helpdesk</a>,
 please copy and paste the following information:</label>
<p><textarea readonly id="app-info" rows="3" cols="40" style="width:96%;">
OU Player version: <?php echo $app_revision->version ?>

Browser: <?php echo $_SERVER['HTTP_USER_AGENT'] ?>
</textarea>


<p>Other information:
<ul>
  <li>Mediaelement.js Javascript version:  <span id="mejs-version">unknown</span>
  <li>Ender/ jeesh Javascript version:  <span id="jeesh-version">unknown</span>
  <li>jQuery Javascript version:  <span id="jquery-version">unknown</span>
</ul>

<p>NOTE: the demos on this site use the <a href="<?php echo site_url('scripts/jquery.oembed.js') ?>" rel="nofollow">jquery-oembed plugin</a>.
<p>NOTE: the OU Media Player is now fairly accessible. Feedback to <a href="mailto:N.D.Freear+@+open.ac.uk?subject=OU+player">N.D.Freear+@+open.ac.uk</a>


<script>
var jq = jQuery.noConflict();
</script>
<script src="<?php echo OUP_JS_CDN_ENDER_MIN ?>"></script>

<script src="<?php echo base_url() ?>/engines/mediaelement/build/mediaelement-and-player.min.js"></script>
<script>
jQuery(document).ready(function() {

	$('#mejs-version').html( mejs.version );
	//$('#jeesh-version').html( ender );
	$('#jquery-version').html( jQuery.fn.jquery );
	//$('#ua').html( navigator.userAgent );

	//console.log( $._VERSION );
});
</script>
