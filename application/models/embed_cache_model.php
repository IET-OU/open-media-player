<?php
/** A model to cache/store embed meta-data, on the provider/server/proxy.
 *
 * @copyright Copyright 2011 The Open University.

DB schema:  Embed_cache (12)
[cache_id,cache_created,url,url_md5, provider_ns,provider_mid,
title,author,author_url,thumbnail_url,desc.,timestamp,x_meta?]
*/

class Embed_cache_model extends CI_Model {

  /*public function __construct() {
      parent::CI_Model();
  }*/

  public function get_embed($url) {
      $url_md5 = md5($url);
      $embed = false;
#var_dump($this);

      $this->db->from('embed_cache');
      $this->db->where('embed_cache.url_md5', $url_md5);
      //$this->db->join('fa_user_profile', 'fa_user_profile.id = cloud.user_id');
      $query = $this->db->get();
      if ($query->num_rows() !=  0 ) {
          $embed = $query->row();
      }
      return $embed;
  }

  public function count() {
      $this->db->from('embed_cache');
	  return $this->db->count_all_results();
  }

  public function insert_embed($embed) {
      if (isset($embed['date'])) unset($embed['date']);
      $embed['url_md5'] = md5($embed['url']);
      if (isset($embed['extended'])) {
        $extended = serialize($embed['extended']);
        $embed['extended'] = $extended;
      }
      $providers = array(
        'youtube'=>1, 'cohere'=>2, 'mathtran'=>3, 'scratch'=>4, 'prezi'=>5);
      $embed['provider_ns'] = $providers[$embed['provider_name']];
      unset($embed['provider_name']);

      $this->db->insert('embed_cache', $embed);
      $cache_id = $this->db->insert_id();
  
      return $cache_id;
  }
}
