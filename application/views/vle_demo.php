<?php
    $embed_url = site_url('embed/vle');
?>
<!DOCTYPE html><html lang="en"><meta charset="utf-8" /><title>OUVLE player demo</title>
<link rel="icon" href="<?=base_url() ?>assets/favicon.ico" />
<style>body{font:1em sans-serif;} iframe{display:block; border:1px solid #bbb; border-radius:4px;}</style>

<h1>OUVLE player</h1> <h2>Prototypes</h2>

<p>NOTE:  not yet accessible!</p>
<p>IMPORTANT: <a href="http://learn.open.ac.uk/site/sc">Visit 'Learn' first, to prevent access errors</a>.</p>


<!--
 * Is overflow:hidden risky for accessibility? scrolling=no?
 * caption_url/ image_url: Can be absolute or relative to media_url.
318+30px;
 -->
<p class="video">
<iframe tabindex="0" title="Video player: Introduction to Fairmead" width="512" height="348" frameborder="0"<?php /*scrolling="no"*/ ?> style="overflow:hidden;" src=
"<?=$embed_url;
?>?title=Introduction+to+Fairmead&amp;media_url=http%3A//learn.open.ac.uk/file.php/5195/!via/oucontent/course/100705/k315-0-video1.mp4&caption_url=k315-0-video1.srt&width=512&height=348"
></iframe>
<small>A <a href="http://learn.open.ac.uk/file.php/5195/!via/oucontent/course/100705/k315-0-video1.mp4">video</a>, <a href="<?=$embed_url;
?>?title=Introduction+to+Fairmead&amp;media_url=http%3A//learn.open.ac.uk/file.php/5195/!via/oucontent/course/100705/k315-0-video1.mp4&amp;caption_url=k315-0-video1.srt&amp;width=512&amp;height=348"
>player</a>: 512 &times; 348 pixels (318+30, for planned deeper control-bar).</small>
</p>

<p class="audio">
<iframe tabindex="0" title="Audio player: Music" width="400" height="60" frameborder="0"<?php /*scrolling="no"*/ ?> style="overflow:hidden;" src=
"<?=$embed_url;
?>?title=Music+&copy;Rehab&amp;media_url=http%3A//learn.open.ac.uk/file.php/5195/!via/oucontent/course/137628/20070330_rehab-after.mp3&amp;width=400&amp;height=60"
></iframe>
<small>Audio player: 400 × 60 pixels (fixed size without image_url).</small>
</p>


<!--
Examples in current VLE:
http://learn.open.ac.uk/mod/oucontent/view.php?id=426478&section=2.5.4 - 2 FLV videos, one showing access features.
http://learn.open.ac.uk/mod/oucontent/view.php?id=426478&section=2.5.3 - audio
http://learn.open.ac.uk/mod/oucontent/view.php?id=316907&section=4.2 - mp4 video
If you get access error, first visit http://learn.open.ac.uk/site/sc 
-->
<p>&copy;2011 The Open University.</p>
</html>