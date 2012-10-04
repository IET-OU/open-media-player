<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Track OER oEmbed service provider.
 *
 * @copyright Copyright 2012 The Open University.
 * @author N.D.Freear, 3 October 2012.
 *
 * @link http://track.olnet.org
 * @link https://github.com/IET-OU/trackoer-core
 */
#require_once APPPATH.'libraries/Oembed_Provider.php';


class Trackoer_serv extends Oembed_Provider {
  public $regex = 'http://(openlearn.open.ac.uk|labspace.open.ac.uk|*oercommons.org)/*';
  public $about = <<<EOT
  Create (and embed) license-tracker code snippets for OpenLearn and OER Commons content. [JISC Track OER service. Public access.]';
EOT;
  public $displayname = 'Track OER';
  #public $name = 'trackoer';
  public $domain = 'openlearn.open.ac.uk';
  public $subdomains = array('labspace.open.ac.uk', 'oercommons.org');
  #public $favicon = 'https://groups.google.com/forum/favicon.ico';
  public $type = 'rich';

  public $_about_url = 'http://track.olnet.org/about';
  public $_regex_real = ':\/\/groups\.google\.com\/(.*forum)\/([^#].*?)(&height=(\d+))?';
  public $_examples = array(
    '_OEM: Learning to Learn/ Piwik analytics' => 'http://track.olnet.org/oembed?url=http%3A//labspace.open.ac.uk/Learning_to_Learn_1.0',
    '_OEM: The Aaron Copland Collect.' => 'http://track.olnet.org/oembed?url=http%3A//oercommons.org/courses/the-aaron-copland-collection-ca-1900-1990',
  );
  public $_access = 'public';

  protected $_endpoint_url = 'http://track.olnet.org/oembed';


  /**
   * Implementation of call().
   * @return object
   */
  public function call($url, $matches) {
      return NULL;
  }
}
