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
		$this->load->library('pagination');
		
		//Setup pagination
		$config = array(
			'base_url'          => site_url().'/{controller_name}/lists',
			'total_rows'        => $this->model->get_count_all(),
			'per_page'          => 20
		);

		$this->pagination->initialize($config);
		//end pagination

		$data = array(
			'title'			=> 'Daftar {title_name}',
			'jumlah_data'	=> $config['total_rows'],
			'result'		=> $this->model->get_result( $config['per_page'], $this->uri->segment(3, 0) ),
			'pagination'	=> $this->pagination->create_links(),
			);
		
		// Menampikan data ke view
		$this->load->view('backend/inc/header', $data);        
		$this->load->view('backend/{view_folder}/lists', $data);
		$this->load->view('backend/inc/footer', $data);
	}	

	/**
	* Menampilkan listing data menggunakan datatables
	*
	* @return view
	**/
	function lists_dt()
	{
		$data = array(
			'title'			=> 'Daftar {title_name}',
			'result'		=> $this->model->get_all(),
			);
		
		// Menampikan data ke view
		$this->load->view('backend/inc/header', $data);        
		$this->load->view('backend/{view_folder}/lists-datatables', $data);
		$this->load->view('backend/inc/footer', $data);
	}


	/**
	* Menampilkan detail data
	*
	* @return view
	**/
	function detail($id)
	{
		$data = array(
			'title'			=> 'Detail {title_name}',
			'result'		=> $this->model->get_row($id)
			);
		
		// Menampikan data ke view
		$this->load->view('backend/inc/header', $data);        
		$this->load->view('backend/{view_folder}/detail', $data);
		$this->load->view('backend/inc/footer', $data);
	}		


	/**
	* Fungsi untuk menambahkan data
	*
	* @return view
	**/
	function add()
	{   
		// Memanggil library form validation
		$this->load->library('form_validation');

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

		// Jika tidak ada data pengiriman, maka tampilkan form
		if($this->form_validation->run() === FALSE)     
		{
			$data = array(
				'title' => 'Tambah {title_name}'
				);

			// Form untuk menambahkan data
			$this->load->view('backend/inc/header', $data);        
			$this->load->view('backend/{view_folder}/add', $data);
			$this->load->view('backend/inc/footer', $data);
		}
		else
		{   
			// Mengumpulkan data POST dalam bentuk array
			$params = array(
				{list_fields}
				'{name}' 				=> $this->input->post('{name}'),
				{/list_fields}
			);
			
			// Insert data ke tabel
			$query = $this->model->add($params);

			// Jika tambah query berhasil, maka return 1
			if($query === TRUE) {

				// Setup session pesan tambah jika berhasil
				$this->session->set_flashdata('action_status', '<div class="alert alert-info">Data berhasil di tambah</div>');

			} else {

				// Setup session pesan tambah jika gagal
				$this->session->set_flashdata('action_status', '<div class="alert alert-danger">Data gagal di tambah</div>');			
			}

			// redirect jika berhasil dan memberikan informasi sesuai session
			redirect('{controller_name}/lists');
		}
	}

	
	/**
	* Fungsi untuk mengedit data
	*
	* @param id integer
	* @return mix
	**/
	function edit($id)
	{   
		// Memanggil library form validation
		$this->load->library('form_validation');

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

		// Jika tidak ada data pengiriman, maka tampilkan edit form
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
			
			// Update data ke table
			$query = $this->model->update($id, $params);

			// Jika update query berhasil, maka return 1
			if($query == 1) 
			{
				
				// Setup session pesan update jika berhasil
				$this->session->set_flashdata('action_status', '<div class="alert alert-info">Data berhasil di update</div>');

			} 
			else 
			{
				// Setup session pesan update jika gagal
				$this->session->set_flashdata('action_status', '<div class="alert alert-danger">Data gagal di update</div>');			
			}

			// redirect jika berhasil dan memberikan informasi sesuai session
			redirect('{controller_name}/lists');
		}
	}
	
	/**
	* Fungsi untuk menghapus data berdasarkan ID
	*
	* @param id Integer
	**/
	function delete($id)
	{
		$query = $this->model->delete($id);

		// Jika delete query berhasil, maka return 1
		if($query == 1) 
		{

			// Setup session pesan delete jika berhasil
			$this->session->set_flashdata('action_status', '<div class="alert alert-info">Data berhasil di hapus</div>');

		} 
		else 
		{

			// Setup session pesan delete jika gagal
			$this->session->set_flashdata('action_status', '<div class="alert alert-danger">Data gagal di hapus</div>');			
		}

		// Redirect ke halaman list, dilengkapi dengan session data
		redirect('{view_folder}/lists');
	}

}
{php_close}