<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * File viewer oEmbed service provider, including CompendiumLD SVG embeds.
 *
 * @copyright Copyright 2012 The Open University.
 * @author N.D.Freear, 19 November-22 December 2012.
 */


class Fileviewer_serv extends Oembed_Provider {

  public $regex =
    'http://various.example.org/*.(pdf|doc|xls|ppt|zip|svg|png|txt|markdown)';
  public $about = <<<EOT
  Embed arbitrary file-types hosted on a number of domains, including PDFs, MS Office files,
  Zips, SVG, Compendium SVG. It uses Google Docs Viewer among other services.
  Supported Web sites include Dropbox-Public, OpenClipArt, OpenLearn-Labspace (OU).
  [Initially for OLDS-MOOC. Public access. Alpha.]
EOT;
  public $displayname = 'Google Docs Viewer';
  public $domain = 'docs.google.com';
  public $subdomains = array('dl.dropbox.com', 'openclipart.org', 'www.open.edu',
    'openlearn.open.ac.uk', 'labspace.open.ac.uk', 'compendiumld.open.ac.uk',
    'kn.open.ac.uk', 'oro.open.ac.uk');  #ORO - ePrints - conflict?
  public $favicon = 'https://docs.google.com/favicon.ico';
  public $type = 'rich';

  public $_about_url = 'https://docs.google.com/viewer';
  public $_help_url ='http://support.google.com/drive/bin/answer.py?hl=en&p=docs_viewer&answer=2423485';

  public $_regex_real =
  '(.*:\/\/.+?)(\/.+\.(pdf|docx?|xlsx?|pptx?|zip|rar|svg|png|txt|markdown|md))(\?[^\#]+)?(\#.+)?';
  public $_examples = array(
    'Compendium LD SVG' =>
'http://dl.dropbox.com/u/9130126/CompendiumLD/test8.svg#!CompendiumLD=1&width=374&height=350', # ? %3F / # %23 / & %26.
    'ORO PDF' => 'http://oro.open.ac.uk/29700/1/3289OS-chpater-4-Spot-the-Difference.pdf',
  );
  public $_access = 'public';

  protected $_per_embed_params = array(
    'compendiumld' => 'Is this a CompendiumLD SVG file? Default: 0 [0 or 1]; optional.',
    'width' => 'Pixels or percentage; default: 100%; optional.',
    'height'=> 'Pixels; optional.',
    'title' => 'String; optional.',
  );


  /**
  * @return object
  */
  public function call($url, $matches) {
    $this->CI->load->helper('file');

    $meta = (object) array(
      'url' => $url,
      'entity_url' => htmlentities($url, ENT_QUOTES),
      'id' => hash('crc32b', $url), #8, #substr(sha256($url), 0, 10),
      #'hash_how' => 'crc32b',
      'host' => $matches[1],
      'path' => $matches[2],
      'ext' => $matches[3],
      'query' => isset($matches[4]) ? ltrim($matches[4], '? ') : NULL,
      'hash' => isset($matches[5]) ? ltrim($matches[5], '#! ') : NULL,

      'provider_name' => $this->displayname,
      'provider_url' => $this->_about_url,
      'type' => $this->type,
      'title'=> NULL,
      'width' => '100%',
      'height'=> 400,
      'embed_url'=>'http://docs.google.com/viewer?embedded=true&url=',
    );
    $meta->embed_url .= urlencode($meta->entity_url);

    parse_str($meta->query, $meta->query_r);
    parse_str($meta->hash, $hash_r);
    $meta->query_r += $hash_r;

    $meta->is_compendiumld =
      $meta->ext == 'svg' && FALSE !== stripos("$meta->query#$meta->hash", 'compendiumld');
    $meta->is_markdown = 'md' == $meta->ext || 'markdown' == $meta->ext
      || FALSE !== stripos("$meta->query#$meta->hash", 'markdown');

    $meta->mime_type = get_mime_by_extension($meta->path);

    $replace = strtoupper($meta->ext);
    if ($meta->is_compendiumld) {
      $meta->provider_name = $replace = 'CompendiumLD';
      $meta->provider_url = 'http://compendiumld.open.ac.uk';
    }
    elseif ($meta->is_markdown) {
      $replace = 'Markdown';
      $meta->provider_name = 'Markdown parser (Track OER)';
      $meta->provider_url = 'http://track.olnet.org/markdown';
    }

    $this->_get_query_param($meta, 'width');
    $this->_get_query_param($meta, 'height');
    $this->_get_query_param($meta, 'title');

    if (! $meta->title) {
      $meta->title = str_replace('/', ' / ', ltrim($meta->path, '/'));
      $meta->title = str_replace(".$meta->ext", " ($replace)", $meta->title);
    }

    $meta->title = str_replace("\\'", "'", $meta->title);
    $meta->entity_title = htmlentities($meta->title, ENT_QUOTES);


    return (object) $meta;
  }


  protected function _get_query_param(&$meta, $name) {
    if (isset($meta->query_r[$name])) {
      $meta->{$name} = $meta->query_r[$name];
    }
  }
}
