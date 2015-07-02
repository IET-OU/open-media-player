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
$config[ 'auth_basicauth_opts' ] = array(
    //"path" => "/", //"path" => "/ouplayer/admin",
    "realm" => "Media player admin pages",
    "relaxed" => array(),
    "secure" => false,
    "users" => [
        "root" => "t00r",
        "user" => "passw0rd"
    ],
    "error" => function ($arguments) {
        header('HTTP/1.1 401 Unauthorized');
        header(sprintf('WWW-Authenticate: Basic realm="%s"', 'Media player admin pages'));
        echo "<title>Authentication required</title><style>body{font:1.1em sans-serif;margin:2em;}</style>WARNING.\n";
        print_r($arguments);
        exit;
    }
    /*"callback" => function ($arguments) use ($app) {
        print_r($arguments);
    }*/
);


#End.
