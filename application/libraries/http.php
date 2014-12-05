<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * HTTP request library.
 * Code from base_service.php, using cURL.
 *
 * @copyright Copyright 2011 The Open University.
 * @author N.D.Freear, 6 March 2012.
 */


/* https://bugs.php.net/bug.php?id=53543
   https://github.com/dtouzeau/1.6.x/blob/master/ressources/class.ccurl.inc#L5
*/
defined( 'CURLOPT_NOPROXY' ) ? NULL : define( 'CURLOPT_NOPROXY', 10177 );


class Http {

  protected $CI;

  public function __construct() {
    $this->CI =& get_instance();
  }


  public function request($url, $spoof=TRUE, $options=array()) {
    $result = $this->_prepare_request($url, $spoof, $options);

    return $this->_http_request_curl($url, $spoof, $options, $result);
  }


  /** Prepare the HTTP request.
  */
#http://api.drupal.org/api/drupal/core%21includes%21common.inc/function/drupal_http_request/8
  protected function _prepare_request($url, $spoof, &$options) {
	$result = new stdClass();

    // Parse the URL and make sure we can handle the schema.
    $uri = @parse_url($url);

    if ($uri == FALSE) {
      $result->error = 'unable to parse URL';
      $result->code = -1001;
      return $result;
    }

    if (!isset($uri['scheme'])) {
      $result->error = 'missing schema';
      $result->code = -1002;
      return $result;
    }

    #timer_start(__FUNCTION__);


    // Bug #1334, Proxy mode to fix VLE caption redirects (Timedtext controller).
    $options[ 'cookie' ] = NULL;
    if (isset($options['proxy_cookies'])) {
      $cookie_names =  $this->CI->config->item('httplib_proxy_cookies');
      if (! is_array($cookie_names)) {
        $this->CI->_error('Array expected for $config[httplib_proxy_cookies]', 400);
      }

      $cookies = '';
      foreach ($cookie_names as $cname) {
        $cookies .= "$cname=". $this->CI->input->cookie($cname) .'; ';
      }
      $options['cookie'] = rtrim($cookies, '; ');
    }

    // Bug #4, Optionally add cookies for every request to a host/ domain.
    $cookie_r = $this->CI->config->item( 'http_cookie' );
    if (is_array( $cookie_r )) {
      foreach ($cookie_r as $domain => $cookie) {
        if (FALSE !== strpos( $url, $domain )) {
          $options[ 'cookie' ] .= $cookie;
        }
      }
    }

    $ua = 'OU Player/1.1.* (PHP/cURL)';
    if ($spoof) {
       // Updated, April 2012.
       $ua = "Mozilla/5.0 (Windows NT 6.1) AppleWebKit/535.19 (KHTML, like Gecko) Chrome/18.0.1025.142 Safari/535.19";
       #$ua="Mozilla/5.0 (Macintosh; U; Intel Mac OS X 10.6; en-GB; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3";
    }

    // Merge the default options.
    $options += array(
      'proxy' => $this->CI->config->item('http_proxy'),
      'no_proxy' => $this->CI->config->item( 'http_no_proxy' ),
      'headers' => array(),
      'method' => 'GET',
      'data' => NULL,
      'max_redirects' => 2,  #3,
      'timeout' => 5,  #15, 30.0 seconds,
      #'context' => NULL,

      'cookie' => NULL,
      'ua' => $ua,
      'debug' => FALSE,
      'auth' => NULL, #'[domain\]user:password'
      'ssl_verify' => TRUE,
    );

    return $result;
  }


  /** Perform the HTTP request using cURL.
  */
  protected function _http_request_curl($url, $spoof, $options, $result) {
    if (!function_exists('curl_init'))  die('Error, cURL is required.');

    $this->CI->_debug($options);

    $h_curl = curl_init($url);

    curl_setopt($h_curl, CURLOPT_USERAGENT, $options['ua']);
    if (!$spoof) {
      curl_setopt($h_curl, CURLOPT_REFERER, base_url());
    }

    // Required for intranet-restricted content [Bug: #1]
    if ($options['cookie']) {
		curl_setopt($h_curl, CURLOPT_COOKIE, $options['cookie']);
		header('X-Proxy-Cookie: '.$options['cookie']);
    }

    if (! $options['ssl_verify']) {
      curl_setopt($h_curl, CURLOPT_SSL_VERIFYPEER, FALSE);
      curl_setopt($h_curl, CURLOPT_SSL_VERIFYHOST, FALSE);
    }

    curl_setopt($h_curl, CURLOPT_AUTOREFERER, TRUE);
    curl_setopt($h_curl, CURLOPT_MAXREDIRS, $options['max_redirects']);
    curl_setopt($h_curl, CURLOPT_FOLLOWLOCATION, TRUE);
    curl_setopt($h_curl, CURLOPT_TIMEOUT, $options['timeout']);
    curl_setopt($h_curl, CURLOPT_CONNECTTIMEOUT, $options['timeout']);

    if ($options['debug']) {
      curl_setopt($h_curl, CURLOPT_HEADER, TRUE);
      curl_setopt($h_curl, CURLINFO_HEADER_OUT, TRUE);
    }

    if ($options['auth']) {
      //TODO: http://unitstep.net/blog/2009/05/05/using-curl-in-php-to-access-https-ssltls-protected-sites/
      curl_setopt($h_curl, CURLOPT_SSL_VERIFYPEER, FALSE);
      curl_setopt($h_curl, CURLOPT_SSL_VERIFYHOST, FALSE);

      curl_setopt($h_curl, CURLOPT_HTTPAUTH, CURLAUTH_NTLM);
      curl_setopt($h_curl, CURLOPT_USERPWD, $options['auth']);
    }

	if ($options[ 'proxy' ]) {
	  curl_setopt($h_curl, CURLOPT_PROXY, $options[ 'proxy' ]);
	  curl_setopt($h_curl, CURLOPT_NOPROXY, $options[ 'no_proxy' ]);
	}
    curl_setopt($h_curl, CURLOPT_RETURNTRANSFER, TRUE);

    $result->data = curl_exec($h_curl);
    $result->http_code = FALSE;

    $result->_headers = NULL;
    // Fragile: rely on cURL always putting 'Content-Length' last..
    if ($options['debug'] && preg_match('#^(HTTP\/1\..+Content\-Length: \d+\s)(.*)$#ms', $result->data, $matches)) {
      $result->_headers = $matches[1];
      $result->data = trim($matches[2], "\r\n");
    }
    if ($errno = curl_errno($h_curl)) {
      //Error. Quietly log?
      $this->CI->_log('error', "cURL $errno, ".curl_error($h_curl)." GET $url");
      #$this->CI->firephp->fb("cURL $errno", "cURL error", "ERROR");
      $result->http_code = "500." . $errno;
      $result->curl_errno = $errno;
      $result->curl_error = curl_error($h_curl);
      $result->success = FALSE;
    }
    $result->info = curl_getinfo($h_curl);
    if (!$result->http_code) {
      $result->success = ($result->info['http_code'] < 300);
      $result->http_code = $result->info['http_code'];
    }

    curl_close($h_curl);

    return (object) $result;
  }
  
}