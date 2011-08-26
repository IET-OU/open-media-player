<?php
/** oEmbed renderer view.
*/
@header("Content-Type: text/plain; charset=UTF-8");
$oembed['version'] = "1.0";

if ('json'==$format):
  //application/json+oembed

  // I'm not sure that PHP json_decode likes newlines(?)
  if (isset($oembed['html'])) {
      $oembed['html'] = str_replace(array('  ', "\r", "\n"), array(' ', ''), $oembed['html']);
  }

  $json = json_encode($oembed);
  $json = str_replace('"dc:', '"dc$', $json); //XML namespaces - check Gdata.
  $json = str_replace(',"',  ','.PHP_EOL.'"', $json);
  //Pretty-print?
  if ($callback) {
    $json = "$callback($json)";
  }
  echo $json;
else:
  @header("Content-Type: application/xml; charset=UTF-8");
  echo '<?xml version="1.0" encoding="UTF-8"?>';
//xmlns="http://oembed.com"
?>
<oembed xmlns:dc="http://purl.org/dc/elements/1.1/" xml:lang="en">
<?php foreach ($oembed as $key => $value): ?>
  <<?="$key>".htmlspecialchars($value)."</$key" ?>>
<?php endforeach; ?>
</oembed>
<?php
endif;