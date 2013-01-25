<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Bibsonomy oEmbed service provider -- a stop-gap service?!
 *
 * @copyright Copyright 2012 The Open University.
 * @author N.D.Freear, 19 November 2012 - 25 January 2013.
 */


class Bibsonomy_serv extends Generic_Iframe_Oembed_Provider {

  public $regex = 'http://www.bibsonomy.org/*'; // Optional trailing slash.
  public $about = <<<EOT
  BibSonomy is a social bookmarking and publication-sharing system. It aims to integrate the features of bookmarking systems as well as team-oriented publication management. [Initially for OLDS-MOOC. Public access. Alpha/ interim.]
EOT;
  public $displayname = 'BibSonomy';
  public $domain = 'bibsonomy.org';
  public $favicon = 'http://www.bibsonomy.org/resources/image/favicon.png';
  public $type = 'rich';

  public $_about_url = 'http://bibsonomy.org/';

  public $_regex_real = 'bibsonomy\.org\/?([^\?]*)(\?.*)?';
  public $_examples = array(
    'Oldsmooc tag' => 'http://www.bibsonomy.org/tag/oldsmooc',
  );
  public $_access = 'public';


  /**
  * @return object
  */
  public function call($url, $matches) {

    // Generate the embed URL from the input URL.
    $embed_url = preg_replace('/format=\w*/', '', $url);
    $embed_url .= contains($url, '?') ? '&' : '?';
    $embed_url .= 'format=embed&for=' . $this->CI->input->server('HTTP_HOST');

    $meta = $this->getIframeResponse($url);

    $meta->title = isset($matches[1]) && !empty($matches[1]) ? $matches[1] : 'BibSonomy home';
    $meta->embed_url = $embed_url;

    //redirect($url . '?format=oembed'); # Doesn't work?!

    return $meta;
  }

}
