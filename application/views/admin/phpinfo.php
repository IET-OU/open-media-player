<?php
/** An application config / phpinfo page, for administrators
*
* Note, we need ob_start to make the phpinfo output appear at the correct place on the page.
* While we're at it, we'll remove some of the 'page-level' tags from the output.
*/
ob_start();

phpinfo();

$page = ob_get_clean();
$page = str_ireplace(array('<html>','<head>','<body>', '</html>','</head>','</body>'), '', $page);
$phpinfo = preg_replace('#<!DOCTYPE.*?>#', '', $page);
?>

<p role="navigation" aria-label="Admin">
  <a href="<?php echo site_url('admin/info') ?>">Player application config</a>
  &bull; <a href="<?php echo site_url('admin/plugins') ?>">Plugins</a>
  &bull; <a href="<?php echo site_url('admin/phpinfo') ?>">PHP info</a>
  &bull; <a href="?name=value" title="Add a GET parameter">[get]</a>
</p>



<div id="php" class="app phpinfo" style="font-size:1.2em;">

<?php echo $phpinfo; ?>

</div>
