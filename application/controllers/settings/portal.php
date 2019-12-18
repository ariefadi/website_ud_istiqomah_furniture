<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
// load base class if needed
require_once( APPPATH . 'controllers/base/OperatorBase.php' );

// --

class portal extends ApplicationBase {

    // constructor
    public function __construct() {
        // parent constructor
        parent::__construct();
        // load model
        $this->load->model('m_settings');
        $this->load->model('m_preferences');
        // load library
        $this->load->library('tnotification');
        //page header
        $this->smarty->assign("page_title","Web Portal");
        //load css dan js
        $this->smarty->load_javascript('resource/js/vue-js/axios.min.js');
        $this->smarty->load_javascript('resource/js/vue-js/vue.js');
        $this->smarty->load_javascript('resource/js/vue-js/vue-custom.js');
        $this->smarty->load_javascript('resource/js/vue-js/vue-plugins/vuejs-paginate/index.js');
    }

    // list data
    public function index() {
        // set page rules
        $this->_set_page_rule("R");
        // set template content
        $this->smarty->assign("template_content", "settings/portal/index.html");
        // get data
        $rs_id = $this->m_settings->get_all_portal();
        $this->smarty->assign("rs_id", $rs_id);
        // notification
        $this->tnotification->display_notification();
        $this->tnotification->display_last_field();
        // output
        parent::display();
    }

    // add form
    public function add() {
        // set page rules
        $this->_set_page_rule("C");
        // set template content
        $this->smarty->assign("template_content", "settings/portal/add.html");
        // notification
        $this->tnotification->display_notification();
        $this->tnotification->display_last_field();
        // output
        parent::display();
    }

    // add process
    public function add_process() {
        // set page rules
        $this->_set_page_rule("C");
        // cek input
        $this->tnotification->set_rules('portal_nm', 'Nama Portal', 'trim|required|max_length[50]');
        $this->tnotification->set_rules('site_title', 'Judul Web', 'trim|required|max_length[100]');
        $this->tnotification->set_rules('site_desc', 'Deskripsi Web', 'trim|required|max_length[100]');
        $this->tnotification->set_rules('meta_desc', 'Meta Deskripsi', 'trim|required|max_length[255]');
        $this->tnotification->set_rules('meta_keyword', 'Meta Keyword', 'trim|required|max_length[255]');
        // portal id
        $portal_id = $this->m_settings->get_portal_last_id();
        if (!$portal_id) {
            $this->tnotification->set_error_message('ID is not available');
        }
        // process
        if ($this->tnotification->run() !== FALSE) {
            $params = array(
                'portal_id' => $portal_id,
                'portal_nm' => $this->input->post('portal_nm', TRUE),
                'site_title' => $this->input->post('site_title', TRUE),
                'site_desc' => $this->input->post('site_desc', TRUE),
                'meta_desc' => $this->input->post('meta_desc', TRUE),
                'meta_keyword' => $this->input->post('meta_keyword', TRUE),
                'create_by' => $this->com_user['user_id'],
                'create_by_name' => $this->com_user['nama'],
                'create_date' => date("Y-m-d H:i:s")
            );
            // insert
            if ($this->m_settings->insert_portal($params)) {
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
        $response = $this->tnotification->display_response();
        $this->tnotification->clear_session();
        echo json_encode($response);
        return;
    }

    // edit form
    public function edit($portal_id = "") {
        // set page rules
        $this->_set_page_rule("U");
        // set template content
        $this->smarty->assign("template_content", "settings/portal/edit.html");
        // get data
        $result = $this->m_settings->get_portal_by_id($portal_id);
        // check
        if (empty($result)) {
            // default error
            $this->tnotification->sent_notification("error", "Data yang anda pilih tidak terdaftar!");
            redirect("settings/portal");
        }
        $this->smarty->assign("result", $result);
        // notification
        $this->tnotification->display_notification();
        // $this->tnotification->display_last_field();
        // output
        parent::display();
    }

    // edit process
    public function edit_process() {
        // set page rules
        $this->_set_page_rule("U");
        // cek input
        $this->tnotification->set_rules('portal_id', 'Portal ID', 'trim|required|max_length[2]');
        $this->tnotification->set_rules('portal_nm', 'Nama Portal', 'trim|required|max_length[50]');
        $this->tnotification->set_rules('site_title', 'Judul Web', 'trim|required|max_length[100]');
        $this->tnotification->set_rules('site_desc', 'Deskripsi Web', 'trim|required|max_length[100]');
        $this->tnotification->set_rules('meta_desc', 'Meta Deskripsi', 'trim|required|max_length[255]');
        $this->tnotification->set_rules('meta_keyword', 'Meta Keyword', 'trim|required|max_length[255]');
        // process
        $portal_id = $this->input->post('portal_id', TRUE);
        if ($this->tnotification->run() !== FALSE) {

            $params = array(
                'portal_nm' => $this->input->post('portal_nm', TRUE),
                'site_title' => $this->input->post('site_title', TRUE),
                'site_desc' => $this->input->post('site_desc', TRUE),
                'meta_desc' => $this->input->post('meta_desc', TRUE),
                'meta_keyword' => $this->input->post('meta_keyword', TRUE),
                'create_by' => $this->com_user['user_id'],
                'create_by_name' => $this->com_user['nama'],
                'create_date' => date("Y-m-d H:i:s")
            );
            $where = array(
                'portal_id' => $this->input->post('portal_id', TRUE)
            );
            // update
            if ($this->m_settings->update_portal($params, $where)) {
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
            $response = $this->tnotification->display_response();
            $this->tnotification->clear_session();
            echo json_encode($response);
            return;
    }

    // hapus form
    public function delete($portal_id = "") {
        // set page rules
        $this->_set_page_rule("D");
        // set template content
        $this->smarty->assign("template_content", "settings/portal/delete.html");
        // get data
        $result = $this->m_settings->get_portal_by_id($portal_id);
        // check
        if (empty($result)) {
            // default error
            $this->tnotification->sent_notification("error", "Data yang anda pilih tidak terdaftar!");
            redirect("settings/portal");
        }
        $this->smarty->assign("result", $result);
        // notification
        $this->tnotification->display_notification();
        $this->tnotification->display_last_field();
        // output
        parent::display();
    }

    // hapus process
    public function delete_process() {
        // set page rules
        $this->_set_page_rule("D");
        // cek input
        $this->tnotification->set_rules('portal_id', 'Portal ID', 'trim|required|max_length[2]');
        // process
        if ($this->tnotification->run() !== FALSE) {
            $params = array(
                'portal_id' => $this->input->post('portal_id', TRUE)
            );
            // delete
            if ($this->m_settings->delete_portal($params)) {
                $this->tnotification->delete_last_field();
                $this->tnotification->sent_notification("deleted", "Data berhasil dihapus");
                // default redirect
                $response = $this->tnotification->display_response();
                $this->tnotification->clear_session();
                $response['redirect'] = site_url('settings/portal');
                echo json_encode($response);
                return;
            } else {
                // default error
                $this->tnotification->sent_notification("error", "Data gagal dihapus");
            }
        } else {
            // default error
            $this->tnotification->sent_notification("error", "Data gagal dihapus");
        }
        // default redirect
        $response = $this->tnotification->display_response();
        $this->tnotification->clear_session();
        echo json_encode($response);
        return;
    }

}
