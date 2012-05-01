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

    public function podcast($page = 'video') {

        $this->load->library('Layout', array('layout'=>'site_layout/layout_bare'));

        $view = 'video'==$page ? 'video' : 'audio';

        $view_data = array(
            'req' => $this->_request,
        );
        $this->layout->view("demo/podcast-one-$view", $view_data);
    }

    /** Error handling tests.
    */
    public function podcast_errors() {
      $this->load->view('test/player-error-test');
    }

    /** OUVLE demonstrations.
    */
	public function vle($page = 'video') {
	    $this->_sams_check();

	    $this->load->library('Layout', array('layout'=>'site_layout/layout_ouvle'));

        $view = 'video'==$page ? 'video' : 'audio';

        $view_data = array(
            'req' => $this->_request,
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