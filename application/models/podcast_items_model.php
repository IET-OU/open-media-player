<?php
/** A model to get item meta-data from the podcast DB.
 *
 * @copyright Copyright 2011 The Open University.
 */
//2 March 2011.

class Podcast_items_model extends CI_Model {

    protected $db_pod;

    public function __construct() {
        parent::__construct();

        $this->db_pod = $this->load->database('podcast', TRUE);
    }

    public function get_item($basename, $shortcode=NULL, $captions=FALSE) {

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
        // This doesn't work!
        $where_podcast_items = 'podcast_items.shortcode';
        if (FALSE !== strpos($shortcode, '.')) {
            $where_podcast_items = 'podcast_items.filename';
        }
        $sql_cc =<<<SQL
  SELECT
  podcasts.title AS pod_title,podcasts.summary AS pod_summary,podcasts.*,podcast_items.*,pim.media_type AS pim_type,pim.filename AS pim_filename
	FROM podcast_items
	JOIN podcasts ON podcasts.id=podcast_items.podcast_id
	LEFT JOIN podcast_item_media AS pim ON pim.podcast_item=podcast_items.id
  WHERE(
	pim.media_type='cc-dfxp'  -- IS NOT NULL
	AND podcasts.custom_id = '$basename'
	AND $where_podcast_items='$shortcode' )
  OR( podcasts.custom_id = '$basename'
	AND $where_podcast_items='$shortcode' )
SQL;

        // This works!
        $select = 'podcasts.title AS pod_title, podcasts.summary AS pod_summary, podcasts.*,podcast_items.*';
        if ($captions) {
            $select .= ', podcast_item_media.filename AS pim_filename, podcast_item_media.media_type AS pim_type';
        }
        $this->db_pod->select($select);
        $this->db_pod->join('podcasts', 'podcasts.id=podcast_items.podcast_id');
        if ($captions) {
            // Important: a LEFT JOIN.
            $this->db_pod->join('podcast_item_media', 'podcast_item_media.podcast_item=podcast_items.id', 'left');
            $this->db_pod->order_by('pim_type', 'desc');
        }
        $this->db_pod->where('podcasts.custom_id', $basename);      #'l314-spanish');
        if (FALSE !== strpos($shortcode, '.')) { #(FALSE !== strpos($basename, '.m') && !$shortcode) {
            $this->db_pod->where('podcast_items.filename', $shortcode);  #'l314audio1.mp3');
        } else {
            $this->db_pod->where('podcast_items.shortcode', $shortcode);#'fe481a4d1d');
        }
        $query = $this->db_pod->get('podcast_items'); #AS pi');

        //$query = $this->db_pod->query($sql_cc);

        #$this->firephp->fb($this->db_pod->last_query(), 'Podcast model', 'LOG');

        $result = $query->result();

        # Captions - multiple results! - Post-process
        if ($result && $captions) {
            foreach ($result as $res) {
                if ('cc-dfxp'==$res->pim_type) {
                    return $res;
                }
            }
        }
        if ($result) {
          return $result[0];
        }
        return FALSE;
    }

    public function count() {
        $this->db_pod->from('podcast_items');
	    return $this->db_pod->count_all_results();
    }

}
