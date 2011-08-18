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
  
}
