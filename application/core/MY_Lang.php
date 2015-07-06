<?php defined('BASEPATH') or exit('No direct script access allowed');
/**
* Internationalization/ Localization library.
*   Based on GNU Gettext.
*
* @copyright Copyright 2011 The Open University.
*/
// http://code.google.com/p/php-po-parser/


class MY_Lang extends CI_Lang
{

    protected $_lang_ui;
    protected $_meta;
    protected $_list;
    protected $_locales;


    public function __construct()
    {
        parent::__construct();
        log_message('debug', __CLASS__." Class Initialized");
    }

  /**Determine the preferred language, and load the required lang. pack if available.
  * TODO: add 'Accept-Language' based negotiation - cf. CloudEngine.
  * TODO: sanitize 'lang', tidy up paths, error handling.
  */
    public function initialize()
    {
        $CI =& get_instance();
        //$CI->load->library('POParser');
      #$lang = $CI->input->get('lang');
      #$lang = preg_match('/^[a-z]{2,3}([-_][a-zA-Z]{2,4})?$/', $lang) ? $lang : 'en';
      #$lang = str_replace('_', '-', $lang);

   # Load locales from config/embed_config.php file.
        $this->_locales = $CI->config->item('locales');
        $_lang = 'en'; #$this->_lang_ui;
        $method= 'non';

   # 1. Content negotiation, using 'Accept-Language' header.
        $CI->load->library('user_agent');

   # Order is significant :(


   # Use MY overridden accept_lang() method.
        $ac_lang = $CI->agent->accept_lang(array_keys($this->_locales));
        if ($ac_lang) {
         # If it's an alias, follow it.
            $_lang = is_string($this->_locales[$ac_lang]) ? $this->_locales[$ac_lang] : $ac_lang;
            $method = 'ACC';
        }
   /*ORIG: foreach ($this->_locales as $lang => $item) {
    if ($CI->agent->accept_lang(strtolower($lang))) {
     # If it's an alias, follow it.
     $_lang = is_string($item) ? $item : $lang;
     $method= 'ACC';
     break;
    }
   }*/

   # 2. If there's a COOKIE, use that.
   #$lc = $this->CI->input->cookie('language', FALSE);
   #...

   # 3. If it's POST[lang], set a cookie (or session?)
   #$lp = $this->CI->input->post('lang', FALSE);
   #...

   # 4. Finally, if there's a GET[lang], then override (unless a cookie was just set?)
        $lg = strtolower(str_replace('_', '-', $CI->input->get('lang', false)));
        if ($lg && isset($this->_locales[$lg])) {
            if (is_string($this->_locales[$lg])) {
                $lg = $this->_locales[$lg];
            }
            if ('CKP'==$method) {
                $method = 'CKI';
            } else {
                $_lang = $lg;
                $method = 'GET';
            }
        }

        $CI->_log(
            'debug',
            "My_Lang: $_lang | how=$method | ".$_SERVER['REQUEST_URI']
            ." | ".$CI->agent->agent_string()." | "
            ." | ".$_SERVER['REMOTE_ADDR']
        ); #$this->accept_lang()

        $this->_lang_ui = $_lang;
        $this->_load_gettext($_lang);
    }

    /** Load the gettext/ PO language pack (was: protected).
  * @param string $lang An ISO 639-1 language code.
  */
    public function _load_gettext($lang)
    {
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

    protected function _post_parse($lines)
    {
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
    public function gettext($msgid)
    {
        if (!$this->_list || empty($this->_list[$msgid]['msgstr'])) {
            return $msgid;
        }
        return $this->_list[$msgid]['msgstr'];
    }

    /** Get the current dictionary of language strings.
  * @return array An array, keyed by $msgid.
  */
    public function get_list()
    {
        return $this->_list;
    }

    /** Get meta-data for the current dictionary.
  * @return array
  */
    public function get_meta()
    {
        return $this->_meta;
    }

    /**
   * Get the ISO language code.
   * @return string A language string, eg. "el-GR"
   */
    public function lang_code()
    {
        return $this->_lang_ui;
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
function t($msgid, $args = null)
{
    $CI =& get_instance();
    $s = $CI->lang->gettext($msgid);
    $s = str_replace(array('<s>', '</s>'), array('<span>', '</span>'), $s);
    if (is_array($args)) {
        $s = vsprintf($s, $args);
    } // Important: accept empty string!
    elseif ($args || ''==$args) {
#is_string() #func_num_args() > 1){
        $s = sprintf($s, $args); #array_shift(func_get_args()));
    }
    return /*Debug: '^'.*/$s;
}
//}
if (!function_exists('_')) {
    function _($s)
    {
        return $s;
    }
}
