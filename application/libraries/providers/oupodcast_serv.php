<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * OU Media Player/ OU Podcast oEmbed service provider.
 *
 * @copyright Copyright 2011 The Open University (IET).
 * @author N.D.Freear, 3 March 2011.
 */
require_once APPPATH.'libraries/ouplayer_lib.php';


class Oupodcast_serv extends Oembed_Provider {

  public $regex = 'http://podcast.open.ac.uk/*/*';
  public $about = <<<EOT
  Learn at any time with The Open University audio and video podcasts.
  Embed podcast audio and video on topics including study and research via the OU Media Player. [Public and restricted access.]
EOT;
  public $displayname = 'OU Podcasts (beta)';
  public $domain = 'podcast.open.ac.uk';
  public $favicon = 'http://www3.open.ac.uk/favicon.ico';
  public $type = 'video';

  public $_type_x = 'video|audio'; #Or 'audio'!!
  public $_about_url = 'http://podcast.open.ac.uk/';

  # regex_real: 'podcast.open.ac.uk/(pod|\w+|feeds).*([\/#]\w|\.m4v|\.mp3)$',
  public $_regex_real = ':\/\/(media\-)?podcast\.open\.ac\.uk\/.*\/(?P<col>[\w-]+)(?P<sep>[\/#]+!?)(?P<sc>\w{10}|\w+\.m\w{2})$';
  ///public $_regex_real = ':\/\/podcast\.open\.ac\.uk\/.*\/([\w-]+)([\/#]+!?)(\w{10}|\w+\.m\w{2})$';
  public $_examples = array(
    'Student views of the OU (video)'
        => 'http://podcast.open.ac.uk/pod/student-experiences#!db6cc60d6b',
    'A Buen Puerto/Spanish: Introduction (audio)'
        => 'http://podcast.open.ac.uk/pod/l314-spanish#!fe481a4d1d',
    'http://podcast.open.ac.uk/feeds/l314-spanish/l314audio1.mp3',
  'http://podcast.open.ac.uk/oulearn/languages/spanish/podcast-l314-spanish/fe481a4d1d', # '#!' or '/'
    'Invisible Boundaries..: Entrepreneurial Lives (audio)' => 'http://podcast.open.ac.uk/pod/entrepreneurial-lives/#!cb127010cf',
    'Motion...: All the Fun of the Fair (video)' => 'http://podcast.open.ac.uk/pod/mst209-fun-of-the-fair#!a67918b334',
    'VC message 01-02-2011 (private/staff)' => 'http://podcast.open.ac.uk/pod/vc-message-to-staff#!746ee92293',
    'New to OU study (hidden: tips)' => 'http://podcast.open.ac.uk/pod/new-to-ou-study/a9e72b75ff',
  );
  public $_access = 'public';
  protected $_comment = 'This endpoint will be deprecated in favour of http://mediaplayer.open.ac.uk [live]';
  protected $embed_url;

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

      $endpoint = $this->CI->config->item('player_oembed_endpoint');
      if ($endpoint) {
        $this->_endpoint_url = $endpoint;
        //$this->_comment = NULL;
        $this->CI->_debug(array('ouplayer_endpoint' => $endpoint));
      }
      // Was @header()
      $this->CI->_debug('podcast_data='.$method);
  }

  /**
  * Implementation of call() - used by oEmbed controller.
  */
  public function call($url, $matches) {
      $basename = str_replace(array('podcast-','pod-'), '', $matches[ 'col' ]); #$matches[1]
      $separator= $matches[ 'sep' ];  #$matches[2]
      $fragment = $matches[ 'sc' ];   #$matches[3]
      $is_file  = FALSE!==strpos($fragment, '.');

      $this->embed_url = site_url("embed/pod/$basename/$fragment") . $this->CI->options_build_query();  //?theme=..&debug=..
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

	  if ($this->CI->_is_debug(OUP_DEBUG_MAX)) {
		$this->CI->_debug($player);
	  }
      return $player;
  }

  public function getExamples($count = 2) {
    return parent::getExamples($count);
  }

  protected function _init_player($result) {
    $player = new Podcast_player;

	$player->width = Podcast_player::DEF_WIDTH;
	$player->height = Podcast_player::DEF_HEIGHT;

    foreach ($result as $key => $value) {
	  $player->{$key} = $value;
	}

    if (isset($this->CI->theme)) {
      $theme = $this->CI->theme;
      $theme->prepare_banner($player);

      $player->_theme = (object) array(
        'name' => str_replace('_', '-', $theme->getName()),
        'controls_height' => $theme->getControlsHeight(),
        'controls_overlap'=> !$player->is_video() || $theme->controlsOverlap(),
        'banner' => $theme->has_title_banner(),
      );
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
    $player->iframe_url = $this->embed_url;

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


  protected function _get_html_transcript(& $player) {
    if (! $player->transcript_html_url) return FALSE;

    $res = FALSE;

    $trans_n2_html = $this->CI->config->item('data_dir').'oupodcast/'.basename($player->transcript_html_url);
    $trans_n2_html= preg_replace( '/\.html?$/', '_trans_n2.html', $trans_n2_html);
    //$trans_n2_html= str_replace(array('.html', '.htm'), '_trans_n2.html', $trans_n2_html);

	if (! file_exists($trans_n2_html)) {
	  $res = $this->_http_request_curl($player->transcript_html_url);
      if ($res->success) {

        $this->CI->_debug( "Success getting HTML transcript (N2-A), $player->transcript_html_url | " . $res->http_code );

      } else {
        // Log error.
        log_message('error', __CLASS__.". Error getting HTML transcript (N2), $player->transcript_html_url | " . $res->http_code);
        $this->CI->_debug( "Error getting HTML transcript (N2-A), $player->transcript_html_url | " . $res->http_code );
      }
    }

    // We're only using the Pdftohtml::filter() call.
    $this->CI->load->library('Pdftohtml');

	if ($res && $res->success && $res->data) {
	  $b1 = @file_put_contents($trans_n2_html, $res->data);
	  if ($b1) {
        $this->CI->_log('debug', "Transcript file written, $b1 bytes (N2), $trans_n2_html");
        $this->CI->_debug("Transcript file written, $b1 bytes (N2), $trans_n2_html");

        $player->transcript_html = '<!--N2-->'. $this->CI->pdftohtml->filter($res->data);
	  } else {
		$this->CI->_log('error', __CLASS__.". Error writing HTML transcript (N2), $trans_n2_html");
		$this->CI->_debug('Error writing HTML transcript (N2)');
		return FALSE;
	  }
	}
    elseif (file_exists($trans_n2_html)) {
      // OR get an existing HTML snippet.
      $player->transcript_html = '<!--N2-->'. $this->CI->pdftohtml->filter(@file_get_contents($trans_n2_html));
      if (! $player->transcript_html) {
        $this->CI->_log('error', __CLASS__.". Error getting HTML transcript (N2).");
        return FALSE;
      }
      if (preg_match( '/(\<\!DOCTYPE|Sign IN)/i', $player->transcript_html )) {
        $this->CI->_log( 'error', __CLASS__ . '. Unexpected HTML transcript (N2) - A.' );
        $this->CI->_debug( __CLASS__ . '. Unexpected HTML transcript (N2) - A.' );
        $player->transcript_html = NULL;
        return FALSE;
      }
    }
    return TRUE;
  }


  /** Either get PDF transcript (from remote site) and convert to HTML snippet, or return existing snippet.
  * Note, an intermediate XML file is saved.
  */
  public function get_transcript($player) {

    $player->transcript_html = NULL;

    $hres = $this->_get_html_transcript($player);

    if ($hres) return $player;

    // @deprecated

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
	  $pdf = @file_put_contents($trans_pdf, $res->data);
	  if (! $pdf) {
		$this->CI->_log('error', __CLASS__.". Error writing PDF transcript, $trans_pdf");
		$this->CI->_debug('Error writing PDF transcript');
		#echo '<META name="ERROR" content="Error writing PDF transcript" />' .PHP_EOL;

		return $player;
	  }
	}

	$this->CI->load->library('Pdftohtml');

    $f_pdftohtml = $this->CI->config->item('pdftohtml_path');
    if ($f_pdftohtml) {

      if ($pdf || !file_exists($trans_file_html)) {
        try {
          $html = $this->CI->pdftohtml->parse($trans_pdf, $trans_file_xml);
        } catch (Exception $e) {
          // Log error.
          $this->CI->_log('error', __CLASS__.". Error parsing PDF transcript | Pdftohtml | ".$e->getMessage());
        }
      }
    } else {
      // Fallback to pure PHP library on IT-hosting (#1409).
      # TODO: error, PDF2Text echoes to screen - messes up header() call.
      #$html = $this->_pdf2text($trans_pdf);

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


  /**
  * @deprecated
  *
  * Fallback to pure PHP library on IT-hosting (#1409).
  * @return string
  */
  protected function _pdf2text($pdf_file) {
    # TODO: error, PDF2Text echoes to screen - messes up header() call.
    require_once __DIR__ . '/../class.pdf2text.php';

    $pdf = new PDF2Text();
    $pdf->setFilename($pdf_file);
    $pdf->decodePDF();

    $result = $pdf->output();

    // Fix floating 's' 'th' ',' etc - English locale-specific.
    $result = preg_replace('#(\w)\ss\s#', '$1s ', $result);
    $result = preg_replace('#\sth\s\w#', ' th$1', $result);
    $result = preg_replace('#\s([,\.;])#', '$1', $result);

    // Concatenate lines starting with lowercase letters.
    $result = preg_replace('#\s+([a-z])#', ' $1', $result);

    $result = str_replace('  ', ' ', $result);

    // A crude conversion to HTML.
    #$html = preg_replace('#([\w\. ])\n(\r)?\n(\w)#ms', '$1<br>$2', $result);
    $html = str_replace(array("\n\n\n", "\n\n", "\n"), '<br>', $result);

    return $html;
  }
}
