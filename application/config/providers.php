<?php
/** Configuration: oEmbed providers/ services.
 *
 * @copyright Copyright 2011 The Open University.
 */

//api.embed.ly/1/services (json, Was /api/v1/services)
$config['providers'] = array(

/* Some example input URLs.
 http://podcast.open.ac.uk/oulearn/languages/spanish/podcast-l314-spanish/079b8e506c
 http://podcast.open.ac.uk/pod/l314-spanish#!079b8e506c
 http://podcast.open.ac.uk/feeds/l314-spanish/l314audio1.mp3
*/
    'podcast.open.ac.uk' => array(
        'about'  => 'Podcast audio and video on topics including courses and research from The Open University.',
        'displayname'=>'OU Podcast',
        'domain' => 'podcast.open.ac.uk',
        'favicon'=> 'http://www3.open.ac.uk/favicon.ico', #iet.open
        'name'   => 'oupodcast',
        'regex'  => 'podcast.open.ac.uk/*/*', //array()?
        'subdomains'=>array(),
        'type'   => 'audio|video', #Or 'audio'!!
        '_regex_real'=>'podcast.open.ac.uk.*\/([\w-]+)([\/#]\!?)(\w{10}|\w+\.m\w{2})$',
    #'_regex_real'=>'podcast.open.ac.uk/(pod|\w+|feeds).*([\/#]\w|\.m4v|\.mp3)$',
    #/oembed?url=http%3A//podcast.open.ac.uk/oulearn/languages/spanish/podcast-l314-spanish%23!fe481a4d1d
    #/oembed?url=http://podcast.open.ac.uk/feeds/l314-spanish/l314audio1.mp3
    #/oembed?url=http%3A//podcast.open.ac.uk/pod/vc-message-to-staff%23!746ee92293
        '_examples'=>array(
            'http://podcast.open.ac.uk/pod/l314-spanish#!fe481a4d1d',
            'http://podcast.open.ac.uk/feeds/l314-spanish/l314audio1.mp3',
            'http://podcast.open.ac.uk/oulearn/languages/spanish/podcast-l314-spanish#!fe481a4d1d'),
        '_google_analytics'=>'UA-12345-1',
    ),

    'lamscommunity.org' => array(
        'about'  => '<abbr title="Learning Activity Management System">LAMS</abbr> is a new tool for producing online collaborative learning activities. It provides teachers with a visual authoring environment for creating sequences.',
        'displayname'=>'LAMS Community',
        'domain' => 'lamscommunity.org',
        'favicon'=> 'http://lamscommunity.org/favicon.ico',
        'name'   => 'lams',
        'regex'  => 'lamscommunity.org/*?seq_id=*', //array()?
        'subdomains'=>array(),
        'type'   => 'rich',
        '_regex_real'=>'lamscommunity.org\/.*(sequence|dl)\?seq_id=(\d{2,10})$',
        #oembed?url=http%3A//lamscommunity.org/lamscentral/sequence%3Fseq_id=1007900
        '_examples'=>array(
          'Crime fighting'=> 'http://lamscommunity.org/lamscentral/sequence?seq_id=1007900',
          'Γενετικά Τροποποιημένα Τρόφιμα 1 [el]'=> 'http://lamscommunity.org/lamscentral/sequence?seq_id=1074994'),
        '_google_analytics'=>'UA-12345-2',
    ),

    'youtube.com' => array('name'=>'youtube', 'regex'=>'youtube.com/watch*', 
        '_regex_real'=>'youtube.com/watch\?.*v=([\w-_]*)&*.*'),
    'youtu.be'    => array('name'=>'youtube', 'regex'=>'youtu.be/*'),
    'cohere.ac.uk'=> array('name'=>'cohere', ),
    'mathtran.org'=> array('name'=>'mathtran', ),
    'scratch.mit.edu' => array('name'=>'scratch',
        'regex' =>'scratch.mit.edu/projects/*/*'),
    'prezi.com'   => array('name'=>'prezi',
        'regex' =>'prezi.com/*/*/', //Hmm, trailing slash?
        '_google_analytics'=>'UA-12345-3'), #IPR?

    'spreadsheets.google.com'=>array(
        'about'  => '',
        'displayname'=>'Google Docs spreadsheets/forms',
        'domain' => 'spreadsheets.google.com',
        'favicon'=> 'http://spreadsheets.google.com/favicon.ico',
        'name'   => 'gglspread',
        'regex'  => 'spreadsheets.google.com/*?*key=*',
        'type'   => 'rich',
    '_regex_real'=>'spreadsheets.google.com\/\w+(ccc|form)\?(form)?key=(\w+)(#height=(\d+))?',
    '_examples'=>array('http://spreadsheets.google.com/embeddedform?formkey=dDhQOXpJYkl0VzFEQnZnTkhGcF9DSFE6MQ#height=1150',
    'https://spreadsheets.google.com/viewform?hl=en_GB&formkey=dDhQOXpJYkl0VzFEQnZnTkhGcF9DSFE6MQ#gid=0',
    #'https://spreadsheets.google.com/gform?key=0AgJMkdi3MO4HdDhQOXpJYkl0VzFEQnZnTkhGcF9DSFE&hl=en_GB&gridId=0#edit'
    'https://spreadsheets.google.com/ccc?key=0AgJMkdi3MO4HdDhQOXpJYkl0VzFEQnZnTkhGcF9DSFE&hl=en_GB#gid=0'),
    ),
);
