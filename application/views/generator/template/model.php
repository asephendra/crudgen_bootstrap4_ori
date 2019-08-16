{php_open}

class {model_name} extends CI_Model
{
	Public function __construct()
	{
		parent::__construct();
	}

	public function get_{table_name}Data($id = null)
	{
		if($id) {
			$sql = "SELECT * FROM {table_name} WHERE id = ?";
			$query = $this->db->query($sql, array($id));
			return $query->row_array();
		}
		$sql = "SELECT * FROM {table_name}";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function create($data)
	{
		if($data) {
			$insert = $this->db->insert('{table_name}', $data);
			return ($insert == true) ? true : false;
		}
	}

	public function update($data, $id)
	{
		if($data && $id) {
			$this->db->where('id', $id);
			$update = $this->db->update('{table_name}', $data);
			return ($update == true) ? true : false;
		}
	}

	public function remove($id)
	{
		if($id) {
			$this->db->where('id', $id);
			$delete = $this->db->delete('{table_name}');
			return ($delete == true) ? true : false;
		}
	}

}
{php_close}