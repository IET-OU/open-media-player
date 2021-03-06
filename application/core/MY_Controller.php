<?php namespace IET_OU\Open_Media_Player;

defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Part of Open Media Player.
 *
 * @license   http://gnu.org/licenses/gpl.html GPL-3.0+
 * @copyright Copyright 2011-2015 The Open University (IET) and contributors.
 * @link      http://iet-ou.github.io/open-media-player
 */

 /*
      This file is part of Open Media Player.

      Open Media Player is free software: you can redistribute it and/or modify
      it under the terms of the GNU General Public License as published by
      the Free Software Foundation, either version 3 of the License, or
      (at your option) any later version.

      Open Media Player is distributed in the hope that it will be useful,
      but WITHOUT ANY WARRANTY; without even the implied warranty of
      MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
      GNU General Public License for more details.

      You should have received a copy of the GNU General Public License
      along with Open Media Player.  If not, see <http://www.gnu.org/licenses/>.
*/

/**
 * All controllers should extend this class.
 *
 * @copyright Copyright 2011-2015 The Open University (IET-OU).
 * @author N.D.Freear, 23 May 2011.
 */

class MY_Controller extends \CI_Controller
{

    public $firephp;
    protected $_request;
    protected $_theme;
    protected $layout_name;
    protected $page_title;
    protected $plugins;

    protected static $API_PATHS = array('oembed', 'timedtext', 'uptime', 'scripts');


    public function __construct()
    {
        parent::__construct();

        $this->plugins = new \IET_OU\Open_Media_Player\Plugin_Finder();

        if (! $this->page_title) {
            $this->page_title = site_name();
        }

        if ($this->use_composer()) {
            //require_once __DIR__ .'/../../vendor/autoload.php';
        }

        $this->_request = (object) array(
            'debug' =>(bool) $this->input->get(OUP_PARAM_DEBUG),
        );

        ///$this->_firephp_init();
        $this->_datadir_init();

        if (! $this->input->is_cli_request()) {
            $this->lang->initialize();
        }

        @header('Content-Type: text/html; charset=UTF-8');
        $this->_debug(array('ouenv'=>getenv('OUENV'), 'server'=>$this->_server_name(), 'token'=>$this->config->item('token')));

        if ($this->config->item('http_adv')) {
            // Enable Cross-Origin Resource Sharing (CORS), http://enable-cors.org | http://w3.org/TR/cors
            @header('Access-Control-Allow-Origin: *');

            if (ini_get('expose_php')) {
                // 'ofa' - OU flavoured Apache..?
                @header('X-Powered-By: iet-ou');
            }
        }

        // Test configured regex!!
        $test_media_url_regex = $this->config->item('https_media_url_regex');
        $guard = \RegexGuard\Factory::getGuard();
        if (! $guard->isRegexValid($test_media_url_regex)) {
            exit("Error. The regexp 'https_media_url_regex' defined in 'config/embed_config.php' is invalid.");
        }

        log_message('debug', __CLASS__." Class Initialized");
    }


    public function use_composer()
    {
        return true;
    }


    public function _page_title()
    {
        return $this->page_title;
    }

    /**
  * Determine if we are a Player-only install (IT-hosted), or an OU-embed install.
  * @link http://intranet4.open.ac.uk/wikis/sysdevdoc/Environment_variables
  * @return bool
  */
    public function _is_ouembed()
    {
        switch (strtolower(getenv('OUENV'))) {
            case 'live':
            case 'acct':    # IT-hosting - fall through.
            case 'test':
            case 'dev':
                return false;
            case 'ouembed': # Fall through.
            case 'iet':
            default:
                return true;
        }
    }

    /**
  * Determine if we are a live server - values should match those in `../../index.php`
  *
  * @link http://intranet4.open.ac.uk/wikis/sysdevdoc/Environment_variables
  * @return bool
  */
    public function _is_live()
    {
        switch (strtolower(getenv('OUENV'))) {
            case 'live':
            case 'acct':    # Fall through.
            case 'iet-live':
            case 'generic':
                return true;
            case 'test':
            case 'dev':
            case 'iet-dev':
            default:
                return false;
        }
    }

    /** Get array of oEmbed providers/ services.
    */
    protected function _get_oembed_providers()
    {
        $this->config->load('providers');
        //$providers_all = $this->config->item('providers');
        $providers_all = $this->plugins->get_oembed_providers();
        if ($this->_is_ouembed()) {
            return $providers_all;
        }
      // Open Media Player-only..
        $providers[OUP_PLAYER_HOST] = $providers_all[OUP_PLAYER_HOST];
        return $providers;
    }

    /** Load the layout library with a 'bare' or OUICE template.
    */
    protected function _load_layout($layout = null)
    {
        $layout = $this->config->item('site_layout');
        //$layout = $layout && preg_match('/^(bare|ouice)/', $layout) ? $layout : $cfg;
        $this->load->library('Layout', array('layout'=>"site_layout/layout_$layout"));

        $this->layout_name = $layout;
    }

    /** Check a JSON-P callback parameter for security etc.
    * @link http://json-p.org#!comment_Kyle-Simpson-getify.me_2010-10-26
    */
    protected function _jsonp_callback_check($name = 'callback')
    {
        // Security. Only allow eg. 'Object.func_CB_1234'
        $callback = $this->input->get('callback', $xss_clean = true);
        if ($callback && !preg_match('/^[a-zA-Z][\w_\.]*$/', $callback)) {
            $this->_error("the parameter {callback} must start with a letter, and contain only letters, numbers, underscore and '.' **", "400.6");
        }
        if ($callback && preg_match('/(Object|Function|Math|window|document|eval$)/', $callback)) {
            $this->_error("the parameter {callback} can't contain reserved names like 'window' or 'eval'.", "400.7");
        }
        return $callback;
    }

    public function _request_init()
    {
        // Support extended MY_Input::get.
        $this->_request->theme = $this->input->get(OUP_PARAM_THEME);
        $this->_request->rgb = $this->input->get('rgb');
        $this->_request->hide_controls = (bool)$this->input->get('_hide_controls');
        $this->_request->site_access = $this->input->get('site_access');
        $this->_request->lang = $this->input->get(OUP_PARAM_LANG);
    }

    /** Initialize the player, including the theme (Embed and Popup controllers).
    */
    protected function _player_init()
    {
        $this->load->library('user_agent');

        $this->_request_init();

        $themes = $this->config->item('player_themes');
        if ($this->_request->theme && isset($themes[$this->_request->theme])) {
            $this->_theme = (object) $themes[$this->_request->theme];
            $this->_theme->name = $this->_request->theme;
        } elseif ($this->_request->theme && !isset($themes[$this->_request->theme])) {
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
    protected function _get_analytics_id($domain)
    {
        $this->config->load('providers');
        $providers = $this->config->item('providers');
        return $providers[$domain]['_google_analytics'];
    }

    /** Get optional parameters for iframe URL (http_build_query)
    */
    public function _options_build_query($defaults = array(), $arg_separator = null)
    {
        if (! isset($this->_request->theme)) {
            //return null;
        }

        $params = array();
        $keys = explode('|', 'theme|rgb|debug|lang|hide_controls|site_access');
        foreach ($keys as $key) {
            if (isset($this->_request->{ $key }) && $this->_request->{ $key }) {
                $params[ $key ] = $this->_request->{ $key };
            }
        }

        $query_data = array_merge($defaults, $params);

        if (! count($query_data)) {
            return '';
        }
        return '?' . http_build_query($query_data); //, '', $arg_separator);
    }

    /** Are debug config and HTTP params set?
  * @link https://github.com/IET-OU/trackoer-core/blob/master/application/core/MY_Controller.php#L152
  * @return mixed (Default: boolean)
  */
    public function _is_debug($threshold = 1, $score = false)
    {
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
    public function _debug($exp)
    {
        static $where, $count = 0;
        if ($this->_is_debug()) {
          # $where could be based on __FUNCTION__ or debug_stacktrace().
            if (!$where) {
                $where = str_replace(array('.php', '_', '.'), '-', basename(__FILE__));
            }
            $value = json_encode($exp);
            $value = is_string($exp) ? str_replace('\/', '/', $value) : $value;
            @header("X-D-$where-".sprintf('%02d', $count).': '. $value);

            foreach (func_get_args() as $c => $arg) {
                if ($c > 0) {
                    $this->_debug($arg);  # Recurse.
                }
            }
            $count++;
        }
    }


    /** Handle fatal errors.
    */
    public function _error($message, $code = 500, $from = null, $obj = null)
    {
    #Was: protected.
      #$this->firephp->fb("$code: $message", $from, 'ERROR');
        $this->_log('error', "$from: $code, $message");
        @header('HTTP/1.1 '. (integer) $code);

        if (! $this->_is_api_call()) {
             $ex =& load_class('Exceptions', 'core');
             echo $ex->show_error(t('%s error', site_name()), $message, 'error_general', $code);
             exit;
        } else {
            @header('Content-Type: text/plain; charset=utf-8');
        // For now, just output plain text.
            echo "$code. Error, $message".PHP_EOL;
            if ($obj) {
                // ??
                my_print_r($obj);
            }
            exit;
        }
    }

    public function _log($level = 'error', $message = 'unknown', $php_error = false)
    {
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
        //$this->firephp->fb($msg, $fp_label, $fp_level);
    }

    /** Determine whether we're in an API controller/ context.
    * @return bool
    */
    protected function _is_api_call()
    {
        return in_array($this->uri->segment(1), self::$API_PATHS);
    }

    /** Handle required GET parameters. */
    protected function _required($param)
    {
        $value = $this->input->get($param);
        if (!$value) {
            $this->_error("'$param' is a required URL parameter.", 400);
        }
        return $value;
    }

    /** Make relative URLs absolute. */
    protected function _absolute($url, $base_url)
    {
        if ($url && !parse_url($url, PHP_URL_SCHEME)) {
            return $base_url.'/'.$url;
        }
        return $url;
    }

    /** Get the load-balanced server name.
    * @return string
    */
    protected function _server_name()
    {
        ob_start();
        phpinfo(INFO_GENERAL);
        $info = ob_get_clean();

        $server = null;
        if (preg_match('/System.+?<td[^>]*>(Windows.+?<|.+\.uk)/', $info, $matches)) {
            $server = trim(str_replace(array('Windows', 'Service Pack ', ' Edition', 'Linux'), array('Win', 'SP', ''), $matches[1]), ' <');
        }
        return $server;
    }

    /**
    * Create data/ logs sub-directories - reduce configuration.
    */
    protected function _datadir_init()
    {
        $data_dir = $this->config->item('data_dir');
      #$this->_debug($data_dir);
      #@header('X-ouplayer-accessible-alt: 0');
        if (! file_exists($data_dir)) {
            $this->_debug("Error, data directory doesn't exist. Check 'embed_config..' configuration file.");
            return false;
        }
        if (! file_exists($data_dir .'logs/')) {
            $b_log = @mkdir($data_dir .'logs/', 0775);
            if (file_exists($data_dir .'logs/')) {
                $this->_debug("OK, created 'logs' directory, $b_log");
            } else {
                $this->_debug("Error creating 'logs' directory. Is the sub-directory writeable?");
                return false;
            }
        }
        if (! file_exists($data_dir .'oupodcast/')) {
            $b_pod = @mkdir($data_dir .'oupodcast/', 0775);
            if (file_exists($data_dir .'oupodcast/')) {
                $this->_debug("OK, created 'oupodcast' directory, $b_pod");
            } else {
                $this->_debug("Error creating 'oupodcast' directory. Is the sub-directory writeable?");
                return false;
            }
        }
        $this->_debug('Data-dirs OK');
    }


    /**
    * Fire PHP
    */
    protected function _firephp_init()
    {
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
