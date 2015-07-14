<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * An extendable controller.
 *
 * Need to replace these removed experiments/ work-in-progress controllers:
 *      localize, media_redirect, obj_to_oup, svg, track, xml_namespace;
 *
 * @copyright Copyright 2015 The Open University.
 */

class Extend extends \IET_OU\Open_Media_Player\MY_Controller
{

    /** Override the default controller behaviour through the use of the _remap() function.
    */
    public function _remap($method, $params = array())
    {
        $sub = new \IET_OU\SubClasses\SubClasses();

        $extensions = $sub->match('\\IET_OU\\Open_Media_Player\\Extend_Controller');

        if (isset($extensions[ 'method' ])) {
            $extend = new $extensions[ 'method' ] ();
            $extend->call($method, $params);
        } else {
            $this->_debug($params);
            $this->_error("The page you requested was not found.", 404.11);
        }
    }
}
