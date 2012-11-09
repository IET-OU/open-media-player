<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
|--------------------------------------------------------------------------
| OU Media Player / OU-embed main configuration file.
|--------------------------------------------------------------------------
*/


/*
|--------------------------------------------------------------------------
| Debugging flag (integer, one of OUP_DEBUG_NONE, OUP_DEBUG_MIN, OUP_DEBUG_MAX).
*/
$config['debug'] = OUP_DEBUG_NONE;


/*
|--------------------------------------------------------------------------
| Web proxy.
*/
$config['http_proxy'] = 'wwwcache.open.ac.uk:80';


/*
|--------------------------------------------------------------------------
| Data directory (required/all).
*/
$config['data_dir'] = '/var/www/_ouplayer_data/';
#$config['data_dir'] = 'C:/Users/NAME/workspace/_ouplayer_data/';


/*
|--------------------------------------------------------------------------
| Podcast Media Player data-feed (or DB) configuration (required).
*/
// If TRUE (default), use the feed model, otherwise, use the database model (requires a config/database.php file).
$config['podcast_data_use_feed'] = true;

// Required/Podcast. Required for feed access model - the default.
$config['podcast_feed_url_pattern'] =
    "http://example.org/feeds/__COLLECTION_ID__/rss2-extended.xml";


/*
|--------------------------------------------------------------------------
| Podcast Player other configuration.
*/
// Placeholder image for private/intranet-only podcasts etc.
$config['player_restricted_poster_url'] = '/themes/ouplayer_base/pix/locked-video-background-v1.png';
#$config['player_restricted_poster_url'] = '/themes/ouplayer_base/pix/embossed-video-background-s1-3-v0.png';

// Optional/Podcast. One of NULL, 'iframe' or 'jquery-oembed' (default: NULL)
$config['player_embed_code'] = NULL;

// Optional/ OU-embed only.
//$config['player_oembed_endpoint'] = 'http://mediaplayer.open.ac.uk/oembed';

// (Alternative/Podcast. Required for database access model. No trailing '/')
//$config['podcast_media_base'] = 'http://example.org/feeds';


/*
|--------------------------------------------------------------------------
| OUVLE Player configuration.
*/
// Optional/VLE: regular expression for media_url, for OUVLE and OpenLearn players.
// If used, must contain (ext1|ext2..) as the second matching group.
//$config['media_url_regex'] = '/.open.ac.uk(\:\d+)?\/.*\.(mp4|m4v|flv|mp3)[\/\?]?/'; //No '$' at the end.

// Required/VLE/experimental: array of names of session cookies to pass on for caption/subtitle proxy requests (Bug #1334).
//$config['httplib_proxy_cookies'] = array('cookiename1', 'cookiename2', '..');


/*
|--------------------------------------------------------------------------
| General OU Player configuration
*/
// Either NULL, 'ender' (maybe for OUVLE?) or 'jquery' (maybe for Podcast?)
// NULL is preferred - it lets Mejs_Default_Theme::prepare_jslib() decide.
//$config['jslib'] = NULL;


/*
|--------------------------------------------------------------------------
| OU-embed configuration.
*/
// Debugging/OU-embed: always make requests to upstream servers.
$config['always_upstream'] = true;

// Experimental.
$config['cache_minutes'] = false; //10;

// Experimental.
$config['player_scripts_compress'] = false;

// NEW! OU Sharepoint NTLM (LDAP) account.
#$config['http_sharepoint_userpwd'] = 'open-university\[UNIT]-cluster:[PASSWORD]';

// Key for Embed.ly API (free for oEmbed/ Pass. Gorilla: iet-embed@ou)
$config['embedly_api_key'] = false; //'04..7';

// Optional/Experimental.
$config['flowplayer_dev'] = false;

// Flowplayer commercial license key.
$config['flowplayer_key'] = '#$0...5';
$config['flowplayer_version'] = '3.2.7';

// HTML5 audio/video fallback, see http://wiki.whatwg.org/wiki/Video_type_parameters
//Was: $config['ouplayer_video_codec'] = 'avc1.42E01E, mp4a.40.2';
//$config['ouplayer_video_type'] = 'type=\'video/mp4; codecs="avc1.42E01E, mp4a.40.2"\'';

// Optional. Use if Git is not in the PATH variable.
//$config['git_path'] = "/usr/local/git/bin/git";  #Mac OS X

// Optional. Set the path to the pdftohtml binary (not required on Redhat 6).
#$config['pdftohtml_path'] = $config['data_dir'].'pdftohtml-0.39/pdftohtml.exe';


/*
|--------------------------------------------------------------------------
| OU Player user documentation.
*/
//
$player_docs_google = 'https://docs.google.com/document/pub?id=1gcxecBs7n4snPKmQnguBytVZpGdkcjl2GqfGUz-pCOc';
$config['player_docs'] = array(
  'help' => FALSE,   #"$player_docs_google#id.j2um0zpktyo1",
  'about'=> '__SITE__/about', #"$player_docs_google#id.mi4tst6i0wac",
  'embed'=> FALSE,   #"$player_docs_google#id.9xoj8o7ev1d5",
);


/*
|--------------------------------------------------------------------------
| OU Player themes.
*/
$config['player_default_theme'] = 'oup-light';
$config['player_mobile_theme'] = 'mejs-default';

$config['player_themes'] = array(
  // 'New' 2012 Mediaelement-based themes.
  'mejs-default' => true,
  'ouplayer-base' => true,
  'oup-light' => true,

  // Legacy 2011 Flowplayer-based themes.
  // Experimental: 'menu' flag - make themes appear in Opera/Firefox Page/'View' > Style menu.
  'basic' => array('styles'=>null, 'view'=>'ouplayer/player_noscript'),
  'core'  => array('styles'=>null),
  'ouice-dark'=>array('title'=>_('OUICE Dark'), 'styles'=>'ouplayer/ouice-dark/ouice-dark.css', '--menu'=>1),
  'ouice-bold'=>array('title'=>_('OUICE Bold'), 'styles'=>'ouplayer/ouice-bold/ouice-bold.css'),
  'ouice-light'=>array('title'=>_('OUICE Light'), 'styles'=>'ouplayer/ouice-light/ouice-light.css', '--menu'=>1),
);


// Captions pre-DB solution - Mental health (S.D.Price@open), http://podcast.open.ac.uk/podcast_items.php?id=1135
$config['captions'][1135] = array(
  '734418f016' => 'difficult-to-manage-symptoms.xml',
  '15f2d28221' => 'how-much-support-should-you-provide.xml',
  'cb8d04e320' => 'memory-concentration-and-organisation.xml',
  '6587f3126c' => 'recognising-barriers.xml',
  '42b612d044' => 'social-difficulties-and-peer-support.xml',
  'ee86f9b7fb' => 'what-support-is-available.xml',
);


/*
|--------------------------------------------------------------------------
| Localization/ internationalization, including 'aliases' (all)
*/
$config['locales'] = array(
    # Keys must be lower-case, using '-'.
    # Order is significant - 'en'+aliases must be last.
    'es'   => array('name'=>'Español - España/Internacional'),
    'es-ar'=> 'es',
    'es-es'=> 'es',
    'es-mx'=> 'es',

    'fr'   => array('name'=>'Français/ French'),
    'fr-ca'=> 'fr',

    'zh-cn'=> array('name'=>'简体中文/ Chinese (Simplified)'),
    'cmn-hans'=>'zh-cn',

    'sw'   => array('name'=>'Kiswahili/ Swahili'),

    'en-gb' => array('name'=>'English - British'),
    'en'   => array('name'=>'English - United States (Int)/ En anglais/ Inglés'),
    'en-us'=> 'en',

    /* Hmm, are these more similar to GB or US English? (http://screenfont.ca/learn/)
	'en-za' => 'en', # S.Africa
    'en-au' => 'en', # Australia
    ... */
);


/* File: config.php
..
$config['log_path'] = '/var/www/_ouplayer_data/logs/';
..
$config['cache_path'] = '/var/www/_ouplayer_data/cache/';
*/

#End.
