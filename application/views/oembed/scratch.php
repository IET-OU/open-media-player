<?php
/** oEmbed Scratch view.
--Get title, date, description.

/w/maltwiki/oembed?url=http://scratch.mit.edu/projects/technoguyx/355353&callback=C&format=xml
*/
  @header('X-Fixed-Size: oEmbed maxwidth/maxheight are ignored.');
  $width = 482;
  $height= 387;
  $p = (object) parse_url($url);
  //preg_match('#scratch.mit.edu\/projects\/(.*?)\/#', $url, $matches);
  $author_name = $matches[1];
  $author_url = "http://$p->host/users/$author_name";

  // HTML5: 4 <param>s -- 3 for all Java applets + 1 specific to Scratch.
  $html =<<<EOF
<div class="scratch"><object type="application/x-java-applet" width="$width" height="$height">
<param name="codebase" value="http://$p->host/static/misc/"/>
<param name="archive" value="ScratchApplet.jar"/>
<param name="code" value="ScratchApplet"/>
<param name="project" value="../../static/$p->path.sb"/>
<p>Sorry, your browser needs Java enabled to view Scratch projects.</p>
<img alt="" src="http://$p->host/static{$p->path}_sm.png" /></object>
<div><img alt="" src="http://$p->host/favicon.ico"/> Scratch project by <a rel=
"author" href="$author_url">$author_name</a>. <a rel="license" href=
"http://creativecommons.org/licenses/by-sa/2.0/"><img alt=
"Creative Commons License" style="border-width:0" src=
"http://i.creativecommons.org/l/by-sa/2.0/80x15.png"/></a></div></div>
EOF;

  $oembed = array(
        'version'=> '1.0',
        'type'   => 'rich',
        'title'  => $meta->title ? $meta->title : null,
        'author_name'=>$meta->author ? $meta->author : $author_name,
        'author_url' =>$author_url,
        'provider_name'=> 'Scratch',
        'provider_url' => "http://$p->host/",
        'width'  => $width,
        'height' => $height,
        'html'   => $html, #'embed_type'=> 'application/x-java-applet',
        'thumbnail_url'=> "http://$p->host/static{$p->path}_sm.png", #133 x 100.

        'license_url'  => 'http://creativecommons.org/licenses/by-sa/2.0/',
        'dc:date'   => date('c', $meta->timestamp),
        'dc:description'=> $meta->description,
        #'_cache_id' => $meta->cache_id,
        #'_cache_md5'=> $meta->url_md5,
        #?'_cache_date'=>date('c', $meta->cache_created),
  );

  $view_data = array(
      'url'   => $url,
      'format'=> $format,
      'callback'=>$callback,
      'oembed' =>$oembed,
  );
  
  $this->load->view('oembed/render', $view_data);
