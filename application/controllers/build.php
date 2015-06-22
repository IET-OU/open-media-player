<?php
/**
* OU player Javascript/ CSS builder.
*
* In Web mode creates a Closure Compiler build script.
* In cli mode builds using YUI Compressor.
*
*     Usage: $ \xampp\php\php index.php build/revision
*
* See mediaelement/src/Builder.py
* See oup-mep/src/build.php
*
* @link http://closure-compiler.appspot.com/home
* (http://www.minifyjs.com/javascript-compressor/)
* (http://www.lotterypost.com/css-compress.aspx)
*
* @copyright 2012 The Open University.
* @author N.D.Freear, 17 April 2012, -04-25.
*/

class Build extends \IET_OU\Open_Media_Player\MY_Controller
{

    protected $_closure_template = <<<EOF
<h2>__OUTPUT__</h2>
<pre>
// ==ClosureCompiler==
// @output_file_name __OUTPUT__
// @compilation_level __LEVEL__
//__URLS__// ==/ClosureCompiler==

</pre>

EOF;


    /** Build a 'revision' file (CLI).
  */
    public function revision()
    {
        if ($this->input->is_cli_request()) {
            $this->load->library('Gitlib', null, 'git');

            $result = $this->git->put_revision();

        } else {
            $this->_error('The page you requested was not found.', 404);
        }
    }


    /** Build a theme (Web/CLI).
  */
    public function theme($theme_name = 'oup-light', $optimizations = 'simple', $output = 'ouplayer.min')
    {
        $theme_name = strtolower(str_replace('-', '_', $theme_name));
      #$optimizations = strtoupper($optimizations);

        $this->load->theme($theme_name);

        if ($this->input->is_cli_request()) {
            $this->load->library('Gitlib', null, 'git');
            $result = $this->git->put_revision();

            $this->_cli_builder();
        } else {
            $this->_web_closure($optimizations);
        }
    }

    /** Print all theme Closure scripts in a Web page.
  */
    protected function _web_closure($optimizations)
    {

    ?>
  <!doctype html><title>*Closure compiler script | OU Player</title>
  <a href="http://closure-compiler.appspot.com/home">Closure-compiler.appspot.com</a>
   | <?php echo anchor('demo/info', 'OU Player admin info') ?>

<p>Theme name: <?php echo $this->theme->getDisplayname() ?> [<span id=theme><?php echo $this->theme->getName() ?></span>]

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
    echo $this->_closure($scripts_ender, str_replace('.min', '-ender.min', $this->theme->js_min), $optimizations);

    ?>
  <a href="http://ganquan.info/yui/">ganquan.info/yui</a> | <a href="http://refresh-sf.com/yui/">refresh-sf.com/yui</a>
    <?php

    // Build script for stylesheet.
    echo $this->_closure($this->theme->styles, $this->theme->css_min, $optimizations);
    }


    /** Return a Closure build script for a given file array.
  */
    protected function _closure($file_array, $output, $comp_level = 'simple')
    {

        $base_url = base_url() .APPPATH;
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
            $this->_closure_template
        );

        return $closure;
    }

    /** Build the theme CSS & Javascript at the commandline.
  */
    protected function _cli_builder()
    {

        $this->_build($this->theme->styles, $this->theme->css_min);

    }

    /** Build (join) and minify a given array of files.
  */
    protected function _build($file_array, $output)
    {
        echo "Building... $output".PHP_EOL;
  
        $app_path = dirname(__DIR__) .'/';
        $temp_file = $app_path. str_replace('.min', '', $output);

        $buffer = '';
        foreach ($file_array as $script) {
            $buffer .= file_get_contents($app_path. $script);
        }
        $res = file_put_contents($temp_file, $buffer);

        return $this->_yui_compress($temp_file, $app_path. $output);
    }

    /** Run YUI Compressor on a CSS or Javascript file.
  */
    protected function _yui_compress($input, $output)
    {
        define('YUI_COMPRESSOR', APPPATH .'libraries/yuicompressor/yuicompressor-2.4.6.jar');

        $cmd = "java -jar ".YUI_COMPRESSOR." $input -o $output -v --charset utf-8 ";
        $result = system($cmd);
        return $result;
    }
}
