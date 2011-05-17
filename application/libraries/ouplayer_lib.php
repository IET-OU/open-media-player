<?php
/** OU player library.
 *
 * @copyright Copyright 2011 The Open University.
 */
//NDF, 2011-04-07.

/* Ouplayer class - Holds meta-data for the player.
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
	$CI =& get_instance();
	// Need to move 'maxwidth'/maxheight calls into the oEmbed controller.
	$max_width = $CI->input->get('maxwidth');
	$max_height= $CI->input->get('maxheight');
	$resizable = $CI->input->get('_resizable');

	$rev_sizes = array(720=>460, 640=>410, 620=>400, 560=>340, 480=>360, 460=>350);
	#$sizes = array(460=>350, 480=>360, 560=>340, 620=>400, 640=>410, 720=>460);

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
	  if ($max_width) {
	    // Count down through the potential sizes.
	    foreach ($rev_sizes as $width => $height) {
		  if ($max_width >= $width) {
		    $this->width = $width;
			$this->height= $height;
			break;
		  }
		}
	  }
	  $this->object_height = $this->height - 30;

	  #var_dump($this->width, $this->height, $this->object_height);
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
  public $_track_md5;  #Was, _track_id (DB: shortcode)
  public $_podcast_id; #Numeric
  public $_album_id;   #Alpha-numeric (DB: custom_id)

  public $timestamp;
}
