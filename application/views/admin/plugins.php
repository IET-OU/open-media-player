
<div id=themes >
<h2> Themes </h2>

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
