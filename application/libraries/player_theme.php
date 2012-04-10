<?php
/** An abstract theme from which to extend Player themes or skins.
 *
 * @copyright Copyright 2012 The Open University.
 * @author N.D.Freear, 20 March 2012.
 */

// Based on (private): https://gist.github.com/08e20a98136289bbd7ec
abstract class Player_Theme {

  public $name;
  #public $type = 'player';
  public $parent;
  public $display;
  public $view;
  public $engine;

  public $styles;
  public $js_file;
  public $js_path;
  public $plugin_path;
  public $builder;
  public $features;

  public function __construct() {
  	$this->name = preg_replace('#_Theme$#i', '', get_class($this));
  	$this->parent = get_parent_class($this);
  	#$this->name = dirname(__FILE__);
  	echo $this->parent;
  }
}

