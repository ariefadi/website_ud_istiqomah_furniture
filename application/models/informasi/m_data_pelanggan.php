<?php

class m_data_pelanggan extends CI_Model {

  function __construct() {
    // Call the Model constructor
    parent::__construct();
    // load encrypt
    $this->load->library('encrypt');
  }

  // generate data pelanggan id
  function get_data_pelanggan_last_id($params = "P") {
    $sql = "SELECT SUBSTRING(pelanggan_id, 4, 7)'last_number'
            FROM master_data_pelanggan
            WHERE SUBSTRING(pelanggan_id, 2, 2) = SUBSTRING(YEAR(NOW()), 3, 2)
            ORDER BY pelanggan_id DESC
            LIMIT 0, 1";
    $query = $this->db->query($sql);
    if ($query->num_rows() > 0) {
        $result = $query->row_array();
        $query->free_result();
        // create next number
        $number = intval($result['last_number']) + 1;
        $zero = '';
        for ($i = strlen($number); $i < 7; $i++) {
            $zero .= '0';
        }
        return $params . substr(date("Y"), -2) . $zero . $number;
    } else {
        // create new number
        return $params . substr(date("Y"), -2) . '0000001';
    }
  }

  public function count_all_data_pelanggan($params){
    $arr_params = array();
    $sql = "SELECT COUNT(*)'total' FROM master_data_pelanggan 
            WHERE pelanggan_id <> '' ";

    if(!empty($params[0])){
      $sql .=" AND pelanggan_nama LIKE ? ";
      array_push($arr_params,$params[0]);
    }

    $query = $this->db->query($sql,$arr_params);
    if($query->num_rows() > 0){
      $result = $query->row_array();
      $query->free_result();
      return $result['total'];
    }else{
      return 0;
    }
  }

  public function get_all_data_pelanggan_limit($params){
    $arr_params = array();
    $sql = "SELECT * FROM master_data_pelanggan 
            WHERE pelanggan_id <> '' ";

    if(!empty($params[0])){
      $sql .=" AND pelanggan_nama LIKE ? ";
      array_push($arr_params,$params[0]);
    }

    $sql .=" ORDER BY pelanggan_id LIMIT ?,? ";
    array_push($arr_params,$params[1]);
    array_push($arr_params,$params[2]);

    $query = $this->db->query($sql,$arr_params);
    if($query->num_rows() > 0){
      $result = $query->result_array();
      $query->free_result();
      return $result;
    }else{
      return array();
    }
  }

  //CHECK EXISTS
  // check data pelanggan
  function is_exist_data_pelanggan($pelanggan_nama) {
    $sql = "SELECT COUNT(*)'total' FROM master_data_pelanggan WHERE pelanggan_nama = ?";
    $query = $this->db->query($sql, $pelanggan_nama);
    if ($query->num_rows() > 0) {
      $result = $query->row_array();
      $query->free_result();
      if ($result['total'] == 0) {
        return false;
      }
    }
    return true;
  }

  function get_detail_data_pelanggan_by_id($pelanggan_id=""){
    $sql = "SELECT * FROM master_data_pelanggan 
            WHERE pelanggan_id = ?";
    $query = $this->db->query($sql,$pelanggan_id);
    if($query->num_rows() > 0){
      $result = $query->row_array();
      $query->free_result();
      return $result;
    }else{
      return array();
    }
  }

  //insert data pelanggan
  function insert_data_pelanggan($params){
    return $this->db->insert('master_data_pelanggan', $params);
  }

  //update data pelanggan
  function c($params){
    return $this->db->update('master_data_pelanggan', $params, $where);
  }



}
