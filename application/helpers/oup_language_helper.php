<?php
/**
 * Part of Open Media Player.
 *
 * @license   http://gnu.org/licenses/gpl.html GPL-3.0+
 * @copyright Copyright 2011-2015 The Open University (IET) and contributors.
 * @link      http://iet-ou.github.io/open-media-player
 */

/**
 * Language helper functions [Bug: 59]
 *
 * Translate text function, uses sprintf/vsprintf.
 * See: cloudengine/libs./MY_Language; Drupal.
 *
 * @param $msgid string Text to translate, with optional printf-style placeholders, eg. %s.
 * @param $args  mixed  Optional. A value or array of values to substitute.
 * @return string
 */
//if (!function_exists('t')) {
function t($msgid, $args = null)
{
    $CI =& get_instance();
    $s = $CI->lang->gettext($msgid);
    $s = str_replace(array('<s>', '</s>'), array('<span>', '</span>'), $s);
    if (is_array($args)) {
        $s = vsprintf($s, $args);
    } // Important: accept empty string!
    elseif ($args || ''==$args) {
    #is_string() #func_num_args() > 1){
        $s = sprintf($s, $args); #array_shift(func_get_args()));
    }
    return /*Debug: '^'.*/$s;
}
//}

if (!function_exists('_')) {
    function _($s)
    {
        return $s;
    }
}
