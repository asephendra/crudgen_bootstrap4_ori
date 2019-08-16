<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Model_penyusutan extends CI_Model {
public function __construct()
{
	parent::__construct();
}

public function getAllAset($value='')
{
	$sql = "SELECT * FROM aset ORDER BY id ASC ";
	$query = $this->db->query($sql);
	return $query->result_array();
}

// $query = " SELECT tgl_masuk, barang_inventaris.kd_barang as kode_barang, hrg_inven, COUNT(barang_inventaris.kd_barang) as jumlah_unit, 
// 		SUM(hrg_inven) as perolehan, kd_departemen, nm_barang, kd_kategori FROM barang_inventaris 
// 		LEFT JOIN penempatan_item ON barang_inventaris.kd_inventaris=penempatan_item.kd_inventaris
// 		LEFT JOIN barang ON barang_inventaris.kd_barang=barang.kd_barang 
// 		$filterSQL
// 		GROUP BY tgl_masuk, kode_barang ORDER BY tgl_masuk ASC";
public function getAsetPenyusutan($value='')
{
	// $sql = 	"SELECT * FROM aset";
	$sql = 	" SELECT trans_date, barang_id, COUNT(barang_id) as jumlah, SUM(rate) as perolehan FROM aset
			  WHERE trans_date IS NOT NULL
			  GROUP BY  trans_date, barang_id  ORDER BY trans_date ASC";
	$query = $this->db->query($sql);
	return $query->result_array();
}

}

/* End of file Model_penyusutan.php */
/* Location: ./application/models/Model_penyusutan.php */