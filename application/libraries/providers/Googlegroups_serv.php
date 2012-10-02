<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Google Groups oEmbed service provider.
 *
 * @copyright Copyright 2012 The Open University.
 * @author N.D.Freear, 1 October 2012.
 *
 * @link http://iet-it-bugs.open.ac.uk/node/1407
 * @link http://dl.dropbox.com/u/3203144/cloudworks.ac.uk-mooc-groups.html
 */
require_once APPPATH.'libraries/Oembed_Provider.php';


class Googlegroups_serv extends Oembed_Provider {
  public $regex = 'https://groups.google.com/forum/#!forum/*';
  public $about = <<<EOT
  Embed Google Groups forums on your web site. [Initially for Cloudworks/OLDS-Mooc. Public access.]';
EOT;
  public $displayname = 'Google Groups';
  #public $name = 'googlegroups';
  public $domain = 'groups.google.com';
  public $subdomains = array();
  public $favicon = 'https://groups.google.com/forum/favicon.ico';
  public $type = 'rich';

  public $_about_url = 'https://groups.google.com/';
  public $_regex_real = ':\/\/groups\.google\.com\/(.*forum)\/([^#].*?)(&height=(\d+))?';
  public $_examples = array(
    'Developer Contact' => 'https://groups.google.com/forum/#!forum/developer-contact',
    '_OEM'=>'/oembed?url=https%3A//groups.google.com/forum/%23!forum/developer-contact%26height=1100',
  );
  public $_access = 'public';


  /**
   * Implementation of call().
   * @return object
   */
  public function call($url, $matches) {

      $group  = $matches[2]; #spreadsheet|present|document.
      # +1
      $fragment = isset($matches[3]) ? '#'.$matches[3] : null;
      $height= isset($matches[4]) ? $matches[4] : 700;
      $groups_base = 'https://groups.google.com/';

	  $embed_url = $groups_base . 'forum/embed/?place=forum/' . $group . '&amp;showsearch=true&amp;showpopout=true&amp;parenturl=http%3A%2F%2Funknown.example.org';

      $meta = array(
          'provider_name' => $this->displayname,
          'provider_url' => $this->_about_url,
          'type' => $this->type,
          'title'=> ucfirst(str_replace('-', ' ', $group)),
          'width' => 800, #900,
          'height'=> $height,
          'embed_url'=>$embed_url,
          '_group'  => $group,
          #'_m' => var_export($matches, $ret=true),
      );
      return (object) $meta;
  }
}
