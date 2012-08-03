<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Prezi oEmbed service provider.
 *
 * @copyright Copyright 2011 The Open University.
 * @author N.D.Freear, 1-23 March 2011.
 */
require_once APPPATH.'libraries/Oembed_Provider.php';


class Prezi_serv extends Oembed_Provider {

  public $regex = 'http://prezi.com/*/*/?'; // Optional trailing slash.
  public $about = <<<EOT
  Prezi - The Zooming Presentations Editor. Embed presentations hosted on Prezi. [Initially for Cloudworks/OULDI. Public access.]';
EOT;
  public $displayname = 'Prezi';
  public $domain = 'prezi.com';
  public $favicon = 'http://prezi.com/favicon.ico';
  public $type = 'rich';

  public $_about_url = 'http://prezi.com/';

  public $_regex_real = NULL;
  public $_examples = array(
    'Dig. Schol. by M.Weller' => 'http://prezi.com/izeqbfy2z5w-/digital-scholarship',
    'http://prezi.com/zoidjousoeat/technology-for-the-classroom',
    '_OEM'=>'/oembed?url=http%3A//prezi.com/izeqbfy2z5w-/digital-scholarship',
  );
  public $_access = 'public';


  /** Short URL for the Prezi iPad app (protocol: itms)
  * http://itunes.apple.com/us/app/prezi/id407759942
  * Tested, OK in iPad-Safari and iPad-Opera Mini.
  */
  const ITUNES_APP_URL = 'itms://itunes.com/apps/prezi';

  /** Get the URL to open a Prezi in the iPad app (protocol: prezi)
  * Tested, OK in iPad-Safari and iPad-Opera Mini.
  * @return string
  */
  protected function _ipad_open_url($prezi_id) {
    return 'prezi://open?oid='.$prezi_id;
  }


  /**
  * Call the Embed.ly service (2011-03-23).
  * @return object
  */
  public function call($url, $matches) {

    $meta = array(
      'url'=>$url,
      'provider_name'=>'Prezi',
      'provider_mid' =>$matches[1],
      'title' => ucfirst(str_replace('-', ' ', $matches[2])),
      'author'=>null,
      'timestamp'=>null,
      '_itunes_app_url'=> self::ITUNES_APP_URL,
      '_ipad_open_url' => $this->_ipad_open_url($matches[1]),
    );

    $json_url = $this->_embedly_oembed_url($url);
    $result = $this->_http_request_json($json_url, $spoof=TRUE);
    if (! $result->success) {
	  //403: Forbidden - Embedly has blocked your client ip. Sign up for an API key at http://embed.ly.
      die("Error, Prezi_serv woops, $json_url");
      return FALSE; //Error.
    }
    if (! $result->json) {
      die("Error, Prezi_serv JSON, $json_url");
      return FALSE; //Error.
    }

    // Older Prezis only?
    if (preg_match('/^(.*) presented by (.*)$/', $result->json->description, $m_desc)) {
      $meta['timestamp'] = strtotime($m_desc[1]);
      #$meta['author'] = $m_desc[2];
    } else {
      // Newer ones, eg. M.Weller's?
      $meta['description'] = $result->json->description;
    }
	// No longer works (26 Sep 2011) :(.
    if (preg_match('/^(.*) by (.*)? on Prezi/', $result->json->title, $m_title)) {
      $meta['title'] = $m_title[1];
      $meta['author']= $m_title[2];
    }
    elseif (preg_match('/^(.*?) on/', $result->json->description, $m_author)) {
      $meta['author']= $m_author[1];
      $meta['title'] = $result->json->title;
    }

    $meta['thumbnail_url']  = $result->json->thumbnail_url;
    $meta['thumbnail_width']= $result->json->thumbnail_width;
    $meta['thumbnail_height']=$result->json->thumbnail_height;

    //$cache_id = $this->embed_cache_model->insert_embed($meta);

    return (object) $meta;
  }

  /** Pre-Embed.ly screen scraper - broken by new HTML5!
  */
  protected function _call_screen_scrape($url, $matches) {
  //protected function _meta_prezi($url, $matches=null) {

    $meta = array(
      'url'=>$url,
      'provider_name'=>'prezi',
      'provider_mid' =>$matches[1],
      'title' => ucfirst(str_replace('-', ' ', $matches[2])),
      'timestamp'=>null,
    );

    $result = $this->_http_request_curl($url, $spoof=TRUE);
    if (! $result->success) {
      die("Error, Prezi_serv woops");
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

    //$cache_id = $this->embed_cache_model->insert_embed($meta);
    
    return (object) $meta;
  }
}