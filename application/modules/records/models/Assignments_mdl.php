<?php 


class Assignments_mdl extends CI_Model
{
            public function __construct()
        {
            parent::__construct();
            $this->load->database();
        }
    public function assign_diseases($member_state_id, $disease_ids)
    {
        foreach ($disease_ids as $id) {
            $this->db->insert('member_state_diseases', [
                'member_state_id' => $member_state_id,
                'disease_id' => $id
            ]);
        }
        return true;
    }

    public function unassign_diseases($member_state_id, $disease_ids)
    {
        $this->db->where('member_state_id', $member_state_id);
        $this->db->where_in('disease_id', $disease_ids);
        return $this->db->delete('member_state_diseases');
    }

    public function get_assigned_diseases($member_state_id)
    {
        $this->db->select('d.id, d.name, ta.id as thematic_area_id, ta.name as thematic_area');
        $this->db->from('member_state_diseases md');
        $this->db->join('diseases_and_conditions d', 'd.id = md.disease_id');
        $this->db->join('disease_thematic_areas ta', 'ta.id = d.thematic_area_id', 'left');
        $this->db->where('md.member_state_id', $member_state_id);
        $this->db->order_by('ta.name', 'ASC');
        $this->db->order_by('d.name', 'ASC');

        return $this->db->get()->result();
    }

    public function save_all_changes($changes)
    {
        foreach ($changes as $row) {
            $this->db->insert('member_state_diseases', [
                'member_state_id' => $row['member_state_id'],
                'disease_id' => $row['disease_id']
            ]);
        }
        return true;
    }
}
