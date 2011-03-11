<?php
/** oEmbed controller. NDF 18 June 2010.
*/
ini_set('display_errors', true);

class Oembed extends Controller {

  public function __construct() {
    parent::__construct();
    @header("X-Powered-By:");

    $this->load->model('embed_cache_model');
  }

  protected function _error($code, $message) {
    @header("HTTP/1.1 $code");
    die("$code, $message");
  }

  public function index() {
    @header("Content-Type: text/plain; charset=UTF-8");

    $url = $this->input->get('url');
    if (!$url) {
      $this->_error(400, "Error, the URL parameter 'url' is required.");
    }

    $format = $this->input->get('format') ? $this->input->get('format') : 'json';
    if ('json'!=$format && 'xml'!=$format) {
      $this->_error("400.5", "Error, the output format '$format' is not recognised.");
    }

    // Security. Only allow eg. 'Object.func_CB_1234'
    $json_callback = $this->input->get('callback', $xss_clean=TRUE);
    if ($json_callback && !preg_match('/^[a-zA-Z][\w_\.]*$/', $json_callback)) {
      $this->_error("400.6", "Error, 'callback' must start with a letter, and contain only letters, numbers, underscore and '.'");
    }

    //api.embed.ly/api/v1/services (json)
    $providers = array(
      'youtube.com' => array('name'=>'youtube', 'regex'=>'youtube.com/watch*', 
          'regex_real'=>'youtube.com/watch\?.*v=([\w-_]*)&*.*'),
      'youtu.be'    => array('name'=>'youtube', 'regex'=>'youtu.be/*'),
      'cohere.ac.uk'=> array('name'=>'cohere', ),
      'mathtran.org'=> array('name'=>'mathtran', ),
      'scratch.mit.edu' => array('name'=>'scratch',
          'regex' =>'scratch.mit.edu/projects/*/*'),
      'prezi.com'   => array('name'=>'prezi',
          'regex' =>'prezi.com/*/*/'), #IPR?
    );

    $p = parse_url($url);
    $host = str_replace('www.', '', strtolower($p['host']));

    if (!isset($providers[$host])) {
      $this->_error(400, "Error, unsupported provider 'http://$host'.");
    }

    $name  = $providers[$host]['name'];
    $regex = $providers[$host]['regex'];
    if (isset($providers[$host]['regex_real'])) {
      $regex = $providers[$host]['regex_real'];
    } else {
      $regex = str_replace('*', '([\w_-]*?)', $regex); #([^\/]*?)
    }
    if (! preg_match("@{$regex}$@", $url, $matches)) {
      $this->_error(400, "Error, the format of the URL for provider '$host' is incorrect. Expecting '".$providers[$host]['regex']."'.");
    }
//var_dump($matches);

    if (!file_exists(APPPATH."views/oembed/$name.php")) {
      $this->_error(404.1, "Not found, view '$name'.");
    }

    $meta = $this->embed_cache_model->get_embed($url);

    //$meta = null;
    if (!$meta && is_callable(array($this, "_meta_$name"))) {
      $meta = $this->{"_meta_$name"}($url, $matches);
    }

    $view_data = array(
      'url'   => $url,
      'format'=> $format,
      'callback'=>$json_callback,
      'matches' =>$matches,
      'meta'  => $meta,
    );

    if (file_exists(APPPATH."views/oembed/$name.php")) {
      $this->load->view("oembed/$name", $view_data);
    } else {
      $this->_error(404, "Not found, view '$name'.");
    }
  }


  protected function _safe_xml($xml) {
    $safe = array('&amp;', '&gt;', '&lt;', '&apos;', '&quot;');
    $place= array('#AMP#', '#GT#', '#LT#', '#APOS#', '#QUOT#');
    $result = str_replace($safe, $place, $xml);
    $result = preg_replace('@&[^#]\w+?;@', '', $result);
    $result = str_replace($place, $safe, $result);
    return $result;
  }

  protected function _meta_prezi($url, $matches=null) {

    $meta = array(
      'url'=>$url,
      'provider_name'=>'prezi',
      'provider_mid' =>$matches[1],
      'title' => ucfirst(str_replace('-', ' ', $matches[2])),
      'timestamp'=>null,
    );
//var_dump($meta);

      /* */
  #echo "GET $url";
    $result = $this->_http_request_curl($url, $spoof=TRUE);
    if (! $result->success) {
      die("Error, _meta_prezi woops");
      return FALSE; //Error.
    }

    preg_match('#(<head.*</head>)#ms', $result->data, $matches);
    $head = $this->_safe_xml($matches[1]);
    $xh = new SimpleXmlElement($head);

    foreach ($xh->children() as $name => $value) {
      $attr = $value->attributes();
      if ('meta'==$name && isset($attr['name'])) {
        if ('description'==$attr['name']) {
          $desc = (string) $attr['content'];
          if (preg_match('#(.*)presented by(.*)#', $desc, $m_desc)) {
            //$meta['author']= trim($m_desc[2]);
            $meta['timestamp'] = strtotime($m_desc[1]);
          } else {
            $meta['description'] = $desc;
          }
        } elseif ('title'==$attr['name']) {
          $meta['title'] = (string) $attr['content'];
        }
      }
      elseif ('link'==$name && 'image_src'==$attr['rel']) {
        $meta['thumbnail_url'] = (string) $attr['href'];
      }
      elseif ('title'==$name
        && preg_match('#by(.*)on Prezi#', (string) $value, $m_title)) {
        $meta['author'] = trim($m_title[1]);
      }
    }
    //$desc = $xh->xpath("//meta[@name='description']/@content");
var_dump($meta);

    $cache_id = $this->embed_cache_model->insert_embed($meta);
    
    return (object) $meta;
  }


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

  protected function _http_request_curl($url, $spoof=TRUE) {
    if (!function_exists('curl_init'))  die('Error, cURL is required.');

    $ua = 'My client/0.1 (PHP/cURL)';
    if ($spoof) {
       $ua="Mozilla/5.0 (Macintosh; U; Intel Mac OS X 10.6; en-GB; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3";
    }

    $h_curl = curl_init($url);
    curl_setopt($h_curl, CURLOPT_USERAGENT, $ua);
    if (!$spoof) {
      curl_setopt($h_curl, CURLOPT_REFERER,   'http://example.org');
    }
    curl_setopt($h_curl, CURLOPT_RETURNTRANSFER, TRUE);
    $result = array('data' => curl_exec($h_curl));
    if ($errno = curl_errno($h_curl)) {
      die("Error: cURL $errno, ".curl_error($h_curl)." GET $url");
    }
    $result['info'] = curl_getinfo($h_curl);
    $result['success'] = ($result['info']['http_code'] < 300);
    return (object) $result;
  }

}
