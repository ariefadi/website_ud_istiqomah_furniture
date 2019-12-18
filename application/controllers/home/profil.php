<?php

if (!defined('BASEPATH'))
exit('No direct script access allowed');
// load base class if needed
require_once( APPPATH . 'controllers/base/OperatorBase.php' );

// --

class profil extends ApplicationBase {

  // constructor
  public function __construct() {
    // parent constructor
    parent::__construct();

    //load model
    $this->load->model('m_preferences');
    $this->load->model('m_settings');
    // load global
    $this->load->library('tnotification');

    //set page title
    $this->smarty->assign("page_title","Profil");

  }

  public function index(){
    $this->_set_page_rule("R");
    // set template content
    $this->smarty->assign("template_content", "home/profil/index.html");

    //get data
    $this->smarty->assign("result",$this->m_account->get_user_account_by_id(array($this->com_user['user_id'])));

    // notification
    $this->tnotification->display_notification();
    $this->tnotification->display_last_field();
    // output
    parent::display();
  }

  public function update_user(){
    $this->_set_page_rule("U");

    $this->tnotification->set_rules("old_password","Password Lama","trim|required");
    $this->tnotification->set_rules("new_password","Password Baru","trim|required");
    $this->tnotification->set_rules("new_password_confirm","Konfirmasi Password Lama","trim|required");

    if($this->tnotification->run() !== FALSE){

      $old_password = $this->input->post('old_password',TRUE);
      $new_password = $this->input->post('new_password',TRUE);
      $new_password_confirm = $this->input->post('new_password_confirm',TRUE);

      if(!$this->m_account->check_old_password($this->com_user['user_id'],$old_password)){
        $this->tnotification->set_error_message("Password lama salah");
        $this->tnotification->sent_notification("error","Password Gagal Dirubah");
        redirect("home/profil");
      }

      if($new_password != $new_password_confirm){
        $this->tnotification->set_error_message("Konfirmasi password salah");
        $this->tnotification->sent_notification("error","Password Gagal Dirubah");
        redirect("home/profil");
      }

      $this->load->library("encrypt");
      $password_key = abs(crc32($new_password));
      $password = $this->encrypt->encode(md5($new_password), $password_key);

      $params = array(
        "user_pass" => $password,
        "user_key" => $password_key
      );

      $where = array(
        "user_id" => $this->com_user['user_id']
      );

      $this->load->model("m_user");
      $this->m_user->update_user($params, $where);

      $this->tnotification->sent_notification("success","Password Berhasil Dirubah");
    }else{
      $this->tnotification->sent_notification("error","Password Gagal Dirubah");
    }
    redirect("home/profil");
  }

}
