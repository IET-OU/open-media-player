<?php defined('BASEPATH') or exit('No direct script access allowed');
/**
|--------------------------------------------------------------------------
| Open Media Player - site configuration file.
|--------------------------------------------------------------------------
*/

// Site layout: 'bare' (or 'ouice_2' - ou-specific)
$config[ 'site_layout' ] = 'bare';

// Authentication - disabled by default, so the (optional) admin pages do not display.

// HTTP Basic Authentication class for admin pages.
#$config[ 'auth_class' ] = '\\Slim\\Middleware\\HttpBasicAuthentication';

// Authentication: ou-specific.
#$config[ 'auth_class' ] = '\\IET_OU\\Open_Media_Player\\Sams_Auth';
#$config[ 'auth_extra_call' ] = 'is_staff';

$config[ 'auth_localhost_bypass' ] = true;

// Slim basic authentication configuration.
// See: https://github.com/tuupola/slim-basic-auth#usage
// Note: no need to set 'path', 'realm' or 'error' callback.
$config[ 'auth_basicauth_opts' ] = array(
    "relaxed" => array(),
    "secure" => false,
    "users" => [
        // ** EDIT ME **
        "admin" => "passw0rd"
    ],
);


#End.
