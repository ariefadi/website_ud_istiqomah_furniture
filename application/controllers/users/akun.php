<?php

if (!defined('BASEPATH'))
  exit('No direct script access allowed');
// load base class if needed
require_once( APPPATH . 'controllers/base/OperatorBase.php' );

// --

class akun extends ApplicationBase {

  protected $per_page = 10;

  // constructor
  public function __construct() {
    // parent constructor
    parent::__construct();
    //load model
    $this->load->model('m_user');
    // load global
    $this->load->library('tnotification');
    $this->load->library('tftp');
    $this->load->library("tupload");

    // load helper
    $this->load->helper('datetime');

    //load css dan js
    $this->smarty->load_style('default/plugins/bootstrap-datepicker/bootstrap-datepicker.min.css');
    $this->smarty->load_style('default/plugins/vue-form-wizard/vue-form-wizard.css');

    $this->smarty->load_javascript('resource/themes/default/plugins/bootstrap-datetimepicker/moment-with-locales.min.js');
    $this->smarty->load_javascript('resource/themes/default/plugins/bootstrap-datetimepicker/bootstrap-datetimepicker.min.js');
    $this->smarty->load_javascript('resource/themes/default/plugins/bootstrap-datetimepicker/locale/id.js');
    $this->smarty->load_javascript('resource/themes/default/plugins/uniform/uniform.min.js');
    $this->smarty->load_javascript('resource/js/vue-js/axios.min.js');
    $this->smarty->load_javascript('resource/js/vue-js/vue.js');
    $this->smarty->load_javascript('resource/js/vue-js/vue-custom.js');
    $this->smarty->load_javascript('resource/js/vue-js/vue-plugins/vuejs-paginate/index.js'); 
    $this->smarty->load_javascript('resource/js/vue-js/vue-plugins/vue-form-wizard/vue-form-wizard.js');
    $this->smarty->load_javascript('resource/js/vue-js/vue-plugins/vuejs-datepicker/vue-bootstrap-datetimepicker.min.js');

    //set page title
    $this->smarty->assign("page_title","Pengaturan User");

  }

  public function index(){
    $this->_set_page_rule("R");
    $this->load->library("pagination");

    // set template content
    $this->smarty->assign("template_content", "users/akun/index.html");

    //get session
    $search = $this->tsession->userdata("session_users_akun");
    $username = empty($search['username']) ? '%%': '%'.$search['username'].'%';
    $this->smarty->assign("search",$search);

    //pagination
    /* start of pagination --------------------- */
    $params = array($username);
    $total_rows=$this->m_user->count_all_user($params);
    $config['base_url'] = site_url("users/akun/index/");
    $config['total_rows'] = $total_rows;
    $config['uri_segment'] = 4;
    $config['per_page'] = $this->per_page;
    $this->pagination->initialize($config);
    $pagination['data'] = $this->pagination->create_links(true);
    // pagination attribute
    $start = $this->uri->segment(4, 0) + 1;
    $end = $this->uri->segment(4, 0) + $config['per_page'];
    $end = (($end > $config['total_rows']) ? $config['total_rows'] : $end);
    $pagination['start'] = ($config['total_rows'] == 0) ? 0 : $start;
    $pagination['end'] = $end;
    $pagination['total'] = $config['total_rows'];
    // pagination assign value
    $this->smarty->assign("pagination", $pagination);
    $this->smarty->assign("no", $start);
    /* end of pagination ---------------------- */

    //get data
    $limit = array(($start - 1), $config['per_page']);
    $rs_result = $this->m_user->get_all_user_limit(array_merge($params, $limit));
    $this->smarty->assign("rs_result",$rs_result);

    $this->smarty->assign("rs_role",$this->m_user->get_all_roles());

    // notification
    $this->tnotification->display_notification();
    $this->tnotification->display_last_field();
    // output
    parent::display();
  }

  public function get_data_akun(){
    $this->load->library("pagination");

    //get session
    $search = $this->tsession->userdata("session_users_akun");
    $username = empty($search['username']) ? '%%': '%'.$search['username'].'%';
    
    $params = array($username);
    $total_rows = $this->m_user->count_all_user($params);

    $page_num = $this->input->post('page_num', TRUE) ?: $this->input->get('page_num', TRUE);
    $page_num = empty($page_num) ? 1 : $page_num;

    //get data
    // pagination
    $config['total_rows'] = $total_rows;
    $config['per_page'] = $this->per_page;
    $this->pagination->initialize($config);
    $pagination['data'] = $this->pagination->create_links(true);
    // pagination attribute
    $start = ($page_num - 1) * $config['per_page'];
    $start = ($page_num <= 0) ? 0 : $start ;
    $end = $start + $config['per_page'];
    $end = (($end > $config['total_rows']) ? $config['total_rows'] : $end);
    $pagination['start'] = ($config['total_rows'] == 0) ? 0 : ($start + 1);
    $pagination['end'] = $end;
    $pagination['total'] = $config['total_rows'];

    $response = array();
    $limit = array(($start), $config['per_page']);
    $response['pagination'] = $pagination;
    $response['result'] = $this->m_user->get_all_user_limit(array_merge($params, $limit));
    $response['search'] = $search;
    $response['rs_role'] = $this->m_user->get_all_roles();
    echo json_encode($response);
  }

  public function search_process(){
    $params = array(
      "username" => $this->input->post('username', TRUE)
    );
    $this->tsession->set_userdata('session_users_akun', $params);
    $response = $this->get_data_akun();
  }

  public function reset_search(){
    $this->tsession->unset_userdata('session_users_akun');
    $response = $this->get_data_akun();
  }

  public function add(){
    $this->_set_page_rule("C");

    // set template content
    $this->smarty->assign("template_content", "users/akun/add.html");

    //get data
    $this->smarty->assign("rs_personal", $this->m_user->get_all_personal());
    $this->smarty->assign("rs_portal",$this->m_user->get_all_roles_group_by_portal());

    // notification
    $this->tnotification->display_notification();
    $this->tnotification->display_last_field();
    // output
    parent::display();
  }

  public function add_process(){
    $this->_set_page_rule("C");

    $this->tnotification->set_rules("nama","Nama","trim|required|max_length[150]");
    $this->tnotification->set_rules("nik","Nomor Identitas","trim|required|max_length[20]");
    $this->tnotification->set_rules("jenis_kelamin","Jenis Kelamin","trim|required");
    $this->tnotification->set_rules("telp","No Telp/HP","trim|required|max_length[50]");
    $this->tnotification->set_rules("alamat","Alamat","trim|required|max_length[250]");
    $this->tnotification->set_rules("rt","RT","trim|required|max_length[3]");
    $this->tnotification->set_rules("rt","RW","trim|required|max_length[3]");
    $this->tnotification->set_rules("tempat_lahir","Tempat Lahir","trim|required|max_length[150]");
    $this->tnotification->set_rules("tanggal_lahir","Tanggal Lahir","trim|required");
    $this->tnotification->set_rules("pekerjaan","Pekerjaan","trim|required|max_length[150]");
    $this->tnotification->set_rules("status_perkawinan","Status Perkawinan","trim|required");

    $roles = $this->input->post('roles', TRUE);
    if(empty($roles)){
      $this->tnotification->set_rules("roles","Roles","required");
    }

    $this->tnotification->set_rules("user_pass","Password","trim|required");
    $this->tnotification->set_rules("user_mail","Email","trim|required|valid_email|max_length[250]");

    if($this->tnotification->run() !== FALSE){

      //check username dan email
      $email = $this->input->post('user_mail',TRUE);
      if($this->m_user->is_exist_email($email)){
        $this->tnotification->set_error_message($email." sudah digunakan");
        $this->tnotification->sent_notification("error","Data User Gagal Disimpan");
        $response = $this->tnotification->display_response();
        $this->tnotification->clear_session();
        echo json_encode($response);
        return;
      }

      $username = $this->input->post('user_mail',TRUE);
      if($this->m_user->is_exist_username($username)){
        $this->tnotification->set_error_message($username." sudah digunakan");
        $this->tnotification->sent_notification("error","Data User Gagal Disimpan");
        $response = $this->tnotification->display_response();
        $this->tnotification->clear_session();
        echo json_encode($response);
        return;
      }

      // check NIK
      $nik = $this->input->post('nik', TRUE);
      if($this->m_user->is_exist_nik($nik)){
        $this->tnotification->set_error_message($nik." sudah digunakan");
        $this->tnotification->sent_notification("error","Data User Gagal Disimpan");
        $response = $this->tnotification->display_response();
        $this->tnotification->clear_session();
        echo json_encode($response);
        return;
      }

      // Upload foto ke ftp
      $tahun = date('Y');
      $bulan = date('m');

      $prefixdate = date('ymd');
      $params = $prefixdate . '%';
      $user_id = $this->m_user->get_user_last_id($prefixdate,$params);

      // cek file surat upload
      $img_personal = $_FILES['personal_img'];
      // file wajib diupload
      if (empty($img_personal['tmp_name'])) {
        // default error
        $this->tnotification->set_error_message("File belum dipilih!");
        $this->tnotification->sent_notification("error","Data User Gagal Disimpan");
        $response = $this->tnotification->display_response();
        $this->tnotification->clear_session();
        echo json_encode($response);
        return;
      }
      // cek file size upload
      if ($img_personal['size'] > 10485760) {
        // error message
        $this->tnotification->set_error_message('File upload max 10 MB');
        $this->tnotification->sent_notification("error","Data User Gagal Disimpan");
        $response = $this->tnotification->display_response();
        $this->tnotification->clear_session();
        echo json_encode($response);
        return;
      }
      // cek file extension
      $ext = pathinfo($img_personal['name'], PATHINFO_EXTENSION);
      $ext_allowed = array('jpg','png','jpeg');
      if (!in_array($ext, $ext_allowed)) {
        // error message
        $this->tnotification->set_error_message('Jenis file tidak diperbolehkan');
        $this->tnotification->sent_notification("error","Data User Gagal Disimpan");
        $response = $this->tnotification->display_response();
        $this->tnotification->clear_session();
        echo json_encode($response);
        return;
      }

      // upload
      $img_path = '';
      $personal_img = '';
      if ($img_personal != '') {
        // upload config
        $year = date('Y');
        $config['file_name'] = $user_id. '.' . $ext;
        $config['upload_path'] = 'resource/doc/images/akun_users/'.$year.'/'.$user_id;
        $config['allowed_types'] = 'jpg|png|jpeg';
        $config['overwrite'] = TRUE;
        $config['max_size'] = 10240; //10 Mb
        $this->tupload->initialize($config);
          // upload process
          if ($this->tupload->do_upload('personal_img')) {
            //ambil data file yang di upload
            $data = $this->tupload->data();
            // set link path untuk di simpan di database
            $img_path = $config['upload_path'];
            $personal_img = $data['file_name'];
          } else {
            $this->tnotification->set_error_message('File gagal di upload !');
            $this->tnotification->sent_notification("error","Data User Gagal Disimpan");
            $response = $this->tnotification->display_response();
            $this->tnotification->clear_session();
            echo json_encode($response);
            return;
          }
        }

        //insert user dan personal
        $password_key = abs(crc32($this->input->post('user_pass',TRUE)));
        $password = $this->encrypt->encode(md5($this->input->post('user_pass',TRUE)), $password_key);
        $tanggal_lahir = $this->input->post('tanggal_lahir',TRUE);
        $nik = $this->input->post('nik', TRUE);

        $params = array(
          "user" => array(
            "user_id" => $user_id,
            "user_name" => $this->input->post('user_mail',TRUE),
            "user_pass" => $password,
            "user_key" => $password_key,
            "user_mail" => $this->input->post('user_mail',TRUE),
            "nik" => $nik,
            "user_st" => $this->input->post('user_st',TRUE),
            "mdb" => $this->com_user['user_id'],
            "mdd" => date("Y-m-d H:i:s")
          ),
          "personal" => array(
            "nik" => $nik,
            "nama" => $this->input->post('nama',TRUE),
            "jenis_kelamin" => $this->input->post('jenis_kelamin',TRUE),
            "telp" => $this->input->post('telp',TRUE),
            "alamat" => $this->input->post('alamat',TRUE),
            "rt" => $this->input->post('rt',TRUE),
            "rw" => $this->input->post('rw',TRUE),
            "tempat_lahir" => $this->input->post('tempat_lahir',TRUE),
            "tanggal_lahir" => reverse_date($tanggal_lahir),
            "pekerjaan" => $this->input->post('pekerjaan',TRUE),
            "status_perkawinan" => $this->input->post('status_perkawinan',TRUE),
            "img_path" => $img_path,
            "personal_img" => $personal_img,
            "mdb" => $this->com_user['user_id'],
            "mdd" => date("Y-m-d H:i:s")
          )
        );
        if(!$this->m_user->insert_user_trans($params)){
          $this->tnotification->sent_notification("error","Data User Gagal Disimpan");
          $response = $this->tnotification->display_response();
          $this->tnotification->clear_session();
          echo json_encode($response);
          return;
        }

        // insert roles
        $roles = $this->input->post('roles', TRUE);
        foreach ($roles as $key => $value) {
          $params = array(
            "user_id" => $user_id,
            "role_id" => $value
            );
          $this->m_user->insert_role($params);
        }

        $this->tnotification->sent_notification("success","Data User Berhasil Disimpan");
        $response = $this->tnotification->display_response();
        $this->tnotification->clear_session();
        echo json_encode($response);
        return;
      }else{
        $this->tnotification->sent_notification("error","Data User Gagal Disimpan");
        $response = $this->tnotification->display_response();
        $this->tnotification->clear_session();
        echo json_encode($response);
        return;
      }

    }

    public function edit($user_id=""){
      $this->_set_page_rule("U");

      // set template content
      $this->smarty->assign("template_content", "users/akun/edit.html");

      //get data
      $rs_result = $this->m_user->get_detail_user_personal_by_user_id($user_id);
      $this->smarty->assign("rs_result", $rs_result);
      $this->smarty->assign("user_roles",$this->m_user->get_roles_id_by_user($user_id));
      $this->smarty->assign("rs_portal",$this->m_user->get_all_roles_group_by_portal());

      // notification
      $this->tnotification->display_notification();
      // output
      parent::display();
    }

    public function edit_process(){
      $this->_set_page_rule("U");

      $this->tnotification->set_rules("user_id","User ID","trim|required");

      $this->tnotification->set_rules("nama","Nama","trim|required|max_length[150]");
      $this->tnotification->set_rules("nik","Nomor Identitas","trim|required|max_length[20]");
      $this->tnotification->set_rules("jenis_kelamin","Jenis Kelamin","trim|required");
      $this->tnotification->set_rules("telp","No Telp/HP","trim|required|max_length[50]");
      $this->tnotification->set_rules("alamat","Alamat","trim|required|max_length[250]");
      $this->tnotification->set_rules("rt","RT","trim|required|max_length[3]");
      $this->tnotification->set_rules("rt","RW","trim|required|max_length[3]");
      $this->tnotification->set_rules("tempat_lahir","Tempat Lahir","trim|required|max_length[150]");
      $this->tnotification->set_rules("tanggal_lahir","Tanggal Lahir","trim|required");
      $this->tnotification->set_rules("pekerjaan","Pekerjaan","trim|required|max_length[150]");
      $this->tnotification->set_rules("status_perkawinan","Status Perkawinan","trim|required");

      $roles = $this->input->post('roles', TRUE);
      if(empty($roles)){
        $this->tnotification->set_rules("roles","Roles","required");
      }

      $this->tnotification->set_rules("old_user_mail","Old Email","trim|required|valid_email");
      $this->tnotification->set_rules("user_mail","Email","trim|required|valid_email|max_length[250]");

      $user_id = $this->input->post('user_id',TRUE);
      if($this->tnotification->run() !== FALSE){

      //check email dan no id
        $email = $this->input->post('user_mail',TRUE);
        $old_email = $this->input->post('old_user_mail',TRUE);
        if($email != $old_email){
          if($this->m_user->is_exist_email($email)){
            $this->tnotification->set_error_message($email." sudah digunakan");
            $this->tnotification->sent_notification("error","Data User Gagal Disimpan");
            $response = $this->tnotification->display_response();
            $this->tnotification->clear_session();
            echo json_encode($response);
            return;
          }
        }

        // check NIK
        $nik = $this->input->post('nik', TRUE);
        $old_nik = $this->input->post('old_nik', TRUE);
        if($nik != $old_nik){
          if($this->m_user->is_exist_nik($nik)){
            $this->tnotification->set_error_message($nik." sudah digunakan");
            $this->tnotification->sent_notification("error","Data User Gagal Disimpan");
            $response = $this->tnotification->display_response();
            $this->tnotification->clear_session();
            echo json_encode($response);
            return;
          }
        }

        $tahun = date('Y');
        $bulan = date('m');

        // cek file surat upload
        $img_personal = $_FILES['personal_img'];
        // file wajib diupload
        if (empty($img_personal['tmp_name'])) {
          // default error
          $this->tnotification->set_error_message("File belum dipilih!");
          $this->tnotification->sent_notification("error","Data User Gagal Disimpan");
          $response = $this->tnotification->display_response();
          $this->tnotification->clear_session();
          echo json_encode($response);
          return;
        }
        // cek file size upload
        if ($img_personal['size'] > 10485760) {
          // error message
          $this->tnotification->set_error_message('File upload max 10 MB');
          $this->tnotification->sent_notification("error","Data User Gagal Disimpan");
          $response = $this->tnotification->display_response();
          $this->tnotification->clear_session();
          echo json_encode($response);
          return;
        }
        // cek file extension
        $ext = pathinfo($img_personal['name'], PATHINFO_EXTENSION);
        $ext_allowed = array('jpg','png','jpeg');
        if (!in_array($ext, $ext_allowed)) {
          // error message
          $this->tnotification->set_error_message('Jenis file tidak diperbolehkan');
          $this->tnotification->sent_notification("error","Data User Gagal Disimpan");
          $response = $this->tnotification->display_response();
          $this->tnotification->clear_session();
          echo json_encode($response);
          return;
        }

        // upload
        $img_path = '';
        $personal_img = '';
        if ($img_personal != '') {
          // upload config
          $year = date('Y');
          $config['file_name'] = $user_id. '.' . $ext;
          $config['upload_path'] = 'resource/doc/images/akun_users/'.$year.'/'.$user_id;
          $config['allowed_types'] = 'jpg|png|jpeg';
          $config['overwrite'] = TRUE;
          $config['max_size'] = 10240; //10 Mb
          $this->tupload->initialize($config);
          // upload process
          if ($this->tupload->do_upload('personal_img')) {
            //ambil data file yang di upload
            $data = $this->tupload->data();
            // set link path untuk di simpan di database
            $img_path = $config['upload_path'];
            $personal_img = $data['file_name'];
          } else {
            $this->tnotification->set_error_message('File gagal di upload !');
            $this->tnotification->sent_notification("error","Data User Gagal Disimpan");
            $response = $this->tnotification->display_response();
            $this->tnotification->clear_session();
            echo json_encode($response);
            return;
          }
      }

      //insert user dan personal
      $tanggal_lahir = $this->input->post('tanggal_lahir',TRUE);
      $nik = $this->input->post('nik', TRUE);
      $params = array(
        "user" => array(
          "user_name" => $this->input->post('user_mail',TRUE),
          "user_mail" => $this->input->post('user_mail',TRUE),
          "nik" => $nik,
          "user_st" => $this->input->post('user_st',TRUE),
          "mdb" => $this->com_user['user_id'],
          "mdd" => date("Y-m-d H:i:s")
          ),
        "personal" => array(
          "nik" => $nik,
          "nama" => $this->input->post('nama',TRUE),
          "jenis_kelamin" => $this->input->post('jenis_kelamin',TRUE),
          "telp" => $this->input->post('telp',TRUE),
          "alamat" => $this->input->post('alamat',TRUE),
          "rt" => $this->input->post('rt',TRUE),
          "rw" => $this->input->post('rw',TRUE),
          "tempat_lahir" => $this->input->post('tempat_lahir',TRUE),
          "tanggal_lahir" => reverse_date($tanggal_lahir),
          "pekerjaan" => $this->input->post('pekerjaan',TRUE),
          "status_perkawinan" => $this->input->post('status_perkawinan',TRUE),
          "img_path" => $img_path,
          "personal_img" => $personal_img,
          "mdb" => $this->com_user['user_id'],
          "mdd" => date("Y-m-d H:i:s")
          ),
        "where_user" => array(
          "user_id" => $user_id
          ),
        "where_personal" => array(
          "nik" => $nik
          )
        ); 
      $password = $this->input->post('user_pass', TRUE);
      if(!empty(trim($password))){
        $password_key = abs(crc32($this->input->post('user_pass',TRUE)));
        $password = $this->encrypt->encode(md5($this->input->post('user_pass',TRUE)), $password_key);
        $params['user']['user_pass'] = $password;
        $params['user']['user_key'] = $password_key;
      }

      if(!$this->m_user->update_user_trans($params)){
        $this->tnotification->sent_notification("error","Data User Gagal Disimpan");
        $response = $this->tnotification->display_response();
        $this->tnotification->clear_session();
        echo json_encode($response);
        return;
      }

      // update roles
      if($user_id == $this->com_user['user_id']){
        $this->tnotification->set_error_message("Roles tidak dapat diperbarui");
        $this->tnotification->sent_notification("success","Data User Berhasil Disimpan");
        $response = $this->tnotification->display_response();
        $this->tnotification->clear_session();
        echo json_encode($response);
        return;
      }

      //kosongkan roles
      $this->m_user->delete_role(array("user_id" => $user_id));

      //insert roles
      $roles = $this->input->post('roles', TRUE);
      foreach ($roles as $key => $value) {
        $params = array(
          "user_id" => $user_id,
          "role_id" => $value
          );
        $this->m_user->insert_role($params);
      }

      $this->tnotification->sent_notification("success","Data User Berhasil Disimpan");
      $response = $this->tnotification->display_response();
      $this->tnotification->clear_session();
      echo json_encode($response);
      return;
    }else{
      $this->tnotification->sent_notification("error","Data User Gagal Disimpan");
      $response = $this->tnotification->display_response();
      $this->tnotification->clear_session();
      echo json_encode($response);
      return;
    }

  }

  public function delete($user_id=""){
    $this->_set_page_rule("D");

    // set template content
    $this->smarty->assign("template_content", "users/akun/delete.html");

    if($user_id == $this->com_user['user_id']){
      $this->tnotification->set_error_message("Tidak dapat menghapus user anda sendiri");
      $this->tnotification->sent_notification("error","Data Akun User Gagal Dihapus");
      $response = $this->tnotification->display_response();
      $this->tnotification->clear_session();
      echo json_encode($response);
      return;
    }

    //get data
    $this->smarty->assign("result",$this->m_user->get_detail_user_personal_by_user_id($user_id));

    // notification
    $this->tnotification->display_notification();
    // output
    parent::display();
  }

  public function delete_process(){
    $this->_set_page_rule("D");

    $this->tnotification->set_rules("user_id","User ID","trim|required|numeric");

    if($this->tnotification->run() !== FALSE){
      $user_id = $this->input->post('user_id', TRUE);
      if($user_id == $this->com_user['user_id']){
        $this->tnotification->set_error_message("Tidak dapat menghapus user anda sendiri");
        $this->tnotification->sent_notification("error","Data Akun User Gagal Dihapus");
        $response = $this->tnotification->display_response();
        $this->tnotification->clear_session();
        echo json_encode($response);
        return;
      }

      $where = array(
        "user" => array(
          "user_id" => $user_id
          ),
        "personal" => array(
          "nik" => $this->input->post('nik', TRUE)
          )
        );

      if(!$this->m_user->delete_user_trans($where)){
        $this->tnotification->sent_notification("error","Data User Gagal Dihapus");
        $response = $this->tnotification->display_response();
        $this->tnotification->clear_session();
        echo json_encode($response);
        return;
      }
      $this->tnotification->sent_notification("deleted","Data User Berhasil Dihapus");
      $response = $this->tnotification->display_response();
      $this->tnotification->clear_session();
      $response['redirect'] = site_url('users/akun');
      echo json_encode($response);
      return;
    }else{
      $this->tnotification->sent_notification("error","Data User Gagal Dihapus");
      $response = $this->tnotification->display_response();
      $this->tnotification->clear_session();
      echo json_encode($response);
      return;
    }
  
  }

  //get data

  public function get_detail_personal(){
    $personal_id = $this->input->post('personal_id', TRUE);
    $result = $this->m_user-> get_detail_personal_by_id($personal_id);
    echo json_encode($result);
  }

}
