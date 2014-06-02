<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * iSpot oEmbed service provider.
 *
 * @copyright Copyright 2012 The Open University.
 * @author N.D.Freear, 10 October 2012.
 *
 * @link http://ispotnature.org
 * @link http://ispot.org.uk
 */


class Ispot_serv extends Oembed_Provider {
  public $regex = array(
    'http://ispotnature.org/node/*', 'http://ispotnature.org/taxonomy/*',
    'http://ispotnature.org/habitat/*', 'http://ispotnature.org/map*'
  );
  public $about = <<<EOT
  Learn more about wildlife, share your interest with a friendly community and get help identifying what you have seen.
  iSpot is a website aimed at helping anyone identify anything in nature. 
  Use the service to embed observations, observation lists and maps. [Initially developed for OpenLearn. Public access.]
EOT;
  public $displayname = 'iSpot';
  #public $name = 'ispot';
  public $domain = 'ispotnature.org';
  public $subdomains = array();
  public $favicon = 'http://ispotnature.org/sites/default/files/iSpot_favicon.ico';
  public $type = 'rich';

  public $_about_url = 'http://ispotnature.org/whats_it_all_about';
  public $_logo_url =
  'http://ispotnature.org/sites/all/themes/custom/ispot_2010/images/ispot_logo.png';
  public $_examples = array(
    'South American Fur Seals (Falklands) by palemaiden'
        => 'http://ispotnature.org/node/313421',
    'Map: indoors habitat' => 'http://ispotnature.org/map?habitat=indoors',
    'Taxonomy term: 16 "Milton Keynes"' => 'http://ispotnature.org/taxonomy/term/16',
    'Habitat: gardens and parks' => 'http://ispotnature.org/habitat/gardens+and+parks',
  );
  public $_access = 'public';

  protected $_endpoint_url = 'http://www.ispotnature.org/oembed';

  protected $_terms_url = 'http://ispotnature.org/terms-of-use';
  protected $_test_url = 'http://ispotnature.org/test/oembed.html';


  /**
   * Implementation of call().
   * @return object
   */
  public function call($url, $matches) {
      return NULL;
  }
}
