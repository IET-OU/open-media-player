<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Mathtran oEmbed service provider.
 *
 * Originally developed as part of the OLnet project (CI_oembed: collective intelligence).
 *
 * @copyright Copyright 2009 The Open University.
 * @author N.D.Freear, 21 October 200, 23 July 2012.
 *
 * @link https://wahoo.open.ac.uk/svn/repos/olnet/trunk/sites/all/modules/custom/ci_oembed/ci_oembed.providers.inc : ci_oembed_mathtran(), lines 87-138 (6.x-0.1-dev)
 * Also, http://olnet.org/node/142 | http://olnet.org/ci/demo | http://olnet.org/oembed
 */
require_once APPPATH.'libraries/Oembed_Provider.php';


class Mathtran_serv extends Oembed_Provider {

  public $regex = 'http://mathtran.org/formulas/details/*'; // Optional trailing slash?
  public $about = <<<EOT
   [Initially for OLnet. Public access.]';
EOT;
  public $displayname = 'Mathtran';
  public $domain = 'mathtran.org';
  public $favicon = 'http://mathtran.org/favicon.ico';
  public $type = 'photo';

  public $_about_url = 'http://mathtran.org/';
  public $_logo_url = 'http://mathtran.org/site_media/logo.png';

  public $_regex_real = '\/mathtran\.org\/formulas\/details\/(\d+)';
  public $_examples = array(
    'Trabajo, by Gustavo (es)' => 'http://mathtran.org/formulas/details/336/',
    'classical time-evolution operator, by rcabrera' => 'http://mathtran.org/formulas/details/371/',
    '_OEM'=>'/oembed?url=http%3A//mathtran.org/formulas/details/371',
  );
  public $_access = 'public';


  /**
  * Implementation of call() - used by oEmbed controller.
  * @return object
  */
  public function call($url, $matches) {

  $embed_width = 600;#Maximums? http://mathtran.org/formulas/details/341/#568x27, http://mathtran.org/formulas/details/345/#447x56
  $embed_height= 56;
  $mathtran_url_pattern = "#\/mathtran\.org\/formulas\/details\/(\d+)#";

# 2. Validate URL - Oembed controller.

  $result = $this->_http_request_curl($url);
  if (! $result->success) {
    $this->_error("Cohere oEmbed provider HTTP problem, $feed_url", $result->http_code);
  }


# 4. Extract meta-data from page.
  $result->data = str_replace('&copy;', '&#169;', $result->data); #@todo Hack!
  $xmlo = @simplexml_load_string($result->data);
  if (! $xmlo) {
    $this->_error("Mathtran oEmbed provider XML problem, $feed_url");
  }

  $xmlo->registerXPathNamespace('xh', 'http://www.w3.org/1999/xhtml');
  $title = $xmlo->xpath('//xh:title');
  $image = $xmlo->xpath("//*[@class='formula-display']//@src"); #('//xh:img')
  $caption=$xmlo->xpath("//*[@class='XXX-caption']/*");
  $caption=trim((string) $caption[0], ". \r\n\t");

  $title = explode('|', (string) $title[0]);
  $author= trim($title[1]);
  $title = trim($title[2]);

  $image = (string) $image[0]['src']; #[1].
  preg_match("#tex=.displaystyle (.*)#", $image, $matches); #\\?
  $tex = urldecode($matches[1]);

  $oembed = array(
    'type'  => $this->type,
    'title' => "Maths formula '$title', $caption, tex: $tex",
    'url'   => $image,
    'author_name'  => $author,
    'author_url'  => "http://mathtran.org/profiles/$author", #@todo.
    'provider_name'=>$this->displayname,
    'provider_url' =>$this->_about_url,
    'width' => $embed_width,
    'height'=> $embed_height,
    'tex'   => $tex,
    'description'=>$caption,
    #'lang'  => 'en', #@todo ?
  );
    return (object) $oembed;
  }

}
