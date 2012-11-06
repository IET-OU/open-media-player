# OU Media Player #

The OU Media Player is an online audio and video player that is designed to be simple to integrate into student, public and staff facing web sites at The Open University. It can be incorporated via an `<iframe>` or an [oEmbed API][oembed].

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

We'll use as our example the podcast video "Student views of the OU",

    http://podcast.open.ac.uk/pod/student-experiences#!db6cc60d6b

### GET parameters ####

See [this matrix][api-table] for a comparison of the parameters supported by the various player variants.

 * `url` : Required, standard oEmbed
 * `format`: Optional, standard oEmbed, two possible values, `format=json` (default), `format=xml`; The output format
 * `callback`: Optional, extension; JSON-P callback function name, for example, `format=myFunction`
 * `theme`: Optional, extension; An OU Player theme name, for example, `theme=oup-light` (default)
 * `site_access`: Optional, extension; two possible values, `site_access=public` (default), `site_access=private`


### OU-Drupal ###

The [Drupal 6.x oEmbed module][oembed-drupal] does not currently support [custom additional parameters to oEmbed][oembed-ex]. As a workaround there is an _extended_ endpoint - see below.

 * Endpoint: http://mediaplayer-dev.open.ac.uk/oembed
 * Extended endpoint: http://mediaplayer-dev.open.ac.uk/oembed/ex/name1:value1/name2:value2/..
 * Example endpoint: http://mediaplayer-dev.open.ac.uk/oembed/ex/theme:oup-light
 * Schemes: `http://podcast.open.ac.uk/*/*`
 * (Behind the scenes: http://mediaplayer-dev.open.ac.uk/oembed/ex/theme:oup-light?url=http%3A//podcast.open.ac.uk/pod/student-experiences%23!db6cc60d6b )


[Example of a server call by Drupal][ouplayer-drupal-1]

Important: remove the exclamation mark `!` from the URL in Drupal node content.


### jquery-oembed ###

The [jQuery-oEmbed plugin][ouplayer-jquery] is used on Embed.open.ac.uk

A simple HTML example:

	<a class=embed href="http://podcast.open.ac.uk/..">A video</a>
	
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


### Iframe ###


	<iframe
	 allowfullscreen mozAllowfullscreen webkitAllowfullscreen
	 src="http://mediaplayer-dev.open.ac.uk/embed/pod/student-experiences/db6cc60d6b?theme=oup-light"
	>
	</iframe>




[iframe]: http://whatwg.org/specs/web-apps/current-work/multipage/the-iframe-element.html#the-iframe-element "4.8.2 The iframe element, HTML5"
[oembed]: http://oembed.com/
[oembed-ex]: http://oembed.com/#section2.2 "'.. Providers are welcome to support custom additional parameters...' (oEmbed specification)"
[oembed-drupal]: http://drupal.org/project/oembed
[oupod]: http://podcast.open.ac.uk/
[oupod-ex-1]: http://podcast.open.ac.uk/pod/student-experiences#!db6cc60d6b
[ouplayer-git]: https://github.com/IET-OU/ouplayer
[ouplayer-ex-1]: http://mediaplayer-dev.open.ac.uk/popup/pod/student-experiences/db6cc60d6b
[ouplayer-embed-1]: http://mediaplayer-dev.open.ac.uk/embed/pod/student-experiences/db6cc60d6b?theme=oup-light
[ouplayer-jquery]: http://embed.open.ac.uk/scripts/jquery.oembed.js "We deliberately link to the jQuery Javascript hosted at Embed.open.ac.uk"
[ouplayer-api]: http://mediaplayer-dev.open.ac.uk/oembed
[ouplayer-drupal-1]: http://mediaplayer-dev.open.ac.uk/oembed/ex/theme:oup-light?url=http%3A//podcast.open.ac.uk/pod/student-experiences%23!db6cc60d6b
[api-table]: https://docs.google.com/spreadsheet/ccc?key=0AgJMkdi3MO4HdDZ4QzVscFlSYnRDNXlkM2ZuYURLbWc#gid=0
