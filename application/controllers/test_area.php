<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 *  Pages with examples to use for test purposes
 *
 * @copyright Copyright 2016 The Open University.
 */

class Test_area extends MY_Controller {
	 public function __construct() {
	    parent::__construct();
	    header('Content-Type: text/html; charset=utf-8');
	 }

	public function video_podcast_open_ac_uk() {
		$this->_load_layout(self::LAYOUT);
		$this->layout->view('test/video-podcast-open-ac-uk');
	} 

	public function index() {
		$this->_load_layout(self::LAYOUT);
		$this->layout->view('test/test');
	} 

	public function audio_podcast_open_ac_uk() {
		$this->_load_layout(self::LAYOUT);
		$this->layout->view('test/audio-podcast-open-ac-uk');
	} 

	public function video_open2_net() {
		$this->_load_layout(self::LAYOUT);
		$this->layout->view('test/video-open2-net');
	} 	
}

/* End of file test.php */
/* Location: ./application/controllers/test.php */