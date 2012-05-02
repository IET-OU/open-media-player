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
	public function index()
	{
		$view_data = array(
			'req' => $this->_request,
		);
		$this->load->view('demo/oupodcast-demo', $view_data);
	}


    /** OU Podcast samples - 1 video or 1 audio, in 'context'.
    */
    public function podcast($page = 'video', $layout = 'bare') {

        $view = 'video'==$page ? 'video' : 'audio';
        $layout = 'bare'==$page ? 'bare' : 'ouice';

        $this->load->library('Layout', array('layout'=>"site_layout/layout_$layout"));

        $view_data = array(
            'req' => $this->_request,
            'resource_url' => 'http://www8.open.ac.uk/',
        );
        $this->layout->view("demo/podcast-one-$view", $view_data);
    }


    /** Error handling tests.
    */
    public function podcast_errors() {
      $this->load->library('Layout', array('layout'=>"site_layout/layout_bare"));

      $this->layout->view('test/player-error-test');
    }


    /** OUVLE demonstrations - 1 video or 1 audio, in 'context'.
    */
	public function vle($page = 'video') {
	    $this->_sams_check();

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
        if ($rgb) {
          $player_param .= "&amp;rgb=$rgb";
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


	    //$this->load->view('vle_demo', $view_data);
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

    /** Basic OU-SAMS cookie check and redirect.
    */
	protected function _sams_check() {
	  // Security: note the 'localhost' check.
	  if ('localhost' != $this->input->server('HTTP_HOST') &&
	      !$this->input->cookie('SAMSsession')) {
	    redirect('https://msds.open.ac.uk/signon/?URL='.current_url());
	  }
	}
}

/* End of file demo.php */
/* Location: ./application/controllers/demo.php */