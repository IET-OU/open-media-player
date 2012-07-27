<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * The oEmbed Services API controller.
 *
 * @copyright Copyright 2012 The Open University.
 * @author N.D.Freear, 19 July 2012.
 *
 * @link http://api.embed.ly/1/services?callback=_FN
 */
ini_set('display_errors', true);

class Services extends MY_Controller {


  /** Output JSON/ JSON-P.
  */
  public function index() {
	@header('Content-Disposition: inline; filename=ou-embed-services.json');

    // JSON-P callback: security. Only allow eg. 'Object.func_CB_1234'
    $callback = $this->input->get('callback', $xss_clean=TRUE);
    if ($callback && !preg_match('/^[a-zA-Z][\w_\.]*$/', $callback)) {
      $this->_error("the parameter 'callback' must start with a letter, and contain only letters, numbers, underscore and '.'", "400.6");
    }


	// Get oEmbed service providers.
    $services = array();

    $this->config->load('providers');
    $providers = $this->config->item('providers');

	foreach ($providers as $domain => $provider) {

      if (! is_string($provider)) continue;

      # New (#1356)
      $this->load->oembed_provider($provider);

      // Filter - all?
      $services[] = get_object_vars($this->provider);
      #$services[] = $this->provider->getVars();
    }


    // Output.
    $view_data = array(
      'format' => 'json',
      'callback' => $callback,
      'oembed' => $services, # A hack!
      'not_oembed' => true,
    );
    $this->load->view('oembed/render', $view_data);
  }
}
