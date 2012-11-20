
<p>A work-in-progress - please view Javascript console.
<script>
  console.log(<?php echo json_encode($services) ?>);
</script>

<?php if ($this->input->get('embedly')): ?>
<script src="http://api.embed.ly/1/services?callback=console.log"></script>
<?php endif; ?>
