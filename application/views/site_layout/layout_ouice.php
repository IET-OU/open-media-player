<?php
/**
 * OUICE 3 site template/layout: "Study at the OU"  (Drupal)
 *
 * Based on: http://www8.open.ac.uk/study/explained/#org
 *
 * @copyright Copyright 2012 The Open University.
 */

$site_url = $resource_url = 'http://www8.open.ac.uk';


?><!doctype html><html lang="en-GB"><meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta charset="utf-8" /><title>*Study Explained | Open University</title>

  <meta name="viewport" content="width=device-width, user-scalable=yes, initial-scale=0.8" />
  <meta name="ROBOTS" content="noindex,nofollow" />

  <!-- link to ou webstandards OUICE -->
<link href="<?php echo $resource_url ?>/includes/header.css" rel="stylesheet" media="all" />
<link href="<?php echo $resource_url ?>/includes/ouice/screen.css" rel="stylesheet" media="screen, projection" />
<link href="<?php echo $resource_url ?>/includes/ouice/print.css" rel="stylesheet" media="print" />
<link href="<?php echo $resource_url ?>/includes/headers-footers/header-public-centre-gradient.css" rel="stylesheet" media="all" />
<!--[if lt IE 9]>
  <link rel="stylesheet" href="<?php echo $resource_url ?>/includes/ouice/ie.css" />
<![endif]-->
<!--[if lt IE 7]>
  <link rel="stylesheet" href="<?php echo $resource_url ?>/includes/ouice/ie6.css" />
<![endif]-->
<?php /*<link rel="stylesheet" media="all" href="/study/explained/modules/aggregator/aggregator.css?u" />
  <link rel="stylesheet" media="all" href="/study/explained/modules/book/book.css?u" /> <link rel="stylesheet" media="all" href="/study/explained/modules/node/node.css?u" /> <link rel="stylesheet" media="all" href="/study/explained/modules/poll/poll.css?u" /> <link rel="stylesheet" media="all" href="/study/explained/modules/system/defaults.css?u" /> <link rel="stylesheet" media="all" href="/study/explained/modules/system/system.css?u" /> <link rel="stylesheet" media="all" href="/study/explained/modules/system/system-menus.css?u" />
<link rel="stylesheet" media="all" href="/study/explained/modules/user/user.css?u" />
<link rel="stylesheet" media="all" href="/study/explained/sites/all/modules/contrib/cck/theme/content-module.css?u" />
<link rel="stylesheet" media="all" href="/study/explained/sites/all/modules/contrib/ctools/css/ctools.css?u" />
<link rel="stylesheet" media="all" href="/study/explained/sites/all/modules/contrib/date/date.css?u" />
<link rel="stylesheet" media="all" href="/study/explained/sites/all/modules/contrib/date/date_popup/themes/datepicker.1.7.css?u" />
<link rel="stylesheet" media="all" href="/study/explained/sites/all/modules/contrib/date/date_popup/themes/jquery.timeentry.css?u" />
<link rel="stylesheet" media="all" href="/study/explained/sites/all/modules/contrib/fckeditor/fckeditor.css?u" />
<link rel="stylesheet" media="all" href="/study/explained/sites/all/modules/contrib/filefield/filefield.css?u" />
<link rel="stylesheet" media="all" href="/study/explained/sites/all/modules/contrib/tagadelic/tagadelic.css?u" />
<link rel="stylesheet" media="all" href="/study/explained/modules/forum/forum.css?u" />
<link rel="stylesheet" media="all" href="/study/explained/misc/farbtastic/farbtastic.css?u" />
<link rel="stylesheet" media="all" href="/study/explained/sites/all/modules/contrib/calendar/calendar.css?u" />
<link rel="stylesheet" media="all" href="/study/explained/sites/all/modules/contrib/cck/modules/fieldgroup/fieldgroup.css?u" />
<link rel="stylesheet" media="all" href="/study/explained/sites/all/modules/contrib/views/css/views.css?u" />
*/ ?>
<link rel="stylesheet" media="screen" href="<?php echo $resource_url ?>/study/explained/sites/all/themes/ou_exstd/styles/style.css?u" />
<!--[if IE 8]>
  <link href="<?php echo $resource_url ?>/study/explained/sites/all/themes/ou_exstd/styles/style_ie8.css" rel="stylesheet" media="screen" />
<![endif]-->
<!--[if IE 7]>
  <link href="<?php echo $resource_url ?>/study/explained/sites/all/themes/ou_exstd/styles/style_ie7.css" rel="stylesheet" media="screen" />
<![endif]-->
<!--[if IE 6]>
  <link href="<?php echo $resource_url ?>/study/explained/sites/all/themes/ou_exstd/styles/style_ie6.css" rel="stylesheet" media="screen" />
<![endif]-->

<?php /*<link rel="EditURI" type="application/rsd+xml" title="RSD" href="http://www8.open.ac.uk/study/explained/blogapi/rsd" />
<link rel="next" href="/study/explained/study-explained/building-your-qualification" />
<link rel="shortcut icon" href="/study/explained/misc/favicon.ico" type="image/x-icon" />

    <meta name="keywords" content="Study explained,,Open University" />    <meta name="robots" content="noodp" />*/ ?>



<link rel="stylesheet" href="<?php echo base_url() ?>assets/client/site-embed.css" />


<body class="ouice sections i5">
<div id="org">
    <script src="<?php echo $resource_url ?>/includes/headers-footers/header2.js"></script>
<script>if (typeof window.ou_sitestat=='function')ou_sitestat();</script>
<div id="org-header">
<a id="ou-skip" href="#ou-content">Skip to content</a>
<div class="ou-hswrap">
	<div id="hsheader">
		<a href="http://www.open.ac.uk/" id="hslogo"><img alt="The Open University" src="<?php echo $resource_url ?>/includes/headers-footers/oulogo-56.jpg" width="83" height="56" /></a>
		<div id="sbhstools">
			<ul>
				<li id="ou-accessibility"><a href="http://www.open.ac.uk/accessibility/">Accessibility</a></li>
				<li class="wrapper" id="ou-signin-area">
					<ul>
						<li id="ou-person" class="hide"></li>
						<li id="ou-signin1"><a href="https://msds.open.ac.uk/signon/sams001.aspx" id="ou-signin2">Sign in</a></li>
						<li id="ou-signout" class="hide"><a href="https://msds.open.ac.uk/signon/samsoff.aspx">&nbsp;/ Sign out</a></li>
						<li id="ou-studenthome" class="hide"><a href="http://www.open.ac.uk/students/" id="ou-studenthome2">StudentHome</a></li>
						<li id="ou-tutorhome" class="hide"><a href="http://www.open.ac.uk/tutorhome/">TutorHome</a></li>
						<li id="ou-intranet" class="hide"><a href="http://intranet.open.ac.uk/">IntranetHome</a></li>
						<li id="ou-sponsor" class="hide"><a href="http://www.open.ac.uk/employers/">SponsorHome</a></li>
					</ul>
				</li>
				<li id="ou-contact"><a href="http://www3.open.ac.uk/contact/">Contact</a></li>
			</ul>
			<form action="http://css2.open.ac.uk/search/search.aspx" method="post">
				<label for="ousrch">Search:</label>
				<input id="ousrch" type="text" class="formField" name="txtSearchTerms" value="Search the OU" onfocus="ou_srchclk()" /><input type="hidden" name="external" value="yes" /><input type="hidden" name="chkProspectus" value="on" /><input type="hidden" name="chkOpenLearn" value="on" /><input type="hidden" name="chkPublic" value="on" /><input type="submit" value="Search" class="formButton" />
			</form>
		</div>
		<ul id="sbhsnavigation">
			<li class="first"><a href="http://www.open.ac.uk/">The Open University</a></li>
			<li class="current"><a href="http://www.open.ac.uk/study/">Study at the OU</a></li>
			<li><a href="http://www.open.ac.uk/research/">Research at the OU</a></li>
			<li><a href="http://www.open.ac.uk/community/">OU Community</a></li>
			<li><a href="http://www.open.ac.uk/about/">About the OU</a></li>			
		</ul>
	</div>
</div>
<div class="ou-clear"></div>
</div>
    <div id="site">
        <div id="site-header">
            			<!-- Start of site-header -->
                            <!-- End of site-header -->
                        <ul class="sections"><li  class="first menu-8884"><a href="http://www3.open.ac.uk/study/">Study at the OU</a></li>
<li  class="selected menu-8021 active-trail active"><a href="<?php echo $site_url ?>/study/explained/study-explained" class="selected active">Study explained</a></li>
<li  class="menu-5778"><a href="<?php echo $site_url ?>/study/explained/is-ou-study-right-for-me">Is OU study right for me?</a></li>
<li  class="menu-7998"><a href="<?php echo $site_url ?>/study/explained/what-is-distance-learning">What is distance learning?</a></li>
<li  class="menu-5779"><a href="<?php echo $site_url ?>/study/explained/where-can-i-study">Where can I study?</a></li>
<li  class="menu-5781"><a href="<?php echo $site_url ?>/study/explained/how-to-apply">How to apply</a></li>
<li  class="last menu-8969"><a href="<?php echo $site_url ?>/study/explained/fees-2012">Fees 2012</a></li>
</ul>                    </div>
        <div id="site-body">
            <div id="page">
                <!-- Start of region 0 -->
                                <!-- End of region 0 -->
                <!-- Start of region 1 -->
                    <div id="region1">
                                    	<div id="search_box">
                                            </div>
                                            <div class="ou-content" id="ou-content"></div>
                                                        
                                    <?php /*<h1>Study explained</h1>                                                                                                                <!-- start OU External Standard v2 node.tpl.php -->
		<div id="node-320" class="node ">*/ ?>




<?php echo $content_for_layout ?>




<!-- /end block.tpl.php -->                    </div>
                <!-- End of region 2 -->
                <!-- Start of region 3 -->
                                    <!-- End of region 3 -->
            </div>
        </div>
        <div id="site-footer">
                        			<a href="#org" class="to-top">Back to top</a>
        </div>
    </div>
    <div id="org-footer">
<div class="ou-clear"></div>
<div class="ou-hswrap">
	<div id="hsdeepfooter">
		<div class="hsfooterGrid">
			<div class="hsfooterRegion1">
				<div class="sbc1of4">
					<h3>The Open University</h3>
					<p>&copy; Copyright <span id="sbyear"></span>. All rights reserved.</p>
					<h4>+44 (0) 845 300 60 90<br />
					<a href="http://www.open.ac.uk/email/">Email us</a></h4>
				</div>
				<div class="sbc2of4">
					<ul>
						<li><a href="http://www.open.ac.uk/privacy">Website privacy</a></li>
						<li><a href="http://www.open.ac.uk/copyright">Copyright</a></li>
						<li><a href="http://www.open.ac.uk/conditions">Conditions of use</a></li>
						<li><a href="http://www.open.ac.uk/cymraeg">Cymraeg</a></li>
					</ul>
				</div>
				<div class="sbc3of4">
					<ul>
						<li><a href="http://www3.open.ac.uk/study/undergraduate">Undergraduate</a></li>
						<li><a href="http://www3.open.ac.uk/study/postgraduate">Postgraduate</a></li>
						<li><a href="http://www.open.ac.uk/research-degrees">Research degrees</a></li>
						<li><a href="http://www.open.ac.uk/employers">Employers</a></li>
					</ul>
				</div>
				<div class="clear"></div>
			</div>
		</div>
	</div>
</div></div>   
<script>//<![CDATA[
ou_init();
//]]></script>
</div>

<script src="<?php echo OUP_JS_CDN_JQUERY_MIN ?>"></script>

<?php /*<script src="/study/explained/misc/jquery.js?u"></script>*/ ?>
<script src="<?php echo $resource_url ?>/study/explained/misc/drupal.js?u"></script>
<script>
<!--//--><![CDATA[//><!--
jQuery.extend(Drupal.settings, { "basePath": "/study/explained/", "jcarousel": { "ajaxPath": "/study/explained/jcarousel/ajax/views" } });
//--><!]]>
</script>
<script src="<?php echo $resource_url ?>/includes/ouice/scripts.js"></script>
<script src="<?php echo $resource_url ?>/study/explained/sites/all/themes/ou_exstd/scripts/hstheme.js"></script>



<script src="<?php echo site_url('scripts/jquery.oembed.js') ?>"></script>
<script>
$(document).ready(function() {
  $("a.embed").oembed(null, {'oupodcast':{'<?php echo OUP_PARAM_THEME ?>':'<?php echo $req->theme ?>'}});<?php /*null, { embedMethod: "replace" });*/ ?>
});
</script>

</body>
</html>