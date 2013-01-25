<?php
/**
* A generic oEmbed view, for IFRAME responses. (Loosely based on 'views/oembed/googledoc'.)
*/

  $iframe_label   = t('%s embed', $meta->provider_name);
  $attribution = t('%s on %s', array($meta->title, $meta->provider_name));
  $noframes= t('Your browser does not support frames.');


  $html = <<<EOF
<div class='$meta->class_name generic-iframe embed-rsp'>
<iframe role='document' allowfullscreen mozallowfullscreen webkitallowfullscreen title='$iframe_label'
 width='$meta->width' height='$meta->height' frameborder='0'
 src='$meta->embed_url'
></iframe>
<a href='$meta->original_url' style='background:url($meta->provider_icon) no-repeat left;padding-left:22px;display:block;'>$attribution</a>
</div>
EOF;

  $oembed = array(
      #'version'=> '1.0',
      'original_url' => $meta->original_url,
      'type'   => $meta->type,
      'provider_name'=> $meta->provider_name,
      'provider_url' => $meta->provider_url,
      'title'  => $meta->title,
      'html'   => $html,
      'width'  => $meta->width,
      'height' => $meta->height,
  );

  $view_data = array(
      'url'   => $url,
      'format'=> $format,
      'callback'=>$callback,
      'oembed' =>$oembed,
  );
  $this->load->view('oembed/render', $view_data);
