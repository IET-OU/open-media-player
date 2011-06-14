<!DOCTYPE html><html lang="en"><meta charset="utf-8"/><title>*OU player/ OU embed - Demonstrations</title>

<meta name="ROBOTS" content="noindex,nofollow" />

<style>body{font:1em sans-serif;} abbr{cursor:pointer;} .oembed{margin:1em 0; border:1px solid #ccc; border-radius:5px;} </style>

<h1>OU player</h1> <h2>Prototype demonstrations</h2>

<p>These are early prototypes for the <abbr title="The Open University">OU</abbr> player/<abbr title=
"Open University Learning Design Initiative, including Cloudworks">OULDI</abbr> embed projects. Here are <a href=
"http://freear.org.uk/content/ou-media-player-project">introductory blog</a>  <a href="http://freear.org.uk/content/ou-embed-proposal">posts</a>.</p>
<p>NOTE:  the OU player is not yet accessible!!</p>


<h3>OU player</h3>
Audio - Flash falls back to HTML5.
<p><a class=embed href=
"http://podcast.open.ac.uk/oulearn/languages/spanish/podcast-l314-spanish#!fe481a4d1d">Introduction: A Buerno Puerto, on OU podcast</a>


<p><a class=embed href="http://podcast.open.ac.uk/pod/student-experiences#!db6cc60d6b">Student Experiences</a>
<!--<p>Audio - OpenLearn/ iTunes U.
<p><a class=embed  href=
"http://podcast.open.ac.uk/pod/entrepreneurial-lives/#!cb127010cf">Invisible Boundaries..: Entrepreneurial Lives, on OU podcast</a>
-->

<p>Video - Flash falls back to HTML5.
<p><a class=embed  href="http://podcast.open.ac.uk/pod/mst209-fun-of-the-fair#!a67918b334">Circular Motion...: All the Fun of the Fair, on OU podcast</a>


<h3>OU/OULDI embed</h3>
<p><a class=embed href="http://youtube.com/watch?v=NaBBk-kpmL4">Interview with Martin Bean, on YouTube (captions)</a>

<p><a class=embed  href=
"http://lamscommunity.org/lamscentral/sequence?seq_id=1007900">Crime fighting, on LAMS</a>

<p><a class=embed  href=
"http://spreadsheets.google.com/viewform?formkey=dFJtUEJTQlZiVEs5R3B5ZFpRd3ZRMFE6MA#height=690">OU Player notifications, on Google Docs</a>

<p><a class=embed  href=
"http://prezi.com/izeqbfy2z5w-/digital-scholarship">Dig. Scholarship by M.Weller, on Prezi</a>


<p>&copy;2011 The Open University.</p>

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.5.2/jquery.min.js"></script>
<script src="<?=site_url('scripts/jquery.oembed.js') ?>"></script>
<script type="text/javascript">
  $(document).ready(function() {
    $("a.embed"    ).oembed(null, {'oupodcast':{'<?=OUP_PARAM_THEME ?>':'<?=$req->theme ?>'}});<?php /*null, { embedMethod: "replace" });*/ ?>

    $("[rel=embed]").oembed(); //Legacy.
  });
</script>

</html>