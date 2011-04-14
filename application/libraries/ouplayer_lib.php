<?php
/** OU player library.
 *
 * @copyright Copyright 2011 The Open University.
 */
//NDF, 2011-04-07.

/* Ouplayer class - Hold meta-data for the player.
   Consistency between OU and OUVLE variants.
*/
abstract class Base_player {

  const DEF_WIDTH = 640;
  const DEF_HEIGHT= 410;

  // Hmm, public?
  public $title;
  public $media_url;
  public $media_type; #audio|video (not MIME!)
  public $media_html5 = TRUE;
  public $codec; #?
  public $width = self::DEF_WIDTH;
  public $height= self::DEF_HEIGHT;
  public $object_height = self::DEF_HEIGHT;
  public $duration;
  public $language = 'en';
  #public $is_vle  = FALSE;
  public $poster_url; #poster/ thumbnail?
  public $transcript_url;
  public $caption_url;
  public $iframe_url; #Our <iframe> embed!!

  public $_extend; #Odds and ends?

  /** calc_size: needs more work.
  */
  public function calc_size($width, $height, $audio_poster=false) {
    //Validate width/height..?!
	if ('audio'==$this->media_type) {
      $this->width = 400;
	  $this->object_height = 60;
	  if ($audio_poster) { #$this->poster_url) {
	    $this->height = 304+$this->object_height;
	  } else {
	    $this->height= $this->object_height;
	  }
	} else { #'video'
	  //Need to use oembed-maxwidth/maxheight.
      $this->object_height = $this->height - 30;
	}
  }
}

class Vle_player extends Base_player {}

class Podcast_player extends Base_player {
  public $url;
  public $_short_url;
  public $_related_url;
  public $thumbnail_url;

  public $transcript_html;

  public $provider_name = 'oupodcast';
  public $provider_mid;
  public $_access; #Access control.
  public $_copyright;
  public $_track_id;
  public $_album_id;

  public $timestamp;
}
