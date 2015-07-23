<?php defined('BASEPATH') or exit('No direct script access allowed');

class Layout
{

    protected $obj;
    protected $layout;

    public function Layout($layout = "layout_main")
    {
#ou-specific bug fix
        if (is_array($layout)) {
            $layout = isset($layout['layout']) ? $layout['layout'] : $layout[0];
        }
#ou-specific ends.
        $this->obj =& get_instance();
        $this->layout = $layout;
    }

    public function setLayout($layout)
    {
        $this->layout = $layout;
    }

    public function view($view, $data = null, $return = false)
    {
        $loadedData = array();
#ou-specific
        if (!isset($data[ 'page_title' ])) {
            $loadedData[ 'page_title' ] = $this->obj->_page_title();
        }
#ou-specific ends.
        $loadedData['content_for_layout'] = $this->obj->load->view($view, $data, true);

        if ($return) {
            $output = $this->obj->load->view($this->layout, $loadedData, true);
            return $output;
        } else {
            $this->obj->load->view($this->layout, $loadedData, false);
        }
    }
}
