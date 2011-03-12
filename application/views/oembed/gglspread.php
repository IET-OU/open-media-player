<?php
/** Google Docs spreadsheet/form oEmbed view.
*/
#var_dump($this->CI->oembed_request);

  $html =<<<EOF
<iframe class='gglspread oembed' role='document' title='Embedded form' type='text/html' width='$meta->width' height='$meta->height'
src='$meta->embed_url' frameborder='0'>
<a href='$meta->embed_url'>On Google</a>
</iframe>$tracker
EOF;

  $oembed = array(
      'version'=> '1.0',
      'type'   => 'rich',
      'provider_name'=> 'Google Docs',
      'provider_url' => "http://docs.google.com/",
      #'title'  => $meta->title,
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

