<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * File viewer oEmbed service provider, including CompendiumLD SVG embeds.
 *
 * @copyright Copyright 2012 The Open University.
 * @author N.D.Freear, 19 November-22 December 2012.
 */


class Fileviewer_serv extends Oembed_Provider {

  public $regex =
    'http://various.example.org/*.(pdf|doc|xls|ppt|zip|rar|svg|png|txt|html|php|js|css|markdown)';
  public $about = <<<EOT
  Embed arbitrary file-types hosted on a number of domains, including PDFs, MS Office files,
  Zips, SVG, Compendium SVG. It uses Google Docs Viewer among other services.
  Supported Web sites include Ubuntu one (Dropbox), OpenClipArt, OU-Blogs, OpenLearn-Labspace (OU).
  [Initially for OLDS-MOOC. Public access. Alpha.]
EOT;
  public $displayname = 'Google Docs Viewer';
  public $domain = 'docs.google.com';
  public $subdomains = array('dl.dropbox.com', '.googleusercontent.com', 'ubuntuone.com',
    'openclipart.org', 'upload.wikimedia.org',
    'www.open.edu', 'www.open.ac.uk',  # Includes OU blogs?
    'openlearn.open.ac.uk', 'labspace.open.ac.uk', 'compendiumld.open.ac.uk',
    'kn.open.ac.uk', 'oro.open.ac.uk',  #ORO - ePrints - conflict?
    'embed.open.ac.uk',  # Recursive?!
    'sites.google.com', 'www.lkl.ac.uk', 'blogs.cetis.ac.uk',
  );
  public $favicon = 'https://docs.google.com/favicon.ico';
  public $type = 'rich';

  public $_about_url = 'https://docs.google.com/viewer';
  public $_help_url ='http://support.google.com/drive/bin/answer.py?hl=en&p=docs_viewer&answer=2423485';

  protected $_extensions = 'pdf|docx?|xlsx?|pptx?|zip|rar|svg|png|txt|markdown|md|html?|php|js|css';
  public $_regex_real =
  '(.*:\/\/.+?)(\/[^\?#]+\.?(pdf|docx?|xlsx?|pptx?|zip|rar|svg|png|txt|markdown|md|html?|php|js|css)?)(\?[^\#]+)?(\#.+)?';
  public $_examples = array(
    'Compendium LD SVG' =>
        'http://dl.dropbox.com/u/9130126/CompendiumLD/test8.svg#!CompendiumLD=1&width=374&height=350', # ? %3F / # %23 / & %26.
    'Compendium LD SVG 2' =>
        'http://ubuntuone.com/5bfulWfbf1RQ225utYWVHe#!name=task-times-v1.svg&CompendiumLD=1&title=Andrew%3A+task+times+v1&width=345&height=483',
    'ORO PDF' => 'http://oro.open.ac.uk/29700/1/3289OS-chpater-4-Spot-the-Difference.pdf',
    'HTML5 page' => 'http://embed.open.ac.uk/demo/ouldi#!name=file.html',
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
      'filename' => basename($matches[2]),
      'ext' => isset($matches[3]) ? $matches[3] : NULL,
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


    // Extract data from the '?' query and '#' hash fragments in the URL.
    parse_str($meta->query, $meta->query_r);
    parse_str($meta->hash, $hash_r);
    $meta->query_r += $hash_r;

    $this->_get_query_param($meta, 'width');
    $this->_get_query_param($meta, 'height');
    $this->_get_query_param($meta, 'title');
    $this->_get_query_param($meta, 'name');

    // If the path doesn't contain an extension and a "name" parameter exists, use it.
    if (! $meta->ext && isset($meta->name)) {
      $meta->filename = $meta->name;
    }
    if (preg_match("/.+\.($this->_extensions)$/", $meta->filename, $matches)) {
      $meta->ext = $matches[1];
    } else {
      $this->_error("Unsupported file extension: $meta->filename", 400);
    }


    // Deal with special cases - CompendiumLD etc.
    $meta->is_compendiumld =
      $meta->ext == 'svg' && FALSE !== stripos("$meta->query#$meta->hash", 'compendiumld');
    $meta->is_markdown = 'md' == $meta->ext || 'markdown' == $meta->ext
      || FALSE !== stripos("$meta->query#$meta->hash", 'markdown');

    $meta->mime_type = get_mime_by_extension($meta->filename);

    $replace = strtoupper($meta->ext);
    if ($meta->is_compendiumld) {
      #$meta->mime_type .= '; CompendiumLD=1';
      $meta->provider_name = $replace = 'CompendiumLD';
      $meta->provider_url = 'http://compendiumld.open.ac.uk';
    }
    elseif ($meta->is_markdown) {
      $replace = 'Markdown';
      $meta->provider_name = 'Markdown parser (Track OER)';
      $meta->provider_url = 'http://track.olnet.org/markdown';
    }


    if (! $meta->title) {
      #$meta->title = str_replace('/', ' / ', ltrim($meta->filename, '/'));
      $meta->title = str_replace(array('-', '_'), ' ', ucfirst($meta->filename));
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
