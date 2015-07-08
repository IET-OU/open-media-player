<?php defined('BASEPATH') or exit('No direct script access allowed');
/**
* Help and about page controller.
*
* @copyright 2012 The Open University.
* @author N.D.Freear, 30 July 2012.
*/


class About extends \IET_OU\Open_Media_Player\MY_Controller
{

    #const LAYOUT = 'ouice_2';

    public function index()
    {
        $this->_load_layout(self::LAYOUT);

        $git = new \IET_OU\Open_Media_Player\Gitlib();

        $rev = $git->get_revision();

        $view_data = array(
            'is_ouembed' => $this->_is_ouembed(),
            'is_live' => $this->_is_live(),
            'is_demo_page' => false,
            'use_oembed' => false,
            'app_revision' => $rev,
        );
        $this->layout->view('about/about', $view_data);
    }


    /**
    * @link http://embed.ly/providers
    */
    public function providers()
    {
        $this->_load_layout(self::LAYOUT);

        $this->load->library('../controllers/services');
        $services = $this->services->index($return = true);

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
