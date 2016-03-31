<?php
/**
* OU player Javascript/ CSS builder.
* Used by make to produce the version.json file in the site root. The
* version.json file is used to identify the version of the code deployed
* on servers managed by IT.
* Usage: $ \xampp\php\php index.php build/revision
*
* @copyright 2012 The Open University.
* @author N.D.Freear, 17 April 2012, -04-25.
*/

class Build extends MY_Controller {
  /** Build a 'revision' file (CLI).
  */
  public function revision() {
    if ($this->input->is_cli_request()) {
      $this->load->library('Gitlib', null, 'git');
      $result = $this->git->put_revision();
	  } else {
	      $this->_error('The page you requested was not found.', 404);
	  }
  }
}
