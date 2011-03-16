<?php
/** Base class for all oEmbed service provider libraries.
 *
 * @copyright Copyright 2011 The Open University.
 */
//NDF, extracted from oembed controller, 24 Feb. 2011.
//Should this be an abstract class?

interface iService {
  /** call.
  * @return object Return a $meta object, as inserted in DB.
  */
  public function call($url, $regex_matches);
}

abstract class Base_service implements iService {

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
  
  protected function _http_request_json($url, $spoof=TRUE) {
    $result = $this->_http_request_curl($url, $spoof);
    if ($result->success) {
      $result->json = json_decode($result->data);
    }
    return $result;
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

/* Internationalization.
*/
function t($s) {
  $s = str_replace(array('<s>', '</s>'), array('<span>', '</span>'), $s);
  return '^'.$s;
}
if (!function_exists('_')) {
  function _($s) { return $s; }
}