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
* (http://www.lotterypost.com/css-compress.aspx)
* @copyright 2012 The Open University.
* @author N.D.Freear, 17 April 2012.
*/

class Build extends MY_Controller {

  public function theme($theme_name = 'oup-light', $optimizations = 'simple', $output = 'ouplayer.min') {	
    $theme_name = strtolower(str_replace('-', '_', $theme_name));
    $optimizations = strtoupper($optimizations);


    $this->load->theme($theme_name);

    $base_url = base_url() .'application/';
    $rand = rand(0, 100);

    $closure_template = <<<EOF
<!doctype html><title>*Closure compiler script | OU Player</title>
<a href="http://closure-compiler.appspot.com/home">closure-compiler.appspot.com/home</a>
<pre>
// ==ClosureCompiler==
// @output_file_name $output.js
// @compilation_level {$optimizations}_OPTIMIZATIONS
//__URLS__// ==/ClosureCompiler==
</pre>

EOF;

    $url_list = '';
    foreach ($this->theme->javascripts as $script) {
      $url_list .= "// @code_url $base_url$script?r=$rand".PHP_EOL;
    }

    echo str_replace('//__URLS__', $url_list, $closure_template);

    $this->_css($output);
  }


  protected function _css($output) {
    $base_url = base_url() .'application/';
    $rand = rand(0, 100);

    $css_template = <<<EOF

<a href="http://ganquan.info/yui/">ganquan.info/yui</a> | <a href="http://refresh-sf.com/yui/">refresh-sf.com/yui</a>
<pre>
// ==CssCompiler==
// @output_file_name $output.css
//__URLS__// ==/CssCompiler==
</pre>
EOF;

    $url_list = '';
    foreach ($this->theme->styles as $style) {
      $url_list .= "// @code_url $base_url$style?r=$rand".PHP_EOL;
    }

    echo str_replace('//__URLS__', $url_list, $css_template);
  }  
}
