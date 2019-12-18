<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
// load base class if needed
require_once( APPPATH . 'controllers/base/OperatorBase.php' );

// --

class visi_misi extends ApplicationBase {

    protected $per_page = 10;

    // constructor
    public function __construct() {
        // parent constructor
        parent::__construct();
        // load model
        $this->load->model('profil/m_visi_misi');
        // load library
        $this->load->library('tnotification');
        $this->load->library('pagination');
        //page header
        $this->smarty->assign("page_title","Visi Misi Perusahaan");
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
        $this->smarty->assign("template_content", "profil/visi_misi/index.html");

        //get session
        $search = $this->tsession->userdata("session_visi_misi");
        $visi_misi_title = empty($search['visi_misi_title']) ? '%': '%'.$search['visi_misi_title'].'%';
        $this->smarty->assign("search",$search);

        //pagination
		/* start of pagination --------------------- */
		$params = array($visi_misi_title);
        $total_rows=$this->m_visi_misi->get_total_data_visi_misi($params);
		$config['base_url'] = site_url("profil/visi_misi/index/");
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
        $rs_result = $this->m_visi_misi->get_all_data_visi_misi(array_merge($params,$limit));
		$this->smarty->assign("rs_result",$rs_result);

        // notification
        $this->tnotification->display_notification();
        $this->tnotification->display_last_field();
        // output
        parent::display();
    }

    public function get_data_visi_misi(){
		$this->load->library('pagination');

		//get session
		$search = $this->tsession->userdata("session_visi_misi");
		$visi_misi_title = empty($search['visi_misi_title']) ? '%': '%'.$search['visi_misi_title'].'%';

		$params = array($visi_misi_title);
		$total_rows=$this->m_visi_misi->get_total_data_visi_misi($params);

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
		$response['result'] = $this->m_visi_misi->get_all_data_visi_misi(array_merge($params,$limit));
		$response['search'] = $search;
		echo json_encode($response);
	}

    public function search_process(){
		$this->_set_page_rule("R");

		$params = array(
			"visi_misi_title" => $this->input->post('visi_misi_title',TRUE)
		);
		$this->tsession->set_userdata("session_visi_misi",$params);

		$response = $this->get_data_visi_misi();
	}

    public function reset_search(){
		$this->_set_page_rule("R");

		$this->tsession->unset_userdata("session_visi_misi");
		$response = $this->get_data_visi_misi();
	}

    // add form
    public function add() {
        // set page rules
        $this->_set_page_rule("C");
        // load style
        $this->smarty->load_style('default/plugins/summernote/dist/summernote.css');
        // load javascript
        $this->smarty->load_javascript('resource/themes/default/plugins/summernote/dist/summernote.min.js');
        // set template content
        $this->smarty->assign("template_content", "profil/visi_misi/add.html");
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
        $this->tnotification->set_rules('visi_misi_title', 'Judul Visi Misi', 'trim|required|max_length[100]');
        $this->tnotification->set_rules('visi_misi_title_en', 'Vision Mission Title', 'trim|required|max_length[100]');
        $this->tnotification->set_rules('visi_desc', 'Deskripsi Visi', 'trim|required|max_length[250]');
        $this->tnotification->set_rules('visi_desc_en', 'Vision Description', 'trim|required|max_length[250]');
        $this->tnotification->set_rules('misi_desc', 'Deskripsi Misi', 'trim|required');
        $this->tnotification->set_rules('misi_desc_en', 'Mission Description', 'trim|required');
        $this->tnotification->set_rules('active_st', 'Status Aktif', 'trim|required');
        // visi misi id
        $visi_misi_id = $this->m_visi_misi->generate_visi_misi_id();
        // process
        if ($this->tnotification->run() !== FALSE) {
            $params = array(
                'id_visi_misi' => $visi_misi_id,
                'visi_misi_title' => $this->input->post('visi_misi_title', TRUE),
                'visi_misi_title_en' => $this->input->post('visi_misi_title_en', TRUE),
                'visi_desc' => strip_tags($this->input->post('visi_desc', TRUE)),
                'visi_desc_en' => strip_tags($this->input->post('visi_desc_en', TRUE)),
                'misi_desc' => strip_tags($this->input->post('misi_desc', TRUE)),
                'misi_desc_en' => strip_tags($this->input->post('misi_desc_en', TRUE)),
                'active_st' => $this->input->post('active_st', TRUE),
                'mdb' => $this->com_user['user_id'],
                'mdb_name' => $this->com_user['nama'],
                'mdd' => date("Y-m-d H:i:s")
            );
            // insert
            if ($this->m_visi_misi->insert_visi_misi($params)) {
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
    public function edit($id_visi_misi = "") {
        // set page rules
        $this->_set_page_rule("U");
        // set template content
        $this->smarty->assign("template_content", "profil/visi_misi/edit.html");
        // load style
        $this->smarty->load_style('default/plugins/summernote/dist/summernote.css');
        // load javascript
        $this->smarty->load_javascript('resource/themes/default/plugins/summernote/dist/summernote.min.js');
        // get data
        $result = $this->m_visi_misi->get_detail_visi_misi_by_id($id_visi_misi);
        // check
        if (empty($result)) {
            // default error
            $this->tnotification->sent_notification("error", "Data yang anda pilih tidak terdaftar!");
            redirect("profil/visi_misi");
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
        $this->tnotification->set_rules('id_visi_misi', 'ID Visi Misi', 'trim|required|max_length[10]');
        $this->tnotification->set_rules('visi_misi_title', 'Judul Visi Misi', 'trim|required|max_length[100]');
        $this->tnotification->set_rules('visi_misi_title_en', 'Vision Mission Title', 'trim|required|max_length[100]');
        $this->tnotification->set_rules('visi_desc', 'Deskripsi Visi', 'trim|required|max_length[250]');
        $this->tnotification->set_rules('visi_desc_en', 'Vision Description', 'trim|required|max_length[250]');
        $this->tnotification->set_rules('misi_desc', 'Deskripsi Misi', 'trim|required');
        $this->tnotification->set_rules('misi_desc_en', 'Mission Description', 'trim|required');
        $this->tnotification->set_rules('active_st', 'Status Aktif', 'trim|required');
        // process
        $id_visi_misi = $this->input->post('id_visi_misi', TRUE);
        if ($this->tnotification->run() !== FALSE) {
            $params = array(
                'visi_misi_title' => $this->input->post('visi_misi_title', TRUE),
                'visi_misi_title_en' => $this->input->post('visi_misi_title_en', TRUE),
                'visi_desc' => strip_tags($this->input->post('visi_desc', TRUE)),
                'visi_desc_en' => strip_tags($this->input->post('visi_desc_en', TRUE)),
                'misi_desc' => strip_tags($this->input->post('misi_desc', TRUE)),
                'misi_desc_en' => strip_tags($this->input->post('misi_desc_en', TRUE)),
                'active_st' => $this->input->post('active_st', TRUE),
                'mdb' => $this->com_user['user_id'],
                'mdb_name' => $this->com_user['nama'],
                'mdd' => date("Y-m-d H:i:s")
            );
            $where = array(
                'id_visi_misi' => $id_visi_misi
            );
            // update
            if ($this->m_visi_misi->update_visi_misi($params, $where)) {
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
    public function delete($id_visi_misi = "") {
        // set page rules
        $this->_set_page_rule("D");
        // set template content
        $this->smarty->assign("template_content", "profil/visi_misi/delete.html");
        // get data
        $result = $this->m_visi_misi->get_detail_visi_misi_by_id($id_visi_misi);
        // check
        if (empty($result)) {
            // default error
            $this->tnotification->sent_notification("error", "Data yang anda pilih tidak terdaftar!");
            redirect("profil/visi_misi");
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
        $this->tnotification->set_rules('id_visi_misi', 'ID Visi Misi', 'trim|required|max_length[10]');
        // process
        if ($this->tnotification->run() !== FALSE) {
            $params = array(
                'id_visi_misi' => $this->input->post('id_visi_misi', TRUE)
            );
            // delete
            if ($this->m_visi_misi->delete_visi_misi($params)) {
                $this->tnotification->delete_last_field();
                $this->tnotification->sent_notification("deleted", "Data berhasil dihapus");
                // default redirect
                $response = $this->tnotification->display_response();
                $this->tnotification->clear_session();
                $response['redirect'] = site_url('profil/visi_misi');
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
