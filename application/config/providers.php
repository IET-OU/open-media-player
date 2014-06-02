<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Configuration: oEmbed providers/ services.
 *
 * @copyright Copyright 2011 The Open University (IET).
 */


if (! defined('OUP_PLAYER_HOST')) define('OUP_PLAYER_HOST', 'podcast.open.ac.uk');


// Locally-available providers.
//api.embed.ly/1/services (json, Was /api/v1/services)
$config['providers'] = array(

    OUP_PLAYER_HOST => 'oupodcast',
    'media-podcast.open.ac.uk' => 'oupodcast',

    'lamscommunity.org' => 'lams',
    'youtube.com'=> 'Youtube',  // Case does matter - Linux etc.!
    'youtu.be'   => 'Youtube',

    /*'cohere.ac.uk'=> array('name'=>'cohere', ),
    #'mathtran.org'=> array('name'=>'mathtran', ),
    'scratch.mit.edu' => array('name'=>'scratch',
        'regex' =>'scratch.mit.edu/projects/*-/*'),
    */
    'prezi.com' => 'prezi',

	# Google Docs.
    'docs.google.com' => 'googledoc',
    'groups.google.com' => 'Googlegroups',


    # New Jul 2012: most data is in 'Sharepoint_serv' - loose coupling (iet-it-bugs:1356)
    'intranet7.open.ac.uk' => 'sharepoint',

	# OLnet - roll into OU embed (iet-it-bugs:1364)
	'mathtran.org' => 'Mathtran',
	'cohere.open.ac.uk' => 'Cohere',

	# File viewer.
	'dl.dropbox.com' => 'Fileviewer',
	'ubuntuone.com' => 'Fileviewer',
	'sites.google.com' => 'Fileviewer',
	'openclipart.org' => 'Fileviewer',
	'upload.wikimedia.org' => 'Fileviewer',
	'openlearn.open.ac.uk' => 'Fileviewer',
	'labspace.open.ac.uk' => 'Fileviewer',
	'compendiumld.open.ac.uk' => 'Fileviewer',
	'kn.open.ac.uk' => 'Fileviewer',
	'oro.open.ac.uk' => 'Fileviewer',
	'www.open.edu' => 'Fileviewer',
	'www.open.ac.uk' => 'Fileviewer',
	'embed.open.ac.uk' => 'Fileviewer',
	'www.lkl.ac.uk' => 'Fileviewer',
	'blogs.cetis.ac.uk' => 'Fileviewer',

	# External.
	//'openlearn.open.ac.uk' => 'Trackoer',
	//'labspace.open.ac.uk' => 'Trackoer',

	'ispot.org.uk' => 'Ispot',
	'views.scraperwiki.com' => 'Scraperwiki',

	'www.bibsonomy.org' => 'Bibsonomy',
	'bibsonomy.org' => 'Bibsonomy',

	'data.dev8d.org' => 'Dev8d',
);


// Google Analytics.
$config['provider_google_analytics_ids'] = array(
  'oupodcast' => 'UA-24005173-2',
  'openlearn' => 'UA-24005173-2',
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

	// No JSON-P 'callback' parameter :( - https://speakerdeck.com/faq#oembed
	'speakerdeck.com' => array('name'=>'Speakerdeck', 'type'=>'rich', 'endpoint' => 'http://speakerdeck.com/oembed.json'),
	'cacoo.com' => array('name'=>'Cacoo', 'type'=>'rich', 'endpoint' => 'http://cacoo.com/oembed.json'),

	// Wordpress, https://bitbucket.org/cloudengine/cloudengine/issue/310/embedding-from-wordpress-blogs
	'.wordpress.com' => array('name'=>'Wordpress', 'type'=>'rich', 'endpoint'=>'http://public-api.wordpress.com/oembed/1.0/?for=Embed.open.ac.uk'),
	'wp.me' => array('name'=>'Wordpress', 'type'=>'rich', 'endpoint'=>'http://public-api.wordpress.com/oembed/1.0/?for=Embed.open.ac.uk'),

	// iSpot (see 'providers')
	///'ispot.org.uk' => array('name'=>'iSpot', 'type'=>'rich', 'endpoint'=>'http://www.ispot.org.uk/oembed'),
);


if (defined('OUP_NOEMBED_END_URL')) {

$config['providers_other'] += array(
	// See, http://noembed.com
	'gist.github.com' => array('name'=>'GitHub Gist', 'type'=>'rich', 'endpoint' => OUP_NOEMBED_END_URL),
	'github.com' => array('name'=>'GitHub Commit', 'type'=>'rich', 'endpoint' => OUP_NOEMBED_END_URL),
	'open.spotify.com' => array('name' => 'Spotify', 'type' => 'rich', 'endpoint' => OUP_NOEMBED_END_URL),
	'wikipedia.org' => array('name' => 'Wikipedia', 'type' => 'rich', 'endpoint' => OUP_NOEMBED_END_URL),
);

}
