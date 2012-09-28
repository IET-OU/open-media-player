<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * The oEmbed API controller. 
 *
 * @copyright Copyright 2011 The Open University.
 * @author N.D.Freear, 18 June 2010-4 July 2012.
 */
ini_set('display_errors', true);

class Oembed extends MY_Controller {

  public function __construct() {
    parent::__construct();
  }


  protected function _tracker($provider, $host, $meta) {
	# Fix for new (#1356) v. legacy.
	$provider = is_array($provider) ? (object) $provider : $provider;
	//TODO - UA-, URL. ($this->uri->site_url() ?)
	if (isset($provider->_google_analytics)) {
	  $id = $provider->_google_analytics;
	  $path = isset($meta->provider_mid) ? $meta->provider_mid : 'p';
      $image_url = site_url()."track/i/$id/$host/$path/".str_replace(' ','-',$meta->title).'?title='.urlencode($meta->title);
      return <<<EOF
<img class="oup-b" alt="" src="$image_url" />
EOF;
    }
	return null;
  }

  public function _error($message, $code=500) {
    return parent::_error($message, $code, __CLASS__);
  }


  /**
  * So called 'extended' oEmbed endpoint, to support Drupal consumers and custom oEmbed parameters.
  *
  * Eg. /oembed/ex/theme:oup-light/...?url=http://..
  */
  public function ex() {
    $this->input->use_get_and_expath();

    // Now call main handler, below.
    $this->index();
  }


  /**
  * THE handler for the oEmbed endpoint.
  */
  public function index() {
    #@header('Content-Type: text/plain; charset=UTF-8');
    #header('Content-Disposition: inline; filename=ouplayer-oembed.json.txt');

    //Get 'width', 'height'.
    $req = new StdClass;
    $this->CI->oembed_request = $req;

    $req->url = $this->input->get('url');
    if (!$req->url) {
      $this->_error("the URL parameter 'url' is required.", 400);
    }

    $req->format = $this->input->get('format') ? $this->input->get('format') : 'json';
    if ('json'!=$req->format && 'xml'!=$req->format) {
      $this->_error("the output format '$req->format' is not recognised.", "400.5");
    }

    // Security. Only allow eg. 'Object.func_CB_1234'
    $req->callback = $this->input->get('callback', $xss_clean=TRUE);
    if ($req->callback && !preg_match('/^[a-zA-Z][\w_\.]*$/', $req->callback)) {
      $this->_error("the parameter 'callback' must start with a letter, and contain only letters, numbers, underscore and '.'", "400.6");
    }

    $providers = $this->_get_oembed_providers();

    $p = parse_url($req->url);
    if (!isset($p['host'])) {
      $this->_error("the parameter 'url' is invalid - missing host.", 400);
    }
    $host = $req->host = str_replace('www.', '', strtolower($p['host']));

    if (!isset($providers[$host])) {
      $this->_error("unsupported provider 'http://$req->host'.", 400);
    }

	$provider = $providers[$host];
	if (is_string($provider)) {
	  # New (#1356)
	  $name = $provider;

	  $this->load->oembed_provider($name);

	  $regex = $this->provider->getInternalRegex();
	  $oembed_view = $this->provider->getView();

	} else {
	  # Legacy (is_array).
      $this->_error("Unexpected oEmbed provider, $provider.");

	} # End legacy.
	//@header('X-Regex: '.$regex);

    if (! preg_match("@{$regex}$@", $req->url, $matches)) {
      $regex_display = $this->provider->regex;
      $this->_error("the format of the URL for provider '$host' is incorrect. Expecting '$regex_display'.", 400);
    }


    // #1319, only try the embed cache DB connection if we absolutely need to! (iet-it-bugs 1319)
    $meta = NULL;
    if ('podcast.open.ac.uk' === $host) { #Oupodcast_serv::POD_BASE
      $this->_player_init();
      // 'New' 2012 Mediaelement-based themes.
      if (preg_match('/oup-light|ouplayer-base|mejs-default/', $this->_theme->name)) {
        $this->load->theme($this->_theme->name);
      }
    }
	// #1358, Make OU-embed services work without a DB..
    elseif (! $this->config->item('always_upstream')) {

      $this->load->model('embed_cache_model');
      $meta = $this->embed_cache_model->get_embed($req->url);
    }

    // Should we load the library for the service?
    if (($this->config->item('always_upstream') || !$meta)
        && file_exists(APPPATH."/libraries/providers/{$name}_serv.php")) {
      $this->load->oembed_provider($name);

      $meta = $this->provider->call($req->url, $matches);
    }

    $view_data = array(
      'url'   => $req->url,
      'format'=> $req->format,
      'callback'=>$req->callback,
      'matches' =>$matches,
      'meta'  => $meta,
      # Fix for new (#1356) v. legacy.
      'tracker'=>$this->_tracker(isset($this->provider) ? $this->provider : $provider, $host, $meta),
    );

    if (file_exists(APPPATH."views/$oembed_view.php")) {
      $html = $this->load->view($oembed_view, $view_data);

    } else {
      $this->_error("not found, view '$oembed_view'.", 404.11);
    }
    $this->_log('debug', __CLASS__.": Success");
  }


  protected function _safe_xml($xml) {
    $safe = array('&amp;', '&gt;', '&lt;', '&apos;', '&quot;');
    $place= array('#AMP#', '#GT#', '#LT#', '#APOS#', '#QUOT#');
    $result = str_replace($safe, $place, $xml);
    $result = preg_replace('@&[^#]\w+?;@', '', $result);
    $result = str_replace($place, $safe, $result);
    return $result;
  }

}
