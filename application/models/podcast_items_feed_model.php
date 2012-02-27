<?php
/** A model to get item meta-data from the podcast DB.
 *
 * @copyright Copyright 2011 The Open University.
 */
//2 March 2011.

class Podcast_items_model extends CI_Model {

	protected $db_pod;

	public function __construct() {
		parent::__construct();

		$this->db_pod = $this->load->database('podcast', TRUE);
	}
	
	// function to check to see if the file exists at the destination url
	function url_exists($url){
		$url = str_replace("http://", "", $url);
		if (strstr($url, "/")) {
			$url = explode("/", $url, 2);
			$url[1] = "/".$url[1];
		} else {
			$url = array($url, "/");
		}

		$fh = fsockopen($url[0], 80);
		if ($fh) {
			fputs($fh,"GET ".$url[1]." HTTP/1.1\nHost:".$url[0]."\n\n");
			if (fread($fh, 22) == "HTTP/1.1 404 Not Found") { return FALSE; }
			else { return TRUE;    }

		} else { return FALSE;}
	}



	function xml2array($contents, $get_attributes=1, $priority = 'tag') {
		if(!$contents) return array();

		if(!function_exists('xml_parser_create')) {
			//print "'xml_parser_create()' function not found!";
			return array();
		}

		//Get the XML parser of PHP - PHP must have this module for the parser to work
		$parser = xml_parser_create('');
		xml_parser_set_option($parser, XML_OPTION_TARGET_ENCODING, "UTF-8"); # http://minutillo.com/steve/weblog/2004/6/17/php-xml-and-character-encodings-a-tale-of-sadness-rage-and-data-loss
		xml_parser_set_option($parser, XML_OPTION_CASE_FOLDING, 0);
		xml_parser_set_option($parser, XML_OPTION_SKIP_WHITE, 1);
		xml_parse_into_struct($parser, trim($contents), $xml_values);
		xml_parser_free($parser);

		if(!$xml_values) return;//Hmm...

		//Initializations
		$xml_array = array();
		$parents = array();
		$opened_tags = array();
		$arr = array();

		$current = &$xml_array; //Refference

		//Go through the tags.
		$repeated_tag_index = array();//Multiple tags with same name will be turned into an array
		foreach($xml_values as $data) {
			unset($attributes,$value);//Remove existing values, or there will be trouble

			//This command will extract these variables into the foreach scope
			// tag(string), type(string), level(int), attributes(array).
			extract($data);//We could use the array by itself, but this cooler.

			$result = array();
			$attributes_data = array();

			if(isset($value)) {
				if($priority == 'tag') $result = $value;
				else $result['value'] = $value; //Put the value in a assoc array if we are in the 'Attribute' mode
			}

			//Set the attributes too.
			if(isset($attributes) and $get_attributes) {
				foreach($attributes as $attr => $val) {
					if($priority == 'tag') $attributes_data[$attr] = $val;
					else $result['attr'][$attr] = $val; //Set all the attributes in a array called 'attr'
				}
			}

			//See tag status and do the needed.
			if($type == "open") {//The starting of the tag '<tag>'
				$parent[$level-1] = &$current;
				if(!is_array($current) or (!in_array($tag, array_keys($current)))) { //Insert New tag
					$current[$tag] = $result;
					if($attributes_data) $current[$tag. '_attr'] = $attributes_data;
					$repeated_tag_index[$tag.'_'.$level] = 1;

					$current = &$current[$tag];

				} else { //There was another element with the same tag name

					if(isset($current[$tag][0])) {//If there is a 0th element it is already an array
						$current[$tag][$repeated_tag_index[$tag.'_'.$level]] = $result;
						$repeated_tag_index[$tag.'_'.$level]++;
					} else {//This section will make the value an array if multiple tags with the same name appear together
						$current[$tag] = array($current[$tag],$result);//This will combine the existing item and the new item together to make an array
						$repeated_tag_index[$tag.'_'.$level] = 2;

						if(isset($current[$tag.'_attr'])) { //The attribute of the last(0th) tag must be moved as well
							$current[$tag]['0_attr'] = $current[$tag.'_attr'];
							unset($current[$tag.'_attr']);
						}

					}
					$last_item_index = $repeated_tag_index[$tag.'_'.$level]-1;
					$current = &$current[$tag][$last_item_index];
				}

			} elseif($type == "complete") { //Tags that ends in 1 line '<tag />'
				//See if the key is already taken.
				if(!isset($current[$tag])) { //New Key
					$current[$tag] = $result;
					$repeated_tag_index[$tag.'_'.$level] = 1;
					if($priority == 'tag' and $attributes_data) $current[$tag. '_attr'] = $attributes_data;

				} else { //If taken, put all things inside a list(array)
					if(isset($current[$tag][0]) and is_array($current[$tag])) {//If it is already an array...

						// ...push the new element into that array.
						$current[$tag][$repeated_tag_index[$tag.'_'.$level]] = $result;

						if($priority == 'tag' and $get_attributes and $attributes_data) {
							$current[$tag][$repeated_tag_index[$tag.'_'.$level] . '_attr'] = $attributes_data;
						}
						$repeated_tag_index[$tag.'_'.$level]++;

					} else { //If it is not an array...
						$current[$tag] = array($current[$tag],$result); //...Make it an array using using the existing value and the new value
						$repeated_tag_index[$tag.'_'.$level] = 1;
						if($priority == 'tag' and $get_attributes) {
							if(isset($current[$tag.'_attr'])) { //The attribute of the last(0th) tag must be moved as well

								$current[$tag]['0_attr'] = $current[$tag.'_attr'];
								unset($current[$tag.'_attr']);
							}

							if($attributes_data) {
								$current[$tag][$repeated_tag_index[$tag.'_'.$level] . '_attr'] = $attributes_data;
							}
						}
						$repeated_tag_index[$tag.'_'.$level]++; //0 and 1 index is already taken
					}
				}

			} elseif($type == 'close') { //End of tag '</tag>'
				$current = &$parent[$level-1];
			}
		}

		return($xml_array);
	}




	public function get_item($basename, $shortcode=NULL, $captions=FALSE) {

		$pod_base = Oupodcast_serv::POD_BASE;
		$file=$pod_base."/feeds/$basename/".config_item('podcast_feed_file');

		// Confirm RSS file containing player data exists
		if(file($file)){
			$rawrssdata =  $this->xml2array(file_get_contents($file));
		}
		else{
			echo "<p>This media item is currently unavailable. It will appear here once it has been transcoded.</p> <!--$file does not exist.--> ";
			die();
		}
		// Confirm the RSS file has item elements
		try{
			if(array_key_exists('item', $rawrssdata['rss']['channel'])){
				//			require_once('dBug.php');
				// Loop round items looking for the one that matches the shortcode

				// count how many items there are
				if (!isset($rawrssdata['rss']['channel']['item'][0])){
					$rssdata[0]=$rawrssdata['rss']['channel']['item'];
				}
				else{
					$rssdata = $rawrssdata['rss']['channel']['item'];
				}

				foreach($rssdata as $rssitem){
				
					// BH 20111102 - added test to check $rssitem['atom:link_attr']['href'] exists before trying to explode it
					if (isset($rssitem['atom:link_attr']['href'])) {
				
						$explodedshortcodeurl=explode('#', $rssitem['atom:link_attr']['href']);
						// If the shortcode is found populate variables with the data from that item.
						if($explodedshortcodeurl[1]==$shortcode){
							$rssshortcode=$explodedshortcodeurl[1];
							$rsstitle=$rssitem['title'];
							$rssdesc=$rssitem['description'];
							$rssduration=$rssitem['itunes:duration'];
							$rsspubdate=$rssitem['pubDate'];
	
							$rssmediafilename=explode('/', $rssitem['guid']);
							$rssmediafilename=end($rssmediafilename);
							if(!$this->url_exists($pod_base."/feeds/$basename/$rssmediafilename")){
								echo "<p>Sorry this video is currently unavailable. <!--$rssmediafilename does not exist, it may still be transcoding --></p>";
								die();
							}
	
							$rssitemimage=explode('/', $rssitem['media:thumbnail_attr']['url']);
							$rssitemimage=end($rssitemimage);  // poster image
							if(!$this->url_exists($pod_base."/feeds/$basename/$rssitemimage")){
								// Media Thumbnail doesn't seem to exist so fall back to use the podcast thumb, if that exists
								$rsspodcastimage=end(explode('/', $rawrssdata['rss']['channel']['image']['url']));
	
								if($this->url_exists($pod_base."/feeds/$basename/".$rsspodcastimage)){
									// we found a podcast level thumkbnail so use that oiver the default.
									$rssitemimage=$rsspodcastimage;
								}
								else{
									// There is no podcast thumbnail either so we have to use the default thumb image.
									$rssitemimage="../default-project-thumbnail.png";
								}
	
							}
						}
					}
				}



			}

		}
		catch(Exception $e){
			echo 'ERROR: ' . $e->getMessage();
			echo "<p>Sorry this video is currently unavailable.</p>  <!--$file exists but does not contain any items. -->";
			die();
		}



		// The data to returm.  Some of it hardcoded as its not present in the RSS.
		$result = (object) array(
		'pod_title'=>$rsstitle,
		'pod_summary'=> $rssdesc,
		'podcast_id'=> '',
		'duration'=> $rssduration,
		'custom_id' => $basename,
		'shortcode' => $rssshortcode,
		'filename' => $rssmediafilename,
		'image' => $rssitemimage,	//image filename as is
		'image_filename' => '',	 	// image filename that it will add .jpg to
		'private' => 'N',
		'intranet_only' => 'N',
		'published' => 'Y',
		'deleted' => 'N',
		'preferred_url' => '',
		'target_url_text' => '',
		'target_url' => '',
		'itunes_u_url' => '',
		'aspect_ratio' => '',
		'keywords' => '',
		'title' => $rsstitle,
		'publication_date' => $rsspubdate,
		'copyright' => '',
		'source_media' => '',
		'published_flag' => '',
		'pim_type' => 'desktop-all'
		);

		if ($result) {
			return $result;
		}
		return FALSE;
	}


}
