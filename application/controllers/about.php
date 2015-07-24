<?php defined('BASEPATH') or exit('No direct script access allowed');
/**
 * Part of Open Media Player.
 *
 * @license   http://gnu.org/licenses/gpl.html GPL-3.0+
 * @copyright Copyright 2011-2015 The Open University (IET) and contributors.
 * @link      http://iet-ou.github.io/open-media-player
 */

/**
* Help and about page controller.
*
* @copyright 2012 The Open University.
* @author N.D.Freear, 30 July 2012.
*/

class About extends \IET_OU\Open_Media_Player\MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->page_title = t('About');
    }

    public function index()
    {
        $this->_load_layout();

        $git = new \IET_OU\Open_Media_Player\Gitlib();

        $rev = $git->get_revision();

        $view_data = array(
            'is_ouembed' => $this->_is_ouembed(),
            'is_live' => $this->_is_live(),
            'is_demo_page' => false,
            'layout_name' => $this->layout_name,
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
        $this->_load_layout();

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
