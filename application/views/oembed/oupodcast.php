<?php
/** oEmbed OU podcast view.

TODO. ou podcast.
*/
  $width = 550;
  $height= 400;

  $html =<<<EOF
<div class="ou podcast oembed"><object type="application/x-shockwave-flash" width="$width" height="$height" data="http://prezi.com/bin/preziloader.swf">
<param name="movie" value="--"/>
<param name="allowfullscreen" value="true"/>
<param name="allowscriptaccess" value="always"/>
<param name="bgcolor" value="#ffffff"/>
<param name="flashvars" value="---" />
<p>Your browser needs Flash enabled to view this presentation.</p>
<img alt="" src="$meta->thumbnail_url"/></object><div><img alt="" src="http://www.open.ac.uk/favicon.ico" />
<a href="$meta->url">$meta->title</a>  on <a href="http://podcast.open.ac.uk/">OU Podcast</a>.</div>
</div>
EOF;

  $oembed = array(
        'version'=> '1.0',
        'type'   => $meta->type,
        'provider_name'=> 'OU Podcast',
        'provider_url' => 'http://podcast.open.ac.uk/',
        'title'  => $meta->title,
        //'author_name'=>$meta->author, //'author_url' =>null,
        'width'  => $width,
        'height' => $height,
        'html'   => $html, #'embed_type'=> 'application/x-shockwave-flash',
        'thumbnail_url'=> $meta->thumbnail_url,
        #'__meta' => $meta,
        //'license_url'  => null,
  );

#$meta->cache_created.
#$tsstring = gmdate('D, d M Y H:i:s ', $meta->timestamp) . 'GMT';
#header("Last-Modified: $tsstring");

  $view_data = array(
      'url'   => $url,
      'format'=> $format,
      'callback'=>$callback,
      'oembed' =>$oembed,
  );
  
  $this->load->view('oembed/render', $view_data);
