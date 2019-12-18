<?php

if (!defined('BASEPATH'))
  exit('No direct script access allowed');
// load base class if needed
require_once( APPPATH . 'controllers/base/OperatorBase.php' );

// --

class data_pelanggan extends ApplicationBase {

  protected $per_page = 10;

  // constructor
  public function __construct() {
    // parent constructor
    parent::__construct();
    //load model
    $this->load->model('informasi/m_data_pelanggan');
    // load global
    $this->load->library('tnotification');
    $this->load->library('tftp');
    $this->load->library("tupload");

    // load helper
    $this->load->helper('datetime');

    //load css dan js
    $this->smarty->load_javascript('resource/themes/default/plugins/uniform/uniform.min.js');
    $this->smarty->load_javascript('resource/js/vue-js/axios.min.js');
    $this->smarty->load_javascript('resource/js/vue-js/vue.js');
    $this->smarty->load_javascript('resource/js/vue-js/vue-custom.js');
    $this->smarty->load_javascript('resource/js/vue-js/vue-plugins/vuejs-paginate/index.js'); 

    //set page title
    $this->smarty->assign("page_title","Data Pelanggan");

  }

  public function index(){
    $this->_set_page_rule("R");
    $this->load->library("pagination");

    // set template content
    $this->smarty->assign("template_content", "informasi/data_pelanggan/index.html");

    //get session
    $search = $this->tsession->userdata("session_data_pelanggan");
    $pelanggan_nama = empty($search['pelanggan_nama']) ? '%%': '%'.$search['pelanggan_nama'].'%';
    $this->smarty->assign("search",$search);

    //pagination
    /* start of pagination --------------------- */
    $params = array($pelanggan_nama);
    $total_rows=$this->m_data_pelanggan->count_all_data_pelanggan($params);
    $config['base_url'] = site_url("informasi/data_pelanggan/index/");
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
    $rs_result = $this->m_data_pelanggan->get_all_data_pelanggan_limit(array_merge($params, $limit));
    $this->smarty->assign("rs_result",$rs_result);

    // notification
    $this->tnotification->display_notification();
    $this->tnotification->display_last_field();
    // output
    parent::display();
  }

  public function get_data_pelanggan(){
    $this->load->library("pagination");

    //get session
    $search = $this->tsession->userdata("session_data_pelanggan");
    $pelanggan_nama = empty($search['pelanggan_nama']) ? '%%': '%'.$search['pelanggan_nama'].'%';
    
    $params = array($pelanggan_nama);
    $total_rows = $this->m_data_pelanggan->count_all_data_pelanggan($params);

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
    $response['result'] = $this->m_data_pelanggan->get_all_data_pelanggan_limit(array_merge($params, $limit));
    $response['search'] = $search;
    echo json_encode($response);
  }

  public function search_process(){
    $params = array(
      "pelanggan_nama" => $this->input->post('pelanggan_nama', TRUE)
    );
    $this->tsession->set_userdata('session_data_pelanggan', $params);
    $response = $this->get_data_pelanggan();
  }

  public function reset_search(){
    $this->tsession->unset_userdata('session_data_pelanggan');
    $response = $this->get_data_pelanggan();
  }

  public function add(){
    $this->_set_page_rule("C");

    // load style
    $this->smarty->load_style('default/plugins/summernote/dist/summernote.css');
    // load javascript
    $this->smarty->load_javascript('resource/themes/default/plugins/summernote/dist/summernote.min.js');

    // set template content
    $this->smarty->assign("template_content", "informasi/data_pelanggan/add.html");

    // notification
    $this->tnotification->display_notification();
    $this->tnotification->display_last_field();
    // output
    parent::display();
  }

  public function add_process(){
    $this->_set_page_rule("C");

    $this->tnotification->set_rules("pelanggan_nama","Nama Pelanggan","trim|required|max_length[200]");
    $this->tnotification->set_rules("pelanggan_telp","Nomor Telepon","trim|required|max_length[13]");
    $this->tnotification->set_rules("pelanggan_email","Email","trim|required");
    $this->tnotification->set_rules("pelanggan_alamat","Alamat","trim|required|max_length[200]");

    if($this->tnotification->run() !== FALSE){

      $pelanggan_nama = $this->input->post('pelanggan_nama',TRUE);
      if($this->m_data_pelanggan->is_exist_data_pelanggan($pelanggan_nama)){
        $this->tnotification->set_error_message($pelanggan_nama." sudah digunakan");
        $this->tnotification->sent_notification("error","Data Pelanggan Gagal Disimpan");
        $response = $this->tnotification->display_response();
        $this->tnotification->clear_session();
        echo json_encode($response);
        return;
      }

      $pelanggan_id = $this->m_data_pelanggan->get_data_pelanggan_last_id();

      // cek file surat upload
      $img_pelanggan = $_FILES['pelanggan_img'];
      // file wajib diupload
      if (empty($img_pelanggan['tmp_name'])) {
        // default error
        $this->tnotification->set_error_message("File belum dipilih!");
        $this->tnotification->sent_notification("error","Data Pelanggan Gagal Disimpan");
        $response = $this->tnotification->display_response();
        $this->tnotification->clear_session();
        echo json_encode($response);
        return;
      }
      // cek file size upload
      if ($img_pelanggan['size'] > 10485760) {
        // error message
        $this->tnotification->set_error_message('File upload max 10 MB');
        $this->tnotification->sent_notification("error","Data Pelanggan Gagal Disimpan");
        $response = $this->tnotification->display_response();
        $this->tnotification->clear_session();
        echo json_encode($response);
        return;
      }
      // cek file extension
      $ext = pathinfo($img_pelanggan['name'], PATHINFO_EXTENSION);
      $ext_allowed = array('jpg','png','jpeg');
      if (!in_array($ext, $ext_allowed)) {
        // error message
        $this->tnotification->set_error_message('Jenis file tidak diperbolehkan');
        $this->tnotification->sent_notification("error","Data Pelanggan Gagal Disimpan");
        $response = $this->tnotification->display_response();
        $this->tnotification->clear_session();
        echo json_encode($response);
        return;
      }

      // upload
      $img_path = '';
      $pelanggan_img = '';
      if ($img_pelanggan != '') {
        // upload config
        $year = date('Y');
        $config['file_name'] = $pelanggan_id. '.' . $ext;
        $config['upload_path'] = 'resource/doc/images/pelanggan/'.$year.'/'.$pelanggan_id;
        $config['allowed_types'] = 'jpg|png|jpeg';
        $config['overwrite'] = TRUE;
        $config['max_size'] = 10240; //10 Mb
        $this->tupload->initialize($config);
          // upload process
          if ($this->tupload->do_upload('pelanggan_img')) {
            //ambil data file yang di upload
            $data = $this->tupload->data();
            // set link path untuk di simpan di database
            $img_path = $config['upload_path'];
            $pelanggan_img = $data['file_name'];
          } else {
            $this->tnotification->set_error_message('File gagal di upload !');
            $this->tnotification->sent_notification("error","Data Pelanggan Gagal Disimpan");
            $response = $this->tnotification->display_response();
            $this->tnotification->clear_session();
            echo json_encode($response);
            return;
          }
        }

        $params = array(
            "pelanggan_id" => $pelanggan_id,
            "pelanggan_nama" => $this->input->post('pelanggan_nama',TRUE),
            "pelanggan_telp" => $this->input->post('pelanggan_telp',TRUE),
            "pelanggan_email" => $this->input->post('pelanggan_email',TRUE),
            "pelanggan_alamat" => strip_tags($this->input->post('pelanggan_alamat', TRUE)),
            "img_path" => $img_path,
            "pelanggan_img" => $pelanggan_img,
            "mdb" => $this->com_user['user_id'],
            "mdd" => date("Y-m-d H:i:s")
        );
        if(!$this->m_data_pelanggan->insert_data_pelanggan($params)){
          $this->tnotification->sent_notification("error","Data Pelanggan Gagal Disimpan");
          $response = $this->tnotification->display_response();
          $this->tnotification->clear_session();
          echo json_encode($response);
          return;
        }

        $this->tnotification->sent_notification("success","Data Pelanggan Berhasil Disimpan");
        $response = $this->tnotification->display_response();
        $this->tnotification->clear_session();
        echo json_encode($response);
        return;
      }else{
        $this->tnotification->sent_notification("error","Data Pelanggan Gagal Disimpan");
        $response = $this->tnotification->display_response();
        $this->tnotification->clear_session();
        echo json_encode($response);
        return;
      }

    }

    public function edit($pelanggan_id=""){
      $this->_set_page_rule("U");

      // load style
      $this->smarty->load_style('default/plugins/summernote/dist/summernote.css');
      // load javascript
      $this->smarty->load_javascript('resource/themes/default/plugins/summernote/dist/summernote.min.js');

      // set template content
      $this->smarty->assign("template_content", "informasi/data_pelanggan/edit.html");

      //get data
      $rs_result = $this->m_data_pelanggan->get_detail_data_pelanggan_by_id($pelanggan_id);
      $this->smarty->assign("rs_result", $rs_result);

      // notification
      $this->tnotification->display_notification();
      // output
      parent::display();
    }

    public function edit_process(){
      $this->_set_page_rule("U");

      $this->tnotification->set_rules("pelanggan_id","Pelanggan ID","trim|required");

      $this->tnotification->set_rules("pelanggan_nama","Nama Pelanggan","trim|required|max_length[200]");
      $this->tnotification->set_rules("pelanggan_telp","Nomor Telepon","trim|required|max_length[13]");
      $this->tnotification->set_rules("pelanggan_email","Email","trim|required");
      $this->tnotification->set_rules("pelanggan_alamat","Alamat","trim|required|max_length[200]");

      $pelanggan_id = $this->input->post('pelanggan_id',TRUE);
      if($this->tnotification->run() !== FALSE){

        // cek file surat upload
        $img_pelanggan = $_FILES['pelanggan_img'];
        // file wajib diupload
        if (empty($img_pelanggan['tmp_name'])) {
          // default error
          $this->tnotification->set_error_message("File belum dipilih!");
          $this->tnotification->sent_notification("error","Data Pelanggan Gagal Disimpan");
          $response = $this->tnotification->display_response();
          $this->tnotification->clear_session();
          echo json_encode($response);
          return;
        }
        // cek file size upload
        if ($img_pelanggan['size'] > 10485760) {
          // error message
          $this->tnotification->set_error_message('File upload max 10 MB');
          $this->tnotification->sent_notification("error","Data Pelanggan Gagal Disimpan");
          $response = $this->tnotification->display_response();
          $this->tnotification->clear_session();
          echo json_encode($response);
          return;
        }
        // cek file extension
        $ext = pathinfo($img_pelanggan['name'], PATHINFO_EXTENSION);
        $ext_allowed = array('jpg','png','jpeg');
        if (!in_array($ext, $ext_allowed)) {
          // error message
          $this->tnotification->set_error_message('Jenis file tidak diperbolehkan');
          $this->tnotification->sent_notification("error","Data Pelanggan Gagal Disimpan");
          $response = $this->tnotification->display_response();
          $this->tnotification->clear_session();
          echo json_encode($response);
          return;
        }

        // upload
        $img_path = '';
        $pelanggan_img = '';
        if ($img_personal != '') {
          // upload config
          $year = date('Y');
          $config['file_name'] = $pelanggan_id. '.' . $ext;
          $config['upload_path'] = 'resource/doc/images/pelanggan/'.$year.'/'.$pelanggan_id;
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

      //update
      $params = array(
        "pelanggan_nama" => $this->input->post('pelanggan_nama',TRUE),
        "pelanggan_telp" => $this->input->post('pelanggan_telp',TRUE),
        "pelanggan_email" => $this->input->post('pelanggan_email',TRUE),
        "pelanggan_alamat" => strip_tags($this->input->post('pelanggan_alamat', TRUE)),
        "img_path" => $img_path,
        "pelanggan_img" => $pelanggan_img,
        "mdb" => $this->com_user['user_id'],
        "mdd" => date("Y-m-d H:i:s")
      ); 

      $where = array(
        "pelanggan_id" => $pelanggan_id
      );

      if(!$this->m_data_pelanggan->update_data_pelanggan($params)){
        $this->tnotification->sent_notification("error","Data Pelanggan Gagal Disimpan");
        $response = $this->tnotification->display_response();
        $this->tnotification->clear_session();
        echo json_encode($response);
        return;
      }

      $this->tnotification->sent_notification("success","Data Pelanggan Berhasil Disimpan");
      $response = $this->tnotification->display_response();
      $this->tnotification->clear_session();
      echo json_encode($response);
      return;
    }else{
      $this->tnotification->sent_notification("error","Data Pelanggan Gagal Disimpan");
      $response = $this->tnotification->display_response();
      $this->tnotification->clear_session();
      echo json_encode($response);
      return;
    }

  }

//   public function delete($user_id=""){
//     $this->_set_page_rule("D");

//     // set template content
//     $this->smarty->assign("template_content", "users/akun/delete.html");

//     if($user_id == $this->com_user['user_id']){
//       $this->tnotification->set_error_message("Tidak dapat menghapus user anda sendiri");
//       $this->tnotification->sent_notification("error","Data Akun User Gagal Dihapus");
//       $response = $this->tnotification->display_response();
//       $this->tnotification->clear_session();
//       echo json_encode($response);
//       return;
//     }

//     //get data
//     $this->smarty->assign("result",$this->m_user->get_detail_user_personal_by_user_id($user_id));

//     // notification
//     $this->tnotification->display_notification();
//     // output
//     parent::display();
//   }

//   public function delete_process(){
//     $this->_set_page_rule("D");

//     $this->tnotification->set_rules("user_id","User ID","trim|required|numeric");

//     if($this->tnotification->run() !== FALSE){
//       $user_id = $this->input->post('user_id', TRUE);
//       if($user_id == $this->com_user['user_id']){
//         $this->tnotification->set_error_message("Tidak dapat menghapus user anda sendiri");
//         $this->tnotification->sent_notification("error","Data Akun User Gagal Dihapus");
//         $response = $this->tnotification->display_response();
//         $this->tnotification->clear_session();
//         echo json_encode($response);
//         return;
//       }

//       $where = array(
//         "user" => array(
//           "user_id" => $user_id
//           ),
//         "personal" => array(
//           "nik" => $this->input->post('nik', TRUE)
//           )
//         );

//       if(!$this->m_user->delete_user_trans($where)){
//         $this->tnotification->sent_notification("error","Data User Gagal Dihapus");
//         $response = $this->tnotification->display_response();
//         $this->tnotification->clear_session();
//         echo json_encode($response);
//         return;
//       }
//       $this->tnotification->sent_notification("deleted","Data User Berhasil Dihapus");
//       $response = $this->tnotification->display_response();
//       $this->tnotification->clear_session();
//       $response['redirect'] = site_url('users/akun');
//       echo json_encode($response);
//       return;
//     }else{
//       $this->tnotification->sent_notification("error","Data User Gagal Dihapus");
//       $response = $this->tnotification->display_response();
//       $this->tnotification->clear_session();
//       echo json_encode($response);
//       return;
//     }
  
//   }

//   //get data

//   public function get_detail_personal(){
//     $personal_id = $this->input->post('personal_id', TRUE);
//     $result = $this->m_user-> get_detail_personal_by_id($personal_id);
//     echo json_encode($result);
//   }

}
