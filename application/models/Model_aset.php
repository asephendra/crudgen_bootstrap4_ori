<?php 

class Model_aset extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	/* get the brand data */
	public function getAsetData($id = null)
	{
		if($id) {

			$sql = "SELECT aset.id,aset.barcode,aset.rate,barang.name as name FROM aset 
				LEFT JOIN barang ON aset.barang_id=barang.id where aset.id=? ";
			$query = $this->db->query($sql, array($id));
			return $query->row_array();
		}

		$sql = "SELECT * FROM aset ORDER BY id DESC";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	public function getBarangData($id = null)
	{
		if($id) {
			$sql = "SELECT * FROM barang where id = ?";
			$query = $this->db->query($sql, array($id));
			return $query->row_array();
		}

		$sql = "SELECT * FROM barang ORDER BY id DESC";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function getActiveAsetData()
	{
		$sql = "SELECT * FROM aset where status='1'";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	public function getActiveBarangData()
	{
		$sql = "SELECT * FROM barang  ORDER BY id ASC";
		$query = $this->db->query($sql, array(1));
		return $query->result_array();
	}

	public function getPenempatanData()
	{
		$sql = "SELECT * FROM designation  ORDER BY id ASC";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function create()
	{
		$user_id = $this->session->userdata('id');
		// $buy_no = 'PA-'.strtoupper(substr(md5(uniqid(mt_rand(), true)), 0, 6));
		$buy_no = $this->model_aset->getBuyNo();
    	$data = array(
    		'buy_no' => $buy_no,
    		'buy_date' => strtotime(date('Y-m-d')),
    		'buyer_name' => $this->input->post('buyer_name'),
    		'supplier_name' => $this->input->post('supplier_name'),
    		'supplier_address' => $this->input->post('supplier_address'),
    		'total' => $this->input->post('gross_amount_value'),
    		'user_id' => $user_id
    	);
		$insert = $this->db->insert('buy', $data);
		$order_id = $this->db->insert_id();
		// $this->load->model('model_products');
		$count_product = count($this->input->post('product'));
		for($x = 0; $x < $count_product; $x++) {
    		$items = array(
    			'buy_id' => $buy_no,
    			'barang_id' => $this->input->post('product')[$x],
    			'qty' => $this->input->post('qty')[$x],
    			'rate' => $this->input->post('rate')[$x],
    			'amount' => $this->input->post('amount_value')[$x],
    		);
    		$this->db->insert('buy_item', $items);
			$jumlah = $this->input->post('qty')[$x];
    		for($y = 0; $y < $jumlah; $y++) {
    			// $bar = 'ASET-'.strtoupper(substr(md5(uniqid(mt_rand(), true)), 0, 6));
    			$items2 = array(
    			'barcode' => $this->model_aset->getBarcode(),
    			'barang_id' => $this->input->post('product')[$x],
    			'category_id' => 4,
    			'kelompok_id' => 5,
    			'rate' => $this->input->post('rate')[$x],
    			'buy_no' => $buy_no,
    			'buy_date' => strtotime(date('Y-m-d h:i:s a'))
    			);
    			$this->db->insert('aset', $items2);
    		}
    	}
		//return ($order_id) ? $order_id : false;
	}


	public function designation()
	{
		$user_id = $this->session->userdata('id');
		$no_penempatan = 'PL-'.strtoupper(substr(md5(uniqid(mt_rand(), true)), 0, 7));
		$trans_date = strtotime(date('Y-m-d'));
		$cabang_id = $this->input->post('cabang');
		$lokasi_id = $this->input->post('lokasi');
    	$data = array(
    		'trans_no' => $no_penempatan,
    		'trans_date' => $trans_date,
    		'cabang_id' => $cabang_id,
    		'lokasi_id' => $lokasi_id,
    		'total' => $this->input->post('gross_amount_value'),
    		'user_id' => $user_id
    	);
		$insert = $this->db->insert('designation', $data);
		$trans_id = $this->db->insert_id();
		$count_product = count($this->input->post('product'));
		for($x = 0; $x < $count_product; $x++) {
			$aset_id = $this->input->post('product')[$x];
    		$items = array(
    			'trans_no' => $no_penempatan,
    			'barang_id' => $aset_id,
    			'rate' => $this->input->post('qty')[$x],
    		);
    		$this->db->insert('designation_item', $items);
			$update_aset_data = array('status' => '2','trans_no'=> $no_penempatan,'trans_date'=> $trans_date, 'cabang_id'=> $cabang_id, 'lokasi_id'=>$lokasi_id,);
			$this->model_aset->update($update_aset_data, $aset_id);
    	}
 		//return ($order_id) ? $order_id : false;
	}

	public function update($data, $id)
	{
		if($data && $id) {
			$this->db->where('id', $id);
			$update = $this->db->update('aset', $data);
			return ($update == true) ? true : false;
		}
	}

	public function remove($id)
	{
		if($id) {
			$this->db->where('id', $id);
			$delete = $this->db->delete('products');
			return ($delete == true) ? true : false;
		}
	}

	public function countTotalProducts()
	{
		$sql = "SELECT * FROM products";
		$query = $this->db->query($sql);
		return $query->num_rows();
	}
	public function getBarcode()
	{
		$q = $this->db->query("select MAX(RIGHT(barcode,8)) as kd_max from aset");
		$kd = "";
		if($q->num_rows()>0)
		{
			foreach($q->result() as $k)
			{
				$tmp = ((int)$k->kd_max)+1;
				$kd = sprintf("%08s", $tmp);
			}
		}
		else
		{
			$kd = "00000001";
		}	
		return "FK".$kd;
	}
	public function getBuyNo()
	{
		$q = $this->db->query("select MAX(RIGHT(buy_no,8)) as kd_max from buy");
		$kd = "";
		if($q->num_rows()>0)
		{
			foreach($q->result() as $k)
			{
				$tmp = ((int)$k->kd_max)+1;
				$kd = sprintf("%08s", $tmp);
			}
		}
		else
		{
			$kd = "00000001";
		}	
		return "FB".$kd;
	}

}