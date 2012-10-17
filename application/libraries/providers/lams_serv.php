<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * LAMS/ Learning Activity Management System oEmbed service provider.
 *
 * Get oEmbed response from upstream Lamscommunity.org server.
 * Options: cache the SVG, screen-scrape the Lamscentral page (for extended meta-data).
 *
 * @author N.D.Freear, 24-Feb-2011 on.
 * @copyright Copyright 2011 The Open University.
 */
require_once APPPATH.'libraries/Oembed_Provider.php';


class Lams_serv extends Oembed_Provider {

  public $regex = 'http://lamscommunity.org/*?seq_id=*'; //array()
  public $about = <<<EOT
  <abbr title="Learning Activity Management System">LAMS</abbr> is a new tool for producing online collaborative learning activities.
  It provides teachers with a visual authoring environment for creating sequences.
  Embed previews of LAMS sequences [Initially for Cloudworks/OULDI. Public access.]
EOT;
  public $displayname = 'LAMS Community';
  public $domain = 'lamscommunity.org';
  public $favicon = 'http://lamscommunity.org/favicon.ico';
  public $type = 'rich';

  public $_about_url = 'http://lamscommunity.org/';
  public $_logo_url = 'http://lamscommunity.org/images/lams_logo.gif';
  public $_regex_real = ':\/\/lamscommunity\.org\/.*(sequence|dl)\?seq_id=(\d{2,10})$';
  public $_examples = array(
    'Crime fighting'=> 'http://lamscommunity.org/lamscentral/sequence?seq_id=1007900',
    'Γενετικά Τροποποιημένα Τρόφιμα 1 [el]'=> 'http://lamscommunity.org/lamscentral/sequence?seq_id=1074994',
    '_OEM'=>'/oembed?url=http%3A//lamscommunity.org/lamscentral/sequence%3Fseq_id=1007900',
  );
  public $_access = 'public';


  /**
   * Implementation of call().
   * @return object
   */
  public function call($url, $matches) {
      $seq_id = $matches[2];
      $lams_base = 'http://lamscommunity.org';

      // Call the upstream oEmbed service.
      $oembed_url = "$lams_base/oembed?format=json&url="
          .'http%3A//lamscommunity.org/lamscentral/sequence%3Fseq_id='.$seq_id;

      $result = $this->_http_request_json($oembed_url);
      if (! $result->success) {
        // HTTP Error, eg. 404.
        $this->_error("LAMS oEmbed provider HTTP problem, $oembed_url", $result->http_code);
        return FALSE;
      }

	  // Regular expressions.
      $author_re = '/script:AuthoredSequences\((\d+)\);\">([^<]+)<\/a/ms'; //[\w ]
      $preview_re= '/script:previewSequence\((\d+)\)/ms';
      $image_re  = '/script:FullView\((\d+),(\d+),\d+\)/ms';
      if (!preg_match($author_re, $result->json->html, $author_m)) {
          //Error.
          $this->_error("LAMS oEmbed provider author-Regex problem, seq=$seq_id, $oembed_url");
      }
      $author_id  = $author_m[1];
      $author_name= $author_m[2];
      //$author_url= "$lams_base/dotlrn/community-member?user_id=$author_id"; //%5f.
      $author_url= "$lams_base/lamscentral/sequence-by-user?user_id=$author_id";
      $image_url = "$lams_base/seqs/svg/$seq_id.png";
      $svg_url   = "$lams_base/seqs/svg/$seq_id.svg";

    // Consider getting the SVG file - backup/count nodes/arrows etc.!

      if (!preg_match($preview_re, $result->json->html, $preview_m)) {
          //Error.
          $this->_error("LAMS oEmbed provider preview-Regex problem, seq=$seq_id, $oembed_url");
      }
      $preview_id  = $preview_m[1];

      if (!preg_match($image_re, $result->json->html, $image_m)) {
		  $this->_error("LAMS oEmbed provider image-Regex problem, seq=$seq_id, $oembed_url");
      }
      $image_width = $image_m[1];
      $image_height= $image_m[2];

      $meta = array(
          'provider_name'=>'lams',
          'provider_mid' =>$seq_id,
          'title' => $result->json->title,
          'author'=> $author_name,
          'author_url' => $author_url,
          //'width':
          'thumbnail_url'=>$image_url,
          'thumbnail_width' =>$image_width,
          'thumbnail_height'=>$image_height,
          //'html':
          '_seq_id'    =>$seq_id,
          '_preview_id'=>$preview_id,
          '_svg_url'   =>$svg_url,
          '_license_url'=>'http://creativecommons.org/licenses/by-nc-sa/2.0/', //?
      );

      $bytes = $this->_http_get_svg($meta);

      return (object) $meta;
  }

  /** Get the LAMS SVG file.

  Icons: http://lamscvs.melcoe.mq.edu.au/fisheye/browse/lams/lams_central/web/images/svg
    http://bugs.lamsfoundation.org/browse/LDEV-2603?page=com.atlassian.jira.ext.fisheye:fisheye-issuepanel
    http://dl.dropbox.com/u/3203144/lams-icons.html
  */
  protected function _http_get_svg($meta) {
      $svg_url= $meta['_svg_url'];
	  $seq_id = $meta['_seq_id'];
	  $cache_dir= $this->_mkdir_cache($seq_id);
	  $svg_path = "$cache_dir/lams-$seq_id.svg";

	  $result = $this->_http_request_curl($svg_url);
      if (! $result->success) {
        //Error.
        log_message('error', __CLASS__.". Error getting LAMS SVG, $svg_url | ".$result->info['http_code']);
        return FALSE;
      }
      $bytes = @file_put_contents($svg_path, $result->data);
      if (! $bytes) {
        log_message('error', __CLASS__.". Error caching LAMS SVG, $svg_url");
      }
      return $bytes;
  }

  /** Create cache directories, using 1st and last digits in seq ID (to avoid filling one directory called '1'!)
  */
  protected function _mkdir_cache($seq_id) {
	$base = $this->CI->config->item('data_dir');
	$cache_dir = 'lams/'; //.(string)$seq_id[0].substr($seq_id, -1, 1);
	$success = true; //$this->_mkdir_safe($base, $cache_dir);
	if ($success) {
	  return $base.$cache_dir;
	}
	return $success;
  }

}
