<?php
//2 March 2011.

class Podcast_items_model extends CI_Model {

    protected $db_pod;

    public function __construct() {
        parent::__construct();

        $this->db_pod = $this->load->database('podcast', TRUE);
    }

    public function get_item() {
    /* SELECT * FROM podcast_items
      JOIN podcasts ON podcasts.id=podcast_items.podcast_id
      WHERE podcasts.custom_id = 'vc-message-to-staff'
      AND podcast_items.shortcode='746ee92293'
    */
        $sql =<<<SQL
    SELECT * FROM podcast_items AS pi
      JOIN podcasts AS p ON p.id=pi.podcast_id
      JOIN podcast_item_media AS pim ON pim.podcast_item=pi.id
      WHERE p.custom_id LIKE '%l314-spanish'
      AND (pi.shortcode='fe481a4d1d' OR pi.filename='l314audio.mp3');
SQL;
        $this->db_pod->where('filename', 'l314audio.mp3');
        $query = $this->db_pod->get('podcast_items');
        return $query->result();
    }

}
