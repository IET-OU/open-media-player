<?php
/** Analytics / tracking view.
*/ ?>

<?php if (isset($google_analytics) && $google_analytics): //'Podcast_player'==get_class($meta)):
  $path = "/$mode/pod/$meta->_album_id/$meta->_track_md5/".str_replace(' ','-', $meta->title);
  ?>
<script>
  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', '<?=$google_analytics ?>']);
  _gaq.push(['_trackPageview', '<?=$path ?>']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();
</script>
<?php endif; ?>
