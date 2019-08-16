<?php

class Buku_model extends CI_Model
{
	Public function __construct()
	{
		parent::__construct();
	}

	public function get_bukuData($id = null)
	{
		if($id) {
			$sql = "SELECT * FROM buku WHERE id = ?";
			$query = $this->db->query($sql, array($id));
			return $query->row_array();
		}
		$sql = "SELECT * FROM buku";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function create($data)
	{
		if($data) {
			$insert = $this->db->insert('buku', $data);
			return ($insert == true) ? true : false;
		}
	}

	public function update($data, $id)
	{
		if($data && $id) {
			$this->db->where('id', $id);
			$update = $this->db->update('buku', $data);
			return ($update == true) ? true : false;
		}
	}

	public function remove($id)
	{
		if($id) {
			$this->db->where('id', $id);
			$delete = $this->db->delete('buku');
			return ($delete == true) ? true : false;
		}
	}

}
?>