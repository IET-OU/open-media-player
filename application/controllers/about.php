<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* Help and about page controller.
*
* @copyright 2012 The Open University.
* @author N.D.Freear, 30 July 2012.
*/
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
