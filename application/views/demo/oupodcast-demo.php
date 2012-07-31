
<h2>Beta demos</h2>

<p>These are Beta demonstrations for the <abbr title="The Open University">OU</abbr> Media Player and <abbr title=
"Open University Learning Design Initiative, including Cloudworks">OULDI</abbr> embed projects.



<h4>Audio player</h4>
<p><a class=embed href=
"http://podcast.open.ac.uk/oulearn/languages/spanish/podcast-l314-spanish#!fe481a4d1d">Introduction: A Buerno Puerto, on OU podcast</a>

<h4>Video player</h4>

<p><a class=embed href="http://podcast.open.ac.uk/pod/student-experiences#!db6cc60d6b">Student Experiences</a>
<!--<p>Audio - OpenLearn/ iTunes U.
<p><a class=embed  href=
"http://podcast.open.ac.uk/pod/entrepreneurial-lives/#!cb127010cf">Invisible Boundaries..: Entrepreneurial Lives, on OU podcast</a>
-->
<br /><a href="<?php echo site_url('popup/pod/student-experiences/db6cc60d6b') ?>?theme=<?php echo $this->config->item('player_default_theme') ?>">iframe</a>


<?php if ($this->input->get('all')): ?>

<h4>Video 2</h4>
<p><a class=embed  href="http://podcast.open.ac.uk/pod/mst209-fun-of-the-fair#!a67918b334">Circular Motion...: All the Fun of the Fair, on OU podcast</a>


<h4>Video 3: restricted access</h4>
<p><a class=embed href="http://podcast.open.ac.uk/pod/learn-about-fair-2009/0a49a38de2">Learn about... 2009: OU on iTunes U, by Ben Hawkridge</a>

<?php endif; ?>


<?php if ($this->input->get('ouldi')): ?>

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

