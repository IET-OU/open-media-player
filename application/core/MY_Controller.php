<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * OU Media Player.
 *
 * (Most) all controllers should extend this class.
 *
 * @copyright Copyright 2011 The Open University.
 * @author N.D.Freear, 23 May 2011.
 */


class MY_Controller extends CI_Controller {

  public $firephp;
  protected $_request;
  protected $_theme;

  // Default layout/template (was: 'bare')
  const LAYOUT = 'ouice';

  static $API_PATHS = array('oembed', 'timedtext', 'uptime', 'scripts');


  public function __construct() {
    parent::__construct();

    $this->_request = (object) array(
      'debug' =>(bool)$this->input->get(OUP_PARAM_DEBUG),
    );

    $this->_firephp_init();
	$this->_datadir_init();

    if (! $this->input->is_cli_request()) {
      $this->lang->initialize();
    }

    @header('Content-Type: text/html; charset=UTF-8');
    #$this->_debug('ouenv='. getenv('OUENV'));
    $this->_debug(array('ouenv' => getenv('OUENV'), 'token' => $this->config->item('token')));

    if ($this->config->item('http_adv')) {
       // Enable Cross-Origin Resource Sharing (CORS), http://enable-cors.org | http://w3.org/TR/cors
       @header('Access-Control-Allow-Origin: *');

      if (ini_get('expose_php')) {
        // 'ofa' - OU flavoured Apache..?
        @header('X-Powered-By: iet-ou');
      }
    }

    log_message('debug', __CLASS__." Class Initialized");
  }


  /**
  * Determine if we are a Player-only install (IT-hosted), or an OU-embed install.
  * @link http://intranet4.open.ac.uk/wikis/sysdevdoc/Environment_variables
  * @return bool
  */
  public function _is_ouembed() {
    switch (strtolower(getenv('OUENV'))) {
      case 'live':
      case 'acct':    # IT-hosting - fall through.
      case 'test':
      case 'dev':
        return FALSE;
      case 'ouembed': # Fall through.
      case 'iet': 
      default:
        return TRUE;
    }
  }

  /**
  * Determine if we are a live server.
  * @link http://intranet4.open.ac.uk/wikis/sysdevdoc/Environment_variables
  * @return bool
  */
  public function _is_live() {
    switch (strtolower(getenv('OUENV'))) {
      case 'live':
      case 'acct':    # Fall through.
      case 'ietlive':
        return TRUE;
      case 'test':
      case 'dev':
      case 'ietdev':
      default:
        return FALSE;
    }
  }

  /** Get array of oEmbed providers/ services.
  */
  protected function _get_oembed_providers() {
    $this->config->load('providers');
    $providers_all = $this->config->item('providers');
    if ($this->_is_ouembed()) {
      return $providers_all;
    }
    // OU Player-only..
    $providers[OUP_PLAYER_HOST] = $providers_all[OUP_PLAYER_HOST];
    return $providers;
  }

  /** Load the layout library with a 'bare' or OUICE template.
  */
  protected function _load_layout($layout = self::LAYOUT) {
    $layout = 'bare'==$layout ? 'bare' : 'ouice_2';
    $this->load->library('Layout', array('layout'=>"site_layout/layout_$layout"));
  }

  /** Check a JSON-P callback parameter for security etc.
  * @link http://json-p.org#!comment_Kyle-Simpson-getify.me_2010-10-26
  */
  protected function _jsonp_callback_check($name = 'callback') {
    // Security. Only allow eg. 'Object.func_CB_1234'
    $callback = $this->input->get('callback', $xss_clean=TRUE);
    if ($callback && !preg_match('/^[a-zA-Z][\w_\.]*$/', $callback)) {
      $this->_error("the parameter {callback} must start with a letter, and contain only letters, numbers, underscore and '.' **", "400.6");
    }
    if ($callback && preg_match('/(Object|Function|Math|window|document|eval$)/', $callback)) {
      $this->_error("the parameter {callback} can't contain reserved names like 'window' or 'eval'.", "400.7");
    }
    return $callback;
  }


  /** Initialize the player, including the theme (Embed and Popup controllers).
  */
  protected function _player_init() {
	$this->load->library('user_agent');

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
	if ($this->agent->is_browser('Internet Explorer') && $this->agent->version() < 7) {
		header('X-OUP-Requested-Theme: '.$this->_theme->name);
		$this->_theme = (object) $themes['basic'];
		$this->_theme->name = 'basic';
	}

	// Mobiles, tablets, Android, iOS etc. - use MediaElement default..? (iet-it-bugs:1414)
	$mobile_theme = $this->config->item('player_mobile_theme');
	if ($mobile_theme && $this->agent->is_mobile()) {
		@header('X-OUP-Requested-Theme: '.$this->_theme->name);
		$this->_theme = (object) $themes[$mobile_theme];
		$this->_theme->name = $mobile_theme;
	}
  }

  /** Return the analytics ID for a domain, eg. podcast.open.ac.uk
  * @deprecated v0.9-beta-19-gb2ed30a / 2012-09-25 - Use $this->provider->getAnalyticsId()
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

  /** Are debug config and HTTP params set?
  * @link https://github.com/IET-OU/trackoer-core/blob/master/application/core/MY_Controller.php#L152
  * @return mixed (Default: boolean)
  */
  public function _is_debug($threshold = 1, $score = FALSE) {
    $is_debug = 0;
    $is_debug += (int) $this->input->get(OUP_PARAM_DEBUG);
    $is_debug += (int) $this->config->item('debug');
    if ($score) {
      return $is_debug;
    }
    return $is_debug > $threshold;
  }

  /** Optionally output strings/objects in a debug HTTP header.
  * @link https://gist.github.com/1712707
  */
  public function _debug($exp) {
    static $where, $count = 0;
    if ($this->_is_debug()) {
      # $where could be based on __FUNCTION__ or debug_stacktrace().
      if(!$where) $where = str_replace(array('.php', '_', '.'), '-', basename(__FILE__));
      $value = json_encode($exp);
      $value = is_string($exp) ? str_replace('\/', '/', $value) : $value;
      @header("X-D-$where-".sprintf('%02d', $count).': '. $value);

      foreach (func_get_args() as $c => $arg) {
        if($c > 0) $this->_debug($arg);  # Recurse.
      }
      $count++;
    }
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


  /**
  * Create data/ logs sub-directories - reduce configuration.
  */
  protected function _datadir_init() {
    $data_dir = $this->config->item('data_dir');
    #$this->_debug($data_dir);
    #@header('X-ouplayer-accessible-alt: 0');
    if (! file_exists($data_dir)) {
      $this->_debug("Error, data directory doesn't exist. Check 'embed_config..' configuration file.");
      return FALSE;
    }
    if (! file_exists($data_dir .'logs/')) {
      $b_log = @mkdir($data_dir .'logs/', 0775);
      if (file_exists($data_dir .'logs/')) {
        $this->_debug("OK, created 'logs' directory, $b_log");
      } else {
        $this->_debug("Error creating 'logs' directory. Is the sub-directory writeable?");
        return FALSE;
      }
    }
    if (! file_exists($data_dir .'oupodcast/')) {
      $b_pod = @mkdir($data_dir .'oupodcast/', 0775);
      if (file_exists($data_dir .'oupodcast/')) {
        $this->_debug("OK, created 'oupodcast' directory, $b_pod");
      } else {
        $this->_debug("Error creating 'oupodcast' directory. Is the sub-directory writeable?");
        return FALSE;
      }
    }
    $this->_debug('Data-dirs OK');
    #@header('X-ouplayer-accessible-alt: 1');
  }


  /**
  * Fire PHP
  */
  protected function _firephp_init() {
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
  }
}
