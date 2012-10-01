<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Configuration: oEmbed providers/ services.
 *
 * @copyright Copyright 2011 The Open University.
 */


if (! defined('OUP_PLAYER_HOST')) define('OUP_PLAYER_HOST', 'podcast.open.ac.uk');


// Locally-available providers.
//api.embed.ly/1/services (json, Was /api/v1/services)
$config['providers'] = array(

    OUP_PLAYER_HOST => 'oupodcast',

    'lamscommunity.org' => 'lams',
    'youtube.com'=> 'Youtube',  // Case does matter - Linux etc.!
    'youtu.be'   => 'Youtube',

    /*'cohere.ac.uk'=> array('name'=>'cohere', ),
    #'mathtran.org'=> array('name'=>'mathtran', ),
    'scratch.mit.edu' => array('name'=>'scratch',
        'regex' =>'scratch.mit.edu/projects/*-/*'),
    */
    'prezi.com' => 'prezi',

	/*
	SS:  https://docs.google.com/spreadsheet/ccc?key=0AlpQljt8DLyXdHE0dzVLVXkyeXdBYXk5UzdQbFJ4OFE&hl=en_US#gid=0
	     https://docs.google.com/spreadsheet/pub?key=0AonYZs4MzlZbcmVCWWVuZnJKSElSZDR2b1pmaVNtdXc#gid=0
	Form:https://docs.google.com/spreadsheet/embeddedform?formkey=dFJtUEJTQlZiVEs5R3B5ZFpRd3ZRMFE6MA
	Doc/ OU player help: https://docs.google.com/document/d/1gcxecBs7n4snPKmQnguBytVZpGdkcjl2GqfGUz-pCOc/edit?hl=en_GB
	https://docs.google.com/present/edit?id=0AQJMkdi3MO4HZGM1M2NoamtfMTk4ZHEyaDlqY3Y&hl=en_GB
	*/
    'docs.google.com' => 'googledoc',
    'groups.google.com' => 'Googlegroups',


    # New Jul 2012: most data is in 'Sharepoint_serv' - loose coupling (iet-it-bugs:1356)
    'intranet7.open.ac.uk' => 'sharepoint',

	# OLnet - roll into OU embed (iet-it-bugs:1364)
	'mathtran.org' => 'Mathtran',
	'cohere.open.ac.uk' => 'Cohere',
);


// Google Analytics.
$config['provider_google_analytics_ids'] = array(
  'oupodcast' => 'UA-24005173-2',
  'lams'  => 'UA-24005173-3',
  'prezi' => 'UA-24005173-4',
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

	// iSpot.
	'ispot.org.uk' => array('name'=>'iSpot', 'type'=>'rich', 'endpoint'=>'http://www.ispot.org.uk/oembed'),
);

