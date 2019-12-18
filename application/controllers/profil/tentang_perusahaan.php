<?php

if (!defined('BASEPATH'))
exit('No direct script access allowed');
// load base class if needed
require_once( APPPATH . 'controllers/base/OperatorBase.php' );

// --

class tentang_perusahaan extends ApplicationBase {

    // constructor
    public function __construct() {
        // parent constructor
        parent::__construct();
  
        //load model
        $this->load->model('m_preferences');
        // load global
        $this->load->library('tnotification');
        //set page title
        $this->smarty->assign("page_title","Tentang Perusahaan");
  
    }

    // list
    public function index() {
        // set page rules
        $this->_set_page_rule("R");
        // set template content
        $this->smarty->assign("template_content", "profil/tentang_perusahaan/index.html");
        // load style
        $this->smarty->load_style('default/plugins/summernote/dist/summernote.css');
        // load javascript
        $this->smarty->load_javascript('resource/themes/default/plugins/summernote/dist/summernote.min.js');
        // get detail data
        $this->smarty->assign("result", $this->m_preferences->get_data_profil_perusahaan());
        // notification 
        $this->tnotification->display_notification();
        $this->tnotification->display_last_field();
        // output
        parent::display();
    }

    // edit process
    public function edit_process() {
        // set page rules
        $this->_set_page_rule("U");
        // cek input
        $this->tnotification->set_rules('isi', 'Isi', 'trim|required');
        $this->tnotification->set_rules('content', 'Isi dalam Bahasa Inggris', 'trim|required');
        $this->tnotification->set_rules('status', 'Status', 'trim|required');
        // process
        if ($this->tnotification->run() !== FALSE) {
            // params
            $params = array(
                'isi' => strip_tags($this->input->post('isi', TRUE)),
                'content' => strip_tags($this->input->post('content', TRUE)),
                'status' => $this->input->post('status', TRUE),
                'oleh' => $this->com_user['nama'],
                'tanggal' => date("Y-m-d H:i:s")
            );
            // update
            if ($this->m_preferences->update_profil_perusahaan($params)) {
                // notification
                $this->tnotification->delete_last_field();
                $this->tnotification->sent_notification("success", "Data berhasil disimpan");
            } else {
                // default error
                $this->tnotification->sent_notification("error", "Data gagal disimpan");
            }
        } else {
            // default error
            $this->tnotification->sent_notification("error", "Data gagal disimpan");
        }
        // default redirect
		redirect("profil/tentang_perusahaan");
    }

}    