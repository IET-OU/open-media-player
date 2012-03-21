<?php
/**
 * HTTP request library.
 * Code from base_service.php, using cURL.
 *
 * @copyright Copyright 2011 The Open University.
 * @author N.D.Freear, 6 March 2012.
 */

class Http {

  public function request($url, $spoof=TRUE) {
    return $this->_http_request_curl($url, $spoof);
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
	$http_proxy = config_item('http_proxy'); //$this->CI->config->item('http_proxy');
	if ($http_proxy) {
	  curl_setopt($h_curl, CURLOPT_PROXY, $http_proxy);
	}
    curl_setopt($h_curl, CURLOPT_RETURNTRANSFER, TRUE);
    $result = array('data' => curl_exec($h_curl));
    if ($errno = curl_errno($h_curl)) {
      //Error. Quietly log?
      $this->CI->_log('error', "cURL $errno, ".curl_error($h_curl)." GET $url");
      #$this->CI->firephp->fb("cURL $errno", "cURL error", "ERROR");
    }
    $result['info'] = curl_getinfo($h_curl);
    $result['success'] = ($result['info']['http_code'] < 300);
    return (object) $result;
  }
  
}