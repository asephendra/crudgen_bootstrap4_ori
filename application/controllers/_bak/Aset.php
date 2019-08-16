<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Aset extends Admin_Controller 
{
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
    /* 
    * It only redirects to the manage product page
    */
	public function index()
	{
        if(!in_array('viewProduct', $this->permission)) {
            redirect('dashboard', 'refresh');
        }
		$this->render_template('aset/index', $this->data);	
	}
    /*
    * It Fetches the products data from the product table 
    * this function is called from the datatable ajax function
    */
	public function fetchAsetData()
	{
		$result = array('data' => array());
		$data = $this->model_aset->getAsetData();
		foreach ($data as $key => $value) {
            $barang_data = $this->model_products->getBarangData($value['barang_id']);
            $kelompok = $this->model_kelompok->getKelompokData($value['kelompok_id']);
            $date = date('d-m-Y', $value['buy_date']);
            // button
            $buttons = '';
            if(in_array('updateProduct', $this->permission)) {
    			$buttons .= '<a href="'.base_url('products/update/'.$value['id']).'" class="btn btn-default"><i class="fa fa-pencil"></i></a>';
            }
            if(in_array('deleteProduct', $this->permission)) { 
    			$buttons .= ' <button type="button" class="btn btn-default" onclick="removeFunc('.$value['id'].')" data-toggle="modal" data-target="#removeModal">
                <i class="fa fa-trash"></i></button>';
            }

            if($value['status']==1){
                $status = '<span class="label label-success">Available</span>';

            } elseif($value['status']==2) {
                $status = '<span class="label label-info">Dipakai</span>';
            } else {
                $status = '<span class="label label-warning">Rusak</span>';
            }
            if($value['lokasi_id']!=''){
                $cek = $this->model_stores->getStoresData($value['lokasi_id']);
                $cbg = $this->model_stores->getCabangData($value['cabang_id']);
                $lokasi= $cbg['name']. ' -> ' .$cek['name'];
            } else {
                $lokasi = '<span class="label label-success">Available</span>';
            }
			$result['data'][$key] = array(
				$value['barcode'],
                $barang_data['name'],
                $lokasi,
                $kelompok['name'],
                $value['rate'],
                $date,
                $status,
                $buttons                
			);
		} // /foreach
		echo json_encode($result);
	}	
    /*
    * If the validation is not valid, then it redirects to the create page.
    * If the validation for each input field is valid then it inserts the data into the database 
    * and it stores the operation message into the session flashdata and display on the manage product page
    */
    public function penempatan()
    {
        if(!in_array('viewProduct', $this->permission)) {
            redirect('dashboard', 'refresh');
        }
        $this->render_template('aset/penempatan', $this->data);  
    }

    public function fetchPenempatanData()
    {
        $result = array('data' => array());
        $data = $this->model_aset->getPenempatanData();
        foreach ($data as $key => $value) {
            $cabang = $this->model_stores->getCabangData($value['cabang_id']);
            $lokasi = $this->model_stores->getStoresData($value['lokasi_id']);
            $date = date('d-m-Y', $value['trans_date']);
            // button
            // $buttons = '';
            // if(in_array('updateProduct', $this->permission)) {
            //     $buttons .= '<a href="'.base_url('products/update/'.$value['id']).'" class="btn btn-default"><i class="fa fa-pencil"></i></a>';
            // }
            // if(in_array('deleteProduct', $this->permission)) { 
            //     $buttons .= ' <button type="button" class="btn btn-default" onclick="removeFunc('.$value['id'].')" data-toggle="modal" data-target="#removeModal">
            //     <i class="fa fa-trash"></i></button>';
            // }
            $result['data'][$key] = array(
                $value['trans_no'],
                $date,
                $cabang['name'],
                $lokasi['name'],
                $value['total'],
                $value['user_id'],
                // $buttons                
            );
        } // /foreach
        echo json_encode($result);
    }   


    public function create()
    {
        if(!in_array('createOrder', $this->permission)) {
            redirect('dashboard', 'refresh');
        }
        $this->data['page_title'] = 'Add Aset';
        $this->form_validation->set_rules('buyer_name', 'Buyer name', 'trim|required');
        $this->form_validation->set_rules('product[]', 'Product name', 'trim|required');
        $this->form_validation->set_rules('rate[]', 'Rate', 'trim|required');
        $this->form_validation->set_rules('qty[]', 'Quantity', 'trim|required');
        if ($this->form_validation->run() == TRUE) {  
                  
            $order_id = $this->model_aset->create();
            if($order_id) {
                $this->session->set_flashdata('success', 'Successfully created');
                redirect('aset', 'refresh');
            }
            else {
                $this->session->set_flashdata('success', 'Successfully created');
                redirect('aset', 'refresh');
            }
        }
        else {
            // false case
            $company = $this->model_company->getCompanyData(1);
            $this->data['company_data'] = $company;
            $this->data['is_vat_enabled'] = ($company['vat_charge_value'] > 0) ? true : false;
            $this->data['is_service_enabled'] = ($company['service_charge_value'] > 0) ? true : false;
            $this->data['barang'] = $this->model_products->getActiveBarangData();       
            $this->render_template('aset/create', $this->data);
        }   
    }

    public function designation()
    {
        $this->data['page_title'] = 'Penempatan Aset';
        $this->form_validation->set_rules('cabang', 'Cabang name', 'trim|required');
        $this->form_validation->set_rules('lokasi', 'Lokasi name', 'trim|required');
        if ($this->form_validation->run() == TRUE) {  
            $trans_id = $this->model_aset->designation();
            if($trans_id) {
                $this->session->set_flashdata('success', 'Successfully created');
                redirect('aset', 'refresh');
            }
            else {
                $this->session->set_flashdata('success', 'Successfully created');
                redirect('aset', 'refresh');
            }
        }
        else {
            $company = $this->model_company->getCompanyData(1);
            $this->data['company_data'] = $company;
            $this->data['is_vat_enabled'] = ($company['vat_charge_value'] > 0) ? true : false;
            $this->data['is_service_enabled'] = ($company['service_charge_value'] > 0) ? true : false;
            $this->data['aset'] = $this->model_aset->getActiveAsetData();       
            $this->render_template('aset/designation', $this->data);
        }   
    }


    public function getAsetValueById()
    {
        $product_id = $this->input->post('product_id');
        if($product_id) {
            $product_data = $this->model_aset->getAsetData($product_id);
            echo json_encode($product_data);
        }
    }

    /*
    * It gets the all the active product inforamtion from the product table 
    * This function is used in the order page, for the product selection in the table
    * The response is return on the json format.
    */
    public function getTableAsetRow()
    {
        $products = $this->model_aset->getActiveAsetData();
        echo json_encode($products);
    }

    /*
    * This function is invoked from another function to upload the image into the assets folder
    * and returns the image path
    */
	public function upload_image()
    {
    	// assets/images/product_image
        $config['upload_path'] = 'assets/images/product_image';
        $config['file_name'] =  uniqid();
        $config['allowed_types'] = 'gif|jpg|png';
        $config['max_size'] = '1000';

        // $config['max_width']  = '1024';s
        // $config['max_height']  = '768';

        $this->load->library('upload', $config);
        if ( ! $this->upload->do_upload('product_image'))
        {
            $error = $this->upload->display_errors();
            return $error;
        }
        else
        {
            $data = array('upload_data' => $this->upload->data());
            $type = explode('.', $_FILES['product_image']['name']);
            $type = $type[count($type) - 1];
            
            $path = $config['upload_path'].'/'.$config['file_name'].'.'.$type;
            return ($data == true) ? $path : false;            
        }
    }

    /*
    * If the validation is not valid, then it redirects to the edit product page 
    * If the validation is successfully then it updates the data into the database 
    * and it stores the operation message into the session flashdata and display on the manage product page
    */
	public function update($product_id)
	{      
        if(!in_array('updateProduct', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        if(!$product_id) {
            redirect('dashboard', 'refresh');
        }
        $this->form_validation->set_rules('product_name', 'Product name', 'trim|required');
        $this->form_validation->set_rules('sku', 'SKU', 'trim|required');
        $this->form_validation->set_rules('price', 'Price', 'trim|required');
        $this->form_validation->set_rules('qty', 'Qty', 'trim|required');
        $this->form_validation->set_rules('store', 'Store', 'trim|required');
        $this->form_validation->set_rules('availability', 'Availability', 'trim|required');
        if ($this->form_validation->run() == TRUE) {
            // true case
            $data = array(
                'name' => $this->input->post('product_name'),
                'sku' => $this->input->post('sku'),
                'price' => $this->input->post('price'),
                'qty' => $this->input->post('qty'),
                'description' => $this->input->post('description'),
                'attribute_value_id' => json_encode($this->input->post('attributes_value_id')),
                'brand_id' => json_encode($this->input->post('brands')),
                'category_id' => json_encode($this->input->post('category')),
                'store_id' => $this->input->post('store'),
                'availability' => $this->input->post('availability'),
            );

            
            if($_FILES['product_image']['size'] > 0) {
                $upload_image = $this->upload_image();
                $upload_image = array('image' => $upload_image);
                
                $this->model_products->update($upload_image, $product_id);
            }

            $update = $this->model_products->update($data, $product_id);
            if($update == true) {
                $this->session->set_flashdata('success', 'Successfully updated');
                redirect('products/', 'refresh');
            }
            else {
                $this->session->set_flashdata('errors', 'Error occurred!!');
                redirect('products/update/'.$product_id, 'refresh');
            }
        }
        else {
            // attributes 
            $attribute_data = $this->model_attributes->getActiveAttributeData();

            $attributes_final_data = array();
            foreach ($attribute_data as $k => $v) {
                $attributes_final_data[$k]['attribute_data'] = $v;
                $value = $this->model_attributes->getAttributeValueData($v['id']);
                $attributes_final_data[$k]['attribute_value'] = $value;
            }
          
            // false case
            $this->data['attributes'] = $attributes_final_data;
            $this->data['brands'] = $this->model_brands->getActiveBrands();         
            $this->data['category'] = $this->model_category->getActiveCategroy();           
            $this->data['stores'] = $this->model_stores->getActiveStore();          

            $product_data = $this->model_products->getProductData($product_id);
            $this->data['product_data'] = $product_data;
            $this->render_template('products/edit', $this->data); 
        }   
	}

    /*
    * It removes the data from the database
    * and it returns the response into the json format
    */
	public function remove()
	{
        if(!in_array('deleteProduct', $this->permission)) {
            redirect('dashboard', 'refresh');
        }
        
        $product_id = $this->input->post('product_id');

        $response = array();
        if($product_id) {
            $delete = $this->model_products->remove($product_id);
            if($delete == true) {
                $response['success'] = true;
                $response['messages'] = "Successfully removed"; 
            }
            else {
                $response['success'] = false;
                $response['messages'] = "Error in the database while removing the product information";
            }
        }
        else {
            $response['success'] = false;
            $response['messages'] = "Refersh the page again!!";
        }

        echo json_encode($response);
	}

    function get_lokasi()
    {
        $cabang = $this->input->post('cabang');
        $lokasi = $this->db->get_where('stores', array('cabang_id' => $cabang))->result_array();
        foreach ($lokasi as $row) {
            echo '<option value="' . $row['id'] . '">' . $row['name'] . '</option>';
        }
    }

}