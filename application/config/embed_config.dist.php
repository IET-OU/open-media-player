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

// Set the data directory.
$config['data_dir'] = '/var/www/_ouplayer_data/';
#$config['data_dir'] = 'C:/Users/ndf42/workspace/_ouplayer_data/';

// Optionally, set the path to a pdftohtml binary executable (not req. on Redhat 6).
#$config['pdftohtml_path'] = $config['data_dir'].'pdftohtml-0.39/pdftohtml.exe';

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

// Localization/ internationalization.
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
