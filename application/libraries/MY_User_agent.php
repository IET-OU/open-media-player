<?php
/** Extends the user agent class, to return browser short codes - for CSS hacks etc.
 *
 * @copyright Copyright 2011 The Open University.
 */

class MY_User_agent extends CI_User_agent {

  /** Return a short code, for the browser family/ rendering engine.
  */
  public function browser_code() {
    $ua  = $this->agent_string();
    $res = 'x'; # Unknown/ other.
    $codes = array(
      'MSIE 9.0' => 'ie9',
      'MSIE 8.0' => 'ie8',
      'MSIE 7.0' => 'ie7',
      'MSIE 6.0' => 'ie6',
      'MSIE '  => 'ie', #-ms?
      'Gecko/' => 'moz',
      'AppleWebKit/'=>'webkit', # Safari, Chrome.
      'Opera/' => 'o', # Presto
    );
    foreach ($codes as $str => $code) {
      if (false!==strpos($ua, $str)) {
        $res = $code;
        break;
      }
    }

    return $res;
  }

  /**
   * Return the first acceptable language for the user (browser), from an input list of supported languages.
   *
   * @access	public
   * @param		mixed Either a single language code, or an array of languages supported by the application.
   * @return	mixed (Was:bool)
   */
  public function accept_lang($lang = NULL) {
    $lang_res = NULL;

    if (is_string($lang)) return parent::accept_lang($lang);

    // Else, an array of locales supported by the application.
    $supported_locales = $lang;

	$user_accept_languages = $this->languages();

	// Important: find the first acceptable language for the user (browser) - order matters!
    foreach ($user_accept_languages as $try_lang) {
      if (in_array($try_lang, $supported_locales)) {
        $lang_res = $try_lang;
		break;
      }
    }

    return $lang_res;
    //return (in_array(strtolower($lang), $this->languages(), TRUE));
  }
  
}
