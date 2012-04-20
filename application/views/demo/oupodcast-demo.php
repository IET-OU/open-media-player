<?php
  $input = $this->input;
  $body_classes = ' oup-jquery-test';
  $body_classes .= $input->get('edge') ? ' oup-edge' :'';
  $body_classes .= $input->get('size') ? ' oup-'.$input->get('size') :'';
?>
<!doctype html><html lang="en" class="<?=$body_classes ?>"><meta charset="utf-8"/><title>*OU player/ OU embed - Beta Demonstrations</title>

<meta name="viewport" content="width=device-width, user-scalable=yes, initial-scale=0.8" />
<meta name="ROBOTS" content="noindex,nofollow" />

<link rel="stylesheet" href="<?=base_url().'application/assets/client/site-embed.css' ?>" />


<h1>OU player</h1> <h2>Beta tests</h2>

<p>These are Beta demonstrations for the <abbr title="The Open University">OU</abbr> player/<abbr title=
"Open University Learning Design Initiative, including Cloudworks">OULDI</abbr> embed projects. Here are <a href=
"http://freear.org.uk/content/ou-media-player-project">introductory blog</a>  <a href="http://freear.org.uk/content/ou-embed-proposal">posts</a>.</p>

<p>NOTE:  these demos use the <a href="<?=site_url('scripts/jquery.oembed.js') ?>">jquery-oembed plugin</a>.
<p>NOTE:  the OU player is now fairly accessible. Feedback to <a href="mailto:N.D.Freear+@+open.ac.uk?subject=OU+player">N.D.Freear+@+open.ac.uk</a></p>


<h3>OU player</h3>

<p>Audio 1
<p><a class=embed href=
"http://podcast.open.ac.uk/oulearn/languages/spanish/podcast-l314-spanish#!fe481a4d1d">Introduction: A Buerno Puerto, on OU podcast</a>

<p>Video 1

<p><a class=embed href="http://podcast.open.ac.uk/pod/student-experiences#!db6cc60d6b">Student Experiences</a>
<!--<p>Audio - OpenLearn/ iTunes U.
<p><a class=embed  href=
"http://podcast.open.ac.uk/pod/entrepreneurial-lives/#!cb127010cf">Invisible Boundaries..: Entrepreneurial Lives, on OU podcast</a>
-->
<br /><a href="http://embed.open.ac.uk/embed/pod/student-experiences/db6cc60d6b?theme=ouice-light">iframe</a>

<p>Video 2
<p><a class=embed  href="http://podcast.open.ac.uk/pod/mst209-fun-of-the-fair#!a67918b334">Circular Motion...: All the Fun of the Fair, on OU podcast</a>



<?php if ($input->get('ouldi')): ?>

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


<p>&copy;2011-2012 The Open University.</p>

<script src="<?=OUP_JS_CDN_JQUERY_MIN ?>"></script>
<script src="<?=site_url('scripts/jquery.oembed.js') ?>"></script>
<script>
  $(document).ready(function() {
    $("a.embed"    ).oembed(null, {'oupodcast':{'<?=OUP_PARAM_THEME ?>':'<?=$req->theme ?>'}});<?php /*null, { embedMethod: "replace" });*/ ?>

    $("[rel=embed]").oembed(); //Legacy.
  });
</script>

</html>