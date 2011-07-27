<?php
/* YouTube oEmbed view - HTML5 / iframe embed.

 http://code.google.com/apis/youtube/iframe_api_reference.html
 http://www.youtube.com/watch_ajax?action_get_caption_track_all&v=NaBBk-kpmL4
 http://video.google.com/timedtext?lang=en&v=NaBBk-kpmL4
*/
  $video_id = $matches[1];
  $width = 640;
  $height= 390;

//?cc_load_policy=1&amp;enablejsapi=1&amp;origin=example.com / ?feature=player_embedded
  //$html =<<<EOF
  ob_start();

  ?>
<div class='youtube oembed'><iframe role='application' title='<?=t('YouTube video player') ?>' type='text/html' width='<?=$width ?>' height='<?=$height ?>'
src='http://www.youtube.com/embed/<?=$video_id ?>?origin=example.com' frameborder='0'><?=t('Your browser does not support frames.') ?>
<a href='http://youtu.be/<?=$video_id ?>'><?=t('Watch video on YouTube') ?></a></iframe><div style="font-size:small"><img alt='' src='http://www.youtube.com/favicon.ico'/>
<?php /*<img src='/ouplayer/assets/services/html5-favicon.ico'/>*/ ?> <a href='http://youtube.com/html5' title="<?=t("Join YouTube's HTML5 trial") ?>"><?=t('Opt-in to HTML5') ?></a>
<?=$tracker ?></div></div>
<?php

  $html = ob_get_clean();
//EOF;

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

