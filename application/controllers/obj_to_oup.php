<?php defined('BASEPATH') or exit('No direct script access allowed');
/**
 * Convert <object> to OU Player embeds.
 *
 * @link  http://dl.dropbox.com/u/3203144/ouplayer/obj-to-oup.js
 * @copyright 2014 The Open University.
 * @author N.D.Freear, 15 January 2014.
 */


class Obj_to_oup extends \IET_OU\Open_Media_Player\MY_Controller
{

    public function index()
    {

        $url = $this->input->get('url');
        preg_match('@http:\/\/podcast-api.open.ac.uk\/play\/(.+)@', $url, $m);
        if (!$url || !$m) {
            echo "Error, missing or invalid {url} parameter";
            $this->_error("The URL parameter 'url' is required.", 400);
            return;
        }

        $oupod_id = $m[1];

        $this->load->library('Http');

        $result = $this->http->request($url, $spoof = true, array('max_redirects' => 1));
        if (!$result->success) {
            $this->_error("The HTTP request failed.", $result->http_code);
        }

        $redirect_url = urldecode($result->info['url']);

        $p = parse_url($redirect_url);
        $config = preg_replace('/config=/', '', $p['query']);

        preg_match("/{'clip':{'url':'([^']+)'/", $config, $m);

        $clip_url = $m[1];

   //$d = json_decode(str_replace("'", '"', $config));

        echo $clip_url;

        //TODO
        $this->load->model('Podcast_items_feed_model', 'podcast_items_model');

   /*
   $result = $this->podcast_items_model->get_item($basename, $fragment, $captions=TRUE);
    if (!$result) {
	    $this->_error('podcast item not found.', 404, __CLASS__);
    }
   */
    }
}
