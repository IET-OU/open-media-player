<?php
/**
 * OU Player Light 2012 theme.
 *
 * This theme extends the OU Player base theme and adds the visuals, colours and so on.
 *
 * @copyright Copyright 2012 The Open University.
 * @author Peter Devine/LTS 2012-03-08 (visuals, CSS)
 * @author Nick Freear 2012-03-30 (CSS, PHP)
 */
require_once dirname(__FILE__) .'/../ouplayer_base/theme.php';


class Oup_Light_Theme extends Ouplayer_Base_Theme {

  public $display = 'OU Player light (2012)';
  public $rgb  = 'ouvle-default-blue';

  public function __construct() {
    parent::__construct();

    // Add the light theme top-level styles to the array.
    $this->styles[] = "themes/$this->name/css/oup-light.css";

    $this->css_min = "themes/$this->name/build/oup-light-ouplayer-mediaelement.css";


	// Feature: currently we don't support 'High-definition'.
	$this->features = str_replace(',oup_quality', '', $this->features);

	// Experimental feature: add in tooltips on keyboard focus.
	$this->features .= ',oup_tooltip';
  }
}
