<?php defined("BASEPATH") OR exit("No direct script access allowed");

class Income_category extends CI_Controller {
  	function __construct() {
	    parent::__construct();
	    $this->load->model("Income_category_model"); 
		if(true==1){
			is_login(); 
			$this->user_id =isset($this->session->get_userdata()['user_details'][0]->id)?$this->session->get_userdata()['user_details'][0]->id:'1';
		}else{ 	
			$this->user_id =1;
		}
  	}

  	/**
      * This function is used to view page
      */
  	public function index() {   
  		if(CheckPermission("income_category", "all_read,own_read")){
			$data["view_data"]= $this->Income_category_model->get_data();
			$this->load->view("include/header");
			$this->load->view("index",$data);
			$this->load->view("include/footer");
		} else {
			$this->session->set_flashdata('messagePr', 'You don\'t have permission to access.');
            redirect( base_url().'user/profile', 'refresh');
		}
  	}

  	/**
      * This function is used to Add and update data
      */
	public function add_edit() {	
		$data = $this->input->post();
		foreach($_FILES as $name => $fileInfo) {
			if(!empty($_FILES[$name]['name'])){
				$filename=$_FILES[$name]['name'];
				$tmpname=$_FILES[$name]['tmp_name']; 
				$exp=explode('.', $filename);
				$ext=end($exp);
				$newname=  $exp[0].'_'.time().".".$ext; 
				$config['upload_path'] = 'assets/images/';
				$config['upload_url'] =  base_url().'assets/images/';
				$config['allowed_types'] = "gif|jpg|jpeg|png|iso|dmg|zip|rar|doc|docx|xls|xlsx|ppt|pptx|csv|ods|odt|odp|pdf|rtf|sxc|sxi|txt|exe|avi|mpeg|mp3|mp4|3gp";
				$config['max_size'] = '2000000'; 
				$config['file_name'] = $newname;
				$this->load->library('upload', $config);
				move_uploaded_file($tmpname,"assets/images/".$newname);
				$data[$name]=$newname; 
			} else {  
				if(!empty($_POST['fileOld'])) {  
					$newname = $this->input->post('fileOld');
					$data[$name]=$newname;
				} else {
					$data[$name]='';
				} 
			} 
		}
		if($this->input->post('id')) {
			unset($data['submit']);
			unset($data['fileOld']);
			unset($data['save']);
			unset($data['id']);
			$this->Income_category_model->updateRow('income_category', 'income_category_id', $this->input->post('id'), $data);
			$this->session->set_flashdata('message', 'Your data updated Successfully..');
      		redirect('income_category');
		} else { 
			unset($data['submit']);
			unset($data['fileOld']);
			unset($data['save']);
			$data['user_id']=$this->user_id;
			$this->Income_category_model->insertRow('income_category', $data);
			$this->session->set_flashdata('message', 'Your data inserted Successfully..');
			redirect('income_category');
		}
	}
	
	/**
      * This function is used to show popup for add and update
      */
	public function get_modal() {
		if($this->input->post('id')){
			$data['data']= $this->Income_category_model->Get_data_id($this->input->post('id'));
      		echo $this->load->view('add_update', $data, true);
	    } else {
	      	echo $this->load->view('add_update', '', true);
	    }
	    exit;
	}

	
	/**
      * This function is used to delete multiple records form table
      * @param : $ids is array if record id
      */
  	public function delete($ids) {
		$idsArr = explode('-', $ids);
		foreach ($idsArr as $key => $value) {
			$this->Income_category_model->delete_data($value);		
		}
		redirect(base_url().'income_category', 'refresh');
  	}

  	/**
      * This function is used to delete single record form table
      * @param : $id is record id
      */
  	public function delete_data($id) { 
		$this->Income_category_model->delete_data($id);
	    $this->session->set_flashdata('message', 'Your data deleted Successfully..');
	    redirect('income_category');
  	}

	/**
      * This function is used to create data for server side datatable
      */
  	public function ajx_data(){
		$primaryKey = 'income_category_id';
		$table 		= 'income_category';
		$columns 	= array(
array( 'db' => 'income_category_id', 'dt' => 0 ),
array( 'db' => 'category_name', 'dt' => 1 ),
array( 'db' => 'income_category_id', 'dt' => 2 )
);
		$joinQuery 	= '';
		$aminkhan 	= '@banarsiamin@';

		$where = '';
		if($this->input->get('dateRange')) {
			$date = explode(' - ', $this->input->get('dateRange'));
			$where = " DATE_FORMAT(`$table`.`".$this->input->get('columnName')."`, '%Y/%m/%d') >= '".date('Y/m/d', strtotime($date[0]))."' AND  DATE_FORMAT(`$table`.`".$this->input->get('columnName')."`, '%Y/%m/%d') <= '".date('Y/m/d', strtotime($date[1]))."' ";
		}

		$sql_details = array(
			'user' => $this->db->username,
			'pass' => $this->db->password,
			'db'   => $this->db->database,
			'host' => $this->db->hostname
		);

		if(CheckPermission($table, "all_read")){}
		else if(CheckPermission($table, "own_read") && CheckPermission($table, "all_read")!=true){$where	.= "`$table`.`user_id`=".$this->user_id;}

		$output_arr = SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns, $joinQuery, $where);
		foreach ($output_arr['data'] as $key => $value) 
		{
			$output_arr['data'][$key][0] = '<input type="checkbox" name="selData" value="'.$output_arr['data'][$key][0].'">';
			$id = $output_arr['data'][$key][count($output_arr['data'][$key])  - 1];
			$output_arr['data'][$key][count($output_arr['data'][$key])  - 1] = '';
			if(CheckPermission($table, "all_update")){
			$output_arr['data'][$key][count($output_arr['data'][$key])  - 1] .= '<a sty id="btnEditRow" class="modalButton mClass"  href="javascript:;" type="button" data-src="'.$id.'" title="Edit"><i class="fa fa-pencil" data-id=""></i></a>';
			}else if(CheckPermission($table, "own_update") && (CheckPermission($table, "all_update")!=true)){
				$user_id =getRowByTableColomId($table,$id,'id','user_id');
				if($user_id==$this->user_id){
			$output_arr['data'][$key][count($output_arr['data'][$key])  - 1] .= '<a sty id="btnEditRow" class="modalButton mClass"  href="javascript:;" type="button" data-src="'.$id.'" title="Edit"><i class="fa fa-pencil" data-id=""></i></a>';
				}
			}
			
			if(CheckPermission($table, "all_delete")){

			$output_arr['data'][$key][count($output_arr['data'][$key])  - 1] .= '<a data-toggle="modal" class="mClass" style="cursor:pointer;"  data-target="#cnfrm_delete" title="delete" onclick="setId('.$id.', \''.$table.'\')"><i class="fa fa-trash-o" ></i></a>';}
			else if(CheckPermission($table, "own_delete") && (CheckPermission($table, "all_delete")!=true)){
				$user_id =getRowByTableColomId($table,$id,'id','user_id');
				if($user_id==$this->user_id){
			$output_arr['data'][$key][count($output_arr['data'][$key])  - 1] .= '<a data-toggle="modal" class="mClass" style="cursor:pointer;"  data-target="#cnfrm_delete" title="delete" onclick="setId('.$id.', \''.$table.'\')"><i class="fa fa-trash-o" ></i></a>';
				}
			}
		}
		echo json_encode($output_arr);
  	}

  	/**
      * This function is used to filter list view data by date range
      */
  	public function getFilterdata(){
  		$where = '';
		if($this->input->post('dateRange')) {
			$date = explode(' - ', $this->input->post('dateRange'));
			$where = " DATE_FORMAT(`income_category`.`".$this->input->post('colName')."`, '%Y/%m/%d') >= '".date('Y/m/d', strtotime($date[0]))."' AND  DATE_FORMAT(`income_category`.`".$this->input->post('colName')."`, '%Y/%m/%d') <= '".date('Y/m/d', strtotime($date[1]))."' ";
		}
		$data["view_data"]= $this->Income_category_model->get_data($where);
		echo $this->load->view("tableData",$data, true);
		die;
  	}
}
?>