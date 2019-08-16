<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Tabel extends Admin_Controller 
{
	public function __construct()
	{
		parent::__construct();
		$this->not_logged_in();
		$this->data['page_title'] = 'Tabel';
		$this->load->model('model_tabel');
	}

	public function index()
	{
		// if(!in_array('viewTabel', $this->permission)) {
		// 	redirect('dashboard', 'refresh');
		// }

		$result = $this->model_tabel->getTableData();
		$this->data['results'] = $result;
		$this->render_template('tabel/index', $this->data);
	}

	public function fetchTabelData()
	{
		$result = array('data' => array());

		$data = $this->model_tabel->getTabelData();
		foreach ($data as $key => $value) {

			$buttons = '';
			if(in_array('viewTabel', $this->permission)) {
				$buttons .= '<button type="button" class="btn btn-default" onclick="editTabel('.$value['id'].')" data-toggle="modal" data-target="#editTabelModal"><i class="fa fa-pencil"></i></button>';	
			}
			if(in_array('deleteTabel', $this->permission)) {
				$buttons .= ' <button type="button" class="btn btn-default" onclick="removeTabel('.$value['id'].')" data-toggle="modal" data-target="#removeTabelModal"><i class="fa fa-trash"></i></button>
				';
			}				

			$result['data'][$key] = array(
				$value['kolom_1'],
				$value['kolom_2'],
				$value['kolom_3'],
				$value['kolom_4'],
				$value['kolom_5'],
				$buttons
			);
		} // /foreach

		echo json_encode($result);
	}

	public function fetchTabelById($id)
	{
		if($id) {
			$data = $this->model_tabel->getTabelData($id);
			echo json_encode($data);
		}
		return false;
	}

	public function create()
	{
		if(!in_array('createTabel', $this->permission)) {
			redirect('dashboard', 'refresh');
		}

		$response = array();


// ************************************ EDIT ***********************
		$this->form_validation->set_rules('kolom_1', 'Kolom name', 'trim|required');
		$this->form_validation->set_rules('kolom_2', 'Kolom name', 'trim|required');
		$this->form_validation->set_rules('kolom_3', 'Kolom name', 'trim|required');
		$this->form_validation->set_error_delimiters('<p class="text-danger">','</p>');

        if ($this->form_validation->run() == TRUE) {
        	$data = array(
        		'name' => $this->input->post('name'),
        		'name' => $this->input->post('kolom_1'),
        		'name' => $this->input->post('kolom_2'),
        	);
// ****************************************** EDIT ********************
        	

        	$create = $this->model_tabel->create($data);
        	if($create == true) {
        		$response['success'] = true;
        		$response['messages'] = 'Succesfully created';
        	}
        	else {
        		$response['success'] = false;
        		$response['messages'] = 'Error in the database while insert data!';			
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

	public function update($id)
	{
		if(!in_array('updateTabel', $this->permission)) {
			redirect('dashboard', 'refresh');
		}

		$response = array();

// ******************************** EDIT *****************************
		if($id) {
			$this->form_validation->set_rules('post_1', 'Post 1', 'trim|required');
			$this->form_validation->set_rules('post_2', 'Post 2', 'trim|required');
			$this->form_validation->set_error_delimiters('<p class="text-danger">','</p>');

	        if ($this->form_validation->run() == TRUE) {
	        	$data = array(
	        		'kolom_1' => $this->input->post('post_1'),
	        	);
// ****************************************************** edit **************************



	        	
	        	$update = $this->model_tabel->update($data, $id);
	        	if($update == true) {
	        		$response['success'] = true;
	        		$response['messages'] = 'Succesfully updated';
	        	}
	        	else {
	        		$response['success'] = false;
	        		$response['messages'] = 'Error in the database while updated data';			
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

	public function remove()
	{
		if(!in_array('deleteTabel', $this->permission)) {
			redirect('dashboard', 'refresh');
		}
		
		$tabel_id = $this->input->post('tabel_id');
		$response = array();
		if($tabel_id) {
			$delete = $this->model_tabel->remove($tabel_id);
			if($delete == true) {
				$response['success'] = true;
				$response['messages'] = "Successfully removed";	
			}
			else {
				$response['success'] = false;
				$response['messages'] = "Error in the database while removing data";
			}
		}
		else {
			$response['success'] = false;
			$response['messages'] = "Refresh the page again!!";
		}
		echo json_encode($response);
	}

}