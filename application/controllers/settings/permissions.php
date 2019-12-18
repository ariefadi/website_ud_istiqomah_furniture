<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
// load base class if needed
require_once( APPPATH . 'controllers/base/OperatorBase.php' );


class permissions extends ApplicationBase {

    protected $per_page = 10;

    // constructor
    public function __construct() {
        // parent constructor
        parent::__construct();
        // load
        $this->load->model('m_settings');
        $this->load->library('tnotification');
        $this->load->library('pagination');

        //page header
        $this->smarty->assign("page_title","Permissions");
        // load js
		$this->smarty->load_javascript('resource/js/vue-js/axios.min.js');
		$this->smarty->load_javascript('resource/js/vue-js/vue.js');
		$this->smarty->load_javascript('resource/js/vue-js/vue-custom.js');
		$this->smarty->load_javascript('resource/js/vue-js/vue-plugins/vuejs-paginate/index.js');
    }

    // list role
    public function index() {
        // set page rules
        $this->_set_page_rule("R");
        // set template content
        $this->smarty->assign("template_content", "settings/permissions/index.html");
        // load javascript
        $this->smarty->load_javascript('resource/themes/default/plugins/velocity/velocity.min.js');
        $this->smarty->load_javascript('resource/themes/default/plugins/velocity/velocity.ui.min.js');
        // get search parameter
        $search = $this->tsession->userdata('session_permissions');
        // search parameters
        $role_nm = empty($search['role_nm']) ? '%' : '%' . $search['role_nm'] . '%';
        $search['role_nm'] = empty($search['role_nm']) ? '' : $search['role_nm'];
        $group_id = empty($search['group_id']) ? '' : $search['group_id'];
        $search['group_id'] = empty($search['group_id']) ? '' : $search['group_id'];
        $portal_id = empty($search['portal_id']) ? '' : $search['portal_id'];
        $search['portal_id'] = empty($search['portal_id']) ? '' : $search['portal_id'];
        $this->smarty->assign("search", $search);

        //pagination
        /* start of pagination --------------------- */
        $params = array($role_nm, $group_id, $portal_id);
        $total_rows=$this->m_settings->count_all_roles($params);
        $config['base_url'] = site_url("settings/permissions/index/");
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

        // get data
        $limit = array(($start - 1), $config['per_page']);
        $rs_result = $this->m_settings->get_all_roles_limit(array_merge($params, $limit));
        $this->smarty->assign("rs_result",$rs_result);
        // data groups
        $this->smarty->assign("rs_group", $this->m_settings->get_all_group());
        // data portal
        $this->smarty->assign("rs_portal", $this->m_settings->get_all_portal());
        // notification
        $this->tnotification->display_notification();
        $this->tnotification->display_last_field();
        // output
        parent::display();
    }

    public function get_data_permissions(){
        $this->load->library("pagination");
    
        //get session
        $search = $this->tsession->userdata("session_permissions");
        $role_nm = empty($search['role_nm']) ? '%' : '%' . $search['role_nm'] . '%';
        $search['role_nm'] = empty($search['role_nm']) ? '' : $search['role_nm'];
        $group_id = empty($search['group_id']) ? '' : $search['group_id'];
        $search['group_id'] = empty($search['group_id']) ? '' : $search['group_id'];
        $portal_id = empty($search['portal_id']) ? '' : $search['portal_id'];
        $search['portal_id'] = empty($search['portal_id']) ? '' : $search['portal_id'];
        
        $params = array($role_nm, $group_id, $portal_id);
        $total_rows = $this->m_settings->count_all_roles($params);
    
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
        $response['result'] = $this->m_settings->get_all_roles_limit(array_merge($params, $limit));
        $response['search'] = $search;
        $response['rs_group'] = $this->m_settings->get_all_group();
        $response['rs_portal'] =  $this->m_settings->get_all_portal();
        echo json_encode($response);
    }

    // search process
    public function search_process() {
        // set page rules
        $this->_set_page_rule("R");
        $params = array(
            "role_nm" => $this->input->post('role_nm', TRUE),
            "group_id" => $this->input->post('group_id', TRUE),
            "portal_id" => $this->input->post('portal_id', TRUE)
        );
        $this->tsession->set_userdata("session_permissions",$params);
        $response = $this->get_data_permissions();
    }

    public function reset_search(){
        $this->_set_page_rule("R");
        $this->tsession->unset_userdata("session_permissions");
        $response = $this->get_data_permissions();
    }

    // list menu by role
    public function access_update($role_id = "") {
        // set page rules
        $this->_set_page_rule("U");
        // set template content
        $this->smarty->assign("template_content", "settings/permissions/access_update.html");

        $result = $this->m_settings->get_detail_role_by_id($role_id);
        // parameter url
        $role = $this->uri->segment(4);
        $this->tsession->set_userdata('data', $role);
        if (empty($result)) {
            // default error
            $this->tnotification->sent_notification("error", "Data yang anda pilih tidak terdaftar!");
            $response = $this->tnotification->display_response();
            $this->tnotification->clear_session();
            echo json_encode($response);
            return;
        }
        $this->smarty->assign("result", $result);
        $rs_portal = $this->m_settings->get_all_portal();
        $this->smarty->assign("rs_portal", $rs_portal);
        // set default_portal for filtering
        $search = $this->tsession->userdata('filter_portal');
        $default_portal_id = (!empty($rs_portal)) ? $rs_portal[0]["portal_id"] : "";
        if (!empty($search)) {
            $default_portal_id = $search["portal_id"];
        }
        $this->smarty->assign("default_portal_id", $default_portal_id);
        // get data menu
        $list_menu = self::_display_menu($default_portal_id, $role_id, 0, "");
        $this->smarty->assign("list_menu", $list_menu);
        // notification
        $this->tnotification->display_notification();
        $this->tnotification->display_last_field();
        // output
        parent::display();
    }

    public function get_data_permissions_administrator(){
        $this->load->library("pagination");
    
        //get session
        $search = $this->tsession->userdata("filter_portal");
        $rs_portal = $this->m_settings->get_all_portal();
        $default_portal_id = (!empty($rs_portal)) ? $rs_portal[0]["portal_id"] : "";
        if (!empty($search)) {
            $default_portal_id = $search["portal_id"];
        }
        // parameter url
        $role_id = $this->tsession->userdata('data');
        // get data menu
        $list_menu = self::_display_menu($default_portal_id, $role_id, 0, "");
        $this->smarty->assign("list_menu", $list_menu);
        
        $response = array();
        $response['result'] = $this->m_settings->get_detail_role_by_id($role_id);
        $response['search'] = $search;
        $response['rs_portal'] = $rs_portal;
        $response['list_menu'] = $list_menu;
        echo json_encode($response);
    }

    // search process
    public function filter_portal_process() {
        // set page rules
        $this->_set_page_rule("R");
        $params = array(
            "portal_id" => $this->input->post('portal_id', TRUE),
        );
        $this->tsession->set_userdata("filter_portal",$params);
        $response = $this->get_data_permissions_administrator();
    }

    private function _display_menu($portal_id, $role_id, $parent_id, $indent) {
        $html = "";
        // get data
        $params = array($role_id, $portal_id, $parent_id);
        $rs_id = $this->m_settings->get_all_menu_selected_by_parent($params);
        if (!empty($rs_id)) {
            $no = 0;
            $indent .= "--- ";
            foreach ($rs_id as $rec) {
                $role_tp = array("C" => "0", "R" => "0", "U" => "0", "D" => "0");
                $i = 0;
                foreach ($role_tp as $rule => $val) {
                    $N = substr($rec['role_tp'], $i, 1);
                    $role_tp[$rule] = $N;
                    $i++;
                }
                $checked = "";
                if (array_sum($role_tp) > 0) {
                    $checked = "checked='true'";
                }
                // parse
                $html .= "<tr>";
                $html .= "<td class='text-center'><label class='ckbox ckbox-primary'><input type='checkbox' class='checked-all r-menu' value='" . $rec['nav_id'] . "' " . $checked . " id=" . $rec['nav_id'] . " /><span></span></label></td>";
                $html .= "<td><label for='" . $rec['nav_id'] . "'>" . $indent . $rec['nav_title'] . "</label></td>";
                $html .= "<td><code>" . $rec['nav_url'] . "</code></td>";
                $html .= "<td class='text-center'><input class='r" . $rec['nav_id'] . " r-menu' type='checkbox' name='rules[" . $rec['nav_id'] . "][C]' value='1' " . ($role_tp['C'] == "1" ? 'checked="true"' : '') . " /></td>";
                $html .= "<td class='text-center'><input class='r" . $rec['nav_id'] . " r-menu' type='checkbox' name='rules[" . $rec['nav_id'] . "][R]' value='1' " . ($role_tp['R'] == "1" ? 'checked="true"' : '') . " /></td>";
                $html .= "<td class='text-center'><input class='r" . $rec['nav_id'] . " r-menu' type='checkbox' name='rules[" . $rec['nav_id'] . "][U]' value='1' " . ($role_tp['U'] == "1" ? 'checked="true"' : '') . " /></td>";
                $html .= "<td class='text-center'><input class='r" . $rec['nav_id'] . " r-menu' type='checkbox' name='rules[" . $rec['nav_id'] . "][D]' value='1' " . ($role_tp['D'] == "1" ? 'checked="true"' : '') . " /></td>";
                $html .= "</tr>";
                $html .= $this->_display_menu($portal_id, $role_id, $rec['nav_id'], $indent);
                $no++;
            }
        }
        return $html;
    }

    // process update
    public function process() {
        // set page rules
        $this->_set_page_rule("U");
        // cek input
        $this->tnotification->set_rules('role_id', 'Role ID', 'trim|required');
        $this->tnotification->set_rules('portal_id', 'Portal ID', 'trim|required');
        // process
        if ($this->tnotification->run() !== FALSE) {
            // delete
            $params = array(
                $this->input->post('role_id', TRUE),
                $this->input->post('portal_id', TRUE),
            );
            $this->m_settings->delete_role_menu($params);
            // insert
            $rules = $this->input->post('rules',TRUE);
            if (is_array($rules)) {
                foreach ($rules as $nav => $rule) {
                    // get rule tipe
                    $role_tp = array("C" => "0", "R" => "0", "U" => "0", "D" => "0");
                    $i = 0;
                    foreach ($role_tp as $tp => $val) {
                        if (isset($rule[$tp])) {
                            $role_tp[$tp] = $rule[$tp];
                        }
                        $i++;
                    }
                    $result = implode("", $role_tp);
                    // insert
                    $params = array($this->input->post('role_id',TRUE), $nav, $result);
                    $this->m_settings->insert_role_menu($params);
                }
            }
            $this->tnotification->sent_notification("success", "Data berhasil disimpan");
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
}
