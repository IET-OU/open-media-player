<?php
/**
 * A model to get item meta-data from a podcast RSS feed.
 *
 * @copyright Copyright 2011 The Open University.
 * @author Jamie Daniels <j.d.daniels @ open.ac.uk>, May-July 2011.
 * @author Nick Freear, March 2012.
 */
require_once 'podcast_items_abstract_model.php';


class Podcast_items_feed_model extends Podcast_items_abstract_model
{

    const COLLECTION_ID = '__COLLECTION_ID__';


    public function __construct()
    {
        parent::__construct();

        $this->load->library('Http');
    }

    /** Test OU Podcast feed configuration and shortcode, and return the feed URL.
    * @return string
    */
    protected function _feed_url($basename, $shortcode)
    {
        $url_pattern = $this->config->item('podcast_feed_url_pattern');
        $locate = "\$config[podcast_feed_url_pattern] in 'config/embed_config.php'";

        if (! $url_pattern) {
            //ERROR 503.
            $this->_error("Missing or empty $locate", 503.1);
        }
        if (false !== strpos($url_pattern, 'example.org')) {
            $this->_error("Invalid host in $locate", 503.2);
        }
        if (false === strpos($url_pattern, self::COLLECTION_ID)) {
            $this->_error("Missing {". self::COLLECTION_ID. "} in $locate", 503.3);
        }
        $pu = parse_url($url_pattern);
        if (!isset($pu['scheme']) || !isset($pu['host']) || !isset($pu['path'])) {
            $this->_error("Invalid URL in $locate", 503.4);
        }

        if (strlen($shortcode) != OUP_PODCAST_SHORTCODE_SIZE) {
            //ERROR 400..
            $this->_error('Sorry, I expect a '. OUP_PODCAST_SHORTCODE_SIZE .' character shortcode', 400.1);
        }
        if (! preg_match(OUP_PODCAST_SHORTCODE_REGEX, $shortcode)) {
            $this->_error('Sorry, unexpected characters in shortcode.', 400.2);
        }


        return str_replace(self::COLLECTION_ID, $basename, $url_pattern);

     /*
     $podcast_feed_file = $this->config->item('podcast_feed_file');
     if (! $podcast_feed_file) {
      //ERROR 503.
      $this->_error("(feed error) \$config[podcast_feed_file] appears to be empty in 'config/embed_config.php'", 503);
     }
     $pod_base = Oupodcast_serv::POD_BASE;
     $url = $pod_base."/feeds/$basename/". $podcast_feed_file;
     */
    }


    public function get_item($basename, $shortcode = null, $captions = false)
    {

        $url = $this->_feed_url($basename, $shortcode);

        // Set a cookie (intranet-restricted content), and don't spoof. [iet-it-bugs:1463][Bug: #1]
        $result = $this->http->request($url, $spoof = false /*, array('cookie' => 'pod.auth=PASSED')*/);
        if (! $result->success) {
            //ERROR.
            $_data = $result->data;
            $result->data = $_data ? substr($_data, 0, 240) .' ... ' : $_data;
            $this->CI->_debug($result);

            if ($result->info['http_code'] == 404) {
                $this->_error(
                    "Podcast data collection deleted or not found.",
                    404.1,
                    null,
                    array('url'=>$url)
                );
            }
            // Other errors:
            $this->_error("Podcast data unknown error.", $result->info['http_code'], null, $result);
        }

        $this->_xmlo = $xmlo = @simplexml_load_string($result->data);

        if (! $xmlo) {
            //ERROR: this can be caused by network errors, or invalid XML.
            $this->CI->_debug($url);
            $this->CI->_debug(substr($result->data, 0, 122) .' ... ');
            $this->_error(
                "Podcast data XML error.",
                400.3,
                null,
                array('url'=>$url)
            );
        }

        foreach ($this->_xml_namespaces() as $prefix => $ns_uri) {
            $bok = $xmlo->registerXPathNamespace($prefix, $ns_uri);
        }

        $xpath_url = '//atom:link[contains(@href, "pod/'. $basename .'/#!'. $shortcode .'")]';
        $xpath_item = $xpath_url .'/..';
        $item = $xmlo->xpath($xpath_item);

        if (isset($item[0])) {
            $item = $item[0];
        } else {
            //ERROR.
            $this->_error("Podcast data item not found.", 404.2);
            return false;
        }

        // Access control.
        $access = array(
        #Item-level: (bool) cast.
            'published_flag' => $this->_xpath_val($xpath_item .'/oup:published_flag'),
        #Podcast-level
        //'intranet_only' => $this->_xpath_val('//oup:restrict_access'),
            'intranet_only' => $this->_xpath_val('//oup:intranet_only'),
            'private' => $this->_xpath_val('//oup:private'),
            'deleted' => $this->_xpath_val('//oup:deleted'),

       /*'_published_flag' => 'yes' != $this->_xpath_val('//app:draft'),
       '_intranet_only' => count( $xmlo->xpath('//yt:state[@reasonCode="oup:intranet_only"]') ),
       '_private' => count( $xmlo->xpath('//yt:private') ),
       '_deleted' => count( $xmlo->xpath('//yt:state[@name="deleted"]') ),
       '_processing' => count( $xmlo->xpath('//yt:state[@name="processing"]') ),
       '_list_allowed' => count( $xmlo->xpath('//yt:accessControl[@action="list"][@permission="allowed"]') ),
       */

            '_embed_allowed' => null,
        );
        $access['published'] = $access['published_flag'];

        $vars = array(
          'title' => (string) $xmlo->channel->title .': '. $item->title,
          'pod_title' => (string) $xmlo->channel->title,
          'summary' => (string) $xmlo->channel->description,
          '_copyright' => (string) $xmlo->channel->copyright,

          'item_title' => (string) $item->title,
          'item_summary' => (string) $item->description,
          'timestamp' => strtotime((string) $item->pubDate),  #?
          'media_url' => (string) $item->enclosure->attributes()->url,
          'media_length' => (string) $item->enclosure->attributes()->length,
          'media_html5' => true,
          'mime_type' => (string) $item->enclosure->attributes()->type,
          'poster_url' => $this->_xpath_val($xpath_item .'/media:thumbnail', 'url'),

          'transcript_url' => $this->_xpath_val($xpath_item .'/atom:link[@type="application/pdf"]', 'href'),
          'transcript_html_url' => $this->_xpath_val($xpath_item .'/atom:link[@type="text/html"][@rel="oup:transcript"]', 'href'),
          'caption_url' => $this->_xpath_val($xpath_item .'/atom:link[@type="application/ttml+xml"]', 'href'), #?

          '_track_md5' => $shortcode,
          '_album_id' => $basename,
          'provider_mid' => "$basename/$shortcode", #?
          'url' => $this->_xpath_val($xpath_item .'/atom:link[@rel="oup:longlink"]', 'href'),
          '_short_url' => $this->_xpath_val($xpath_url, 'href'),
          // Iframe - see Oupodcast_serv::_post_process()
          'iframe_url' => null,

          'link' => $this->_xpath_val('//channel/atom:link[@rel="related"]', 'href'),
          'link_text' => $this->_xpath_val('//channel/atom:link[@rel="related"]', 'title'),
          'target_url' => $this->_xpath_val($xpath_item .'/atom:link[@rel="related"]', 'href'),
          'target_text' => $this->_xpath_val($xpath_item .'/atom:link[@rel="related"]', 'title'),

          '_itunes_url' => $this->_xpath_val('//atom:link[@rel="oup:ituneslink"]', 'href'), #oup:rel-itunes-url
          '_youtube_url' => $this->_xpath_val($xpath_item .'/atom:content[contains(@src, "youtube.com")]', 'src'), #'), #[@type="application/x-shockwave-flash"]
          'duration_orig' => $this->_xpath_val($xpath_item .'/itunes:duration'),
          'duration' => 0,
          'aspect_ratio' => $this->_xpath_val($xpath_item .'/oup:aspect_ratio'),

          '_access' => $access,

          #'_' => $item,
        );

        // Post process the duration, youtube URL etc.
        $duration = $vars['duration_orig'];
        if (preg_match('/\d{2}:\d{2}:\d{2}/', $duration)) {
            $vars['duration'] = strtotime("1970-01-01T".$vars['duration_orig']. "GMT");
        }

        $vars['media_type'] = substr($vars['mime_type'], 0, strpos($vars['mime_type'], '/'));

        if ($vars['_youtube_url']) {
            $vars['youtube_id'] = preg_replace(array('#^.+v\/#', '#\?.*$#'), '', $vars['_youtube_url']);
        }

        return (object) $vars;
    }

    

    /** Safely get an element or attribute value for SimpleXML.
    * @return string
    */
    protected function _xpath_val($expr, $attr = null)
    {
        $reso = $this->_xmlo->xpath($expr);
        if (isset($reso[0])) {
            if ($attr) {
                return (string) $reso[0]->attributes()->{$attr}[0];
            }
            return (string) $reso[0];
        }
        return false;
    }

    /** Return all of the XML namespaces, and prefixes used in OU podcast RSS.
    * @return array
    */
    protected function _xml_namespaces()
    {
        $NAMESPACES = array(
        # http://validator.w3.org/feed/docs/howto/declare_namespaces.html
        # http://w3.org/TR/html5/namespaces.html
        /*'fn' => 'http://www.w3.org/2005/xpath-functions',
        'xmlns' => 'http://www.w3.org/2000/xmlns/',
        'xml' => 'http://www.w3.org/XML/1998/namespace',
        'html' => 'http://www.w3.org/1999/xhtml',
        'rss2' => 'http://backend.userland.com/rss2',*/

            'atom' => 'http://www.w3.org/2005/Atom',
            'app' => 'http://www.w3.org/2007/app',

            'itunes' => 'http://www.itunes.com/dtds/podcast-1.0.dtd',
            'itunesu' => 'http://www.itunesu.com/feed',
            'media' => 'http://search.yahoo.com/mrss/',

            'gd' => 'http://schemas.google.com/g/2005',
            'yt' => 'http://gdata.youtube.com/schemas/2007',
            'openSearch' => 'http://a9.com/-/spec/opensearch/1.1/',

            's' => 'http://purl.org/steeple',
            'oup' => 'http://podcast.open.ac.uk/2012',
            'oupod_' => 'http://purl.org/net/oupod/',
        );
        return $NAMESPACES;
    }


    // function to check to see if the file exists at the destination url
    protected function url_exists($url)
    {
        $url = str_replace("http://", "", $url);
        if (strstr($url, "/")) {
            $url = explode("/", $url, 2);
            $url[1] = "/".$url[1];
        } else {
            $url = array($url, "/");
        }

        $fh = fsockopen($url[0], 80);
        if ($fh) {
            fputs($fh, "GET ".$url[1]." HTTP/1.1\nHost:".$url[0]."\n\n");
            if (fread($fh, 22) == "HTTP/1.1 404 Not Found") {
                return false;
            } else {
                return true;
            }

        } else {
            return false;
        }
    }

    /**
    * xml2array
    * lz_speedy at web dot de 30-Dec-2008 10:20
    * http://www.php.net/manual/en/function.xml-parse.php#87920
    */
    protected function xml2array($contents, $get_attributes = 1, $priority = 'tag')
    {
        if (!$contents) {
            return array();
        }

        if (!function_exists('xml_parser_create')) {
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

        if (!$xml_values) {
            return;//Hmm...
        }
        // Initializations
        $xml_array = array();
        $parents = array();
        $opened_tags = array();
        $arr = array();

        $current = &$xml_array; //Refference

        // Go through the tags.
        $repeated_tag_index = array();//Multiple tags with same name will be turned into an array
        foreach ($xml_values as $data) {
            unset($attributes,$value);//Remove existing values, or there will be trouble

         // This command will extract these variables into the foreach scope
         // tag(string), type(string), level(int), attributes(array).
            extract($data);//We could use the array by itself, but this cooler.

            $result = array();
            $attributes_data = array();

            if (isset($value)) {
                if ($priority == 'tag') {
                    $result = $value;
                } else {
                    $result['value'] = $value; //Put the value in a assoc array if we are in the 'Attribute' mode
                }
            }

            // Set the attributes too.
            if (isset($attributes) and $get_attributes) {
                foreach ($attributes as $attr => $val) {
                    if ($priority == 'tag') {
                        $attributes_data[$attr] = $val;
                    } else {
                        $result['attr'][$attr] = $val; //Set all the attributes in a array called 'attr'
                    }
                }
            }

            // See tag status and do the needed.
            if ($type == "open") {
                // The starting of the tag '<tag>'
                $parent[$level-1] = &$current;
                if (!is_array($current) or (!in_array($tag, array_keys($current)))) {
                    // Insert New tag
                    $current[$tag] = $result;
                    if ($attributes_data) {
                        $current[$tag. '_attr'] = $attributes_data;
                    }
                    $repeated_tag_index[$tag.'_'.$level] = 1;

                    $current = &$current[$tag];

                } else {
                    // There was another element with the same tag name

                    if (isset($current[$tag][0])) {
                        //If there is a 0th element it is already an array
                        $current[$tag][$repeated_tag_index[$tag.'_'.$level]] = $result;
                        $repeated_tag_index[$tag.'_'.$level]++;
                    } else {
              //This section will make the value an array if multiple tags with the same name appear together
                        $current[$tag] = array($current[$tag],$result);//This will combine the existing item and the new item together to make an array
                        $repeated_tag_index[$tag.'_'.$level] = 2;

                        if (isset($current[$tag.'_attr'])) {
               //The attribute of the last(0th) tag must be moved as well
                            $current[$tag]['0_attr'] = $current[$tag.'_attr'];
                            unset($current[$tag.'_attr']);
                        }

                    }
                    $last_item_index = $repeated_tag_index[$tag.'_'.$level]-1;
                    $current = &$current[$tag][$last_item_index];
                }

            } elseif ($type == "complete") {
                // Tags that ends in 1 line '<tag />'
                // See if the key is already taken.
                if (!isset($current[$tag])) {
                    // New Key
                    $current[$tag] = $result;
                    $repeated_tag_index[$tag.'_'.$level] = 1;
                    if ($priority == 'tag' and $attributes_data) {
                        $current[$tag. '_attr'] = $attributes_data;
                    }

                } else {
                    // If taken, put all things inside a list(array)
                    if (isset($current[$tag][0]) and is_array($current[$tag])) {
                        // If it is already an array...

                        // ...push the new element into that array.
                        $current[$tag][$repeated_tag_index[$tag.'_'.$level]] = $result;

                        if ($priority == 'tag' and $get_attributes and $attributes_data) {
                            $current[$tag][$repeated_tag_index[$tag.'_'.$level] . '_attr'] = $attributes_data;
                        }
                        $repeated_tag_index[$tag.'_'.$level]++;

                    } else {
                        // If it is not an array...
                        $current[$tag] = array($current[$tag],$result); //...Make it an array using using the existing value and the new value
                        $repeated_tag_index[$tag.'_'.$level] = 1;
                        if ($priority == 'tag' and $get_attributes) {
                            if (isset($current[$tag.'_attr'])) {
                  //The attribute of the last(0th) tag must be moved as well

                                $current[$tag]['0_attr'] = $current[$tag.'_attr'];
                                unset($current[$tag.'_attr']);
                            }

                            if ($attributes_data) {
                                $current[$tag][$repeated_tag_index[$tag.'_'.$level] . '_attr'] = $attributes_data;
                            }
                        }
                        $repeated_tag_index[$tag.'_'.$level]++; //0 and 1 index is already taken
                    }
                }

            } elseif ($type == 'close') {
                // End of tag '</tag>'
                $current = &$parent[$level-1];
            }
        }

        return ($xml_array);
    }

    /**
    * @author Jamie Daniels.
    */
    public function get_item_v1($basename, $shortcode = null, $captions = false)
    {

        $pod_base = Oupodcast_serv::POD_BASE;
        $file=$pod_base."/feeds/$basename/".config_item('podcast_feed_file');

        // Confirm RSS file containing player data exists
        if (file($file)) {
            $rawrssdata =  $this->xml2array(file_get_contents($file));
        } else {
            echo "<p>This media item is currently unavailable. It will appear here once it has been transcoded.</p> <!--$file does not exist.--> ";
            die();
        }
        // Confirm the RSS file has item elements
        try {
            if (array_key_exists('item', $rawrssdata['rss']['channel'])) {
             //			require_once('dBug.php');
             // Loop round items looking for the one that matches the shortcode

             // count how many items there are
                if (!isset($rawrssdata['rss']['channel']['item'][0])) {
                    $rssdata[0]=$rawrssdata['rss']['channel']['item'];
                } else {
                    $rssdata = $rawrssdata['rss']['channel']['item'];
                }

                foreach ($rssdata as $rssitem) {
                    // BH 20111102 - added test to check $rssitem['atom:link_attr']['href'] exists before trying to explode it
                    if (isset($rssitem['atom:link_attr']['href'])) {
                        $explodedshortcodeurl=explode('#', $rssitem['atom:link_attr']['href']);
                    // If the shortcode is found populate variables with the data from that item.
                        if ($explodedshortcodeurl[1]==$shortcode) {
                            $rssshortcode=$explodedshortcodeurl[1];
                            $rsstitle=$rssitem['title'];
                            $rssdesc=$rssitem['description'];
                            $rssduration=$rssitem['itunes:duration'];
                            $rsspubdate=$rssitem['pubDate'];
    
                            $rssmediafilename=explode('/', $rssitem['guid']);
                            $rssmediafilename=end($rssmediafilename);
                            if (!$this->url_exists($pod_base."/feeds/$basename/$rssmediafilename")) {
                                echo "<p>Sorry this video is currently unavailable. <!--$rssmediafilename does not exist, it may still be transcoding --></p>";
                                die();
                            }
    
                            $rssitemimage=explode('/', $rssitem['media:thumbnail_attr']['url']);
                            $rssitemimage=end($rssitemimage);  // poster image
                            if (!$this->url_exists($pod_base."/feeds/$basename/$rssitemimage")) {
                             // Media Thumbnail doesn't seem to exist so fall back to use the podcast thumb, if that exists
                                $rsspodcastimage=end(explode('/', $rawrssdata['rss']['channel']['image']['url']));
    
                                if ($this->url_exists($pod_base."/feeds/$basename/".$rsspodcastimage)) {
                                 // we found a podcast level thumkbnail so use that oiver the default.
                                    $rssitemimage=$rsspodcastimage;
                                } else {
                                 // There is no podcast thumbnail either so we have to use the default thumb image.
                                    $rssitemimage="../default-project-thumbnail.png";
                                }
    
                            }
                        }
                    }
                }

            }

        } catch (Exception $e) {
            echo 'ERROR: ' . $e->getMessage();
            echo "<p>Sorry this video is currently unavailable.</p>  <!--$file exists but does not contain any items. -->";
            die();
        }


     // The data to return.  Some of it hardcoded as its not present in the RSS.
        $result = (object) array(
            'pod_title'=>$rsstitle,
            'pod_summary'=> $rssdesc,
            'podcast_id'=> '',
            'duration'=> $rssduration,
            'custom_id' => $basename,
            'shortcode' => $rssshortcode,
            'filename' => $rssmediafilename,
            'image' => $rssitemimage,    //image filename as is
            'image_filename' => '',         // image filename that it will add .jpg to
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
        return false;
    }
}
