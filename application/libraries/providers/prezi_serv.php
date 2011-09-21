<?php
/** Prezi service provider.
 *
 * @copyright Copyright 2011 The Open University.
 */
//NDF, 1, 23 March 2011.

require_once APPPATH.'libraries/base_service.php';


class Prezi_serv extends Base_service {

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

  /** Call the Embed.ly service (2011-03-23).
  * @return object
  */
  public function call($url, $matches) {

    $meta = array(
      'url'=>$url,
      'provider_name'=>'prezi',
      'provider_mid' =>$matches[1],
      'title' => ucfirst(str_replace('-', ' ', $matches[2])),
      'timestamp'=>null,
      '_itunes_app_url'=> self::ITUNES_APP_URL,
      '_ipad_open_url' => $this->_ipad_open_url($matches[1]),
    );

    $json_url = "http://api.embed.ly/1/oembed?format=json&url=$url";
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
    if (preg_match('/^(.*) by (.*) on Prezi/', $result->json->title, $m_title)) {
      $meta['title'] = $m_title[1];
      $meta['author']= $m_title[2];
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