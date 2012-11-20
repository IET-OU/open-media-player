<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* Help and about page controller.
*
* @copyright 2012 The Open University.
* @author N.D.Freear, 30 July 2012.
*/


class About extends MY_Controller {

  #const LAYOUT = 'ouice_2';


  public function index() {
    $this->_load_layout(self::LAYOUT);

    $this->load->library('Gitlib');

	$rev = $this->gitlib->get_revision();

	$view_data = array(
		'is_ouembed' => $this->_is_ouembed(),
		'is_live' => $this->_is_live(),
		'app_revision' => $rev,
		'is_demo_page' => FALSE,
	);
	$this->layout->view('about/about', $view_data);
  }


  /**
  * @link http://embed.ly/providers
  */
  public function providers() {
    $this->_load_layout(self::LAYOUT);

    $this->load->library('../controllers/services');
	$services = $this->services->index($return = TRUE);

	$view_data = array(
		'is_ouembed' => $this->_is_ouembed(),
		'is_live' => $this->_is_live(),
		'page_title' => 'Providers',
		'services' => $services,
		'embedly' => $this->input->get('embedly'),
	);
	$this->layout->view('about/providers_list', $view_data);
  }
}
