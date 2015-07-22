#!/usr/bin/env php
<?php
/** Commandline script. Run xgettext to extract translatable strings from directories (defined below).
 *  Create PO(T) translation template files.
 *
 * <code>
 *   $ php application/cli/xgettext.php
 * </code>
 *
 * @link http://gnu.org/software/gettext GNU Gettext
 * @copyright 2009, 2010 The Open University. See CREDITS.txt
 */
/*
http://translate.google.com/#en|fr|Player+controls.+Play.+Pause.+Rewind.+Fast+forward.+Current+time.+Loading.+Loaded.+Seek+bar.+Total+time.+Mute.+Un-mute.+Volume.+Quieter.+Louder.+New+window.+Captions.
*/
if ('cli'!=php_sapi_name()) {
    die(basename(__FILE__).": Must run as cli."); #Security.
}
$xgettext = array(
    'mac' => "/Applications/Poedit.app/Contents/MacOS/xgettext",
    'win' => "C:/apps/GnuWin32/bin/xgettext.exe",
    'win' => "C:/Program Files/Poedit/bin/xgettext.exe",
);
$OS = null;
foreach ($xgettext as $label => $path) {
    if (file_exists($path)) {
        echo "OK, $label it is!".PHP_EOL;
        $OS      = $label;
        $xgettext= win_dir($path);
        break;
    }
}
$files_from = win_dir(str_replace('.php', '', __FILE__).".txt", $quote = false);
$sys_dir = dirname(dirname(dirname(__FILE__)));
$out_dir = win_dir("$sys_dir/application/language/"); #_templates_/");

var_dump($files_from, $sys_dir, $out_dir);


$domains = array('application/');

foreach ($domains as $path) {
    $domain = basename($path);
    $directory = win_dir("$sys_dir/$path");

    $exclude = ".|..|.svn|.po|.DS_Store|cli|about|config|Zend|phpmailer|index.html|- Copy.";
    $files = file_array($directory, $directory, $exclude);
    $bytes = file_put_contents($files_from, $files); #implode(PHP_EOL, $files));

  /*@todo --keyword=plural' doesn't work :( --keyword=t:1, plural:1,2  --flag=plural:1:pass-c-format */
    $command = <<<EOF
"$xgettext"
 --default-domain=$domain
 --directory=$directory
 --files-from=$files_from
 --output-dir=$out_dir

 --keyword=t

 --language=PHP
 --from-code=utf-8
 --width=86
 --add-comments=/
 --sort-by-file
 --force-po
 --debug
EOF;

    if ('win' != $OS) {
      # The Windows builds don't have these options :(
        $command .= <<<EOF
 --copyright-holder="2011 The Open University. All rights reserved."
 --package-name=ouplayer-$domain
 --package-version="1.0"
 --msgid-bugs-address="N.D.Freear@open.ac.uk"
EOF;
    }

    $command = str_replace(array("\r","\n"), '', $command);

  # A return of '0' is good.
    $st = system($command, $return);
    $count = count(explode(PHP_EOL, $files));
    echo "Domain: $domain | Files parsed: $count | Status: $return".PHP_EOL;
}
# Security: truncate file.
#$r = file_put_contents($files_from, '');


function win_dir($input, $quotes = true)
{
    global $OS;
    if ('win'==$OS) {
        $quotes = /*($quotes) ? '"' :*/ '';
        return ltrim(str_replace(array('Documents and Settings', "/"), array('DOCUME~1', "\\"), $input), "\\");
    }
    return $input;
}

// Open a known directory, and proceed to read its contents
function file_array($path, $rel, $exclude = ".|..|.svn|.DS_Store", $recursive = true)
{
    $path = rtrim($path, "/") . "/";
    $folder_handle = opendir($path);
    $exclude_array = explode("|", strtolower($exclude));
    $result = ''; #array();
    while (false !== ($filename = readdir($folder_handle))) {
        if (!in_array(strtolower($filename), $exclude_array)) {
            if (is_dir($path . $filename . "/")) {
                    // Need to include full "path" or it's an infinite loop
                if ($recursive) {
                    $result .= file_array($path . $filename . "/", $rel, $exclude, true); #[].
                }
            } else {
                $result .= win_dir(str_replace($rel, '', $path).$filename.PHP_EOL);  #[], $path.
            }
        }
    }
    closedir($folder_handle);
    return $result;
}

#End.
