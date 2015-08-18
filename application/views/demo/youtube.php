
<h2> <?php echo $page_title ?> </h2>

<iframe
	src="<?php echo $youtube_url ?>"
	aria-label="YouTube player"
	class="x youtube player embed-rsp" width="560" height="315" frameborder="0" allowfullscreen
></iframe>


<?php if ($youtube_list): ?>
<div id="examples">
<p>More YouTube examples:
<ul>
<?php foreach ($youtube_list as $vid => $vtitle): ?>
	<li><a href="<?php echo site_url('demo/youtube/' . $vid) ?>"><?php echo $vtitle ?></a>
<?php endforeach; ?>
</ul>
</div>
<?php endif; ?>
