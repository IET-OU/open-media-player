<?php

$storage = NULL;
if (FALSE !== strpos($meta->host, 'ubuntuone.com')):
  $storage = <<<EOF
<a class="s" href="https://one.ubuntu.com/"><img src="http://media.one.ubuntu.com/media/6611/img/favicon.ico" title="Ubuntu one - safe, shareable storage" /></a>
EOF;

elseif (FALSE !== strpos($meta->host, 'dropbox.com')):
  $storage = <<<EOF
<a class="s" href="https://dropbox.com/"><img src="https://dt8kf6553cww8.cloudfront.net/static/images/favicon-vfl7PByQm.ico" title="Dropbox - storage" /></a>
EOF;

elseif (FALSE !== strpos($meta->host, '.open.ac.uk')):
  $storage = <<<EOF
<a class="s" href="$meta->host"><img src="https://www.open.ac.uk/favicon.ico" title="An Open University service" /></a>
EOF;

endif;



if ($meta->is_compendiumld):

  // Fallback: link to Browse Happy or http://www.whatbrowser.org/ - ?

  $html = <<<EOF
<div class='compendiumld cld embed-rsp $meta->ext' id='$meta->id'>
<object data='$meta->entity_url' type='image/svg+xml'
 width='$meta->width' height='$meta->height' style='display:block; margin:2px 0;'>
<div style='border:.2em solid #8275FD; background:#ffd; text-align:center;'
><p><strong>Sorry!</strong><br>Your browser can not display SVG so you will not see the interactive CompendiumLD map.
<p>To see the interactive map, please use a <a href="http://browsehappy.com/">modern browser</a>, e.g. Chrome, Firefox, Opera, Safari or Internet Explorer 9 and above.<br><strong>Thank you</strong>.</div>
</object>
$storage
 <a class='p' href='$meta->provider_url'><img title='$meta->provider_name - learning design software'
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
$storage
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
