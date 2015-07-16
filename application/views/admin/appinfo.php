<?php
/** An application configuration display page, for administrators
*
*/
?>

<p><a href="<?php echo site_url('admin/info') ?>">Player application config</a>
  &bull; <a href="<?php echo site_url('admin/plugins') ?>">Plugins</a>
  &bull; <a href="<?php echo site_url('admin/phpinfo') ?>">PHP info</a>
</p>


<!--
<h2 id="version">Versions</h2>
<ul class="app version">

  <li>CodeIgniter version: <?php echo CI_VERSION ?></li>
</ul>
-->

<h2 id="app">Site configuration</h2>
<ul class="app config">
<?php
    foreach ($app_config as $item => $val):
      if (is_scalar($val)) {
        // Security - escape HTML in `version.json::message` etc.
        $val = preg_replace('@<(\/?h\d)>@i', '[[$1]]', $val);
        $val = htmlentities($val);
        $val = preg_replace('@\[\[(\/?h\d)\]\]@i', '<$1>', $val);
      } else {
        $val = '<pre>'. preg_replace('/Array\s+\(/ms', '@(', print_r($val, $ret=TRUE)) .'</pre>';
      } ?>
    <li><?php echo $item ?> = <span class="val"><?php echo $val ?></span>
<?php endforeach; ?>
</ul><p></p>
