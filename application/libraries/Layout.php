<?php  
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Layout
{
    
    var $obj;
    var $layout;

    public function __construct($layout = 'layout_main')
    // Was: function Layout($layout = "layout_main")
    {
#ou-specific bug fix
        if (is_array($layout)) {
            $layout = isset($layout['layout']) ? $layout['layout'] : $layout[0];
        }
#ou-specific ends.
        $this->obj =& get_instance();
        $this->layout = $layout;
    }

    function setLayout($layout)
    {
      $this->layout = $layout;
    }
    
    function view($view, $data=null, $return=false)
    {
        $loadedData = array();
        $loadedData['content_for_layout'] = $this->obj->load->view($view,$data,true);
        
        if($return)
        {
            $output = $this->obj->load->view($this->layout, $loadedData, true);
            return $output;
        }
        else
        {
            $this->obj->load->view($this->layout, $loadedData, false);
        }
    }
}
?>
