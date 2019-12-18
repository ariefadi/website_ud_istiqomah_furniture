<?php

class m_user extends CI_Model {

  function __construct() {
    // Call the Model constructor
    parent::__construct();
    // load encrypt
    $this->load->library('encrypt');
  }

  // get last id
  function get_user_last_id($prefixdate) {
    $sql = "SELECT SUBSTRING(user_id,7,4) AS 'urutan'
      FROM com_user
      WHERE SUBSTRING(user_id,1,6) = ?
      ORDER BY user_id DESC LIMIT 0,1";
    $query = $this->db->query($sql, $prefixdate);
    if ($query->num_rows() > 0) {
      $result = $query->row_array();
      $query->free_result();
      $last_id = intval($result['urutan']);
      $next_id = $prefixdate.str_pad(($last_id + 1),4,"0",STR_PAD_LEFT);
      return $next_id;
    } else {
      $next_id = $prefixdate.str_pad((0 + 1),4,"0",STR_PAD_LEFT);
      return $next_id;
    }
  }

  function get_personal_last_id($prefixdate) {
    $sql = "SELECT SUBSTRING(personal_id,7,4) AS 'urutan'
      FROM personal
      WHERE SUBSTRING(personal_id,1,6) = ?
      ORDER BY personal_id DESC LIMIT 0,1";
    $query = $this->db->query($sql, $prefixdate);
    if ($query->num_rows() > 0) {
      $result = $query->row_array();
      $query->free_result();
      $last_id = intval($result['urutan']);
      $next_id = $prefixdate.str_pad(($last_id + 1),4,"0",STR_PAD_LEFT);
      return $next_id;
    } else {
      $next_id = $prefixdate.str_pad((0 + 1),4,"0",STR_PAD_LEFT);
      return $next_id;
    }
  }

  public function count_all_user_by_role($params){
    $arr_params = array();
    $sql = "SELECT COUNT(*)'total' FROM com_user a
    INNER JOIN com_role_user c ON a.user_id=c.user_id
    INNER JOIN com_role d ON c.role_id = d.role_id
    INNER JOIN personal e ON a.nik = e.nik
    WHERE a.user_id <> '1605200002' ";

    if(!empty($params[0])){
      $sql .=" AND (user_mail LIKE ? OR nama LIKE ?) ";
      array_push($arr_params,$params[0]);
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

  public function count_all_user($params){
    $arr_params = array();
    $sql = "SELECT COUNT(*)'total' FROM com_user a
    INNER JOIN personal b ON a.nik = b.nik
    WHERE a.user_id <> '1605200002' ";

    if(!empty($params[0])){
      $sql .=" AND (user_mail LIKE ? OR nama LIKE ?) ";
      array_push($arr_params,$params[0]);
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

  public function get_all_user_by_role_limit($params){
    $arr_params = array();
    $sql = "SELECT a.*,role_nm,e.* FROM com_user a
    INNER JOIN com_role_user c ON a.user_id=c.user_id
    INNER JOIN com_role d ON c.role_id = d.role_id
    INNER JOIN personal e ON a.nik = e.nik
    WHERE a.user_id <> '1605200002' ";

    if(!empty($params[0])){
      $sql .=" AND (user_mail LIKE ? OR nama LIKE ?) ";
      array_push($arr_params,$params[0]);
      array_push($arr_params,$params[0]);
    }

    $sql .=" ORDER BY c.role_id,a.user_id LIMIT ?,? ";
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

  public function get_all_user_limit($params){
    $arr_params = array();
    $sql = "SELECT a.*,d.*,jml_role FROM com_user a
    INNER JOIN (
      SELECT COUNT(*)'jml_role', user_id
      FROM com_role_user GROUP BY user_id
    ) c ON a.user_id=c.user_id
    INNER JOIN personal d ON a.nik = d.nik
    WHERE a.user_id <> '1605200002' ";

    if(!empty($params[0])){
      $sql .=" AND (user_mail LIKE ? OR nama LIKE ?) ";
      array_push($arr_params,$params[0]);
      array_push($arr_params,$params[0]);
    }

    $sql .=" ORDER BY a.user_id LIMIT ?,? ";
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


  function get_detail_user_personal_by_user_id($user_id=""){
    $sql = "SELECT user_id,user_name,user_mail,user_st,pegawai_st,b.*
    FROM com_user a
      INNER JOIN personal b ON a.nik = b.nik
    WHERE a.user_id = ?";
    $query = $this->db->query($sql,$user_id);
    if($query->num_rows() > 0){
      $result = $query->row_array();
      $query->free_result();
      return $result;
    }else{
      return array();
    }
  }

  //PERSONAL
  //get personal
  function get_all_personal(){
    $sql ="SELECT * FROM personal ORDER BY nama ";
    $query = $this->db->query($sql);
    if($query->num_rows() > 0){
      $result = $query->result_array();
      $query->free_result();
      return $result;
    }else{
      return array();
    }
  }
  //get personal non user
  function get_all_personal_non_user(){
    $sql ="SELECT * FROM personal
      WHERE user_id NOT IN (SELECT user_id FROM com_user) ";
    $query = $this->db->query($sql);
    if($query->num_rows() > 0){
      $result = $query->result_array();
      $query->free_result();
      return $result;
    }else{
      return array();
    }
  }

  //get detail personal by id
  function get_detail_personal_by_id($personal_id){
    $sql = "SELECT * FROM personal WHERE personal_id = ? ";
    $query = $this->db->query($sql,$personal_id);
    if($query->num_rows() > 0){
      $result = $query->row_array();
      $query->free_result();
      return $result;
    }else{
      return array();
    }
  }


  //ROLES
  // get roles by user
  function get_roles_by_user($params) {
    $sql = "SELECT a.*
    FROM com_role_user a
    INNER JOIN com_role b ON b.role_id = a.role_id
    INNER JOIN com_group c ON c.group_id = b.group_id
    WHERE a.user_id = ?
    ORDER BY c.group_name ASC";
    $query = $this->db->query($sql, $params);
    if ($query->num_rows() > 0) {
      $result = $query->result_array();
      $query->free_result();
      return $result;
    } else {
      return array();
    }
  }

  function get_roles_id_by_user($params){
    $sql = "SELECT role_id FROM com_role_user WHERE user_id = ?";
    $query = $this->db->query($sql, $params);
    if ($query->num_rows() > 0) {
      $rs_result = $query->result_array();
      $query->free_result();
      foreach ($rs_result as $key => $value) {
        $arr_result[$key] = $value['role_id'];
      }
      return $arr_result;
    } else {
      return array();
    }
  }

  //get all roles
  function get_all_roles(){
    $sql = "SELECT * FROM com_role ORDER BY role_nm";
    $query = $this->db->query($sql);
    if ($query->num_rows() > 0) {
      $result = $query->result_array();
      $query->free_result();
      return $result;
    } else {
      return array();
    }
  }

  function get_all_roles_group_by_portal(){

    $arr_return = array();
    $result = $this->get_all_portal();
    foreach ($result as $key => $value) {
      $arr_return[$key]['portal_id'] = $value['portal_id'];
      $arr_return[$key]['portal_nm'] = $value['portal_nm'];

      $roles = $this->get_roles_by_portal(array($value['portal_id']));
      foreach ($roles as $i => $role) {
        $arr_return[$key]['roles'][$i]['role_id'] = $role['role_id'];
        $arr_return[$key]['roles'][$i]['role_nm'] = $role['role_nm'];
      }
    }
    return $arr_return;
  }

  function get_all_portal(){
    $sql = "SELECT * FROM com_portal ORDER BY portal_id";
    $query = $this->db->query($sql);
    if($query->num_rows() > 0){
      $result = $query->result_array();
      $query->free_result();
      return $result;
    }else{
      return array();
    }
  }

  // get all roles by portal
  function get_roles_by_portal($params) {
    $sql = "SELECT b.group_name, a.*
    FROM com_role a
      INNER JOIN com_group b ON a.group_id = b.group_id
    WHERE a.portal_id = ?
    GROUP BY role_id
    ORDER BY b.group_name ASC, a.role_nm ASC";
    $query = $this->db->query($sql, $params);
    if ($query->num_rows() > 0) {
      $result = $query->result_array();
      $query->free_result();
      return $result;
    } else {
      return array();
    }
  }


  //CHECK EXISTS
  // check username
  function is_exist_username($username) {
    $sql = "SELECT COUNT(*)'total' FROM com_user WHERE user_name = ?";
    $query = $this->db->query($sql, $username);
    if ($query->num_rows() > 0) {
      $result = $query->row_array();
      $query->free_result();
      if ($result['total'] == 0) {
        return false;
      }
    }
    return true;
  }

  // check email
  function is_exist_email($user_mail) {
    $sql = "SELECT COUNT(*)'total' FROM com_user WHERE user_mail = ?";
    $query = $this->db->query($sql, $user_mail);
    if ($query->num_rows() > 0) {
      $result = $query->row_array();
      $query->free_result();
      if ($result['total'] == 0) {
        return false;
      }
    }
    return true;
  }

  function is_exist_nik($nik) {
    $sql = "SELECT COUNT(*)'total' FROM personal WHERE nik = ?";
    $query = $this->db->query($sql, $nik);
    if ($query->num_rows() > 0) {
      $result = $query->row_array();
      $query->free_result();
      if ($result['total'] == 0) {
        return false;
      }
    }
    return true;
  }

  //USER (COM_USER)

  function get_detail_user_by_id($params) {
    $sql = "SELECT *
    FROM com_user a
    INNER JOIN com_role_user b ON a.user_id = b.user_id
    WHERE a.user_id = ?";
    $query = $this->db->query($sql, $params);
    if ($query->num_rows() > 0) {
      $result = $query->row_array();
      $query->free_result();
      return $result;
    } else {
      return array();
    }
  }

  //insert personal
  function insert_personal($params){
    return $this->db->insert('personal', $params);
  }

  //insert personal
  function update_personal($params, $where){
    return $this->db->update('personal', $params, $where);
  }

  // insert personal user
  function insert_personal_user($params) {
    return $this->db->insert('user_personal', $params);
  }

  // update personal user
  function update_personal_user($params, $where) {
    return $this->db->update('user_personal', $params, $where);
  }

  // insert role
  function insert_role($params) {
    return $this->db->insert('com_role_user', $params);
  }

  // update role
  function update_role($params, $where) {
    return $this->db->update('com_role_user', $params, $where);
  }

  // delete role
  function delete_role($where) {
    return $this->db->delete('com_role_user', $where);
  }

  // insert user
  function insert_user($params){
    return $this->db->insert('com_user', $params);
  }

  //delete user
  function delete_user($where) {
    return $this->db->delete('com_user', $where);
  }

  function delete_user_trans($where) {
    $this->db->trans_start();
    $this->db->delete('personal', $where['personal']);
    $this->db->delete('com_user', $where['user']);
    $this->db->trans_complete();
    return $this->db->trans_status();
  }

  //delete personal
  function delete_personal($where) {
    return $this->db->delete('personal', $where);
  }

  // update user
  function update_user($params,$where){
    return $this->db->update('com_user',$params,$where);
  }

  function insert_reset_password($params){
    return $this->db->insert('com_reset_pass',$params);
  }

  function update_reset_password($params,$where){
    return $this->db->update('com_reset_pass', $params, $where);
  }

  // Transact
  function insert_user_trans($params){
    $this->db->trans_start();
    $this->db->insert('personal', $params['personal']);
    $this->db->insert('com_user', $params['user']);
    $this->db->trans_complete();
    return $this->db->trans_status();
  }

  function update_user_trans($params){
    $this->db->trans_start();
    $this->db->update('com_user', $params['user'], $params['where_user']);
    $this->db->update('personal', $params['personal'], $params['where_personal']);
    $this->db->trans_complete();
    return $this->db->trans_status();
  }

  function get_reset_by_verif_code($kode){
    $sql = "SELECT * FROM com_reset_pass
      WHERE verif_code = ? AND reset_st = '0'";
    $query = $this->db->query($sql,$kode);
    if($query->num_rows() > 0){
      $result = $query->row_array();
      $query->free_result();
      return $result;
    }else{
      return array();
    }
  }

}
