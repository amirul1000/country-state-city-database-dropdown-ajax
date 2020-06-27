<?php

/**
 * Author: Amirul Momenin
 * Desc:Store Model
 */
class Store_model extends CI_Model
{
	protected $store = 'store';
	
    function __construct(){
        parent::__construct();
    }
	
    /** Get store by id
	 *@param $id - primary key to get record
	 *
     */
    function get_store($id){
        $result = $this->db->get_where('store',array('id'=>$id))->row_array();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    } 
	
    /** Get all store
	 *
     */
    function get_all_store(){
        $this->db->order_by('id', 'desc');
        $result = $this->db->get('store')->result_array();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    }
	
	/** Get limit store
	 *@param $limit - limit of query , $start - start of db table index to get query
	 *
     */
    function get_limit_store($limit, $start){
		$this->db->order_by('id', 'desc');
        $this->db->limit($limit, $start);
        $result = $this->db->get('store')->result_array();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    }
	
    /** Count store rows
	 *
     */
	function get_count_store(){
       $result = $this->db->from("store")->count_all_results();
	   $db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    }
	
    /** function to add new store
	 *@param $params - data set to add record
	 *
     */
    function add_store($params){
        $this->db->insert('store',$params);
        $id = $this->db->insert_id();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $id;
    }
	
    /** function to update store
	 *@param $id - primary key to update record,$params - data set to add record
	 *
     */
    function update_store($id,$params){
        $this->db->where('id',$id);
        $status = $this->db->update('store',$params);
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $status;
    }
	
    /** function to delete store
	 *@param $id - primary key to delete record
	 *
     */
    function delete_store($id){
        $status = $this->db->delete('store',array('id'=>$id));
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $status;
    }
}
