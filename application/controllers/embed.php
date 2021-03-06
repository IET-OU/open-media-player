<?php defined('BASEPATH') or exit('No direct script access allowed');
/**
 * Part of Open Media Player.
 *
 * @license   http://gnu.org/licenses/gpl.html GPL-3.0+
 * @copyright Copyright 2011-2015 The Open University (IET) and contributors.
 * @link      http://iet-ou.github.io/open-media-player
 */

/**
 * Iframe embed controller for Open Media Player.
 *
 * Note, this controller is also used for the 'popup' functionality (see Popup controller).
 *
 * @copyright Copyright 2012 The Open University.
 * @author N.D.Freear, 2011-03-22.
 */

class Embed extends \IET_OU\Open_Media_Player\MY_Controller
{

    protected $_debug;

    public function __construct()
    {
        parent::__construct();

   #$this->_theme = $this->_request->theme ? $this->_request->theme :'basic'; #(basic|core|ouice-dark|ouice-bold)
        $this->_player_init();

        $this->_debug = $this->input->get('_debug');
    }

    /**
    * http://localhost/ouplayer/embed/-/youtube.com/EQEy5_QE2tQ
    */
    public function extend($provider_domain = null, $id = null)
    {
        $expect = '<tt>/embed/-/{domain}/{id}</tt>';

        $providers = $this->plugins->get_local_embed_providers();

        if (!$provider_domain) {
            $this->_error('The URL segment {$provider_domain} is required. '. $expect, "400.A");
        }
        if (!$id) {
            $this->_error('The URL segment {id} is required. ' . $expect, "400.B");
        }
        if (!isset($providers[ $provider_domain ])) {
            $this->_error("Can't find a provider for the domain, $provider_domain. $expect", "404.C");
        }

        $provider_class = $providers[ $provider_domain ];

        $provider = new $provider_class ();
        $provider->local_embed($id);
    }

    /** OU-podcast player embed.
    */
    public function pod($custom_id = null, $shortcode = null)
    {
        if (!$custom_id || !$shortcode) {
            $this->_error("an album ID and track MD5 hash are required in the URL", 400);
        }
        $width = 0; #$this->_required('width');
        $height= 0; #$this->_required('height');
        $edge  = $this->input->get('edge');  #Deprecated.
        $audio_poster= $this->input->get('poster'); #Only for audio!

        $this->oupodcast_serv = $this->load->oembed_provider('\\IET_OU\\Open_Media_Player\\Oupodcast_Provider');
        //$this->load->oembed_provider('Oupodcast', 'oupodcast_serv');

        $player = $this->oupodcast_serv->_inner_call($custom_id, $shortcode);
        $player = $this->oupodcast_serv->get_transcript($player);

        $player->calc_size($width, $height, $audio_poster);

        $popup_url = site_url("popup/pod/$player->_album_id/$player->_track_md5")
            . $this->_options_build_query();

        $view_data = array(
            'meta' => $player,
            'theme'=> $this->_theme,
            'debug'=> $this->_debug,
            'standalone' => false,
            // Auto-generate 'embed' or 'popup'.
            'mode' => strtolower(get_class($this)),
            'context' => $player->shortClass(),
            'req'  => $this->_request,
            'google_analytics' => $this->oupodcast_serv->getAnalyticsId(),  #$this->_get_analytics_id('podcast.open.ac.uk'),
            'popup_url' => $popup_url,
            // Bug #1334, VLE caption redirect bug [iet-it-bugs:1477] [ltsredmine:6937]
            '_caption_url' => site_url('timedtext/webvtt') .'?url='. $player->caption_url,
        );
        if ($this->_is_popup()) {
            // We don't want a "Pop up" button in the "popup" view.
            $view_data[ 'popup_url' ] = null;
        }


        // Access control - start simple!

        $restrict_image = $this->config->item('player_restricted_poster_url');

        $this->auth = new \IET_OU\Open_Media_Player\Sams_Auth();

        if ($this->auth->is_private_caller()
            && $player->is_restricted_podcast()) {
            $this->auth->authenticate();
        } elseif ($restrict_image
            && $player->is_restricted_podcast()
            && ! $this->_is_popup()) {
            $view_data[ 'login_url' ] = \IET_OU\Open_Media_Player\Sams_Auth::login_link($popup_url);
            $view_data['meta']->poster_url = $restrict_image;
            #..pixastic/podcast-pix-emboss-grey-220-strength-3.0-blend-opacity-0.25.png;
            $this->load->view('ouplayer/oup_restricted', $view_data);

            return;
        } elseif ($player->is_restricted_podcast()
            && $this->_is_popup()) {
            // Private podcast, public site, 'popup' view - authenticate.

            $this->auth->authenticate();
        }

    // 'New' 2012 Mediaelement-based themes.
        if (preg_match('/oup-light|ouplayer-base|mejs-default/', $this->_theme->name)) {
            $this->load->theme($this->_theme->name);

            $this->theme->prepare($player);

            $view_data['params'] = $view_data['meta'];
            $view_data['params']->debug = $this->_is_debug(OUP_DEBUG_MAX);  #$this->_debug;
            $view_data['params']->debug_score = $this->_is_debug(1, $score = true);

            $this->load->theme_view(null, $view_data);
        } elseif ('basic' != $this->_theme->name || $edge) {
            // Legacy 2011 Flowplayer-based themes.
            // The themed player.
            $this->load->view('ouplayer/ouplayer', $view_data);
        } else {
            // Basic/ un-themed ('no-script') player.
            $view_data['standalone'] = true;
            $this->load->view('ouplayer/player_noscript', $view_data);
        }
    }

    /** A generic iframe player embed.
    */
    public function player()
    {
        $options = array('width', 'height', 'image_url', 'caption_url', 'lang', 'theme', 'debug', 'transcript_url', 'related_url');
        return $this->_player('\\IET_OU\\Open_Media_Player\\Generic_Player', $options);
    }

    /** OUVLE player embed.
    */
    public function vle()
    {
        $options = array('width', 'height', 'image_url', 'caption_url', 'lang', 'theme', 'debug');
        return $this->_player('\\IET_OU\\Open_Media_Player\\Vle_Player', $options);
    }

    public function openlearn()
    {
        $options = array('width', 'height', 'image_url', 'caption_url', 'lang', 'theme', 'debug', 'transcript_url', 'related_url');
        return $this->_player('\\IET_OU\\Open_Media_Player\\Openlearn_Player', $options);
    }

    public function _is_popup()
    {
        return 'Popup' === get_class($this);
    }

    protected function _player($class, $options)
    {
        header('Content-Type: text/html; charset=utf-8');

      // Security: No access control required?

      // Process GET parameters in the request URL.
        $player = new $class;
      // Required.
        $player->media_url = $this->input->get('media_url');
        $player->title     = $this->_required('title');
        $player->width     = $this->input->get('width');  # is_numeric. Required?
        $player->height    = $this->input->get('height'); # Play height, not media(?)
      // Optional.
        $player->poster_url = $this->input->get('image_url');
        $player->caption_url= $this->input->get('caption_url');
        $player->language   = $this->input->get('lang'); #Just a reminder!
      #);

      // Maybe tighten back up for production (Was: '/learn.open.ac.uk../')?
        $media_url_regex = $this->config->item('media_url_regex');
        if (! $media_url_regex) {
            $media_url_regex = '@:\/\/[\w-\.]+\.open\.(ac\.uk|edu)(\:\d+)?\/.*\.(mp4|m4v|flv|mp3)[\/\?]?@'; //No '$' at the end.
        }
        $this->_debug($media_url_regex);

        if (preg_match($media_url_regex, $player->media_url, $ext)) {
          // Codecs? http://wiki.whatwg.org/wiki/Video_type_parameters
            $opts = array('mp4'=>'video/mp4', 'm4v'=>'video/mp4', 'flv'=>'video/flv', 'mp3'=>'audio/mpeg', 'f4v'=>'video/mp4');
            $player->mime_type = $opts[$ext[3]];
            $player->media_type = substr($player->mime_type, 0, 5);
            $player->media_html5 = ('flv' != $ext[3]);
        } else {
            $this->_error("'media_url' is a required parameter. (Accepts URLs ending mp4, flv and mp3.)", 400);
        }
        if ($player->caption_url && !preg_match('/\.(srt|xml|ttml)$/', $player->caption_url)) {
            $this->_error("'caption_url' accepts URLs ending srt, xml and ttml.", 400);
        }
        $base_url = dirname($player->media_url);
        $player->poster_url = $this->_absolute($player->poster_url, $base_url);
        $player->caption_url= $this->_absolute($player->caption_url, $base_url);

        $player->calc_size($player->width, $player->height, (bool)$player->poster_url);

        $google_analytics_id = null;
        if ($player->is_player('openlearn')) {
          #$dummy_provider = new Oembed_Provider();
          #$this->load->library('Dummy_Provider', 'openlearn');
        }

        $view_data = array(
            'meta' => $player,
            'theme'=> $this->_theme,
            'debug'=> $this->_debug,
            'standalone' => false,
            // Auto-generate 'embed' or 'popup'.
            'mode' => strtolower(get_class($this)),
            'context' => $player->shortClass(),
            'req'  => $this->_request,
            'google_analytics' => $player->is_player('openlearn') || $player->is_player('generic')
                ? google_analytics_id('openlearn') : null,
            'popup_url' => site_url("popup/vle?media_url=") . $this->_options_build_query([
                'title' => $player->title, 'media_url' => $player->media_url ]),
            // Bug #1334, VLE caption redirect bug [iet-it-bugs:1477] [ltsredmine:6937]
            '_caption_url' => $player->caption_url .'?r='. mt_rand(1, 1000),
        );
        if ($this->_is_popup()) {
            // We don't want a "Pop up" button in the "popup" view.
            $view_data[ 'popup_url' ] = null;
        } else {
            // Hack.
            $view_data[ 'popup_url' ] = str_replace('&?', '&', $view_data[ 'popup_url' ]);
        }

        // 'New' 2012 Mediaelement-based themes.
        if (preg_match('/oup-light|ouplayer-base|mejs-default/', $this->_theme->name)) {
            $this->load->theme($this->_theme->name);

            $this->theme->prepare($player);

            $view_data[ 'params' ] = $view_data[ 'meta' ];
            $view_data[ 'params' ]->debug = $this->_is_debug(OUP_DEBUG_MAX);  #$this->_debug;
            $view_data[ 'params' ]->debug_score = $this->_is_debug(1, $score = true);

            $this->load->theme_view(null, $view_data);
        } elseif ('basic' !== $this->_theme->name) {
            // Legacy 2011 Flowplayer-based themes.
            $this->load->view('ouplayer/ouplayer', $view_data);
        } else {
            $view_data[ 'standalone' ] = true;
            $this->load->view('ouplayer/player_noscript', $view_data);
            // For now load vle_player - but, SWF is SAMS-protected!
            #$this->load->view('vle_player', $view_data);
        }
    }
}
