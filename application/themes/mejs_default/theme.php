<?php
/** Mediaelement.js default theme.
 *
 * @copyright Copyright 2012 The Open University.
 * @author N.D.Freear, 20 March 2012.
 */
require_once APPPATH .'/libraries/player_theme.php';


class Mejs_Default_Theme extends Player_Theme {

  public $display = 'Mediaelement.js default theme';
  public $view = 'meplayer';
  public $type = 'player';
  public $engine = 'mediaelement';


  public function __construct() {
    //parent::__construct();

	$engine_path = "engines/$this->engine/";
	$build_path = $engine_path .'build/';

	//$this->view = dirname(__FILE__).'/views/mep-player.php'; //'themes/mejs/views/'
	$this->styles  = $build_path . 'mediaelementplayer.min.css';
    $this->js_file = $build_path . 'mediaelement-and-player.min.js';
    $this->js_path = $engine_path . 'src/js/';
    $this->plugin_path = $build_path;
    $this->builder = $engine_path . 'src/Builder.py';
    #$this->features = array(); #'playpause,current,progress,duration,tracks,volume,fullscreen', #(See mep-player.js)

    $meps_base = $this->js_path;

    $mep_scripts = array(
    # Mediaelement libraries.
      $meps_base.'me-header.js',
      $meps_base.'me-namespace.js',
      $meps_base.'me-utility.js',
      $meps_base.'me-plugindetector.js',
      $meps_base.'me-featuredetection.js',
      $meps_base.'me-mediaelements.js',
      $meps_base.'me-shim.js',
    # Mediaelement player libraries.
      $meps_base.'mep-header.js',
      $meps_base.'mep-library.js',
      $meps_base.'mep-player.js',
      $meps_base.'mep-feature-playpause.js',
      #$meps_base.'mep-feature-stop.js',
      $meps_base.'mep-feature-progress.js',
      $meps_base.'mep-feature-time.js',
      $meps_base.'mep-feature-volume.js',
      $meps_base.'mep-feature-fullscreen.js',
      $meps_base.'mep-feature-tracks.js',
      #$meps_base.'mep-feature-contextmenu.js',
      $meps_base.'mep-feature-googleanalytics.js',
      #$meps_base.'mep-feature-endedhtml.js',
    );
  }
}
