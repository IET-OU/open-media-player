<?php defined('BASEPATH') or exit('No direct script access allowed');
/**
|--------------------------------------------------------------------------
| Open Media Player - constants.
|--------------------------------------------------------------------------
*/

/* NOTE: for now we use the legacy prefix `OUP_`. */


// Prevent CodeIgniter error.
$config[ 'oup_constants' ] = 'dummy';


// Debug constants.

// NONE: no console logging, minified Javascripts/CSS.
define('OUP_DEBUG_NONE', 0);

// MIN: Javascript console logging, minified/concatenated Javascripts/CSS.
define('OUP_DEBUG_MIN',  1);

// MAX: Javascript console logging, un-minified/separate Javascripts/CSS.
define('OUP_DEBUG_MAX',  2);



/*
|--------------------------------------------------------------------------
| XML Nampsaces - oEmbed extensions; Open Media Player data-feeds.
*/
define('XMLNS_OU_OEMBED_EXTEND', 'http://embed.open.ac.uk/2012/extend#');
define('XMLNS_OU_RSS_PLAYER', 'http://podcast.open.ac.uk/2012');


/*
|--------------------------------------------------------------------------
| Resource URL - Stylesheet/JS base URL for OUICE layout/template view (Was: www8).
| ('//' is deliberate - HTTPS/SSL - 'www3..' is available via HTTPS/SSL.)
*/
define( 'OUP_OU_RESOURCE_URL', 'https://www3.open.ac.uk' );


/*
| Blog, help and feedback URLs.
|--------------------------------------------------------------------------
| http://freear.org.uk/content/ou-media-player-project | http://freear.org.uk/content/ou-embed-proposal
| mailto:N.D.Freear+@+open.ac.uk?subject=OU+player
*/
define('OUP_PROJECT_URL', 'https://iet-ou.github.io/open-media-player/');
define('OUP_BLOG_URL', 'http://www.open.ac.uk/blogs/LTT_IET/category/open-media-player/');
define('OUP_BLOG_RSS_URL',
    'http://www.open.ac.uk/blogs/LTT_IET/category/open-media-player/feed/');
define('OUP_PACK_URL', 'https://packagist.org/packages/IET-OU/open-media-player');
define('OUP_CODE_URL', 'https://github.com/IET-OU/open-media-player');
define('OUP_BUG_URL', 'https://github.com/IET-OU/open-media-player/issues');
define('OUP_HELP_URL', 'https://msds.open.ac.uk/students/help.aspx');
define('OUP_CONTACT_URL', 'mailto:IET-Webmaster@open.ac.uk?subject=Open Media Player feedback:');

define('OUP_CLOUD_URL', 'https://cloudworks.ac.uk/tag/view/oEmbed'); // Was: 'view/ouplayer'
define('OUP_DRUPAL_URL', 'http://www.open.ac.uk/wikis/drupal/');
define('OUP_FLASH_URL', 'https://get.adobe.com/flashplayer/');

// ('//' is deliberate - HTTPS/SSL.)
define('OUP_NOEMBED_STYLE_URL', '//noembed.com/noembed.css');
define('OUP_NOEMBED_END_URL', 'https://noembed.com/embed');

// URL parameter names (eg. http://example.org/path?param=value)

//Common parameter names, shared by oEmbed/ embed/ popup controllers.
define('OUP_PARAM_DEBUG', 'debug');
define('OUP_PARAM_THEME', 'theme');
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

// Fix jQuery XSS vulnerability (IT notify) [Bug: #8]
define( 'jQuery_version', '3.2.1' );
define( 'OUP_JS_CDN_JQUERY_MIN', 'https://unpkg.com/jquery@3.4.1/dist/jquery.min.js' );
define( 'OUP_JS_CDN_JQUERY', 'https://unpkg.com/jquery@3.4.1/dist/jquery.js' );


// "Link to jQuery 1.7+ on a CDN - shared by jquery-oembed demos (and the Player depending on config[jslib])."
// Note, the Player implements a JS fallback for the jQuery CDN.
