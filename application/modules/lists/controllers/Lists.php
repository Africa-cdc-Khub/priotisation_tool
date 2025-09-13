<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Lists extends MX_Controller
{


	public  function __construct()
	{
		parent::__construct();

		$this->module = "lists";
		$this->load->model("lists_mdl", 'lists_mdl');
		$this->load->model("diseases_mdl", 'diseases_mdl');
	}
	
	public function get_thematic_areas(){
		$diseases = $this->lists_mdl->get_thematic_areas();
		echo json_encode($diseases);
	}
	public function get_diseases_by_theme() {
		$themes = $this->input->post('thematic_ids'); // Receives thematic IDs array from AJAX
	
		if (!empty($themes)) {
			$diseases = $this->lists_mdl->get_diseases_by_theme($themes);
			echo json_encode($diseases);
		} else {
			echo json_encode([]);
		}
	}
	
	public function get_memberstates(){
		return $this->lists_mdl->get_memberstates();

	}
	public function get_memberstates_by_region($region_id){
		return $this->lists_mdl->get_memberstates_by_region($region_id);

	}
	public function get_regions(){
		return $this->lists_mdl->get_regions();
	}

	public function get_prioritisation_categories(){
		return $this->lists_mdl->get_prioritisation_categories();


	}
	public function diseases_and_conditions(){

		$data['title'] ="Diseases";
		$data['module'] = $this->module;



		render('diseases',$data);

	
	}

	public function fetch_all() {
        $data = $this->diseases_mdl->get_all();
        echo json_encode($data);
    }

    public function save() {
        $data = [
            'name' => $this->input->post('name'),
            'description' => $this->input->post('description'),
			'thematic_area_id' => $this->input->post('thematic_area_id')
        ];
        $id = $this->input->post('id');

        if ($id) {
            $this->diseases_mdl->update($id, $data);
        } else {
            $this->diseases_mdl->insert($data);
        }

        echo json_encode(['status' => 'success']);
    }

    public function delete($id) {
        $this->diseases_mdl->delete($id);
        echo json_encode(['status' => 'deleted']);
    }

    public function get($id) {
        $data = $this->diseases_mdl->get($id);
        echo json_encode($data);
    }

	
	

}
