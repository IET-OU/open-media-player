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


// URL parameter names (eg. http://example.org/path?param=value)

//Common parameter names, shared by oEmbed/ embed/ popup controllers.
define('OUP_PARAM_DEBUG', 'debug'); #Was: _debug
define('OUP_PARAM_THEME', 'theme'); #Was: _theme
define('OUP_PARAM_LANG', 'lang');


// Javascript (no-)libraries / CDNs.
// Note, the Player uses CDNs with Javascript fallbacks to local copies.

// Preferred: Ender/jeesh
define('OUP_JS_CDN_ENDER_MIN', 'http://cdn.enderjs.com/jeesh.min.js');
define('OUP_JS_CDN_ENDER',     'http://cdn.enderjs.com/jeesh.js');

// Fallback: jQuery 1.7+
define('OUP_JS_CDN_JQUERY_MIN',
  '//ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js');
define('OUP_JS_CDN_JQUERY',
  '//ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.js');


// "Link to jQuery 1.7+ on a CDN - shared by jquery-oembed demos (and the Player depending on config[jslib])."
// Note, the Player implements a JS fallback for the jQuery CDN.


//header('Content-Type: text/plain;');
//var_dump(get_defined_constants()); exit;

