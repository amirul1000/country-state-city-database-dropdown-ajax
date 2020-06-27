<?php

 /**
 * Author: Amirul Momenin
 * Desc:Store Controller
 *
 */
class Store extends CI_Controller{
    function __construct(){
        parent::__construct();
        $this->load->helper('url'); 
		$this->load->helper('form');
		$this->load->library('session');
		$this->load->library('pagination');
		$this->load->library('Customlib');
		$this->load->helper(array('cookie', 'url')); 
		$this->load->database();  
		$this->load->model('Store_model');
		if(! $this->session->userdata('validated')){
				redirect('admin/login/index');
		}  
    } 
	
    /**
	 * Index Page for this controller.
	 *@param $start - Starting of store table's index to get query
	 *
	 */
    function index($start=0){
		$limit = 10;
        $data['store'] = $this->Store_model->get_limit_store($limit,$start);
		//pagination
		$config['base_url'] = site_url('admin/store/index');
		$config['total_rows'] = $this->Store_model->get_count_store();
		$config['per_page'] = 10;
		//Bootstrap 4 Pagination fix
		$config['full_tag_open']    = '<div class="pagging text-center"><nav><ul class="pagination">';
		$config['full_tag_close']   = '</ul></nav></div>';
		$config['num_tag_open']     = '<li class="page-item"><span class="page-link">';
		$config['num_tag_close']    = '</span></li>';
		$config['cur_tag_open']     = '<li class="page-item active"><span class="page-link">';
		$config['cur_tag_close']    = '<span class="sr-only">(current)</span></span></li>';
		$config['next_tag_open']    = '<li class="page-item"><span class="page-link">';
		$config['next_tag_close']   = '<span aria-hidden="true"></span></span></li>';
		$config['next_tag_close']   = '<span aria-hidden="true">&raquo;</span></span></li>';
		$config['prev_tag_open']    = '<li class="page-item"><span class="page-link">';
		$config['prev_tag_close']   = '</span></li>';
		$config['first_tag_open']   = '<li class="page-item"><span class="page-link">';
		$config['first_tag_close']  = '</span></li>';
		$config['last_tag_open']    = '<li class="page-item"><span class="page-link">';
		$config['last_tag_close']   = '</span></li>';		
		$this->pagination->initialize($config);
        $data['link'] =$this->pagination->create_links();
		
        $data['_view'] = 'admin/store/index';
        $this->load->view('layouts/admin/body',$data);
    }
	
	 /**
     * Save store
	 *@param $id - primary key to update
	 *
     */
    function save($id=-1){   
		 
		
		
		$params = array(
					 'country_id' => html_escape($this->input->post('country_id')),
'state_id' => html_escape($this->input->post('state_id')),
'city_id' => html_escape($this->input->post('city_id')),

				);
		 
		 
		$data['id'] = $id;
		//update		
        if(isset($id) && $id>0){
			$data['store'] = $this->Store_model->get_store($id);
            if(isset($_POST) && count($_POST) > 0){   
                $this->Store_model->update_store($id,$params);
				$this->session->set_flashdata('msg','Store has been updated successfully');
                redirect('admin/store/index');
            }else{
                $data['_view'] = 'admin/store/form';
                $this->load->view('layouts/admin/body',$data);
            }
        } //save
		else{
			if(isset($_POST) && count($_POST) > 0){   
                $store_id = $this->Store_model->add_store($params);
				$this->session->set_flashdata('msg','Store has been saved successfully');
                redirect('admin/store/index');
            }else{  
			    $data['store'] = $this->Store_model->get_store(0);
                $data['_view'] = 'admin/store/form';
                $this->load->view('layouts/admin/body',$data);
            }
		}
        
    } 
	
	
  function state($country_id){
	    $this->load->database(); 
        $this->db->where('country_id', $country_id);
        $res = $this->db->get_where('state')->result_array();
        $db_error = $this->db->error();
        if (! empty($db_error['code'])) {
            echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
            exit();
        }
	    echo json_encode($res);
  }
  
  function city($state_id){
	    $this->load->database();
        $this->db->where('state_id', $state_id);
        $res = $this->db->get_where('city')->result_array();
        $db_error = $this->db->error();
        if (! empty($db_error['code'])) {
            echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
            exit();
        }
	    echo json_encode($res);
  }
	
	/**
     * Details store
	 * @param $id - primary key to get record
	 *
     */
	function details($id){
        $data['store'] = $this->Store_model->get_store($id);
		$data['id'] = $id;
        $data['_view'] = 'admin/store/details';
        $this->load->view('layouts/admin/body',$data);
	}
	
    /**
     * Deleting store
	 * @param $id - primary key to delete record
	 *
     */
    function remove($id){
        $store = $this->Store_model->get_store($id);

        // check if the store exists before trying to delete it
        if(isset($store['id'])){
            $this->Store_model->delete_store($id);
			$this->session->set_flashdata('msg','Store has been deleted successfully');
            redirect('admin/store/index');
        }
        else
            show_error('The store you are trying to delete does not exist.');
    }
	
	/**
     * Search store
	 * @param $start - Starting of store table's index to get query
     */
	function search($start=0){
		if(!empty($this->input->post('key'))){
			$key =$this->input->post('key');
			$_SESSION['key'] = $key;
		}else{
			$key = $_SESSION['key'];
		}
		
		$limit = 10;		
		$this->db->like('id', $key, 'both');
$this->db->or_like('country_id', $key, 'both');
$this->db->or_like('state_id', $key, 'both');
$this->db->or_like('city_id', $key, 'both');


		$this->db->order_by('id', 'desc');
		
        $this->db->limit($limit,$start);
        $data['store'] = $this->db->get('store')->result_array();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		
		//pagination
		$config['base_url'] = site_url('admin/store/search');
		$this->db->reset_query();		
		$this->db->like('id', $key, 'both');
$this->db->or_like('country_id', $key, 'both');
$this->db->or_like('state_id', $key, 'both');
$this->db->or_like('city_id', $key, 'both');

		$config['total_rows'] = $this->db->from("store")->count_all_results();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		$config['per_page'] = 10;
		// Bootstrap 4 Pagination fix
		$config['full_tag_open']    = '<div class="pagging text-center"><nav><ul class="pagination">';
		$config['full_tag_close']   = '</ul></nav></div>';
		$config['num_tag_open']     = '<li class="page-item"><span class="page-link">';
		$config['num_tag_close']    = '</span></li>';
		$config['cur_tag_open']     = '<li class="page-item active"><span class="page-link">';
		$config['cur_tag_close']    = '<span class="sr-only">(current)</span></span></li>';
		$config['next_tag_open']    = '<li class="page-item"><span class="page-link">';
		$config['next_tag_close']   = '<span aria-hidden="true"></span></span></li>';
		$config['next_tag_close']   = '<span aria-hidden="true">&raquo;</span></span></li>';
		$config['prev_tag_open']    = '<li class="page-item"><span class="page-link">';
		$config['prev_tag_close']   = '</span></li>';
		$config['first_tag_open']   = '<li class="page-item"><span class="page-link">';
		$config['first_tag_close']  = '</span></li>';
		$config['last_tag_open']    = '<li class="page-item"><span class="page-link">';
		$config['last_tag_close']   = '</span></li>';
		$this->pagination->initialize($config);
        $data['link'] =$this->pagination->create_links();
		
		$data['key'] = $key;
		$data['_view'] = 'admin/store/index';
        $this->load->view('layouts/admin/body',$data);
	}
	
    /**
     * Export store
	 * @param $export_type - CSV or PDF type 
     */
	function export($export_type='CSV'){
	  if($export_type=='CSV'){	
		   // file name 
		   $filename = 'store_'.date('Ymd').'.csv'; 
		   header("Content-Description: File Transfer"); 
		   header("Content-Disposition: attachment; filename=$filename"); 
		   header("Content-Type: application/csv; ");
		   // get data 
		   $this->db->order_by('id', 'desc');
		   $storeData = $this->Store_model->get_all_store();
		   // file creation 
		   $file = fopen('php://output', 'w');
		   $header = array("Id","Country Id","State Id","City Id"); 
		   fputcsv($file, $header);
		   foreach ($storeData as $key=>$line){ 
			 fputcsv($file,$line); 
		   }
		   fclose($file); 
		   exit; 
	  }else if($export_type=='Pdf'){
		    $this->db->order_by('id', 'desc');
		    $store = $this->db->get('store')->result_array();
		   // get the HTML
			ob_start();
			include(APPPATH.'views/admin/store/print_template.php');
			$html = ob_get_clean();
			include(APPPATH."third_party/mpdf60/mpdf.php");					
			$mpdf=new mPDF('','A4'); 
			//$mpdf=new mPDF('c','A4','','',32,25,27,25,16,13); 
			//$mpdf->mirrorMargins = true;
		    $mpdf->SetDisplayMode('fullpage');
			//==============================================================
			$mpdf->autoScriptToLang = true;
			$mpdf->baseScript = 1;	// Use values in classes/ucdn.php  1 = LATIN
			$mpdf->autoVietnamese = true;
			$mpdf->autoArabic = true;
			$mpdf->autoLangToFont = true;
			$mpdf->setAutoBottomMargin = 'stretch';
			$stylesheet = file_get_contents(APPPATH."third_party/mpdf60/lang2fonts.css");
			$mpdf->WriteHTML($stylesheet,1);
			$mpdf->WriteHTML($html);
			//$mpdf->AddPage();
			$mpdf->Output($filePath);
			$mpdf->Output();
			//$mpdf->Output( $filePath,'S');
			exit;	
	  }
	   
	}
}
//End of Store controller