<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Base class for all oEmbed service provider libraries.
 *
 * @copyright Copyright 2011 The Open University.
 * @author N.D.Freear, extracted from oem. controller 24 Feb 2011/ extended 4 July 2012.
 */


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
  public $_logo_url = NULL;
  public $_regex_real = NULL;
  public $_examples = array();
  public $_google_analytics = NULL; # 'UA-12345678-0'

  public $_access = 'public';	# public|private|unpublished|external (Also 'maturity'..?)

  protected $_endpoint_url;		# oEmbed endpoint for 'external' providers, eg. iSpot.
  protected $_comment;			# Single-line comment aimed at developers.


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
    $this->_google_analytics = google_analytics_id($this->name);
  }


  /** Get the machine-readable name for the Scripts controller.
  * @return string
  */
  public function getName() { return $this->name; }

  /** Get the oEmbed type for the Scripts controller.
  */
  public function getType() { return $this->type; }

  /** Get the path to the view for the Oembed controller (relative to application/views directory, without '.php').
  * @return string
  */
  public function getView() {
    return 'oembed/'. $this->name;
  }

  /** Get the regular expression for the Oembed controller.
  * @return string
  */
  public function getInternalRegex() {
    return $this->_regex_real ? $this->_regex_real : str_replace(array('*', '/'), array('([\w_-]*?)', '\/'), $this->regex);
  }

  /** Get the Google Analytics account ID.
  * @return string
  */
  public function getAnalyticsId() {
    return $this->_google_analytics;
  }

  /** Get 'published' provider-properties for Services controller (Cf. http://api.embed.ly/1/services)
  * @return object
  */
  public function getProperties() {
    $choose = explode('|', 'regex|about|displayname|name|domain|subdomains|favicon|type');
    $props = (object)array();
    foreach (get_object_vars($this) as $key => $value) {
      if (in_array($key, $choose)) {
        $props->{$key} = $value;
      }
    }
    if (is_string($props->regex)) {
      $props->regex = array($props->regex);
    }
    $props->about = str_replace(array('  ', "\r"), '', $props->about);
    if (isset($this->_endpoint_url)) {
      $props->_oembed_endpoint = $this->_endpoint_url;
    }
    if (isset($this->_comment)) {
      $props->_comment = $this->_comment;
    }
    return $props;
  }

  /** Get one or more example URLs.
  * @return mixed Array or FALSE.
  */
  public function getExamples($count = 1) {
    if ('public' != $this->_access || count($this->_examples) < 1) return FALSE;

    // '-1' means 'all'.
    if ($count < 1) return $this->_examples;

    return array_slice($this->_examples, 0, $count);
  }


  protected function _error($message, $code=500, $from=null, $obj=null) {
    return $this->CI->_error($message, $code, $from, $obj);
  }

  protected function _log($level, $message, $php_error=FALSE) {
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


/**
 * Extend the base class for a generic IFRAME oEmbed provider.
 */
abstract class Generic_Iframe_Oembed_Provider extends Oembed_Provider {

  public function getView() {
    return 'oembed/_generic_iframe';
  }

  protected function getIframeResponse($url) {
    return (object) array(
        '_comment' => '/*TODO: work-in-progress! */',
        'original_url' => $url,
        #'is_iframe' => TRUE,
        #'view_name' => $this->getView(),
        'class_name' => $this->name,
        'provider_name' => $this->displayname,
        'provider_url' => $this->_about_url,
        'provider_icon' => $this->favicon,
        'type' => $this->type, #rich
        'title'=> NULL,
        'width' => '100%', #640, #720,
        'height'=> 400, #$height,
        'embed_url'=> NULL,
    );
  }
}


/**
 *
 */
abstract class External_Oembed_Provider extends Oembed_Provider {

  #protected $_endpoint_url;	# oEmbed endpoint for 'external' providers, eg. iSpot.

  public function call($url, $matches) {
    $this->_error('sorry the endpoint is: '. $this->_endpoint_url, 400.9);
  }
}


