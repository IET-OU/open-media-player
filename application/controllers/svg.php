<?php
/**

Examples:
* http://compendiumld.open.ac.uk/documentation/examples/SVG/simple/mapactivity1.svg
* http://lamscommunity.org/seqs/svg/1007900.svg
* http://www.openclipart.org/people/gnokii/Apple2.svg
* http://upload.wikimedia.org/wikipedia/commons/f/fd/China_Beijing.svg
*
*/

class Svg extends \IET_OU\Open_Media_Player\MY_Controller
{

    protected $_whitelist;

    public function __construct()
    {
        parent::__construct();

        $this->_whitelist = array(
        'compendiumld.open.ac.uk', '*.open.ac.uk', 'openclipart.org', 'upload.wikimedia.org', 'www.basher-sounds.co.uk',
        );
    }

    public function r()
    {
        var_dump(func_num_args(), func_get_args(), $this->uri->uri_string(), $this->uri->total_segments());
        exit;
    }
}
