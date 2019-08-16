{php_open}
class {class_name} extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('{model_name}', 'model');
	}

	function index() {
		redirect('{controller_name}/lists');
	}	

	function lists()
	{
		$data = array(
			'title'			=> 'Daftar {title_name}',
			'result'		=> $this->model->get_all(),
			);
		$this->load->view('backend/inc/header', $data);        
		$this->load->view('backend/{view_folder}/lists', $data);
		$this->load->view('backend/inc/footer', $data);
	}

	function detail($id)
	{
		$data = array(
			'title'			=> 'Detail {title_name}',
			'result'		=> $this->model->get_row($id)
			);
		$this->load->view('backend/inc/header', $data);        
		$this->load->view('backend/{view_folder}/detail', $data);
		$this->load->view('backend/inc/footer', $data);
	}		

	function add()
	{   
		$this->load->library('form_validation');
		$config = array(
			{list_fields}
			array(
				'field' => '{name}',
				'label' => '{label}',
				'rules' => '{rules}'
			),
			{/list_fields}
		);
		$this->form_validation->set_rules($config);
		if($this->form_validation->run() === FALSE)     
		{
			$data = array(
				'title' => 'Tambah {title_name}'
				);
			$this->load->view('backend/inc/header', $data);        
			$this->load->view('backend/{view_folder}/add', $data);
			$this->load->view('backend/inc/footer', $data);
		}
		else
		{   
			$params = array(
				{list_fields}
				'{name}' 				=> $this->input->post('{name}'),{/list_fields}
			);
			$query = $this->model->add($params);
			if($query === TRUE) {
				$this->session->set_flashdata('action_status', '<div class="alert alert-info">Data berhasil di tambah</div>');
			} else {
				$this->session->set_flashdata('action_status', '<div class="alert alert-danger">Data gagal di tambah</div>');			
			}
			redirect('{controller_name}/lists');
		}
	}

	function edit($id)
	{   
		$this->load->library('form_validation');
		$config = array(
			{list_fields}
			array(
				'field' => '{name}',
				'label' => '{label}',
				'rules' => '{rules}'
			),{/list_fields}
		);

		$this->form_validation->set_rules($config);

		if($this->form_validation->run() === FALSE)
		{   
			$data = array(
				'title' => 'Edit {title_name}',
				'row' 	=> $this->model->get_row($id),
				);
			$this->load->view('backend/inc/header', $data);        
			$this->load->view('backend/{view_folder}/edit', $data);
			$this->load->view('backend/inc/footer', $data);
		}
		else
		{   
			$params = array(
				{list_fields}
				'{name}' 			=> $this->input->post('{name}'),{/list_fields}
			);
			$query = $this->model->update($id, $params);
			if($query == 1) 
			{
				$this->session->set_flashdata('action_status', '<div class="alert alert-info">Data berhasil di update</div>');
			} 
			else 
			{
				$this->session->set_flashdata('action_status', '<div class="alert alert-danger">Data gagal di update</div>');			
			}
			redirect('{controller_name}/lists');
		}
	}
	
	function delete($id)
	{
		$query = $this->model->delete($id);
		if($query == 1) 
		{
			$this->session->set_flashdata('action_status', '<div class="alert alert-info">Data berhasil di hapus</div>');
		} 
		else 
		{
			$this->session->set_flashdata('action_status', '<div class="alert alert-danger">Data gagal di hapus</div>');	
		}
		redirect('{view_folder}/lists');
	}

}
{php_close}