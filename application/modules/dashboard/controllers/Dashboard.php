<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends MX_Controller
{


	public  function __construct()
	{
		parent::__construct();

		$this->dashmodule = "dashboard";
		$this->load->model("dashboard_mdl", 'dash_mdl');
	}

public function home()
	{
		$data['module'] = $this->dashmodule;
		$data['title'] = 'Dashboard';
		$data['uptitle'] = "Country";
		$data['uptitle'] = "Region";
		$data['countries'] = $this->lists_mdl->get_memberstates();
		$data['thematic_areas'] = $this->lists_mdl->get_thematic_areas();
		//dd($data);
		$data['diseases'] =$this->lists_mdl->get_diseases();
		$data['prioritisation_categories'] = $this->lists_mdl->get_prioritisation_categories();
		render('home', $data);
	}
	public function submssions()
	{
		$data['module'] = 'records';
		$data['title'] = 'Country Disease Profile';
		$data['uptitle'] = "Region";
		$data['uptitle'] = "Country";
		$data['countries'] = $this->lists_mdl->get_memberstates();
		$data['prioritisation_categories'] = $this->dash_mdl->get_prioritisation_categories();
		render_site('dashboard', $data);
	}
}
