<?php

if (!defined('BASEPATH'))
exit('No direct script access allowed');
// load base class if needed
require_once( APPPATH . 'controllers/base/OperatorBase.php' );

// --

class help extends ApplicationBase {
  // constructor
  public function __construct() {
    // parent constructor
    parent::__construct();
    //load model
    $this->load->model('m_preferences');
    $this->load->model('m_settings');
    // load global
    $this->load->library('tnotification');
    $this->load->library('pagination');

    //set page title
    $this->smarty->assign("page_title", "Help (User Manual)");
  }

  // general
  public function index() {
    // set page rules
    $this->_set_page_rule("R");
    // set template content
    $this->smarty->assign("template_content", "home/help/index.html");
    // pencarian
    $search = $this->tsession->userdata("session_search_help");
    $judul = empty($search['judul']) ? '%%' : '%'.$search['judul'].'%';
    $this->smarty->assign("search",$search);
    // pagination
    $params = array($judul);
    $config['base_url'] = site_url("home/help/index");
    $config['total_rows'] = $this->m_settings->get_count_user_manual($params);
    $config['uri_segment'] = 4;
    $config['per_page'] = 20;
    $this->pagination->initialize($config);
    $pagination['data'] = $this->pagination->create_links();
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
    $params = array($judul, ($start - 1), $config['per_page']);
    // get data
    $rs_id = $this->m_settings->get_all_user_manual($params);
    $this->smarty->assign("rs_id", $rs_id);
    // output
    parent::display();
  }

  // pencarian
  public function search_process(){
    // set page rule
    $this->_set_page_rule("R");
    // input
    $search = $this->input->post('save', true);
    if ($search == 'Cari') {
      $params = array(
        'judul'   => $this->input->post('judul', true)
      );
      // set session
      $this->tsession->set_userdata("session_search_help", $params);
    } else{
      // unset session
      $this->tsession->unset_userdata("session_search_help");
    }
    // redirect
    redirect('home/help');
  }
}
