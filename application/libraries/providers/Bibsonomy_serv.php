<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Bibsonomy oEmbed service provider -- a stop-gap service?!
 *
 * @copyright Copyright 2012 The Open University.
 * @author N.D.Freear, 19 November 2012.
 */


class Bibsonomy_serv extends Oembed_Provider {

  public $regex = 'http://www.bibsonomy.org/*'; // Optional trailing slash.
  public $about = <<<EOT
  BibSonomy is a social bookmarking and publication-sharing system. It aims to integrate the features of bookmarking systems as well as team-oriented publication management. [Initially for OLDS-MOOC. Public access. Alpha/ interim.]
EOT;
  public $displayname = 'BibSonomy';
  public $domain = 'bibsonomy.org';
  public $favicon = 'http://www.bibsonomy.org/resources/image/favicon.png';
  public $type = 'rich';

  public $_about_url = 'http://bibsonomy.org/';

  public $_regex_real = 'bibsonomy\.org\/.*';
  public $_examples = array(
    'Twitter tag' => 'http://www.bibsonomy.org/tag/twitter',
  );
  public $_access = 'public';


  /**
  * Call the Embed.ly service (2011-03-23).
  * @return object
  */
  public function call($url, $matches) {
    var_dump('/*TODO: work-in-progress! */', $url, $matches);

    //redirect($url . '?format=oembed'); # Doesn't work?!

	exit(1);
  }

}