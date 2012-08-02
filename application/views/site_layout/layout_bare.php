<?php
  $input = $this->input;
  $body_classes = ' oup-jquery-test';
  $body_classes .= $input->get('edge') ? ' oup-edge' :'';
  $body_classes .= $input->get('size') ? ' oup-'.$input->get('size') :'';

  #header('X-UA-Compatible: IE=edge,chrome=1');

?>
<!doctype html><html lang="en" class="<?php echo $body_classes ?>"><meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
<meta charset="utf-8" /><title>*OU player/ OU embed - Beta Demonstrations</title>

<meta name="viewport" content="width=device-width, user-scalable=yes, initial-scale=0.8" />
<meta name="ROBOTS" content="noindex,nofollow" />

<link rel="stylesheet" href="<?php echo base_url() ?>assets/client/site-embed.css" />



<h1 class=hide>OU Media Player</h1>
<p class="home-link"><a href="<?php echo base_url() ?>">&larr; Player home</a></p>

<?php echo $content_for_layout ?>

</pre>

<p class="home-link"><a href="<?php echo base_url() ?>">&larr; Player home</a></p>
<p id="footer">&copy;2012 The Open University.</p>

<script src="<?php echo OUP_JS_CDN_JQUERY_MIN ?>"></script>
<script src="<?php echo site_url('scripts/jquery.oembed.js') ?>"></script>
<script>
  $(document).ready(function() {
    $("a.embed").oembed(null, {'oupodcast':{'<?php echo OUP_PARAM_THEME ?>':'<?php echo isset($req->theme) ? $req->theme :'' ?>'}});<?php /*null, { embedMethod: "replace" });*/ ?>

<?php /*$("[rel=embed]").oembed(); //Legacy.*/ ?>
  });
</script>

</html> 