<?php
/** OU podcast service provider.
 *
 * @copyright Copyright 2011 The Open University.
 */
//NDF, 3/3/2011.
require_once 'base_service.php';

class Oupodcast_serv extends Base_service {

  protected $CI;

  public function __construct() {
      $this->CI =& get_instance();
      $this->CI->load->model('podcast_items_model');
  }

  public function call($url, $matches) {
      $pod_base = 'http://podcast.open.ac.uk';
      
      $basename = str_replace(array('podcast-','pod-'), '', $matches[1]);
      $separator= $matches[2];
      $fragment = $matches[3];
      $is_file  = FALSE!==strpos($fragment, '.');
  #var_dump($basename,$separator,$fragment, $is_file);

      // Query the podcast DB.
      $result = $this->CI->podcast_items_model->get_item($basename, $fragment, $transcript=TRUE);
      #$result = $result_A[0];

      // TODO: Access control - SAMS cookie.
      $access = array(
          # Album/podcast level.
          'private' => $result->private, #N.
          'intranet_only' => $result->intranet_only, #N.
          # Track/item level.
          'published' => $result->published_flag, #Y.
          'deleted'   => $result->deleted, #0.
      );

      $custom_id = $result->custom_id;
      $shortcode = $result->shortcode;
      $meta = array(
        '_access' => $access,

        'url' => "$pod_base/$result->preferred_url/podcast-$custom_id#!$shortcode",
        '_short_url' => "$pod_base/pod/$custom_id#!$shortcode", #Track permalink.
        'provider_name'=> 'oupodcast',
        'provider_mid' => "$custom_id/$shortcode",

        'type'  => strtolower($result->source_media),
        'title' => $result->pod_title,
        '_sub_title' => $result->title,
        '_summary'   => $result->pod_summary,
        '_keywords'  => $result->keywords,
        'thumbnail_url'=>"$pod_base/feeds/$custom_id/".str_replace('.', '_thm.', $result->image), #75x75px.
        '_poster_url' => "$pod_base/feeds/$custom_id/$result->image",   #Poster, 304x304px.
        '_media_url' => "$pod_base/feeds/$custom_id/$result->filename", #608x362px.
        '_duration'  => $result->duration, #Seconds.
        '_feed_url'  => "$pod_base/feeds/$custom_id/rss2.xml",
        '_transcript_url' => "$pod_base/feeds/$custom_id/transcript/".str_replace(array('.mp3', '.m4'), '.pdf', $result->filename), #TODO!
        '_target_url'=> isset($result->link) ? $result->link : $result->target_url, #OR target_url (target_url_text/ link_text).
        '_itunes_url'=> $result->itunes_u_url, 
        '_album_id'  => $custom_id,
        '_track_id'  => $shortcode,
        '_copyright' => $result->copyright,
        #'_language'  => $result->language, ??
        '_published' => $result->publication_date,
      );

  var_dump($meta); #, $result);
      
      return (object) $meta;
  }
}
