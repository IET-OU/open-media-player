<?php
/**
* OU player Javascript/ CSS builder.
* Creates a Closure Compiler build script.
*
* See mediaelement/src/Builder.py
* See oup-mep/src/build.php
*
* @link http://closure-compiler.appspot.com/home
* (http://www.minifyjs.com/javascript-compressor/)
* @copyright 2012 The Open University.
* @author N.D.Freear, 17 April 2012.
*/

class Build extends MY_Controller {

  public function theme($theme_name = 'ouplayer-base', $optimizations = 'simple') {	
	$theme_name = strtolower(str_replace('-', '_', $theme_name));
	$optimizations = strtoupper($optimizations);

	$this->load->theme($theme_name);

	$mep_scripts = $this->theme->javascripts;
    $base_url = base_url() .'application/';
    $rand = rand(0, 100);

    $closure = <<<EOF
<!doctype html><title>*Closure compiler script | OU Player</title>
<a href="http://closure-compiler.appspot.com/home">closure-compiler.appspot.com/home</a>
<pre>
// ==ClosureCompiler==
// @output_file_name mediaelement-and-ou-player.min.js
// @compilation_level {$optimizations}_OPTIMIZATIONS
//__URLS__// ==/ClosureCompiler==

</pre>
EOF;

    $url_list = '';
    foreach ($mep_scripts as $script) {
      $url_list .= "// @code_url $base_url$script?r=$rand".PHP_EOL;
    }

    echo str_replace('//__URLS__', $url_list, $closure);
  }  
}
