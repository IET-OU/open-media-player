<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * File viewer oEmbed service provider.
 *
 * @copyright Copyright 2012 The Open University.
 * @author N.D.Freear, 19 November 2012.
 */


class Fileviewer_serv extends Oembed_Provider {

  public $regex = 'http://various.example.org/*.(pdf|doc|xls|ppt|zip|svg|txt|markdown)'; // Optional trailing slash.
  public $about = <<<EOT
  Embed arbitrary file-types hosted on a number of domains, including PDFs, MS Office files, Zips, SVG, Compendium SVG. It uses Google Docs Viewer among other services.
  Supported Web sites include Dropbox-Public, OpenClipArt, OpenLearn-Labspace (OU).
  [Initially for OLDS-MOOC. Public access. Alpha.]
EOT;
  public $displayname = 'File Viewer';
  public $domain = 'docs.google.com';
  public $subdomains = array('dl.dropbox.com', 'openclipart.org', 'openclipart.org',
    'openlearn.open.ac.uk', 'labspace.open.ac.uk', 'compendiumld.open.ac.uk', 'www.open.edu'); #?
  public $favicon = 'https://docs.google.com/favicon.ico';
  public $type = 'rich';

  public $_about_url = 'https://docs.google.com/viewer';
  public $_help_url ='http://support.google.com/drive/bin/answer.py?hl=en&p=docs_viewer&answer=2423485';

  public $_regex_real = '.*\.(pdf|doc|xls|ppt|zip|rar|svg|txt|markdown|md)(\?hint=compendiumld)?'; #Todo: more.
  public $_examples = array(
    '' => '',
  );
  public $_access = 'public';


  /**
  * Call the Embed.ly service (2011-03-23).
  * @return object
  */
  public function call($url, $matches) {
    var_dump('/*TODO: work-in-progress! */', $url, $matches);

	exit;
  }
}