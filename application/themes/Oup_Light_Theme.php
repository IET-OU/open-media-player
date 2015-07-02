<?php namespace IET_OU\Open_Media_Player;

/**
 * OU Player Light 2012 theme.
 *
 * This theme extends the OU Player base theme and adds the visuals, colours and so on.
 *
 * @copyright Copyright 2012 The Open University.
 * @author Peter Devine/LTS 2012-03-08 (visuals, CSS)
 * @author Nick Freear 2012-03-30 (CSS, PHP)
 */

use \IET_OU\Open_Media_Player\Ouplayer_Base_Theme;

class Oup_Light_Theme extends Ouplayer_Base_Theme
{

    public $display = 'OU Player light (2012)';
    public $rgb  = 'ouvle-default-blue';
    public $background = 'black';


    public function __construct()
    {
        parent::__construct();

        // Add the light theme top-level styles to the array.
        $this->styles[] = "themes/$this->name/css/oup-light.css";

        $this->css_min = "themes/$this->name/build/oup-light-ouplayer-mediaelement.min.css";


        // Feature: currently we don't support 'High-definition'.
        $this->features = str_replace(',oup_quality', '', $this->features);

        // Experimental feature: add in tooltips on keyboard focus.
        $this->features .= ',oup_tooltip';

        // Experimental feature: HTML5 postMessage.
        if ($this->CI->input->get('postmessage')) {
            $this->features .= ',oup_postmessage';
        }
    }


    /** Prepare: initialize features of the theme, given a player object.
    */
    public function prepare(& $player)
    {
        parent::prepare($player);

        // Embed or Popup mode.
        $mode = get_class($this->CI);

        // The foreground colour name, from a URL parameter.
        $rgb = $this->CI->input->get('rgb');
        $this->rgb = $rgb ? $rgb : 'ouvle-default-blue';

        // Bug #1324, https://gist.github.com/2291035 --? /(ouvle-[a-z]+|button-normal)/
        $RE = 'default-blue|orange|dark-blue|green|grey|purple|pink|dark-red'; #'|button-normal'
        if (! preg_match("/^ouvle-($RE)\$/", $this->rgb)) {
          #$this->CI->_error("(theme error) unrecognized value for 'rgb' parameter: ".$this->rgb, 400);
            $this->CI->_debug("Warning (theme), unrecognized value for 'rgb' color parameter, ". $this->rgb);
            $this->rgb = 'ouvle-default-blue';
        }


        // Bug #1377, Experimental: custom/ transparent player background color.
        $bg = $this->CI->input->get('background');
        $bg_options = explode('|', 'transparent|black|white|beige');
        if ('Embed' == $mode && $bg && in_array($bg, $bg_options)) {
            $this->background = $bg;
        }

        // Specific override for embedded VLE audio player.
        if ('Vle_player' == get_class($player)
        && 'audio' == $player->media_type
        && 'Embed' == $mode) {
            $this->background = 'transparent';
        }
    }
}
