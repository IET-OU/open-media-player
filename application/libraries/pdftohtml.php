<?php
/**
 * Convert PDF transcripts to clean HTML5 snippets.
 * NDF, 25 March 2011.
 *
 * @copyright Copyright 2011 The Open University.
 *
 * Uses: pdftohtml v0.39 (which uses xpdf) http://pdftohtml.sourceforge.net/
 * @copyright 2003-6 Gueorgui Ovtcharov and Rainer Dorsch.
 * @license GNU GPLv2.

 http://podcast.open.ac.uk/feeds/l314-spanish/transcript/l314audio2.pdf

 $ pdftohtml -i -noframes -enc UTF-8  l314audio2.pdf
 $ pdftohtml -stdout -xml -enc UTF-8  l314audio2.pdf
*/
#$config['pdftohtml_path'] = './pdftohtml';


$pdf = '/var/www/_ouplayer_data/transcripts/l314audio2.pdf'; #Ok.
#$pdf = '_test/oupod-entrep-invisable_transcript_00775_7600.pdf'; #Errors :(.
$xml = str_replace('.pdf', '.xml', $pdf);  //tmp file?
$ofile = str_replace('.pdf', '_transcript.html', $pdf);

/*try {
  $parser = new Pdftohtml();
  $out = $parser->parse($pdf, $xml);
  $by = file_put_contents($ofile, $out);
  echo "Ok, written $by bytes | $ofile".PHP_EOL;
} catch(Exception $ex) {
  die('EX: '.$ex->getMessage().PHP_EOL);
}*/


class Pdftohtml {

  protected static $cmd_path = '/usr/bin/pdftohtml'; #Redhat 6.

  public function __construct() {
    $path = config_item('pdftohtml_path');
	if ($path) {
	  $this->cmd_path = $path;
	}
  }
  
  /** Parse the PDF and return the clean HTML snippet.
   * @return string
   */
  public function parse($pdf, $xml) {

    $xo = $this->pdftoxml($pdf, $xml);

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

    return $out;
  }


  /** pdftoxml
  * @return object A SimpleXML object.
  */
  protected function pdftoxml($pdf, $xml) {
    if (!file_exists(self::$cmd_path)) {
      //Error.
      throw new Exception('Error finding pdftohtml binary.');
    }

    $pdftoxml = self::$cmd_path." -xml -enc UTF-8 $pdf  2>&1";
    $last = exec($pdftoxml, $output_r, $status);

    if (0===strpos($last, 'Error:')) {
      //Error. (Success: 'Page-4..')
      throw new Exception("Error reading PDF | $pdf | ".$output_r[0]." $last");
    }

    $xo = @simplexml_load_file($xml);
    if (!$xo) {
      //Error.
      throw new Exception("Error reading XML | $xml");
    }
    return $xo;
  }
};


/*array(3) {
  [0]=> string(72) "Error (0): PDF file is damaged - attempting to reconstruct xref table..."
  [1]=> string(39) "Error: Couldn't find trailer dictionary"
  [2]=> string(31) "Error: Couldn't read xref table"
}
NULL*/