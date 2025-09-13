<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Lists_mdl extends CI_Model {
    
    public function get_thematic_areas(){

    
        return  $this->db->get('disease_thematic_areas')->result();

    }
    public function get_thematic_areas_array(){

    
        return  $this->db->get('disease_thematic_areas')->result_array();

    }
    public function get_diseases_by_theme($ids) {
        if (!empty($ids)) {
            $this->db->where_in('thematic_area_id', $ids);
            $query = $this->db->get('diseases_and_conditions');
            return $query->result_array();
        } else {
            return [];
        }
    }
    
public function get_diseases(){

   $data=  $this->db->get('diseases_and_conditions');
   return $data->result_array();
}
public function get_memberstates(){
        $this->db->order_by('member_state','ASC');
return  $this->db->get('member_states')->result_array();
}
public function get_regions(){
        $this->db->order_by('name','ASC');
return  $this->db->get('regions')->result_array();
}


public function get_memberstates_by_region($region_id){
        $this->db->where('region_id', $region_id);
        $this->db->order_by('member_state','ASC');
return  $this->db->get('member_states')->result_array();
}
public function get_region_by_memberstates($memberstate_id){
        $this->db->where('id', $memberstate_id);
        $this->db->order_by('member_state','ASC');
return  $this->db->get('member_states')->row()->region_id;
}
public function get_prioritisation_categories(){
return  $this->db->get('priotisation_category')->result_array();

}
}
