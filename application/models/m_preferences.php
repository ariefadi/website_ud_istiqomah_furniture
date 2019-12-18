<?php

// class for core system
class m_preferences extends CI_Model {

  function __construct() {
    // Call the Model constructor
    parent::__construct();
  }

  function get_micro_time() {
        $time = microtime(true);
        $id = str_replace('.', '', $time);
        $id = str_replace(',', '', $id);
        return $id;
  }

  function get_all_tahun_from($start){
    $arr_tahun = array();
    $end = (int)date("Y")+5;

    $i = 0;
    for($year = $start;$year <= $end; $year++){
      $arr_tahun[$i]['tahun'] = $year;

      $i++;
    }

    return $arr_tahun;
  }

  function get_all_bulan_advanced(){
    $arr_bulan = array(
      "1" => array("long" => "Januari","short" => "Jan"),
      "2" => array("long" => "Februari","short" => "Feb"),
      "3" => array("long" => "Maret","short" => "Mar"),
      "4" => array("long" => "April","short" => "Apr"),
      "5" => array("long" => "Mei","short" => "Mei"),
      "6" => array("long" => "Juni","short" => "Jun"),
      "7" => array("long" => "Juli","short" => "Jul"),
      "8" => array("long" => "Agustus","short" => "Ags"),
      "9" => array("long" => "September","short" => "Sept"),
      "10" => array("long" => "Oktober","short" => "Okt"),
      "11" => array("long" => "November","short" => "Nov"),
      "12" => array("long" => "Desember","short" => "Des"),
    );

    return $arr_bulan;
  }

  function get_list_month_year($params){
    $start    = (new DateTime($params[0]))->modify('first day of this month');
    $end      = (new DateTime($params[1]))->modify('first day of next month');
    $interval = DateInterval::createFromDateString('1 month');
    $period   = new DatePeriod($start, $interval, $end);

    $arr_month = array();
    $i = 0;
    foreach ($period as $dt) {
        $arr_month[$i]['tahun'] = $dt->format("Y");
        $arr_month[$i]['bulan'] = $dt->format("n");

        $i++;
    }

    return $arr_month;
  }

  function get_pref_value_by_grup_name($params){
    $sql = "SELECT pref_value FROM com_preferences
      WHERE pref_group = ? AND pref_nm = ? ";
    $query = $this->db->query($sql,$params);
    if($query->num_rows() > 0){
      $result = $query->row_array();
      $query->free_result();
      return $result['pref_value'];
    }else{
      return array();
    }
  }

  function get_grup_name($params){
    $sql = "SELECT pref_nm, pref_value FROM com_preferences
      WHERE pref_group = ? AND pref_nm = ?";
    $query = $this->db->query($sql,$params);
    if($query->num_rows() > 0){
      $result = $query->row_array();
      $query->free_result();
      return $result['pref_nm'];
    }else{
      return array();
    }
  }  

  function update_preferences($params,$where){
    return $this->db->update('com_preferences', $params, $where);
  }

  function get_data_prov(){
      $sql = "SELECT * FROM lokasi_prov
        ORDER BY prov_nama ";
      $query = $this->db->query($sql);
      if($query->num_rows() > 0){
        $result = $query->result_array();
        $query->free_result();
        return $result;
      }else{
        return array();
      }
    }

  function get_data_kab(){
      $sql = "SELECT * FROM lokasi_kab
        ORDER BY kab_nama ";
      $query = $this->db->query($sql);
      if($query->num_rows() > 0){
        $result = $query->result_array();
        $query->free_result();
        return $result;
      }else{
        return array();
      }
    }

    function get_data_kab_by_prov($prov_id){
      $sql = "SELECT * FROM lokasi_kab
        WHERE prov_id = ?
        ORDER BY kab_nama ";
      $query = $this->db->query($sql,$prov_id);
      if($query->num_rows() > 0){
        $result = $query->result_array();
        $query->free_result();
        return $result;
      }else{
        return array();
      }
    }

    function get_data_kec_by_kab($kab_id){
      $sql = "SELECT * FROM lokasi_kec
        WHERE kab_id = ?
        ORDER BY kec_nama ";
      $query = $this->db->query($sql,$kab_id);
      if($query->num_rows() > 0){
        $result = $query->result_array();
        $query->free_result();
        return $result;
      }else{
        return array();
      }
    }

    function get_data_kel_by_kec($kec_id){
      $sql = "SELECT * FROM lokasi_kel
        WHERE kec_id = ?
        ORDER BY kel_nama ";
      $query = $this->db->query($sql,$kec_id);
      if($query->num_rows() > 0){
        $result = $query->result_array();
        $query->free_result();
        return $result;
      }else{
        return array();
      }
    }

    public function get_data_profil_perusahaan() {
      $sql = "SELECT * FROM com_preferences
              WHERE pref_group = 'profil'";
      $query = $this->db->query($sql);
      if ($query->num_rows() > 0) {
          $result = $query->result_array();
          $query->free_result();
          $data = array();
          foreach ($result as $rec) {
              $data[$rec['pref_nm']] = $rec['pref_value'];
          }
          return $data;
      } else {
          return array();
      }
    }

    // update profil perusahaan
    public function update_profil_perusahaan($rs_params) {
      // update
      foreach ($rs_params as $pref_nm => $value) {
          // params
          $params = array(
              'pref_value' => $value
          );
          $where = array(
              'pref_group' => 'profil',
              'pref_nm' => $pref_nm,
          );
          $this->db->update('com_preferences', $params, $where);
      }
      // return
      return true;
    }

}
