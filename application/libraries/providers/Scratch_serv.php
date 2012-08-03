<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Scratch oEmbed service provider.
 *
 * "Adding initial oembed.php controller and views, from June-Sep 2010."
 *
 * @copyright Copyright 2010 The Open University.
 * @author N.D.Freear, June-Sep 2010, 2011-03-11 08:02:49.
 *
 * @link https://github.com/IET-OU/ouplayer/commit/bdb2b3b918df619
 */
require_once APPPATH.'libraries/Oembed_Provider.php';


class Scratch_serv extends Oembed_Provider {

  public $regex = '';
  public $about = <<<EOT
    [Public access.]';
EOT;
  public $displayname = 'Scratch';
  public $domain = 'scratch.mit.edu';
  public $favicon = 'http://scratch.mit.edu/favicon.ico';
  public $type = 'rich';

  public $_about_url = 'http://scratch.mit.edu/';
  public $_logo_url = 'http://scratch.mit.edu/../logo.png';

  public $_regex_real = '\/';
  public $_examples = array(
    
    '_OEM'=>'/oembed?url=http%3A//scratch.mit.edu/projects/technoguyx/355353',
  );
  public $_access = 'public';


  /**
  * Implementation of call() - used by oEmbed controller.
  * @return object
  */
  public function call($url, $matches) {

    $meta = array(
      'url'=>$url,
      'provider_name'=>'scratch',
      'provider_mid' =>$matches[2],
      'author' => $matches[1]);

      /*<!-- <rdf:RDF..><Work..><dc:title>..
    #pactivity(views,loves..); #pdesc-description; ul#taglist */
  #echo "GET $url";
    $result = $this->_http_request_curl($url);
    if (! $result->success) {
      die("Error, _meta_scratch woops");
      return FALSE; //Error.
    }
    if (! preg_match('#(<Work.*\/Work>)#ms', $result->data, $matches)) {
      die("Error, preg [rdf..Work]");
      return FALSE;
    }
    // Suppress un-registered namespace warnings?
    $rdf = @new SimpleXmlElement($matches[1]);
    $rdf->registerXPathNamespace('rdf', "http://www.w3.org/1999/02/22-rdf-syntax-ns#");
    //$rdf->registerXPathNamespace('cc', 'http://web.resource.org/cc/');
    $rdf->registerXPathNamespace('dc', 'http://purl.org/dc/elements/1.1/');

    //dc:title,date,desc,creator,rights,type,license.
    foreach ($rdf->children() as $name => $value) {
      if ('creator'==$name) {
        $value = $value->Agent->title;
        $name  = 'author';
      }
      elseif ($attr = $value->attributes()) {
        $value = $attr['resource'];
      }
      if ('rights'==$name||'type'==$name||'license'==$name) {
      //switch($name) { case 'rights':case 'type':case 'license': #@todo??
          continue;
      }
      $meta[$name] = (string) $value;
    }
    $meta['timestamp'] = strtotime($meta['date']);
    $meta['author_url']= 'http://scratch.mit.edu/users/'.$meta['author']; #@todo.
    //$author=  $rdf->xpath('/Work/creator//text()'); #<license rdf:resource*/

    //More efficient/robust using SimpleXml ?
    preg_match('#(<ul id=.taglist.>.*?<\/ul>)#ms', $result->data, $m_tags);
    $tags = strip_tags(str_replace('</li>', '|', $m_tags[1]));
    $tags = explode('|', $tags);
    $taglist;
    foreach ($tags as $tag) {
      $taglist[] = trim($tag);
    }
    $meta['extended']['tags'] = trim(implode('|', $taglist), '|'); #??

    preg_match('#(<div id=.pactivity.*?<\/div>)#ms', $result->data, $m_activity);
    $activity = trim(strip_tags($m_activity[1])); #194 views, 2 taggers...
    $meta['extended']['activity'] = $activity;

    preg_match('#<div  id=.projectdown.*?\/h3>(.*?)<a#ms', $result->data, $m_project);
    $project = trim(strip_tags($m_project[1])); #Download the 3 sprites and 4 scripts  of..
    $meta['extended']['project'] = $project;

    preg_match("#<link rel=.image_src. href=.(.*?). \/>#", $result->data, $m_image);
    $meta['thumbnail_url'] = $m_image[1];


    $cache_id = $this->embed_cache_model->insert_embed($meta);


    return (object) $oembed;
  }
}

