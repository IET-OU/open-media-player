<?php
/**
 * Remotely debug a mobile web app.
 *
 * jsconsole.com is a simple JavaScript command line tool.
 * @link http://jsconsole.com/remote-debugging.html
 * @link https://github.com/remy/jsconsole
 * @link http://stackoverflow.com/questions/1219860/javascript-jquery-html-encoding
 *
 *
 * NOT IN PRODUCTION -- Do NOT set $config['jsconsole'] in production -- debugging only.
 */


// CodeIgniter 'get config'.
$jsconsole_id = $this->config->item('jsconsole_id');


?>
<?php if ($jsconsole_id && $params->debug): ?>
<script src="http://jsconsole.com/remote.js?<?php echo $jsconsole_id ?>"></script>
<script>
(function () {

  if (typeof console === 'undefined') return;

  function htmlEscape(str) {
    return String(str)
            .replace(/&/g, '&amp;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#39;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;');
  }
  function nl2br(str) {
    return String(str).replace(/\n/g, '<br>');
  }
  console.log(
    nl2br(
      htmlEscape(document.querySelector('html').innerHTML)
    )
  );

})();
</script>
<?php endif; ?>
