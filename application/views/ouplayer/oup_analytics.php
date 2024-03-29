<?php
/**
 * Analytics / tracking view - Google and/or ComScore analytics.
 */

//VLE/ OpenLearn player??
#if ('Podcast_player'==get_class($meta)):
if (!$meta->is_player('vle')): ?>

<?php // ComScore/ StreamSense/ Nedstat.
if ($this->config->item('player_analytics_comscore')):

$ns_loc='no-loc';
if ('embed'==$mode) {
  $this->load->library('user_agent');
  // For a page in an <iframe> the referrer is the host page.
  if ($this->agent->is_referral()) {
    $ns_loc = $this->agent->referrer();
    $ns_loc=str_replace('http://', '', $ns_loc);
    $ns_loc=str_replace(array('/', '.', '?', '&', '='), '-', $ns_loc);
  }
}
//Counter: embed.video.[internal|external].<location>.<title>.page
$ns_counter ="ouplayer.$mode.$meta->media_type.$ns_loc.$meta->_album_id.$meta->_track_md5.".urlencode($meta->title).'.page'; #sub-title?
$ns_subdom  ='www'; //'player'/'embed'
$ns_sitename = $this->config->item('comscore_sitename');
if(!$ns_sitename)$ns_sitename='test-ou';

//<!--Begin CMC v.1.0.1-->
?>
<script src="http://ouan.open.ac.uk/sitestat.js"></script>
<script>//<![CDATA[
function sitestat(u){
 var d=document,l=d.location;ns_pixelUrl=u+"&ns__t="+(new Date().getTime());
 u=ns_pixelUrl+"&ns_c="+((d.characterSet)?d.characterSet:d.defaultCharset)+"&ns_ti="+escape(d.title)+"&ns_jspageurl="+escape(l&&l.href?l.href:d.URL)+"&ns_referrer="+escape(d.referrer);
 (d.images)?new Image().src=u:d.write('<'+'p><img src="'+u+'" height="1" width="1" alt=""/><'+'/p>');
};
sitestat("//ouan.open.ac.uk/ou/<?php echo $ns_sitename ?>/s?name=<?php echo $ns_counter ?>&ou_subdom=<?php echo $ns_subdom ?>");
//]]>
</script>
<noscript><p><img src="//ouan.open.ac.uk/ou/<?php echo $ns_sitename ?>/s?name=<?php echo $ns_counter ?>&ou_subdom=<?php echo $ns_subdom ?>" height="1" width="1" alt=""/></p></noscript>
<!--End CMC-->

<?php endif; ?>



<?php // Google analytics.
if (isset($google_analytics) && $google_analytics):
  $ga_title= substr(str_replace(array(' ', '\'', ':'), array('-', "\'", ''), $meta->title), 0, 40);

  if ($meta->is_player('podcast')) {
    $ga_path = "/$mode/pod/$meta->_album_id/$meta->_track_md5#!" . rtrim($ga_title, '-');
  } else {
    // OpenLearn.
    $ga_media_url = str_replace('://', '-//', $meta->media_url);
    $ga_path = "/$mode/openlearn/$ga_media_url#!" . rtrim($ga_title, '-');
  }

  // Bug #1464, Encode the "embedder" in the "path".
  if (isset($this->theme->origin) && $this->theme->origin) {
    $po = (object) parse_url($this->theme->origin);
    $ga_path .= "!$po->host!";
    $ga_path .= trim($po->path, '/ ') .'!';
  }
  ?>
<!-- Google Analytics -->
<script>
(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
})(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

ga('create', 'UA-XXXXX-Y', 'auto');
ga('send', 'pageview');
</script>
<!-- End Google Analytics -->

<?php /* LEGACY - To Delete! <script>
  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', '<?php echo $google_analytics ?>']);
  _gaq.push(['_trackPageview', '<?php echo $ga_path ?>']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = 'https://www.google-analytics.com/ga.js';
    <?php /* WAS: ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js'; *-/ ?>
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();
</script> */ ?>

<?php endif; ?>

<?php endif; ?>
