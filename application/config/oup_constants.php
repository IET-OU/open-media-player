<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * OU Player/ Embed constants.
 *
 * @copyright Copyright 2012 The Open University.
 */
// Prevent CI error.
$config['oup_constants'] = 'dummy';


// Debug constants.

// NONE: no console logging, minified Javascripts/CSS.
define('OUP_DEBUG_NONE', 0);

// MIN: Javascript console logging, minified/concatenated Javascripts/CSS.
define('OUP_DEBUG_MIN',  1);

// MAX: Javascript console logging, un-minified/separate Javascripts/CSS.
define('OUP_DEBUG_MAX',  2);



/*
|--------------------------------------------------------------------------
| XML Nampsaces - oEmbed extensions; OU Player data-feeds.
*/
define('XMLNS_OU_OEMBED_EXTEND', 'http://embed.open.ac.uk/2012/extend#');
define('XMLNS_OU_RSS_PLAYER', 'http://podcast.open.ac.uk/2012');



/*
|--------------------------------------------------------------------------
| Resource URL - Stylesheet/JS base URL for OUICE layout/template view (Was: www8).
| ('//' is deliberate - HTTPS/SSL - 'www3..' is available via HTTPS/SSL.)
*/
define('OUP_OU_RESOURCE_URL', '//www3.open.ac.uk');


/*
| Blog, help and feedback URLs.
|--------------------------------------------------------------------------
| http://freear.org.uk/content/ou-media-player-project | http://freear.org.uk/content/ou-embed-proposal
| mailto:N.D.Freear+@+open.ac.uk?subject=OU+player
*/
define('OUP_BLOG_URL', 'http://cloudworks.ac.uk/tag/view/oEmbed'); #Was: 'view/ouplayer'
define('OUP_BLOG_RSS_URL', 'http://cloudworks.ac.uk/tag/rss/oEmbed');
define('OUP_HELP_URL', 'https://msds.open.ac.uk/students/help.aspx');
define('OUP_CONTACT_URL', 'mailto:IET-Webmaster+@+open.ac.uk?subject=OU+player');

define('OUP_DRUPAL_URL', 'http://www.open.ac.uk/wikis/drupal/');
define('OUP_FLASH_URL', 'http://adobe.com/go/getflashplayer');

// ('//' is deliberate - HTTPS/SSL.)
define('OUP_NOEMBED_STYLE_URL', '//noembed.com/noembed.css');
define('OUP_NOEMBED_END_URL', 'http://noembed.com/embed');

// URL parameter names (eg. http://example.org/path?param=value)

//Common parameter names, shared by oEmbed/ embed/ popup controllers.
define('OUP_PARAM_DEBUG', 'debug'); #Was: _debug
define('OUP_PARAM_THEME', 'theme'); #Was: _theme
define('OUP_PARAM_LANG', 'lang');


// Expected format of the OU Podcast MD5 item-shortcode.
// (http://codeaid.net/php/check-if-the-string-is-a-valid-md5-hash)
define('OUP_PODCAST_SHORTCODE_SIZE', 10);
define('OUP_PODCAST_SHORTCODE_REGEX', '/^[a-f0-9]{10}$/');


// Javascript (no-)libraries / CDNs.
// Note, the Player uses CDNs with Javascript fallbacks to local copies.

// Preferred: Ender/jeesh ('//' is deliberate - HTTPS/SSL.)
// See, https://github.com/ender-js/website/issues/11
// See, http://ender.jit.su/#jeesh
//Was: define('OUP_JS_CDN_ENDER_MIN', '//cdn.enderjs.com/jeesh.min.js');
define('OUP_JS_CDN_ENDER_MIN', '//dnmrmlfxy5gpj.cloudfront.net/jeesh.min.js');
define('OUP_JS_CDN_ENDER',     '//dnmrmlfxy5gpj.cloudfront.net/jeesh.js');

// Fallback: jQuery 1.7+ ('//' is deliberate - HTTPS/SSL support!)
//WAS: 1.7.2 (1.9.1)
define('OUP_JS_CDN_JQUERY_MIN',
  '//ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js');
define('OUP_JS_CDN_JQUERY',
  '//ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.js');


// "Link to jQuery 1.7+ on a CDN - shared by jquery-oembed demos (and the Player depending on config[jslib])."
// Note, the Player implements a JS fallback for the jQuery CDN.


//header('Content-Type: text/plain;');
//var_dump(get_defined_constants()); exit;

