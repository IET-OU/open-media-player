<?php
/** oEmbed OU podcast view - iframe-based.
*
* @copyright Copyright 2011 The Open University.
*
* NDF, 17 March 2011.
*/
  $width = 608;
  $height= 362;
  $pod_base = Oupodcast_serv::POD_BASE;
  $base = base_url();
  $label= t('OU player');
  $noframes = t('Your browser does not support frames.');

  $theme = 'theme-'. (isset($this->theme->name) ? $this->theme->name : 'legacy');

  $allowfullscreen = 'video'==$meta->media_type ?
      'allowfullscreen webkitallowfullscreen mozallowfullscreen' : '';


  //scrolling='no' - ?
  $html =<<<EOF
<iframe class='ou player podcast oembed $meta->media_type $theme' id='pod-$meta->_album_id-$meta->_track_md5' aria-label='$label'
 about='$meta->_short_url' xmlns:dct='http://purl.org/dc/terms/' property='dct:title' content='$meta->title'
 width='$meta->width' height='$meta->height' frameborder='0' scrolling='no' style='overflow:hidden;' $allowfullscreen
 src='$meta->iframe_url'>$noframes</iframe>
EOF;
  //src='{$base}embed/pod/$meta->_album_id/$meta->_track_md5?width=$meta->width&amp;height=$meta->height'
  //style='border:none; overflow:hidden;'


// Legacy OU podcast player, using the existing jwPlayer!
//(file=http://podcast.open.ac.uk/feeds/l314-spanish/rss2.xml&javascriptid=flashplayer&enablejs=true)
  $html_ORIG =<<<EOF
<div class="ou podcast oembed">
<object tabindex="0" id="pod-$meta->_track_md5" aria-label="$label" type="application/x-shockwave-flash" height="$height" width="$width"
data="$pod_base/flash_media_player/mediaplayer.swf" >
<param name="movie" value="$pod_base/flash_media_player/mediaplayer.swf" />
<param name="allowscriptaccess" value="always" />
<param name="allowfullscreen" value="true" />
<param name="flashvars" value=
"displaywidth=$width&amp;width=$width&amp;height=$height&amp;linkfromdisplay=false&amp;__showdownload=false&amp;overstretch=false&amp;image=$meta->poster_url&amp;file=$meta->media_url&amp;backcolor=0x000000&amp;frontcolor=0xFFFFFF&amp;lightcolor=0xdbedff&amp;screencolor=0x000000&amp;autostart=false" />
<p>Your browser needs Flash enabled to view this $meta->media_type.</p>
<img alt="" src="$meta->poster_url"/>
</object><div><small><img alt="" src="$base/assets/services/oupodcast.png" style="padding:2px;" />
<a href="$meta->url">$meta->title</a> on <a href="$pod_base">OU Podcast</a>.</small></div>
</div>
EOF;

  $oembed = array(
        'version'=> '1.0',
        // 'audio' is a non-standard type!!
        'type'   => 'video'==$meta->media_type ? 'video' : 'rich',
        'provider_name'=> t('Podcasts - The Open University'), #Was: 'OU Podcast'
        'provider_url' => $pod_base,
        'title'  => $meta->title,
        //'author_name'=>$meta->author, 'author_url' =>null,
        'width'  => $width,
        'height' => $height,
        'html'   => $html, #'embed_type'=> 'application/x-shockwave-flash',
        'thumbnail_url'=> $meta->poster_url, #thumbnail or poster.
        '__duration'=>$meta->duration,
        '__podcast_id'=>$meta->_podcast_id,
        '__album_id'  =>$meta->_album_id, #(DB: custom_id)
        '__track_md5' =>$meta->_track_md5,
		'__access' => $meta->_access,
        //'dc:extent'=>"$meta->_duration s",
        #'__meta' => $meta,
        'dc:copyright'=>$meta->_copyright,
        'dc:date'=> $meta->timestamp, //date('c', $meta->timestamp),
        //'license_url'  => null,
  );

  $view_data = array(
      'url'   => $url,
      'format'=> $format,
      'callback'=>$callback,
      'oembed' =>$oembed,
  );
  
  $this->load->view('oembed/render', $view_data);
