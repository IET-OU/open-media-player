<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Admin pages controller.
 *
 * @copyright Copyright 2015 The Open University.
 */

class Admin extends \IET_OU\Open_Media_Player\MY_Controller
{

    public function __construct()
    {
        parent::__construct();

        $this->page_title = t('Admin');

        header('Content-Type: text/html; charset=utf-8');

        $this->_authenticate();
    }

    /**
     * Index Page for this controller.
     */
    public function index()
    {
        redirect('/admin/info');
    }


    /** SAMS protected (staff-only) call to phpinfo() - help with debugging.
    * @todo - Improve content + styling, cf. http://cloudworks.ac.uk/admin/phpinfo
    */
    public function info($layout = null)
    {
        $this->_load_layout($layout);

        $my_env = array(
            'OUENV' => getenv('OUENV'),
            'ENVIRONMENT' => ENVIRONMENT,
            'Server' => $this->_server_name(),
            'CodeIgniter version' => CI_VERSION,  #.' <small>(Not always up-to-date!)</small>',
            'Token' => $this->config->item('token'),
            #'Request' => $this->_request,
        );

      /*$vars = 'token data_dir log_path log_threshold debug podcast_feed_url_pattern http_proxy';
	  foreach (explode(' ', $vars) as $key) {
	    $my_env[ $key ] = $this->config->item($key);
	  }*/

        $git = new \IET_OU\Open_Media_Player\Gitlib();

        $my_env['<h3> version.json '] = '</h3>'; # Hack!
        $my_env += (array) $git->get_revision();

        $my_env['<h3> Configuration '] = '</h3>';
        $my_env += $this->config->config;

        $view_data = array(
            'is_ouembed' => $this->_is_ouembed(),
            'is_live' => $this->_is_live(),
            'use_oembed' => false,
            'req' => $this->_request,
            'app_config' => $my_env,
        );

        $this->layout->view('admin/appinfo', $view_data);
    }

    public function phpinfo($layout = null, $what = INFO_ALL)
    {
        $this->_load_layout($layout);

        $view_data = array('phpinfo_what' => $what);

        $this->layout->view('admin/phpinfo', $view_data);
    }

    public function plugins($layout = null)
    {
        $this->_load_layout($layout);

        $view_data = array(
            'themes' => $this->plugins->get_player_themes(),
            'providers' => $this->plugins->get_oembed_providers(),
        );
        $this->layout->view('admin/plugins', $view_data);
    }


    /** Configurable authentication check and optionally redirect.
    */
    //protected function Demo::_sams_check()
    protected function _authenticate()
    {
        if ($this->config->item('auth_localhost_bypass') && 'localhost' == $_SERVER['HTTP_HOST']) {
            $this->_debug('auth_localhost_bypass');
            return;
        }

        // For example, '\\IET_OU\\Open_Media_Player\\Sams_Auth'
        $auth_class = $this->config->item('auth_class');
        $auth_extra_call = $this->config->item('auth_extra_call');

        $this->_debug($auth_class);
        $this->_debug($auth_extra_call);

        if (! $auth_class) {
            $this->_debug("Warning. No {auth_class} defined in 'config/oup_site' (403 forbidden)");
            $this->_error('Page not found', '404.10');
        }

        $used_slim = $this->_slim_basic_authentication($auth_class);

        if (! $used_slim) {
            $this->auth = $this->load->library($auth_class);
            if (! $this->auth->authenticate()) {
                $this->_error("Sorry, you don't have permission to access this page (Forbidden)", 403.1);
            }

            // For example, in Sams_Auth, call `is_staff()`
            if (is_string($auth_extra_call) && ! $this->auth->{ $auth_extra_call }()) {
                $this->_error("Sorry, you don't have permission to access this page (Forbidden)", 403.2);
            }
        }
    }

    protected function _slim_basic_authentication($auth_class)
    {
        if ('\\Slim\\Middleware\\HttpBasicAuthentication' != $auth_class) {
            return false;
        }

        $app = new \Slim\Slim();
        $opts = $this->config->item('auth_basicauth_opts');

        $opts[ 'path' ] = $opts[ 'callback' ] = null;
        $opts[ 'realm' ] = 'Media Player admin pages';
        $opts[ 'error' ] = function ($arguments) use ($app) {
            header('HTTP/1.1 401 Unauthorized');
            header(sprintf('WWW-Authenticate: Basic realm="%s"', 'Media Player admin pages'));
            echo "<title>Authentication required</title><style>body{font:1.1em sans-serif;margin:2em;color:#333}</style>WARNING.\n";
            echo isset($arguments[ 'message' ]) ? $arguments[ 'message' ] : my_print_r($arguments);
            exit;
        };

        $this->auth = new $auth_class ($opts);
        $opts[ 'users' ]  = '{ *** }';
        $this->_debug($opts);

        $app->add($this->auth);
        $this->auth->call();

        return true;
    }
}

/* End of file admin.php */
/* Location: ./application/controllers/admin.php */
