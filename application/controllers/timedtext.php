<?php
/**
 * Captions/timed-text controller.  NDF, 27 April 2011.
 *
 * Very important - Flowplayer only accepts,
 *   xmlns="http://www.w3.org/2006/10/ttaf1"
 * NOT
 *   xmlns="http://www.w3.org/2006/04/ttaf1"
 *
 * @copyright Copyright 2011 The Open University.
 */
#require_once APPPATH.'libraries/ouplayer_lib.php';


class Timedtext extends CI_Controller {

  /** OU-podcast player captions.
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
