<?php
/** For now, dynamically create the oEmbed jQuery Javascript.
 * scripts/jquery.oembed.js
 *
 * Caching: 
http://stackoverflow.com/questions/1971721/how-to-use-http-cache-headers-with-php#v3
http://www.mnot.net/cache_docs/
 */
//NDF, 4 March 2011 (was: class Javascript)

class Scripts extends CI_Controller {

  public function __construct() {
      parent::__construct();

  }

  /** oEmbed jQuery plugin.
  */
  public function jquery_oembed($cache_minutes=10) {
      header('Content-Type: application/x-javascript; charset=utf-8');
      @header('Content-Disposition: inline; filename=jquery.oembed.js');

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
	    $name = $provider['name'];
		$oembed_other = null;
		if (isset($provider['endpoint'])) {
		    $oembed_other = ", '{$provider['endpoint']}'";
		}
		$script_prov .= '    '."new OEmbedProvider('$name', '$domain'$oembed_other),".PHP_EOL;
	  }
	  // OU embed providers.
	  $providers = $this->config->item('providers');
      foreach ($providers as $domain => $provider) {
         $script_prov .= '    '
           ."new OEmbedProvider('ouplayer', '$domain', '$oembed_url'),".PHP_EOL;
      }

	  // http://code.google.com/p/oohembed/issues/detail?id=14
	  $script = str_replace(': "http://oohembed.com/oohembed/"', ': "http://api.embed.ly/v1/api/oembed"', $script);
      $out = '/*auto-generated: '.date('c').' */'.PHP_EOL
          .str_replace('/*__PROVIDERS__*/', $script_prov, $script);

      $this->_cache_save($cache_key, $out);

      //$out .= PHP_EOL.'/*'. var_export($this->cache->get_metadata($cache_key), true).'*/';

      @header('Content-Length: '.strlen($out));
      echo $out;
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

        header('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT');
        @header('Expires: '.gmdate('D, d M Y H:i:s', time()+$minutes*60).' GMT');#r.
        @header('Cache-Control: max-age='.($minutes*60).', must-revalidate');
      }
  }
}
