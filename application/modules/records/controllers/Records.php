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
		
		// Check if user is admin (role = 10)
		$user_role = $this->session->userdata('role');
		$is_admin = ($user_role == 10);
		
		if ($is_admin) {
			// Admin users can see all countries and regions
			$data['countries'] = $this->lists_mdl->get_memberstates();
			$data['regions'] = $this->lists_mdl->get_regions();
			$data['user_region'] = null;
			$data['user_memberstate'] = null;
		} else {
			// Non-admin users see only their region and member state
			$memberstate_id = $this->session->userdata('memberstate_id');
			$data['user_memberstate'] = $this->lists_mdl->get_memberstate_with_region($memberstate_id);
			$data['user_region'] = $this->lists_mdl->get_region_by_memberstate_id($memberstate_id);
			$data['countries'] = [$data['user_memberstate']]; // Only their country
			$data['regions'] = [$data['user_region']]; // Only their region
		}
		
		$data['thematic_areas'] = $this->lists_mdl->get_thematic_areas();
		$data['diseases'] = $this->lists_mdl->get_diseases();
		$data['prioritisation_categories'] = $this->lists_mdl->get_prioritisation_categories();
		$data['is_admin'] = $is_admin;
		
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

	public function get_map_data()
{
	try {
		$member_state_id = $this->input->post('member_state_id');
		$period = $this->input->post('period');
		$thematic_area_id = $this->input->post('thematic_area_id');
		$prioritisation_category_id = $this->input->post('prioritisation_category_id');
		
		// Log the received parameters
		log_message('debug', 'Map data request - member_state_id: ' . $member_state_id . ', period: ' . $period . ', thematic_area_id: ' . $thematic_area_id . ', prioritisation_category_id: ' . $prioritisation_category_id);

	// Build query based on filters
	$this->db->select('
		ms.id,
		ms.member_state,
		ms.iso3_code,
		r.name as region_name,
		COUNT(msdd.id) as total_diseases,
		AVG(CASE 
			WHEN msdd.priority_level = "High" THEN 3
			WHEN msdd.priority_level = "Medium" THEN 2
			WHEN msdd.priority_level = "Low" THEN 1
			ELSE NULL 
		END) as avg_priority,
		GROUP_CONCAT(DISTINCT CONCAT(d.name, ":", msdd.priority_level, ":", msdd.probability) ORDER BY 
			CASE 
				WHEN msdd.priority_level = "High" THEN 3
				WHEN msdd.priority_level = "Medium" THEN 2
				WHEN msdd.priority_level = "Low" THEN 1
				ELSE 0
			END DESC, msdd.probability DESC SEPARATOR "|") as disease_priorities
	');
	$this->db->from('member_states ms');
	$this->db->join('regions r', 'ms.region_id = r.id', 'left');
	$this->db->join('member_state_diseases_data msdd', 'ms.id = msdd.member_state_id', 'left');
	$this->db->join('diseases_and_conditions d', 'msdd.disease_id = d.id', 'left');
	
	// Apply filters
	if ($member_state_id) {
		$this->db->where('ms.id', $member_state_id);
	}
	if ($period) {
		$this->db->where('msdd.period', $period);
	}
	if ($thematic_area_id) {
		$this->db->join('disease_thematic_areas dta', 'd.id = dta.disease_id', 'left');
		$this->db->where('dta.thematic_area_id', $thematic_area_id);
	}
	if ($prioritisation_category_id) {
		$this->db->where('msdd.prioritisation_category', $prioritisation_category_id);
	}
	
	$this->db->group_by('ms.id, ms.member_state, ms.iso3_code, r.name');
	$this->db->order_by('total_diseases', 'DESC');
	
	$query = $this->db->get();
	$results = $query->result_array();
	
	// Process results to include disease details
	$mapData = [];
	foreach ($results as $row) {
		$diseases = [];
		if ($row['disease_priorities']) {
			$diseasePriorityPairs = explode('|', $row['disease_priorities']);
			
			// Limit to top 5 diseases per country
			$diseasePriorityPairs = array_slice($diseasePriorityPairs, 0, 5);
			
			foreach ($diseasePriorityPairs as $pair) {
				$parts = explode(':', $pair);
				if (count($parts) == 3) {
					$diseases[] = [
						'name' => $parts[0],
						'priority_level' => $parts[1], // Keep as text (High, Medium, Low)
						'probability' => (float)$parts[2]
					];
				}
			}
		}
		
		// Calculate average priority from the diseases array
		$avgPriority = 0;
		if (!empty($diseases)) {
			$priorityValues = [];
			foreach ($diseases as $disease) {
				switch ($disease['priority_level']) {
					case 'High':
						$priorityValues[] = 3;
						break;
					case 'Medium':
						$priorityValues[] = 2;
						break;
					case 'Low':
						$priorityValues[] = 1;
						break;
				}
			}
			if (!empty($priorityValues)) {
				$avgPriority = array_sum($priorityValues) / count($priorityValues);
			}
		} elseif ($row['avg_priority']) {
			$avgPriority = (float)$row['avg_priority'];
		}
		
		$mapData[] = [
			'id' => $row['id'],
			'member_state' => $row['member_state'],
			'iso3_code' => $row['iso3_code'],
			'region_name' => $row['region_name'],
			'total_diseases' => (int)$row['total_diseases'],
			'avg_priority' => round($avgPriority, 2),
			'diseases' => $diseases
		];
	}
	
	echo json_encode(['status' => 'success', 'data' => $mapData]);
	
	} catch (Exception $e) {
		log_message('error', 'Map data error: ' . $e->getMessage());
		echo json_encode(['status' => 'error', 'message' => 'Error loading map data: ' . $e->getMessage()]);
	}
}

	public function get_summary_data()
{
	$member_state_id = $this->input->post('member_state_id');
	$period = $this->input->post('period');
	$thematic_area_id = $this->input->post('thematic_area_id');
	$prioritisation_category_id = $this->input->post('prioritisation_category_id');

	// Build query for summary statistics
	$this->db->select('
		COUNT(DISTINCT msdd.disease_id) as total_diseases,
		AVG(msdd.priority_level) as avg_priority,
		COUNT(DISTINCT msdd.member_state_id) as countries_with_data,
		COUNT(msdd.id) as total_entries
	');
	$this->db->from('member_state_diseases_data msdd');
	$this->db->join('member_states ms', 'msdd.member_state_id = ms.id', 'left');
	$this->db->join('diseases_and_conditions d', 'msdd.disease_id = d.id', 'left');
	
	// Apply filters
	if ($member_state_id) {
		$this->db->where('msdd.member_state_id', $member_state_id);
	}
	if ($period) {
		$this->db->where('msdd.period', $period);
	}
	if ($thematic_area_id) {
		$this->db->join('disease_thematic_areas dta', 'd.id = dta.disease_id', 'left');
		$this->db->where('dta.thematic_area_id', $thematic_area_id);
	}
	if ($prioritisation_category_id) {
		$this->db->where('msdd.prioritisation_category', $prioritisation_category_id);
	}
	
	$query = $this->db->get();
	$result = $query->row_array();
	
	// Get additional statistics
	$total_countries = $this->db->count_all('member_states');
	$total_regions = $this->db->count_all('regions');
	
	$summaryData = [
		'total_diseases' => (int)($result['total_diseases'] ?? 0),
		'avg_priority' => (float)($result['avg_priority'] ?? 0),
		'countries_with_data' => (int)($result['countries_with_data'] ?? 0),
		'total_entries' => (int)($result['total_entries'] ?? 0),
		'total_countries' => $total_countries,
		'total_regions' => $total_regions
	];
	
	echo json_encode(['status' => 'success', 'data' => $summaryData]);
}

	public function get_ranking_data()
{
	// Get DataTables parameters
	$draw = intval($this->input->post("draw"));
	$start = intval($this->input->post("start"));
	$length = intval($this->input->post("length"));
	$search_data = $this->input->post("search");
	$search_value = isset($search_data["value"]) ? $search_data["value"] : "";
	
	$order_data = $this->input->post("order");
	$order_column = isset($order_data[0]["column"]) ? intval($order_data[0]["column"]) : 0;
	$order_dir = isset($order_data[0]["dir"]) ? $order_data[0]["dir"] : "asc";
	
	// Debug: Log the request
	log_message('debug', 'DataTable Request - Draw: ' . $draw . ', Start: ' . $start . ', Length: ' . $length);
	
	// Debug: Check if we have any data at all
	$test_query = $this->db->get('member_state_diseases_data');
	$test_count = $test_query->num_rows();
	log_message('debug', 'Total records in member_state_diseases_data: ' . $test_count);
	
	// Get filter parameters
	$member_state_id = $this->input->post('member_state_id');
	$period = $this->input->post('period');
	$thematic_area_id = $this->input->post('thematic_area_id');
	$prioritisation_category_id = $this->input->post('prioritisation_category_id');
	$region_id = $this->input->post('region_id');
	
	// Column mapping for ordering
	$columns = array(
		0 => 'msd.period',
		1 => 'pc.name',
		2 => 'rg.name',
		3 => 'ms.member_state',
		4 => 'd.name',
		5 => 'ta.name',
		6 => 'msd.prev',
		7 => 'msd.detect',
		8 => 'msd.morbid',
		9 => 'msd.case',
		10 => 'msd.mort',
		11 => 'msd.composite_index',
		12 => 'msd.probability',
		13 => 'msd.priority_level',
		14 => 'msd.draft_status'
	);
	
	// Build the main query
	$this->db->select('
		msd.period,
		pc.name as prioritization_level,
		rg.name as region_name,
		ms.member_state,
		d.name as disease_name,
		d.description as disease_description,
		ta.name as thematic_area_name,
		ta.description as thematic_area_description,
		msd.prev,
		msd.detect,
		msd.morbid,
		msd.case,
		msd.mort,
		msd.temp_composite_index,
		msd.temp_probability,
		msd.temp_priority_level,
		msd.composite_index,
		msd.probability,
		msd.priority_level,
		msd.draft_status,
		msd.created_at,
		msd.updated_at
	');
	$this->db->from('member_state_diseases_data msd');
	$this->db->join('member_states ms', 'ms.id = msd.member_state_id', 'left');
	$this->db->join('regions rg', 'ms.region_id = rg.id', 'left');
	$this->db->join('diseases_and_conditions d', 'd.id = msd.disease_id', 'left');
	$this->db->join('priotisation_category pc', 'pc.id = msd.prioritisation_category', 'left');
	$this->db->join('disease_thematic_areas ta', 'ta.id = d.thematic_area_id', 'left');
	
	// Apply filters
	if ($member_state_id) {
		$this->db->where('msd.member_state_id', $member_state_id);
	}
	if ($period) {
		$this->db->where('msd.period', $period);
	}
	if ($thematic_area_id) {
		$this->db->where('ta.id', $thematic_area_id);
	}
	if ($prioritisation_category_id) {
		$this->db->where('msd.prioritisation_category', $prioritisation_category_id);
	}
	if ($region_id) {
		$this->db->where('ms.region_id', $region_id);
	}
	
	// Apply search
	if (!empty($search_value)) {
		$this->db->group_start();
		$this->db->like('ms.member_state', $search_value);
		$this->db->or_like('d.name', $search_value);
		$this->db->or_like('ta.name', $search_value);
		$this->db->or_like('rg.name', $search_value);
		$this->db->or_like('pc.name', $search_value);
		$this->db->group_end();
	}
	
	// Get total records count
	$total_records = $this->db->count_all_results('', FALSE);
	
	// Apply ordering
	if (isset($columns[$order_column])) {
		$this->db->order_by($columns[$order_column], $order_dir);
	} else {
		$this->db->order_by('msd.priority_level', 'DESC');
	}
	
	// Apply pagination
	$this->db->limit($length, $start);
	
	$query = $this->db->get();
	
	// Debug: Log the query
	log_message('debug', 'DataTable Query: ' . $this->db->last_query());
	
	$data = $query->result_array();
	
	// Debug: Log the data count
	log_message('debug', 'DataTable Data Count: ' . count($data));
	
	// Helper function to safely format numbers
	function safe_number_format($value, $decimals = 2) {
		if (is_null($value) || $value === '') {
			return '0.00';
		}
		return number_format((float)$value, $decimals);
	}
	
	// Format data for DataTables
	$formatted_data = array();
	foreach ($data as $row) {
		$formatted_data[] = array(
			$row['period'],
			$row['prioritization_level'],
			$row['region_name'],
			$row['member_state'],
			$row['disease_name'],
			$row['thematic_area_name'],
			safe_number_format($row['prev'], 2),
			safe_number_format($row['detect'], 2),
			safe_number_format($row['morbid'], 2),
			safe_number_format($row['case'], 2),
			safe_number_format($row['mort'], 2),
			safe_number_format($row['composite_index'], 2),
			safe_number_format($row['probability'], 2),
			$row['priority_level'], // Text field (High, Medium, Low)
			$row['draft_status'] == 1 ? '<span class="badge badge-warning">Draft</span>' : '<span class="badge badge-success">Final</span>',
			$row['created_at'],
			$row['updated_at']
		);
	}
	
	// Get filtered records count
	$this->db->select('COUNT(*) as count');
	$this->db->from('member_state_diseases_data msd');
	$this->db->join('member_states ms', 'ms.id = msd.member_state_id', 'left');
	$this->db->join('regions rg', 'ms.region_id = rg.id', 'left');
	$this->db->join('diseases_and_conditions d', 'd.id = msd.disease_id', 'left');
	$this->db->join('priotisation_category pc', 'pc.id = msd.prioritisation_category', 'left');
	$this->db->join('disease_thematic_areas ta', 'ta.id = d.thematic_area_id', 'left');
	
	// Apply same filters
	if ($member_state_id) {
		$this->db->where('msd.member_state_id', $member_state_id);
	}
	if ($period) {
		$this->db->where('msd.period', $period);
	}
	if ($thematic_area_id) {
		$this->db->where('ta.id', $thematic_area_id);
	}
	if ($prioritisation_category_id) {
		$this->db->where('msd.prioritisation_category', $prioritisation_category_id);
	}
	if ($region_id) {
		$this->db->where('ms.region_id', $region_id);
	}
	
	// Apply search
	if (!empty($search_value)) {
		$this->db->group_start();
		$this->db->like('ms.member_state', $search_value);
		$this->db->or_like('d.name', $search_value);
		$this->db->or_like('ta.name', $search_value);
		$this->db->or_like('rg.name', $search_value);
		$this->db->or_like('pc.name', $search_value);
		$this->db->group_end();
	}
	
	$filtered_query = $this->db->get();
	$filtered_records = $filtered_query->row()->count;
	
	// Return DataTables response
	$response = array(
		"draw" => $draw,
		"recordsTotal" => $total_records,
		"recordsFiltered" => $filtered_records,
		"data" => $formatted_data
	);
	
	echo json_encode($response);
}

	public function test_ranking_data()
{
	// Simple test to check if data exists
	$query = $this->db->get('member_state_diseases_data', 5);
	$data = $query->result_array();
	
	echo json_encode([
		'status' => 'success',
		'count' => count($data),
		'sample' => $data
	]);
}
	public function profile()
	{
		// Pagination configuration
		$data['module'] = 'records';
		$data['title'] = 'Home';
		$data['uptitle'] = "Home";
		
		// Check if user is admin (role = 10)
		$user_role = $this->session->userdata('role');
		$is_admin = ($user_role == 10);
		
		if ($is_admin) {
			// Admin users can see all countries and regions
			$data['countries'] = $this->lists_mdl->get_memberstates();
			$data['regions'] = $this->lists_mdl->get_regions();
			$data['user_region'] = null;
			$data['user_memberstate'] = null;
		} else {
			// Non-admin users see only their member state
			$memberstate_id = $this->session->userdata('memberstate_id');
			$data['user_memberstate'] = $this->lists_mdl->get_memberstate_with_region($memberstate_id);
			$data['user_region'] = $this->lists_mdl->get_region_by_memberstate_id($memberstate_id);
			$data['countries'] = [$data['user_memberstate']]; // Only their country
			$data['regions'] = [$data['user_region']]; // Only their region
		}
		
		$data['thematic_areas'] = $this->lists_mdl->get_thematic_areas();
		$data['diseases'] = $this->lists_mdl->get_diseases();
		$data['is_admin'] = $is_admin;
		
		render_site('profile_improved', $data);
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


