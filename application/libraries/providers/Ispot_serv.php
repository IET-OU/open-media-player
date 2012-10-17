<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * iSpot oEmbed service provider.
 *
 * @copyright Copyright 2012 The Open University.
 * @author N.D.Freear, 10 October 2012.
 *
 * @link http://ispot.org.uk
 */


class Ispot_serv extends Oembed_Provider {
  public $regex = array(
    'http://ispot.org.uk/node/*', 'http://ispot.org.uk/taxonomy/*',
    'http://ispot.org.uk/habitat/*', 'http://ispot.org.uk/map*'
  );
  public $about = <<<EOT
  Learn more about wildlife, share your interest with a friendly community and get help identifying what you have seen.
  iSpot is a website aimed at helping anyone identify anything in nature. 
  Use the service to embed observations, observation lists and maps. [Initially developed for OpenLearn. Public access.]
EOT;
  public $displayname = 'iSpot';
  #public $name = 'ispot';
  public $domain = 'ispot.org.uk';
  public $subdomains = array();
  public $favicon = 'http://www.ispot.org.uk/sites/default/files/iSpot_favicon.ico';
  public $type = 'rich';

  public $_about_url = 'http://www.ispot.org.uk/whats_it_all_about';
  public $_logo_url = 'http://ispot.org.uk/sites/all/themes/custom/ispot_2010/images/ispot_logo.png';
  public $_examples = array(
    'Observation/ node' => 'http://ispot.org.uk/node/123',
    'Taxonomy term: 16 "Milton Keynes"' => 'http://ispot.org.uk/taxonomy/term/16',
    'Habitat list' => 'http://ispot.org.uk/habitat/gardens+and+parks',
    'Map: indoors' => 'http://ispot.org.uk/map?habitat=indoors',
  );
  public $_access = 'public';

  protected $_endpoint_url = 'http://www.ispot.org.uk/oembed';

  protected $_terms_url = 'http://www.ispot.org.uk/terms-of-use';
  protected $_test_url = 'http://www.ispot.org.uk/test/oembed.html';


  /**
   * Implementation of call().
   * @return object
   */
  public function call($url, $matches) {
      return NULL;
  }
}
