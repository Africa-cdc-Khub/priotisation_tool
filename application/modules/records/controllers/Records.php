<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Records extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('records_model');
		$this->load->model('assignments_mdl');
		$this->load->library('pagination');
	}

	public function index()
	{
		$data['module'] = 'records';
		$data['title'] = 'Country Disease Profile';
		$data['uptitle'] = "Country";
		$data['uptitle'] = "Region";
		$data['countries'] = $this->lists_mdl->get_memberstates_by_region($this->session->userdata('region_id'));
		$data['regions'] = $this->lists_mdl->get_regions();
		$data['thematic_areas'] = $this->lists_mdl->get_thematic_areas();
	
		$data['diseases'] =$this->lists_mdl->get_diseases();
		$data['prioritisation_categories'] = $this->lists_mdl->get_prioritisation_categories();
		render_site('dashboard', $data);
	}

	public function get_countries_by_region()
{
	$region_id = $this->input->post('region_id');

	if ($region_id) {
		$countries = $this->lists_mdl->get_memberstates_by_region($region_id);
		echo json_encode(['status' => 'success', 'countries' => $countries]);
	} else {
		echo json_encode(['status' => 'error', 'message' => 'No region ID provided']);
	}
}
	public function profile()
	{
		// Pagination configuration
		$data['module'] = 'records';
		$data['title'] = 'Home';
		$data['uptitle'] = "Home";
        $data['countries'] =$this->lists_mdl->get_memberstates_by_region();
		$data['thematic_areas']=$this->lists_mdl->get_thematic_areas();
		$data['diseases'] =$this->lists_mdl->get_diseases();
		//dd($data);
		render_site('index', $data);
	}
	public function load_ranking_form()
	{
		$member_state_id = $this->input->post('member_state_id') ?? null;
		$region_id = $this->input->post('region_id');
		$period = $this->input->post('period');
		$thematic_area_id = $this->input->post('thematic_area_id');
		$prioritisation_category_id = $this->input->post('prioritisation_category_id');

		$data['diseases'] = $this->records_model->get_assigned_diseases_with_area($region_id,$member_state_id, $thematic_area_id);
		$data['parameters'] = $this->records_model->get_all_parameters();

		// Load existing data for editing
		$existing_data = $this->records_model->get_existing_data($region_id,$member_state_id, $period,$prioritisation_category_id);
		$data['existing_data'] = [];
		
		foreach ($existing_data as $row) {
			$data['existing_data'][$row['disease_id']] = $row;
		}

		$this->load->view('ranking_table', $data);
	}

	public function save_all_ranking_data()
	{
		$changes = $this->input->post('changes');

		if (empty($changes)) {
			echo json_encode(['status' => 'error', 'message' => 'No changes provided.']);
			return;
		}

		$result = $this->records_model->save_all_ranking_data($changes);

		if ($result) {
			echo json_encode(['status' => 'success', 'message' => 'All changes saved successfully!']);
		} else {
			echo json_encode(['status' => 'error', 'message' => 'Error saving data.']);
		}
	}
    public function data_correction(){
		$this->composite_mdl->correct_composite_index();
	}
	public function get_disease_chart_data()
	{
		// Get raw JSON body
		$input = json_decode(file_get_contents('php://input'), true);
		$region_id = $input['region_id'] ?? null; 
		$member_state_id = $input['member_state_id'] ?? null;
		$period = $input['period'] ?? null;
		
		$thematic_area_id = $input['thematic_area_id'] ?? null;
		$prioritisation_category_id = $input['prioritisation_category_id'] ?? null;
	
		$data = $this->records_model->get_priority_disease_counts_by_thematic_area(
			$region_id,
			$member_state_id,
			$period,
			$thematic_area_id,
			$prioritisation_category_id
		);
	
		echo json_encode($data);
	}

	public function get_disease_probability_chart_data()
{
    // Get JSON input from POST
    $filters = json_decode(file_get_contents("php://input"), true);
	$region_id = $filters['region_id'] ?? null; 
    $member_state_id = $filters['member_state_id'] ?? null;
    $period = $filters['period'] ?? null;
    $thematic_area_id = $filters['thematic_area_id'] ?? null;
    $prioritisation_category_id = $filters['prioritisation_category_id'] ?? null;

    $data = $this->records_model->get_disease_probabilities($region_id,$member_state_id, $period, $thematic_area_id, $prioritisation_category_id);

    echo json_encode($data);
}
public function get_continental_disease_chart_data()
{
    $data = $this->records_model->get_priority_disease_counts_by_thematic_area_cont(null);
    echo json_encode($data);
}

public function get_disease_probability_gauge()
{
    $input = json_decode(file_get_contents("php://input"), true);
	$region_id = $input['region_id'] ?? null; 

    $member_state_id = $input['member_state_id'] ?? null;
    $period = $input['period'] ?? null;
    $thematic_area_id = $input['thematic_area_id'] ?? null;
    $prioritisation_category_id = $input['prioritisation_category_id'] ?? null;
    $disease_id = $input['disease_id'] ?? null;

    $probability = $this->records_model->get_disease_probability_value(
		$region_id,
        $member_state_id,
        $period,
        $thematic_area_id,
        $prioritisation_category_id,
        $disease_id
    );

    echo json_encode($probability);
}

public function assign_diseases()
    {
        $member_state_id = $this->input->post('member_state_id');
        $diseases = $this->input->post('diseases');

        $status = $this->assignments_mdl->assign_diseases($member_state_id, $diseases);

        echo json_encode([
            'status' => $status,
            'message' => $status ? 'Diseases assigned successfully.' : 'Failed to assign diseases.'
        ]);
    }

    public function unassign_diseases()
    {
        $member_state_id = $this->input->post('member_state_id');
        $diseases = $this->input->post('diseases');

        $status = $this->assignments_mdl->unassign_diseases($member_state_id, $diseases);

        echo json_encode([
            'status' => $status,
            'message' => $status ? 'Diseases unassigned successfully.' : 'Failed to unassign diseases.'
        ]);
    }

    public function get_diseases_by_theme()
    {
        $ids = $this->input->post('thematic_ids');
        $diseases = $this->Disease_model->get_diseases_by_thematic_ids($ids);
        echo json_encode($diseases);
    }

    public function get_assigned_diseases()
    {
        $member_state_id = $this->input->post('member_state_id');
        $diseases = $this->assignments_mdl->get_assigned_diseases($member_state_id);
        echo json_encode($diseases);
    }

    public function save_all_changes()
    {
        $changes = $this->input->post('changes');
        $status = $this->assignments_mdl->save_all_changes($changes);

        echo json_encode([
            'status' => $status,
            'message' => $status ? 'Changes saved successfully.' : 'Failed to save changes.'
        ]);
    }

	public function get_diseases_by_country()
	{
		$role = $this->session->userdata('role');
		$session_member_state_id = $this->session->userdata('memberstate_id');
	
		// If user is not admin (role != 10), override input with session value
		if ($role != 10) {
			$id = $session_member_state_id;
		} else {
			$id = $this->input->post('member_state_id');
		}
	
		$query = "SELECT msd.disease_id, dc.name 
				  FROM member_state_diseases msd
				  JOIN diseases_and_conditions dc ON msd.disease_id = dc.id
				  WHERE msd.member_state_id = ?";
		
		$diseases = $this->db->query($query, [$id])->result();
	
		echo json_encode($diseases);
	}
}


