<?php
/**
 * An abstract model to get item meta-data from a podcast DB or an RSS feed.
 *
 * @copyright Copyright 2012 The Open University.
 * @author N.D.Freear, 16 March 2012.
 */

abstract class Podcast_items_abstract_model extends CI_Model
{

    protected $CI;

    public function __construct()
    {
        parent::__construct();
        $this->CI =& get_instance();
    }

    public function get_item($basename, $shortcode = null, $captions = false)
    {

    }


    protected function _error($message, $code = 500, $from = null, $obj = null)
    {
        $this->CI->_error($message, $code, $from, $obj);
    }
}
