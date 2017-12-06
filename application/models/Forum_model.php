<?php
class Forum_model extends CI_Model {

	function getAllData($table){
		$query = $this->db->select('*')
			->from($table)
			->get();
		return ($query->num_rows <= 0)? false : $query->result_array();
	}
	function insert($data, $table){
		$query = $this->db->insert($data, $table);
	}

	function getById($where, $table){
		$query = $this->db->select('*')
			->from($table)
			->where($where)
			->limit(1)
			->get();
		return ($query->num_rows <= 0)? false : $query->result_array();
	}

	function matchId($where, $table){
		$query = $this->db->select('*')
			->from($table)
			->where($where)
			->limit(1)
			->get();
		return ($query->num_rows <= 0)? true : false;	
	}

	function destroy($where, $table){
		$this->db->where($where);
		$this->db->delete($table);
	}
}