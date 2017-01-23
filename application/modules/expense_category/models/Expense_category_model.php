<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Expense_category_model extends CI_Model {       
	function __construct(){            
    parent::__construct();
    $this->load->database();
		$this->user_id =isset($this->session->get_userdata()['user_details'][0]->id)?$this->session->get_userdata()['user_details'][0]->id:'1';
	} 
	
	/**
      * This function is get table data by id
      * @param : $id is value of expense_category_id
      */
	public function Get_data_id($id='') {
		 $this->db->select('*');
		 $this->db->from('expense_category');
		 $this->db->where('expense_category_id' , $id);
		 $query = $this->db->get();
		 return $result = $query->row();
	}
	
	/**
      * This function is get data for front end datatable
      * @param : $con is where condition for select query
      */
	public function get_data($con=NULL) {
		$sql = "SELECT * FROM  `expense_category` ";
		if($con != '') {
			$sql .= ' WHERE '.$con;	
		}
		$qr = $this->db->query($sql);
		return $qr->result();
	}

	/**
      * This function is used to delete record from table
      * @param : $id record id which you want to delete
      */
	public function delete_data($id='') {
		$this->db->where('expense_category_id', $id);
    	$this->db->delete('expense_category');
	}

	/**
      * This function is used to Insert Record in table
      * @param : $table - table name in which you want to insert record 
      * @param : $data - record array 
      */
	public function insertRow($table, $data){
	  	$this->db->insert($table, $data);
	  	return  $this->db->insert_id();
	}

	/**
      * This function is used to Update Record in table
      * @param : $table - table name in which you want to update record 
      * @param : $col - field name for where clause 
      * @param : $colVal - field value for where clause 
      * @param : $data - updated array 
      */
  	public function updateRow($table, $col, $colVal, $data) {
  		$this->db->where($col,$colVal);
		$this->db->update($table,$data);
		return true;
  	}
}?>