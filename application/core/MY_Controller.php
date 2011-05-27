<?php
/**Most controllers should extend this one.
 *
 * @copyright Copyright 2011 The Open University.
 */

class MY_Controller extends CI_Controller {

  public function __construct() {
    parent::__construct();

	$this->lang->initialize();
  }

  /** Handle errors.
  */
  protected function _error($message, $code=500, $from) {
    $this->_log('error', "$from: $code, $message");
    @header("HTTP/1.1 $code");
    // For now, just output plain text.
    die("$code. Error, $message");
  }

  protected function _log($level='error', $message, $php_error=FALSE) {
    $_CI = $this;
	$_CI->load->library('user_agent');
    $ip = $_SERVER['REMOTE_ADDR'];
    $ref= $_CI->agent->referrer();    #['HTTP_REFERER']
    $ua = $_CI->agent->agent_string();#['HTTP_USER_AGENT']
    $request = $_CI->uri->uri_string().'?'.$_SERVER['QUERY_STRING'];
	log_message($level, "$message, $request -- $ip, $ref, $ua"); #, $php_error);
  }

  /** Handle required GET parameters. */
  protected function _required($param) {
    $value = $this->input->get($param);
    if (!$value) {
      $this->_error("'$param' is a required URL parameter.", 400);
    }
    return $value;
  }

  /** Make relative URLs absolute. */
  protected function _absolute($url, $base_url) {
    if ($url && !parse_url($url, PHP_URL_SCHEME)) {
      return $base_url.'/'.$url;
    }
    return $url;
  }

}
