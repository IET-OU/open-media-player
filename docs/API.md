# OU Media Player #

The OU Media Player is an online audio and video player that is designed to be simple to integrate into student, public and staff facing web sites at The Open University. It can be incorporated via an [`<iframe>`](#iframe) or an [oEmbed API][oembed].

The OU Player has three _variants_:

 1. OU Podcast player - audio and video hosted at [OU Podcasts][oupod]
 2. OUVLE player - audio/video hosted on the OU's VLE
 3. OpenLearn player - audio/video hosted on OpenLearn-LearningSpace/LabSpace


A note on OU Player installations:

 1. The OU Player will be available at, http://mediaplayer.open.ac.uk and http://mediaplayer.open.edu
 2. There will be an acceptance test install at, http://mediaplayer-acct.open.ac.uk
 3. There is a development install at, http://mediaplayer-dev.open.ac.uk (behind the firewall)
 4. Currently (Nov. 2012) there is a test install at, http://iet-embed-acct.open.ac.uk (public, to be deprecated)
 5. Currently there is a live-beta install at, http://embed.open.ac.uk (to be deprecated)

If you use _Embed.open.ac.uk_ at present you should be prepared to migrate to Mediaplayer.open.ac.uk in due course. The examples below use _Mediaplayer-dev.open.ac.uk_.


## OU Podcast player -- API ##

We'll use as our example the Podcast video "_Student views of the OU_",

 * [`http://podcast.open.ac.uk/pod/student-experiences#!db6cc60d6b`][oupod-ex-1]

The Player currently supports individual podcast _tracks_, not whole collections. In the example above,

 1. `student-experiences` is the collection identifier,
 2. `#!` (_shebang_ or hash-exclamation-mark) are the separators,
 3. `db6cc60d6b` is the track identifier.

The above example is the short form of the URL. There is also a longer form and the two can be freely interchanged in the oEmbed API,

 * [`http://podcast.open.ac.uk/oulife/podcast-student-experiences#!db6cc60d6b`][oupod-ex-1b]

..Where `oulife` is a Podcast category. There can be multiple categories, for example,

 * [`http://podcast.open.ac.uk/oulearn/languages/spanish/podcast-l314-spanish#!fe481a4d1d`][oupod-ex-2b]

### oEmbed endpoint ###

The endpoint for the oEmbed API is,

 * Endpoint: [`http://mediaplayer-dev.open.ac.uk/oembed`][ouplayer-api]
 * Example: <http://mediaplayer-dev.open.ac.uk/oembed?url=http%3A//podcast.open.ac.uk/pod/student-experiences%23!db6cc60d6b>

### GET parameters ####

See [this matrix][ouplayer-api-table] for a comparison of the HTTP GET parameters supported by the various player variants.

 * `url` : Required, standard oEmbed
 * `format`: Optional, standard oEmbed, two possible values, `format=json` (default), `format=xml`; The output format
 * `maxwidth`: Optional, standard oEmbed, integer pixels;
 * `maxheight`: Optional, standard oEmbed;
 * `pcwidth`: Optional, extension, experimental, integer; Use video width expressed as a percentage, `pcwidth=0` (default), `pcwidth=1` (100%), `pcwidth=99` (99%) and so on,
 * `callback`: Optional, extension; JSON-P callback function name, for example, `callback=myFunction`
 * `theme`: Optional, extension; An OU Player theme name, for example, `theme=oup-light` (default)
 * `site_access`: Optional, extension; How to display private podcasts on restricted-access sites, two possible values, `site_access=public` (default), `site_access=private`
 * `lang`: Optional, extension; User-interface language/locale, `lang=en`, `lang=zh-CN` and so on.


### OU-Drupal ###

The [Drupal 6.x oEmbed module][oembed-drupal] does not currently support [custom additional parameters to oEmbed][oembed-ex]. As a workaround there is an _extended_ endpoint - see below.

 * Endpoint: `http://mediaplayer-dev.open.ac.uk/oembed`
 * Extended endpoint: `http://mediaplayer-dev.open.ac.uk/oembed/ex/name1:value1/name2:value2/..`
 * Example endpoint: `http://mediaplayer-dev.open.ac.uk/oembed/ex/theme:oup-light`
 * Schemes: `http://podcast.open.ac.uk/*/*`
 * (Behind the scenes: <http://mediaplayer-dev.open.ac.uk/oembed/ex/theme:oup-light?url=http%3A//podcast.open.ac.uk/pod/student-experiences%23db6cc60d6b> )

__Important__: remove the exclamation mark `!` from the URL in Drupal node content.


### jquery-oembed ###

The [jQuery-oEmbed plugin][ouplayer-jquery] (extended from [Chamorro's plugin][jquery-oembed]) is available via Embed.open.ac.uk

A simple HTML example:

	<a class=embed href="http://podcast.open.ac.uk/pod/student-experiences#!db6cc60d6b">A video</a>
	
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
	<script src="http://embed.open.ac.uk/scripts/jquery.oembed.js"></script>
	<script>
	$(document).ready(function () {
	  $("a.embed").oembed();
	});
	</script>


An example with a custom parameter (`theme: oup-light`):

	<script>
	$(document).ready(function () {
	  $("a.embed").oembed(null, {
	    oupodcast: {
		  theme: "oup-light"
		}
	  });
	});
	</script>


### Iframe {#iframe}

This is the suggested syntax for a direct embed using a HTML5 `<iframe>` -- [example embed][ouplayer-embed-1],

	<iframe
	 width="560"
	 height="315"
	 frameborder="0"
	 src="http://mediaplayer-dev.open.ac.uk/embed/pod/student-experiences/db6cc60d6b"
	 allowfullscreen
	 mozallowfullscreen
	 webkitallowfullscreen
	>
	</iframe>


Notes:

 1. `width="100%"` is useful, it appears to be widely supported in browsers, but it is not valid [HTML5][html5-iframe] ("_...valid non-negative integers_"),
 2. `frameborder="0"` is not valid HTML5. However, it is easier to override in stylesheets and more backwards-compatible than `style="border:none"`,
 3. `allowfullscreen` and the vendor specific `(moz|webkit)allowfullscreen` are not currently part of the [HTML5 specification][html5-iframe], but are needed to make fullscreen work ([`allowfullscreen` is in a separate document][w3c-fullscreen], [Mozilla page][moz-allowfull] and [bug tracker][w3c-bug-full]).
 4. See also, [Embedding a YouTube player][youtube-how].


[html5-iframe]: http://whatwg.org/specs/web-apps/current-work/multipage/the-iframe-element.html#the-iframe-element "4.8.2 The iframe element, HTML5 Living Standard —"
[w3c-bug-full]: https://www.w3.org/Bugs/Public/buglist.cgi?quicksearch=allowfullscreen "Bug 18840 - Fullscreen changes"
[w3c-fullscreen]: http://w3.org/TR/2012/WD-fullscreen-20120703/#security-and-privacy-considerations "Fullscreen; W3C Working Draft 03 July 2012"
[moz-allowfull]: https://developer.mozilla.org/en-US/docs/HTML/Element/iframe#attr-mozallowfullscreen "(moz|webkit)allowfullscreen attributes; Mozilla"
[oembed]: http://oembed.com/
[oembed-ex]: http://oembed.com/#section2.2 "'.. Providers are welcome to support custom additional parameters...' (oEmbed specification)"
[oembed-drupal]: http://drupal.org/project/oembed
[oembed-notes]: https://bitbucket.org/cloudengine/cloudengine/wiki/oEmbed "Guidelines for developers of oEmbed services/providers"
[oupod]: http://podcast.open.ac.uk/
[oupod-ex-1]: http://podcast.open.ac.uk/pod/student-experiences#!db6cc60d6b
[oupod-ex-1b]: http://podcast.open.ac.uk/oulife/podcast-student-experiences#!db6cc60d6b
[oupod-ex-2]: http://podcast.open.ac.uk/pod/l314-spanish#!fe481a4d1d
[oupod-ex-2b]: http://podcast.open.ac.uk/oulearn/languages/spanish/podcast-l314-spanish#!fe481a4d1d
[ouplayer-git]: https://github.com/IET-OU/ouplayer
[ouplayer-ex-1]: http://mediaplayer-dev.open.ac.uk/popup/pod/student-experiences/db6cc60d6b
[ouplayer-embed-1]: http://mediaplayer-dev.open.ac.uk/embed/pod/student-experiences/db6cc60d6b?theme=oup-light
[ouplayer-jquery]: http://embed.open.ac.uk/scripts/jquery.oembed.js "We deliberately link to the jQuery Javascript hosted at Embed.open.ac.uk"
[ouplayer-api]: http://mediaplayer-dev.open.ac.uk/oembed
[ouplayer-drupal-1]: http://mediaplayer-dev.open.ac.uk/oembed/ex/theme:oup-light?url=http%3A//podcast.open.ac.uk/pod/student-experiences%23!db6cc60d6b
[ouplayer-api-table]: https://docs.google.com/spreadsheet/ccc?key=0AgJMkdi3MO4HdDZ4QzVscFlSYnRDNXlkM2ZuYURLbWc#gid=0
[jquery-oembed]: http://code.google.com/p/jquery-oembed/ "Copyright (c) 2009 Richard Chamorro/ MIT license"
[youtube-how]: https://developers.google.com/youtube/player_parameters#Embedding_a_Player
