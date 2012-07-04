<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Sharepoint oEmbed service provider.
 *
 * @copyright Copyright 2012 The Open University.
 * @author N.D.Freear, 4 July 2012.
 */

/*
 /oembed?url=https%3A//intranet7.open.ac.uk/collaboration/iet-professional-development/Shared Documents/Forms/DispForm.aspx?ID=1
*/
require_once APPPATH.'libraries/Oembed_Provider.php';


class Sharepoint_serv extends Oembed_Provider {

  public $regex = 'https://intranet7.open.ac.uk/collaboration/iet-professional-development/Shared Documents/*'; #array()
  public $about = 'Embed links to shared documents stored in Microsoft SharePoint, with associated meta-data.';
  public $displayname = 'MS SharePoint';
  public $name = 'sharepoint';  #
  public $domain = 'intranet7.open.ac.uk'; # HOST string.
  public $subdomains = array();	# HOST strings.
  public $favicon = '';			# URL string.
  public $type = 'rich';

  public $_type_x = NULL;
  public $_regex_real = 'https://intranet7.open.ac.uk/collaboration/iet-professional-development/Shared%20Documents/Forms/DispForm.aspx?ID=(\d+)';
  public $_examples = array(
    'Follow-up Induction Apr 2008'=>'https://intranet7.open.ac.uk/collaboration/iet-professional-development/Shared Documents/Forms/DispForm.aspx?ID=1',
	'_RSS'=>'https://intranet7.open.ac.uk/collaboration/iet-professional-development/_layouts/listfeed.aspx?List=%7B55377B07-A07E-4BDD-9F8E-03CFD5524546%7D',
	'_OEM'=>'/oembed?url=https%3A//intranet7.open.ac.uk/collaboration/iet-professional-development/Shared Documents/Forms/DispForm.aspx?ID=1',
  );
  public $_google_analytics = NULL;


  protected $_list_id = '55377B07-A07E-4BDD-9F8E-03CFD5524546';
  protected $_root = 'https://intranet7.open.ac.uk/collaboration/iet-professional-development';


  public function call($url, $matches) {

      $document_id  = $matches[1]; #DispForm.aspx?ID=1

	  $rss_url = "$this->_root/_layouts/listfeed.aspx?List=%7B{$this->_list_id}%7D";
	  
	  var_dump($document_id, $rss_url);
	  exit;
  }
}
