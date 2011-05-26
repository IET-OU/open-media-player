<?php
/** Internationalization.
*
* @copyright Copyright 2011 The Open University.
*/
// http://code.google.com/p/php-po-parser/
require_once APPPATH.'/libraries/POParser.php';


class My_Lang extends CI_Lang {

  protected $_lang_ui;
  protected $_meta;
  protected $_list;

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
    $this->_lang_ui = $lang ? $lang : 'en';

    $path = APPPATH."language/$lang/application.po";

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


/* 'translate text' placeholder - Internationalization/ Localization.
 * See: cloudengine/libs./MY_Language; Drupal.
 */
//if (!function_exists('t')) {
  function t($s) {
    $CI =& get_instance();
    $s = $CI->lang->gettext($s);
    $s = str_replace(array('<s>', '</s>'), array('<span>', '</span>'), $s);
    return /*Debug: '^'.*/$s;
  }
//}
if (!function_exists('_')) {
  function _($s) { return $s; }
}


