<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/** Configuration: OU player/ embed.
 *
 * @copyright Copyright 2011 The Open University.
 */

// Set a HTTP proxy.
putenv('http_proxy=wwwcache.open.ac.uk:80');
$config['http_proxy'] = 'wwwcache.open.ac.uk:80';

// Prevent date/ timezone warnings.
date_default_timezone_set('Europe/London');

// Debugging.
$config['debug'] = OUP_DEBUG_NONE;

// Required/Podcast. If TRUE, use the feed model, otherwise, use the database model (requires a config/database.php file).
$config['podcast_data_use_feed'] = true;

// Required/Podcast. Required for feed access model - the default.
$config['podcast_feed_url_pattern'] =
    "http://example.org/feeds/__COLLECTION_ID__/rss2-extended.xml";

// (Removed/Podcast. The name of the remote RSS feed file.)
//$config['podcast_feed_file'] = '';

// (Alternative/Podcast. Required for database access model. No trailing '/')
//$config['podcast_media_base'] = 'http://example.org/feeds';

// Optional/VLE: regular expression for media_url, for OUVLE and OpenLearn players.
// If used, must contain one (ext1|ext2..) group.
//$config['media_url_regex'] = '/.open.ac.uk\/.*\.(mp4|m4v|flv|mp3)$/';

// Required/VLE/experimental: array of names of session cookies to pass on for caption/subtitle proxy requests (Bug #1334).
//$config['httplib_proxy_cookies'] = array('cookiename1', 'cookiename2', '..');

// Either NULL, 'ender' (maybe for OUVLE?) or 'jquery' (maybe for Podcast?)
// NULL is preferred - it lets Mejs_Default_Theme::prepare_jslib() decide.
//$config['jslib'] = NULL;

// NEW! A placeholder image for intranet-only podcasts etc.
#$config['player_restricted_poster_url'] = '/themes/ouplayer_base/pix/embossed-video-background-s1-3-v0.png';
$config['player_restricted_poster_url'] = '/themes/ouplayer_base/pix/locked-video-background-v1.png';

// Optional/Podcast. One of NULL, 'iframe' or 'jquery-oembed' (default: NULL)
$config['player_embed_code'] = NULL;

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

/*$config['flowplayer_key'] = '#$a...c';
$config['flowplayer_version'] = '3.1.5';*/

// HTML5 audio/video fallback, see http://wiki.whatwg.org/wiki/Video_type_parameters
//Was: $config['ouplayer_video_codec'] = 'avc1.42E01E, mp4a.40.2';
//$config['ouplayer_video_type'] = 'type=\'video/mp4; codecs="avc1.42E01E, mp4a.40.2"\'';

// Required/All. Set the data directory.
$config['data_dir'] = '/var/www/_ouplayer_data/';
#$config['data_dir'] = 'C:/Users/ndf42/workspace/_ouplayer_data/';

// Optional. Use if Git is not in the PATH variable.
//$config['git_path'] = "/usr/local/git/bin/git";  #Mac OS X

// Optional. Set the path to the pdftohtml binary (not required on Redhat 6).
#$config['pdftohtml_path'] = $config['data_dir'].'pdftohtml-0.39/pdftohtml.exe';

// Which embed providers are live on this server?
$config['providers_local'] = array(
  'podcast.open.ac.uk'
);

// OU Player user documentation.
$player_docs_google = 'https://docs.google.com/document/pub?id=1gcxecBs7n4snPKmQnguBytVZpGdkcjl2GqfGUz-pCOc';
$config['player_docs'] = array(
  'help' => FALSE,   #"$player_docs_google#id.j2um0zpktyo1",
  'about'=> '__SITE__/about', #"$player_docs_google#id.mi4tst6i0wac",
  'embed'=> FALSE,   #"$player_docs_google#id.9xoj8o7ev1d5",
);

// OU Player themes.
$config['player_default_theme'] = 'oup-light';

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


/* File: config.php

$config['log_path'] = '/var/www/_ouplayer_data/logs/';

$config['cache_path'] = '/var/www/_ouplayer_data/cache/';

*/

// Localization/ internationalization, including 'aliases'.
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

#End.
