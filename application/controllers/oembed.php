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
    #parent::Controller();
    #@header("X-Powered-By:");

    //( #1319, Don't load the embed cache model here. iet-it-bugs 1319)
  }

  protected function _tracker($provider, $host, $meta) {
    //TODO - UA-, URL. ($this->uri->site_url() ?)
	if (isset($provider['_google_analytics'])) {
	  $id = $provider['_google_analytics'];
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

  public function p($params){var_dump("Params: $params");exit;}
  
  public function index() {
    @header('Content-Type: text/plain; charset=UTF-8');
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

    $this->config->load('providers');
    $providers = $this->config->item('providers');

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
	  $this->load->library("providers/{$name}_serv.php");
      $regex_display = $this->{"{$name}_serv"}->regex;

	  $regex = $this->{"{$name}_serv"}->_regex_real ? $this->{"{$name}_serv"}->_regex_real : str_replace('*', '([\w_-]*?)', $regex_display);
	  
	} else {
	  # Legacy (is_array).
    $name  = $providers[$host]['name'];
    $regex_display = $providers[$host]['regex'];
    if (isset($providers[$host]['_regex_real'])) {
      $regex = $providers[$host]['_regex_real'];
    } else {
      $regex = str_replace('*', '([\w_-]*?)', $regex_display); #([^\/]*?)
    }

	} # End legacy.

    if (! preg_match("@{$regex}$@", $req->url, $matches)) {
      $this->_error("the format of the URL for provider '$host' is incorrect. Expecting '$regex_display'.", 400);
    }

    if (!file_exists(APPPATH."views/oembed/$name.php")) {
      $this->_error("not found, view '$name'.", 404.1);
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
    else {
      $this->load->model('embed_cache_model');
      $meta = $this->embed_cache_model->get_embed($req->url);
    }

    // Should we load the library for the service?
    if (($this->config->item('always_upstream') || !$meta)
        && file_exists(APPPATH."/libraries/providers/{$name}_serv.php")) {
      $this->load->library("providers/{$name}_serv.php");
      $meta = $this->{"{$name}_serv"}->call($req->url, $matches);
    } elseif (!$meta && is_callable(array($this, "_meta_$name"))) {
      // Legacy.
echo " this->_meta_$name() ";
      $meta = $this->{"_meta_$name"}($req->url, $matches);
    } else {
      #$meta = array();
    }

    $view_data = array(
      'url'   => $req->url,
      'format'=> $req->format,
      'callback'=>$req->callback,
      'matches' =>$matches,
      'meta'  => $meta,
      'tracker'=>$this->_tracker($provider, $host, $meta),
    );

    if (file_exists(APPPATH."views/oembed/$name.php")) {
      $html = $this->load->view("oembed/$name", $view_data); #, TRUE);
      /*$resp = array_merge(array(
          #'version'=>'1.0',
          'type'=>'rich',
          'html'=>$html,
        ),
        $meta
      );
      $this->load->view('oembed/render', array(
        'format'=>$format,
        'callback'=>$json_callback,
        'oembed'=>$resp,
      ));
      /*if ('json'==$format) {
        $json = json_encode($resp);
        $json = str_replace('",', '",'.PHP_EOL, $json);
        if ($json_callback) {
          $json = "$json_callback($json\n)";
        }
        echo $json;
      } else {
        $this->load->view('oembed/xml', $resp);
      }*/

    } else {
      $this->_error("not found, view '$name'.", 404);
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


  #protected function _meta_prezi(...)

  protected function _meta_scratch($url, $matches=null) {

    $meta = array(
      'url'=>$url,
      'provider_name'=>'scratch',
      'provider_mid' =>$matches[2],
      'author' => $matches[1]);
    
      /*<!-- <rdf:RDF..><Work..><dc:title>..
    #pactivity(views,loves..); #pdesc-description; ul#taglist */
  #echo "GET $url";
    $result = $this->_http_request_curl($url);
    if (! $result->success) {
      die("Error, _meta_scratch woops");
      return FALSE; //Error.
    }
    if (! preg_match('#(<Work.*\/Work>)#ms', $result->data, $matches)) {
      die("Error, preg [rdf..Work]");
      return FALSE;
    }
    // Suppress un-registered namespace warnings?
    $rdf = @new SimpleXmlElement($matches[1]);
    $rdf->registerXPathNamespace('rdf', "http://www.w3.org/1999/02/22-rdf-syntax-ns#");
    //$rdf->registerXPathNamespace('cc', 'http://web.resource.org/cc/');
    $rdf->registerXPathNamespace('dc', 'http://purl.org/dc/elements/1.1/');

    //dc:title,date,desc,creator,rights,type,license.
    foreach ($rdf->children() as $name => $value) {
      if ('creator'==$name) {
        $value = $value->Agent->title;
        $name  = 'author';
      }
      elseif ($attr = $value->attributes()) {
        $value = $attr['resource'];
      }
      if ('rights'==$name||'type'==$name||'license'==$name) {
      //switch($name) { case 'rights':case 'type':case 'license': #@todo??
          continue;
      }
      $meta[$name] = (string) $value;
    }
    $meta['timestamp'] = strtotime($meta['date']);
    $meta['author_url']= 'http://scratch.mit.edu/users/'.$meta['author']; #@todo.
    //$author=  $rdf->xpath('/Work/creator//text()'); #<license rdf:resource*/

    //More efficient/robust using SimpleXml ?
    preg_match('#(<ul id=.taglist.>.*?<\/ul>)#ms', $result->data, $m_tags);
    $tags = strip_tags(str_replace('</li>', '|', $m_tags[1]));
    $tags = explode('|', $tags);
    $taglist;
    foreach ($tags as $tag) {
      $taglist[] = trim($tag);
    }
    $meta['extended']['tags'] = trim(implode('|', $taglist), '|'); #??

    preg_match('#(<div id=.pactivity.*?<\/div>)#ms', $result->data, $m_activity);
    $activity = trim(strip_tags($m_activity[1])); #194 views, 2 taggers...
    $meta['extended']['activity'] = $activity;
    
    preg_match('#<div  id=.projectdown.*?\/h3>(.*?)<a#ms', $result->data, $m_project);
    $project = trim(strip_tags($m_project[1])); #Download the 3 sprites and 4 scripts  of..
    $meta['extended']['project'] = $project;

    preg_match("#<link rel=.image_src. href=.(.*?). \/>#", $result->data, $m_image);
    $meta['thumbnail_url'] = $m_image[1];


    $cache_id = $this->embed_cache_model->insert_embed($meta);
    
    return (object) $meta;
  }

}
