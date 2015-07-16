<?php namespace IET_OU\Open_Media_Player;

/**
 * Open Media Player base theme.
 *
 * This theme extends the Mediaelement default theme, and adds Javascript features and views.
 *
 * @copyright Copyright 2012 The Open University.
 * @author N.D.Freear, 20 March 2012.
 */

use \IET_OU\Open_Media_Player\Mejs_Default_Theme;

class Ouplayer_Base_Theme extends Mejs_Default_Theme
{

    public $display = 'Open Media Player base theme';
    public $view = 'ou-me-player';

  // Note, set defaults for 'foreground' and background colours here (use & make them customizable in oup_light theme).
    public $rgb  = 'ouvle-default-blue';
    public $background = 'black';

    public $js_xdr;
    public $js_timeout;
    public $can_play_maybe;
    public $origin;    // TODO: move! For postMessage security (https://developers.google.com/youtube/player_parameters#origin)
    public $player_embed_code = null;
    public $with_credentials = false;  // TODO: move? Goes with $js_xdr.

  //iPadUseNativeControls etc.
    public $mobile_native_controls = true;

    protected $controls_height = 22; // Pixels
    protected $controls_overlap= false;
    protected $has_banner = false;

    // Order matters in the feature-list.
    public $features =
    'oup_shim,oup_playpause,oup_progress,current,duration,oup_group,oup_volume,tracks,oup_transcript,oup_quality,oup_popout,fullscreen,oup_fullscreenhover,oup_tracks_shim';
# 'oup_shim,oup_playpause,oup_progress,oup_group,fullscreen'; // Minimal.


    public function __construct()
    {
        parent::__construct();

        if (! $this->CI->input->is_cli_request()) {
            $this->origin  = $this->CI->agent->referrer();
        }

      // Hmm, $this->name won't be correct in child themes!
        $theme_name = strtolower($this->shortClass('#_Theme#i', '', __CLASS__));
        $theme_path = self::THEME_PATH . $theme_name;

      // Add our Open Media Player base styles to the array.
        $this->styles[] = $theme_path . '/css/ouplayer-base.css';

      // The minified Open Media Player+mediaelement Javascript/ CSS.
        $this->js_min  = $theme_path . '/build/ouplayer-mediaelement.min.js';
        $this->css_min = str_replace('.js', '.css', $this->js_min);

      // Bug #1334, VLE caption redirect bug [iet-it-bugs:1477] [ltsredmine:6937]
        $this->js_xdr = $theme_path . '/build/xdr.js';

        $meps_base = $this->js_path; #From parent.
        $oups_base = $theme_path . '/js/';

        $this->javascripts = array(
            $oups_base.'mep-header-cl.js',
            $oups_base.'mep-oup-log.js',
        # Mediaelement libraries.
            $meps_base.'me-namespace.js',
            $meps_base.'me-utility.js',
            $meps_base.'me-plugindetector.js',
            $meps_base.'me-featuredetection.js',
            $meps_base.'me-mediaelements.js',
            $meps_base.'me-shim.js',
            $meps_base.'me-i18n.js',
        # Mediaelement player libraries.
            $meps_base.'mep-library.js',
            $oups_base.'mep-player.js',  # Ender.js fix: 1-line change, NDF 2012-04-17.
            $meps_base.'mep-feature-time.js',
            //$meps_base.'mep-feature-volume.js',
            $oups_base.'mep-feature-fullscreen.js', # Group: 1-line change, NDF 2012-03-30.
            $oups_base.'mep-feature-tracks.js',     # Group: 1-line change.
            $meps_base.'mep-feature-googleanalytics.js',
        # Open Media Player extensions.
            $oups_base.'mep-oup-header.js',
            $oups_base.'mep-oup-feature-shim.js',
            $oups_base.'mep-oup-feature-error.js',
            $oups_base.'mep-oup-feature-tracks-shim.js',
            $oups_base.'mep-oup-feature-playpause.js',
            $oups_base.'mep-oup-feature-progress.js',
            $oups_base.'mep-oup-feature-volume.js',
            $oups_base.'mep-oup-feature-postmessage.js',
            $oups_base.'mep-oup-feature-popout.js',
            $oups_base.'mep-oup-feature-transcript.js',
            $oups_base.'mep-oup-feature-quality.js', # High-definition.
            $oups_base.'mep-oup-feature-options.js',
            //$oups_base.'mep-oup-feature-title.js', # NOT required!

            $oups_base.'mep-oup-feature-tooltip.js', #Experimental!
            $oups_base.'mep-oup-feature-group.js',
            $oups_base.'mep-oup-feature-fullscreenhover.js', #Experimental!
            $oups_base.'mep-oup-feature-copyembed.js',   #Experimental.
            $oups_base.'mep-oup-feature-ignore-color.js',    # High contrast/ignore colour accessibility fix.
        );
    }


    /** Prepare: initialize features of the theme, given a player object.
    */
    public function prepare(& $player)
    {
        parent::prepare($player);

      // OU Podcast only: options menu, google analytics..
        if ($player->is_player('podcast') || $player->is_player('openlearn')) {
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

      // Bug #1447, captions expected - part of a fix?
        if (! $player->caption_url) {
            $this->features = str_replace(array(',tracks', ',oup_tracks_shim'), '', $this->features);
        }

        $this->can_play_maybe = $this->canPlayMaybe();
        $this->js_timeout = $this->config_option('js_timeout', 500);
        $this->config = $this->config_option('player_js_config', array('z'=>0));

      // Bug #1334, VLE caption redirect bug [iet-it-bugs:1477] [ltsredmine:6937] ('Vle_player')
        if (!$player->is_player('podcast') && $player->caption_url) {
            $this->with_credentials = true;
        }


        $this->prepare_banner($player);
    }


    /**
  * Should audio/video players have a title panel/ banner? [iet-it-bugs:1486] [ltsredmine:10744]
  */
    public function prepare_banner($player)
    {
        $this->has_banner = ('Podcast_player' == get_class($player));

        $param_banner = $this->CI->input->get('banner');
        $http_referer = $this->CI->input->server('HTTP_REFERER');
        $REGEX = '@:\/\/[^\/]+\.open\.(ac\.uk|edu)\/@';
        if ('0' === $param_banner or preg_match($REGEX, $http_referer)) {
            $this->has_banner = false;
        }
        if ('1' === $param_banner) {
  //OR 'Popup' == get_class(get_instance())
            $this->has_banner = true;
        }
    }

    /**
    * @return bool
    */
    public function has_title_banner()
    {
        return $this->has_banner;
    }

    /**
  * Grr, need to use Flash in MSIE 9/ 10 :((.
  * @link http://caniuse.com/fullscreen
  * [iet-it-bugs:1416]
  */
    protected function canPlayMaybe()
    {
        $ua = $this->CI->agent;
      #var_dump($ua->is_browser('MSIE'), $ua->browser(), $ua->version(), (int) $ua->version() < 11);
        if (/* $ua->is_browser('Chrome')
        || */ ($ua->is_browser('MSIE') && $ua->version() < 11)) {
            return 'false';
        } else {
            return 'true';
        }
    }
}
