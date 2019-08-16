<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Penyusutan extends Admin_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->not_logged_in();
		$this->data['page_title'] = 'Aset';
		$this->load->model('model_products');
		$this->load->model('model_brands');
		$this->load->model('model_category');
		$this->load->model('model_stores');
		$this->load->model('model_attributes');
        $this->load->model('model_kelompok'); 
        $this->load->model('model_aset'); 
        $this->load->model('model_company');
	}
	public function index()
	{
		$this->render_template('penyusutan/index', $this->data);
	}
	public function fetchAsetData($value='')
	{
		$result = array('data' => array());
		$data = $this->model_penyusutan->getAllAset();
		foreach ($data as $key => $value) {
			$result['data'][$key] = array(


			);
		}
	echo json_encode($result);
	}

}

/* End of file Penyusutan.php */
/* Location: ./application/controllers/Penyusutan.php */