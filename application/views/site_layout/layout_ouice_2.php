<?php
/**
*
* Source: http://www3.open.ac.uk/study/
*/

  $site_url = $resource_url = 'http://www3.open.ac.uk';
  $base_url = base_url();
  $is_demo_page = TRUE;
  $is_player_site = TRUE;

  $body_classes = 'ou-ia-community sections oup-jquery-test';

?>
<!doctype html><html lang="en"><meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1" />
<meta charset="utf-8" /><title>
	Study at the OU - Degrees, Diplomas, Courses, Certificates and Qualifications - Open University
</title>
<meta name="ROBOTS" content="noindex,nofollow" />

<meta name="description" content="Open University is the UK's largest university for part-time higher education..." />
<meta name="keywords" content="" />
<meta name="author" content="The Open University" />
<meta name="copyright" content="© 2012 The Open University" />

<!-- **********************************************************************************
    ***  OUICE 3
    ***  ou-head.html will load all necessary css for OUICE styles required on page....
    ***  ********************************************************************************** -->
<link rel="stylesheet" href="<?php echo $resource_url ?>/includes/headers-footers/ou-header.css" media="screen, projection" />
<link rel="stylesheet" href="<?php echo $resource_url ?>/includes/ouice/3/screen.css" media="screen, projection" />
<link rel="stylesheet" href="<?php echo $resource_url ?>/includes/ouice/3/print.css" media="print" />

<!--[if lt IE 9]>
<link rel="stylesheet" href="<?php echo $resource_url ?>/includes/ouice/3/ie.css" />
<![endif]-->

<!--[if lt IE 7]>
<link rel="stylesheet" href="<?php echo $resource_url ?>/includes/ouice/3/ie6.css" />
<![endif]-->

<meta name="viewport" content="width=device-width" />

<link rel="stylesheet" href="<?php echo $resource_url ?>/includes/ouice/3/mobile.css" media="only screen and (max-device-width:640px)" />
<link rel="stylesheet" href="<?php echo $resource_url ?>/includes/ouice/3/mobile.css" media="only screen and (max-width:640px)" />
<link rel="stylesheet" href="<?php echo $resource_url ?>/includes/headers-footers/ou-header-mob.css" media="only screen and (max-device-width:640px)" />
<link rel="stylesheet" href="<?php echo $resource_url ?>/includes/headers-footers/ou-header-mob.css" media="only screen and (max-width:640px)" />

<!--<link rel="alternate stylesheet" href="/includes/ouice/3/mobile.css" title="ou-mobile" /> -->

<script src="<?php echo $resource_url ?>/includes/headers-footers/ou-header.js"></script>
<!--<link href="<?php echo $resource_url ?>/study/stylesheets/study-common.css" rel="stylesheet" media="all" />-->

<!-- site specific head components -->
<!--<script src="http://code.jquery.com/jquery-latest.js"></script>-->
<!--<link rel="stylesheet" href="<?php echo $resource_url ?>/study/stylesheets/themes/base/jquery.ui.all.css" />-->  
<!--<script src="<?php echo $resource_url ?>/study/includes/jquery-scripts/jquery-1.7.1.min.js"></script>-->
<!--<style media="screen">@import "/study/stylesheets/student-services-phone.css";</style>-->


<script src="<?php echo OUP_JS_CDN_JQUERY_MIN ?>"></script>

<?php if ($is_demo_page): ?>
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/client/site-embed.css" />
<?php endif; ?>


<body class="X-ou-ia-study <?php echo $body_classes ?>" id="X-study" >

    <div id="ou-org">

<script>if (typeof window.ou_sitestat=='function')ou_sitestat();</script>
<div id="ou-org-header"> <a class="ou-skip" href="#ou-content">Skip to content</a> <a class="ou-link-ou" href="http://www.open.ac.uk/"><img src="<?php echo $resource_url ?>/includes/headers-footers/oulogo-56.jpg" alt="The Open University" /></a>
  <div class="ou-role-nav">
    <ul>
      <li class="ou-role-accessibility"><a href="http://www.open.ac.uk/accessibility/">Accessibility</a></li>
      <li class="ou-role-signin" id="ou-signin1"><a href="https://msds.open.ac.uk/signon/sams001.aspx" id="ou-signin2">Sign in</a></li>
      <li id="ou-signout" class="ou-role-signout"><a href="https://msds.open.ac.uk/signon/samsoff.aspx" id="ou-signout2">/ Sign out</a></li>
      <li id="ou-studenthome" class="ou-role-studenthome"><a href="http://www.open.ac.uk/students/" id="ou-studenthome2">StudentHome</a></li>
      <li id="ou-tutorhome" class="ou-role-tutorhome"><a href="http://www.open.ac.uk/tutorhome/">TutorHome</a></li>
      <li id="ou-intranet" class="ou-role-intranet"><a href="http://intranet.open.ac.uk/">IntranetHome</a></li>
      <li id="ou-sponsor" class="ou-role-sponsor"><a href="https://css2.open.ac.uk/employers/sponsorhome/home/HomePage.aspx">SponsorHome</a></li>
      <li id="ou-contact" class="ou-role-contact"><a href="http://www.open.ac.uk/contact/">Contact</a></li>
      <li id="ou-search" class="ou-role-search"><a href="http://www.open.ac.uk/search/">Search the OU</a></li>
    </ul>
  </div>
  <div class="ou-ia-nav">
    <ul>
      <li class="ou-ia-home"><a href="http://www.open.ac.uk/">The Open University</a></li>
      <li class="ou-ia-study"><a href="http://www.open.ac.uk/study/">Study at the OU</a></li>
      <li class="ou-ia-research"><a href="http://www.open.ac.uk/research/">Research at the OU</a></li>
      <li class="ou-ia-community"><a href="http://www.open.ac.uk/community/">OU Community</a></li>
      <li class="ou-ia-about"><a href="http://www.open.ac.uk/about/">About the OU</a></li>
    </ul>
  </div>
</div>

        <div id="ou-site">

            <div id="ou-site-header">
               
               <!-- Standard Navigation    -->   
               
<ul class="ou-sections">
<?php if ($is_player_site): ?>
    <li class="first menu- selected active-trail active"><a href="<?php echo $base_url ?>" class="selected active">Player home</a></li>
    <li class="menu-"><a href="<?php echo $base_url ?>about" >About</a></li>
    <li class="menu-"><a href="<?php echo $base_url ?>about/help" >Player Help</a></li>
    <li class="menu-"><a href="<?php echo $base_url ?>demo/ouldi" >Other OU embeds</a></li>
    <li class="menu-"><a href="<?php echo $base_url ?>demo/podcast_errors" >Error tests</a></li>
    <li class="menu-"><a href="<?php echo $base_url ?>demo/vle_fewer" title="Requires login" >[VLE]</a></li>
	<li class="last menu-"><a href="http://podcast.open.ac.uk/" >OU Podcasts</a></li>
<?php else: ?>
    <li id="tm-study-home"><a href="<?php echo $site_url ?>/study/">Study at the OU</a></li>
    <li id="tm-undergraduate"><a href="<?php echo $site_url ?>/study/undergraduate/index.htm">Undergraduate</a></li>
    <li id="tm-postgraduate"><a href="<?php echo $site_url ?>/study/postgraduate/index.htm">Postgraduate</a></li>
    <li id="tm-research"><a href="<?php echo $site_url ?>/study/research-degrees/index.htm">Research degrees</a></li>
    <li id="tm-professional-skills"><a href="<?php echo $site_url ?>/study/professional-skills/index.htm">Professional skills</a></li>
    <li id="tm-study-explained"><a href="http://www8.open.ac.uk/study/explained/">Study explained</a></li>
<?php endif; ?>
</ul>

                
            </div>

            <div id="ou-site-body">
                
                <div>
                    <!-- Content Page is loaded here -->


<style >
div.teaser {margin: 0 0 2em 0; float:left; clear:both; width:100%; height:Auto;}
div#col1 div.teasers h2 {margin-bottom:0; padding-bottom: 0; margin-left:105px; margin-top:0;}
div.teasers p {margin-top:0; padding-top:.5em; padding-left: 105px;}
div.teasers ul {margin:0; list-style:none; padding:0; padding-left: 105px;}
 
/*div.teasers ul li {display: inline; background:none; margin:0; padding:0;*/ /*white-space:nowrap; gd53: removed 04.03.08*/
div.teasers ul li {display: inline; background:none; margin:0; padding:0; white-space:nowrap;}

/*div.teasers ul li a {padding: 0 8px 0 0; border-right: 1px solid #ccc; margin-right: 4px;}*/
div.teasers ul li a {padding: 0 8px 0 0; border-right: 1px solid #ccc; margin-right: 4px;  white-space:nowrap;}
div.teasers ul li:last-child a {border-right:none;}

</style>

<div id="ou-page" class="study">

    <div id="ou-region0">
    <!-- ou-region0-components -->
    </div>

    <div id="ou-region1">
        <div id="ou-content" class="ou-content">

    <h1><?php echo isset($header) ? $header : 'OU Media Player' ?></h1>


<?php echo $content_for_layout ?>


<?php /*
            <div id="ou-introduction">
                <p>Want to get a qualification that will help you develop or change your career? Learn a subject in depth? The Open University could provide the flexibility, the qualifications and the top-class teaching you’re after. For most courses you don't need any previous qualifications. And with our world-leading blend of distance learning and innovative study materials, you’ll get an exceptional learning experience.</p>
            </div>

            <div class="teasers">
                  
                <div class="ou-feature-block" style="float:left;width:93%;">
                    <div class="teaser" id="teaser-explore" >
                      <img class="ou-go1" style="padding-top:15px;" src="/study/images/AF008744crop.jpg" alt="Explore the prospectus" />
                      <h2>Explore the prospectus</h2>
                      <p>Around 600 courses can count towards more than 250 qualifications. With specially designed introductory courses, you can gradually build towards your first university-level qualification, towards a degree and even beyond.</p>
                      <ul>
                      <li><a href="/study/undergraduate/index.htm">Undergraduate</a></li>
					  <!-- ..-->
                      </ul>
                    </div>
                </div>
                      
                <!--... -->
           </div>    <!-- DIV teasers  -->

        </div> <!-- ou-content -->
    </div>  <!-- ou-region1    -->

    <div id="ou-region2">
        <!-- ou-region2-components -->
        
        <!-- **********************************************************************************
        ***  Borrowed from OUICE 3
        ***  ********************************************************************************** -->
<style >
  /* ... *-/
</style>

<div class="ou-box" id="sign-post" style="float:left;margin-top:3px;">
	
	<span class="ou-title">Are you already an OU student ?</span>
	<a class="ou-action" href="https://msds.open.ac.uk/students/next-module.aspx">
	<span class="ou-desc">Go to StudentHome for information on choosing your next module.</span>
	</a>
	
</div>
            
        
        <div class="ou-feature-block" style="clear:both;margin-top:0em;">
            <h3><a href="/study/undergraduate/index.htm">Undergraduate</a></h3>
            <ul>
                <li><a href="/study/undergraduate/qualification/arts-and-humanities/index.htm">Arts and Humanities</a></li>
                <li><a href="/study/undergraduate/qualification/business-and-management/index.htm">..</a></li>
                
                <li><a href="/study/undergraduate/qualification/social-sciences/index.htm">Social Sciences</a></li>
            </ul>
            <h3><a href="/study/postgraduate/index.htm">See Postgraduate</a></h3>
            <br />
        </div>

        
<div id="how-to-register-banner" >

    <div class="ou-box" style="background:transparent url(/study/images/four-simple-steps.gif) no-repeat scroll 100% 0%;min-height:153px;max-width:235px;padding-top:8px;">
        <div class="banner-text">
            
                <img class="ou-go1" src="/study/images/block-quote-open.gif" alt="opening quotes"/>
                <span class="line">4 easy steps to</span>
                <span class="line">becoming an</span>
                <span class="line">OU undergraduate</span>
                
                <span class="line" style="display:inline;">student<img src="/study/images/block-quote-close.gif" alt="opening quotes" style="padding:0px 0px 0px 5px;display:inline;"/>
                </span>
            
        </div>
        
        <div style="margin-top:30px;">
        <!--<ul style="list-style:none;display:block;padding:0px;margin:0px;">
        <li style="margin:0px;padding:0px;display:inline;">-->
        <a href="/study/undergraduate/qualification/register/index.htm" style="padding-left:5px;font-size:110%;font-weight:bold;">Find out more</a>
        <!--</li>
        </ul>-->
        </div>
        
    </div>    
</div>


<div id="student-speak-to-advisor" style="width:88%;">

</div>


        <!-- Load the user control to handle Employer Speak to Advisor box.. -->
        <div id="employer-speak-to-advisor" style="width:88%;">

</div>
*/ ?>


    </div> <!-- ou-region2  -->

</div> <!-- ou-page -->



                </div>
                
            </div>  <!-- ou-site-body -->
 
            <div id="ou-site-footer">
                <a class="ou-to-top" href="#ou-content">Back to top</a>
            </div>

        </div>  <!-- ou-site -->

    <div id="ou-org-footer">

<div class="ou-grid ou-mobile-footer" id="ou-mobile-jlinks"></div>

<div class="ou-grid ou-footer-links">
  <div class="ou-c1of4">
    <ul>
      <li class="ou-title"><a href="http://www.open.ac.uk">The Open University</a></li>
      <li class="ou-copyright">&#169; Copyright <span id="sbyear"></span>. All rights reserved</li>
      <li class="ou-phone">+44 (0) 845 300 60 90</li>
      <li class="ou-email"><a href="http://www.open.ac.uk/email/">Email us</a></li>
      <li class="ou-study"><a href="http://www.open.ac.uk/study/">Study at the OU</a></li>
      <li class="ou-research"><a href="http://www.open.ac.uk/research/">Research</a></li>
      <li class="ou-community"><a href="http://www.open.ac.uk/community/">Community</a></li>
      <li class="ou-about"><a href="http://www.open.ac.uk/about/">About</a></li>
      <li class="ou-accessibility"><a href="http://www.open.ac.uk/about/">Accessibility</a></li>
    </ul>
  </div>
  <div class="ou-c2of4">
    <ul>
    <li class="ou-contact"><a href="http://www.open.ac.uk/contact/">Contact</a></li>
      <li class="ou-search"><a href="http://www.open.ac.uk/search/">Search</a></li>
      <li class="ou-privacy"><a href="http://www.open.ac.uk/privacy/">Website privacy</a></li>
      <li class="ou-copyright"><a href="http://www.open.ac.uk/copyright/">Copyright</a></li>
      <li class="ou-conditions"><a href="http://www.open.ac.uk/conditions/">Conditions of use</a></li>
      <li class="ou-cymraeg"><a href="http://www.open.ac.uk/cymraeg/">Cymraeg</a></li>
      <li class="ou-mobile-enquiries">0845 300 60 90</li>
    </ul>
  </div>
  <div class="ou-c3of4">
    <ul>
<?php /*
      <li class="ou-ia-study"><a href="http://www3.open.ac.uk/study/undergraduate/">Undergraduate</a></li>
      <li class="ou-ia-study"><a href="http://www3.open.ac.uk/study/postgraduate/">Postgraduate</a></li>
      <li class="ou-ia-study ou-ia-research"><a href="http://www.open.ac.uk/research-degrees">Research degrees</a></li>
      <li class="ou-ia-home ou-ia-study"><a href="http://www.open.ac.uk/employers/">Employers</a></li>
      <li class="ou-ia-about"><a href="http://www8.open.ac.uk/about/main/the-ou-explained/">OU explained</a></li>
      <li class="ou-ia-about"><a href="http://www8.open.ac.uk/about/main/faculties-and-centres/">Faculties and centres</a></li>
      <li class="ou-ia-about"><a href="http://www8.open.ac.uk/about/main/admin-and-governance/">Admin and governance</a></li>
      <li class="ou-ia-about ou-ia-home"><a href="http://www.open.ac.uk/news/">Press Room</a></li>
      <li class="ou-ia-home"><a href="http://www.open.ac.uk/alumni/" class="ou-home">Alumni</a></li>
      <li class="ou-ia-home ou-ia-research ou-ia-about"><a href="http://www.open.ac.uk/jobs/">Jobs</a></li>
      <li class="ou-ia-home"><a href="http://www.open.ac.uk/fundraising/">Donate</a></li>
*/ ?>
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

<script>if (typeof window.ou_init=='function')ou_init();</script>

    </div>  <!-- ou-org -->
    
<script src="<?php echo $resource_url ?>/includes/ouice/3/scripts.js"></script>
<!-- site specific scripts -->


<?php if ($is_demo_page): ?>
<!--
	<script src="<?php echo OUP_JS_CDN_JQUERY_MIN ?>"></script>
-->

<script src="<?php echo site_url('scripts/jquery.oembed.js') ?>"></script>
<script>
$(document).ready(function() {
  $("a.embed").oembed(null, {'oupodcast':{'<?php echo OUP_PARAM_THEME ?>':'<?php echo isset($req->theme) ? $req->theme :'' ?>'}});<?php /*null, { embedMethod: "replace" });*/ ?>
});
</script>
<?php endif; ?>


</body>
</html>