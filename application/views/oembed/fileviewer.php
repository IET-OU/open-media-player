<?php

if ($meta->is_compendiumld):

  // Fallback: link to Browse Happy or http://www.whatbrowser.org/ - ?

  $html = <<<EOF
<div class='compendiumld cld embed-rsp $meta->ext' id='$meta->id'>
<object data='$meta->entity_url' type='image/svg+xml'
 width='$meta->width' height='$meta->height' style='display:block'>
<div style='border:.2em solid #8275FD; background:#ffd; text-align:center;'
><p><strong>Sorry!</strong><br>Your browser can not display SVG so you will not see the interactive CompendiumLD map.
<p>To see the interactive map, please use a <a href="http://browsehappy.com/">modern browser</a>, e.g. Chrome, Firefox, Opera, Safari or Internet Explorer 9 and above.<br><strong>Thank you</strong>.</div>
</object>
<a class='p' href='$meta->provider_url'><img title='$meta->provider_name' 
 src='http://compendiumld.open.ac.uk/favicon.ico' width='18' height='18' /></a>
 <a class='f' href='$meta->entity_url'>$meta->title</a>
</div>
EOF;

else: // Google Docs viewer

  $html = <<<EOF
<div class='fileviewer gdv embed-rsp $meta->ext' id='$meta->id'>
<iframe
 width='$meta->width' height='$meta->height' frameborder='0'
 src="$meta->embed_url"
></iframe>
<a class='p' href='$meta->provider_url'><img title='$meta->provider_name' 
 src='http://docs.google.com/favicon.ico' /></a>
 <a class='f' href='$meta->entity_url'>$meta->title</a>
</div>
EOF;

endif;


  $oembed = array(
        'version'=> '1.0',
        'type'   => $meta->type,
        'provider_name'=> $meta->provider_name,
        'provider_url' => $meta->provider_url,
        'title'  => $meta->title,
        #'author_name'=>$meta->author,
        'html'   => $html,
        'mime_type' => $meta->mime_type,
  );

  $view_data = array(
      'url'   => $url,
      'format'=> $format,
      'callback'=>$callback,
      'oembed' =>$oembed,
  );
  $this->load->view('oembed/render', $view_data);
