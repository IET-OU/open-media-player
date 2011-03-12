<?php
/** OU podcast service provider.
 *
 * @copyright Copyright 2011 The Open University.
 */
//NDF, 3/3/2011.
require_once 'base_service.php';

class Oupodcast_serv extends Base_service {

  protected $CI;

  public function __construct() {
      $this->CI =& get_instance();
      #$this->CI->load->model('podcast_items_model');
  }

  public function call($url, $matches) {
      $basename = str_replace(array('podcast-','pod-'), '', $matches[1]);
      $separator= $matches[2];
      $fragment = $matches[3];
      $is_file  = FALSE!==strpos($fragment, '.');
  var_dump($basename,$separator,$fragment, $is_file);

      // Query the podcast DB.
      #$result = $this->CI->podcast_items_model->get_item($basename, $fragment, $is_file);
  var_dump($result);

      // Access checks - SAMS cookie.
  
  }
}
