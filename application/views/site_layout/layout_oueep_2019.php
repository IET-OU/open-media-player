<?php
/**
 * OU V4-EEP compatible layout for Open Media Player web-site (21-August-2019).
 *
 * @copyright © 2019 The Open University (IET).
 *
 * Source :~  http://www.open.ac.uk/courses/
 * Replaces :~ https://github.com/IET-OU/open-media-player/blob/2.x/application/views/site_layout/layout_ouice_2.php
 */

  $page_title = isset( $page_title ) ? $page_title : 'Home';

  $robots = $this->config->item('robots');
  $google_analytics = $this->config->item('google_analytics');

  $site_url = $resource_url = OUP_OU_RESOURCE_URL;
  $local_res_url = site_res_url();
  $base_url = site_url();
  $player_url = isset($player_url) ? $player_url : site_url();
  $is_demo_page = !isset($is_demo_page) ? TRUE : $is_demo_page;
  $is_player_site = TRUE;

  $body_classes = 'LTR X-Chrome ENGB ContentBody X-ou-ia-community ou-ia-news ou-sections oup-ice-test ';

  $path = str_replace('/', '-', $this->uri->uri_string());
  $body_classes .= '-'==$path ? 'pg-player-home' : 'pg-'. $path;

  $google_gtm = false;
  $optimizely_etc = false;

  $message = $this->config->item('site_message');


?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge, chrome=1" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes" />
<?php /* <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" /> */ ?>

<?php if (!$robots): ?>
  <meta name="robots" content="noindex,nofollow" />
<?php endif ?>

	<title> <?= $page_title ?> | Open University </title>

  <meta name="copyright" content="© 2011-<?= date('Y')?> The Open University (IET)." />
	<meta name="description" content="<?= site_name() ?> is an online audio and video player. The Open University offers flexible part-time study, supported distance and open learning for undergraduate and postgraduate courses and qualifications." />
  <meta name="keywords" content="ouplayer, oembed, open university, distance, learning, study, employee development, research, course, qualification, uni" />

<?php /*
  <script src="/oudigital/v4/eep/js/vendor/modernizr-2.6.2.min.js"></script>
*/ ?>

    <link rel="stylesheet" href="<?= $resource_url ?>/oudigital/v4/eep/css/screen.css?v=1.0.1.45">

    <!--[if lt IE 9]>
            <link rel="stylesheet" href="<?= $resource_url ?>/oudigital/v4/eep/css/ie8.css">
   <![endif]-->

<?php /*
      <!--[if lt IE 8]>
            <link rel="stylesheet" href="/oudigital/v4/eep/css/ie.css">
      <![endif]-->
*/ ?>

    <link rel="stylesheet" href="<?= $resource_url ?>/oudigital/v4/eep/css/print.css" media="print">

    <!-- favicons -->
    <link rel="apple-touch-icon" href="<?= $resource_url ?>/oudigital/v4/external/img/favicons/apple-touch-icon.png">
    <link rel="icon" href="<?= $resource_url ?>/oudigital/v4/external/img/favicons/favicon.png">
    <link rel="shortcut icon" href="<?= $resource_url ?>/oudigital/v4/external/img/favicons/favicon.ico">

    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="<?= $resource_url ?>/oudigital/v4/external/img/favicons/ie10-win8-tile-icon.png">

    <link rel="stylesheet" href="<?= $resource_url ?>/oudigital/v4/eep/css/secondary-nav.css" media="screen, projection">

<meta property="og:title" content="<?= $page_title ?> | Open University" />
<meta property="og:type" content="website" />
<meta property="og:description" content="?= site_name() ?> is an online audio and video player. The Open University offers flexible part-time study, supported distance and open learning for undergraduate and postgraduate courses and qualifications." />
<meta property="og:site_name" content="Open Media Player" />
<meta property="og:url" content="https://mediaplayer.open.ac.uk/" />
<meta property="og:image" content="https://iet-ou.github.io/open-media-player/badge.svg" />

<link rel='canonical' href='https://mediaplayer.open.ac.uk/' />

<!-- ou-head v1.1.1.69 -->
<?php if ($optimizely_etc): ?>
<script src="https://cdn.optimizely.com/js/221317523.js">//</script>
<!-- DTM tag -->
<script src="https://assets.adobedtm.com/b1dc8118356a8e737a4df74290d3f22f3ed977d3/satelliteLib-05638696b6b1957263568043144849476ce12d0d.js" /></script>
<?php endif; ?>
<!-- Google Tag Manager Generic Data Layer -->
<!-- Make sure any site specific layers happen before this line -->
<script> /*<![CDATA[*/ dataLayer = []; /*]]>*/ </script>
<!-- End Google Tag Manager Generic Data Layer -->


<script src="<?= $resource_url ?>/ouheaders/js/headerfooter.min.js?1.1.1.69"
  integrity="sha384-UR7J1ENs7E5+aTmwFaH4NtZDUEe5wLPs5DURUl0vP4xoO00z8ovUsarKDLtorbVQ" crossorigin="anonymous"></script>

<!-- Stylesheets -->
<link rel="stylesheet" href="<?= $resource_url ?>/ouheaders/gui/headerfooter.css?1.1.1.69" media="screen, projection" />
<!--[if lt IE 9]><link rel="stylesheet" href="/ouheaders/gui/header-footer-ie.css" /><![endif]-->
<link rel="stylesheet" href="<?= $resource_url ?>/ouheaders/gui/headerfooter-print.css?1.1.1.69" media="print" />
<!-- End ou-head v1.1.1.69 -->


<!-- site specific head components -->

<link rel="stylesheet" href="<?= $local_res_url ?>assets/site/site-extra.css" />
<link rel="stylesheet" href="<?= $local_res_url ?>assets/site/ou-font-fix.css" />

<!--**
    ** Styles for OU Embed, Noembed etc.
    ** -->
<link rel="stylesheet" href="<?php echo $local_res_url ?>ou-embed.css" title="OU Embed styles" />

<script src="/jquery-3.7.1.min.js"></script>

<?php if($google_analytics): ?>
<!-- Google Analytics -->
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
    (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
    m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', '<?= $google_analytics ?>', 'auto');
  ga('send', 'pageview');
</script>
<!-- End Google Analytics -->
<?php endif; ?>

</head>
<body class="<?= $body_classes ?>" >


<!-- Start of generic site template markup -->
 <div id="int-site">

   <!-- Load the common header -->
   <!-- ou-header v1.1.1.69 -->
<?php if ($google_gtm): ?>
	 <!-- Google Tag Manager -->
	 <noscript>
		 <iframe src="https://www.googletagmanager.com/ns.html?id=GTM-PPS2SH" height="0" width="0" style="display:none; visibility:hidden" name="GTM">&amp;nbsp;</iframe>
	 </noscript>
	 <script>
	 /*<![CDATA[*/
		 (function(w,d,s,l,i){
			 w[l]=w[l]||[];
			 w[l].push({ 'gtm.start': new Date().getTime(), event:'gtm.js' });
			 var f=d.getElementsByTagName(s)[0], j=d.createElement(s), dl= l!='dataLayer'?'&amp;l='+l:'';
			 j.async = true;
			 j.src = 'https://www.googletagmanager.com/gtm.js?id='+i+dl;
			 f.parentNode.insertBefore(j,f);
		 })(window,document,'script','dataLayer','GTM-PPS2SH');
		 /*]]>*/
	 </script>
	 <!-- End Google Tag Manager -->
<?php endif; ?>

	 <div id="ou-header">
		 <a class="ou-skip" href="#int-content" data-translate="true"><i class="int-icon int-icon-arrow-circle-down">&#xA0;</i> Skip to content       </a>

		 <div id="ou-logo">
			 <a class="ou-logo england" href="https://www.open.ac.uk/" title="The Open University">
				 <img src="<?= $resource_url ?>/ouheaders/gui/sprite.png?1.1.1.69" srcset="<?= $resource_url ?>/ouheaders/gui/sprite.png?1.1.1.69 1x, /ouheaders/gui/sprite-x3.png?1.1.1.69 2x" alt="The Open University" />
			 </a>
<?php /*
			 <a class="ou-logo roi" href="http://www.open.ac.uk/republic-of-ireland/" title="The Open University"><img src="/ouheaders/gui/sprite.png?1.1.1.69" srcset="/ouheaders/gui/sprite.png?1.1.1.69 1x, /ouheaders/gui/sprite-x3.png?1.1.1.69 2x" alt="The Open University" /></a>
			 <a class="ou-logo nir" href="http://www.open.ac.uk/northern-ireland/" title="The Open University"><img src="/ouheaders/gui/sprite.png?1.1.1.69" srcset="/ouheaders/gui/sprite.png?1.1.1.69 1x, /ouheaders/gui/sprite-x3.png?1.1.1.69 2x" alt="The Open University" /> </a>
			 <a class="ou-logo scotland" href="http://www.open.ac.uk/scotland/" title="The Open University">   <img src="/ouheaders/gui/sprite.png?1.1.1.69" srcset="/ouheaders/gui/sprite.png?1.1.1.69 1x, /ouheaders/gui/sprite-x3.png?1.1.1.69 2x" alt="The Open University" /> </a>
			 <a class="ou-logo wales" href="http://www.open.ac.uk/wales/" title="The Open University">         <img src="/ouheaders/gui/sprite.png?1.1.1.69" srcset="/ouheaders/gui/sprite.png?1.1.1.69 1x, /ouheaders/gui/sprite-x3.png?1.1.1.69 2x" alt="The Open University" /> </a>
			 <a class="ou-logo cymraeg" href="http://www.open.ac.uk/wales/cy/" title="The Open University">    <img src="/ouheaders/gui/sprite.png?1.1.1.69" srcset="/ouheaders/gui/sprite.png?1.1.1.69 1x, /ouheaders/gui/sprite-x3.png?1.1.1.69 2x" alt="The Open University" /> </a>
*/ ?>
			 <a class="ou-logo nonav" href="javascript:void(0);" title="The Open University"> <img src="<?= $resource_url ?>/ouheaders/gui/sprite.png?1.1.1.69" srcset="<?= $resource_url ?>/ouheaders/gui/sprite.png?1.1.1.69 1x, /ouheaders/gui/sprite-x3.png?1.1.1.69 2x" alt="The Open University" /> </a>
		 </div>
		 <div class="ou-identity">
			 <p class="ou-identity-name" data-hj-masked="" /></div>
			 <a href="#" class="ou-mobile-menu-toggle icon-up" id="ou-mobile-menu-toggle"><img src="<?= $resource_url ?>/ouheaders/gui/sprite.png?1.1.1.69" srcset="<?= $resource_url ?>/ouheaders/gui/sprite.png?1.1.1.69 1x, /ouheaders/gui/sprite-x3.png?1.1.1.69 2x" alt="Toggle service links" title="Toggle service links" /></a>

			 <div id="ou-header-nav">
				 <div id="ou-service-links" role="navigation">
					 <div id="ou-identity"><p class="ou-identity-name" data-hj-masked="" /><p id="ou-identity-id" data-hj-masked="" /></div>

				   <ul>
					   <li class="ou-role-signin" id="ou-signin1"><a href="https://msds.open.ac.uk/signon/sams001.aspx" id="ou-signin2" data-translate="true">Sign in</a><span>|</span></li>
					   <li class="ou-role-signout ou-header-remove" id="ou-signout"><a href="https://msds.open.ac.uk/signon/samsoff.aspx" id="ou-signout2" data-translate="true">Sign out</a><span>|</span></li>
					   <li id="ou-myaccount" class="ou-header-remove"> <a href="https://msds.open.ac.uk/students/" data-translate="true">My Account</a>         <span>|</span>       </li>
					 <li id="ou-studenthome" class="ou-header-remove"> <a href="https://msds.open.ac.uk/students/" data-translate="true">StudentHome</a>         <span>|</span>       </li>
					 <li id="ou-tutorhome" class="ou-header-remove">   <a href="https://msds.open.ac.uk/tutorhome/" data-translate="true">TutorHome</a>         <span>|</span>       </li>
					 <li id="ou-intranethome" class="ou-header-remove"><a href="http://intranet.open.ac.uk/oulife-home/" data-translate="true">IntranetHome</a>         <span>|</span>       </li>
					 <li id="ou-contact"><a href="http://www.open.ac.uk/contact" data-translate="true" class="ou-ia-public" id="ou-public-contact">Contact the OU</a>
						 <a href="http://www2.open.ac.uk/students/help/your-contacts" data-translate="true" class="ou-ia-student" id="ou-student-contact">Contact the OU</a><a href="http://www2.open.ac.uk/tutors/help/who-to-contact" data-translate="true" class="ou-ia-tutor" id="ou-tutor-contact">Contact the OU</a><span>|</span>
					 </li>
					 <li><a href="http://www.open.ac.uk/about/main/strategy-and-policies/policies-and-statements/website-accessibility-open-university" data-translate="true" class="ou-display-public-tutor">Accessibility</a><a href="http://www2.open.ac.uk/students/help/accessibility-using-a-computer-for-ou-study" data-translate="true" class="ou-ia-student">Accessibility</a></li>
					 <li class="ou-search ou-ia-public">
						 <label for="ou-header-search-public" class="ou-hide" data-translate="true">Search the OU</label>
						 <input type="search" id="ou-header-search-public" class="ou-header-search" name="q" data-translate="true" placeholder="Search the OU" onkeyup="javascript: onSearchBoxInput(event);" />
						 <div class="ou-button-container">
							 <button type="button" value="Search" form="ou-search" onclick="submitSearch('ou-header-search-public');"><img src="<?= $resource_url ?>/ouheaders/gui/sprite.png?1.1.1.69" srcset="<?= $resource_url ?>/ouheaders/gui/sprite.png?1.1.1.69 1x, /ouheaders/gui/sprite-x3.png?1.1.1.69 2x" alt="Search" title="Search" /></button>
						 </div>
					 </li>
				 </ul>
			 </div>
			 <!-- end ou-service-links -->

			 <div class="ou-ia-nav" id="ou-ia-nav" role="navigation">
				 <ul class="ou-ia-public">
					 <li class="ou-ia-courses"> <a href="http://www.open.ac.uk/courses/">Courses</a> </li>
					 <li class="ou-ia-postgraduate"> <a href="http://www.open.ac.uk/postgraduate/">Postgraduate</a> </li>
					 <li class="ou-ia-research"><a href="http://www.open.ac.uk/research/">Research</a> </li>
					 <li class="ou-ia-about">   <a href="http://www.open.ac.uk/about/">About</a> </li>
					 <li class="ou-ia-news">    <a href="http://ounews.co/">News &amp; media</a> </li>
					 <li class="ou-ia-business"><a href="http://www.open.ac.uk/business/">Business &amp; apprenticeships</a> </li>
				 </ul>
			 </div>
			 <!-- end ou-ia-nav -->
		 </div>
		 <!--end ou-header-navigation-->
	 </div>
	 <!-- End ou-header v1.1.1.69 -->


<div role='navigation' class='ou-secondary-nav ou-nav-open'>
<ul class='ou-container'>

	<li class='all ou-nav-active'><a href="<?= $base_url ?>"><span>Player home</span></a></li>

	<li class='all ou-nav-inactive'><a href="<?= $base_url ?>about"><span>About</span></a></li>
<?php if ($is_ouembed): ?>
	<li class='all ou-nav-inactive'><a href="<?= $base_url ?>demo/ouldi"><span>OU/OULDI embeds</span></a></li>
<?php endif; ?>
<?php if (! $is_live): ?>
        <li class='all ou-nav-inactive'><a href="<?= $base_url ?>test_area" rel="nofollow"><span> Test Area </span></a>
<?php endif; ?>
        <li class='all ou-nav-inactive'><a href="<?= $base_url ?>about/links" title="Useful Links"><span> Useful Links </span></a>
<?php /*
	<li class='all ou-nav-inactive'><a href="https://iet-ou.github.io/open-media-player/" title="<?= site_name() ?> –  the open source project" rel="external"><span>Project</spam></a></li>
<!--
    - https://web.archive.org/web/20170301223130/http://www.open.ac.uk/blogs/LTT_IET/category/open-media-player/
    - https://nick.freear.org.uk/2015/08/20/introducing-open-media-player.html
  <li class='all ou-nav-inactive'><a href="<?= OUP_BLOG_URL ?>"><span>Blog</spam></a></li>
-->
	<li class='all ou-nav-inactive'><a href="https://www.open.ac.uk/disability/" title="Services for disabled students – external OU" rel="external"><span>Disabled serices</spam></a></li>
	<li class='all ou-nav-inactive'><a href="https://podcast.open.ac.uk/"  title="Open University Podcasts – external OU" rel="external"><span>OU Podcasts</spam></a></li>
	<li class='all ou-nav-inactive'><a href="https://www.open.edu/itunes/" title="The Open University on iTunes U – external OU" rel="external"><span>iTunes U</spam></a></li>
*/ ?>
</ul>
</div>


   <!-- Main Content section -->
    <main id="int-content">
      <div class="country-changer-container">
        <div class="int-container">

	<?php if ($message): ?>
          <div id=warn class="x-oup-test-warning alert alert-warning text-center" role="status">

          <?= $message ?>
          </div>
	<?php endif; ?>


          <h1><?= $page_title ?></h1>

          <?= $content_for_layout ?>

          <!-- close container late if NOT loading qualifications -->

        </div>


      </div>

      <!-- Back to top -->
      <div id="int-btn-top" class="btn-top">
        <a href="#int-site"><i class="int-icon int-icon-chevron-up"></i><span> Back to top</span></a>
      </div>

    </main>


   <!-- site footer -->
     <!-- ou-footer v1.1.1.69 -->
		 <div id="ou-org-footer" class="ou-footer" role="contentinfo">
			 <div class="ou-container">
				 <div class="ou-header">
					 <div class="ou-crest">
						 <img src="<?= $resource_url ?>/ouheaders/gui/sprite.png?1.1.1.69" srcset="<?= $resource_url ?>/ouheaders/gui/sprite.png?[UILD_NUMBER] 1x, /ouheaders/gui/sprite-x3.png?1.1.1.69 2x" alt="The Open University Crest" title="The Open University Crest" />
					 </div>
					 <div class="ou-footer-title">
						 <h3 data-translate="true">The Open University</h3>
					 </div>
				 </div>
				 <div class="ou-footer-nav">
					 <div id="ou-ia-public">
						 <ul>
							 <li> <a href="http://www.open.ac.uk/contact/" class="ou-ia-public" id="ou-footer-public-contact" data-translate="true">Contact the OU</a>
								 <a href="http://www2.open.ac.uk/tutors/help/who-to-contact" class="ou-ia-tutor" id="ou-footer-tutor-contact" data-translate="true">Contact the OU</a>
							 </li>
							 <li> <a href="http://www.open.ac.uk/about/employment/" data-translate="true">Jobs</a> </li>
							 <li> <a href="http://www.open.ac.uk/about/main/strategy-and-policies/policies-and-statements/website-accessibility-open-university" data-translate="true">Accessibility</a> </li>
							 <li> <a href="http://www.open.ac.uk/wales/cy">Cymraeg</a> </li>
							 <li> <a href="http://www.open.ac.uk/about/main/strategy-and-policies/policies-and-statements/conditions-use-open-university-websites" data-translate="true">Conditions of use</a> </li>
							 <li> <a href="http://www.open.ac.uk/about/main/strategy-and-policies/policies-and-statements/website-privacy-ou" data-translate="true">Privacy and cookies</a> </li>
							 <li> <a href="http://www.open.ac.uk/about/main/sites/www.open.ac.uk.about.main/files/files/ecms/web-content/modern-slavery-act-statement.pdf" data-translate="true">Modern Slavery Act (pdf 149kb)</a> </li>
							 <li> <a href="http://www.open.ac.uk/about/main/strategy-and-policies/policies-and-statements/copyright-ou-websites" data-translate="true">Copyright</a> </li>
						 </ul>
					 </div>

			 </div>


			<div class="ou-small-print">
				<p class="ou-copyright"><small>&#xA9;<span id="ou-copyright-year">9999</span>. <span data-translate="true" id="ou-footer-statement" /></small></p>
			</div>
		</div>
	</div>
</div>

<?php /* <script>_satellite.pageBottom();</script> */ ?>
<!-- End ou-footer v1.1.1.69 -->

<!-- /site footer -->


</div>
<!-- /ou container -->

    <input type="hidden" id="loaded-components" value="">

<?php /*
    <script src="<?= $resource_url ?>/oudigital/v4/eep/js/vendor/jquery-1.10.2.min.js"></script>
*/ ?>
	<script src="<?= $resource_url ?>/oudigital/v4/eep/js/ou.menu.nav.js?"
      integrity="sha384-5s3TXPFIwMGLRfawO3atWlK2mPsL3vwETDUSdqZnMoCypIhjU8L7v8t3g9f7FVqg" crossorigin="anonymous"></script>

<?php /*

  <!--Vantage files-->
    <script src="/oudigital/v4/core/js/vendor/spin.js?"></script>
    <script src="/oudigital/v4/core/js/ou.widgets.js?"></script>
  <!--end of Vantage files-->

 <script src="/oudigital/v4/eep/js/vendor/min/jquery-ui-1.10.4.custom.min.js?"></script>
    <script src="/oudigital/v4/core/js/vendor/jquery.actual.js?"></script>
    <script src="/oudigital/v4/eep/js/vendor/jquery.placeholder.js?"></script>
    <script src="/oudigital/v4/eep/js/vendor/jquery.smartresize.js?"></script>

    <script src="/oudigital/v4/eep/js/vendor/cookies.js?"></script>
    <script data-X-src="/oudigital/v4/eep/js/ou.eep.js?"></script>
*/ ?>
    <!--[if lt IE 9]>
    <script src="<?= $resource_url ?>/oudigital/v4/eep/js/vendor/respond.js"></script>
    <![endif]-->

<?php /*
  <script data-X-src="<?= $resource_url ?>/oudigital/v4/eep/js/main.js?"></script>

    <!-- DJS Research scripts...-->
    <link rel="stylesheet" href="http://code.jquery.com/ui/1.9.2/jquery-ui.min.js">
    <script src="/oudigital/v4/eep/js/vendor/jquery-cookie.js?"></script>
*/ ?>
    <script>
      $("link[ href *= 'jquery-ui.css' ]").remove();
    </script>

<?php /*
    <link rel="stylesheet" href="<?= $resource_url ?>/oudigital/v4/core/css/ou.digitalframework.css?">
*/ ?>

</body>
</html>
