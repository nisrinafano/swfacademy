<?php
class Forum_model extends CI_Model {
	function __construct() {
	parent::__construct();
	}

	function getAllData($table){
		$query = $this->db->select('*')
			->from($table)
			->get();
		return ($query->num_rows <= 0)? false : $query->result_array();
	}
	function getAllData_sort_desc($table){
		$query = $this->db->select('id_user, forum_id, timestamp, title, tags, title_slug')
			->from($table)
			->order_by('timestamp', 'DESC')
			->get();
		return ($query->num_rows() <= 0)? false : $query->result_array();
	}
	function insert($data, $table){
		$query = $this->db->insert($table, $data);
		if ($query) {
			return true;
		}
	}

	function getById($where, $table){
		$query = $this->db->select('*')
			->from($table)
			->where($where)
			->limit(1)
			->get();
		return ($query->num_rows() <= 0)? false : $query->result_array();
	}

	function getById_many_asc($where, $table, $orderby){
		$query = $this->db->select('*')
			->from($table)
			->where($where)
			->order_by($orderby, 'ASC')
			->get();
		return ($query->num_rows() <= 0)? false : $query->result_array();
	}

	function getById_many_desc($where, $table, $orderby){
		$query = $this->db->select('*')
			->from($table)
			->where($where)
			->order_by($orderby, 'DESC')
			->get();
		return ($query->num_rows() <= 0)? false : $query->result_array();
	}

	function searchById_many_desc($where, $table, $orderby){
		$query = $this->db->select('*')
			->from($table)
			->like($where)
			->order_by($orderby, 'DESC')
			->get();
		return ($query->num_rows() <= 0)? false : $query->result_array();
	}
	function multiSearchById_many_desc($where, $table, $orderby){
		$query = $this->db->select('*')
			->from($table)
			->or_like($where)
			->order_by($orderby, 'DESC')
			->get();
		return ($query->num_rows() <= 0)? false : $query->result_array();
	}

	function count_row($where, $table){
		$this->db->where($where);
		return $num = $this->db->count_all_results($table);
	}

	function matchId($where, $table){
		$query = $this->db->select('*')
			->from($table)
			->where($where)
			->limit(1)
			->get();
		return ($query->num_rows() <= 0)? false : true;	
	}

	function update($where, $data, $table){
		$this->db->where($where);
		$this->db->update($table, $data);
	}

	function destroy($where, $table){
		$this->db->where($where);
		$this->db->delete($table);
	}
}