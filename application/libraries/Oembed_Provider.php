<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Base class for all oEmbed service provider libraries.
 *
 * @copyright Copyright 2011 The Open University.
 */
//NDF, extracted from oembed controller, 24 Feb. 2011/ extended 4 July 2012.

interface iService {

  /** call.
  * @return object Return a $meta meta-data object, as inserted in DB.
  */
  public function call($url, $regex_matches);
}

/** Was: Base_service
*/
abstract class Oembed_Provider implements iService {

  public $regex = '';			# array();
  public $about = '';			# Human
  public $displayname = '';		# Human, mixed-case
  public $name = NULL;			# Auto-generate, machine-readable, lower-case.
  public $domain = '';			# HOST
  public $subdomains = array();	# HOSTs
  public $favicon = '';			# URL
  public $type = 'rich';		# photo|video|link|rich (http://oembed.com/#section2.3) NOT 'audio'

  public $_type_x = NULL;
  public $_about_url = NULL;
  public $_regex_real = NULL;
  public $_examples = array();
  public $_google_analytics = NULL; # 'UA-12345678-0'

  public $_access = 'public';	# public|private|unpublished|external (Also 'maturity'..?)

/* JSON: http://api.embed.ly/1/services [
{
 "regex": ["http://*youtube.com/watch*", "http://*.youtube.com/v/*", "https://*youtube.com/watch*", "https://*.youtube.com/v/*", "http://youtu.be/*",  ...  ],
 "about": "YouTube is the world's most popular online video community, allowing millions ...",
 "displayname": "YouTube",
 "name": "youtube",
 "domain": "youtube.com",
 "subdomains": ["m.youtube.com"],
 "favicon": "http://c2548752.cdn.cloudfiles.rackspacecloud.com/youtube.ico",
 "type": "video"
},
..
] */

  protected $CI;

  /** Constructor: auto-generate 'name' property.
  */
  public function __construct() {
    $this->CI =& get_instance();

    // We use $this - an instance, not a class.
    $this->name = strtolower(preg_replace('#_serv$#i', '', get_class($this)));

    // Get the Google Analytics ID, if available.
    $this->CI->config->load('providers');
    $ga_analytics_ids = $this->CI->config->item('provider_google_analytics_ids');
    if (isset($ga_analytics_ids[$this->name])) {
      $this->_google_analytics = $ga_analytics_ids[$this->name];
    }
  }


  protected function _error($message, $code=500, $from=null, $obj=null) {
    return $this->CI->_error($message, $code, $from, $obj);
  }

  protected function _log($level='error', $message, $php_error=FALSE) {
    return $this->CI->_log($level, $message, $php_error);
  }


  protected function _http_request_curl($url, $spoof=TRUE, $options=array()) {
    $this->CI->load->library('http');
    return $this->CI->http->request($url, $spoof, $options);
  }

  protected function _http_request_json($url, $spoof=TRUE, $options=array()) {
    $result = $this->_http_request_curl($url, $spoof, $options);
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

