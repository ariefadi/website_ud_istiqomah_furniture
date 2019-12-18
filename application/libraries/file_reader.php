<?php 
/**
* Read file Pelaporan KSP
*/
class File_Reader {

  private $ci;
  private $com_user;
  
  public function __construct($com_user) {
    $this->ci =& get_instance();
    $this->com_user = $com_user;
  }
  
  public function neraca($uploaded, $laporan_id) {
    // load model
    $this->ci->load->model('ksp/m_keuangan_neraca');
    $this->ci->load->model('master/m_neraca_akun');
    // read file excel
    $data_excel  = $this->_read_excel($uploaded['full_path']);
    $arr_akun_kd = $this->ci->m_neraca_akun->get_all_read('akun_kd');
    $mdb = $this->com_user['user_id'];
    $mdd = date('Y-m-d H:i:s');
    foreach ($data_excel as $key => $data) {
      if ($key == 1 && trim($data['A']) != 'IMPORT NERACA') return false;
      if ($key < 6) continue;
      if (empty($data['B'])) continue;
      $akun_kd = trim($data['B']);
      if (!in_array($akun_kd, $arr_akun_kd)) continue;
      $nominal = (int)trim($data['D']);
      $where = compact('laporan_id', 'akun_kd');
      if ($this->ci->m_keuangan_neraca->is_exists($where)) {
        $params_update = compact('nominal', 'mdb', 'mdd');
        $this->ci->m_keuangan_neraca->update($params_update, $where);
      } else {
        $params_insert = compact('laporan_id', 'akun_kd', 'nominal', 'mdb', 'mdd');
        $this->ci->m_keuangan_neraca->insert($params_insert);
      }
    }
    return true;
  }

  public function shu($uploaded, $laporan_id) {
    // load model
    $this->ci->load->model('ksp/m_keuangan_shu');
    $this->ci->load->model('master/m_shu_akun');
    // read file excel
    $data_excel  = $this->_read_excel($uploaded['full_path']);
    $arr_akun_kd = $this->ci->m_shu_akun->get_all_read('akun_kd');
    $mdb = $this->com_user['user_id'];
    $mdd = date('Y-m-d H:i:s');
    foreach ($data_excel as $key => $data) {
      if ($key == 1 && trim($data['A']) != 'IMPORT HASIL USAHA') return false;
      if ($key < 6) continue;
      if (empty($data['B'])) continue;
      $akun_kd = trim($data['B']);
      if (!in_array($akun_kd, $arr_akun_kd)) continue;
      $nominal = (int)trim($data['D']);
      $where = compact('laporan_id', 'akun_kd');
      if ($this->ci->m_keuangan_shu->is_exists($where)) {
        $params_update = compact('nominal', 'mdb', 'mdd');
        $this->ci->m_keuangan_shu->update($params_update, $where);
      } else {
        $params_insert = compact('laporan_id', 'akun_kd', 'nominal', 'mdb', 'mdd');
        $this->ci->m_keuangan_shu->insert($params_insert);
      }
    }
    return true;
  }

  public function ekuitas($uploaded, $laporan_id) {
    // load model
    $this->ci->load->model('ksp/m_keuangan_ekuitas');
    $this->ci->load->model('master/m_ekuitas_akun');
    // read file excel
    $data_excel  = $this->_read_excel($uploaded['full_path']);
    $arr_akun_kd = $this->ci->m_ekuitas_akun->get_all_read('akun_kd');
    $mdb = $this->com_user['user_id'];
    $mdd = date('Y-m-d H:i:s');
    foreach ($data_excel as $key => $data) {
      if ($key == 1 && trim($data['A']) != 'IMPORT PERUBAHAN EKUITAS') return false;
      if ($key != 8) continue;
      $akun_kd = 1;
      foreach ($data as $index => $nominal) {
        if ($index == 'A' || $index == 'G') continue;
        if (!in_array($akun_kd, $arr_akun_kd)) continue;
        $nominal = (int)trim($nominal);
        $where = compact('laporan_id', 'akun_kd');
        if ($this->ci->m_keuangan_ekuitas->is_exists($where)) {
          $params_update = compact('nominal', 'mdb', 'mdd');
          $this->ci->m_keuangan_ekuitas->update($params_update, $where);
        } else {
          $params_insert = compact('laporan_id', 'akun_kd', 'nominal', 'mdb', 'mdd');
          $this->ci->m_keuangan_ekuitas->insert($params_insert);
        }
        $akun_kd ++;
      }
    }
    return true;
  }

  public function aruskas($uploaded, $laporan_id) {
    // load model
    $this->ci->load->model('ksp/m_keuangan_aruskas');
    $this->ci->load->model('master/m_aruskas_akun');
    // read file excel
    $data_excel  = $this->_read_excel($uploaded['full_path']);
    $arr_akun_kd = $this->ci->m_aruskas_akun->get_all_read('akun_kd');
    $mdb = $this->com_user['user_id'];
    $mdd = date('Y-m-d H:i:s');
    foreach ($data_excel as $key => $data) {
      if ($key == 1 && trim($data['A']) != 'IMPORT ARUS KAS') return false;
      if ($key < 6) continue;
      if (empty($data['B'])) continue;
      $akun_kd = trim($data['B']);
      if (!in_array($akun_kd, $arr_akun_kd)) continue;
      $nominal = (int)trim($data['D']);
      $where = compact('laporan_id', 'akun_kd');
      if ($this->ci->m_keuangan_aruskas->is_exists($where)) {
        $params_update = compact('nominal', 'mdb', 'mdd');
        $this->ci->m_keuangan_aruskas->update($params_update, $where);
      } else {
        $params_insert = compact('laporan_id', 'akun_kd', 'nominal', 'mdb', 'mdd');
        $this->ci->m_keuangan_aruskas->insert($params_insert);
      }
    }
    return true;
  }

  private function _read_excel($file_path) {
    $this->ci->load->library('phpexcel');
    $inputFileType = PHPExcel_IOFactory::identify($file_path);
    $objReader     = PHPExcel_IOFactory::createReader($inputFileType);
    $objPHPExcel   = $objReader->load($file_path);
    return $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
  }

}