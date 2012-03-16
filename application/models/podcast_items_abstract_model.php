<?php
/**
 * An abstract model to get item meta-data from a podcast DB or feed.
 *
 * @copyright Copyright 2012 The Open University.
 * @author N.D.Freear
 */

abstract class Podcast_items_abstract_model extends CI_Model {

	public function get_item($basename, $shortcode=NULL, $captions=FALSE) {}

}
