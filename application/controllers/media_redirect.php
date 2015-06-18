<?php defined('BASEPATH') or exit('No direct script access allowed');
/**
 * Media-redirect test controller.
 *
 * @example  /media_redirect/pod/trackoer/20121019T163505_trackoer-bookmarklet-v1-screencast-nfreear-2012-10-19.m4v
 * @example  /media_redirect/pod/student-experiences/openings-being-an-ou-student.m4v/1/303
 *
 * @copyright Copyright 2012 The Open University.
 * @author N.D.Freear, 2012-10-25
 */


class Media_redirect extends MY_Controller
{

    protected $redirect_codes = array(
    301 => 'Moved permanently',
    302 => 'Found', #'Moved Temporarily'
    303 => 'See Other',
    307 => 'Temporary Redirect', # HTTP/1.1+
    );


    public function pod($collection = null, $filename = null, $params = false, $http_code = 302)
    {
        if (! $collection || ! $filename) {
            $this->_error('Missing {collection} or {filename}', 400);
        }
        if (! preg_match('/30[123]/', $http_code)) {
            $this->_error('Invalid {http_code}', 400.2);
        }

        $url = "http://podcast.open.ac.uk/feeds/$collection/$filename";

        $url .= ($params) ? '?random=' . rand(2, 99) : '';

      #var_dump($url, $params, $http_code);

        header('HTTP/1.1 '. $http_code);
        header('Location: '. $url);

      #redirect($url);
    }
}
