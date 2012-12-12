<?php
/* YouTube oEmbed view - HTML5 / iframe embed.

 http://code.google.com/apis/youtube/iframe_api_reference.html
 http://www.youtube.com/watch_ajax?action_get_caption_track_all&v=NaBBk-kpmL4
 http://video.google.com/timedtext?lang=en&v=NaBBk-kpmL4
*/
  $video_id = $meta->provider_mid;
  $width = 640;
  $height= 390;

//?cc_load_policy=1&amp;enablejsapi=1&amp;origin=example.com / ?feature=player_embedded
  ob_start();

  ?>
<div class='youtube embed-rsp'><iframe role='application' title='<?php echo t('YouTube video player') ?>' width='<?php echo $width ?>' height='<?php echo $height ?>'
 allowfullscreen webkitallowfullscreen mozallowfullscreen frameborder='0'
 src='http://www.youtube.com/embed/<?php echo $video_id ?>?fs=1&amp;cc_load_policy=1&amp;origin=<?php echo $this->input->server('HTTP_HOST'); ?>'><?php echo t('Your browser does not support frames.') ?>
</iframe><div style="font-size:small"><img alt='' src='http://www.youtube.com/favicon.ico' style='padding-top:3px'/>
<?php /*<img src='/ouplayer/assets/services/html5-favicon.ico'/>*/ ?> <a href='http://youtube.com/html5' title="<?php echo t("Join YouTube's HTML5 trial") ?>"><?php echo t('Opt-in to HTML5') ?></a>
 <a href='http://youtu.be/<?php echo $video_id ?>?hd=1' title='<?php echo t('High definition') ?>' style='padding-left:20px; margin-left:8px; background:url(<?php echo base_url() ?>assets/services/hd.png) no-repeat left;'><?php echo t('Watch on YouTube') ?></a><?php echo $tracker ?></div></div>
<?php

  $html = ob_get_clean();


  $oembed = array(
        'version'=> '1.0',
        'type'   => 'video',
        'provider_name'=> 'YouTube',
        'provider_url' => "http://www.youtube.com/",
        /*'title'  => $meta->title,
        'author_name'=>$meta->author,
        'author_url' =>$meta->author_url,
        */
        'html'   => $html,
        'width'  => "$width", //Cast to string?
        'height' => $height,
        /*'thumbnail_url'=> $meta->thumbnail_url,
        'thumbnail_width' =>$meta->thumbnail_width,
        'thumbnail_height'=>$meta->thumbnail_height,
*/
  );

  $view_data = array(
      'url'   => $url,
      'format'=> $format,
      'callback'=>$callback,
      'oembed'=> $oembed,
  );
  $this->load->view('oembed/render', $view_data);

