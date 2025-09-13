<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Records_model extends CI_Model
{

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	public function get_all_parameters()
	{
		return $this->db->get('parameters')->result_array();
	}

	public function get_diseases_from_prioritisation($member_state_id, $prioritisation_category_id, $thematic_area_id = null)
	{
		$this->db->select('d.id, d.name, ta.name as thematic_area')
				 ->from('member_state_diseases_data msdd')
				 ->join('diseases_and_conditions d', 'd.id = msdd.disease_id')
				 ->join('disease_thematic_areas ta', 'ta.id = d.thematic_area_id')
				 ->where('msdd.member_state_id', $member_state_id)
				 ->where('msdd.prioritisation_category', $prioritisation_category_id);

		if (!empty($thematic_area_id)) {
			$this->db->where('d.thematic_area_id', $thematic_area_id);
		}

		$this->db->group_by('msdd.disease_id');
		return $this->db->get()->result_array();
	}

	public function get_existing_data($region_id,$member_state_id, $period, $prioritisation_category_id)
	{
		return $this->db->get_where('member_state_diseases_data', [
			'region_id' => $region_id, 
			'member_state_id' => $member_state_id,
			'period' => $period,
			'prioritisation_category' => $prioritisation_category_id
		])->result_array();
	}

	public function save_all_ranking_data($changes)
	{
		if (empty($changes)) return false;

		foreach ($changes as $change) {
			$this->save_ranking_data(
				$change['member_state_id'],
				$change['period'],
				$change['disease_id'],
				$change['param'],
				$change['creteria'],
				$change['prioritisation_category_id'],
			    $change['draft_status']

			);
		}
		return true;
	}

	public function save_ranking_data($member_state_id, $period, $disease_id, $param, $creteria, $prioritisation_category_id, $draft_status)
{
    $valid_params = ['prev', 'detect', 'morbid', 'case', 'mort'];
    if (!in_array($param, $valid_params)) return false;

    $existing = $this->get_member_state_disease_data($member_state_id, $period, $disease_id, $prioritisation_category_id);

    $data = [
        'period' => $period,
        'member_state_id' => $member_state_id,
		'region_id' => $this->lists_mdl->get_region_by_memberstates($member_state_id),
        'disease_id' => $disease_id,
        'prioritisation_category' => $prioritisation_category_id,
        $param => $creteria,
        'draft_status' => $draft_status
    ];

    if ($existing) {
        $this->db->update('member_state_diseases_data', $data, ['id' => $existing['id']]);
    } else {
        $this->db->insert('member_state_diseases_data', $data);
    }
    correct_composite_index_async();
    return true;
}




	public function get_member_state_disease_data($member_state_id, $period, $disease_id, $prioritisation_category_id)
	{
		return $this->db->get_where('member_state_diseases_data', [
			'member_state_id' => $member_state_id,
			'period' => $period,
			'disease_id' => $disease_id,
			'prioritisation_category' => $prioritisation_category_id
		])->row_array();
	}
	public function get_assigned_diseases_with_area($region_id,$member_state_id, $thematic_area_id = null)
	{
		$this->db->select('d.id, d.name, ta.name as thematic_area')
				 ->from('member_state_diseases msd')
				 ->join('diseases_and_conditions d', 'd.id = msd.disease_id')
				 ->join('disease_thematic_areas ta', 'ta.id = d.thematic_area_id')
				 ->join('member_states ms', 'ms.id = msd.member_state_id')
				 ->where('msd.member_state_id', $member_state_id)
				 ->where('ms.region_id', $region_id);
		if (!empty($thematic_area_id)) {
			$this->db->where('d.thematic_area_id', $thematic_area_id);
		}

		return $this->db->get()->result_array();
	}
	public function get_priority_disease_counts_by_thematic_area($region_id,$member_state_id, $period = null, $thematic_area_id = null, $prioritisation_category_id = null)
	{
		$this->db->select('dta.name as thematic_area, COUNT(DISTINCT msd.disease_id) as total')
				 ->from('member_state_diseases_data msd')
				 ->join('diseases_and_conditions d', 'd.id = msd.disease_id')
				 ->join('disease_thematic_areas dta', 'd.thematic_area_id = dta.id')
				//  ->where('msd.member_state_id', $member_state_id)
				//  ->where('msd.region_id', $region_id)
				 ->where('msd.draft_status', 0); // Only finalized
	
		// Optional filters
		if (!empty($member_state_id)) {
			$this->db->where('msd.member_state_id', $member_state_id);
		}
		if (!empty($region_id)) {
			$this->db->where('msd.region_id', $region_id);
		}
		if (!empty($period)) {
			$this->db->where('msd.period', $period);
		}
	
		if (!empty($thematic_area_id)) {
			$this->db->where('d.thematic_area_id', $thematic_area_id);
		}
	
		if (!empty($prioritisation_category_id)) {
			$this->db->where('msd.prioritisation_category', $prioritisation_category_id);
		}
	
		$this->db->group_by('dta.name');
	
		return $this->db->get()->result_array();
	
		// For debugging: 
		// echo $this->db->last_query(); exit;
	}
	public function get_disease_probabilities($region_id,$member_state_id, $period, $thematic_area_id, $prioritisation_category_id)
{
    $this->db->select('d.name as disease_name, msd.probability');
    $this->db->from('member_state_diseases_data msd');
    $this->db->join('diseases_and_conditions d', 'd.id = msd.disease_id');
    
	if (!empty($member_state_id)) {
        $this->db->where('msd.member_state_id', $member_state_id);
    }
    if (!empty($region_id)) {
        $this->db->where('msd.region_id', $region_id);
    }

    if (!empty($period)) {
        $this->db->where('msd.period', $period);
    }

    if (!empty($prioritisation_category_id)) {
        $this->db->where('msd.prioritisation_category', $prioritisation_category_id);
    }

    if (!empty($thematic_area_id)) {
        $this->db->where('d.thematic_area_id', $thematic_area_id);
    }

    $this->db->where('msd.draft_status', 0); // Only finalized data

    $this->db->order_by('msd.probability', 'DESC');

    return $this->db->get()->result_array();
}

public function get_priority_disease_counts_by_thematic_area_cont($member_state_id = null)
{
    $this->db->select('dta.name as thematic_area, COUNT(DISTINCT msd.disease_id) as total')
             ->from('member_state_diseases_data msd')
             ->join('diseases_and_conditions d', 'd.id = msd.disease_id')
             ->join('disease_thematic_areas dta', 'd.thematic_area_id = dta.id');

    if (!empty($member_state_id)) {
        $this->db->where('msd.member_state_id', $member_state_id);
    }

    $this->db->where('msd.draft_status', 0);
    $this->db->group_by('dta.name');

    return $this->db->get()->result_array();
}

public function get_disease_probability_value($region_id,$member_state_id, $period, $thematic_area_id, $prioritisation_category_id, $disease_id)
{
    $this->db->select('probability');
    $this->db->from('member_state_diseases_data');
    $this->db->join('diseases_and_conditions d', 'd.id = member_state_diseases_data.disease_id');

    if ($region_id) {
        $this->db->where('region_id', $region_id);
    }

	if ($member_state_id) {
        $this->db->where('member_state_id', $member_state_id);
    }

    if ($period) {
        $this->db->where('period', $period);
    }

    if ($prioritisation_category_id) {
        $this->db->where('prioritisation_category', $prioritisation_category_id);
    }

    if ($thematic_area_id) {
        $this->db->where('d.thematic_area_id', $thematic_area_id);
    }

    if ($disease_id) {
        $this->db->where('disease_id', $disease_id);
    }

    $this->db->where('draft_status', 0);
    $this->db->limit(1);
    $query = $this->db->get();

    $row = $query->row();
    return $row ? (float)$row->probability : 0;
}
}