<?php
/** OU player helper functions.
 *
 * @copyright Copyright 2011 The Open University.
 */

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
