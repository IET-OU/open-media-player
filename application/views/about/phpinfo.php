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

<p><?php echo anchor('', 'Return home') ?>
 &bull; <a href="#app">Player application config</a> &bull; <a href="?name=value" title=
  "Add a GET parameter">[get]</a> &bull; <a href="#php">PHP info</a>  
</p>


<h2 id="version">Versions</h2>
<ul class="app version">

  <li>CodeIgniter version: <?= CI_VERSION ?></li>
</ul><p></p>


<h2 id="app">Site configuration</h2>
<ul class="app config">
<?php
    foreach ($app_config as $item => $value): ?>
    <li><?php echo $item ?> = <span class="val"><?php echo $value ?></span>
<?php endforeach; ?>
</ul><p></p>


<div id="php" class="app phpinfo" style="font-size:1.2em;">

<?php echo $phpinfo; ?>

</div>
