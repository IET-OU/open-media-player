<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * An abstract theme from which to extend OU Media Player themes or skins.
 *
 * @copyright Copyright 2012 The Open University.
 * @author N.D.Freear, 20 March 2012.
 */

// Based on (private): https://gist.github.com/08e20a98136289bbd7ec
abstract class Player_Theme {

  public $name;    // The short theme name, used internally (auto-generated from class name).
  #public $type = 'player';
  public $parent;  // Parent theme name (auto-generated).
  public $display; // A longer display name.
  public $view;    // The name of the main view file, without '.php'
  public $engine;  // The player engine, one of 'mediaelement' or 'flowplayer'.

  public $styles;   // An ordered array of stylesheets (for building/ debug).
  public $css_min;  // 'The' single compressed stylesheet for the theme (live).
  public $js_min;   // 'The' single concatenated, minified Javascript (live).
  public $js_path;  // Path to individual, raw Javascripts.
  public $javascripts; // An ordered array of raw Javascripts (build/ debug).
  public $plugin_path; // Path to Flash/ Silverlight plugins.
  public $builder;  // File-path for a build script.

  protected $CI;


  /** Constructor: auto-generate 'name' and 'parent' properties.
  */
  public function __construct() {
    $this->CI =& get_instance();

    // We use $this - an instance, not a class.
    $this->name = strtolower(preg_replace('#_Theme$#i', '', get_class($this)));
    $this->parent = strtolower(preg_replace('#_Theme$#i', '', get_parent_class($this)));
  	#$this->name = dirname(__FILE__);
	#echo __FILE__;
	#echo $this->parent;
  }

  /** Get the machine-readable name for the Scripts controller.
  * @return string
  */
  public function getName() { return $this->name; }

  /** Get the theme display name.
  * @return string
  */
  public function getDisplayname() { return $this->display; }

  /** Get a path to a theme view (relative to application/ directory, without '.php').
  * @return string
  */
  public function getView($view = NULL) {
    return 'themes/'. $this->getName() .'/views/'. ($view ? $view : $this->view);
  }

  /** Get a path to a view for the parent theme.
  */
  public function getParentView($view = NULL) {
    return 'themes/'. $this->parent .'/views/'. ($view ? $view : $this->view);
  }


  /** Prepare: initialize features of the theme, given a player object (was abstract).
  */
  public function prepare(& $player) {
    if (! is_subclass_of($player, 'Base_player')) {
      die('Error, not a valid player object, '.__CLASS__);
    }
  }


  /** Get a configuration item, set a default if it doesn't exist.
  */
  public function config_option($name, $default = NULL) {
    $cfg = $this->CI->config;
    return $cfg->item($name) ? $cfg->item($name) : $default;
  }
}

