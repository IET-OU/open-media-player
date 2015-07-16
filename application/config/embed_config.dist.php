<?php defined('BASEPATH') or exit('No direct script access allowed');
/**
|--------------------------------------------------------------------------
| Open Media Player - GENERIC main configuration file.
|--------------------------------------------------------------------------
*/


/*
|--------------------------------------------------------------------------
| Debugging flag (integer, one of OUP_DEBUG_NONE, OUP_DEBUG_MIN, OUP_DEBUG_MAX).
*/
// See also: 'ENVIRONMENT' defined in ../../index.php
$config['debug'] = OUP_DEBUG_MIN;

// Allow search engine robots to index?
$config['robots'] = FALSE;

/*
|--------------------------------------------------------------------------
| Web proxy.
*/
$config[ 'http_proxy' ]    = null;
$config[ 'http_no_proxy' ] = null;
$config[ 'http_cookie' ]   = array();

/*
|--------------------------------------------------------------------------
| Data directory (required/all).
*/
$config['data_dir'] = __DIR__ .'/../../_data/';

#$config['data_dir'] = '/var/www/_ouplayer_data/';
#$config['data_dir'] = 'C:/Users/[NAME]/workspace/_ouplayer_data/';


/*
|--------------------------------------------------------------------------
| Podcast Media Player data-feed (or database) configuration (required).
*/
// If TRUE (default), use the feed model, otherwise, use the database model (requires a config/database.php file).
$config['podcast_data_use_feed'] = true;

// Required/Podcast. Required for feed access model - the default.
$config['podcast_feed_url_pattern'] =
    "http://podcast.example.org/feeds/__COLLECTION_ID__/rss2-extended.xml";


// SSL/ HTTPS regular expression for `media_url()` helper function - OU Media Player.
$config['https_media_url_regex'] =
    '@https?:\/\/(sub_domain_A|sub_domain_B)\.example\.org)@';


/*
|--------------------------------------------------------------------------
| Podcast Player other configuration.
*/
// Placeholder image for private/intranet-only podcasts etc.
$config['player_restricted_poster_url'] = '/themes/ouplayer_base/pix/locked-video-background-v1.png';

// Optional/Podcast. One of NULL, 'iframe' or 'jquery-oembed' (default: NULL)
$config['player_embed_code'] = NULL;

/*
|--------------------------------------------------------------------------
| General Media Player configuration
*/
// Either NULL, 'ender' (maybe for OUVLE?) or 'jquery' (maybe for Podcast?)
// (NULL was preferred - it lets Mejs_Default_Theme::prepare_jslib() decide.)
$config['jslib'] ='jquery';


// 200 ~ 500 milliseconds.
$config['js_timeout'] = 500;


// Volume keyboard shortcuts - iet-it-bugs:1477 / LTSredmine:6994.
$config['player_js_config'] = array(
  'quieterKey' => '[',
  'louderKey'  => ']',

  // Keyboard accessibility: disable (most) shortcuts?!
  //: engines/mediaelement/js/mep-player.js#L63
  'enableKeyboard' => true,

  // array of keyboard actions such as play pause
  'keyActions' => array(
		array(
			'keys' => array(
				32, // SPACE
				179 // GOOGLE play/pause button
			),
			'action' => 'function (player, media) {'."\n"
			.'	if (media.paused || media.ended) {' ."\n"
			.'		media.play();' ."\n"
			.'	} else {' ."\n"
			.'		media.pause();' ."\n"
			.'	}' .PHP_EOL
            .'}'
		)
	),

  /* LtsRedmine:7911 - true, false or "ie" */
  'fsHoverAltButton' => 'ie',
);


/*
|--------------------------------------------------------------------------
| OU-embed configuration.
*/
// Debugging/OU-embed: always make requests to upstream servers.
$config['always_upstream'] = true;

// Experimental (10)
$config['cache_minutes'] = false;

// Experimental.
$config['player_scripts_compress'] = false;


#$config['google_analytics'] = 'UA-24005173-1';


// NEW! OU Sharepoint NTLM (LDAP) account.
#$config['http_sharepoint_userpwd'] = '[auth-domain]\[auth-ID]:[PASSWORD]';

// Key for Embed.ly API.
$config['embedly_api_key'] = false; //'04..7';

// Optional/Experimental.
$config['flowplayer_dev'] = false;

// Flowplayer commercial license key.
$config['flowplayer_key'] = '#$0...5';
$config['flowplayer_version'] = '3.2.7';

// HTML5 audio/video fallback, see http://wiki.whatwg.org/wiki/Video_type_parameters
//Was: $config['ouplayer_video_codec'] = 'avc1.42E01E, mp4a.40.2';
//$config['ouplayer_video_type'] = 'type=\'video/mp4; codecs="avc1.42E01E, mp4a.40.2"\'';

// Optional. Set the path to the pdftohtml binary (not required on Redhat 6).
#$config['pdftohtml_path'] = $config['data_dir'].'pdftohtml-0.39/pdftohtml.exe';


/*
|--------------------------------------------------------------------------
| Open Media Player user documentation.
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
| Open Media Player themes.
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


/*
|--------------------------------------------------------------------------
| YouTube - create you server API key at, https://console.developers.google.com
*/
$config[ 'youtube_api_key' ]= ' ** EDIT ME **';


#End.
