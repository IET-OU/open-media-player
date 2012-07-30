<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once APPPATH. 'controllers/demo.php';

class About extends Demo { #MY_Controller {

  #const LAYOUT = 'ouice_2';


  public function index() {
    $this->_load_layout(self::LAYOUT);

    $this->load->library('Gitlib');

	$rev = $this->gitlib->get_revision();

	$view_data = array(
		'app_revision' => $rev,
	);
	$this->layout->view('about/about', $view_data);
  }
  
}
