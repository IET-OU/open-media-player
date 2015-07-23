
<?php if ($is_stream): ?>
	<h2> YouTube stream example </h2>
<?php else: ?>
	<h2> YouTube example </h2>
<?php endif; ?>

<iframe
	src="<?php echo $youtube_url ?>"
	aria-label="YouTube player"
	class="x youtube player embed-rsp" width="560" height="315" frameborder="0" allowfullscreen
></iframe>
