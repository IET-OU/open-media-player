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

  protected $_closure_template = <<<EOF
<h2>__OUTPUT__</h2>
<pre>
// ==ClosureCompiler==
// @output_file_name __OUTPUT__
// @compilation_level __LEVEL__
//__URLS__// ==/ClosureCompiler==

</pre>

EOF;


  public function theme($theme_name = 'oup-light', $optimizations = 'simple', $output = 'ouplayer.min') {	
    $theme_name = strtolower(str_replace('-', '_', $theme_name));
    #$optimizations = strtoupper($optimizations);


    $this->load->theme($theme_name);

?>
<!doctype html><title>*Closure compiler script | OU Player</title>
<a href="http://closure-compiler.appspot.com/home">closure-compiler.appspot.com/home</a>
<?php

    // Build script for minified Javascripts.
    echo $this->_closure($this->theme->javascripts, $this->theme->js_min, $optimizations);

    // Build script for minified Javascripts + Ender.
    $scripts_ender = array_merge(
      array(
        //OUP_JS_CDN_ENDER_MIN,
        'engines/mediaelement/src/js/jeesh.js',
        'engines/mediaelement/src/js/jeesh-extras.js'
      ),
      $this->theme->javascripts
    );
    echo $this->_closure($scripts_ender, str_replace('.min','-ender.min', $this->theme->js_min), $optimizations);

?>
<a href="http://ganquan.info/yui/">ganquan.info/yui</a> | <a href="http://refresh-sf.com/yui/">refresh-sf.com/yui</a>
<?php

    // Build script for stylesheet.
    echo $this->_closure($this->theme->styles, $this->theme->css_min, $optimizations);
  }

  /** Return a Closure build script for a given file array.
  */
  protected function _closure($file_array, $output, $comp_level = 'simple') {

    $base_url = base_url().'application/';
    $rand = rand(0, 100);

    $levels = array(
      0 => 'WHITESPACE_ONLY',
      'simple' => 'SIMPLE_OPTIMIZATIONS',
      'advanced' => 'ADVANCED_OPTIMIZATIONS',
    );
    $comp_level = $levels[$comp_level];
    $output = basename($output);

    $url_list = '';
    foreach ($file_array as $script) {
      $url_list .= "// @code_url $base_url$script?r=$rand".PHP_EOL;
    }

    $closure = str_replace(
      array('//__URLS__', '__OUTPUT__', '__LEVEL__'),
      array($url_list, $output, $comp_level),
      $this->_closure_template);

    return $closure;
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
