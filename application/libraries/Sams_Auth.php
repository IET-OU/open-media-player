<?php
/**
* OU SAMS authentication.
*
* @author N.D.Freear, 27 July 2012.
*/

abstract class Privacy_Auth {

  abstract public function authenticate();


  /**
  * Determine if the caller is a private site/ client.
  *
  * Note, it is the responsibility of the caller to set a HTTP GET parameter.
  * Otherwise the caller is assumed to be public, with restricted-access warning being set as appropriate.
  */
  public function is_private_caller() {
    return ('private' == $this->CI->input->get('site_access'));
  }
}


class Sams_Auth extends Privacy_Auth {

  public function __construct() {
    $this->CI =& get_instance();
  }

  /**
  * Basic OU-SAMS session cookie check and redirect - used for VLE demo/test pages.
  *
  SAMSsession=20460a8663e3b7593a9a9dbd97b57b2a501337e2ndf42
  2=9000b6ae61b04e91855c2f7353e146aa501337e2ndf42
  */
  public function authenticate() {
    // Security: note the 'localhost' check.
    if (#'localhost' != $this->CI->input->server('HTTP_HOST') &&
        !$this->CI->input->cookie('SAMSsession')
	  || !$this->CI->input->cookie('SAMS2session')) {
      redirect($this->login_link(current_url()));
    }
  }

  public function login_link($url) {
    #?? https://msds.open.ac.uk/signon/SAMSDefault/SAMS001_Default.aspx?URL=

	return 'https://msds.open.ac.uk/signon/?URL=' . $url;
  }

}
