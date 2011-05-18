<?php
/** Internationalization.
*
* @copyright Copyright 2011 The Open University.
*/

class My_Lang extends CI_Lang {

  public function __construct() {
    parent::__construct();
	log_message('debug', __CLASS__." Class Initialized");
  }
}


/* 'translate text' placeholder - Internationalization/ Localization.
 * See: cloudengine/libs./MY_Language; Drupal.
 */
//if (!function_exists('t')) {
  function t($s) {
    $s = str_replace(array('<s>', '</s>'), array('<span>', '</span>'), $s);
    return /*Debug: '^'.*/$s;
  }
//}
if (!function_exists('_')) {
  function _($s) { return $s; }
}


