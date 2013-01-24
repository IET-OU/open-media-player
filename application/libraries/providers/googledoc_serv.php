<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Google Docs spreadsheet/forms oEmbed service provider.
 *
 * @copyright Copyright 2011 The Open University.
 * @author N.D.Freear, 4 March 2011.
 */


class Googledoc_serv extends Oembed_Provider {

  public $regex = 'https://docs.google.com/(spreadsheet|document|present[ation])/*'; #array()
  public $about = <<<EOT
  Embed Google Docs spreadsheets, forms, documents and presentations in your web site. [Initially for Cloudworks/OULDI. Public access.]
EOT;
  public $displayname = 'Google Docs';
  #public $name = 'googledoc';
  public $domain = 'docs.google.com';
  public $subdomains = array();
  public $favicon = 'http://docs.google.com/favicon.ico';
  public $type = 'rich';

  public $_about_url = 'https://docs.google.com/';
  // Bug #1271 - a work-in-progress!!
  public $_regex_real =
    ':\/\/docs\.google\.com\/(spreadsheet|present|presentation|document)\/\w*(ccc|form|pub|d|view|edit)(\?\w+=|\/)([\w-]+)(\/edit)?#?(.*?)(height=(\d+))?';
  public $_examples = array(
    'Get CloudEngine IET coffee..' => 'https://docs.google.com/presentation/d/1XK81uvcIZl_lTnYGRSOOMUz7Zor94eqG5TimKOZp-kg/edit#slide=id.i0',
    'Rhodri\'s talk' => 'https://docs.google.com/presentation/d/1ODWAPH9pXgVo-IImJeUDCHrh5owh33OXkvHfWlJyOqo/edit#slide=id.g14429bf_1_14',
    'OU Player help/ about' => 'https://docs.google.com/document/d/1gcxecBs7n4snPKmQnguBytVZpGdkcjl2GqfGUz-pCOc/edit#id.j2um0zpktyo1',

    'OU Player notif. (form)' => 'https://docs.google.com/spreadsheet/viewform?hl=en_&formkey=dFJtUEJTQlZiVEs5R3B5ZFpRd3ZRMFE6MA#height=690',
    'Student satis./ Ouseful (spreadsheet)' => 'http://docs.google.com/spreadsheet/ccc?key=reBYenfrJHIRd4voZfiSmuw',
    'https://docs.google.com/spreadsheet/embeddedform?formkey=dFJtUEJTQlZiVEs5R3B5ZFpRd3ZRMFE6MA#gid=0',
    #NO: https://docs.google.com/spreadsheet/gform?key=0AgJMkdi3MO4HdFJtUEJTQlZiVEs5R3B5ZFpRd3ZRMFE&hl=en_GB&gridId=0#edit
    'https://docs.google.com/spreadsheet/ccc?key=0AgJMkdi3MO4HdDhQOXpJYkl0VzFEQnZnTkhGcF9DSFE&hl=en_GB#gid=0',
    '_OEM'=>'/oembed?url=http%3A//spreadsheets.google.com/embeddedform?formkey=dDhQOXpJYkl0VzFEQnZnTkhGcF9DSFE6MQ%23height=1160',
  );
  public $_access = 'public';


  /**
   * Implementation of call().
   * @return object
   */
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
          'provider_name' => $this->displayname,
          'provider_url' => $this->_about_url,
          'type' => $this->type,
          'title'=> NULL, #'[unknown]',
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
