<?php $_debug = filter_input(INPUT_GET, 'debug') ?>
<div class="error-php" data-msg=<?php echo json_encode("PHP $severity: $message")?> style=
 "border:1px solid #990000;padding-left:20px;margin:0 0 5px 0;<?php echo $_debug ? '':'display:none'?>">

<h4>A PHP Error was encountered</h4>

<div>Severity: <?php echo $severity; ?></div>
<div>Message:  <?php echo $message; ?></div>
<div>Filename: <?php echo $filepath; ?></div>
<div>Line Number: <?php echo $line; ?></div>

<script>window.console && console.error(<?php echo json_encode("ERROR - PHP $severity: '$message' .. (ouplayer)")?>)</script>
</div>
