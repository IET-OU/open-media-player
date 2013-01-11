<?php
/**
 Dev8D-oEmbed: re-direct to Chris' output...
 N.D.Freear/ Chris Gutteridge, 14 February 2012.
 

 Eg. http://embed.open.ac.uk/dev8d/oembed.php?format=json&callback=FN&url=http%3A//data.dev8d.org/2012/programme/event/CS03
 REDIRECT to,
 http://data.dev8d.org/2012/programme/?event=ET04&output=oembed&callback=FN

 See, http://dl.dropbox.com/u/3203144/oembed-offline/mock-data/dev8d-example-1.json
*/

class Dev8d_serv extends Oembed_provider {

  public $regex = 'http://data.dev8d.org/2012/programme/event/*'; // Optional trailing slash.
  public $about = <<<EOT
  JISC Dev8D is the major UK event in the year for developers in the education sector to learn from one another and ultimately create better, smarter technology for learning and research. [Initially for Dev8D'12. Public access. Alpha.]
EOT;
  public $displayname = 'JISC Dev8D';
  public $domain = 'data.dev8d.org';
  public $favicon = 'http://data.dev8d.org/favicon.ico';
  public $type = 'rich';

  public $_about_url = 'http://dev8d.org/';

  public $_examples = array(
    'oEmbed: future proofed embedding made easy' => 'http://data.dev8d.org/2012/programme/event/ET04', // %3F.
  );
  public $_access = 'public';


  /**
  * Redirect.
  * @return object
  */
  public function call($url, $matches) {
    $params = (object) array(
      'url' => $url,
      'event' => $matches[1],
      // Actually, 'callback' 'output' are not required, but this is a start! - ??
      #'callback' => $this->input->get('callback'),
      #'format' => _required('format'),
      'output' => 'oembed',
    );

    unset($params->url);

    $redirect_url = "http://data.dev8d.org/2012/programme/?".http_build_query($params);

    redirect($redirect_url);


    exit(1);
  }

}



/*
header('Content-Type: application/javascript; charset=utf-8');


//$DEV8D_REGEX = '#data.dev8d.org/2012/programme/?\??event[\/=](\w)#';
$DEV8D_REGEX = '#data\.dev8d\.org\/2012\/programme\/event\/(\w+)#';

$params = (object) array(
  'url' => _required('url'),
  'event' => null,
// Actually, 'callback' 'output' are not required, but this is a start!
  'callback' => _required('callback'),
  'format' => _required('format'),
  'output' => 'oembed',
);


if (! preg_match($DEV8D_REGEX, $params->url, $matches)) {
  header('HTTP/1.0 400 Bad Request');
  echo "Error, the 'url' parameter doesn't match the Regex, $DEV8D_REGEX .";
  exit;
}
$params->event = $matches[1];

unset($params->url);

$redirect_url = "http://data.dev8d.org/2012/programme/?".http_build_query($params);

// Perform a 302 redirect..
header('Location: '.$redirect_url);
exit;


function _required($key) {
  if (isset($_GET[$key])) {
    $value = $_GET[$key];
    // Not empty!
    if ($value) return $value;
  }
  // Otherwise, an error..
  header('HTTP/1.0 400 Bad Request');
  echo "Error, the parameter '$key' is required.".PHP_EOL;
  exit;
}
*/
