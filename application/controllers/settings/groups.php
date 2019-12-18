<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
// load base class if needed
require_once( APPPATH . 'controllers/base/OperatorBase.php' );


class groups extends ApplicationBase {

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
        $this->smarty->assign("page_title","Groups");
        // load js
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
        $this->smarty->assign("template_content", "settings/groups/index.html");

        //get session
        $search = $this->tsession->userdata("session_settings_groups");
        $group_name = empty($search['group_name']) ? '%': '%'.$search['group_name'].'%';
        $this->smarty->assign("search",$search);

        //pagination
		/* start of pagination --------------------- */
		$params = array($group_name);
        $total_rows=$this->m_settings->count_all_group($params);
		$config['base_url'] = site_url("settings/groups/index/");
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
        $rs_result = $this->m_settings->get_all_group_limit(array_merge($params,$limit));
		$this->smarty->assign("rs_result",$rs_result);

        // notification
        $this->tnotification->display_notification();
        $this->tnotification->display_last_field();
        // output
        parent::display();
    }

    public function get_data_groups(){
		$this->load->library('pagination');

		//get session
		$search = $this->tsession->userdata("session_settings_groups");
		$group_name = empty($search['group_name']) ? '%': '%'.$search['group_name'].'%';

		$params = array($group_name);
		$total_rows=$this->m_settings->count_all_group($params);

        $page_num = $this->input->post('page_num', TRUE) ?: $this->input->get('page_num', TRUE);
		$page_num = empty($page_num) ? 1 : $page_num;

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
		$response['result'] = $this->m_settings->get_all_group_limit(array_merge($params,$limit));
		$response['search'] = $search;
		echo json_encode($response);
	}

    public function search_process(){
		$this->_set_page_rule("R");

		$params = array(
			"group_name" => $this->input->post('group_name',TRUE)
		);
		$this->tsession->set_userdata("session_settings_groups",$params);

		$response = $this->get_data_groups();
	}

    public function reset_search(){
		$this->_set_page_rule("R");

		$this->tsession->unset_userdata("session_settings_groups");
		$response = $this->get_data_groups();
	}


    // add form
    public function add() {
        // set page rules
        $this->_set_page_rule("C");
        // set template content
        $this->smarty->assign("template_content", "settings/groups/add.html");
        // Get Data Portal
		$rs_portal = $this->m_settings->get_all_portal();
		$this->smarty->assign("rs_portal",$rs_portal);
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
        $this->tnotification->set_rules('group_name', 'Nama Group', 'trim|required|max_length[50]');
        $this->tnotification->set_rules('group_desc', 'Deskripsi Group', 'trim|required|max_length[100]');
        // group id
        $group_id = $this->m_settings->get_group_last_id();
        if (!$group_id) {
            $this->tnotification->set_error_message('ID is not available');
        }
        $group_name = $this->input->post('group_name', TRUE);
		if($this->m_settings->is_exists_nama_group($group_name)){
			$this->tnotification->set_error_message("Nama Group ".$group_name." sudah digunakan");
			$this->tnotification->sent_notification("error","Data Groups Gagal Disimpan");
			$response = $this->tnotification->display_response();
	      	$this->tnotification->clear_session();
      		echo json_encode($response);
	  		return;
		}
        // process
        if ($this->tnotification->run() !== FALSE) {
            $params = array(
                'group_id' => $group_id,
                'group_name' => $group_name,
                'group_desc' => $this->input->post('group_desc', TRUE),
                'portal_id' => $this->input->post('portal_id', TRUE),
                'mdb' => $this->com_user['user_id'],
                'mdb_name' => $this->com_user['nama'],
                'mdd' => date("Y-m-d H:i:s")
                );
            // insert
            if ($this->m_settings->insert_group($params)) {
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
    public function edit($group_id = "") {
        // set page rules
        $this->_set_page_rule("U");
        // set template content
        $this->smarty->assign("template_content", "settings/groups/edit.html");
        // get data
        $result = $this->m_settings->get_group_by_id($group_id);
        // Get Data Portal
		$rs_portal = $this->m_settings->get_all_portal();
		$this->smarty->assign("rs_portal",$rs_portal);
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
        $this->tnotification->set_rules('group_id', 'Group ID', 'trim|required|max_length[2]');
        $this->tnotification->set_rules('group_name', 'Nama Group', 'trim|required|max_length[50]');
        $this->tnotification->set_rules('group_desc', 'Deskripsi Group', 'trim|required|max_length[100]');
        // process
        if ($this->tnotification->run() !== FALSE) {
            $group_name = $this->input->post('group_name', TRUE);
			$old_group_name = $this->input->post('old_group_name', TRUE);
			if($group_name != $old_group_name){
				if($this->m_settings->is_exists_nama_group($group_name)){
					$this->tnotification->set_error_message("Nama Group ".$group_name." sudah digunakan");
					$this->tnotification->sent_notification("error","Data Groups Gagal Disimpan");
					$response = $this->tnotification->display_response();
		            $this->tnotification->clear_session();
		            echo json_encode($response);
		            return;
				}
			}
            $params = array(
                'group_name' => $group_name,
                'group_desc' => $this->input->post('group_desc', TRUE),
                'portal_id' => $this->input->post('portal_id', TRUE),
                'mdb' => $this->com_user['user_id'],
                'mdb_name' => $this->com_user['nama'],
                'mdd' => date("Y-m-d H:i:s")
                );
            $where = array(
                'group_id' => $this->input->post('group_id', TRUE)
            );
            // update
            if ($this->m_settings->update_group($params, $where)) {
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
    public function delete($group_id = "") {
        // set page rules
        $this->_set_page_rule("D");
        // set template content
        $this->smarty->assign("template_content", "settings/groups/delete.html");
        // get data
        $result = $this->m_settings->get_group_by_id($group_id);
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
        $this->tnotification->set_rules('group_id', 'Group ID', 'trim|required|max_length[2]');
        // process
        if ($this->tnotification->run() !== FALSE) {
            $params = array(
                'group_id' => $this->input->post('group_id', TRUE)
            );
            // delete
            if ($this->m_settings->delete_group($params)) {
                $this->tnotification->delete_last_field();
                $this->tnotification->sent_notification("deleted", "Data berhasil dihapus");
                // default redirect
                $response = $this->tnotification->display_response();
				$response['redirect'] = site_url('settings/groups');
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
