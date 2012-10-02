<?php
/** Google Docs spreadsheet/form/presentation/document oEmbed view.
*/

  $label   = t('%s embed', $meta->provider_name);
  $noframes= t('Your browser does not support frames.');
  $_ = t('Access the form on %s', $meta->provider_name);
  $alttext = t('View the page on %s', $meta->provider_name);

  $html =<<<EOF
<iframe class='google google-docs $meta->_ccc embed-rsp' role='document' seamless allowfullscreen mozallowfullscreen webkitallowfullscreen title='$label' width='$meta->width' height='$meta->height'
src='$meta->embed_url' frameborder='0'>$noframes
<a href='$meta->embed_url'>$alttext</a>
</iframe>$tracker
EOF;

  $oembed = array(
      #'version'=> '1.0',
      'type'   => $meta->type,
      'provider_name'=> $meta->provider_name,
      'provider_url' => $meta->provider_url,
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

