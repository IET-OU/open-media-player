<?php defined('BASEPATH') or exit('No direct script access allowed');
/**
|--------------------------------------------------------------------------
| Open Media Player - site configuration file.
|--------------------------------------------------------------------------
*/

$config[ 'site_layout' ] = 'ouice';

//$config[ 'auth_class' ] = '\\Slim\\Middleware\\HttpBasicAuthentication';
$config[ 'auth_class' ] = '\\IET_OU\\Open_Media_Player\\Sams_Auth';

$config[ 'auth_extra_call' ] = 'is_staff';

$config[ 'auth_localhost_bypass' ] = true;

// See: https://github.com/tuupola/slim-basic-auth#usage
// Note: no need to set 'path', 'realm' or 'error' callback.
$config[ 'auth_basicauth_opts' ] = array(
    "relaxed" => array(),
    "secure" => false,
    "users" => [
        "admin" => "passw0rd"
    ],
);


#End.
