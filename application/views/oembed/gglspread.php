<?php
/** Google Docs spreadsheet/form/presentation/document oEmbed view.
*/

  $label   = t('Google Docs embed');
  $noframes= t('Your browser does not support frames.');
  $_ = t('Access the form on Google');
  $alttext = t('Access the document on Google');

  $html =<<<EOF
<iframe class='ggl-docs $meta->_ccc oembed' role='document' title='$label' width='$meta->width' height='$meta->height'
src='$meta->embed_url' frameborder='0'>$noframes
<a href='$meta->embed_url'>$alttext</a>
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

