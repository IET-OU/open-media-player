<?php defined('BASEPATH') or exit('No direct script access allowed');

//if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Demonstrations/tests controller.
 *
 * @copyright Copyright 2011 The Open University.
 */

class Admin extends \IET_OU\Open_Media_Player\MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        header('Content-Type: text/html; charset=utf-8');
    }

    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     *         http://example.com/index.php/welcome
     *    - or -
     *         http://example.com/index.php/welcome/index
     *    - or -
     * Since this controller is set as the default controller in
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/welcome/<method_name>
     * @see http://codeigniter.com/user_guide/general/urls.html
     */
    public function index($layout = self::LAYOUT, $use_oembed = false)
    {
        $this->_authenticate();

        $this->_load_layout($layout);

        redirect('/admin/info');
    }


    /** SAMS protected (staff-only) call to phpinfo() - help with debugging.
    * @todo - Improve content + styling, cf. http://cloudworks.ac.uk/admin/phpinfo
    */
    public function info($layout = self::LAYOUT)
    {
        $this->_authenticate();
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

        $this->load->library('Gitlib', null, 'git');
        $my_env['<h3> version.json '] = '</h3>'; # Hack!
        $my_env += (array) $this->git->get_revision();

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

    public function phpinfo($layout = self::LAYOUT, $what = INFO_ALL)
    {
        $this->_authenticate();
        $this->_load_layout($layout);

        $view_data = array('phpinfo_what' => $what);

        $this->layout->view('about/phpinfo', $view_data);
    }

    public function plugins($layout = self::LAYOUT)
    {
        $this->_authenticate();
        $this->_load_layout($layout);

        $sub = new \IET_OU\SubClasses\SubClasses();

        $view_data = array(
            'themes' => $sub->get_player_themes(),
            'providers' => $sub->get_oembed_providers(),
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

        // Eg. '\\IET_OU\\Open_Media_Player\\Sams_Auth'
        $auth_class = $this->config->item('auth_class');
        $auth_extra_call = $this->config->item('auth_extra_call');

        $this->_debug($auth_class);
        $this->_debug($auth_extra_call);

        // TODO: can't get Slim basic-auth working :(!
        if ('\\Slim\\Middleware\\HttpBasicAuthentication' == $auth_class) {
            $app = new \Slim\Slim();
            $opts = $this->config->item('auth_basicauth_opts');

            $this->auth = new $auth_class ($opts);
            $this->_debug($opts);

            $app->add($this->auth);
            $this->auth->call();
        } else {
            $this->auth = $this->load->library($auth_class);
            $this->auth->authenticate();

            // Eg. in Sams_Auth, call `is_staff()`
            if (is_string($auth_extra_call) && ! $this->auth->{ $auth_extra_call }()) {
                $this->_error("Sorry, you don't have permission to access this page (Forbidden)", 403);
            }
        }
    }
}

/* End of file demo.php */
/* Location: ./application/controllers/demo.php */
