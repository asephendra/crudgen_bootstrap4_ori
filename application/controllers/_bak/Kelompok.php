<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Kelompok extends Admin_Controller 
{
	public function __construct()
	{
		parent::__construct();

		$this->not_logged_in();

		$this->data['page_title'] = 'Kelompok';

		$this->load->model('model_kelompok');
	}

	/* 
	* It only redirects to the manage kelompok page
	*/
	public function index()
	{

		if(!in_array('viewKelompok', $this->permission)) {
			redirect('dashboard', 'refresh');
		}

		$this->render_template('kelompok/index', $this->data);	
	}	

	/*
	* It checks if it gets the kelompok id and retreives
	* the kelompok information from the kelompok model and 
	* returns the data into json format. 
	* This function is invoked from the view page.
	*/
	public function fetchKelompokDataById($id) 
	{
		if($id) {
			$data = $this->model_kelompok->getKelompokData($id);
			echo json_encode($data);
		}

		return false;
	}

	/*
	* Fetches the kelompok value from the kelompok table 
	* this function is called from the datatable ajax function
	*/
	public function fetchKelompokData()
	{
		$result = array('data' => array());

		$data = $this->model_kelompok->getKelompokData();

		foreach ($data as $key => $value) {

			// button
			$buttons = '';

			if(in_array('updateKelompok', $this->permission)) {
				$buttons .= '<button type="button" class="btn btn-default" onclick="editFunc('.$value['id'].')" data-toggle="modal" data-target="#editModal"><i class="fa fa-pencil"></i></button>';
			}

			if(in_array('deleteKelompok', $this->permission)) {
				$buttons .= ' <button type="button" class="btn btn-default" onclick="removeFunc('.$value['id'].')" data-toggle="modal" data-target="#removeModal"><i class="fa fa-trash"></i></button>';
			}
				

			$status = ($value['active'] == 1) ? '<span class="label label-success">Active</span>' : '<span class="label label-warning">Inactive</span>';

			$result['data'][$key] = array(
				$value['name'],
				$status,
				$buttons
			);
		} // /foreach

		echo json_encode($result);
	}

	/*
	* Its checks the kelompok form validation 
	* and if the validation is successfully then it inserts the data into the database 
	* and returns the json format operation messages
	*/
	public function create()
	{
		if(!in_array('createKelompok', $this->permission)) {
			redirect('dashboard', 'refresh');
		}

		$response = array();

		$this->form_validation->set_rules('kelompok_name', 'Kelompok name', 'trim|required');
		$this->form_validation->set_rules('active', 'Active', 'trim|required');

		$this->form_validation->set_error_delimiters('<p class="text-danger">','</p>');

        if ($this->form_validation->run() == TRUE) {
        	$data = array(
        		'name' => $this->input->post('kelompok_name'),
        		'active' => $this->input->post('active'),	
        	);

        	$create = $this->model_kelompok->create($data);
        	if($create == true) {
        		$response['success'] = true;
        		$response['messages'] = 'Succesfully created';
        	}
        	else {
        		$response['success'] = false;
        		$response['messages'] = 'Error in the database while creating the brand information';			
        	}
        }
        else {
        	$response['success'] = false;
        	foreach ($_POST as $key => $value) {
        		$response['messages'][$key] = form_error($key);
        	}
        }

        echo json_encode($response);
	}

	/*
	* Its checks the kelompok form validation 
	* and if the validation is successfully then it updates the data into the database 
	* and returns the json format operation messages
	*/
	public function update($id)
	{

		if(!in_array('updateKelompok', $this->permission)) {
			redirect('dashboard', 'refresh');
		}

		$response = array();

		if($id) {
			$this->form_validation->set_rules('edit_kelompok_name', 'Kelompok name', 'trim|required');
			$this->form_validation->set_rules('edit_active', 'Active', 'trim|required');

			$this->form_validation->set_error_delimiters('<p class="text-danger">','</p>');

	        if ($this->form_validation->run() == TRUE) {
	        	$data = array(
	        		'name' => $this->input->post('edit_kelompok_name'),
	        		'active' => $this->input->post('edit_active'),	
	        	);

	        	$update = $this->model_kelompok->update($data, $id);
	        	if($update == true) {
	        		$response['success'] = true;
	        		$response['messages'] = 'Succesfully updated';
	        	}
	        	else {
	        		$response['success'] = false;
	        		$response['messages'] = 'Error in the database while updated the brand information';			
	        	}
	        }
	        else {
	        	$response['success'] = false;
	        	foreach ($_POST as $key => $value) {
	        		$response['messages'][$key] = form_error($key);
	        	}
	        }
		}
		else {
			$response['success'] = false;
    		$response['messages'] = 'Error please refresh the page again!!';
		}

		echo json_encode($response);
	}

	/*
	* It removes the kelompok information from the database 
	* and returns the json format operation messages
	*/
	public function remove()
	{
		if(!in_array('deleteKelompok', $this->permission)) {
			redirect('dashboard', 'refresh');
		}
		
		$kelompok_id = $this->input->post('kelompok_id');

		$response = array();
		if($kelompok_id) {
			$delete = $this->model_kelompok->remove($kelompok_id);
			if($delete == true) {
				$response['success'] = true;
				$response['messages'] = "Successfully removed";	
			}
			else {
				$response['success'] = false;
				$response['messages'] = "Error in the database while removing the brand information";
			}
		}
		else {
			$response['success'] = false;
			$response['messages'] = "Refersh the page again!!";
		}

		echo json_encode($response);
	}

}