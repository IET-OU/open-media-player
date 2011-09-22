<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There area two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/

$route['default_controller'] = "demo"; #"welcome"
$route['404_override'] = '';

$route['uptime.txt'] = 'uptime';
$route['translate'] = 'localize'; #/template';
$route['translate/po/(:any)'] = 'localize/po/$1';

// Client/plugin Javascript routing.
$route['scripts/jquery.oembed.js'] = 'scripts/jquery_oembed';
#$route['scripts/jquery.oembed.min.js'] = 'scripts/jquery_oembed'; #_jsmin'; #Todo.

// Player Javascript routing.
$route['jsbin/ouplayer.min.js'] = 'scripts/embed_ouplayer_js';
$route['jsbin/ouplayer.min.js/(:any)'] = 'scripts/embed_ouplayer_js/$1';


/* End of file routes.php */
/* Location: ./application/config/routes.php */