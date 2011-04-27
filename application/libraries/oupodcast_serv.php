<?php
/** OU podcast service provider.
 *
 * @copyright Copyright 2011 The Open University.
 */
//NDF, 3/3/2011.
require_once 'base_service.php';
require_once 'ouplayer_lib.php';


class Oupodcast_serv extends Base_service {

  protected $CI;

  public function __construct() {
      $this->CI =& get_instance();
      $this->CI->load->model('podcast_items_model');
  }

  /** Used by oEmbed controller.
  */
  public function call($url, $matches) {
      $basename = str_replace(array('podcast-','pod-'), '', $matches[1]);
      $separator= $matches[2];
      $fragment = $matches[3];
      $is_file  = FALSE!==strpos($fragment, '.');

	  return $this->_inner_call($basename, $fragment);
  }

  /** Used directly by embed controller.
  */
  public function _inner_call($basename, $fragment, $transcript=FALSE) {
      $pod_base = 'http://podcast.open.ac.uk';


	  // Query the podcast DB.
      $result = $this->CI->podcast_items_model->get_item($basename, $fragment, $transcript=FALSE);
      #$result = $result_A[0];
      if (!$result) {
          die("404, Error, podcast item not found.");
      }

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

	  // TODO: derive from maxwidth/maxheight!
	  $width = Podcast_player::DEF_WIDTH;
	  $height= Podcast_player::DEF_HEIGHT;

	  $player = new Podcast_player;

	  $player->title = $result->pod_title.': '.$result->title;
	  $player->media_html5 = TRUE;
	  $player->media_type = strtolower($result->source_media);
	  $player->media_url = "$pod_base/feeds/$custom_id/$result->filename"; #608x362px.
	  if ($result->image) {
		$player->poster_url= "$pod_base/feeds/$custom_id/$result->image";    #304x304px.
	  } else {
	    // Unpublished?
	    $player->poster_url= "$pod_base/feeds/$custom_id/$result->image_filename.jpg";
	  }
	  $player->thumbnail_url = "$pod_base/feeds/$custom_id/".str_replace('.', '_thm.', $result->image); #75x75px.
	  $player->duration = $result->duration; #Seconds.
	  $player->width = $width;
	  $player->height= $height;
	  $player->transcript_url = "$pod_base/feeds/$custom_id/transcript/".str_replace(array('.mp3', '.m4v'), '.pdf', $result->filename); #TODO!
	  // Our <iframe> embed!!
	  $player->iframe_url = site_url()."embed/pod/$custom_id/$shortcode?width=$width&amp;height=$height";

	  $player->_related_url = isset($result->link) ? $result->link : $result->target_url;
            #OR target_url (target_url_text/ link_text). #'_related_text'=>
	  $player->_podcast_id = $result->podcast_id;
	  $player->_album_id = $custom_id;
	  $player->_track_id = $shortcode;
	  $player->_access   = $access;
	  $player->url = "$pod_base/$result->preferred_url/podcast-$custom_id#!$shortcode";
	  $player->_short_url = "$pod_base/pod/$custom_id#!$shortcode"; #Track permalink.
	  $player->provider_mid = "$custom_id/$shortcode";
	  $player->_copyright = $result->copyright;
	  #$player->language  = $result->language; #Always 'en'??
	  $player->timestamp  = $result->publication_date;

	  $player__extend = array( #$player->_extend
	    '_album_title'=>$result->pod_title,
        '_track_title' => $result->title,
        '_summary'   => $result->pod_summary,
        '_keywords'  => $result->keywords,
		'_aspect_ratio'=> $result->aspect_ratio,
        '_feed_url'  => "$pod_base/feeds/$custom_id/rss2.xml", #Album.
		'_itunes_url'=> $result->itunes_u_url, #Album.
	  );

      return $player;
  }

  /** Either get PDF transcript (from remote site) and convert to HTML snippet, or return existing snippet.
  * Note, an intermediate XML file is saved.
  */
  public function get_transcript($player) {

    $res = $pdf = $html = false;

	// Maybe a sub-directory?
	  $trans_pdf = $this->CI->config->item('data_dir').'oupodcast/'.basename($player->transcript_url);
	  $trans_file_xml = str_replace('.pdf', '.xml', $trans_pdf);
	  $trans_file_html= str_replace('.pdf', '_trans.html',$trans_pdf);

    if ($player->transcript_url) {
	  if (!file_exists($trans_pdf)) { #$trans_file_html)) {
	    $res = $this->_http_request_curl($player->transcript_url);
		if (!$res->success) {
		  // Log error.
		  log_message('error', __CLASS__.". Error getting transcript, $player->transcript_url | ".$res->info['http_code']);
		}
	  }
	}

    if ($res && $res->success && $res->data) {
	  $pdf = file_put_contents($trans_pdf, $res->data);
	}

	if ($pdf || !file_exists($trans_file_html)) {
	  $this->CI->load->library('Pdftohtml');

	  try {
	    $html = $this->CI->pdftohtml->parse($trans_pdf, $trans_file_xml);
	  } catch (Exception $e) {
	    // Log error.
        log_message('error', __CLASS__.". Error parsing PDF transcript | ".$e->getMessage());

	  }
	}
	if ($html) {
	  $b2 = file_put_contents($trans_file_html, $html);
	  $player->transcript_html = $html;
	}
	elseif (file_exists($trans_file_html)) {
	  // OR get an existing HTML snippet.
	  $player->transcript_html = file_get_contents($trans_file_html);
	}

    return $player;
  }

}
