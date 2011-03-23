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

