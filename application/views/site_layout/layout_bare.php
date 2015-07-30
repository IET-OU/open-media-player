<?php
  $robots = $this->config->item('robots');
  $google_analytics = $this->config->item('google_analytics');

  $input = $this->input;
  $body_classes = ' oup-jquery-test';
  $body_classes .= $input->get('edge') ? ' oup-edge' :'';
  $body_classes .= $input->get('size') ? ' oup-'.$input->get('size') :'';

  #header('X-UA-Compatible: IE=edge');

?>
<!doctype html><html lang="en" class="<?php echo $body_classes ?>"><meta http-equiv="X-UA-Compatible" content="IE=edge" />
<meta charset="utf-8" /><title><?php echo $page_title ?> – <?php echo site_name() ?></title>

<meta name="viewport" content="width=device-width, user-scalable=yes, initial-scale=0.8" />
<meta name="ROBOTS" content="noindex,nofollow" />

<link rel="stylesheet" href="<?php echo base_url() ?>assets/client/site-embed.css" />
<script src="<?php echo OUP_JS_CDN_JQUERY_MIN ?>"></script>

<?php if($google_analytics): ?>
<script>
  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', '<?php echo $google_analytics ?>']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();
</script>
<?php endif; ?>


<?php
$message = $this->config->item('site_message');
if ($message): ?>
<div id=warn class=oup-test-warning role="status">
    <?php echo $message ?>
</div>
<?php endif; ?>


<h1 class=hide><?php echo site_name() ?></h1>

<ul role="navigation">
    <li><a href="<?php echo base_url() ?>">Home</a>
    <li><a href="<?php echo base_url() ?>about">About</a>
    <li><a href="<?php echo base_url() ?>demo/ouldi">OU/OULDI embeds</a>
</ul>

<?php echo $content_for_layout ?>

<p id="footer">&copy; 2011-<span class="copy">2014</span> The Open University.</p>


<?php //if ($is_demo_page && $use_oembed): ?>

<script src="<?php echo site_url('scripts/jquery.oembed.js') ?>"></script>
<script>
  $(document).ready(function() {

    $.fn.oembed && $("a.embed").oembed(null, {
      'oupodcast':{'<?php echo OUP_PARAM_THEME ?>':'<?php echo isset($req->theme) ? $req->theme :'' ?>'}
    });<?php /*null, { embedMethod: "replace" });*/ ?>

<?php /*$("[rel=embed]").oembed(); //Legacy.*/ ?>


    $(".copy").text((new Date).getYear() + 1900);
  });
</script>

<script>$.oup_site_debug = <?php echo json_encode(isset($req) ? $req->debug : NULL) ?>;</script>
<script src="<?php echo site_url('assets/site/site-behaviour.js') ?>"></script>

</html>
