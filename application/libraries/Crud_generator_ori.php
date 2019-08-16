<?php
class Crud_generator
{

	// folder backend
	private $backend_folder;

	// folder view
	private $view_folder;

	// folder app view
	private $view_path_folder;

	// membuat protected class name
	protected $class_name;

	public function __construct()
	{
		$this->load->helper('file');
		$this->backend_folder 	= 'backend';
		$this->view_folder 		= 'views/'.$this->backend_folder;		
		$this->view_path_folder = APPPATH.'/views/'.$this->backend_folder.'/';		
	}

	/**
	 * __get
	 *
	 * Enables the use of CI super-global without having to define an extra variable.
	 *
	 * I can't remember where I first saw this, so thank you if you are the original author. -Militis
	 *
	 * @access	public
	 * @param	$var
	 * @return	mixed
	 */
	public function __get($var)
	{
		return get_instance()->$var;
	}


	/**
	 * php tags
	 * digunakan untuk array template parser
	 * @return array
	 *
	 */	
	private function php_tags()
	{
		$array = array(
			'php_open' => "<?php",
			'php_close' => "?>"
			);
		return $array;
	}


	/**
	 * Get Table
	 * Berfungsi untuk mendapatkan daftar table
	 * @param string $table
	 * return array
	 *
	 */	
	public function get_list_table() 
	{
		$list_table = $this->db->list_tables();

		$table = array();

		if($list_table) {
			foreach($list_table as $key) {
				$table[$key] = $key;
			}
		}

		return $table;
	}


	/**
	 * Get Primary Fields
	 * Mendapatkan field primary field
	 * @param string $table
	 * return string
	 *
	 */	
	public function get_primary_key($table) 
	{
		$primary_field = $this->db->primary($table);
		return $primary_field;
	}


	/**
	 * Get Fields
	 * Berfungsi untuk mendapatkan daftar field by table
	 * @param string $table
	 * return array
	 *
	 */	
	public function get_fields($table) 
	{
		if($table) {
			$result = $this->db->field_data($table);
		} else {
			$result = FALSE;
		}

		return $result;
	}

	/**
	 * Get List Fields
	 * Berfungsi untuk mendapatkan daftar nama kolom by table
	 * @param string $table
	 * return array
	 *
	 */	
	public function get_list_fields($table) 
	{
		if($table) {
			$result = $this->db->list_fields($table);
		} else {
			$result = FALSE;
		}

		return $result;
	}


	public function dropdown_validation()
	{
		$array_validation = array(
			'valid_url' 	=> 'valid_url',
			'valid_email' 	=> 'valid_email',
			'alpha' 		=> 'alpha',
			'alpha_numeric' => 'alpha_numeric',
			#'valid_email' => 'valid_email',
			#'valid_email' => 'valid_email',
			);
	}


	/**
	 * Create label
	 * @param string $label
	 * @return string
	 *
	 */
	private function _create_label($label) 
	{	
		// remove _
		$convert = str_replace('_', ' ', $label);
		$convert = ucwords( $convert );
		return $convert;
	}	


	/**
	 * List form dropdown
	 * @return function
	 *
	 */
	private function _dropdown_type($i, $get_type = NULL) 
	{
		switch ($get_type) {

			case 'varchar':
				$set_type = 'input';
				break;

			case 'text':
				$set_type = 'textarea';
				break;

			case 'date':
				$set_type = 'date';
				break;
			
			default:
				$set_type = 'input';
				break;
		}		

		$array_dropdown = array(
			'input'		=> 'input',
			'password' 	=> 'password',
			'textarea'	=> 'textarea',
			'texteditor'=> 'texteditor',
			//'combobox' 	=> 'combobox',
			//'radio' 	=> 'radio',
			//'checkbox' 	=> 'checkbox',
			'date'		=> 'date',
			'file'		=> 'file'
			);

		$create_dropdown = form_dropdown( "fields[$i][dropdown_type]", $array_dropdown, $set_type, 'class="form-controls"' );

		return $create_dropdown;
	}


	/**
	 * Populate form
	 * Berfungsi untuk populate dan generate MVC
	 * @return function
	 *
	 */
	public function populate_form($table = '') 
	{

		// jika tabel kosong, exit
		if($table == '')
		{
			return 'table tidak boleh kosong'; 
			exit();
		}

		// Load table library
		$this->load->library('table');

		// Setup table template
		$table_template = array(
		'table_open'            => '<table class="table table-striped table-condensed">',

		'thead_open'            => '<thead>',
		'thead_close'           => '</thead>',

		'heading_row_start'     => '<tr style="background:#efefef">',
		'heading_row_end'       => '</tr>',
		'heading_cell_start'    => '<th>',
		'heading_cell_end'      => '</th>',

		'tbody_open'            => '<tbody>',
		'tbody_close'           => '</tbody>',

		'row_start'             => '<tr>',
		'row_end'               => '</tr>',
		'cell_start'            => '<td>',
		'cell_end'              => '</td>',

		'row_alt_start'         => '<tr>',
		'row_alt_end'           => '</tr>',
		'cell_alt_start'        => '<td>',
		'cell_alt_end'          => '</td>',

		'table_close'           => '</table>'
		);

		$this->table->set_template($table_template);

		// Set heading
		$this->table->set_heading( '#', 'Label', 'Name', 'Original type', 'Set Type Form', 'Append #id', 'Append .class', 'Validation', 'List View ?', 'Is search ?');

		// Set empty coloum content
		#$this->table->set_empty("-");

		// Set table function
		#$this->table->function = 'htmlspecialchars';

		// Load field by table
		$list_fields = $this->get_fields($table);

		// get primary key
		$get_primary_key = $this->get_primary_key($table);

		// Populate form
		$form = array();

		$i = 1;
		foreach($list_fields as $data) {

			// check max length
			$max_length = (intval($data->max_length) != 0) ? 'maxlength="'.$data->max_length.'"' : ''; 

				if($data->name == $get_primary_key)
				{
					$form[] = array(						
						// Number
						$i,
						
						// Field label
						form_input( "fields[$i][label]", $this->_create_label($data->name), $max_length. 'class="form-controls" readonly="readonly"' )
						,

						// field name
						form_input( "fields[$i][name]", $data->name, 'readonly="readonly"' ),

						$data->type.' <span class="label label-primary">primary key</span>',
						'-',
						'-',
						'-',
						'-',
						'-',
						'-'
					); // end $form[]
				}
				else
				{
					$form[] = array(
						// Number
						$i,
						
						// Field label
						form_input( "fields[$i][label]", $this->_create_label( $data->name ), $max_length. 'class="form-controls"' )
						,

						// field name
						form_input( "fields[$i][name]", $data->name, 'readonly="readonly"' ),	

						// field field type
						form_input( "fields[$i][field_type]", $data->type, 'readonly="readonly"' ),				

						// Field type
						$this->_dropdown_type($i, $data->type),

						// field #id
						form_input( "fields[$i][append_id]", '' ),

						// field .class
						form_input( "fields[$i][append_class]", '' ),

						// Validation, default true
						form_checkbox( "fields[$i][validation]", '1', TRUE), 

						// List view ? default true
						form_checkbox( "fields[$i][list_view]", '1', TRUE), 

						// is search ? default true
						form_checkbox( "fields[$i][is_search]", '1', TRUE), 
					);
				}
		$i++;
		}
		// end populate form

		return $this->table->generate( $form );	
	}


	public function get_crud_configuration($table)
	{
		$query 	= $this->db->get_where('crud_table_config', array('table_name' => $table));

		if($query->num_rows() > 0)
		{
			$row = $query->row();			
		}
		else
		{
			$row = FALSE;
		}

		return $row;
	}


	/**
	 * build_controller
	 * Berfungsi untuk membuat controller
	 * @return file
	 *
	 */
	public function build_controller($get_model, $get_view, $get_controller, $get_table, $get_field, $get_title)
	{
		$this->load->library('parser');
		$class_name = ucfirst($get_controller);
		$data = array(
			'php_open'		=> '<?php',
			'php_close'		=> '?>',
			'title_name'	=> $get_title,
			'class_name'	=> $class_name,
			'model_name'	=> $get_model,
			'view_folder'	=> $get_view,
			'controller_name' => strtolower($get_controller),
			'table_name'	=> $get_table,
			'list_fields'	=> $this->populate_field_controller($get_table, $get_field)
			);
		$source_template = $this->parser->parse('generator/template/controller', $data, TRUE);
		$build = write_file(APPPATH.'controllers/'.$class_name.'.php', $source_template);
		if($build === TRUE)
		{
			$this->session->set_flashdata('action_status', '<div class="alert alert-success">Controller '.$get_controller.' berhasil di buat</div>');
		}
		else
		{
			$this->session->set_flashdata('action_status', '<div class="alert alert-danger">Controller '.$get_controller.' gagal di buat</div>');
		}
	}

	public function build_model($get_model, $get_view, $get_controller, $get_table, $get_field, $get_title)
	{
		$this->load->library('parser');
		$class_name = ucfirst($get_controller);
		$get_primary_key = $this->get_primary_key($get_table);
		$data = array(
			'php_open'		=> '<?php',
			'php_close'		=> '?>',
			'primary_key'	=> $get_primary_key,
			'title_name'	=> $get_title,
			'class_name'	=> $class_name,
			'model_name'	=> $get_model,
			'view_folder'	=> $get_view,
			'controller_name' => strtolower($get_controller),
			'table_name'	=> $get_table,
			'list_fields'	=> $get_field
			);

		// **********************************
		$source_template = $this->parser->parse('generator/template/model', $data, TRUE);

		$build = write_file(APPPATH.'models/'.$get_model.'.php', $source_template);
		if($build === TRUE)
		{
			$this->session->set_flashdata('action_status', '<div class="alert alert-success">Model '.$get_model.' berhasil di buat</div>');
		}
		else
		{
			$this->session->set_flashdata('action_status', '<div class="alert alert-danger">Model '.$get_model.' gagal di buat</div>');
		}
	}

	public function build_add_list($get_model, $get_view, $get_controller, $get_table, $get_field, $get_title)
	{
		$this->load->library('parser');
		$get_primary_key = $this->get_primary_key($get_table);
		$data = array(
			'php_open'		=> '<?php',
			'php_close'		=> '?>',
			'primary_key'	=> $get_primary_key,
			'title_name'	=> $get_title,
			'class_name'	=> ucfirst($class_name),
			'model_name'	=> $get_model,
			'view_folder'	=> $get_view,
			'controller_name' => strtolower($get_controller),
			'table_name'	=> $get_table,
			'add_form'	=> $this->populate_view_add($get_table, $get_field)
			);
		$source_template = $this->parser->parse('generator/template/form_view/add', $data, TRUE);
		$folder_view = $this->view_path_folder.$get_view;
		if(is_dir($folder_view) === FALSE)
		{
			@mkdir($folder_view, DIR_WRITE_MODE, TRUE);
		}
		$build = write_file(APPPATH.'views/backend/'.$get_view.'/add.php', $source_template);
		if($build === TRUE)
		{
			echo 'add view '.$get_view.' berhasil di buat'."<br/>";
		}
		else
		{
			echo 'add view '.$get_view.' gagal di buat'."<br/>";		
		}
	}


	/**
	 * build_update_list
	 * Berfungsi untuk membuat view update
	 * @return file
	 *
	 */
	public function build_update_list($get_model, $get_view, $get_controller, $get_table, $get_field, $get_title)
	{
		$this->load->library('parser');

		$class_name = ucfirst($get_controller);

		$get_primary_key = $this->get_primary_key($get_table);

		$data = array(
			'php_open'		=> '<?php',
			'php_close'		=> '?>',
			'primary_key'	=> $get_primary_key,
			'title_name'	=> $get_title,
			'class_name'	=> $class_name,
			'model_name'	=> $get_model,
			'view_folder'	=> $get_view,
			'controller_name' => strtolower($get_controller),
			'table_name'	=> $get_table,
			'update_form'	=> $this->populate_view_update($get_table, $get_field)
			);

		$source_template = $this->parser->parse('generator/template/form_view/edit', $data, TRUE);

		$folder_view = $this->view_path_folder.$get_view;

		if(is_dir($folder_view) === FALSE)
		{
			@mkdir($folder_view, DIR_WRITE_MODE, TRUE);
		}

		$build = write_file($folder_view.'/edit.php', $source_template);

		if($build === TRUE)
		{
			echo 'edit view '.$get_view.' berhasil di buat'."<br/>";
		}
		else
		{
			echo 'edit view '.$get_view.' gagal di buat'."<br/>";		
		}
	}



	/**
	 * build_view_list
	 * Berfungsi untuk membuat view lists
	 * @return file
	 *
	 */
	public function build_view_list($get_model, $get_view, $get_controller, $get_table, $get_field, $get_title)
	{
		$this->load->library('parser');
		$this->load->helper('file');
		#$class_name = ucfirst($get_controller);
		$get_primary_key = $this->get_primary_key($get_table);
		$data = array(
			'php_open'		=> '<?php',
			'php_close'		=> '?>',
			'primary_key'	=> $get_primary_key,
			'title_name'	=> $get_title,
			'class_name'	=> ucfirst($class_name),
			'model_name'	=> $get_model,
			'view_folder'	=> $get_view,
			'controller_name' => strtolower($get_controller),
			'table_name'	=> $get_table,
			'list_fields'	=> $this->populate_view_list($get_table, $get_field)
			);

		$source_template = $this->parser->parse('generator/template/form_view/lists', $data, TRUE);
		$folder_view = $this->view_path_folder.$get_view;
		// jika folder view tidak tersedia, buatkan
		if(is_dir($folder_view) === FALSE)
		{
			@mkdir($folder_view, DIR_WRITE_MODE, TRUE);
		}

		// buat nama list view
		$build = write_file($folder_view.'/lists.php', $source_template);

		// jika create list view berhasil, return session berhasil
		if($build === TRUE)
		{
			$this->session->set_flashdata('action_status', '<div class="alert alert-success">view '.$get_view.' berhasil di buat</div>');
		}
		else
		{
			$this->session->set_flashdata('action_status', '<div class="alert alert-danger">view '.$get_view.' gagal di buat</div>');
		}
	}

	private function populate_field_controller($table, $fields)
	{
		$field_array = array();
		
		$get_primary_key = $this->get_primary_key($table);

		$i = 1;
		foreach ($fields as $key) {
			if($key['name'] != $get_primary_key)
			{
				$field_array[$i]['label'] = $key['label'];
				$field_array[$i]['name'] = $key['name'];
				$field_array[$i]['field_type'] = $key['field_type'];
				$field_array[$i]['validation'] = $key['validation'];
				#$field_array[$i]['list_view'] = $key['list_view'];

				if($key['validation'] == 1)
				{
					$field_array[$i]['rules'] = 'trim|required';					
				}
				else
				{
					$field_array[$i]['rules'] = 'trim';					
				}
			}
		$i++;
		}

		return $field_array;
	}

	private function populate_view_list($table, $fields)
	{
		$field_array = array();
		
		$get_primary_key = $this->get_primary_key($table);

		$i = 1;
		foreach ($fields as $key) {
			
			if($key['name'] != $get_primary_key)
			{
				if(isset($key['list_view']))
				{
					$field_array[$i]['php_open'] 	= '<?php';
					$field_array[$i]['php_close'] 	= '?>';
					$field_array[$i]['label'] 		= $key['label'];
					$field_array[$i]['name'] 		= $key['name'];
					$field_array[$i]['field_type'] 	= $key['field_type'];
					$field_array[$i]['validation'] 	= $key['validation'];
					$field_array[$i]['list_view'] 	= $key['list_view'];
				}
			}

		$i++;
		}

		return $field_array;
	}

	private function view_add_form($name, $field_type, $validation, $append_id = null, $append_class = null)
	{
		$add_form = '';

		if($validation == 1)
		{
			$required = 'required="required"';
		}
		else
		{
			$required = '';
		}

		switch ($field_type) {

			case 'input':
				$add_form = '<input type="text" name="'.$name.'" value="<?php echo set_value(\''.$name.'\'); ?>"  class="form-control '.$append_class.'" id="'.$name.' '.$append_id.'" '.$required.' />';
				break;

			case 'password':
				$add_form = '<input type="password" name="'.$name.'" value="<?php echo set_value(\''.$name.'\'); ?>"  class="form-control '.$append_class.'" id="'.$name.' '.$append_id.'" '.$required.' />';
				break;

			case 'file':
				$add_form = '<input type="file" name="'.$name.'" value="<?php echo set_value(\''.$name.'\'); ?>"  class="form-control '.$append_class.'" id="'.$name.' '.$append_id.'" '.$required.' />';
				break;

			case 'textarea':
				$add_form = '<textarea name="'.$name.'" class="form-control '.$append_class.'" id="'.$name.' '.$append_id.'" '.$required.'><?php echo set_value(\''.$name.'\'); ?></textarea>';
				break;
			
			default:
				$add_form = '<input type="text" name="'.$name.'" value="<?php echo set_value(\''.$name.' '.$append_id.'\'); ?>"  class="form-control '.$append_class.'" id="'.$name.'" '.$required.' />';

				break;
		}

		return $add_form;
	}

	private function view_update_form($name, $field_type, $validation, $append_id = null, $append_class = null)
	{
		$update_form = '';

		if($validation == 1)
		{
			$required = 'required="required"';
		}
		else
		{
			$required = '';
		}

		switch ($field_type) {

			case 'input':
				$update_form = '<input type="text" name="'.$name.'" value="<?php echo $row->'.$name.'; ?>"  class="form-control '.$append_class.'" id="'.$name.' '.$append_id.'" '.$required.' />';
				break;

			case 'password':
				$update_form = '<input type="password" name="'.$name.'" value="<?php echo row->'.$name.'; ?>"  class="form-control '.$append_class.'" id="'.$name.' '.$append_id.'" '.$required.' />';
				break;

			case 'file':
				$update_form = '<input type="file" name="'.$name.'" value="<?php echo row->'.$name.'; ?>"  class="form-control '.$append_class.'" id="'.$name.' '.$append_id.'" '.$required.' />';
				break;

			case 'textarea':
				$update_form = '<textarea name="'.$name.'" class="form-control '.$append_class.'" id="'.$name.' '.$append_id.'" '.$required.'><?php echo $row->'.$name.'; ?></textarea>';
				break;
			
			default:
				$update_form = '<input type="text" name="'.$name.'" value="<?php echo row->'.$name.'; ?>"  class="form-control '.$append_class.'" id="'.$name.' '.$append_id.'" '.$required.' />';

				break;
		}

		return $update_form;
	}

	private function populate_view_add($table, $fields)
	{
		$field_array = array();
		
		$get_primary_key = $this->get_primary_key($table);

		$i = 1;
		foreach ($fields as $key) {

			if($key['name'] != $get_primary_key)
			{
				$field_array[$i]['php_open'] = '<?php';
				$field_array[$i]['php_close'] = '?>';
				$field_array[$i]['label'] = $key['label'];
				$field_array[$i]['name'] = $key['name'];
				$field_array[$i]['field_type'] = $key['field_type'];
				$field_array[$i]['validation'] = $key['validation'];
				#$field_array[$i]['list_view'] = $key['list_view'];
				$field_array[$i]['input_form'] = $this->view_add_form($key['name'], $key['dropdown_type'], $key['validation'], $key['append_id'], $key['append_class']);


				if($key['validation'] == 1)
				{
					$field_array[$i]['label_required'] = 'required';					
				}				
			}

		$i++;
		}

		return $field_array;
	}

	private function populate_view_update($table, $fields)
	{
		$field_array = array();
		
		$get_primary_key = $this->get_primary_key($table);

		$i = 1;
		foreach ($fields as $key) {

			if($key['name'] != $get_primary_key)
			{
				$field_array[$i]['php_open'] = '<?php';
				$field_array[$i]['php_close'] = '?>';
				$field_array[$i]['label'] = $key['label'];
				$field_array[$i]['name'] = $key['name'];
				$field_array[$i]['field_type'] = $key['field_type'];
				$field_array[$i]['validation'] = $key['validation'];
				#$field_array[$i]['list_view'] = $key['list_view'];
				$field_array[$i]['update_input'] = $this->view_update_form($key['name'], $key['dropdown_type'], $key['validation'], $key['append_id'], $key['append_class']);

				if($key['validation'] == 1)
				{
					$field_array[$i]['label_required'] = 'required';					
				}				
			}

		$i++;
		}

		return $field_array;

		/*
		= hasil get fields
	            [name] => id
	            [type] => int
	            [max_length] => 11
	            [default] => 
	            [primary_key] => 1
		
		= hasil post fields
	    [2] => Array
	        (
	            [label] => Name
	            [name] => name
	            [field_type] => varchar
	            [dropdown_type] => input
	            [validation] => 1
	            [list_view] => 1
	        )
		*/
	}
}
?>