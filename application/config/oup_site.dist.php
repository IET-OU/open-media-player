<?php defined('BASEPATH') or exit('No direct script access allowed');
/**
|--------------------------------------------------------------------------
| Open Media Player - site configuration file.
|--------------------------------------------------------------------------
*/

//$config[ 'auth_class' ] = '\\Slim\\Middleware\\HttpBasicAuthentication';
$config[ 'auth_class' ] = '\\IET_OU\\Open_Media_Player\\Sams_Auth';

$config[ 'auth_extra_call' ] = 'is_staff';

$config[ 'auth_localhost_bypass' ] = true;

// See: https://github.com/tuupola/slim-basic-auth#usage
$config[ 'auth_basicauth_opts' ] = array(
    "path" => "/", //"path" => "/ouplayer/admin",
    "realm" => "Protected",
    "secure" => false,
    "users" => [
        "root" => "t00r",
        "user" => "passw0rd"
    ],
    /*"callback" => function ($arguments) use ($app) {
        print_r($arguments);
    }*/
);

$config[ 'site_layout' ] = 'ouice';


#End.
