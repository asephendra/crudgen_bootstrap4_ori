<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Penyusutan extends Admin_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->not_logged_in();
		$this->data['page_title'] = 'Penyusutan';
		$this->load->model('model_products');
		$this->load->model('model_brands');
		$this->load->model('model_category');
		$this->load->model('model_stores');
		$this->load->model('model_attributes');
        $this->load->model('model_kelompok'); 
        $this->load->model('model_aset'); 
        $this->load->model('model_company');
        $this->load->model('model_penyusutan');
        $this->load->library('table');
	}
	public function index()
	{
		$this->render_template('penyusutan/index', $this->data);
	}

	public function tes()
	{
		$data = array(
        array('Name', 'Color', 'Size'),
        array('Fred', 'Blue', 'Small'),
        array('Mary', 'Red', 'Large'),
        array('John', 'Green', 'Medium')
		);
		$this->render_template('penyusutan/tes', $data);
	}
	public function fetchPenyusutanData($value='')
	{
		//strtotime(date('Y-m-d')),
		//$awal  = date_create('1988-08-10');
		// $akhir = date_create(); // waktu sekarang
		// $diff  = date_diff( $awal, $akhir );

		// echo 'Selisih waktu: '
		// echo $diff->y . ' tahun, ';
		// echo $diff->m . ' bulan, ';
		$skrg = strtotime(date('Y-m-d'));
		$result = array('data' => array());
		$data = $this->model_penyusutan->getAsetPenyusutan();

		foreach ($data as $key => $value) {
			$barang = $this->model_products->getBarangData($value['barang_id']);
			$perolehan = $value['perolehan'];
			$perolehan2 = number_format($value['perolehan']);
			$tgl = date('d-M-Y',$value['trans_date']);
			$sel = (strtotime(date('Y-m-d')) - $value['trans_date'])/2592000;
			$selisih = round($sel);

			$susut = number_format($perolehan/48);
			$akum = number_format($susut*$selisih);
			$nbuku = number_format($perolehan - $akum);
			$susut2 = '<td style="text-align:right">'.$susut.'</td>';
			$result['data'][$key] = array(
				$barang['name'],
				$tgl,
				$value['jumlah'],
				'Rp.'.$perolehan2,
				$selisih,
				$susut,
				$akum,
				$nbuku
			);
		}
	echo json_encode($result);
	}

}

/* End of file Penyusutan.php */
/* Location: ./application/controllers/Penyusutan.php */