<?php
/**
 * Captions/timed-text controller.  NDF, 27 April 2011.
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
	    $file = $captions[$custom_id][$shortcode];

		$path = config_item('data_dir')."oupodcast/captions/$file";
		//var_dump($path);
		if (file_exists($path)) {
		    header('Content-Type: application/xml; charset=utf-8');
			header("Content-Disposition: inline; filename=$file");
			echo file_get_contents($path);
		} else {
		  //Error 404.
		  die('404');
		}
	} else {
		//Error 404.
		die('404');
	}
  }
}
