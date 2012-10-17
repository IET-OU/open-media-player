<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Cohere oEmbed service provider.
 *
 * Originally developed as part of the OLnet project (CI_oembed: collective intelligence).
 *
 * @copyright Copyright 2009 The Open University.
 * @author N.D.Freear, 21 October 2009, 23 July 2012.
 *
 * @link https://wahoo.open.ac.uk/svn/repos/olnet/trunk/sites/all/modules/custom/ci_oembed/ci_oembed.providers.inc : ci_oembed_cohere(), lines 14-84 (6.x-0.1-dev)
 * Also, http://olnet.org/node/142 | http://olnet.org/ci/demo | http://olnet.org/oembed
 */
require_once APPPATH.'libraries/Oembed_Provider.php';


class Cohere_serv extends Oembed_Provider {

  public $regex = 'http://cohere.open.ac.uk/node/*';
  public $about = <<<EOT
  The Web is about IDEAS+PEOPLE. Cohere is a visual tool to create, connect and share Ideas.
  Back them up with websites. Support or challenge them. Embed them to spread virally.
  Discover who - literally - connects with your thinking. [Initially for OLnet. Public access.]
EOT;
  public $displayname = 'Cohere';
  public $domain = 'cohere.open.ac.uk';
  public $favicon = 'http://cohere.open.ac.uk/favicon.ico';
  public $type = 'rich';

  public $_about_url = 'http://cohere.open.ac.uk/';
  public $_logo_url = 'http://cohere.open.ac.uk/images/cohere_logo2.png';

  public $_regex_real = '\/cohere\.open\.ac\.uk\/node.*\?nodeid=(\d{6,})(.*)$';
  public $_examples = array(
    'What does OLnet.org provide? what are the activities that bring people back to our site?' => 'http://cohere.open.ac.uk/node.php?nodeid=137108251180792633001256905958#conn-neighbour',
    '1 - Climate' => 'http://cohere.open.ac.uk/node.php?nodeid=9396932240241950001231360289#conn-neighbour',
    '2 - Olnet' => 'http://cohere.open.ac.uk/node.php?nodeid=13710849440486941001232370050#conn-neighbour',
    '_OEM'=>'/oembed?url=http%3A//cohere.open.ac.uk/node.php%3Fnodeid%3D137108251180792633001256905958%23conn-neighbour',
    '_RSS'=>'http://cohere.open.ac.uk/api/service.php?format=rss&method=getnodesbysearch&q=OER&scope=all&start=0&max=20&orderby=date&sort=DESC&direction=right',
  );
  public $_access = 'public';


  /**
  * Implementation of call() - used by oEmbed controller.
  * @return object
  */
  public function call($url, $matches) {

    $request = (object) array(
      'url' => $url,
      'html5' => TRUE,
    );
    $node_id = $matches[1];

  #Width: I've trimmed, but still too big!
  $embed_width = 650;
  $embed_height= 340;
  $iframe_width= 1002; #1002,1015;

  $iframe_attr = NULL; #' style="overflow:scroll"';
  if ($request->html5) {
    #http://whatwg.org/specs/web-apps/current-work/multipage/the-iframe-element.html#attr-iframe-seamless
    $iframe_attr =' seamless="seamless" '; #sandbox?
  }

# 2. Validate URL and get node ID - Oembed controller.

# 3. Form feed URL, Get RSS feed - cURL... max=20
  $feed_url = "http://cohere.open.ac.uk/api/service.php?format=rss&method=getnodesbynode&nodeid=$node_id&start=0&max=5&orderby=date&sort=DESC&direction=right"; #&filtergroup=&filterlist=&netnodeid=&netq=&netscope=";

  $result = $this->_http_request_curl($feed_url);
  if (! $result->success) {
    $this->_error("Cohere oEmbed provider HTTP problem, $feed_url", $result->http_code);
  }


# 4. Extract meta-data from Feed.
  $xmlo = @simplexml_load_string($result->data);
  if (! $xmlo) {
    $this->_error("Cohere oEmbed provider XML problem, $feed_url");
  }

  $xmlo->registerXPathNamespace('dc', 'http://purl.org/dc/elements/1.1/');
  #$link  = $xmlo->xpath('//item/link');
  $title = $xmlo->xpath('//item/title');
  $desc  = $xmlo->xpath('//item/description');
  $author= $xmlo->xpath('//item/dc:creator');
  $date  = $xmlo->xpath('//item/pubDate');

  $idx = 0;
  $title = (string) $title[$idx];
  $desc  = (string) $desc[$idx];
  $author= (string) $author[$idx];
  $date  = strtotime((string) $date[$idx]);

# 5. Create <iframe> markup + a heading-link - see the view.

  $meta = array(
    'type'  => $this->type,
    'title' => $title,
    'author_name'  => $author,
    #'author_url'  => 'http://cohere.open.ac.uk/user.php?userid=137108251180600208001228233364', #@todo: Anna.
    'provider_mid' => $node_id,
    'provider_name'=> $this->displayname,
    'provider_url' => $this->_about_url,
    'html'  => NULL,
    'width' => $embed_width,
    '_iframe_width' => $iframe_width,
    'height'=> $embed_height,
    'description'=>$desc,
    'lang'  => 'en', #@todo ?
  );
    return (object) $meta;
  }

}
