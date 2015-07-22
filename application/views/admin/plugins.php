
<p role="navigation" aria-label="Admin">
  <a href="<?php echo site_url('admin/info') ?>">Player application config</a>
  &bull; <a href="<?php echo site_url('admin/plugins') ?>">Plugins</a>
  &bull; <a href="<?php echo site_url('admin/phpinfo') ?>">PHP info</a>
</p>


<div id=themes >
<h2> Player Themes </h2>

<table>
<?php foreach ($themes as $name => $class): ?>
    <tr><td class=k ><?php echo $name ?></td> <td class=v ><?php echo $class ?></td></tr>
<?php endforeach; ?>
</table>
</div>


<div id=providers >
<h2> oEmbed Providers </h2>

<table>
<?php foreach ($providers as $name => $class): ?>
    <tr><td class=k ><?php echo $name ?></td> <td class=v ><?php echo $class ?></td></tr>
<?php endforeach; ?>
</table>
</div>
