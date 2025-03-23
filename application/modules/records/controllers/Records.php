<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Records extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('records_model');
		$this->load->library('pagination');
	}

	public function index()
	{
		$data['module'] = 'records';
		$data['title'] = 'Country Disease Profile';
		$data['uptitle'] = "Country";
		$data['countries'] = $this->lists_mdl->get_memberstates();
		$data['thematic_areas'] = $this->lists_mdl->get_thematic_areas();
		//dd($data);
		$data['diseases'] =$this->lists_mdl->get_diseases();
		$data['prioritisation_categories'] = $this->lists_mdl->get_prioritisation_categories();
		render_site('dashboard', $data);
	}
	public function profile()
	{
		// Pagination configuration
		$data['module'] = 'records';
		$data['title'] = 'Home';
		$data['uptitle'] = "Home";
        $data['countries'] =$this->lists_mdl->get_memberstates();
		$data['thematic_areas']=$this->lists_mdl->get_thematic_areas();
		$data['diseases'] =$this->lists_mdl->get_diseases();
		//dd($data);
		render_site('index', $data);
	}

	public function load_ranking_form()
	{
		$member_state_id = $this->input->post('member_state_id');
		$period = $this->input->post('period');
		$thematic_area_id = $this->input->post('thematic_area_id');
		$prioritisation_category_id = $this->input->post('prioritisation_category_id');

		$data['diseases'] = $this->records_model->get_assigned_diseases_with_area($member_state_id, $thematic_area_id);
		$data['parameters'] = $this->records_model->get_all_parameters();

		// Load existing data for editing
		$existing_data = $this->records_model->get_existing_data($member_state_id, $period,$prioritisation_category_id);
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

	public function get_disease_chart_data()
	{
		// Get raw JSON body
		$input = json_decode(file_get_contents('php://input'), true);
	
		$member_state_id = $input['member_state_id'] ?? null;
		$period = $input['period'] ?? null;
		$thematic_area_id = $input['thematic_area_id'] ?? null;
		$prioritisation_category_id = $input['prioritisation_category_id'] ?? null;
	
		$data = $this->records_model->get_priority_disease_counts_by_thematic_area(
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

    $member_state_id = $filters['member_state_id'] ?? null;
    $period = $filters['period'] ?? null;
    $thematic_area_id = $filters['thematic_area_id'] ?? null;
    $prioritisation_category_id = $filters['prioritisation_category_id'] ?? null;

    $data = $this->records_model->get_disease_probabilities($member_state_id, $period, $thematic_area_id, $prioritisation_category_id);

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

    $member_state_id = $input['member_state_id'] ?? null;
    $period = $input['period'] ?? null;
    $thematic_area_id = $input['thematic_area_id'] ?? null;
    $prioritisation_category_id = $input['prioritisation_category_id'] ?? null;
    $disease_id = $input['disease_id'] ?? null;

    $probability = $this->records_model->get_disease_probability_value(
        $member_state_id,
        $period,
        $thematic_area_id,
        $prioritisation_category_id,
        $disease_id
    );

    echo json_encode($probability);
}


	

}


