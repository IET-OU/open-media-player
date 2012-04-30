<?php
/**
 * OU-themed version of 'application/errors/error_general.php'
 * Uses Ender/jeesh, with a local fallback.
 *
 * Copyright 2012 The Open University.
 */
if(!function_exists('t')) {
  function t($s) { return $s; }
}

$base_url = 'http://podcast.open.ac.uk';
$target = ' target="_blank" title="'.t('Opens in new window').'"';

?>
<!doctype html><html lang="en"><meta charset=utf-8 />
  <title><?php echo $heading ?> - The Open University</title>
  <?php /*
  <meta name="desciption" content="Learn at any time with The Open University audio and video podcasts">
  <meta name="robots" content="noindex,nofollow">
  <link href="favicon.ico" rel="icon" />
  <link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
  <link href="styles.css" rel="stylesheet" />*/ ?>
  <link rel="stylesheet" href="<?php echo $base_url ?>/includes/headers-footers/ou-header.css" />
  <?php /*<script src="<?php echo $base_url ?>/includes/headers-footers/ou-header.js"></script>*/ ?>

<style>
.size-small .ou-role-nav, .size-small .ou-ia-nav, .size-small #ou-org-footer, .size-small .searchrow{ display:none;}
.my-content{ font:1em sans-serif; color:#222; }
body.size-small{ margin:0 3px; padding:0; font-size:.9em; }
.size-small .my-content{ float:right; position:relative; top:-85px; }
.size-small #ou-org-header{ width:86px; position:relative; top:-5px; }
h2{ margin:1px 0; font-size:1.2em; }
.searchrow{ float:right; font-size:.8em; }
.searchrow a{ text-align:right; display:block; margin-top:3px; }
.my-content{ margin:16px 6px; padding:7px; background:#f4f4f4; border:1px solid #a88; border-radius:4px; }
.size-small .my-content{ margin:1px; padding:2px 6px; }
</style>

<body class="ou-ia-community">
<script>if(typeof window.ou_sitestat=='function')ou_sitestat()</script>

<div id="ou-org-header"> <a class="ou-skip" href="#ou-content">Skip to content</a> <a class="ou-link-ou" href="http://www.open.ac.uk/"<?php echo $target ?>><img src="<?php echo $base_url ?>/includes/headers-footers/oulogo-56.jpg" alt="The Open University" /></a>
  <div class="ou-role-nav">
    <ul>
      <li class="ou-role-accessibility"><a href="http://www.open.ac.uk/accessibility/"<?php echo $target ?>>Accessibility</a></li>
      <li class="ou-role-signin" id="ou-signin1"><a href="https://msds.open.ac.uk/signon/sams001.aspx" id="ou-signin2">Sign in</a></li>
      <li id="ou-signout" class="ou-role-signout"><a href="https://msds.open.ac.uk/signon/samsoff.aspx" id="ou-signout2">/ Sign out</a></li>
<?php /*
      <li id="ou-studenthome" class="ou-role-studenthome"><a href="http://www.open.ac.uk/students/" id="ou-studenthome2">StudentHome</a></li>
      <li id="ou-tutorhome" class="ou-role-tutorhome"><a href="http://www.open.ac.uk/tutorhome/">TutorHome</a></li>
      <li id="ou-intranet" class="ou-role-intranet"><a href="http://intranet.open.ac.uk/">IntranetHome</a></li>
      <li id="ou-sponsor" class="ou-role-sponsor"><a href="https://css2.open.ac.uk/employers/sponsorhome/home/HomePage.aspx">SponsorHome</a></li>
      */ ?>
<li id="ou-contact" class="ou-role-contact"><a href="http://www.open.ac.uk/contact/"<?php echo $target ?>>Contact</a></li>
      <li id="ou-search" class="ou-role-search"><a href="http://www.open.ac.uk/search/"<?php echo $target ?>>Search the OU</a></li>
    </ul>
  </div>
<div class="ou-ia-nav">
    <ul>
      <li class="ou-ia-home"><a href="http://www.open.ac.uk/"<?php echo $target ?>>The Open University</a></li>
      <li class="ou-ia-study"><a href="http://www.open.ac.uk/study/"<?php echo $target ?>>Study at the OU</a></li><?php /*
      <li class="ou-ia-research"><a href="http://www.open.ac.uk/research/"<?php echo $target ?>>Research at the OU</a></li>
     */ ?> <li class="ou-ia-community"><a href="http://www.open.ac.uk/community/"<?php echo $target ?>>OU Community</a></li>
      <?php /*<li class="ou-ia-about"><a href="http://www.open.ac.uk/about/"<?php echo $target ?>>About the OU</a></li>
   */ ?> </ul>
  </div>
</div>

<div class="my-content">

<form action="http://podcast.open.ac.uk/search.php" method="post"<?php echo $target ?> class="searchrow">
<label for="search">Search</b> podcasts </label>
<input id="search" type="search" name="searchFor" maxlength="100" /> <input type="submit" />
<a href="http://podcast.open.ac.uk/"<?php echo $target ?>>OU Podcasts</a>
</form>

<a id='ou-content' name='ou-content'></a>

<h2><?php echo $heading ?></h2>

<div><?php echo $message ?></div>

</div>


<div id="ou-org-footer">
<div class="ou-grid ou-mobile-footer" id="ou-mobile-jlinks"></div>

<div class="ou-grid ou-footer-links">
  <div class="ou-c1of4">
    <ul>
      <li class="ou-title"><a href="http://www.open.ac.uk"<?php echo $target ?>>The Open University</a></li>
      <li class="ou-copyright">&#169; Copyright <span id="sbyear">2012</span>.<?php /*All rights reserved*/ ?></li>
      <li class="ou-phone"><!--+44 (0) 8-->0845 300 60 90</li>
      <li class="ou-email"><a href="http://www.open.ac.uk/email/"<?php echo $target ?>>Email us</a></li>
      <li class="ou-study"><a href="http://www.open.ac.uk/study/">Study at the OU</a></li>
      <li class="ou-research"><a href="http://www.open.ac.uk/research/">Research</a></li>
      <li class="ou-community"><a href="http://www.open.ac.uk/community/">Community</a></li>
      <li class="ou-about"><a href="http://www.open.ac.uk/about/">About</a></li>
      <li class="ou-accessibility"><a href="http://www.open.ac.uk/about/">Accessibility</a></li>
    </ul>
  </div>
  <div class="ou-c2of4">
    <ul>
    <?php /*<li class="ou-contact"><a href="http://www.open.ac.uk/contact/">Contact</a></li>
      <li class="ou-search"><a href="http://www.open.ac.uk/search/">Search</a></li>*/ ?>
      <li class="ou-privacy"><a href="http://www.open.ac.uk/privacy/">Website privacy</a></li>
      <li class="ou-copyright"><a href="http://www.open.ac.uk/copyright/">Copyright</a></li>
      <?php /*<li class="ou-conditions"><a href="http://www.open.ac.uk/conditions/">Conditions of use</a></li>*/ ?>
      <li class="ou-cymraeg"><a href="http://www.open.ac.uk/cymraeg/">Cymraeg</a></li>
      <li class="ou-mobile-enquiries">0845 300 60 90</li>
    </ul>
  </div>
  <div class="ou-c3of4">
    <ul>
      <?php /*<li class="ou-ia-study"><a href="http://www3.open.ac.uk/study/undergraduate/">Undergraduate</a></li>
      <li class="ou-ia-study"><a href="http://www3.open.ac.uk/study/postgraduate/">Postgraduate</a></li>
      <li class="ou-ia-study ou-ia-research"><a href="http://www.open.ac.uk/research-degrees">Research degrees</a></li>
      <li class="ou-ia-home ou-ia-study"><a href="http://www.open.ac.uk/employers/">Employers</a></li>
      <li class="ou-ia-about"><a href="http://www8.open.ac.uk/about/main/the-ou-explained/">OU explained</a></li>
      <li class="ou-ia-about"><a href="http://www8.open.ac.uk/about/main/faculties-and-centres/">Faculties and centres</a></li>
      <li class="ou-ia-about"><a href="http://www8.open.ac.uk/about/main/admin-and-governance/">Admin and governance</a></li>
      <li class="ou-ia-about ou-ia-home"><a href="http://www.open.ac.uk/news/">Press Room</a></li>
      <li class="ou-ia-home"><a href="http://www.open.ac.uk/alumni/" class="ou-home">Alumni</a></li>
      <li class="ou-ia-home ou-ia-research ou-ia-about"><a href="http://www.open.ac.uk/jobs/">Jobs</a></li>
      <li class="ou-ia-home"><a href="http://www.open.ac.uk/fundraising/">Donate</a></li>*/ ?>
      <li class="ou-ia-community"><a href="http://www.open.ac.uk/platform/">Platform</a></li>
      <li class="ou-ia-community"><a href="http://www.open.ac.uk/openlearn/">OpenLearn</a></li>
      <li class="ou-ia-community"><a href="http://www.open.ac.uk/facebook/">Facebook</a></li>
      <li class="ou-ia-community"><a href="http://www.open.ac.uk/twitter/">Twitter</a></li>
      <li class="ou-ia-community"><a href="http://www.open.ac.uk/youtube/">YouTube</a></li>
      <li class="ou-ia-learning"><a href="http://www.open.ac.uk/students/">StudentHome</a></li>
      <li class="ou-ia-learning"><a href="http://www.open.ac.uk/skillsforstudy/">Learning Support</a></li>
      <li class="ou-ia-learning"><a href="http://library.open.ac.uk/">Library</a></li>
    </ul>
  </div>
  <div class="ou-c4of4"><!-- reserved --></div>
  </div>
    
</div>

<script>if (typeof window.ou_init=='function')ou_init()</script>


<?php /*<script src="<?php echo OUP_JS_CDN_JQUERY_MIN ?>"></script>*/ ?>
<script src="<?php echo OUP_JS_CDN_ENDER_MIN ?>"></script>
<script>
if(typeof $=='undefined'){
  document.write(unescape("%3Cscript src='<?php echo base_url() ?>'engines/mediaelement/src/js/jeesh.js' %3E%3C/script%3E"));
  CDN_fallback = true;
}
</script>
<script>
$.domReady(function(){
  // Set a flag for narrow/ standard/ wide players (POPUP = wide).
  var body = $('body'),
	small = 'size-small',
	medium= 'size-medium',
	large = 'size-large';
  function oup_check_size(){
	if (body.width() <= 450) {
		body.addClass(small).removeClass(medium).removeClass(large);
	} else if (body.width() >= 720) {
		body.removeClass(small).removeClass(medium).addClass(large);
	} else {
		body.removeClass(small).addClass(medium).removeClass(large);
	}
	console.log('> check_size, width px: '+body.width());
	//$.log('>> check_size, width px: '+body.width());
  };
  $(window).resize(oup_check_size);
  oup_check_size();
});
</script>
</body>
</html>