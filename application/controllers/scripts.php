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

  public function jquery_oembed($cache_minutes=10) {
      header('Content-Type: application/x-javascript; charset=utf-8');

      #$this->_cache($cache_minutes);

      ob_start();
      require_once APPPATH.'assets/client/jquery.oembed.js';
      $script = ob_get_clean();

      $oembed_url = base_url().'oembed';
      $script_prov ='';
      
      $this->config->load('providers');
      $providers = $this->config->item('providers');
      foreach ($providers as $domain => $provider) {
         $script_prov .= '    '
           ."new OEmbedProvider('ouplayer', '$domain', '$oembed_url'),".PHP_EOL;
      }
      $out = '/*auto-generated: '.date('c').' */'.PHP_EOL
          .str_replace('/*__PROVIDERS__*/', $script_prov, $script);

$this->load->driver('cache', array('adapter'=>'file')); #, array('adapter' => 'apc', 'backup' => 'file'));
$r = $this->cache->save('scripts/jquery.oembed.js', $out, 5*60);
$out .= PHP_EOL.'//'. var_export($this->cache->get_metadata('scripts/jquery.oembed.js'), true);

      @header('Content-Length: '.strlen($out));
      echo $out;
  }

  protected function _cache($minutes=10) {      
      // Start with a low value for caching. (No, set expires headers in .htaccess/ httpd.conf)
      if ('-1'==$minutes) {
        //Don't cache.
        /*echo '/*';
        var_dump($_SERVER);
        echo '*-/';*/
      } elseif ($minutes) {

        # http://stackoverflow.com/questions/1971721/how-to-use-http-cache-headers-
    	# .. License: CC-by-sa
        $if_modified_since = isset($_SERVER['HTTP_IF_MODIFIED_SINCE']) ? strtotime($_SERVER['HTTP_IF_MODIFIED_SINCE']) : false;
		//$if_none_match = isset($_SERVER['HTTP_IF_NONE_MATCH']) ? $_SERVER['HTTP_IF_NONE_MATCH'] : false;

		if (//(($if_none_match && $if_none_match == $etag) || (!$if_none_match)) &&
		    //($if_modified_since && $if_modified_since == $tsstring))
		    $if_modified_since && $if_modified_since < time() + $minutes*60) //-?
		{
    		header('HTTP/1.1 304 Not Modified');
    		exit();
        }

        @header('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT');
        @header('Expires: '.gmdate('D, d M Y H:i:s', time()+$minutes*60).' GMT');#r.
        @header('Cache-Control: max-age='.($minutes*60).', must-revalidate');
      }
  }
}
