<?php defined('BASEPATH') or exit('No direct script access allowed');
/**
 * Exception and error handling - adds FirePHP.
 *
 * @copyright Copyright 2011 The Open University.
 */

class MY_Exceptions extends CI_Exceptions
{

    /** Exception Logger
   *
   * @access    private
   * @param    string    the error severity
   */
    public function log_exception($severity, $message, $filepath, $line, $label = 'Error')
    {
        $severity = ( ! isset($this->levels[$severity])) ? $severity : $this->levels[$severity];

        if ($filepath) {
         // Security - works on Linux anyway ('/').
            $my_filepath = str_replace(BASEPATH, '-', $filepath);
        }
        $ex = array('severity'=>$severity, 'message'=>$message, 'filepath'=>$my_filepath, 'line'=>$line);
        $label = ($filepath) ? 'PHP error' : $label;
        $CI =& get_instance();
        if ($CI->firephp) {
            $CI->firephp->fb($ex, $label, 'ERROR');
        }

        return parent::log_exception($severity, $message, $filepath, $line);
    }

    protected function __show_404($page = '', $log_error = true)
    {
        parent::show_404($page, true);
    }

    protected function __show_php_error($severity, $message, $filepath, $line)
    {
      #$this->log_exception($severity, $message, $filepath, $line, 'PHP error');
    
        return parent::show_php_error($severity, $message, $filepath, $line);
    }


    /** General Error Page
   *
   * @access    private
   * @return    string
   */
    public function show_error($heading, $message, $template = 'error_general', $status_code = 500)
    {
        $template = '../views/errors/error_general';  #Not: app../errors/'error_general'
        $message  = "$message <small>$status_code</small>";
        return parent::show_error($heading, $message, $template, (integer) $status_code);
    }
}
