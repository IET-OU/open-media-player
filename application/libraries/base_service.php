<?php
/** Base class for all oEmbed service provider libraries.
 *
 * @copyright Copyright 2011 The Open University.
 */
//NDF, extracted from oembed controller, 24 Feb. 2011.

interface iService {
  /** call.
  * @return object Return a $meta meta-data object, as inserted in DB.
  */
  public function call($url, $regex_matches);
}

abstract class Base_service implements iService {

  protected $CI;

  public function __construct() {
    $this->CI =& get_instance();
  }

  protected function _http_request_curl($url, $spoof=TRUE) {
    $this->CI->load->library('http');
    return $this->CI->http->request($url, $spoof);
  }
  
  protected function _http_request_json($url, $spoof=TRUE) {
    $result = $this->_http_request_curl($url, $spoof);
    if ($result->success) {
      $result->json = json_decode($result->data);
    }
    return $result;
  }

  protected function _safe_xml($xml) {
    $safe = array('&amp;', '&gt;', '&lt;', '&apos;', '&quot;');
    $place= array('#AMP#', '#GT#', '#LT#', '#APOS#', '#QUOT#');
    $result = str_replace($safe, $place, $xml);
    $result = preg_replace('@&[^#]\w+?;@', '', $result);
    $result = str_replace($place, $safe, $result);
    return $result;
  }

  /**Safely, recursively create directories.
   * Status: not working fully, on Windows.
   * Source: https://github.com/nfreear/moodle-filter_simplespeak/blob/master/simplespeaklib.php
   */
  function _mkdir_safe($base, $path, $perm=0777) { #Or 0664.
    $parts = explode('/', trim($path, '/'));
    $dir = $base;
    $success = true;
    foreach ($parts as $p) {
      $dir .= "/$p";
      if (is_dir($dir)) {
	    break;
      } elseif (file_exists($dir)) {
        #error("File exists '$p'.");
      }
      $success = mkdir($dir, $perm);
    }
    return $success;
  }

  /** Get the Embed.ly API key
  * @return string
  */
  protected function _embedly_api_key() {
    return $this->CI->config->item('embedly_api_key');
  }

  /** Get an Embed.ly oEmbed URL / JSON format.
  * @return string
  */
  protected function _embedly_oembed_url($url) {
    return "http://api.embed.ly/1/oembed?format=json&url=$url&key=".$this->_embedly_api_key();
  }
}

