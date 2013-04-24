<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * OU Media Player helper functions.
 *
 * @copyright Copyright 2011 The Open University.
 * @author N.D.Freear.
 */


/** JSON encode a string, removing the outer quotes (").
*/
function json_encode_str($str) {
  return str_replace("'", "\\'", trim(json_encode($str), '"{}'));
}

/** JSON encode an object, removing the outer braces {}.
*/
function json_encode_bare($obj) {
  return str_replace("'", "\\'", trim(json_encode($obj), '{}'));
}


/** Convert special characters '<', '"', etc. to HTML5 entities.
*
* @link http://stackoverflow.com/questions/13745353/what-do-the-ent-html5-ent-html401-modi ..
* @link http://php.net/manual/en/changelog.strings.php PHP 5.4+
*/
if (! defined('ENT_HTML401')) {
  define('ENT_HTML401', 0);
  define('ENT_XML1', 16);
  define('ENT_XHTML', 32);
  define('ENT_HTML5', 16|32);
}
function html_chars($str, $flags = NULL, $encoding = 'UTF-8', $double_encode = FALSE) {
  if (! $flags) $flags = ENT_COMPAT | ENT_HTML5;
  return htmlspecialchars($str, $flags, $encoding, $double_encode);
}


/** Does haystack contain needle? (Semantic wrapper around 'strpos')
*/
function contains($haystack, $needle) {
  return FALSE !== strpos($haystack, $needle);
}


// ====================================================================

/**
 * Site URL. (Based on `/system/helpers/url_helper.php`)
 * @return string
 */
if ( ! function_exists('site_url'))
{
  function site_url($uri = '')
  {
    $CI =& get_instance();
    $site_url = $CI->config->site_url($uri);
    return preg_replace('@https?:\/\/@', '//', $site_url);
  }
}

/**
* Output the URL for a Player-engine or theme resource.
* Note, the URL is HTTPS/SSL-neutral (//host/path) and contains a hash/version ID.
* @link http://google-styleguide.googlecode.com/svn/trunk/htmlcssguide.xml#Protocol
  @param string $uri Path
  @param bool $hash Whether to use a hash/version ID in the URL.
* @return string
*/
function player_res_url($uri = '', $hash = true, $return = false) {
  static $base_url;
  if (! $base_url) {
    //Was: $base_url = preg_replace('@https?:\/\/@', '//', base_url());
    $p = parse_url(base_url());
    $base_url = $p['path'];
  }

  if ($hash) {
    $hash = '?v=0';
  } else {
    $hash = '';
  }

  if ($return) {
    return $base_url. $uri . $hash;
  }
  echo $base_url. $uri . $hash;
}

/**
* Output URL for a site resource - HTTPS/SSL-neutral (iet-it-bugs:1329)
* @return string
*/
function site_res_url($uri = '') {
  $p = parse_url(base_url());
  $site_url = $p['path'] . $uri;

  return $site_url;
}

// ====================================================================


/** Return class and aria-label attributes for player controls.
* @return string
*/
function _oupc_label($className, $text) {
  return "class=\"$className\" aria-label=\"$text\"";
}

  /** Return the path for the main Flowplayer Flash file, based on config. variables.
  * @return string
  */
  function _flowplayer_flash() {
    $CI =& get_instance();
    $flowplayer_dev= $CI->config->item('flowplayer_dev');
    $flow_key      = $CI->config->item('flowplayer_key');
    $flow_commercial= $flow_key ? '.commercial' : '';
    $flow_version  = $CI->config->item('flowplayer_version');
    if(!$flow_version || !$flow_key){$flow_version='3.2.7';}

	if ($flowplayer_dev) {
	  return "assets/flowplayer_dev/flowplayer$flow_commercial.swf";
	}
	return "swf/flowplayer$flow_commercial-$flow_version.swf";
  }

  /** Return the path for a Flowplayer Flash plugin, based on config. variables.
  * @return string
  */
  function _flowplayer_plugin($name, $version) {
    $flowplayer_dev = config_item('flowplayer_dev');
	if ($flowplayer_dev) {
	  return "flowplayer.$name.swf";
	}
	return "flowplayer.$name-$version.swf";
  }

function cache_exists($key) {
  $CI =& get_instance();
  $CI->load->driver('cache', array('adapter'=>'file')); #,array('adapter'=>'apc', 'backup'=>'file'));
  $stat = $CI->cache->get_metadata($key);
  return (bool) $stat;
}

function cache_time($key) {
  $CI =& get_instance();
  $CI->load->driver('cache', array('adapter'=>'file'));
  $stat = $CI->cache->get_metadata($key);
  
#var_dump($stat);
  return $stat['mtime'];
}
