<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Most controllers should extend this one.
 *
 * @copyright Copyright 2011 The Open University.
 * @author N.D.Freear, 23 May 2011.
 */


class MY_Controller extends CI_Controller {

  public $firephp;
  protected $_request;
  protected $_theme;

  static $API_PATHS = array('oembed', 'timedtext', 'uptime', 'scripts');


  public function __construct() {
    parent::__construct();

    $this->_request = (object) array(
      'debug' =>(bool)$this->input->get(OUP_PARAM_DEBUG),
    );

    $this->load->library('FirePHPCore/Firephp');
    if ($this->config->item('debug') && $this->_request->debug) {
        #$this->load->library('FirePHPCore/FirephpEx', null, 'firephp');
    } else {
        $this->firephp->setEnabled(false);
        #$this->load->library('firephp_fake', null, 'firephp');
        #$this->firephp =& $this->firephp_fake;
    }
    $this->firephp->fb(__METHOD__, 'OUP', 'INFO');
    #$this->firephp->fb($_SERVER, 'OUP', 'INFO');
    #$this->firephp->log('test');

    if (! $this->input->is_cli_request()) {
      $this->lang->initialize();
    }

    @header('Content-Type: text/html; charset=UTF-8');
    #@header("X-Powered-By:");

    log_message('debug', __CLASS__." Class Initialized");
  }

  /** Initialize the player, including the theme (Embed and Popup controllers).
  */
  protected function _player_init() {

	// Support extended MY_Input::get.
	$this->_request->theme = $this->input->get(OUP_PARAM_THEME);
	$this->_request->hide_controls = (bool)$this->input->get('_hide_controls');
	$this->_request->site_access = $this->input->get('site_access');
	$this->_request->lang = $this->input->get(OUP_PARAM_LANG);


	$themes = $this->config->item('player_themes');
	if ($this->_request->theme && isset($themes[$this->_request->theme])) {
		$this->_theme = (object) $themes[$this->_request->theme];
		$this->_theme->name = $this->_request->theme;
	}
	elseif ($this->_request->theme && !isset($themes[$this->_request->theme])) {
		$this->firephp->fb('Unrecognised theme!', __METHOD__, 'ERROR');
	}
	if (!$this->_theme) {
		$def_theme = $this->config->item('player_default_theme');
		if ($def_theme && isset($themes[$def_theme])) {
			$this->_theme = (object) $themes[$def_theme];
			$this->_theme->name = $def_theme;
		} else {
			$this->_theme = (object) $themes['basic'];
			$this->_theme->name = 'basic';
		}
	}

	// For MSIE <= 6.5, downgrade the theme to 'basic' aka 'noscript'!
	$this->load->library('user_agent');
	if ($this->agent->is_browser('Internet Explorer') && $this->agent->version() < 7) {
		header('X-OUP-Requested-Theme: '.$this->_theme->name);
		$this->_theme = (object) $themes['basic'];
		$this->_theme->name = 'basic';
	}
  }

  /** Return the analytics ID for a domain, eg. podcast.open.ac.uk
  */
  protected function _get_analytics_id($domain) {
    $this->config->load('providers');
    $providers = $this->config->item('providers');
	return $providers[$domain]['_google_analytics'];
  }

  /** Get optional parameters for iframe URL (http_build_query)
  */
  public function options_build_query() {
    if (! isset($this->_request->theme)) return NULL;

    $params = '?';
    $keys = explode('|', 'theme|debug|lang|hide_controls|site_access');
    foreach ($keys as $key) {
      if ($this->_request->{$key}) {
	    $params .= '&'. $key .'='. $this->_request->{$key};
	  }
    }

    if ('?' == $params) return '';

	return str_replace('?&', '?', $params);
  }

  /** Handle fatal errors.
  */
  public function _error($message, $code=500, $from=null, $obj=null) { #Was: protected.
    #$this->firephp->fb("$code: $message", $from, 'ERROR');
    $this->_log('error', "$from: $code, $message");
    @header('HTTP/1.1 '. (integer) $code);

	if (! $this->_is_api_call()) {
      $ex =& load_class('Exceptions', 'core');
      echo $ex->show_error(t('OU Player error'), $message, 'error_general', $code);
      exit;
    } else {

    @header('Content-Type: text/plain; charset=utf-8');
    // For now, just output plain text.
    echo "$code. Error, $message".PHP_EOL;
    if ($obj) { // ??
      print_r($obj);
    }
      exit;
    }
  }

  public function _log($level='error', $message, $php_error=FALSE) {
    $_CI = $this;
    $_CI->load->library('user_agent');
    $ip = $_SERVER['REMOTE_ADDR'];
    $ref= $_CI->agent->referrer();    #['HTTP_REFERER']
    $ua = $_CI->agent->agent_string();#['HTTP_USER_AGENT']
    $request = $_CI->uri->uri_string().'?'.$_SERVER['QUERY_STRING'];
    $msg = "$message, $request -- $ip, $ref, $ua";
    log_message($level, $msg);  #, $php_error);


    $fp_level = 'error'==$level ? 'ERROR' : 'INFO';
    $fp_label = 'error'==$level ? 'Error log' : 'Log';
    $this->firephp->fb($msg, $fp_label, $fp_level);
  }

  /** Determine whether we're in an API controller/ context.
  * @return bool
  */
  protected function _is_api_call() {
    return in_array($this->uri->segment(1), self::$API_PATHS);
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
