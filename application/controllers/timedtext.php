<?php
/**
 * Captions/timed-text controller.
 *
 * Very important - Flowplayer only accepts,
 *   xmlns="http://www.w3.org/2006/10/ttaf1"
 * NOT
 *   xmlns="http://www.w3.org/2006/04/ttaf1"
 *
 * @author N.D.Freear, 27 April 2011/6 February 2012.
 * @copyright Copyright 2012 The Open University.
 */
#require_once APPPATH.'libraries/ouplayer_lib.php';

#define('PROXY', 'wwwcache.open.ac.uk:80');
define('TTML_NS', 'http://www.w3.org/2006/10/ttaf1');
error_reporting(E_ALL);
ini_set('display_errors', 1);


class Timedtext extends CI_Controller {


  // Captions for Mediaelement-based players.

  /**
   * TTML+XML to WebVTT (Web Video Text Tracks) parser.
   * Copyright 2012-02-06 N.D.Freear/ The Open University.
   *
   * See, http://dev.w3.org/html5/webvtt/#the-webvtt-file-format
   * See, http://www.delphiki.com/webvtt/
   *
   * FROM: oup-mep/webvtt.php
   */
  public function webvtt() {

    $ttml_url = isset($_GET['url']) ? $_GET['url'] :
      'http://podcast.open.ac.uk/feeds/student-experiences/closed-captions/openings-being-an-ou-student.xml';
    $debug = isset($_GET['debug']) ? $_GET['debug'] : null;

    if (! $ttml_url) {
      header("HTTP/1.0 400 Bad Request");
      echo "Error, 'url' is a required parameter.";
      exit;
    }

	$CI =& get_instance();
	$CI->load->library('http');

    $result = $CI->http->request($ttml_url, $spoof=FALSE);
	//_http_request_curl($ttml_url);

    if (! $result->success) {
      header("HTTP/1.0 400 Bad Request");
      echo "Error, ". $result->error;
      var_dump($result->info);
      exit;
    }

    /*simplexml_load_string*/
    $xmlo = new SimpleXMLElement($result->data);

    if ($debug) {
      header('Content-Type: text/plain; charset=UTF-8');
    } else {
      header('Content-Type: text/vtt; charset=UTF-8');
    }
    @header('X-Input-TTML: '.$ttml_url);
    @header('Content-Disposition: inline; filename='.basename($ttml_url).'.vtt');
    echo 'WEBVTT'.PHP_EOL.PHP_EOL;

    // Get declared namespaces.
    $ns = $xmlo->getDocNamespaces();

    $ns_string = '';
    foreach ($ns as $pre => $url) {
      $fix = ''==$pre ? 'xmlns' : 'xmlns:'.$pre;
      $ns_string .= " $fix='$url'";
    }

    $count=0;
foreach ($xmlo->body->div->p as $el => $para) {
  $count++;

  $text ='';
  $line = $para;
  /*if (isset($para->span)) {
    $line = $para->span;
  }*/

  if ($line->br) {
    $para_n = str_replace('<br/>', ' ', $line->asXML());
    $xml_n = "<x $ns_string>$para_n</x>";
    $xmlo_n = new SimpleXMLElement($xml_n);
    if (isset($xmlo_n->p->span)) {
      foreach ($xmlo_n->p->children() as $span) {
        $text .= (string) $span.' ';
      }
    } else {
      $text = (string) $xmlo_n->p;
    }
  } elseif (isset($para->span)) {
    $text = (string) $para->span;
  } else {
    $text = (string) $line;
  }
  echo
    $count.PHP_EOL
    .$para['begin'].' --> '.$para['end'].PHP_EOL
    .$text .PHP_EOL.PHP_EOL;
}

  }



  // Captions for Flowplayer-based players.

  /**
  *  OU-podcast player captions - TTML format.
  */
  public function pod_captions($custom_id, $shortcode, $captions_file=null) {

    $captions = config_item('captions'); #$this->CI->config->item
    if (isset($captions[$custom_id][$shortcode])) {
	    $cc_file = $captions[$custom_id][$shortcode];

		$cc_path = config_item('data_dir')."oupodcast/captions/$cc_file";

		if (file_exists($cc_path)) {
		    header('Content-Type: application/xml; charset=utf-8');
			header("Content-Disposition: inline; filename=$cc_file");
			#header('Content-Type: text/xml');
			#header('Accept-Ranges: bytes');
			echo file_get_contents($cc_path);
		} else {
		  //Error 404.
		  die('404.1');
		}
	} else {
		//Error 404.
		die('404.2');
	}
  }
}
