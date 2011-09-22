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
        'type'   => 'video',
        'type_x' => 'video|audio', #Or 'audio'!!
        '_regex_real'=>'podcast.open.ac.uk.*/([\w-]+)([/#]+!?)(\w{10}|\w+\.m\w{2})$',
    #'_regex_real'=>'podcast.open.ac.uk/(pod|\w+|feeds).*([\/#]\w|\.m4v|\.mp3)$',
    #/oembed?url=http%3A//podcast.open.ac.uk/oulearn/languages/spanish/podcast-l314-spanish%23!fe481a4d1d
    #/oembed?url=http://podcast.open.ac.uk/feeds/l314-spanish/l314audio1.mp3
    #/oembed?url=http%3A//podcast.open.ac.uk/pod/vc-message-to-staff%23!746ee92293
        '_examples'=>array(
          'Introduction: A Buen Puerto/Spanish (audio)' => 'http://podcast.open.ac.uk/pod/l314-spanish#!fe481a4d1d',
            'http://podcast.open.ac.uk/feeds/l314-spanish/l314audio1.mp3',
            'http://podcast.open.ac.uk/oulearn/languages/spanish/podcast-l314-spanish#!fe481a4d1d',
          'Invisible Boundaries..: Entrepreneurial Lives (audio)' => 'http://podcast.open.ac.uk/pod/entrepreneurial-lives/#!cb127010cf',
          'Motion...: All the Fun of the Fair (video)' => 'http://podcast.open.ac.uk/pod/mst209-fun-of-the-fair#!a67918b334',
          'http://podcast.open.ac.uk/pod/vc-message-to-staff#!746ee92293', #Private/staff: VC message 01-02-2011.
          'http://podcast.open.ac.uk/pod/new-to-ou-study/a9e72b75ff' #Hidden: Tips.
          ),
        '_google_analytics'=>'UA-24005173-2',
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
        '_google_analytics'=>'UA-24005173-3',
    ),

    'youtube.com' => array('name'=>'youtube', 'type'=>'video', 'regex'=>'youtube.com/watch*', 
        '_regex_real'=>'youtube.com/watch\?.*v=([\w-_]*)&*.*',
        '_examples'=>array(
          'Interview with Martin Bean (captions)' => 'http://youtube.com/watch?v=NaBBk-kpmL4',
		  'http://youtu.be/NaBBk-kpmL4'),
        ),
    'youtu.be' => array('name'=>'youtube', 'type'=>'video', 'regex'=>'youtu.be/*', /*'parent'=>'youtube.com'*/ ),
    /*'cohere.ac.uk'=> array('name'=>'cohere', ),
    #'mathtran.org'=> array('name'=>'mathtran', ),
    'scratch.mit.edu' => array('name'=>'scratch',
        'regex' =>'scratch.mit.edu/projects/*-/*'),
    */
    'prezi.com'   => array('name'=>'prezi',
        'regex' =>'prezi.com/*/*/?', // Optional trailing slash.
        'type'  =>'rich',
        '_examples' => array(
          'Dig. Schol. by M.Weller' => 'http://prezi.com/izeqbfy2z5w-/digital-scholarship',
          'http://prezi.com/zoidjousoeat/technology-for-the-classroom',
        ),
        '_google_analytics'=>'UA-24005173-4'), #IPR?

	/*
	SS:  https://docs.google.com/spreadsheet/ccc?key=0AlpQljt8DLyXdHE0dzVLVXkyeXdBYXk5UzdQbFJ4OFE&hl=en_US#gid=0
	     https://docs.google.com/spreadsheet/pub?key=0AonYZs4MzlZbcmVCWWVuZnJKSElSZDR2b1pmaVNtdXc#gid=0
	Form:https://docs.google.com/spreadsheet/embeddedform?formkey=dFJtUEJTQlZiVEs5R3B5ZFpRd3ZRMFE6MA
	Doc: https://docs.google.com/document/d/1gcxecBs7n4snPKmQnguBytVZpGdkcjl2GqfGUz-pCOc/edit?hl=en_GB
	*/
    'docs.google.com' => array(
        'about'  => '',
        'displayname'=>'Google Docs spreadsheets/forms',
        'domain' => 'spreadsheets.google.com',
        'favicon'=> 'http://spreadsheets.google.com/favicon.ico',
        'name'   => 'gglspread',
        'regex'  => 'docs.google.com/spreadsheet/*?*key=*',
        //'regex'  => 'spreadsheets.google.com/*?*key=*',
        'type'   => 'rich',
    '_regex_real'=> 'docs.google.com\/spreadsheet\/\w*(ccc|pub|form)\?.*(form)?key=(\w+).*?(#height=(\d+))?',
    //'_regex_real'=>'spreadsheets.google.com\/\w+(ccc|form)\?(form)?key=(\w+)(#height=(\d+))?',
    '_examples'=>array(
      'OU Player notif.' => 'https://docs.google.com/spreadsheet/viewform?hl=en_&formkey=dFJtUEJTQlZiVEs5R3B5ZFpRd3ZRMFE6MA#height=690',
      'Student satis./ Ouseful' => 'http://docs.google.com/spreadsheet/ccc?key=reBYenfrJHIRd4voZfiSmuw',
    'https://docs.google.com/spreadsheet/embeddedform?formkey=dFJtUEJTQlZiVEs5R3B5ZFpRd3ZRMFE6MA#gid=0',
    #NO: https://docs.google.com/spreadsheet/gform?key=0AgJMkdi3MO4HdFJtUEJTQlZiVEs5R3B5ZFpRd3ZRMFE&hl=en_GB&gridId=0#edit
    'https://docs.google.com/spreadsheet/ccc?key=0AgJMkdi3MO4HdDhQOXpJYkl0VzFEQnZnTkhGcF9DSFE&hl=en_GB#gid=0'),
    ),
);

// Other providers.
// IF (!endpoint) endpoint=embedly;
$config['providers_other'] = array(
    // See, http://maltwiki.org/scripts/jquery.oembed.js
	'nfb.ca'  => array('name' => 'NFB', 'type'=>'video'),
	//'blip.tv' => array('name' => 'blip', 'type'=>'video'),
	//See, http://cloudworks.ac.uk/_scripts/jquery.oembed.js
	'last.fm' => array('name' => 'last.fm', 'type'=>'audio'),
	'dotsub.com' => array('name'=>'dotSUB', 'type'=>'video'),
	'twitter.com'=> array('name'=>'twitter', 'type'=>'rich'),
	//'scribd.com' => array('name'=>'Scribd', 'type'=>'rich'),

	// See, http://api.embed.ly
	#'status.net' => array('name'=>'StatusNet'),
	'xtranormal.com' => array('name'=>'xtranormal', 'type'=>'video'),
	'timetoast.com'  => array('name'=>'Timetoast',  'type'=>'rich'),
	#'teachertube.com'=> array('name'=>'Teachertube', 'type'=>'video'),
	#'schooltube.com' => array('name'=>'Schooltube'),
	#'ted.com', 'polldaddy.com',
	#'crocodoc.com'=>array('name'=>'crocodoc'),
	#'freemusicarchive.org',
	#'huffduffer.com'=>array('name'=>'Huffduffer', 'type'=>'audio', '__endpoint'=>'http://huffduffer.com/oembed'),
	'gist.github.com' => array('name'=>'GitHub', 'type'=>'rich'),
	'cacoo.com' => array('name'=>'Cacoo', 'type'=>'rich', 'endpoint' => 'http://cacoo.com/oembed.json'),

	// OLnet - roll into OU embed.
	'cohere.open.ac.uk'=> array('name'=>'olnet', 'type'=>'rich', 'endpoint'=>'http://olnet.org/oembed'),
	'mathtran.org'     => array('name'=>'olnet', 'type'=>'rich', 'endpoint'=>'http://olnet.org/oembed'),
);

