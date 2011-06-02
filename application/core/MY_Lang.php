<?php
/** Internationalization/ Localization library.
*   Based on GNU Gettext.
*
* @copyright Copyright 2011 The Open University.
*/
// http://code.google.com/p/php-po-parser/
require_once APPPATH.'/libraries/POParser.php';


class My_Lang extends CI_Lang {

  protected $_lang_ui;
  protected $_meta;
  protected $_list;
  protected $_locales;

  public function __construct() {
    parent::__construct();
	log_message('debug', __CLASS__." Class Initialized");
  }

  /**Determine the preferred language, and load the required lang. pack if available.
  * TODO: add 'Accept-Language' based negotiation - cf. CloudEngine.
  * TODO: sanitize 'lang', tidy up paths, error handling.
  */
  public function initialize() {
    $CI =& get_instance();
    $lang = $CI->input->get('lang');
    $lang = preg_match('/^[a-z]{2,3}([-_][a-zA-Z]{2,4})?$/', $lang) ? $lang : 'en';
    $lang = str_replace('_', '-', $lang);
    $this->_lang_ui = $lang;

    $this->_locales = $CI->config->item('locales');

    $path = APPPATH."language/$lang.po";  #$lang/application.po;

    if (file_exists($path)) {

      $parser = new POParser;
      $result = $parser->parse($path);

      $this->_meta = $result[0];
      $this->_post_parse($result[1]);

      log_message('debug', __CLASS__." parsed PO file: $lang; lines: ".count($this->_list));
    } else {
      log_message('warn', __CLASS__." can't find file, $path");
    }
  }

  protected function _post_parse($lines) {
    foreach ($lines as $line) {
      if (isset($line['msgid'])) {
        $this->_list[$line['msgid']] = $line;
      }
    }
  }

  /** Get a single translation, or the original string if not translated.
  * @param string $msgid
  * @return string
  */
  public function gettext($msgid) {
    if (!$this->_list || empty($this->_list[$msgid]['msgstr'])) {
      return $msgid;
    }
    return $this->_list[$msgid]['msgstr'];
  }
}


/* Translate text function, uses sprintf/vsprintf.
 * See: cloudengine/libs./MY_Language; Drupal.
 *
 * @param $msgid string Text to translate, with optional printf-style placeholders, eg. %s.
 * @param $args  mixed  Optional. A value or array of values to substitute.
 * @return string
 */
//if (!function_exists('t')) {
  function t($msgid, $args=null) {
    $CI =& get_instance();
    $s = $CI->lang->gettext($msgid);
    $s = str_replace(array('<s>', '</s>'), array('<span>', '</span>'), $s);
    if (is_array($args)) {
      $s = vsprintf($s, $args);
    }
    elseif ($args) { #is_string() #func_num_args() > 1){
      $s = sprintf($s, $args); #array_shift(func_get_args()));
    }
    return /*Debug: '^'.*/$s;
  }
//}
if (!function_exists('_')) {
  function _($s) { return $s; }
}


