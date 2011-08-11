<?php
/** Google Docs spreadsheet/forms service provider.
 *
 *  @copyright Copyright 2011 The Open University.
 */
#NDF, 4/3/2011.
#/oembed?url=http%3A//spreadsheets.google.com/embeddedform?formkey=dDhQOXpJYkl0VzFEQnZnTkhGcF9DSFE6MQ%23height=1160
require_once APPPATH.'libraries/base_service.php';


class Gglspread_serv extends Base_service {

  public function call($url, $matches) {
      $which = $matches[1]; #form|ccc.
      $key   = $matches[3];
      $height= isset($matches[5]) ? $matches[5] : 700;
      $ccc_base = 'http://spreadsheets.google.com';
  #var_dump($matches);

      if ('form'==$which) {
          $embed_url = "$ccc_base/embeddedform?formkey=$key";
      } else {
          die("400.10, Google Docs spreadsheets not yet implemented.");
      }

      // HTTP request - get the title...?

      $meta = array(
          #'title'=> '',
          'width' => 640, #720, #760,
          'height'=> $height,
          'embed_url'=>$embed_url,
          '_ccc'  => $which,
          '_key'  => $key,
      );
      return (object) $meta;
  }
}
