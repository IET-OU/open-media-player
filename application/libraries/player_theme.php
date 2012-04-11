<?php
/** An abstract theme from which to extend OU Media Player themes or skins.
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

  public $styles;   // The stylesheet (Todo: an array)
  public $js_file;  // 'The' single concatenated, minified Javascript (live).
  public $js_path;  // Path to individual, raw Javascripts.
  public $javascripts; // Array of raw Javascripts (debug).
  public $plugin_path; // Path to Flash/ Silverlight plugins.
  public $builder;  // File-path for a build script.

  /** Constructor: auto-generate 'name' and 'parent' properties.
  */
  public function __construct() {
    // We use $this - instance, not class.
  	$this->name = preg_replace('#_Theme$#i', '', get_class($this));
  	$this->parent = get_parent_class($this);
  	#$this->name = dirname(__FILE__);
	#echo __FILE__;
	#echo $this->parent;
  }
}

