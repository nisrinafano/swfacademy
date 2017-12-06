<?php
class GeneralModel extends CI_Model {

        public function create($table, $data){
                $result = $this->db->insert($table, $data);
                if ($result) {
                     return true;
                }
        }
        public function getItem($field, $table){
                $query = $this->db->select($field)
                        ->from($table)
                        ->get();
                return ($query->num_rows()<=0)? false : $query->result_array();
        }
        public function update($table, $where, $data){
                $this->db->where($where)
                        ->update($table, $data);
        }
        public function destroy($table, $where){
                $this->db->where($where)
                        ->delete($table); 
        }
        public function getByParam($table, $where){
                $query = $this->db->select('*')
                        ->from($table)
                        ->where($where)
                        ->get();
                return ($query->num_rows()<=0)? false : $query->result_array();
        }
        public function query($sql){
                $query = $this->db->query($sql);
                return ($query->num_rows()<=0)? false : $query->result_array();
        }
        public function getByLimit($table){
                $query = $this->db->select('*')
                        ->from($table)
                        ->limit(3)
                        ->order_by('id', 'DESC')
                        ->get();
                return ($query->num_rows()<=0)? false : $query->result_array();
        }
        public function data_on_search($cari){
            $query = $this->db->select('*')
            ->from('info_jurusan')
            ->like('nama_jurusan',$cari)
            ->or_like('nama_kampus',$cari)
            ->get();
        return ($query->num_rows()<=0)? false : $query->result_array();
        }
}

?>