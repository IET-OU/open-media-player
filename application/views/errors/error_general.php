<?php
/**
 * OU-themed version of 'application/errors/error_general.php'
 * Uses Ender/jeesh, with a local fallback, and adapts to different <iframe> sizes.
 *
 * Copyright 2012 The Open University.
 */
if(!function_exists('t')) {
  function t($s) { return $s; }
}
if(!function_exists('base_url')) {
  function base_url() { return '/'; }
}
if (!defined('OUP_JS_CDN_ENDER_MIN')) define('OUP_JS_CDN_ENDER_MIN', '//__NO__js_cdn_ender');


$base_url = '//www.open.ac.uk';   //Was: 'http://podcast.open.ac.uk';
$target = ' target="_blank" title="'.t('Opens in new window').'"';
$x_target = '';


// Catch commandline 404 errors.
if (class_exists('CI_Controller')) {
  $CI =& get_instance();
  if ($CI->input->is_cli_request()) {
    fprintf(STDERR, "Error, $message".PHP_EOL);
    exit (1);
  }
}

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
.size-x-small .ou-role-nav, .size-x-small .ou-ia-nav, .size-x-small #ou-org-footer, .size-x-small .searchrow{ display:none;}
.my-content{ font:.95em sans-serif; color:#333; margin:0 4px; padding:4px; background:#f4f4f4; border:1px solid #a88; border-radius:4px; }
body.size-x-small{ margin:0 0 0 3px; padding:0; font-size:.87em; }
.size-x-small .my-content{ float:right; position:relative; top:-87px; margin:1px; padding:2px; max-width:265px; }
.size-x-small p{ margin:9px 0 3px;}
.size-x-small #ou-org-header{ width:86px; position:relative; top:-5px; }
h2{ margin:1px 0; font-size:1.15em; }
h2 small,label{ font-weight:normal; font-size:small; }
input{ margin:0; }
.searchrow{ float:right; font-size:.8em; height:2em !important; overflow:visible; }
.searchrow a{ text-align:right; display:block; margin-top:4px; }

body.is-iframe div#ou-org-footer{ /*margin-top:1px; padding-top:17px;*/ background-image:none; }
.is-iframe #ou-org-footer .ou-c1of4{ width:100%; }

.is-iframe #ou-org-footer .ou-c2of4,
.is-iframe #ou-org-footer .ou-c3of4,
.is-iframe #ou-org-footer .ou-phone,
.is-iframe #ou-org-footer .ou-title,
.is-iframe #ou-org-footer .ou-copyright .all,
.is-iframe #ou-org-header .ou-ia-nav { display:none; }

<?php /*
#ou-org-footer li.ou-phone{ font-size:1.1em; }

.size-small #ou-org-footer{ background:none; }
.size-small .ou-ia-study{ display:none; }
.size-small #ou-org-footer li.ou-phone{ font-size:1em; }

.size-medium .ou-footer-links .ou-c2of4{ position:relative; left:-21px; }
.size-medium .ou-footer-links .ou-c3of4{ position:relative; left:-42px; }
*/ ?>
</style>

<body class="ou-ia-community">
<script>if(typeof window.ou_sitestat=='function')ou_sitestat()</script>

<div id="ou-org-header"> <a class="ou-skip" href="#ou-content">Skip to content</a> <a class="ou-link-ou" href="http://www.open.ac.uk/"<?php echo $target ?>><img src="<?php echo $base_url ?>/includes/headers-footers/oulogo-56.jpg" alt="The Open University" /></a>
  <div class="ou-role-nav">
    <ul>
      <li class="ou-role-accessibility"><a href="http://www.open.ac.uk/accessibility/"<?php echo $target ?>>Accessibility</a></li>
      <li class="ou-role-signin" id="ou-signin1"><a href="https://msds.open.ac.uk/signon/sams001.aspx" id="ou-signin2"<?php echo $target ?>>Sign in</a></li>
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
      <li class="ou-ia-home"><a href="http://www.open.ac.uk/"<?php echo $x_target ?>>The Open University</a></li>
      <li class="ou-ia-study"><a href="http://www.open.ac.uk/study/"<?php echo $x_target ?>>Study at the OU</a></li><?php /*
      <li class="ou-ia-research"><a href="http://www.open.ac.uk/research/"<?php echo $x_target ?>>Research at the OU</a></li>
     */ ?> <li class="ou-ia-community"><a href="http://www.open.ac.uk/community/"<?php echo $x_target ?>>OU Community</a></li>
      <?php /*<li class="ou-ia-about"><a href="http://www.open.ac.uk/about/"<?php echo $x_target ?>>About the OU</a></li>
   */ ?> </ul>
  </div>
</div>

<div class="my-content">

<form action="http://podcast.open.ac.uk/search.php" method="post"<?php echo $target ?> class="searchrow">
<label for="search">Search podcasts</label><input
 id="search" type="search" required name="searchFor" maxlength="100" /><input type="submit" value="Search" />
<a href="http://podcast.open.ac.uk/"<?php echo $target ?>>OU Podcasts</a>
</form>

<a id='ou-content' name='ou-content'></a>

<h2><?php echo $heading ?> <small>| <a href="/">Player home&crarr;</a></small></h2>

<div class=message><?php echo $message ?></div>

</div>


<div id="ou-org-footer">
<div class="ou-grid ou-mobile-footer" id="ou-mobile-jlinks"></div>

<div class="ou-grid ou-footer-links">
  <div class="ou-c1of4">
    <ul>
      <li class="ou-title"><a href="http://www.open.ac.uk"<?php echo $x_target ?>>The Open University</a></li>
      <li class="ou-copyright">&#169; Copyright <span id="sbyear">2012</span>.<span class=all>All rights reserved</span></li>
      <li class="ou-phone">+44 (0) 8 845 300 60 90</li>
      <li class="ou-email"><a href="http://www.open.ac.uk/email/"<?php echo $target ?>>Email us</a></li>
      <?php /*<li class="ou-study"><a href="http://www.open.ac.uk/study/">Study at the OU</a></li>
      <li class="ou-research"><a href="http://www.open.ac.uk/research/">Research</a></li>
      <li class="ou-community"><a href="http://www.open.ac.uk/community/">Community</a></li>
      <li class="ou-about"><a href="http://www.open.ac.uk/about/">About</a></li>
      <li class="ou-accessibility"><a href="http://www.open.ac.uk/about/">Accessibility</a></li>*/ ?>
    </ul>
  </div>
  <div class="ou-c2of4">
    <ul>
    <?php /*<li class="ou-contact"><a href="http://www.open.ac.uk/contact/">Contact</a></li>
      <li class="ou-search"><a href="http://www.open.ac.uk/search/">Search</a></li>*/ ?>
      <li class="ou-privacy"><a href="http://www.open.ac.uk/privacy/"<?php echo $x_target ?>>Privacy and cookies</a></li>
      <li class="ou-copyright"><a href="http://www.open.ac.uk/copyright/"<?php echo $x_target ?>>Copyright</a></li>
      <li class="ou-conditions"><a href="http://www.open.ac.uk/conditions/"<?php echo $x_target ?>>Conditions of use</a></li>
      <li class="ou-cymraeg"><a href="http://www.open.ac.uk/cymraeg/"<?php echo $x_target ?>>Cymraeg</a></li>
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
      <li class="ou-ia-community"><a href="http://www.open.ac.uk/platform/"<?php echo $x_target ?>>Platform</a></li>
      <li class="ou-ia-community"><a href="http://www.open.ac.uk/openlearn/"<?php echo $x_target ?>>OpenLearn</a></li>
      <li class="ou-ia-community"><a href="http://www.open.ac.uk/facebook/"<?php echo $x_target ?>>Facebook</a></li>
      <li class="ou-ia-community"><a href="http://www.open.ac.uk/twitter/"<?php echo $x_target ?>>Twitter</a></li>
      <li class="ou-ia-community"><a href="http://www.open.ac.uk/youtube/"<?php echo $x_target ?>>YouTube</a></li>
      <?php /*<li class="ou-ia-learning"><a href="http://www.open.ac.uk/students/">StudentHome</a></li>
      <li class="ou-ia-learning"><a href="http://www.open.ac.uk/skillsforstudy/">Learning Support</a></li>
      <li class="ou-ia-learning"><a href="http://library.open.ac.uk/">Library</a></li>*/ ?>
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
  document.write(unescape("%3Cscript src='<?php echo base_url() ?>engines/mediaelement/src/js/jeesh.js' %3E%3C/script%3E"));
  CDN_fallback = true;
}
</script>
<script>
$.domReady(function(){
  // Set a flag for narrow/ standard/ wide players (POPUP = wide).
  var body = $('body')
  , xsmall= 'size-x-small'
  , small = 'size-small'
  , medium= 'size-medium'
  //, large = 'size-large'
  ;
  function oup_check_size(){
	if (body.width() <= 370/*360*/) {
		body.addClass(xsmall).removeClass(small).removeClass(medium);
	} else if (body.width() <= 480) {
		body.removeClass(xsmall).addClass(small).removeClass(medium);
	} else {
		body.removeClass(xsmall).removeClass(small).addClass(medium);
	}
	body.addClass(window == window.top ? 'not-iframe' : 'is-iframe');

<?php //console.log('> check_size, width px: '+body.width());
	//$.log('>> check_size, width px: '+body.width()); ?>
  };
  $(window).resize(oup_check_size);
  oup_check_size();
});
</script>
</body>
</html>