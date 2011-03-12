<?php
/** Google/Piwik Analytics - track controller. (2010-07-20)

  http://snipplr.com/view/37647/nojs-redirect-to-piwik-google-analytics-webbug/

  Redirect to a Piwik webbug (1 pixel image), or the Google-Analytics one.
  OLnet.org / OER tracking project.

  @copyright 2010 The Open University.
 
  Usage - Piwik - title=X, r=referrer are optional,
  <img alt="" src="http://localhost/track/PI-1/example.org/path/to/123?title=My+Title" />
 
  Usage - Google-Analytics,
  <img alt="" src="http://localhost/w/ouplayer/track/UA-1234-5/example.org/path/to/123?title=My+Title&r=http%3A//referer.example.com/" />
 
 
  An Apache .htaccess/httpd.conf edit is required:
 
  <IfModule mod_rewrite.c>
  RewriteEngine on
  # If the file/dir is NOT real go to index
  RewriteCond %{REQUEST_FILENAME} !-f
  RewriteCond %{REQUEST_FILENAME} !-d
  RewriteRule ^(.*)$ index.php/$1 [QSA,L]
  </IfModule>
  <IfModule !mod_rewrite.c>
  # If mod_rewrite is NOT installed go to index.php
  ErrorDocument 404 index.php
  </IfModule>
 
*/
// Substitute your local Piwik here.
#define('PIWIK_TRACKER', "http://localhost/my_piwik/piwik.php");
define('PIWIK_TRACKER',  "http://piwik.org/demo/piwik.php");
define('GOOGLE_TRACKER', "http://www.google-analytics.com/__utm.gif");

ini_set('display_errors', true);


class Track extends CI_Controller {

  public function i($id) { #Can't be function index - segments :(.

    #$local_url = $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    #$path = parse_url($local_url, PHP_URL_PATH);
    $path = $this->uri->uri_string();

    // Optional Referrer/title - use parse_url for crude parsing.
    $referer = isset($_GET['r']) && 'array'==gettype(@parse_url($_GET['r'])) ? $_GET['r'] : NULL;
    $referer = !$referer && isset($_SERVER['HTTP_REFERER']) ? isset($_SERVER['HTTP_REFERER']) : $referer;
    $title = isset($_GET['title']) ? $_GET['title'] : NULL;

    $request_string = NULL;
    if (preg_match('#/PI-(\d+?)/(.+)$#', $path, $matches)) {
      // Piwik
      $request_string = $this->_piwik_analytics_bug_url($matches, $title, $referer);
    }
    elseif (preg_match('#/(UA-\d+?(-\d+)?)/(.+)$#', $path, $matches)) {
      // Google/Urchin?
      $request_string = $this->_google_analytics_bug_url($matches, $title, $referer);
    }
    //ELSE: Yahoo?
 
    // Error.
    if (!$request_string) {
      @header("HTTP/1.1 400", TRUE, 400);
      die("Error, bad request.");
    }
 
    // OK, do the redirect to the web bug (temporary).
    @header("HTTP/1.1 302 Moved", TRUE, 302);
    header("Location: $request_string"); exit;
 
    echo " DEBUG, redirect: $request_string ";
  }

  /* Based on,
   http://dev.piwik.org/svn/trunk/core/Tracker/Visit.php
   http://www.burtonkent.com/wp-content/uploads/piwik-tag.php
  */
  protected function _piwik_analytics_bug_url($matches, $title=NULL, $referer=NULL) {
    // non-Javascript solution can't get screen-resolution, Flash, Java, other plugin capabilities.
    $request = array();

    # idsite - Piwik site ID.
    $request['idsite'] = $matches[1];

    # url - Requested URL.
    $scheme = 80==$_SERVER['SERVER_PORT'] ? 'http://' : 'https://';
    $request['url'] = $scheme . $matches[2];

    # urlref - Referrer.
    $request['urlref'] = $referer;

    # title, action_name?
    $request['title'] = $title;
    $request['action_name']= $title;

  # cookie - Are cookies enabled?
  /*if (isset($_SERVER['HTTP_COOKIE']) && $_SERVER['HTTP_COOKIE'] != '') {
    $request['cookie'] = 1;
  }
  else {
    $request['cookie'] = 0; # or possibly not set? Hmm, not convinced!
  }*/

    # (d,) h, m, s - hours, minutes, seconds (, days?)
    list($request['d'], $request['h'], $request['m'], $request['s'])
          = explode('|', date('d|H|i|s', $_SERVER['REQUEST_TIME']));

    # rand - random number - quick 17 precision random number.
    $request['rand'] = '0.' . mt_rand(0, mt_getrandmax());

    # rec - record? 1 by default
    $request['rec'] = 1;

    return PIWIK_TRACKER .'?'. http_build_query($request);
  }


  /* Based on http://nojsstats.blogspot.com/ */
  protected function _google_analytics_bug_url($matches, $title=NULL, $referer=NULL) {
    $request = array('utmwv'=>1, 'utmsr'=>'-', 'utmsc'=>'-', 'utmul'=>'-',
         'utmje'=>'0', 'utmfl'=>'-', 'utmjv'=>'-'); //'hid' Another number?

    $request['utmac'] = $matches[1];

    $p = parse_url('http://'.$matches[3]);
    $request['utmhn'] = $p['host'];
    $request['utmp' ] = $p['path']. (isset($p['query']) ? '?'.$p['query'] : '');

    $request['utmdt'] = $title;
    $request['utmr' ] = $referer;

    # utmn - Random number?
    $request['utmn' ] = mt_rand(0, mt_getrandmax());

    return GOOGLE_TRACKER .'?'. http_build_query($request);
  }
}
