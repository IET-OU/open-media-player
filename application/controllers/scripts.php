<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Dynamically create Javascripts, for delivery and caching.
 *
 * @copyright Copyright 2011 The Open University.
 * @author N.D.Freear, 4 March 2011.
 *
 * Caching: 
http://stackoverflow.com/questions/1971721/how-to-use-http-cache-headers-with-php#v3
http://www.mnot.net/cache_docs/
 */

class Scripts extends MY_Controller {

  public function __construct() {
      parent::__construct();

  }

  /** oEmbed jQuery plugin, scripts/jquery.oembed.js
  */
  public function jquery_oembed($cache_minutes=10) {

      $cache_key = 'scripts_jquery.oembed.js';
      $this->_cache_init($cache_key);

      ob_start();
      require_once APPPATH.'assets/client/jquery.oembed.js';
      $script = ob_get_clean();

      $oembed_url = base_url().'oembed';
      $script_prov ='';

      $this->config->load('providers');
      // Other providers.
	  $others = $this->config->item('providers_other');
	  foreach ($others as $domain => $provider) {
	    $name = strtolower($provider['name']);
		$type = $provider['type'];
		$regex = '"'.str_replace('.', '\.', $domain).'"';
		$oembed_other = null;
		if (isset($provider['endpoint'])) {
		    $oembed_other = ", '{$provider['endpoint']}'";
		}
		//$script_prov .= '    '."new OEmbedProvider('$name', '$domain'$oembed_other),".PHP_EOL; #plugin.r20.
		$script_prov .= "\t\t"."new \$.fn.oembed.OEmbedProvider('$name', '$type', [$regex]$oembed_other),".PHP_EOL; #plugin.r23.
	  }
	  // OU embed providers.
	  $providers = $this->config->item('providers');
      foreach ($providers as $domain => $provider) {
		if (is_string($provider)) {
		  # New Jul 2012: loose coupling (iet-it-bugs:1356)
		  $this->load->oembed_provider($provider);

		  $name = $this->provider->getName();
		  $type = $this->provider->getType();
		} else {
		  # Legacy.
		$name = strtolower($provider['name']);
		$type = $provider['type'];
		}
		$regex = '"'.str_replace('.', '\.', $domain).'"';
		$script_prov .= "\t\t"
        //   ."new OEmbedProvider('ouplayer', '$domain', '$oembed_url'),".PHP_EOL;
             ."new \$.fn.oembed.OEmbedProvider('$name', '$type', [$regex], '$oembed_url'),".PHP_EOL;
      }

	  // http://code.google.com/p/oohembed/issues/detail?id=14
	  #$script = str_replace(': "http://oohembed.com/oohembed/"', ': "http://api.embed.ly/v1/api/oembed"', $script);
	  $script = str_replace(': "oohembed"', ': "embed.ly"', $script);
      $out = '/*auto-generated: '.date('c').' */'.PHP_EOL
          .str_replace('/*__PROVIDERS__*/', $script_prov, $script);

      $this->_cache_save($cache_key, $out);

      //$out .= PHP_EOL.'/*'. var_export($this->cache->get_metadata($cache_key), true).'*/';

      header('Content-Type: application/x-javascript; charset=utf-8');
      @header('Content-Disposition: inline; filename=jquery.oembed.js');
      @header('Content-Length: '.strlen($out));
      echo $out;
  }

  /**Get/generate minified/concatenated Javascript for embedded/popup OU player / LEGACY 2011 themes.
   *   jsbin/embed-ouplayer.{mtime}.js
   */
  public function embed_ouplayer_js($mtime=null) {
    header('Content-Type: application/x-javascript; charset=utf-8');

    $cache_key = 'scripts_embed_ouplayer.min.js';
    $this->_cache_init($cache_key);

    $assets = array(
      #http://ouan.open.ac.uk/sitestat.js
      'flowplayer/flowplayer-3.2.6.min.js',
      'flowplayer/flowplayer.controls-OUP.js',
      'ouplayer/ouplayer.tooltips.js',
      'ouplayer/ouplayer.behaviors.js',
    );
    $out = '/* Woops! */';
    if (!cache_exists($cache_key)) {
        $out = $this->_join_yuicompress($assets);
    }
    $this->_cache_save($cache_key, $out);

    echo $out;
  }

  /** Run YUI Compressor and concatenate arbitrary Javascripts.
  * @return string
  */
  protected function _join_yuicompress($assets, $ctype='application/x-javascript') {
    #@header("Content-Type: $ctype; charset=utf-8");
    $out = array();
    foreach ($assets as $file) {
      $input = APPPATH."assets/$file";
      $out[] = PHP_EOL."/*:$file*/";
      if (preg_match('#\.min\.#', $file)) {
        // Already compressed.
        $out[] = file_get_contents($input);
      } else {
        //java -jar yuicompressor-x.y.z.jar [options] [input file]
        $jar_path = APPPATH."libraries/yuicompressor/yuicompressor-2.4.6.jar";
        $cmd = "java -jar $jar_path --charset utf-8 $input";
        $res = exec($cmd, $out, $ret);
        if (0!=$ret) {
          // Error. (Can we get the error-output?)
          $out[] = "/* Error. YUI Compressor returned: $ret ($file) */";
        }
      }
    }
    $out = implode(PHP_EOL, $out);

    return $out;
  }

  protected function _cache_save($key, $payload) {
      $minutes = $this->config->item('cache_minutes'); /*FALSE===$this->config->item('cache_minutes')
                  ? 2 : $this->config->item('cache_minutes');*/
      if (!$minutes) return;

      $this->cache->save($key, $payload, $minutes*60); #'scripts/jquery.oembed.js'
  }

  protected function _cache_init($key) {
      // Start with a low value for caching. (No, set expires headers in .htaccess/ httpd.conf)
      $cache = $this->input->get('cache');
      $minutes = $this->config->item('cache_minutes');
      if (!$minutes) return;

      $this->load->driver('cache', array('adapter'=>'file')); #,array('adapter'=>'apc', 'backup'=>'file'));

      if ('-1'==$cache) {
        // Delete the server cache, and bypass the 304 response
        @header('X-Cache-0: clear');
        $this->cache->delete($key);

      } elseif ($minutes) {

        $stat = $this->cache->get_metadata($key);

        # http://stackoverflow.com/questions/1971721/how-to-use-http-cache-headers-
    	# .. License: CC-by-sa
        $if_modified_since = $this->input->server('HTTP_IF_MODIFIED_SINCE');
        //$if_none_match = $this->input->server('HTTP_IF_NONE_MATCH');

		if (//(($if_none_match && $if_none_match == $etag) || (!$if_none_match)) &&
		    //($if_modified_since && $if_modified_since == $tsstring))
		    $if_modified_since && $if_modified_since < ($stat['mtime'] + $minutes*60)) //Check.
		{
    		header('HTTP/1.1 304 Not Modified');
    		exit();
        }

        header('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); //$stat['mtime']
        @header('Expires: '.gmdate('D, d M Y H:i:s', time()+$minutes*60).' GMT');#r.
        @header('Cache-Control: max-age='.($minutes*60).', must-revalidate');
      }
  }
}
