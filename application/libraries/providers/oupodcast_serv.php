<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * OU Media Player/ OU Podcast oEmbed service provider.
 *
 * @copyright Copyright 2011 The Open University.
 * @author N.D.Freear, 3 March 2011.
 */
require_once APPPATH.'libraries/Oembed_Provider.php';
require_once APPPATH.'libraries/ouplayer_lib.php';


class Oupodcast_serv extends Oembed_Provider {

  public $regex = 'http://podcast.open.ac.uk/*/*';
  public $about = <<<EOT
  Podcast audio and video on topics including study and research at The Open University. Embed podcasts via the OU Media Player. [Public and restricted access.]';
EOT;
  public $displayname = 'OU Podcast';
  public $domain = 'podcast.open.ac.uk';
  public $favicon = 'http://www3.open.ac.uk/favicon.ico';
  public $type = 'video';

  public $_type_x = 'video|audio'; #Or 'audio'!!
  public $_about_url = 'http://podcast.open.ac.uk/';

  # regex_real: 'podcast.open.ac.uk/(pod|\w+|feeds).*([\/#]\w|\.m4v|\.mp3)$',
  public $_regex_real = ':\/\/podcast\.open\.ac\.uk\/.*\/([\w-]+)([\/#]+!?)(\w{10}|\w+\.m\w{2})$';
  public $_examples = array(
    'A Buen Puerto/Spanish: Introduction (audio)' => 'http://podcast.open.ac.uk/pod/l314-spanish#!fe481a4d1d',
      'http://podcast.open.ac.uk/feeds/l314-spanish/l314audio1.mp3',
      'http://podcast.open.ac.uk/oulearn/languages/spanish/podcast-l314-spanish/fe481a4d1d', # '#!' or '/'
    'Invisible Boundaries..: Entrepreneurial Lives (audio)' => 'http://podcast.open.ac.uk/pod/entrepreneurial-lives/#!cb127010cf',
    'Motion...: All the Fun of the Fair (video)' => 'http://podcast.open.ac.uk/pod/mst209-fun-of-the-fair#!a67918b334',
    'VC message 01-02-2011 (private/staff)' => 'http://podcast.open.ac.uk/pod/vc-message-to-staff#!746ee92293',
    'New to OU study (hidden: tips)' => 'http://podcast.open.ac.uk/pod/new-to-ou-study/a9e72b75ff',
    '_OEM'=>'/oembed?url=http%3A//podcast.open.ac.uk/pod/vc-message-to-staff%23!746ee92293',
  );
  public $_access = 'public';

  //NDF: const POD_BASE = 'http://podcast.open.ac.uk';


  public function __construct() {
      parent::__construct();

      if ($this->CI->config->item('podcast_data_use_feed')) {
        $this->CI->load->model('Podcast_items_feed_model', 'podcast_items_model');
        $method = 'feed';
      } else {
        // Or the original database model.    
        $this->CI->load->model('podcast_items_model');
        $method = 'db';
      }
      @header('X-Podcast-Data: '.$method);
  }

  /**
  * Implementation of call() - used by oEmbed controller.
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
      //NDF: $pod_base = self::POD_BASE;

	  $edge  = $this->CI->input->get('edge');
	  $audio_poster= $this->CI->input->get('poster'); #Only for audio!

	  // Query the podcast DB.
      $result = $this->CI->podcast_items_model->get_item($basename, $fragment, $captions=TRUE);
      #$result = $result_A[0];
      if (!$result) {
	      $this->CI->_error('podcast item not found.', 404, __CLASS__);
      }

	  // TODO: derive from maxwidth/maxheight!
	  $width = Podcast_player::DEF_WIDTH;
	  $height= Podcast_player::DEF_HEIGHT;

	  if (isset($result->media_url)) {
		  // Initialize player from feed object.
		  $player = $this->_init_player($result); #(Podcast_player) cast?
	  } else {
	      // Process result from database.
	      $player = $this->_process_DB_result($result);
	  }

	  $player->calc_size($width, $height, $audio_poster);
	  $player = $this->_get_related_link($player, $result);
	  $player = $this->_get_caption_url($player, $result);

	  $this->_post_process($player);

	  $this->CI->firephp->fb($player, 'player', 'LOG');

      return $player;
  }

  protected function _init_player($result) {
    $player = new Podcast_player;

	$player->width = Podcast_player::DEF_WIDTH;
	$player->height = Podcast_player::DEF_HEIGHT;
	
    foreach ($result as $key => $value) {
	  $player->{$key} = $value;
	}
	return $player;
  }

  protected function _process_DB_result($result) {
      $pod_base = $this->config->item('podcast_media_base');
      if (! $pod_base) {
        // NDF: needs testing!
        $this->_error("Missing or empty \$config[podcast_media_base] in 'config/embed_config.php'", 503);
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
	  $player->summary = $result->pod_summary;
	  $player->media_html5 = TRUE;
	  // The oEmbed type, not the PIM.media_type in the podcast DB.
	  $player->media_type = 'audio'==strtolower($result->source_media) ? 'audio' : 'video';
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
	  // Iframe - see $this->_post_process() method.
	  $player->iframe_url = NULL;

	  $player->_podcast_id = $result->podcast_id;
	  $player->_album_id = $custom_id;
	  $player->_track_md5= $shortcode;
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

  /** Post process the player object.
  */
  protected function _post_process(&$player) {
    // Our <iframe> embed!!
    $player->iframe_url = site_url("embed/pod/$player->_album_id/$player->_track_md5").$this->CI->options_build_query(); #?width=$width&amp;height=$height";

    // Mediaelement.js doesn't seem to like 'x-m4v'.
    // And, Webkit HTML5 doesn't like 'video/m4v'.
    if ('video/x-m4v' == $player->mime_type) {
      $player->mime_type = 'video/mp4';
    }
  }

  /** Get the related link, and especially associated text. */
  protected function _get_related_link($player, $result) {
      $rel_url = $player->_related_url = isset($result->link) ? $result->link : $result->target_url;
            #OR target_url (target_url_text/ link_text). #'_related_text'=>
      $rel_text= isset($result->link_text) ? $result->link_text : $result->target_url_text;
      if (false!==strpos($rel_url, 'open.ac.uk/course')
       || false!==strpos($rel_url, 'open.ac.uk/study')) {
        $rel_text = t('%s, in Study at The Open University', $rel_text);
      }
	  elseif (false!==strpos($rel_url, 'openlearn.open.ac.uk')) {
	    $rel_text = t('OpenLearn at The Open University');
	  }
	  elseif (false!==strpos($rel_url, '/podcast.open.ac.uk')) {
	    $rel_text = t('Open University Podcasts');
	  }
	  elseif (false!==strpos($rel_url, 'cloudworks.ac.uk')) {
	    $rel_text = t('Cloudworks, hosted at The Open University');
	  }
	  elseif (false!==strpos($rel_url, '/jime.open.ac.uk')) {
	    $rel_text = t('Journal of Interactive Media in Education (JIME)');
	  }
	  elseif (false!==strpos($rel_url, 'open.ac.uk')) {
        if ($rel_text) {
          $rel_text = t('%s, at The Open University', $rel_text);
        } else {
          $rel_text = t('The Open University');
        }
      }
      //( Deprecated: $player->_related_text = t('Related link: %s', $rel_text); )
      $player->_related_text = $rel_text;

      return $player;
  }

  /**
    http://embed.open.ac.uk/embed/pod/student-experiences/db6cc60d6b
    http://embed.open.ac.uk/embed/pod/1135/734418f016 - Mental health.
  */
  protected function _get_caption_url($player, $result) {
    // First, try to use captions hosted via podcast DB.
	if (isset($result->pim_type) && 'cc-dfxp'==$result->pim_type) {
		$player->caption_url = self::POD_BASE."/feeds/$player->_album_id/closed-captions/$result->pim_filename";
	}
	// Then, override with locally hosted captions if applicable.
	$captions = $this->CI->config->item('captions');
	if (isset($captions[$player->_album_id]/*Was: _podcast_id*/) && isset($captions[$player->_album_id][$player->_track_md5])) {
	    $player->caption_url = site_url("timedtext/pod_captions/$player->_album_id/$player->_track_md5/en.xml");
	}
	return $player;
  }

  /** Either get PDF transcript (from remote site) and convert to HTML snippet, or return existing snippet.
  * Note, an intermediate XML file is saved.
  */
  public function get_transcript($player) {

    $player->transcript_html = NULL;

    if (! $player->transcript_url) return $player;

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

	$this->CI->load->library('Pdftohtml');

	if ($pdf || !file_exists($trans_file_html)) {
	  try {
	    $html = $this->CI->pdftohtml->parse($trans_pdf, $trans_file_xml);
	  } catch (Exception $e) {
	    // Log error.
        $this->CI->_log('error', __CLASS__.". Error parsing PDF transcript | ".$e->getMessage());

	  }
	}
	if ($html) {
	  $b2 = file_put_contents($trans_file_html, $html);
	  $this->CI->_log('debug', "Transcript file written, $b2 bytes, $trans_file_html");
	  $player->transcript_html = $this->CI->pdftohtml->filter($html);
	}
	elseif (file_exists($trans_file_html)) {
	  // OR get an existing HTML snippet.
	  $player->transcript_html = $this->CI->pdftohtml->filter(@file_get_contents($trans_file_html));
	  if (! $player->transcript_html) {
	    //Error/ warning?
	    $this->CI->_log('error', __CLASS__.". Error getting HTML transcript.");
	  }
	}

    return $player;
  }

}
