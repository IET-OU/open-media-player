<?php defined('BASEPATH') or exit('No direct script access allowed');
/**
 * The oEmbed Services API controller.
 *
 * @copyright Copyright 2012 The Open University.
 * @author N.D.Freear, 19 July 2012.
 *
 * @link http://api.embed.ly/1/services?callback=_FN
 */
ini_set('display_errors', true);


class Services extends \IET_OU\Open_Media_Player\MY_Controller
{

    /** Output JSON/ JSON-P.
    */
    public function index($return = false)
    {
        @header('Content-Disposition: inline; filename=ouplayer-ou-embed-services.json');

      // JSON-P callback: security. Only allow eg. 'Object.func_CB_1234'
        $callback = $this->_jsonp_callback_check();


      // Get oEmbed service providers.
        $providers = $this->_get_oembed_providers();
        $services = array();

        foreach ($providers as $domain => $provider) {
            if (! is_string($provider)) {
                continue;
            }

          # New (#1356)
            $this->load->oembed_provider($provider);
            $name = $this->provider->getName();

          // Use the 'name' to filter duplicates, then call 'array_values' below.
            $services[ $name ] = $this->provider->getProperties();

            if ('\\IET_OU\\Open_Media_Player\\Oupodcast_Provider' == $provider) {

                $player = new \IET_OU\Open_Media_Player\Podcast_Player();
                $services[$name]->_sizes = $player->get_sizes();
            }
        }

        if ($return) {
            return $services;
        }


      // Output.
        $view_data = array(
        'format' => 'json',
        'callback' => $callback,
        'oembed' => array_values($services), # A hack!
        'not_oembed' => true,
        );
        $this->load->view('oembed/render', $view_data);
    }
}
