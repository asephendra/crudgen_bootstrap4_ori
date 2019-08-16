{php_open}
defined('BASEPATH') OR exit('No direct script access allowed');

class {class_name} extends Admin_Controller
{
	Public function __construct()
	{
		parent::__construct();
		$this->not_logged_in();
		$this->data['page_title'] = '{title_name}';
		$this->load->model('{model_name}');
	}

	Public function index() {
		// if(!in_array('viewTabel', $this->permission)) {
		// 	redirect('dashboard', 'refresh');
		// }

		$result = $this->{model_name}->get_{table_name}Data();
		$this->data['results'] = $result;
		$this->render_template('{table_name}/index', $this->data);
	}	

	public function fetch_{table_name}Data()
	{
		$result = array('data' => array());
		$data = $this->{model_name}->get_{table_name}Data();
		foreach ($data as $key => $value) {

			$buttons = '';
			//if(in_array('viewTabel', $this->permission)) {
				$buttons .= '<button type="button" class="btn btn-sm btn-success" onclick="edit_{table_name}('.$value['id'].')" data-toggle="modal" data-target="#edit_{table_name}Modal">Edit</button>';	
			//}
			//if(in_array('delete_{table_name}', $this->permission)) {
				$buttons .= ' <button type="button" class="btn btn-sm btn-danger" onclick="remove_{table_name}('.$value['id'].')" data-toggle="modal" data-target="#remove_{table_name}Modal">Hapus</button>
				';
			//}				
			
			$result['data'][$key] = array(
				{list_fields}
				$value['{name}'],{/list_fields}
				$buttons
			);

		} 
		echo json_encode($result);
	}

	public function fetch_{table_name}ById($id)
	{
		if($id) {
			$data = $this->{model_name}->get_{table_name}Data($id);
			echo json_encode($data);
		}
		return false;
	}

	public function create()
	{
		if(!in_array('create_{table_name}', $this->permission)) {
			redirect('dashboard', 'refresh');
		}
		$response = array();
		
		// setup config validation
		$config = array(
			{list_fields}
			array(
				'field' => '{name}',
				'label' => '{label}',
				'rules' => '{rules}'
			),{/list_fields}
		);
		$this->form_validation->set_rules($config);

		$this->form_validation->set_error_delimiters('<p class="text-danger">','</p>');

        if ($this->form_validation->run() == TRUE) {
        	
			$data = array(
				{list_fields}
				'{name}' 				=> $this->input->post('{name}'),
				{/list_fields}
			);
        	$create = $this->{model_name}->create($data);

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
		if(!in_array('update_{table_name}', $this->permission)) {
			redirect('dashboard', 'refresh');
		}
		$response = array();
		if($id) {
			$config = array(
				{list_fields}
				array(
					'field' => '{name}',
					'label' => '{label}',
					'rules' => '{rules}'
				),{/list_fields}
			);
			$this->form_validation->set_rules($config);
			$this->form_validation->set_error_delimiters('<p class="text-danger">','</p>');

	        if ($this->form_validation->run() == TRUE) {
				$data = array(
					{list_fields}
					'{name}' 			=> $this->input->post('{name}'),
					{/list_fields}
				);
	        	$update = $this->{model_name}->update($data, $id);
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
		if(!in_array('delete_{table_name}', $this->permission)) {
			redirect('dashboard', 'refresh');
		}
		
		$id = $this->input->post('id');
		$response = array();
		if($id) {

			$delete = $this->{model_name}->remove($id);
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
{php_close}