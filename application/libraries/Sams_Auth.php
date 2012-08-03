<?php
/**
* OU SAMS authentication.
*
* @copyright 2012 The Open University.
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
  */
  public function authenticate() {
    // Security: note the 'localhost' check.
    if (#'localhost' != $this->CI->input->server('HTTP_HOST') &&
        !$this->CI->input->cookie('SAMSsession')
	  || !$this->CI->input->cookie('SAMS2session')) {
      redirect($this->login_link(current_url()));
    }
  }

  public static function login_link($url) {
    //( Redirect to:  https://msds.open.ac.uk/signon/SAMSDefault/SAMS001_Default.aspx?URL= )

	return 'https://msds.open.ac.uk/signon/?URL=' . $url;
  }


  /**
  * Determine if the authenticated user is staff, including OU tutors.
  */
  public function is_staff() {
    $sess = $this->CI->input->cookie('SAMS2session');
    return $sess && (FALSE !== strpos($sess, 'samsStaffID=') || FALSE !== strpos($sess, 'samsTutorID='));
  }
}
