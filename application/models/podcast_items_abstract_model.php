<?php
/**
 * An abstract model to get item meta-data from a podcast DB or feed.
 *
 * @copyright Copyright 2012 The Open University.
 * @author N.D.Freear, 16 March 2012.
 */

abstract class Podcast_items_abstract_model extends CI_Model {

	public function get_item($basename, $shortcode=NULL, $captions=FALSE) {}


	protected function _error($message, $code=500, $from=null, $obj=null) {
		$CI =& get_instance();
		$CI->_error($message, $code, $from, $obj);
	}
}
