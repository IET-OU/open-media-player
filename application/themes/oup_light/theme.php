<?php
/**
 * OU Player Light 2012 theme.
 *
 * @copyright Copyright 2012 The Open University.
 * @author N.D.Freear, 20 March 2012.
 */
require_once dirname(__FILE__) .'/../ouplayer_base/theme.php';


class Oup_Light_Theme extends Ouplayer_Base_Theme {

  public $display = 'OU Player light (2012)';
  public $rgb  = 'ouvle-default-blue';

  public function __construct() {
    parent::__construct();

    // Add the light theme top-level styles to the array.
    $this->styles[] = "themes/$this->name/css/oup-light.css";
  }
}
