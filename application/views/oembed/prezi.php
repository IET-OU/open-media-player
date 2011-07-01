<?php
/** oEmbed Prezi view.
--Get image, author, date, tags.

/w/maltwiki/oembed?url=http://prezi.com/zoidjousoeat/technology-for-the-classroom/&callback=C&format=json
*/
  $width = 550;
  $height= 400;

  /*$tracker_url = site_url().'track/i/UA-12345-1/prezi.com/prezi'.
      parse_url($url, PHP_URL_PATH).'?title='.$meta->title;
  $tracker_img =<<<EOF
<img alt="" class="wb" src="$tracker_url" />
EOF;*/

  //classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000"
  $html =<<<EOF
<div class='prezi oembed'><object type='application/x-shockwave-flash' width='$width' height='$height' data='http://prezi.com/bin/preziloader.swf'>
<param name="movie" value="http://prezi.com/bin/preziloader.swf"/>
<param name="allowfullscreen" value="true"/>
<param name="allowscriptaccess" value="always"/>
<param name="bgcolor" value="#ffffff"/>
<param name="flashvars" value=
"prezi_id=$meta->provider_mid&amp;lock_to_path=0&amp;color=ffffff&amp;autoplay=no"/>
<p>Your browser needs Flash enabled to view this presentation.</p>
<img alt="" src="$meta->thumbnail_url"/></object><div><img alt="" src="http://prezi.com/favicon.ico" />
<a href="$url">$meta->title</a> by $meta->author on <a href="http://prezi.com/">Prezi</a>.</small></div>$tracker</div>
EOF;

  $oembed = array(
        'version'=> '1.0',
        'type'   => 'rich',
        'provider_name'=> 'Prezi',
        'provider_url' => "http://prezi.com/",
        'title'  => $meta->title,
        'author_name'=>$meta->author, //'author_url' =>null,
        'width'  => $width,
        'height' => $height,
        'html'   => $html, #'embed_type'=> 'application/x-shockwave-flash',
        'thumbnail_url'=> $meta->thumbnail_url,
        'dc:date'=> $meta->timestamp ? date('c', $meta->timestamp) : null,
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

