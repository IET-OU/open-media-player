<?php  if (!defined('BASEPATH') && !defined('PDFTOHTML_PATH')) exit('No direct script access allowed');
/**
 * Convert PDF transcripts to clean HTML5 snippets.
 *
 * @copyright Copyright 2011 The Open University.
 * @author N.D.Freear, 25 March 2011.
 */


/* ============================================================

 pdftohtml binary installation (Redhat Linux)

 Uses: pdftohtml v0.39 (which uses xpdf) http://pdftohtml.sourceforge.net/
 @copyright 2003-6 Gueorgui Ovtcharov and Rainer Dorsch.
 @license GNU GPLv2.

 http://podcast.open.ac.uk/feeds/l314-spanish/transcript/l314audio2.pdf

 $ yum info poppler
 $ yum install poppler
 $ pdftohtml -v
 $ pdftohtml -i -noframes -enc UTF-8  l314audio2.pdf
 $ pdftohtml -stdout -xml -enc UTF-8  l314audio2.pdf
*/


/* ============================================================

 PHP usage:

// Standalone context.
define('PDFTOHTML_PATH', 'C:/Users/ndf42/workspace/_ouplayer_data/pdftohtml-0.39/pdftohtml.exe');  # Windows.
#define('PDFTOHTML_PATH', '/usr/bin/pdftohtml');  # Redhat 6.
require_once 'libraries/pdftohtml.php';

//( Or, CodeIgniter context. )
#$config['pdftohtml_path'] = '/usr/bin/pdftohtml';
#$this->load->library('pdftohtml');

$pdf = '/var/www/_ouplayer_data/transcripts/l314audio2.pdf'; #Ok.
#$pdf = '_test/oupod-entrep-invisable_transcript_00775_7600.pdf'; #Errors :(.
$xml = str_replace('.pdf', '.xml', $pdf);  //tmp file?
$ofile = str_replace('.pdf', '_transcript.html', $pdf);

try {
  $parser = new Pdftohtml();
  $out = $parser->parse($pdf, $xml);  #, $delete_xml = TRUE);
  $by = file_put_contents($ofile, $out);
  echo "Ok, written $by bytes | $ofile".PHP_EOL;
} catch(Exception $ex) {
  die('EX: '.$ex->getMessage().PHP_EOL);
}*/


class Pdftohtml {

  protected static $cmd_path = '/usr/bin/pdftohtml'; #Redhat 6.
  protected $CI;


  public function __construct() {
	$path = NULL;
	// CodeIgniter context.
	if (function_exists('get_instance')) {
	  $this->CI =& get_instance();
	  $path = $this->CI->config->item('pdftohtml_path');
	}
	// Standalone context.
	elseif (defined('PDFTOHTML_PATH')) {
	  $path = PDFTOHTML_PATH;
	} else {
	  $path = getenv('pdftohtml_path');
	}

	if (is_string($path) && strlen($path) > 0) {
	  self::$cmd_path = $path;
	}
	if (function_exists('log_message')) {
	  log_message('debug', __CLASS__." Class Initialized | ".self::$cmd_path);
	}
  }


  /** Parse the PDF and return the clean HTML snippet.
   *
   * @param string $pdf_file Path to an input PDF file.
   * @param string $xml_file Path to an intermediate XML file.
   * @param bool $delete_xml Whether to delete the intermediate XML (default: FALSE)
   * @return string HTML
   */
  public function parse($pdf_file, $xml_file, $delete_xml = FALSE) {

    $xo = $this->pdftoxml($pdf_file, $xml_file);

    //<-?xml version="1.0" ?-> 
    $out = '<!DOCTYPE html><meta charset="utf-8"/><div class="TR"><style>b,em{display:block}</style>'.PHP_EOL;
    foreach ($xo->page as $page) {
      $out .= '<div class="pg">'.PHP_EOL;
      foreach ($page->text as $text) {
        $str = trim($text);
        if (isset($text->b)) {
          $sb = trim($text->b);
          if (''==trim($text->b)) {
            $out .= " <span>$str</span>".PHP_EOL;
          } else {
            $out .= "<b>$sb</b>".PHP_EOL;
          }
        }
        elseif (isset($text->i)) {
          $out .= "<em>$text->i</em>".PHP_EOL;
        }
        elseif (''===$str) {
          //New paragraph.
          $out .= PHP_EOL.'<p>';
        }
        elseif (is_string($str)) {
          $out .= " <span>$str</span>".PHP_EOL;
        } else {
          //Error?
          var_dump($text);
        }
      }
      $out .= '</div>'.PHP_EOL;
    }
    $out .= '</div>';


    if ($delete_xml) {
      unlink($xml_file);
    }

    return $out;
  }

  /** Remove DOCTYPE and other stuff that is present in transcripts stored in HTML form.
  * @return string HTML
  */
  public function filter($html) {
    $out = $html;
	$out = str_ireplace(array('<!DOCTYPE html>', '<meta charset="utf-8"/>'), '', $out);
	$out = preg_replace('/<style>[^<]*<\/style>/', '', $out);
	return $out;
  }

  /** Get the pdftohtml binary version.
  * @return array
  */
  public function version() {
	$last = $this->_exec('-v', $output_r, $status);
	return $output_r;  #implode(PHP_EOL, $output_r);
  }

  /** pdftoxml
  * @return object A SimpleXML object.
  */
  protected function pdftoxml($pdf_file, $xml_file) {

    $last = $this->_exec('-xml -enc UTF-8 '. $pdf_file, $output_r); #$xml_file

    if (0===strpos($last, 'Error:')) {
      //Error. (Success: 'Page-4..')
      throw new Exception("Error reading PDF | $pdf_file | ".$output_r[0]." $last");
    }

    $xo = @simplexml_load_file($xml_file);
    if (!$xo) {
      //Error.
      throw new Exception("Error reading XML | $xml_file");
    }
    return $xo;
  }

  /** Execute a pdftohtml binary command.
  */
  protected function _exec($options, &$output_r, &$return_var) {
    if (! file_exists(self::$cmd_path)) {
      //Error.
      if (isset($this->CI)) {
        $this->CI->_debug('Error finding pdftohtml binary | '.self::$cmd_path);
      }
      throw new Exception('Error finding pdftohtml binary | '.self::$cmd_path);
    }

    $command = self::$cmd_path." $options 2>&1"; #$xml_file
    $last = exec($command, $output_r, $return_var);

    return $last;
  }
};


/*array(3) {
  [0]=> string(72) "Error (0): PDF file is damaged - attempting to reconstruct xref table..."
  [1]=> string(39) "Error: Couldn't find trailer dictionary"
  [2]=> string(31) "Error: Couldn't read xref table"
}
NULL*/