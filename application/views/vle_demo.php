<?php
    $embed_url = site_url('embed/vle');
?>
<!DOCTYPE html><html lang="en"><meta charset="utf-8" /><title>OUVLE player demo</title>
<style>body{font:1em sans-serif;} iframe{display:block; border:1px solid #bbb; border-radius:4px;}</style>

<p><a href="http://learn.open.ac.uk/site/sc">Visit 'Learn' first, to prevent access errors</a></p>

<!-- Note you seemingly have to add 5px to the iframe height! -->
<p class="video">
<iframe tabindex="0" title="Player: Intro" width="512" height="323" frameborder="0" src=
"<?=$embed_url;
?>?title=Introduction+to+Fairmead&amp;media_url=http%3A//learn.open.ac.uk/file.php/5195/!via/oucontent/course/100705/k315-0-video1.mp4&caption_url=k315-0-video1.srt&width=512&height=318"
></iframe></p>

<p class="audio">
<iframe tabindex="0" title="Player: Music" width="400" height="65" frameborder="0" src=
"<?=$embed_url;
?>?title=Music+&copy;Rehab&amp;media_url=http%3A//learn.open.ac.uk/file.php/5195/!via/oucontent/course/137628/20070330_rehab-after.mp3&amp;width=400&amp;height=60"
></iframe></p><!--Was:60 / 65px-->


<!--
Examples in current VLE:
http://learn.open.ac.uk/mod/oucontent/view.php?id=426478&section=2.5.4 - 2 FLV videos, one showing access features.
http://learn.open.ac.uk/mod/oucontent/view.php?id=426478&section=2.5.3 - audio
http://learn.open.ac.uk/mod/oucontent/view.php?id=316907&section=4.2 - mp4 video
If you get access error, first visit http://learn.open.ac.uk/site/sc 
-->
<p>&copy;2011 The Open University.</p>
</html>