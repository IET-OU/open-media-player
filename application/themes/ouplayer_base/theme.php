<?php
/** OU Player base theme.
 *
 * @copyright Copyright 2012 The Open University.
 * @author N.D.Freear, 20 March 2012.
 */
require_once dirname(__FILE__) .'/../mejs_default/theme.php';


class Ouplayer_Base_Theme extends Mejs_Default_Theme {

  public $display = 'OU Player base theme';
  public $view = 'ou-me-player';

  public $features =
'oup_titlepanel,oup_playpause,oup_progress,current,duration,oup_volume,tracks,oup_transcript,oup_quality,oup_popout,fullscreen,oup_options,oup_shim,oup_tooltip,oup_fullscreenhover';


  public function __construct() {
    parent::__construct();

    $meps_base = $this->js_path; #From parent.
    $oups_base = 'themes/$this->name/js/';

    $mep_scripts = array(
      $oups_base.'mep-header-cl.js',
    # Mediaelement libraries.
      $meps_base.'me-namespace.js',
      $meps_base.'me-utility.js',
      $meps_base.'me-plugindetector.js',
      $meps_base.'me-featuredetection.js',
      $meps_base.'me-mediaelements.js',
      $meps_base.'me-shim.js',
    # Mediaelement player libraries.
      $meps_base.'mep-library.js',
      $meps_base.'mep-player.js',
      $meps_base.'mep-feature-time.js',
      $meps_base.'mep-feature-volume.js',
      $meps_base.'mep-feature-fullscreen.js',
      $meps_base.'mep-feature-tracks.js',
      $meps_base.'mep-feature-googleanalytics.js',
    # OU Player extensions.
      $oups_base.'mep-oup-header.js',
      $oups_base.'mep-oup-feature-shim.js',
      $oups_base.'mep-oup-feature-playpause.js',
      $oups_base.'mep-oup-feature-progress.js',
      $oups_base.'mep-oup-feature-volume.js',
      $oups_base.'mep-oup-feature-postmessage.js',
      $oups_base.'mep-oup-feature-popout.js',
      $oups_base.'mep-oup-feature-transcript.js',
      $oups_base.'mep-oup-feature-quality.js', # High-def.
      $oups_base.'mep-oup-feature-options.js',
      $oups_base.'mep-oup-feature-title.js',

      //$oups_base.'mep-oup-feature-tooltip.js',
      //$oups_base.'mep-oup-feature-fullscreenhover.js', #Experimental!
    );
  }
}
