<?php
/** OU player helper functions.
 *
 * @copyright Copyright 2011 The Open University.
 */

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
