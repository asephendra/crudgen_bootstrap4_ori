<?php

class Contoh_model extends CI_Model
{
	Public function __construct()
	{
		parent::__construct();
	}

	public function get_contohData($id = null)
	{
		if($id) {
			$sql = "SELECT * FROM contoh WHERE id = ?";
			$query = $this->db->query($sql, array($id));
			return $query->row_array();
		}
		$sql = "SELECT * FROM contoh";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function create($data)
	{
		if($data) {
			$insert = $this->db->insert('contoh', $data);
			return ($insert == true) ? true : false;
		}
	}

	public function update($data, $id)
	{
		if($data && $id) {
			$this->db->where('id', $id);
			$update = $this->db->update('contoh', $data);
			return ($update == true) ? true : false;
		}
	}

	public function remove($id)
	{
		if($id) {
			$this->db->where('id', $id);
			$delete = $this->db->delete('contoh');
			return ($delete == true) ? true : false;
		}
	}

}
?>