<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/** Configuration: OU player/ embed.
 *
 * @copyright Copyright 2011 The Open University.
 */

// Set a HTTP proxy.
putenv('http_proxy=wwwcache.open.ac.uk:80');

// Prevent date/ timezone warnings.
date_default_timezone_set('Europe/London');

// Debugging: always make requests to upstream servers.
$config['always_upstream'] = true;

// Set the data directory.
$config['data_dir'] = '/var/www/_ouplayer_data/';
#$config['data_dir'] = 'C:/Users/ndf42/workspace/_ouplayer_data/';

// Optionally, set the path to a pdftohtml binary executable (not req. on Redhat 6).
#$config['pdftohtml_path'] = $config['data_dir'].'pdftohtml-0.39/pdftohtml.exe';



/* File: config.php

$config['log_path'] = '/var/www/_ouplayer_data/logs/';

$config['cache_path'] = '/var/www/_ouplayer_data/cache/';

*/

#End.
