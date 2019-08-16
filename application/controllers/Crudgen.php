<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class crudgen extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('crud_generator');
	}

	public function index()
	{
		$data = array(
			'title'			=> 'Crud Builder',
			'menu'			=> 'builder',
			'submenu'		=> '',
			'table'			=> '',
			'list_table'	=> $this->crud_generator->get_list_table(),
			);
		$this->load->view('generator/inc2/header', $data);		
		$this->load->view('generator/builder/form_tabel', $data);
		$this->load->view('generator/inc2/footer', $data);
	}


	public function form_fields()
	{
		$table = $this->input->post('list_tables');

		if($table == '')
		{
			redirect('crudgen');
		}

		$data = array(
			'title'				=> 'Crud Builder',
			'menu'				=> 'builder',
			'submenu'			=> '',
			'table'				=> $table,
			'title_name'		=> ucfirst($table),
			'list_table' 		=> $this->crud_generator->get_list_table(),
			'list_fields' 		=> $this->crud_generator->populate_form($table),
			// 'page_name'			=> ucfirst($table),
			'model_name'		=> ucfirst($table.'_model'),
			'view_name'			=> $table,
			'controller_name' 	=> ucfirst($table),
			'table_name'		=> $table
			);
		$this->load->view('generator/inc2/header', $data);		
		$this->load->view('generator/builder/form_fields', $data);
		$this->load->view('generator/inc2/footer', $data);
	}	


	public function build()
	{
		// echo '<pre>';
		// print_r($this->input->post());
		// exit();
		$get_model      = $this->input->post('model_name');
		$get_view       = $this->input->post('view_name');
		$get_controller = $this->input->post('controller_name');
		$get_table      = $this->input->post('table_name'); 
		$get_field      = $this->input->post('fields');
		$get_title		= $this->input->post('title_name');		
		$this->crud_generator->build_model($get_model, $get_view, $get_controller, $get_table, $get_field, $get_title);
		$this->crud_generator->build_controller($get_model, $get_view, $get_controller, $get_table, $get_field, $get_title);
		#$this->crud_generator->build_view_list($get_model, $get_view, $get_controller, $get_table, $get_field, $get_title);
		$this->crud_generator->build_view_index($get_model, $get_view, $get_controller, $get_table, $get_field, $get_title);
		#$this->crud_generator->build_add_list($get_model, $get_view, $get_controller, $get_table, $get_field, $get_title);
		redirect('crudgen/index');
		#exit();
	}
}