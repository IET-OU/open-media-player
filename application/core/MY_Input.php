<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Extend the default CI Input class, to support mixed-format URIs  (iet-it-bugs:1378).
 * Primarily to support Drupal consumers and custom oEmbed parameters.
 * Eg.
 *
 *   /[Controller]/ex/name1:value1/name2:value2/...?name3=value3&..
 *   /oembed/ex/theme:oup-light/...?url=http://..
 *
 * @copyright Copyright 2012 The Open University.
 * @author N.D.Freear, 27 July 2012.
 */
#ini_set('display_errors', 1);


class MY_Input extends CI_Input {

	protected $_expath = NULL;

	/**
	* If required, initialize in a controller method.
	*
	* (This can't be called in MY_Input::__construct() as $CI doesn't yet exist!)
	*/
	public function use_get_and_expath($expath_start = '/ex/', $delimiter = ':', $pair_delimiter = '/') {
		$CI =& get_instance();
		$uri = $CI->uri->uri_string();
		$pos = strpos($uri, $expath_start);
		$uri_ex = $expath_r = NULL;

		if (FALSE !== $pos) {
			$uri_ex = substr($uri, $pos + strlen($expath_start));
		}
		if ($uri_ex) {
			/*
			Things I tried..
			
			//$expath_r = explode($delimiter, $uri_ex);
			$orig_sep = ini_get('arg_separator.input');
			ini_set('arg_separator.input', $pair_delimiter);

			parse_str($uri_ex, $this->_expath);

			ini_set('arg_separator.input', $orig_sep);
			*/

			#$uri_ex = str_replace(array($delimiter, $pair_delimiter), array('=', '&'), $uri_ex);
			$uri_ex = strtr($uri_ex, array(
				$delimiter => '=',
				urlencode($delimiter) => '=',
				strtolower(urlencode($delimiter)) => '=',
				$pair_delimiter => '&',
			));

			parse_str($uri_ex, $this->_expath);
		}
	}

	/**
	* Fetch an item from the GET array
	*
	* @access	public
	* @param	string
	* @param	bool
	* @return	string
	*/
	public function get($index = NULL, $xss_clean = FALSE) {
		$value = parent::get($index, $xss_clean);

		if (! $value && $this->_expath && isset($this->_expath[$index])) {
			$value = $this->_expath[$index];
		}

		return $value;
	}
}
