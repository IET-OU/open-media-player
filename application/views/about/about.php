
<?php



var_dump($app_revision);

?>

<ul>
  <li>Mediaelement.js library version:  <span id="mejs-version">unknown</span>
  <li>Ender/ jeesh Javascript version:  <span id="jeesh-version">unknown</span>
  <li>jQuery Javascript version:  <span id="jquery-version">unknown</span>
  <li>Browser:  <span id="ua">unknown</span>
</ul>


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
	$('#ua').html( navigator.userAgent );

	console.log( $._VERSION );
});
</script>
