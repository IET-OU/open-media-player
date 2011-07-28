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
$config['debug'] = false;

// Debugging: always make requests to upstream servers.
$config['always_upstream'] = true;

// Flowplayer commercial license key.
$config['flowplayer_key'] = '#$0...5';
$config['flowplayer_version'] = '3.2.7';

/*$config['flowplayer_key'] = '#$a...c';
$config['flowplayer_version'] = '3.1.5';*/

// HTML5 audio/video fallback, see http://wiki.whatwg.org/wiki/Video_type_parameters
//Was: $config['ouplayer_video_codec'] = 'avc1.42E01E, mp4a.40.2';
//$config['ouplayer_video_type'] = 'type=\'video/mp4; codecs="avc1.42E01E, mp4a.40.2"\'';

// Set the data directory.
$config['data_dir'] = '/var/www/_ouplayer_data/';
#$config['data_dir'] = 'C:/Users/ndf42/workspace/_ouplayer_data/';

// Optionally, set the path to a pdftohtml binary executable (not required on Redhat 6).
#$config['pdftohtml_path'] = $config['data_dir'].'pdftohtml-0.39/pdftohtml.exe';

// Which embed providers are live on this server?
$config['providers_local'] = array(
  'podcast.open.ac.uk'
);

$player_docs_google = 'https://docs.google.com/document/pub?id=1gcxecBs7n4snPKmQnguBytVZpGdkcjl2GqfGUz-pCOc';
$config['player_docs'] = array(
  'help' => "$player_docs_google#id.j2um0zpktyo1",
  'about'=> "$player_docs_google#id.mi4tst6i0wac",
  'embed'=> "$player_docs_google#id.9xoj8o7ev1d5",
);

// OU Player themes.
$config['player_themes'] = array(
  'basic' => array('styles'=>null, 'view'=>'ouplayer/player_noscript'),
  'core'  => array('styles'=>null),
  'ouice-dark'=>array('title'=>'OUICE Dark', 'styles'=>'ouplayer/ouice-dark/ouice-dark.css'),
  'ouice-bold'=>array('title'=>'OUICE Bold', 'styles'=>'ouplayer/ouice-bold/ouice-bold.css'),
  'ouice-light'=>array('title'=>'OUICE Light', 'styles'=>'ouplayer/ouice-light/ouice-light.css'),
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

// Localization/ internationalization, including aliases.
$config['locales'] = array(
    'es'   => array('name'=>'Español - España/Internacional'),
    'es-ar'=> 'es',
    'es-es'=> 'es',
    'es-mx'=> 'es',

    'fr'   => array('name'=>'Français/ French'),
    'fr-ca'=> 'fr',

    'zh-cn'=> array('name'=>'简体中文/ Chinese (Simplified)'),
    'cmn-hans'=>'zh-cn',

    'en'   => array('name'=>'English/ En anglais/ Inglés'),
    'en-gb'=> 'en',
    'en-us'=> 'en',
);

#End.
