<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Demonstrations/tests controller.
 *
 * @copyright Copyright 2011 The Open University.
 */

class Demo extends CI_Controller {

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
		$this->load->view('welcome_message');
	}

    /** OUVLE demonstrations.
    */
	public function vle() {
	  $this->_sams_check();

	  $this->load->view('vle_demo');
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