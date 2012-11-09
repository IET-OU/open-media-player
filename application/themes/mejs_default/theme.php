<?php
/**
 * Mediaelement.js default theme.
 *
 * A thin PHP wrapper around John Dyer's Mediaelement library.
 * @link http://mediaelementjs.com/
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

  public $jslib;     // Name of the Javascript framework/ library, one of 'ender' or 'jquery' - see 'prepare_jslib()' below.
  public $features;  // Comma-separated list of Javascript features (or null for the default Mediaelement features).


  public function __construct() {
    parent::__construct();

	$engine_path = "engines/$this->engine/";
	$build_path = $engine_path .'build/';

    //$this->view = dirname(__FILE__).'/views/mep-player.php'; //'themes/mejs/views/'
    $this->styles[]  = $build_path . 'mediaelementplayer.min.css';
    $this->css_min = $build_path . 'mediaelementplayer.min.css';
    $this->js_min  = $build_path . 'mediaelement-and-player.min.js';
    $this->js_path = $engine_path . 'src/js/';
    $this->plugin_path = $build_path;
    $this->builder = $engine_path . 'src/Builder.py';
    #$this->features = array(); #'playpause,current,progress,duration,tracks,volume,fullscreen', #(See mep-player.js)

    $meps_base = $this->js_path;

    $this->javascripts = array(
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

  public function prepare(& $player) {
    parent::prepare($player);

    return $this->prepare_jslib($player);
  }

  /** Decide whether to use 'Ender' or 'jQuery' Javascript (no-)library.
   *  Call after Podcast_items_model::get_item, with player-parameter object.
   */
  protected function prepare_jslib(& $player) {
    $this->jslib = $this->CI->input->get('jslib');
    if (! $this->jslib) {
      $this->jslib = $this->CI->config->item('jslib');
    }

    if ($this->CI->agent->is_browser('MSIE') || $this->CI->agent->is_mobile()) {
      // Safer for MSIE 8 - is it? (Fullscreen hover JS feature.)
      $this->jslib = 'jquery';
    }
    // At present, Ender can't parse a captions track ("Full support for Ender.js.." is in the Mediaelement readme).
    if ('ender' == $this->jslib) {
      $player->caption_url = null;
    }
    elseif (! $this->jslib && $player->caption_url) {
      $this->jslib = 'jquery';
    }
  }
}
