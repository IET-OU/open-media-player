<?php
/** Render language pack as a (M)HTML table for easy opening in MS Word.
*/
?>
<!DOCTYPE html><html><head>
<meta http-equiv=Content-Type content="text/html; charset=utf-8">
<meta name=ProgId content=Word.Document>
<meta name=Generator content="Microsoft Word 2008">
<meta name=Originator content="Microsoft Word 2008">
<?php /*<link rel=File-List href="ouplayer-lang_files/filelist.xml">*/ ?>
<title>OU player/OU embed language file: HTML for MS Word</title>
<style>
<!--
 /* Font Definitions */
@font-face
	{font-family:Cambria;
	panose-1:2 4 5 3 5 4 6 3 2 4;}
@font-face
	{font-family:"ヒラギノ明朝 ProN W3";
	panose-1:0 0 0 0 0 0 0 0 0 0;}
@font-face
	{font-family:"Heiti TC Light";
	panose-1:2 0 0 0 0 0 0 0 0 0;}
 /* Style Definitions */
body{margin:1.7cm; font:12pt Arial,sans-serif;}
table{border-color:#ddd; margin:12pt 0;}
p, li{margin:6pt 0;}
td{width:25%; padding:3pt;}
th tt{font-size:small; font-weight:normal;}
p.-MsoNormal, li.MsoNormal, div.MsoNormal
	{margin:0cm;
	margin-bottom:.0001pt;
	font-size:12.0pt;
	font-family:"Times New Roman";
	mso-ascii-font-family:Cambria;
	mso-fareast-font-family:Cambria;
	mso-hansi-font-family:Cambria;
	mso-bidi-font-family:"Times New Roman";}
<?php /*
pre
	{margin:0cm;
	margin-bottom:.0001pt;
	font-size:10.0pt;
	font-family:Courier;
	mso-fareast-font-family:Cambria;
	mso-bidi-font-family:Courier;}
span.HTMLPreformattedChar
	{mso-ansi-font-size:10.0pt;
	mso-bidi-font-size:10.0pt;
	font-family:Courier;
	mso-ascii-font-family:Courier;
	mso-hansi-font-family:Courier;
	mso-bidi-font-family:Courier;}
@page Section1
	{size:595.0pt 842.0pt;
	margin:72.0pt 90.0pt 72.0pt 90.0pt;
	mso-paper-source:0;}
div.Section1
	{page:Section1;}
-->
</style>
<style>
 /* Style Definitions *--/
table.MsoNormalTable
	{mso-para-margin:0cm;
	mso-para-margin-bottom:.0001pt;
	font-size:10.0pt;
	font-family:"Times New Roman";
	mso-ascii-font-family:Cambria;
	mso-hansi-font-family:Cambria;}
*/ ?>
-->
</style>
</head>

<body lang=EN-US style='tab-interval:36.0pt'>

<div class=Section1>

<h1>OU Player language file</h1>

<ul id="hints">
  <li>You probably want to save me with a <tt>.mhtml</tt> or <tt>.html</tt> file extension.</li>
  <li>Then you can open me in Microsoft Word and save me as a Word document 
    &mdash; Save As: <tt>Word 97-2004 (.doc)</tt> please.</li>
  <li>Placeholders are denoted <tt>%s</tt> and <tt>&lt;s></tt> &mdash; do not translate me!</li>
  <li>Example player: <a href="http://embed.open.ac.uk/embed/pod/student-experiences/db6cc60d6b?lang=<?= $lang ?>"
  >embed.open.ac.uk/embed/pod/student-experiences/db6cc60d6b</a></li>
  <li>Example language file: <a href="http://dl.dropbox.com/u/3203144/ouplayer/ouplayer-lang.word.html">ouplayer-lang.word.html</a>
  <li>Help! Email or MS Lync me: <a href="mailto:N.D.Freear@open.ac.uk">N.D.Freear</a>.</li>
</ul>
<p >Language: <tt id=langCode><?= $lang ?></tt> (<a href=
"http://en.wikipedia.org/wiki/List_of_ISO_639-1_codes">List of ISO 639-1 codes</a>).</p>

<?php /*
<p class=MsoNormal style='tab-stops:45.8pt 91.6pt 137.4pt 183.2pt 229.0pt 274.8pt 320.6pt 366.4pt 412.2pt 458.0pt 503.8pt 549.6pt 595.4pt 641.2pt 687.0pt 732.8pt'><span
style='font-size:10.0pt;font-family:"ヒラギノ明朝 ProN W3";mso-bidi-font-family:"ヒラギノ明朝 ProN W3"'>播放</span><span
style='font-size:10.0pt;font-family:"Heiti TC Light";mso-bidi-font-family:"Heiti TC Light"'>视频</span></p>
*/ ?>

<table id="strings" border="1">
  <tr><th class=i>Original</th> <th class=s>Translation</th>
    <th class=r>References <tt>file:line-number</tt></th> <th class=c>Comments</th></tr>

<?php
  $idx=0;
  foreach ($strings as $msgid => $o):
    $idx++;
    $hid = "s-$idx";
    $sid = htmlspecialchars($msgid);
    $str = htmlspecialchars($o['msgstr']);
    $ref = $o['references'][0];
    $com = isset($o['extracted-comments']) ? $o['extracted-comments'] :'';
?>
  <tr id=<?=$hid ?>><td class=i><?=$sid ?></td><td class=s><?=$str ?></td>
    <td class=r><?=$ref ?></td><td class=c><?=$com ?></td></tr>
<?php endforeach; ?>
</table>

<p class=MsoNormal>[End.]</p>

</div>

</body>

</html>
