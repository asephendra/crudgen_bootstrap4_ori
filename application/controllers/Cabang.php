<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Cabang extends Admin_Controller 
{
	public function __construct()
	{
		parent::__construct();
		$this->not_logged_in();
		$this->data['page_title'] = 'Cabang';
		$this->load->model('model_cabang');
	}

	public function index()
	{
		// if(!in_array('viewCabang', $this->permission)) {
		// 	redirect('dashboard', 'refresh');
		// }

		$result = $this->model_cabang->getCabangData();
		$this->data['results'] = $result;
		$this->render_template('cabang/index', $this->data);
	}

	public function fetchCabangData()
	{
		$result = array('data' => array());

		$data = $this->model_cabang->getCabangData();
		foreach ($data as $key => $value) {

			$buttons = '';
			if(in_array('viewCabang', $this->permission)) {
				$buttons .= '<button type="button" class="btn btn-default" onclick="editCabang('.$value['id'].')" data-toggle="modal" data-target="#editCabangModal"><i class="fa fa-pencil"></i></button>';	
			}
			if(in_array('deleteCabang', $this->permission)) {
				$buttons .= ' <button type="button" class="btn btn-default" onclick="removeCabang('.$value['id'].')" data-toggle="modal" data-target="#removeCabangModal"><i class="fa fa-trash"></i></button>
				';
			}				

			$result['data'][$key] = array(
				$value['name'],
				$value['keterangan'],
				$buttons
			);
		} // /foreach

		echo json_encode($result);
	}

	public function fetchCabangById($id)
	{
		if($id) {
			$data = $this->model_cabang->getCabangData($id);
			echo json_encode($data);
		}
		return false;
	}

	public function create()
	{
		if(!in_array('createCabang', $this->permission)) {
			redirect('dashboard', 'refresh');
		}

		$response = array();


// ************************************ EDIT ***********************
		$this->form_validation->set_rules('name', 'Nama cabang', 'trim|required');
		$this->form_validation->set_error_delimiters('<p class="text-danger">','</p>');

        if ($this->form_validation->run() == TRUE) {
        	$data = array(
        		'name' => $this->input->post('name'),
        		'keterangan' => $this->input->post('keterangan'),
        	);
// ****************************************** EDIT ********************
        	

        	$create = $this->model_cabang->create($data);
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
		if(!in_array('updateCabang', $this->permission)) {
			redirect('dashboard', 'refresh');
		}

		$response = array();

// ******************************** EDIT *****************************
		if($id) {
			$this->form_validation->set_rules('name', 'Nama cabang', 'trim|required');
			$this->form_validation->set_error_delimiters('<p class="text-danger">','</p>');

	        if ($this->form_validation->run() == TRUE) {
	        	$data = array(
	        		'name' => $this->input->post('name'),
	        		'keterangan' => $this->input->post('keterangan'),

	        	);
// ****************************************************** edit **************************



	        	
	        	$update = $this->model_cabang->update($data, $id);
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
		if(!in_array('deleteCabang', $this->permission)) {
			redirect('dashboard', 'refresh');
		}
		
		$cabang_id = $this->input->post('cabang_id');
		$response = array();
		if($cabang_id) {
			$delete = $this->model_cabang->remove($cabang_id);
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