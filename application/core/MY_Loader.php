<?php
/**
 * Extend the CI Loader class, so that it handles player themes.
 *
 * @copyright Copyright 2012 The Open University.
 * @author N.D.Freear, 20 March 2012.
 */

class MY_Loader extends CI_Loader {

  protected $my_ci;

  /** Load a theme.php class/configuration file.
  */
  public function theme($theme_name) {
    $theme_name = str_replace('-', '_', $theme_name);

    $this->file(APPPATH. "/themes/$theme_name/theme.php");
    #require_once APPPATH ."/themes/$theme_name/theme.php";

    $classname = $theme_name .'_Theme';

    $this->my_ci =& get_instance();
    $this->my_ci->theme = new $classname();

    #$this->_ci_view_paths = array_merge($this->_ci_view_paths, array("../themes/$theme_name" => TRUE));
    #$this->add_package_path(APPPATH .'/themes/'. $theme_name);
    #$this->add_package_path(APPPATH .'/themes/'. $this->my_ci->theme->parent);
  }

  /** Load a view file from the theme or parent theme directory.
  */
  public function theme_view($view=null, $vars=array(), $return=false) {
  	$view = $view ? $view : $this->my_ci->theme->view;

    $view_file = 'themes/'. $this->my_ci->theme->name ."/views/$view.php";
    if (file_exists(APPPATH .$view_file)) {
      return $this->view('../'. $view_file, $vars, $return);
    }
    return $this->view('../themes/'. $this->my_ci->theme->parent ."/views/$view", $vars, $return);
  }
}
