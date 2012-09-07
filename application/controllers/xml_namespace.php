<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * XML Namespace controller.
 *
 * @example  http://www.w3.org/1999/xhtml
 * @example  http://www.w3.org/2005/Atom
 * @example  http://www.w3.org/1999/02/22-rdf-syntax-ns#
 * @example  http://purl.org/rss/1.0/modules/event/
 * @example  http://a9.com/-/spec/opensearch/1.1/
 * @example  http://creativecommons.org/ns#Work
 * @example  http://purl.org/steeple
 * @example  http://embed.open.ac.uk/2012/extend#
 *
 * @link  http://w3.org/TR/REC-xml-names
 * @copyright 2012 The Open University.
 * @author N.D.Freear, 06 September 2012.
 */


class Xml_namespace extends MY_Controller {

  // List of live/test/dev. servers for which we display the namespace page.
  const NS_HOSTS = 'embed.open.ac.uk|iet-embed-acct.open.ac.uk|iet-embed-dev.open.ac.uk|pcie663.open.ac.uk|localhost'; 


  /** Method for our single namespace.
  */
  public function ou_oembed_extend() {

    $host = $this->input->server('HTTP_HOST');
    if ($host && FALSE===strpos(self::NS_HOSTS, $host)) {
      $this->_error('The page you requested was not found.', 404);
    }


    $this->_load_layout(self::LAYOUT);

    #echo 'XML Namespace for oEmbed extensions: http://embed.open.ac.uk/2012/extend#';
    $this->layout->view('about/xmlns_ou_oembed_extend');
  }

}
