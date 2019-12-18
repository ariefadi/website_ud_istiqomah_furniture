<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
// load base class if needed
require_once( APPPATH . 'controllers/base/OperatorBase.php' );

// --

class menu extends ApplicationBase {

    protected $list_parent = array();

    // constructor
    public function __construct() {
        // parent constructor
        parent::__construct();
        // load
        $this->load->model('m_settings');
        $this->load->library('tnotification');

        //page header
        $this->smarty->assign("page_title","Navigation");
        // load js
		$this->smarty->load_javascript('resource/js/vue-js/axios.min.js');
		$this->smarty->load_javascript('resource/js/vue-js/vue.js');
		$this->smarty->load_javascript('resource/js/vue-js/vue-custom.js');
		$this->smarty->load_javascript('resource/js/vue-js/vue-plugins/vuejs-paginate/index.js');
    }

    // list portal menu
    public function index() {
        // set page rules
        $this->_set_page_rule("R");
        // set template content
        $this->smarty->assign("template_content", "settings/menu/index.html");
        // get data
        $this->smarty->assign("rs_id", $this->m_settings->get_all_portal_menu());
        // notification
        $this->tnotification->display_notification();
        $this->tnotification->display_last_field();
        // output
        parent::display();
    }

    // list navigasi by portal
    public function navigation($portal_id = '') {
        // set page rules
        $this->_set_page_rule("R");
        // set template content
        $this->smarty->assign("template_content", "settings/menu/navigation.html");
        // get data portal
        $portal = $this->m_settings->get_portal_by_id($portal_id);
        if (empty($portal)) {
            redirect('settings/menu');
        }
        $this->smarty->assign("portal", $portal);
        // get data menu
        $html = $this->_get_menu_by_portal($portal_id, 0, "");
        $this->smarty->assign("html", $html);
        // notification
        $this->tnotification->display_notification();
        $this->tnotification->display_last_field();

        // output
        parent::display();
    }

    // get menu
    private function _get_menu_by_portal($portal_id, $parent_id, $indent) {
        $html = "";
        $params = array($portal_id, $parent_id);
        $rs_id = $this->m_settings->get_all_menu_by_parent($params);
        if ($rs_id) {
            $no = 0;
            $indent .= "--- ";
            foreach ($rs_id as $rec) {
                // url
                $url_edit = site_url('settings/menu/edit/' . $portal_id . '/' . $rec['nav_id']);
                $url_hapus = site_url('settings/menu/delete/' . $portal_id . '/' . $rec['nav_id']);
                // icon
                $icon = '';
                if (!empty($rec['nav_icon'])) {
                    $icon = '<i class="' . $rec['nav_icon'] . '"></i>';
                }
                // parse
                $html .= "<tr>";
                $html .= "<td class='text-center'>" . $icon . "</td>";
                $html .= "<td>" . $indent . $rec['nav_title'] . "</td>";
                $html .= "<td>" . $rec['nav_url'] . "</td>";
                $html .= "<td class='text-center'>" . $rec['active_st'] . "</td>";
                $html .= "<td class='text-center'>" . $rec['display_st'] . "</td>";
                $html .= "<td class='text-center'>";
                $html .= "<a href='" . $url_edit . "' class='' data-toggle='tooltip' data-placement='top' title='Edit'><i class='fa fa-pencil text-info m-r-10'></i></a>&nbsp;";
                $html .= "<a href='" . $url_hapus . "' class='' data-toggle='tooltip' data-placement='top' title='Hapus'><i class='fa fa-times text-danger m-r-10'></i></a>";
                $html .= "</td>";
                $html .= "</tr>";
                $html .= $this->_get_menu_by_portal($rec['portal_id'], $rec['nav_id'], $indent);
                $no++;
            }
        }
        return $html;
    }

    // form tambah menu
    public function add($portal_id = "") {
        // set page rules
        $this->_set_page_rule("C");
        // set template content
        $this->smarty->assign("template_content", "settings/menu/add.html");
        // get data portal
        $portal = $this->m_settings->get_portal_by_id($portal_id);
        if (empty($portal)) {
            $response = $this->tnotification->display_response();
            $this->tnotification->clear_session();
            echo json_encode($response);
            return;
        }
        $this->smarty->assign("portal", $portal);
        // notification
        $this->tnotification->display_notification();
        $this->tnotification->display_last_field();
        // get last field
        $result = $this->tnotification->get_field_data();
        $parent_selected = isset($result['parent_id']['postdata']) ? $result['parent_id']['postdata'] : 0;
        // get list parent
        $list_parent = $this->_get_arr_menu($portal_id, 0, "", $parent_selected, 0, array());
        $this->smarty->assign("list_parent", $list_parent);
        // output
        parent::display();
    }

    // get menu selectbox
    private function _get_menu_selectbox_by_portal($portal_id, $parent_id, $indent, $parent_selected) {
        $html = "";
        $params = array($portal_id, $parent_id);
        $rs_id = $this->m_settings->get_all_menu_by_parent($params);
        if ($rs_id) {
            $no = 0;
            $indent .= "--- ";
            foreach ($rs_id as $rec) {
                // selected
                $selected = ($parent_selected == $rec['nav_id']) ? 'selected="selected"' : '';
                // parse
                $html .= "<option value='" . $rec['nav_id'] . "' " . $selected . ">";
                $html .= $indent . $rec['nav_title'];
                $html .= "</option>";
                $html .= $this->_get_menu_selectbox_by_portal($rec['portal_id'], $rec['nav_id'], $indent, $parent_selected);
                $no++;
            }
        }
        return $html;
    }

    protected function _get_arr_menu($portal_id, $parent_id, $indent, $parent_selected, $no, $arr_menu){
        $params = array($portal_id, $parent_id);
        $rs_id = $this->m_settings->get_all_menu_by_parent($params);
        if ($rs_id) {
            $indent .= "--- ";
            foreach ($rs_id as $rec) {
                $arr_menu[] = array(
                    'nav_id' => $rec['nav_id'],
                    'nav_title' => $indent . $rec['nav_title']
                    );
                $no++;
                $arr_menu = $this->_get_arr_menu($rec['portal_id'], $rec['nav_id'], $indent, $parent_selected, $no, $arr_menu);

            }
        }

        return $arr_menu;
    }

    // proses tambah
    public function process_add() {
        // set page rules
        $this->_set_page_rule("C");
        // cek input
        $this->tnotification->set_rules('portal_id', 'Web Portal', 'trim|required');
        $this->tnotification->set_rules('parent_id', 'Induk Menu', 'trim');
        $this->tnotification->set_rules('nav_title', 'Judul', 'trim|required|max_length[50]');
        $this->tnotification->set_rules('nav_desc', 'Deskripsi', 'trim|required|max_length[100]');
        $this->tnotification->set_rules('nav_url', 'Alamat Menu', 'trim|required|max_length[100]');
        $this->tnotification->set_rules('nav_no', 'Urutan', 'trim|required|max_length[5]');
        $this->tnotification->set_rules('active_st', 'Digunakan', 'trim|required');
        $this->tnotification->set_rules('display_st', 'Ditampilkan', 'trim|required');
        $this->tnotification->set_rules('nav_icon', 'Icon Class', 'trim|max_length[50]');
        // nav id
        $nav_id = $this->m_settings->get_nav_last_id($this->input->post('portal_id', TRUE));
        if (!$nav_id) {
            $this->tnotification->set_error_message('ID is not available');
        }
        $nav_title = $this->input->post('nav_title', TRUE);
        if($this->m_settings->is_exists_judul_nav($nav_title)){
            $this->tnotification->set_error_message("Judul Menu ".$nav_title." sudah digunakan");
            $this->tnotification->sent_notification("error","Data Menu Gagal Disimpan");
            $response = $this->tnotification->display_response();
            $this->tnotification->clear_session();
            echo json_encode($response);
            return;
        }  
        // process
        if ($this->tnotification->run() !== FALSE) {
                // params
            $params = array(
                'nav_id' => $nav_id,
                'portal_id' => $this->input->post('portal_id', TRUE),
                'parent_id' => $this->input->post('parent_id', TRUE),
                'nav_title' => $nav_title,
                'nav_desc' => $this->input->post('nav_desc', TRUE),
                'nav_url' => $this->input->post('nav_url', TRUE),
                'nav_no' => $this->input->post('nav_no', TRUE),
                'active_st' => $this->input->post('active_st', TRUE),
                'display_st' => $this->input->post('display_st', TRUE),
                'nav_icon' => $this->input->post('nav_icon', TRUE),
                'mdb' => $this->com_user['user_id'],
                'mdb_name' => $this->com_user['nama'],
                'mdd' => date("Y-m-d H:i:s")
                );
                // insert
            if ($this->m_settings->insert_menu($params)) {
                //insert com_menu_modul
                $params = array(
                "modul_id" => '00000001',
                "nav_id" => $nav_id
                );
                $this->m_settings->insert_modul_menu($params);

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
    public function edit($portal_id = '', $nav_id = '') {
        // set page rules
        $this->_set_page_rule("U");
        // set template content
        $this->smarty->assign("template_content", "settings/menu/edit.html");
        // get data portal
        $portal = $this->m_settings->get_portal_by_id($portal_id);
        if (empty($portal)) {
            $response = $this->tnotification->display_response();
            $this->tnotification->clear_session();
            echo json_encode($response);
            return;
        }
        $this->smarty->assign("portal", $portal);
        // get data
        $result = $this->m_settings->get_detail_menu_by_id($nav_id);
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
        $list_parent = $this->_get_arr_menu($portal_id, 0, "", $parent_selected, 0, array());
        $this->smarty->assign("list_parent", $list_parent);

        // // get list parent
        // $html = $this->_get_menu_selectbox_by_portal($portal_id, 0, "", $parent_selected);
        // $this->smarty->assign("list_parent", $html);
        // output
        parent::display();
    }

    // edit process
    public function process_update() {
        // set page rules
        $this->_set_page_rule("U");
        // cek input
        $this->tnotification->set_rules('nav_id', 'ID', 'trim|required');
        $this->tnotification->set_rules('portal_id', 'Web Portal', 'trim|required');
        $this->tnotification->set_rules('parent_id', 'Induk Menu', 'trim');
        $this->tnotification->set_rules('nav_title', 'Judul', 'trim|required|max_length[50]');
        $this->tnotification->set_rules('nav_desc', 'Deskripsi', 'trim|required|max_length[100]');
        $this->tnotification->set_rules('nav_url', 'Alamat Menu', 'trim|required|max_length[100]');
        $this->tnotification->set_rules('nav_no', 'Urutan', 'trim|required|max_length[5]');
        $this->tnotification->set_rules('active_st', 'Digunakan', 'trim|required');
        $this->tnotification->set_rules('display_st', 'Ditampilkan', 'trim|required');
        $this->tnotification->set_rules('nav_icon', 'Icon Class', 'trim|max_length[50]');
        // jika parent dan nav sama
        if ($this->input->post('parent_id',TRUE) == $this->input->post('nav_id',TRUE)) {
            $this->tnotification->set_error_message("Induk Menu tidak boleh pada diri sendiri");
        }
        // process
        if ($this->tnotification->run() !== FALSE) {
            $nav_title = $this->input->post('nav_title', TRUE);
            $old_nav_title = $this->input->post('old_nav_title', TRUE);
            if($nav_title != $old_nav_title){
                if($this->m_settings->is_exists_judul_nav($nav_title)){
                $this->tnotification->set_error_message("Judul Menu ".$nav_title." sudah digunakan");
                $this->tnotification->sent_notification("error","Data Menu Gagal Disimpan");
                $response = $this->tnotification->display_response();
                $this->tnotification->clear_session();
                echo json_encode($response);
                return;
            }
        }
        // params
        $params = array(
            'parent_id' => $this->input->post('parent_id', TRUE),
            'nav_title' => $nav_title,
            'nav_desc' => $this->input->post('nav_desc', TRUE),
            'nav_url' => $this->input->post('nav_url', TRUE),
            'nav_no' => $this->input->post('nav_no', TRUE),
            'active_st' => $this->input->post('active_st', TRUE),
            'display_st' => $this->input->post('display_st', TRUE),
            'nav_icon' => $this->input->post('nav_icon', TRUE),
            'mdb' => $this->com_user['user_id'],
            'mdb_name' => $this->com_user['nama'],
            'mdd' => date("Y-m-d H:i:s")
            );
            // where
            $where = array(
                'nav_id' => $this->input->post('nav_id', TRUE),
                'portal_id' => $this->input->post('portal_id', TRUE),
            );
            // update
            if ($this->m_settings->update_menu($params, $where)) {
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
    public function delete($portal_id = '', $nav_id = '') {
        // set page rules
        $this->_set_page_rule("D");
        // set template content
        $this->smarty->assign("template_content", "settings/menu/delete.html");
        // get data portal
        $portal = $this->m_settings->get_portal_by_id($portal_id);
        if (empty($portal)) {
            $response = $this->tnotification->display_response();
            $this->tnotification->clear_session();
            echo json_encode($response);
            return;
        }
        $this->smarty->assign("portal", $portal);
        // get data
        $result = $this->m_settings->get_detail_menu_by_id($nav_id);
        $this->smarty->assign("result", $result);
        // get parent
        $parent = $this->m_settings->get_detail_menu_by_id($result['parent_id']);
        $this->smarty->assign("parent", $parent);
        // notification
        $this->tnotification->display_notification();
        $this->tnotification->display_last_field();
        // output
        parent::display();
    }

    // hapus process
    public function process_delete() {
        // set page rules
        $this->_set_page_rule("D");
        // cek input
        $this->tnotification->set_rules('nav_id', 'Menu ID', 'trim|required');
        $this->tnotification->set_rules('portal_id', 'Web Portal', 'trim|required');
        // check child
        $params = array(
            $this->input->post('portal_id', TRUE),
            $this->input->post('nav_id', TRUE),
        );
        $child = $this->m_settings->get_all_menu_by_parent($params);
        if (!empty($child)) {
            $this->tnotification->set_error_message('Hapus / pindahkan terlebih dahulu menu anaknya!');
        }
            // process
        if ($this->tnotification->run() !== FALSE) {
            $params = array(
                'portal_id' => $this->input->post('portal_id',TRUE),
                'nav_id' => $this->input->post('nav_id',TRUE),
                );
            // delete
            if ($this->m_settings->delete_menu($params)) {
                    // notification
                $this->tnotification->delete_last_field();
                $this->tnotification->sent_notification("deleted", "Data berhasil dihapus");
                    // default redirect
                $response = $this->tnotification->display_response();
                $response['redirect'] = site_url('settings/menu/navigation/' . $this->input->post('portal_id',TRUE));
                $this->tnotification->clear_session();
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

    // public function get_list_parent(){

    //     $portal_id = $this->input->post('portal_id', TRUE) ?: $this->input->get('portal_id', TRUE);
    //     $list_parent = $this->_get_arr_menu($portal_id, 0, "", $parent_selected, 0, array());

    //     echo json_encode($list_parent);
    // }

}
