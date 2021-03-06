<?php defined('BASEPATH') or exit('No direct script access allowed');
/**
 * Part of Open Media Player.
 *
 * @license   http://gnu.org/licenses/gpl.html GPL-3.0+
 * @copyright Copyright 2011-2015 The Open University (IET) and contributors.
 * @link      http://iet-ou.github.io/open-media-player
 */

/**
 * Extend the CI Loader class, so that it handles Player themes, and oEmbed providers.
 *
 * @copyright Copyright 2012 The Open University.
 * @author N.D.Freear, 20 March 2012.
 */

class MY_Loader extends CI_Loader
{
    protected $CI;

    public function __construct()
    {
        parent::__construct();

        $this->CI =& get_instance();

        if ($this->CI->use_composer()) {
            if (! file_exists(__DIR__ . '/../../vendor/autoload.php')) {
                @header('HTTP/1.1 500');
                ?><title>500 Internal Server Error</title> <p>Error. Missing 'vendor' directory.
            <?php
                exit(1);
                // OR: $this->CI->_error("Missing 'vendor' directory.", 500);
            }
            require_once __DIR__ .'/../../vendor/autoload.php';
        }

        // Allow views to be loaded via absolute paths too - neat! [Bug: #21]
        $this->_ci_view_paths[ '' ] = true;

        log_message('debug', "MY_Loader Class Initialized");
    }

    /** Called within the oEmbed provider's view to render the response.
    */
    public function send_oembed_response($view_data)
    {
        return $this->view(\IET_OU\Open_Media_Player\Oembed_Provider::getRenderer(), $view_data);
        //return $this->load->view(..);
    }

    /**
  * Class Loader
  * This function lets users load and instantiate classes.
  * @return    void
  */
    public function library($library = '', $params = null, $object_name = null)
    {
        $lib_register = array(
            '_Gitlib' => 'git',
            '_Sams_Auth' => 'auth',
        );
        if (!$object_name && isset($lib_register[$library])) {
            $object_name = $lib_register[$library];
        }

        if ($this->has_namespace($library)) {
            return new $library;
        }
        return parent::library($library, $params, $object_name);
    }

    /** Load a theme.php class/configuration file.
    */
    public function theme($theme_name)
    {
        if ($this->CI->use_composer()) {
            $plugins = new \IET_OU\Open_Media_Player\Plugin_Finder();
            $themes = $plugins->get_player_themes();

            $theme_name = str_replace('-', '_', $theme_name);
            if (isset($themes[ $theme_name ])) {
                $this->CI->theme = new $themes[ $theme_name ] ();
            } else {
                $this->CI->theme = new $themes[ $this->CI->config->item('player_default_theme') ] ();
            }

        } else {
            $classname = $this->dev_ucwords($theme_name) . '_Theme';
            $theme_path = str_replace('-', '_', $theme_name);

            $theme_path = APPPATH . "/themes/$theme_path/theme.php";

            require_once $theme_path;

            $this->CI->theme = new $classname();
        }

      #$this->_ci_view_paths = array_merge($this->_ci_view_paths, array("../themes/$theme_name" => TRUE));
      #$this->add_package_path(APPPATH .'/themes/'. $theme_name);
      #$this->add_package_path(APPPATH .'/themes/'. $this->CI->theme->parent);

        return $this->CI->theme;
    }

    /** Load a view file from the theme or parent theme directory.
    */
    public function theme_view($view = null, $vars = array(), $return = false)
    {
        $view_file = $this->CI->theme->getView($view);
        $parent_view = $this->CI->theme->getParentView($view);

        // Try absolute paths first.
        if (file_exists($view_file . '.php')) {
            return $this->view($view_file, $vars, $return);

        } elseif (file_exists($parent_view . '.php')) {
            return $this->view($parent_view, $vars, $return);

        } elseif (file_exists(APPPATH . $view_file .'.php')) {
            // .. Then (legacy) relative paths.
            return $this->view('../'. $view_file, $vars, $return);
        }
        return $this->view('../'. $parent_view, $vars, $return);
    }


    /** Load an oEmbed provider class.
    * @return void
    */
    public function oembed_provider($provider_name, $object_name = 'provider')
    {
        if (!$this->CI->use_composer() && !class_exists('Oembed_Provider')) {
            // Require the base provider class file.
            $this->file(APPPATH .'/libraries/Oembed_Provider.php');
        }

      // If appropriate, include intermediate class file...


        if ($this->has_namespace($provider_name)) {
            $this->CI->provider = new $provider_name ();
            return $this->CI->provider;
        }
      // Simplify lines like, $regex = $this->{"{$name}_serv"}->regex;
        return $this->library("providers/{$provider_name}_serv", null, $object_name);
    }


    protected function dev_ucwords($str)
    {
        $result = preg_replace_callback('/([\-_])([a-z])/', function ($m) {
            return strtoupper($m[ 1 ] . $m[ 2 ]);
        }, $str);
        return ucwords(str_replace('-', '_', $result));
    }

    protected function has_namespace($class)
    {
        return false !== strpos($class, '\\');
    }
}
