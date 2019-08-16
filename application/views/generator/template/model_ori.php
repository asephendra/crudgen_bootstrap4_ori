{php_open}
class {model_name} extends CI_Model
{
	function __construct()
	{
		parent::__construct();
		$this->table = '{table_name}';
	}

	function get_row($id)
	{
		$array_data = array( 
			'{primary_key}' => $id
			);
		$query = $this->db->get_where($this->table , $array_data);

		if( $query->num_rows() > 0 ) {
			$result = $query->row();
		} else {	
			$result = FALSE;
		}
		return $result;		
	}

	function get_all()
	{
		$query = $this->db->get( $this->table );
		if($query->num_rows() > 0) 
		{
			$result = $query->result();
		} 
		else 
		{	
			$result = FALSE;
		}
		return $result;
	}

	function get_result($limit, $offset)
	{
		$this->db->limit($limit, $offset);
		$query = $this->db->get( $this->table );
		if($query->num_rows() > 0) 
		{
			$result = $query->result();
		} 
		else 
		{	
			$result = FALSE;
		}
		return $result;
	}

	function get_count_all()
	{
		$result = $this->db->count_all_results($this->table);
		return $result;
	}

	function get_count_search()
	{
		$keyword = $this->session->userdata('keyword');
		{list_fields}
		$this->db->or_like('{name}', $keyword);{/list_fields}
		$query = $this->db->count_all_result();
		return $query;
	}


	/**
	* Model untuk insert data {title_name}
	*
	* @param params Array
	**/
	function add($params)
	{
		// query add
		$add = $this->db->insert($this->table , $params);

		return $add;
	}

	
	/**
	* Model untuk update data {title_name}
	* 
	* @param id integer
	* @param params Array
	* @return boolean
	**/
	function update($id, $parameter)
	{
		// Menggunakan id sebagai referensi key update
		$this->db->where('{primary_key}', $id);

		$update = $this->db->update($this->table, $parameter);

		return $update;
	}

	
	/**
	* Model untuk hapus data
	*
	* @param id integer
	**/
	function delete($id)
	{
		// delete on primary
		$array_delete = array(
			'{primary_key}' => $id
			);

		$delete = $this->db->delete($this->table , $array_delete);

		return $delete;
	}
}
{php_close}