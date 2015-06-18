<?php defined('BASEPATH') or exit('No direct script access allowed');
/**
 * Controller for a responder for the Uptime Server Monitoring service.
 *
 * Requires the following line in application/config/routes.php
 * <code>
 *   $route['uptime.txt'] = 'uptime';
 * </code>
 * @link http://uptime.solutiongrove.com/
 * @link http://uptime.openacs.org/
 * @copyright 2011 The Open University.
 * @author N.D.Freear, 1 April 2010, 13 July 2012.
 * @package Uptime
 */

class Uptime extends MY_Controller
{

    /** Uptime page, for both podcast and OU-embed data sources/DBs.
    */
    public function index()
    {
        $return = true;

        $podcasts_count = $this->podcast($return);

        $embed_count = $this->embed($return);

        if (!$embed_count || !$podcasts_count) {
               $this->_error('A Feed/ Database Error Occurred'); #Actually, CI never reaches this point!
        }

        $this->_echo_success();
    }


    /** Uptime page/monitor for just the podcast RSS feed(s) or DB.
  *
  * Suggest OPML:  http://podcast.open.ac.uk/feeds/opml.xml
  * Eg.  http://openlearn.open.ac.uk/rss/file.php/stdfeed/1/full_opml.xml
  */
    public function podcast($return = false)
    {
        $url = 'http://podcast.open.ac.uk/pod/l314-spanish#!fe481a4d1d';

        $this->load->oembed_provider('Oupodcast');
        $result = $this->provider->_inner_call('l314-spanish', 'fe481a4d1d');

        $podcasts_count = $result ? 'gt 1' : 0;
        @header('X-Count-Podcast-Items: '.$podcasts_count);

        if (! $return) {
            $this->_echo_success();
        }
        return $podcasts_count;
    }


    /** Uptime page/monitor for just the embed cache DB.
    */
    public function embed($return = false)
    {
        if ($this->config->item('always_upstream')) {
            $embed_count = 'upstream';
        } else {
            $this->load->model('embed_cache_model');
            $embed_count = $this->embed_cache_model->count();
        }
        @header('X-Count-Embed-Cache: '.$embed_count);

        if (! $return) {
             $this->_echo_success();
        }
        return $embed_count;
    }


    protected function _echo_success()
    {
        @header('Content-Type: text/plain; charset=UTF-8');
        echo 'success'.PHP_EOL;
    }
}
