<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * YouTube/HTML5 oEmbed service provider.
 *
 * @copyright Copyright 2012 The Open University.
 */
require_once APPPATH.'libraries/Oembed_Provider.php';


class Youtube_serv extends Oembed_Provider {

  public $regex = array('http://*youtube.com/watch*', 'http://youtu.be/*');
  public $about = <<<EOT
  YouTube is the world's most popular online video community, allowing millions of people to discover, watch and share originally-created videos.
  Embed videos from YouTube with a HTML5-video option. [Initially for Cloudworks/OULDI. Public access.]';
EOT;
  public $displayname = 'YouTube';
  #public $name = 'youtube';
  public $domain = 'youtube.com';
  public $subdomains = array('m.youtube.com');
  public $favicon = 'http://youtube.com/favicon.ico';
  public $type = 'video';

  public $_about_url = 'http://youtube.com/';
  public $_regex_real = '(youtu\.be\/|youtube\.com\/watch\?.*v=)([\w-_]+)&*.*';
  public $_examples = array(
    'Interview with Martin Bean (captions)' => 'http://youtube.com/watch?v=NaBBk-kpmL4',
    'http://youtu.be/NaBBk-kpmL4',
	'Brian McAllister, Roadtrip Nation (OLnet)' => 'http://youtube.com/watch?v=VesKht_8HCo',
	'_OEM'=>'/oembed?url=http%3A//youtu.be/NaBBk-kpmL4',
  );
  public $_access = 'public';


  /**
  * Implementation of call().
  * @return object
  */
  public function call($url, $matches) {
    $video_id = $matches[2]; #1

    $meta = array(
      'url'=>$url,
      'provider_name'=> 'YouTube',
      'provider_mid' => $video_id,
      'title' => NULL,
      'author'=> NULL,
      'timestamp'=>NULL,
    #signature=44A4BF0C1FBD2ED9EDF492CB0DB54032633BEBC2.EE68DF33D462D9F026839B632204559C75322F8B
    #&hl=en-GB&asr_langs=en%2Cko%2Cja%2Ces&lang=en
      '_caption_url' =>
      'http://www.youtube.com/api/timedtext?sparams=asr_langs%2Ccaps%2Cv%2Cexpire&asr_langs=en%2Cko%2Cja%2Ces&v='.$video_id.'&caps=asr&expire=1342827491&key=yttt1&x-signature&type=track&lang=en&name&kind&fmt=1',
    );

    return (object) $meta;
  }
}