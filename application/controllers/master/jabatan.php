<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
// load base class if needed
require_once( APPPATH . 'controllers/base/OperatorBase.php' );

// --
class jabatan extends ApplicationBase {

    // constructor
    public function __construct() {
        // parent constructor
        parent::__construct();
        // load model
        $this->load->model('master/m_jabatan');
        // load library
        $this->load->library('tnotification');
        //page header
        $this->smarty->assign("page_title","Jabatan Fungsional");
        //load css dan js
        $this->smarty->load_javascript('resource/js/vue-js/axios.min.js');
        $this->smarty->load_javascript('resource/js/vue-js/vue.js');
        $this->smarty->load_javascript('resource/js/vue-js/vue-custom.js');
        $this->smarty->load_javascript('resource/js/vue-js/vue-plugins/vuejs-paginate/index.js');
    }

    // list jabatan
    public function index() {
        // set page rules
        $this->_set_page_rule("R");
        // set template content
        $this->smarty->assign("template_content", "master/jabatan/index.html");
        // get data menu
        $html = $this->_get_jabatan(0, "");
        $this->smarty->assign("html", $html);
        // notification
        $this->tnotification->display_notification();
        $this->tnotification->display_last_field();
        // output
        parent::display();
    }

    // get menu
    private function _get_jabatan($jabatan_id, $indent) {
        $html = "";
        $params = array($jabatan_id);
        $rs_id = $this->m_jabatan->get_all_jabatan_by_parent($params);
        if ($rs_id) {
            $no = 0;
            $indent .= "--- ";
            foreach ($rs_id as $rec) {
                // url
                $url_edit = site_url('master/jabatan/edit/' . $rec['jabatan_id']);
                $url_hapus = site_url('master/jabatan/delete/' . $rec['jabatan_id']);
                // parse
                $html .= "<tr>";
                $html .= "<td>" . $indent . $rec['jabatan_nm'] . "</td>";
                $html .= "<td class='text-center'>" . strtoupper($rec['grup']) . "</td>";
                $html .= "<td class='text-center'>";
                $html .= "<a href='" . $url_edit . "' data-toggle='tooltip' data-placement='bottom' title='Edit'><i class='fa fa-pencil text-info m-r-10'></i></a>&nbsp;";
                $html .= "<a href='" . $url_hapus . "' data-toggle='tooltip' data-placement='bottom' title='Hapus'><i class='fa fa-times text-danger'></i></a>";
                $html .= "</td>";
                $html .= "</tr>";
                $html .= $this->_get_jabatan($rec['jabatan_id'], $indent);
                $no++;
            }
        }
        return $html;
    }

    // form tambah Jabatan
    public function add() {
        // set page rules
        $this->_set_page_rule("C");
        // set template content
        $this->smarty->assign("template_content", "master/jabatan/add.html");
        // notification
        $this->tnotification->display_notification();
        $this->tnotification->display_last_field();
        // get last field
        $result = $this->tnotification->get_field_data();
        $parent_selected = isset($result['parent_id']['postdata']) ? $result['parent_id']['postdata'] : 0;
        // get list parent
        $html = $this->_get_selectbox_jabatan(0, "", $parent_selected);
        $this->smarty->assign("list_parent", $html);
        // output
        parent::display();
    }

    // get jabatan selectbox
    private function _get_selectbox_jabatan($parent_id, $indent, $parent_selected) {
        $html = "";
        $params = array($parent_id);
        $rs_id = $this->m_jabatan->get_all_jabatan_by_parent($params);
        if ($rs_id) {
            $no = 0;
            $indent .= "--- ";
            foreach ($rs_id as $rec) {
                // selected
                $selected = ($parent_selected == $rec['jabatan_id']) ? 'selected="selected"' : '';
                // parse
                $html .= "<option value='" . $rec['jabatan_id'] . "' " . $selected . ">";
                $html .= $indent . $rec['jabatan_nm'];
                $html .= "</option>";
                $html .= $this->_get_selectbox_jabatan($rec['jabatan_id'], $indent, $parent_selected);
                $no++;
            }
        }
        return $html;
    }

    // proses tambah
    public function add_process() {
        // set page rules
        $this->_set_page_rule("C");
        // cek input
        $this->tnotification->set_rules('parent_id', 'Induk Menu', 'trim');
        $this->tnotification->set_rules('jabatan_nm', 'Judul', 'trim|required|max_length[50]');
        $this->tnotification->set_rules('grup', 'Grup', 'trim|required|max_length[50]');
        // process
        if ($this->tnotification->run() !== FALSE) {
            // params
            $params = array(
                'parent_id' => $this->input->post('parent_id', TRUE),
                'jabatan_nm' => $this->input->post('jabatan_nm', TRUE),
                'grup' => $this->input->post('grup', TRUE),
            );
            // insert
            if ($this->m_jabatan->insert_jabatan($params)) {
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

    // form edit
    public function edit($jabatan_id = '') {
        // set page rules
        $this->_set_page_rule("U");
        // set template content
        $this->smarty->assign("template_content", "master/jabatan/edit.html");
        // get data
        $result = $this->m_jabatan->get_detail_jabatan_by_id($jabatan_id);
        $this->smarty->assign("result", $result);
        // notification
        $this->tnotification->display_notification();
        $this->tnotification->display_last_field();
        // get last
        $result_field = $this->tnotification->get_field_data();
        if (isset($result_field['parent_id']['postdata'])) {
            $parent_selected = isset($result_field['parent_id']['postdata']) ? $result_field['parent_id']['postdata'] : $result['parent_id'];
        } else {
            $parent_selected = $result['parent_id'];
        }
        // get list parent
        $html = $this->_get_selectbox_jabatan(0, "", $parent_selected);
        $this->smarty->assign("list_parent", $html);
        // output
        parent::display();
    }

    // edit process
    public function edit_process() {
        // set page rules
        $this->_set_page_rule("U");
        // cek input
        $this->tnotification->set_rules('jabatan_id', 'ID', 'trim|required');
        $this->tnotification->set_rules('parent_id', 'Induk Menu', 'trim');
        $this->tnotification->set_rules('jabatan_nm', 'Judul', 'trim|required|max_length[50]');
        $this->tnotification->set_rules('grup', 'Grup', 'trim|required|max_length[50]');
        // jika parent dan id jabatan sama
        if ($this->input->post('parent_id', TRUE) == $this->input->post('jabatan_id', TRUE)) {
            $this->tnotification->set_error_message("Induk Menu tidak boleh pada diri sendiri");
        }
        // process
        if ($this->tnotification->run() !== FALSE) {
            // params
            $params = array(
                'parent_id' => $this->input->post('parent_id', TRUE),
                'jabatan_nm' => $this->input->post('jabatan_nm', TRUE),
                'grup' => $this->input->post('grup', TRUE)
            );
            // where
            $where = array(
                'jabatan_id' => $this->input->post('jabatan_id', TRUE),
            );
            // update
            if ($this->m_jabatan->update_jabatan($params, $where)) {
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

    // form hapus
    public function delete($jabatan_id = '') {
        // set page rules
        $this->_set_page_rule("D");
        // set template content
        $this->smarty->assign("template_content", "master/jabatan/delete.html");
        // get data
        $result = $this->m_jabatan->get_detail_jabatan_by_id($jabatan_id);
        $this->smarty->assign("result", $result);
        // get parent
        $parent = $this->m_jabatan->get_detail_jabatan_by_id($result['parent_id']);
        $this->smarty->assign("parent", $parent);
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
        $this->tnotification->set_rules('jabatan_id', 'Jabatan ID', 'trim|required');
        // check child
        $params = array(
            $this->input->post('jabatan_id', TRUE),
        );
        $child = $this->m_jabatan->get_all_jabatan_by_parent($params);
        if (!empty($child)) {
            $this->tnotification->set_error_message('Hapus / pindahkan terlebih dahulu menu anaknya!');
        }
        // process
        if ($this->tnotification->run() !== FALSE) {
            $params = array(
                'jabatan_id' => $this->input->post('jabatan_id', TRUE),
            );
            // delete
            if ($this->m_jabatan->delete_jabatan($params)) {
                $this->tnotification->delete_last_field();
                $this->tnotification->sent_notification("deleted", "Data berhasil dihapus");
                // default redirect
                $response = $this->tnotification->display_response();
                $this->tnotification->clear_session();
                $response['redirect'] = site_url('master/jabatan');
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