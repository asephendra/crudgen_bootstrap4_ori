{php_open}
class {model_name} extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}

	function get_row($id)
	{
		$array_data = array( 
			'{primary_key}' => $id
			);
		$query = $this->db->get_where('{table_name}' , $array_data);

		if( $query->num_rows() > 0 ) {
			$result = $query->row();
		} else {	
			$result = FALSE;
		}
		return $result;		
	}

	function get_all()
	{
		$query = $this->db->get( '{table_name}' );
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

	function add($params)
	{
		$add = $this->db->insert('{table_name}' , $params);
		return $add;
	}

	function update($id, $parameter)
	{
		$this->db->where('{primary_key}', $id);
		$update = $this->db->update('{table_name}', $parameter);
		return $update;
	}

	function delete($id)
	{
		$array_delete = array(
			'{primary_key}' => $id
			);
		$delete = $this->db->delete('{table_name}' , $array_delete);
		return $delete;
	}
}
{php_close}