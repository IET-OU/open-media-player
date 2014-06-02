
<h2>Demonstrations</h2>

<p>These are demonstrations for the <abbr title="The Open University">OU</abbr> Media Player project.

<?php if ($use_oembed): ?>

<h3>Audio player</h3>
<p><a class=embed href=
"http://podcast.open.ac.uk/oulearn/languages/spanish/podcast-l314-spanish#!fe481a4d1d">Introduction: A Buerno Puerto, on OU podcast</a>

<h3>Video player</h3>

<p><a class=embed href="http://podcast.open.ac.uk/pod/student-experiences#!db6cc60d6b">Student Experiences</a>
<!--<p>Audio - OpenLearn/ iTunes U.
<p><a class=embed  href=
"http://podcast.open.ac.uk/pod/entrepreneurial-lives/#!cb127010cf">Invisible Boundaries..: Entrepreneurial Lives, on OU podcast</a>
-->

<?php else: ?>

<h3>Audio player</h3>

<p><iframe
 class="x ou audio player embed-rsp" width="360" height="22" frameborder="0"
 src="<?php echo site_url('embed/pod/l314-spanish/fe481a4d1d') ?>"
></iframe><!--Was: height=80 (no-banner) [iet-it-bugs:1486]-->

<h3>Video player</h3>

<p><iframe
 class="x ou video player embed-rsp" width="560" height="337" data-v_height="315" frameborder="0"
 allowfullscreen mozallowfullscreen webkitallowfullscreen
 src="<?php echo site_url('embed/pod/student-experiences/db6cc60d6b') ?>"
></iframe>

<?php endif; ?>

<p><a href="<?php echo site_url('popup/pod/student-experiences/db6cc60d6b') ?>?theme=<?php echo $this->config->item('player_default_theme') ?>">iframe</a>


<?php if ($this->input->get('all')): #Deprecated. ?>

<h3>Video 2</h3>
<p><a class=embed  href="http://podcast.open.ac.uk/pod/mst209-fun-of-the-fair#!a67918b334">Circular Motion...: All the Fun of the Fair, on OU podcast</a>


<h3>Video 3: restricted access</h3>
<p><a class=embed href="http://podcast.open.ac.uk/pod/learn-about-fair-2009/0a49a38de2">Learn about... 2009: OU on iTunes U, by Ben Hawkridge</a>

<?php endif; ?>


<?php if ($this->input->get('ouldi')): #Deprecated. ?>

<h3>OU/OULDI embed</h3>

<a class=embed href="http://youtu.be/NaBBk-kpmL4" data-href-2="http://youtube.com/watch?v=NaBBk-kpmL4">Interview with Martin Bean, on YouTube (captions)</a>

<p><a class=embed  href=
"http://lamscommunity.org/lamscentral/sequence?seq_id=1007900">Crime fighting, on LAMS</a>

<?php /*
<p><a class=embed  href=
"https://docs.google.com/spreadsheet/ccc?key=0AgJMkdi3MO4HdHJqR1kwbXluVHJfT3RYQ1kyZy1oUFE#gid=0">Bec's spreadsheet, Google Docs</a>
*/ ?>

<p><a class=embed  href=
"https://docs.google.com/spreadsheet/viewform?formkey=dFJtUEJTQlZiVEs5R3B5ZFpRd3ZRMFE6MA">OU Player notifications, Google Docs</a>

<p><a class=embed  href=
"http://prezi.com/izeqbfy2z5w-/digital-scholarship">Dig. Scholarship by M.Weller, on Prezi</a>

<?php endif; ?>

