<?php
/**
 * Extend the CI Loader class, so that it handles Player themes, and oEmbed providers.
 *
 * @copyright Copyright 2012 The Open University.
 * @author N.D.Freear, 20 March 2012.
 */

class MY_Loader extends CI_Loader
{
    protected $my_ci;

    public function __construct()
    {
        parent::__construct();

        $this->my_ci =& get_instance();

        if ($this->my_ci->use_composer()) {
            require_once __DIR__ .'/../../vendor/autoload.php';
        }
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
        $classname = $this->dev_ucwords($theme_name) . '_Theme';
        $theme_path = str_replace('-', '_', $theme_name);
        $theme_path = APPPATH . "/themes/$theme_path/theme.php";

        var_dump($classname, $theme_path);

        //$this->file(APPPATH. "/themes/$theme_path/theme.php");
        require_once $theme_path;

        $this->my_ci->theme = new $classname();

      #$this->_ci_view_paths = array_merge($this->_ci_view_paths, array("../themes/$theme_name" => TRUE));
      #$this->add_package_path(APPPATH .'/themes/'. $theme_name);
      #$this->add_package_path(APPPATH .'/themes/'. $this->my_ci->theme->parent);
    }

    /** Load a view file from the theme or parent theme directory.
    */
    public function theme_view($view = null, $vars = array(), $return = false)
    {
        $view_file = $this->my_ci->theme->getView($view);

        if (file_exists(APPPATH . $view_file .'.php')) {
            return $this->view('../'. $view_file, $vars, $return);
        }
        return $this->view('../'. $this->my_ci->theme->getParentView($view), $vars, $return);
    }


    /** Load an oEmbed provider class.
    * @return void
    */
    public function oembed_provider($provider_name, $object_name = 'provider')
    {
        if (!$this->my_ci->use_composer() && !class_exists('Oembed_Provider')) {
          // Require the base provider class file.
            $this->file(APPPATH .'/libraries/Oembed_Provider.php');
        }

      // If appropriate, include intermediate class file...


        if ($this->has_namespace($provider_name)) {
            return new $provider_name();
        }
      // Simplify lines like, $regex = $this->{"{$name}_serv"}->regex;
        return $this->library("providers/{$provider_name}_serv", null, $object_name);
    }


    protected function dev_ucwords($str)
    {
        $result = preg_replace_callback('/([\-_])([a-z])/', function($m) {
            return strtoupper($m[ 1 ] . $m[ 2 ]);
        }, $str);
        return ucwords(str_replace('-', '_', $result));
    }

    protected function has_namespace($class)
    {
        return false !== strpos($class, '\\');
    }
}
