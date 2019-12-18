<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
// load base class if needed
require_once( APPPATH . 'controllers/base/OperatorBase.php' );

// --

class roles extends ApplicationBase {

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
        $this->smarty->assign("page_title","Roles");
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
        $this->smarty->assign("template_content", "settings/roles/index.html");
        // load
        $this->smarty->load_javascript('resource/themes/default/plugins/velocity/velocity.min.js');
        $this->smarty->load_javascript('resource/themes/default/plugins/velocity/velocity.ui.min.js');
        // get search parameter
        $search = $this->tsession->userdata('search_roles');
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
        $config['base_url'] = site_url("settings/roles/index/");
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

    public function get_data_roles(){
        $this->load->library("pagination");
    
        //get session
        $search = $this->tsession->userdata("search_roles");
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
        $this->tsession->set_userdata("search_roles",$params);
        $response = $this->get_data_roles();
    }

    public function reset_search(){
        $this->_set_page_rule("R");
        $this->tsession->unset_userdata("search_roles");
        $response = $this->get_data_roles();
    }
    

    // add form
    public function add() {
        // set page rules
        $this->_set_page_rule("C");
        // set template content
        $this->smarty->assign("template_content", "settings/roles/add.html");
        // get data
        $this->smarty->assign("rs_group", $this->m_settings->get_all_group());
        $this->smarty->assign("rs_portal", $this->m_settings->get_all_portal());
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
        $this->tnotification->set_rules('group_id', 'Group', 'trim|required|max_length[2]');
        $this->tnotification->set_rules('portal_id', 'Portal', 'trim|required|max_length[2]');
        $this->tnotification->set_rules('role_nm', 'Role Name', 'trim|required|max_length[100]');
        $this->tnotification->set_rules('role_desc', 'Role Description', 'trim|required|max_length[100]');
        $this->tnotification->set_rules('default_page', 'Default Pages', 'trim|required|max_length[50]');
        // role id
        $role_id = $this->m_settings->get_role_last_id($this->input->post('group_id', TRUE));
        if (!$role_id) {
            $this->tnotification->set_error_message('ID is not available');
        }
        $role_nm = $this->input->post('role_nm', TRUE);
		if($this->m_settings->is_exists_nama_role($role_nm)){
			$this->tnotification->set_error_message("Nama Role ".$role_nm." sudah digunakan");
			$this->tnotification->sent_notification("error","Data Roles Gagal Disimpan");
			$response = $this->tnotification->display_response();
	      	$this->tnotification->clear_session();
      		echo json_encode($response);
	  		return;
		}
        // process
        if ($this->tnotification->run() !== FALSE) {
            $params = array(
                'role_id' => $role_id,
                'group_id' => $this->input->post('group_id', TRUE),
                'portal_id' => $this->input->post('portal_id', TRUE),
                'role_nm' => $role_nm,
                'role_desc' => $this->input->post('role_desc', TRUE),
                'default_page' => $this->input->post('default_page', TRUE),
                'mdb' => $this->com_user['user_id'],
                'mdd' => date("Y-m-d H:i:s")
            );
            // insert
            if ($this->m_settings->insert_role($params)) {
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
    public function edit($role_id = "") {
        // set page rules
        $this->_set_page_rule("U");
        // set template content
        $this->smarty->assign("template_content", "settings/roles/edit.html");
        // get data
        $this->smarty->assign("rs_group", $this->m_settings->get_all_group());
        $this->smarty->assign("rs_portal", $this->m_settings->get_all_portal());
        // get data
        $result = $this->m_settings->get_detail_role_by_id($role_id);
        // check
        if (empty($result)) {
            // default error
            $this->tnotification->sent_notification("error", "Data yang anda pilih tidak terdaftar!");
            $response = $this->tnotification->display_response();
            $this->tnotification->clear_session();
            echo json_encode($response);
            return;
        }
        $this->smarty->assign("result", $result);
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
        $this->tnotification->set_rules('role_id', 'ID Role', 'trim|required');
        $this->tnotification->set_rules('group_id', 'Group', 'trim|required|max_length[2]');
        $this->tnotification->set_rules('portal_id', 'Portal', 'trim|required|max_length[2]');
        $this->tnotification->set_rules('role_nm', 'Role Name', 'trim|required|max_length[100]');
        $this->tnotification->set_rules('role_desc', 'Role Description', 'trim|required|max_length[100]');
        $this->tnotification->set_rules('default_page', 'Default Pages', 'trim|required|max_length[50]');
        // process
        if ($this->tnotification->run() !== FALSE) {
            $role_nm = $this->input->post('role_nm', TRUE);
			$old_role_nm = $this->input->post('old_role_nm', TRUE);
			if($role_nm != $old_role_nm){
				if($this->m_settings->is_exists_nama_role($role_nm)){
					$this->tnotification->set_error_message("Nama Role ".$role_nm." sudah digunakan");
					$this->tnotification->sent_notification("error","Data Roles Gagal Disimpan");
					$response = $this->tnotification->display_response();
		            $this->tnotification->clear_session();
		            echo json_encode($response);
		            return;
				}
			}
            $params = array(
                'role_nm' => $role_nm,
                'group_id' => $this->input->post('group_id', TRUE),
                'portal_id' => $this->input->post('portal_id', TRUE),
                'role_desc' => $this->input->post('role_desc', TRUE),
                'default_page' => $this->input->post('default_page', TRUE),
                'mdb' => $this->com_user['user_id'],
                'mdd' => date("Y-m-d H:i:s")
            );
            $where = array(
                'role_id' => $this->input->post('role_id', TRUE)
            );
            // update
            if ($this->m_settings->update_role($params, $where)) {
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
    public function delete($role_id = "") {
        // set page rules
        $this->_set_page_rule("D");
        // set template content
        $this->smarty->assign("template_content", "settings/roles/delete.html");
        // get data
        $result = $this->m_settings->get_detail_role_by_id($role_id);
        // check
        if (empty($result)) {
            // default error
            $this->tnotification->sent_notification("error", "Data yang anda pilih tidak terdaftar!");
            $response = $this->tnotification->display_response();
			$this->tnotification->clear_session();
			echo json_encode($response);
			return;
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
        $this->tnotification->set_rules('role_id', 'ID Role', 'trim|required');
        // process
        if ($this->tnotification->run() !== FALSE) {
            $params = array(
                'role_id' => $this->input->post('role_id', TRUE)
            );
            // delete
            if ($this->m_settings->delete_role($params)) {
                $this->tnotification->delete_last_field();
                $this->tnotification->sent_notification("deleted", "Data berhasil dihapus");
                // default redirect
                $response = $this->tnotification->display_response();
				$response['redirect'] = site_url('settings/roles');
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

}
