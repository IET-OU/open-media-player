<?php
//2 March 2011.

class Podcast_items_model extends CI_Model {

    protected $db_pod;

    public function __construct() {
        parent::__construct();

        $this->db_pod = $this->load->database('podcast', TRUE);
    }

    public function get_item($basename, $shortcode=NULL, $transcript=FALSE) {
    /* SELECT * FROM podcast_items
      JOIN podcasts ON podcasts.id=podcast_items.podcast_id
      WHERE podcasts.custom_id = 'vc-message-to-staff'
      AND podcast_items.shortcode='746ee92293'
    */
        $sql =<<<SQL
    SELECT p.title AS pod_title, p.*, pi.*, pim.media_type,pim.filename AS pim_filename FROM podcast_items AS pi
      JOIN podcasts AS p ON p.id=pi.podcast_id
      JOIN podcast_item_media AS pim ON pim.podcast_item=pi.id
      WHERE p.custom_id LIKE '%l314-spanish'
      AND (pi.shortcode='fe481a4d1d' OR pi.filename='l314audio1.mp3');
SQL;
        $select = 'podcasts.title AS pod_title, podcasts.summary AS pod_summary, podcasts.*,podcast_items.*';
        if ($transcript) {
            $select .= ', podcast_item_media.filename AS pim_filename';
        }
        $this->db_pod->select($select);
        $this->db_pod->join('podcasts', 'podcasts.id=podcast_items.podcast_id');
        if ($transcript) {
            $this->db_pod->join('podcast_item_media', 'podcast_item_media.podcast_item=podcast_items.id');
        }
        if (FALSE !== strpos($basename, '.m') && !$shortcode) {
            $this->db_pod->where('podcast_items.filename', $basename);  #'l314audio1.mp3');
        } else {
            $this->db_pod->where('podcasts.custom_id', $basename);      #'l314-spanish');
            $this->db_pod->where('podcast_items.shortcode', $shortcode);#'fe481a4d1d');
        }
        $query = $this->db_pod->get('podcast_items'); #AS pi');
        
        #if $transcript - multiple results! - Post-process
        
        $result = $query->result();
        return $result[0];
    }

}
