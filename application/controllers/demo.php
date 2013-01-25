<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Demonstrations/tests controller.
 *
 * @copyright Copyright 2011 The Open University.
 */

class Demo extends MY_Controller {


    public function __construct() {
      parent::__construct();
      header('Content-Type: text/html; charset=utf-8');
    }

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	public function index($layout = self::LAYOUT, $use_oembed = FALSE) {
		/*if ($this->_is_ouembed() && $this->uri->segment(1) == 'demo') {
			redirect('demo/ouldi');
		}*/

		$this->_load_layout($layout);

		$view_data = array(
			'is_ouembed' => $this->_is_ouembed(),
			'is_live' => $this->_is_live(),
			'use_oembed' => $use_oembed || $this->config->item('home_use_oembed') || $this->input->get('oembed'),
			'req' => $this->_request,
		);
		$this->layout->view('demo/oupodcast-demo', $view_data);
	}


    /** OU Embed demo form [iet-it-bugs:1454].
	* @link http://track.olnet.org/oerform
	* @link http://noembed.com/demo
    */
    public function ouldi($layout = self::LAYOUT) {
      if (! $this->_is_ouembed()) {
        $this->_error('The page you requested was not found.', 404);
      }
      $this->_load_layout($layout);

      $view_data = array(
            'is_ouembed' => true,
            'is_live' => $this->_is_live(),
            'use_oembed' => true,
            'page_title' => t('OU/ OULDI Embeds'),
            'req' => $this->_request,
            'examples' => $this->_get_oembed_examples(),
            'url' => $this->input->get('url'),
        );
        $this->layout->view('demo/ouembed-form', $view_data);
    }

    protected function _get_oembed_examples() {
      $examples = $names = array();
      $providers = $this->_get_oembed_providers();

      foreach ($providers as $domain => $name) {
        // Prevent duplicated loads/ examples.
        if (isset($names[$name])) continue;

        $names[$name] = 1;

        $this->load->oembed_provider($name);

        $example = $this->provider->getExamples();
        if ($example) {
          $examples += $example;
        }
      }
      return $examples;
    }


	/** OULDI (and OLnet) tests (Was: 'ouldi')
	*/
	public function ouldi_gallery($layout = self::LAYOUT) {
        if (! $this->_is_ouembed()) {
            $this->_error('The page you requested was not found.', 404);
        }
        $this->_load_layout($layout);

        $view_data = array(
            'is_ouembed' => true,
            'is_live' => $this->_is_live(),
            'use_oembed' => true,
            'page_title' => t('OU/ OULDI Embeds'),
            'req' => $this->_request,
        );
        $this->layout->view('demo/ouldi-demo', $view_data);
	}

    /** OU Podcast samples - 1 video or 1 audio, in 'context'.
    */
    public function podcast($page = 'video', $layout = self::LAYOUT) {
        $this->_load_layout($layout);

        $view = 'video'==$page ? 'video' : 'audio';

        $view_data = array(
            'is_ouembed' => $this->_is_ouembed(),
            'is_live' => $this->_is_live(),
            'use_oembed' => true,
            'req' => $this->_request,
            #'resource_url' => OUP_OU_RESOURCE_URL,
        );
        $this->layout->view("demo/podcast-one-$view", $view_data);
    }


    /** OU player size tests.
    */
    public function player_sizes($layout = self::LAYOUT) {
      $this->_load_layout($layout);
      
      $this->layout->view('test/player-sizes');
    }


    /** Player error handling tests.
    */
    public function podcast_errors($layout = self::LAYOUT) {
      $this->_load_layout($layout);

      $view_data = array(
        'is_ouembed' => $this->_is_ouembed(),
        'is_live' => $this->_is_live(),
        'use_oembed' => FALSE,
      );
      $this->layout->view('test/player-error-test', $view_data);
    }


    /** OUVLE demonstrations - 1 video or 1 audio, in 'context'.
    */
	public function vle($page = 'video') {
	    $this->_sams_check();

	    # Not, $this->_load_layout('ouvle').
	    $this->load->library('Layout', array('layout'=>'site_layout/layout_ouvle'));

        $view = 'video'==$page ? 'video' : 'audio';


	    $input = $this->input;
        $original = (bool) $input->get('original');
        if ($original) {
          $player_url_unenc = 'http://learn3.open.ac.uk/local/mediahack/';
          #$player_url = 'http:\/\/learn3.open.ac.uk\/local\/mediahack\/';
          $audio_height = 30;
        } else {
          $player_url_unenc = site_url('embed/vle');
          $audio_height = 36; #22;
        }
        $player_url = str_replace('"', '', json_encode($player_url_unenc));

        // Player 'foreground' colour.
        $player_param = '';
        $rgb = $input->get('rgb');

		// Bug #1377, Custom player background colour.
        $background = $input->get('background');
        if ($rgb) {
          $player_param .= "&amp;rgb=$rgb";
        }
        if ($background) {
          $player_param .= "&amp;background=$background";
        }

        // URL for stylesheets, Javascript, images etc.
        $resource_url = 'http://learn3.open.ac.uk';

        $view_data = array(
            'req' => $this->_request,
            'audio_height'=> $audio_height,
            'iframe_param'=> 'allowfullscreen webkitallowfullscreen',
            'player_param'=> $player_param,
            'player_url'  => $player_url,
            'player_url_unenc' => $player_url_unenc,
            'resource_url' => $resource_url,
            // 'newwindow.png' icon.
            'icon_url' => "$resource_url/mod/oucontent/",
            'transcript_url' => "$resource_url/mod/oucontent/",
        );
        $this->layout->view("vle_demo/learn3-one-$view", $view_data);
	}


	/** OUVLE demonstration - many players - OUVLE style/layout.
    */
	public function vle_many() {
	  $this->_sams_check();

	  $view_data = array(
	    'req' => $this->_request,
	  );
	  $this->load->view('vle_demo/learn3-mod-oucontent-many.php', $view_data);
	}

	/** OUVLE demonstration - fewer players - OUVLE style/layout.
    */
	public function vle_fewer() {
	  $this->_sams_check();

	  $view_data = array(
	    'req' => $this->_request,
	  );
	  $this->load->view('vle_demo/learn3-mod-oucontent-fewer.php', $view_data);
	}


	/** SAMS protected (staff-only) call to phpinfo() - help with debugging.
	* @todo - Improve content + styling, cf. http://cloudworks.ac.uk/admin/phpinfo
	*/
	public function info($layout = self::LAYOUT, $what = INFO_ALL) {
	  $this->_sams_check();
	  $this->_load_layout($layout);

	  $my_env = array(
	    'OUENV' => getenv('OUENV'),
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
	    'use_oembed' => FALSE,
	    'req' => $this->_request,
	    'app_config' => $my_env,
		'phpinfo_what' => $what,
	  );

	  $this->layout->view('about/phpinfo', $view_data);
	}


    /** Basic OU-SAMS authentication check and redirect.
    */
	protected function _sams_check() {
	  $this->load->library('Sams_Auth', null, 'auth');
	  $this->auth->authenticate();

	  if (! $this->auth->is_staff()) {
	    $this->_error('Sorry, staff only (Forbidden)', 403);
	  }
	}
}

/* End of file demo.php */
/* Location: ./application/controllers/demo.php */