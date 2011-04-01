<?php
/** Controller for a responder forathe Uptime Server Monitoring service
 * Requires the following line in application/config/routes.php
 * <code>
 *   $route['uptime.txt'] = 'uptime';
 * </code>
 * @link http://uptime.openacs.org/
 * @copyright 2011 The Open University.
 * @package Uptime NDF, 1 April 2010.
 */

class Uptime extends CI_Controller {

  /** The uptime page.
  */
  public function index() {
    $this->load->model('embed_cache_model');
	$embed_count = $this->embed_cache_model->count();
	@header('X-Count-Embed-Cache: '.$embed_count);

	# Need to add an IF (config) check.
	$this->load->model('podcast_items_model');
	$podcasts_count = $this->podcast_items_model->count();
	@header('X-Count-Podcast-Items: '.$podcasts_count);

	@header('Content-Type: text/plain; charset=UTF-8');
	if (!$embed_count || !$podcasts_count) {
	    @header('HTTP/1.1 503 Service Unavailable'); #Actually, CI never reaches this point!
		die('A Database Error Occurred'.PHP_EOL);
	}

	echo 'success'.PHP_EOL;
  }
}
