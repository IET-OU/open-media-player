<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Gitlib: a simple Git library, to get changeset hashes and information.
 *
 * See: https://bitbucket.org/cloudengine/cloudengine/src/tip/system/application/libraries/Hglib.php
 *
 * @copyright 2012 The Open University.
 * @author N.D.Freear, 2012-04-25.
 */

class Gitlib {

    protected $_hash;
    protected $CI;

    static $REVISION_FILE = 'version.json';

    public function __construct() {
        $this->CI =& get_instance();

        self::$REVISION_FILE = dirname(__FILE__) .'/../../'. self::$REVISION_FILE;
    }

    /**
     * Return the start of the most recent commit hash (from file).
     * Maybe md5/ sha() the result?
     */
    public function lastHash($length = 6) {
        if ($length < 4) $length = 4;

        if ($this->_hash) {
            return substr($this->_hash, 0, $length);
        }

        $log = $this->get_revision();
        $this->_hash = $log->commit;

        return substr($this->_hash, 0, $length);
    }

    /** Save revision meta-data to a '.' file, JSON-encoded.
     *  (CloudEngine's Hglib uses PHP (un)serialize.)
     */
    public function put_revision() {
        $log = $this->_exec('log -1');

        $log = explode("\n", $log);
        $result = FALSE;
        //Hmm, a more efficient way?
        foreach ($log as $line) {
            if (FALSE !== ($p = strpos($line, ' '))) { #':'
                $key = trim(substr($line, 0, $p), ' :');
                if (!$key) $key = 'message';
                $result[strtolower($key)] = trim(substr($line, $p+1));
                if ('message'==$key) break;
            }
        }
        // Describe "v0.86-usertest-95-g.."
        // Semantic Versioning, http://semver.org
        $result['describe'] = trim($this->_exec('describe --tags --long'));
        $result['version'] = preg_replace('/(\d)-(\w+\.?\d?)-(\d+)-g/', '\1.\3-\2+g', $result['describe']);
        // http://stackoverflow.com/questions/4089430/how-can-i-determine-the-url-that-a-local-git-repo-was-originally-pulled-from
        $result['origin'] = rtrim($this->_exec('config --get remote.origin.url'), "\r\n");
        #$result['origin url'] = str_replace(array('git@', 'com:'), array('https://', 'com/'), $result['origin']);
        #$result['agent'] = basename(__FILE__);
        #$result['git'] = rtrim($this->_exec('--version'), "\r\n ");

        $bytes = file_put_contents(self::$REVISION_FILE, json_encode($result));

        echo "File written, $bytes: ", self::$REVISION_FILE;

        return $result;
    }

    /** Read revision meta-data from the '.' file.
    */
    public function get_revision() {
        return (object) json_decode(file_get_contents(self::$REVISION_FILE));
    }


    /** Execute a Git command, if allowed.
    */
    protected function _exec($cmd) {

        if (! $this->CI->input->is_cli_request()) {
          echo "Warning, Git must be run from the commandline.".PHP_EOL;
          return FALSE;
        }

        //Security?
        $git_path = $this->CI->config->item('git_path');


        if (! $git_path) {
          $git_path = "git";  #"/usr/bin/env git";
          #$git_path = "/usr/bin/git";  #Redhat6
          #$git_path = "/usr/local/git/bin/git"; #Mac
        }

        $git_cmd = "$git_path $cmd";

        $result = FALSE;
        // The path may contain 'sudo ../git'.
        if (! file_exists($git_path)) {
          echo "Warning, not found, $git_path".PHP_EOL;
        }


        #if (file_exists($git_path)) {
            $cwd = getcwd();
            if ($cwd) {
                chdir(APPPATH);
            }

            $handle = popen(escapeshellcmd($git_cmd), 'r'); //2>&1
            $result = fread($handle, 2096);
            pclose($handle);

            if ($cwd) {
                chdir($cwd);
            }
        #}
        return $result;
    }

}
