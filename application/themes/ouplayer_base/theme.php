<?php
/**
 * OU Media Player base theme.
 * This theme extends the Mediaelement default theme, and adds Javascript features and views.
 *
 * @copyright Copyright 2012 The Open University.
 * @author N.D.Freear, 20 March 2012.
 */
require_once dirname(__FILE__) .'/../mejs_default/theme.php';


class Ouplayer_Base_Theme extends Mejs_Default_Theme {

  public $display = 'OU Player base theme';
  public $view = 'ou-me-player';
  public $rgb  = 'ouvle-default-blue';
  public $origin;    // TODO: move! For postMessage security (https://developers.google.com/youtube/player_parameters#origin)
  public $player_embed_code = NULL;

  //iPadUseNativeControls etc.
  public $mobile_native_controls = true;

  public $features =
'oup_shim,oup_titlepanel,oup_playpause,oup_progress,current,duration,oup_group,oup_volume,tracks,oup_transcript,oup_quality,oup_popout,fullscreen,oup_fullscreenhover';
# 'oup_shim,oup_playpause,oup_progress,oup_group,fullscreen'; // Minimal.


  public function __construct() {
    parent::__construct();

    if (! $this->CI->input->is_cli_request()) {
      $this->origin  = $this->CI->agent->referrer();
    }

    // Hmm, $this->name won't be correct in child themes!
    $theme_name = str_replace('_theme', '', strtolower(__CLASS__));

    // Add our OU Player base styles to the array.
    $this->styles[] = "themes/$theme_name/css/ouplayer-base.css";

    // The minified OU Player+mediaelement Javascript/ CSS.
    $this->js_min  = "themes/$theme_name/build/ouplayer-mediaelement.min.js";
    $this->css_min = str_replace('.js', '.css', $this->js_min);


    $meps_base = $this->js_path; #From parent.
    $oups_base = "themes/$theme_name/js/";

    $this->javascripts = array(
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
      $oups_base.'mep-player.js',  # Ender.js fix: 1-line change, NDF 2012-04-17.
      $meps_base.'mep-feature-time.js',
      $meps_base.'mep-feature-volume.js',
      $oups_base.'mep-feature-fullscreen.js', # Group: 1-line change, NDF 2012-03-30.
      $oups_base.'mep-feature-tracks.js',     # Group: 1-line change.
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
      $oups_base.'mep-oup-feature-quality.js', # High-definition.
      $oups_base.'mep-oup-feature-options.js',
      $oups_base.'mep-oup-feature-title.js',

      $oups_base.'mep-oup-feature-tooltip.js', #Experimental!
	  $oups_base.'mep-oup-feature-group.js',
      $oups_base.'mep-oup-feature-fullscreenhover.js', #Experimental!
      $oups_base.'mep-oup-feature-copyembed.js',   #Experimental.
      $oups_base.'mep-oup-feature-ignore-color.js',    # High contrast/ignore colour accessibility fix.
    );
  }


  /** Prepare: initialize features of the theme, given a player object.
  */
  public function prepare(& $player) {

    $this->prepare_jslib($player);

    // OU Podcast only: options menu, google analytics..
    if ('Podcast_player' == get_class($player)) {

      $this->features .= ',oup_options,googleanalytics';
    }

    // Embed code - uses jQuery-oEmbed plugin or Iframe.
    // http://support.google.com/youtube/bin/answer.py?hl=en&answer=171780&expand=UseHTTPS#HTTPS
    if ('Vle_player' != get_class($player)) {
      $this->player_embed_code = $this->CI->config->item('player_embed_code');
    }
    if ($this->player_embed_code) {

      // Experimental feature: select/copy embed code.
      $this->features .= ',oup_copyembed';
    }
  }
}
