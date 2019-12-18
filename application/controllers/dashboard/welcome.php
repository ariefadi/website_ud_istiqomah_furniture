<?php

if (!defined('BASEPATH'))
exit('No direct script access allowed');
// load base class if needed
require_once( APPPATH . 'controllers/base/OperatorBase.php' );

// --

class welcome extends ApplicationBase {

  // constructor
  public function __construct() {
    // parent constructor
    parent::__construct();
    //load model
    $this->load->model('m_dashboard');
    // load global
    $this->load->library('tnotification');
    //set page title
    $this->smarty->assign("page_title","Dashboard");
  }

  // general
  public function index() {
    // set template content
    $this->smarty->assign("template_content", "dashboard/welcome/index.html");
    // notification
    $this->tnotification->display_notification();
    $this->tnotification->display_last_field();
    // output
    parent::display();
  }
  
}
