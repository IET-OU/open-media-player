<?php
/** LAMS service provider.
 *
 *  @copyright Copyright 2011 The Open University.
 */
//24/2, 1/3/2011.
require_once 'base_service.php';

class Lams_serv extends Base_service {

  public function call($url, $matches) {
      $seq_id = $matches[2];
      $lams_base = 'http://lamscommunity.org';

      // Call the upstream oEmbed service.
      $oembed_url = "$lams_base/oembed?format=json&url="
          .'http%3A//lamscommunity.org/lamscentral/sequence%3Fseq_id='.$seq_id;

      $result = $this->_http_request_json($oembed_url);
      if (! $result->success) {
        die("Error, Lams_serv woops");
        return FALSE; //Error.
      }
  #var_dump($result);

      $author_re = '/script:AuthoredSequences\((\d+)\);\">([^<]+)<\/a/ms'; //[\w ]
      $preview_re= '/script:previewSequence\((\d+)\)/ms';
      $image_re  = '/script:FullView\((\d+),(\d+),\d+\)/ms';
      if (!preg_match($author_re, $result->json->html, $author_m)) {
          //Error.
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
      }
      $preview_id  = $preview_m[1];

      if (!preg_match($image_re, $result->json->html, $image_m)) {
          //Error.
      }
      $image_width = $image_m[1];
      $image_height= $image_m[2];

      $meta = array(
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
  #var_dump($meta);
      
      return (object) $meta;
  }
}
