<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Google Docs spreadsheet/forms oEmbed service provider.
 *
 *  @copyright Copyright 2011 The Open University.
 */
#NDF, 4/3/2011.
#/oembed?url=http%3A//spreadsheets.google.com/embeddedform?formkey=dDhQOXpJYkl0VzFEQnZnTkhGcF9DSFE6MQ%23height=1160
require_once APPPATH.'libraries/Oembed_Provider.php';


class Googledoc_serv extends Oembed_Provider {

  public function call($url, $matches) {

      $what  = $matches[1]; #spreadsheet|present|document.
      # +1
      $which = $matches[2]; #ccc|form|pub|d|view|edit.
      $key   = $matches[4];
      $fragment = isset($matches[6]) ? '#'.$matches[6] : null;
      $height= isset($matches[8]) ? $matches[8] : 700;
      $docs_base = 'https://docs.google.com';

      switch ($what) {
        case 'spreadsheet':
          if ('form'==$which) {
            $embed_url = "$docs_base/spreadsheet/embeddedform?formkey=$key";
        } else {
            $which = 'ccc';
            $embed_url = "$docs_base/spreadsheet/pub?key=$key&amp;output=html";
        }
        break;
        case 'present':
          $embed_url = "$docs_base/present/view?id=$key";
          $which = 'present';
          $height= 490;
        break;
        case 'presentation': # Scheme 2, eg. Rhodri.
          $embed_url = "$docs_base/presentation/d/$key/embed$fragment"; #edit,view,present,htmlpresent,embed.
          $which = 'present s2';
          $height= 490;
        break;
        case 'document':
          $embed_url = "$docs_base/document/pub?id=$key$fragment";
          $which = 'doc';
        break;
        default:
          die("400.11, Invalid or unsupported path-segment '$what' for Google Docs.");
        break;
      }

      //die("400.10, Google Docs spreadsheets not yet implemented.");

      // HTTP request - get the title...?

      $meta = array(
          #'title'=> '',
          'width' => 640, #720,
          'height'=> $height,
          'embed_url'=>$embed_url,
          '_ccc'  => $which,
          '_key'  => $key,
          #'_m' => var_export($matches, $ret=true),
      );
      return (object) $meta;
  }
}
