<?php
/**
*
* Form:			https://msds.open.ac.uk/tutorhome/contactus.aspx?t=Z
* Help Centre:	https://msds.open.ac.uk/students/help.aspx
* Contacts:		https://msds.open.ac.uk/students/help-contacts.aspx
*/
?>

<img class=oup-logo alt="" src="<?php echo site_url('assets/ouplayer/ou-media-player-logo.png') ?>" />

<p>The OU Media Player is an online audio and video player, developed at <a href="http://www.open.ac.uk/">The Open University</a>
 and used in student, public and staff facing services. Here are <a href=
"<?php echo OUP_BLOG_URL ?>" title="On Cloudworks">introductory blog posts</a>.


<h2 id=giving-feedback >Giving feedback</h2>

<p>If you are an Open University student please use your <a href="<?php echo OUP_HELP_URL ?>" title="Requires a University login" rel="nofollow">Student Help centre</a>
 to find answers, or the contact details for people who can help you.
 <label for="app-info">When you report a problem, please copy and paste the following information:</label>
<p><textarea readonly id="app-info" class="copy-fm" rows="3" cols="90">
OU Player version: <?php echo $app_revision->version ?>

Browser: <?php echo $this->input->server('HTTP_USER_AGENT') ?>
</textarea>


<p>Other information:
<ul>
  <li>Mediaelement.js Javascript version:  <span id="mejs-version">unknown</span>
  <li>Ender/ jeesh Javascript version:  <span id="jeesh-version">unknown</span>
  <li>jQuery Javascript version:  <span id="jquery-version">unknown</span>
</ul>

<p>NOTE: some demos on this site use the <a href="<?php echo site_url('scripts/jquery.oembed.js') ?>" rel="nofollow">jquery-oembed plugin</a>.
<p>You can also report bugs and give feedback to <a href="<?php echo OUP_CONTACT_URL ?>">IET-Webmaster+@+open.ac.uk</a>.


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
