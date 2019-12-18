<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
// load base class if needed
require_once( APPPATH . 'controllers/base/OperatorBase.php' );

// --

class struktur_organisasi extends ApplicationBase {

    protected $per_page = 10;

    // constructor
    public function __construct() {
        // parent constructor
        parent::__construct();
        // load model
        $this->load->model('profil/m_struktur_organisasi');
        $this->load->model('master/m_jabatan');
        $this->load->model('profil/m_struktur');
        // load helper
        $this->load->helper('url');
        // load library
        $this->load->library('tnotification');
        $this->load->library('pagination');
        $this->load->library("tupload");
        $this->load->library('session');
        //page header
        $this->smarty->assign("page_title","Struktur Organisasi");
        // load css
        $this->smarty->load_style('default/plugins/bootstrap-datetimepicker/bootstrap-datetimepicker.min.css');
        //load js
        $this->smarty->load_javascript('resource/js/vue-js/axios.min.js');
        $this->smarty->load_javascript('resource/js/vue-js/vue.js');
        $this->smarty->load_javascript('resource/js/vue-js/vue-custom.js');
        $this->smarty->load_javascript('resource/js/vue-js/vue-plugins/vuejs-paginate/index.js');
        $this->smarty->load_javascript('resource/js/vue-js/vue-plugins/vuejs-datepicker/vue-bootstrap-datetimepicker.min.js');
        $this->smarty->load_javascript('resource/themes/default/plugins/bootstrap-datetimepicker/moment-with-locales.min.js');
        $this->smarty->load_javascript('resource/themes/default/plugins/bootstrap-datetimepicker/bootstrap-datetimepicker.min.js');
        $this->smarty->load_javascript('resource/themes/default/plugins/bootstrap-datetimepicker/locale/id.js');
    }

    // list data
    public function index() {
        // set page rules
        $this->_set_page_rule("R");
        // set template content
        $this->smarty->assign("template_content", "profil/struktur_organisasi/index.html");

        //get session
        $search = $this->tsession->userdata("session_struktur_organisasi");
        $kepengurusan_nama = empty($search['kepengurusan_nama']) ? '%': '%'.$search['kepengurusan_nama'].'%';
        $this->smarty->assign("search",$search);

        //pagination
		/* start of pagination --------------------- */
		$params = array($kepengurusan_nama);
        $total_rows=$this->m_struktur_organisasi->get_count_kepengurusan($params);
		$config['base_url'] = site_url("profil/struktur_organisasi/index/");
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
        $rs_result = $this->m_struktur_organisasi->get_all_kepengurusan(array_merge($params,$limit));
		$this->smarty->assign("rs_result",$rs_result);

        // notification
        $this->tnotification->display_notification();
        $this->tnotification->display_last_field();
        // output
        parent::display();
    }

    public function get_data_struktur_organisasi(){
		$this->load->library('pagination');

		//get session
		$search = $this->tsession->userdata("session_struktur_organisasi");
		$kepengurusan_nama = empty($search['kepengurusan_nama']) ? '%': '%'.$search['kepengurusan_nama'].'%';

		$params = array($kepengurusan_nama);
		$total_rows=$this->m_struktur_organisasi->get_count_kepengurusan($params);

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
		$response['result'] = $this->m_struktur_organisasi->get_all_kepengurusan(array_merge($params,$limit));
		$response['search'] = $search;
		echo json_encode($response);
	}

    public function search_process(){
		$this->_set_page_rule("R");

		$params = array(
			"kepengurusan_nama" => $this->input->post('kepengurusan_nama',TRUE)
		);
		$this->tsession->set_userdata("session_struktur_organisasi",$params);

		$response = $this->get_data_struktur_organisasi();
	}

    public function reset_search(){
		$this->_set_page_rule("R");

		$this->tsession->unset_userdata("session_struktur_organisasi");
		$response = $this->get_data_struktur_organisasi();
    }
    
    public function add() {
        // set page rule
        $this->_set_page_rule("C");
        // set template content
        $this->smarty->assign("template_content", "profil/struktur_organisasi/add.html");
        // notification
        $this->tnotification->display_notification();
        $this->tnotification->delete_last_field();
        // output
        parent::display();
    }

    public function add_process() {
        // set page rule
        $this->_set_page_rule("C");
        // validasi
        $this->tnotification->set_rules("kepengurusan_nama", "Nama Kepengurusan", "trim|required");
        $this->tnotification->set_rules("kepengurusan_tahun_mulai", "Tahun Mulai Kepengurusan", "trim|required|numeric");
        $this->tnotification->set_rules("kepengurusan_tahun_berakhir", "Tahun Berakhir Kepengurusan", "trim|required|numeric");
        // cek file surat upload
		$file_lampiran = $_FILES['lampiran_file'];
        // cek file size upload
		if ($file_lampiran['size'] > 10485760) {
			// error message
			$this->tnotification->set_error_message('File upload max 10 MB');
		}
        // cek file extension
		$ext = pathinfo($file_lampiran['name'], PATHINFO_EXTENSION);
		$ext_allowed = array('pdf','doc','docx','xls','xlsx');
		if (!in_array($ext, $ext_allowed)) {
			// error message
			$this->tnotification->set_error_message('Jenis file tidak diperbolehkan');
        }
        // parameter to save file
		$prefixdate = date('ymd');
        $params = $prefixdate . '%';
        // cek dan get id kepengurusan
        $kepengurusan_id = $this->m_struktur_organisasi->get_kepengurusan_last_id($prefixdate, $params);
		$kepengurusan_nama = $this->input->post('kepengurusan_nama', TRUE);
        if ($this->tnotification->run() !== FALSE) {
            // upload
            $lampiran_path = '';
            $lampiran_file = '';
            if ($file_lampiran != '') {
                // konfigurasi upload
                $config['upload_path'] = 'resource/doc/files/kepengurusan/'.$kepengurusan_id;
                $config['allowed_types'] = 'doc|docx|pdf|xls|xlsx';
                $config['file_name'] =  'FILE_' . $kepengurusan_id . '_'. $kepengurusan_nama . '.' . $ext;
                $config['max_size'] = 10240;
                $this->tupload->initialize($config);
                // upload process
                if ($this->tupload->do_upload('lampiran_file')) {
                    //ambil data file yang di upload
                    $data = $this->tupload->data();
                    // set link path untuk di simpan di database
                    $lampiran_path = $config['upload_path'];
                    $lampiran_file = $data['file_name'];
                } else {
                    // default error
                    $this->tnotification->sent_notification("error", "Data file gagal diupload");
                }   
            } 
            // params
            $params = array(
                'kepengurusan_id'               => $kepengurusan_id,
                'kepengurusan_nama'             => $kepengurusan_nama,
                'kepengurusan_tahun_mulai'      => $this->input->post('kepengurusan_tahun_mulai', true),
                'kepengurusan_tahun_berakhir'   => $this->input->post('kepengurusan_tahun_berakhir', true),
                'lampiran_path' 			    => $lampiran_path,
                'lampiran_file' 			    => $lampiran_file,
                'mdb'                           => $this->com_user['user_id'],
                'mdd'                           => date('Y-m-d H:i:s')
            );
            // proses simpan
            if ($this->m_struktur_organisasi->insert_kepengurusan($params)) {
                // berhasil
                $this->tnotification->delete_last_field();
                $this->tnotification->sent_notification("success", "Data Kepengurusan Berhasil Disimpan");
            } else {
                // default error
                $this->tnotification->sent_notification("error", "Data Kepengurusan gagal disimpan");
            }
        } else {
            // gagal
            $this->tnotification->sent_notification("error", "Data Kepengurusan Gagal Disimpan");
        }
        // default redirect
        $response = $this->tnotification->display_response();
        $this->tnotification->clear_session();
        echo json_encode($response);
        return;
    }

    public function edit($kepengurusan_id = '') {
        // set page rule
        $this->_set_page_rule("U");
        // set template content
        $this->smarty->assign("template_content", "profil/struktur_organisasi/edit.html");
        // data detail struktur organisasi
        $rs_detail = $this->m_struktur_organisasi->get_kepengurusan_by_id($kepengurusan_id);
        $this->smarty->assign('rs_detail', $rs_detail);
        // notification
        $this->tnotification->display_notification();
        $this->tnotification->delete_last_field();
        // output
        parent::display();
    }

    public function edit_process() {
        // set page rule
        $this->_set_page_rule("U");
        // validasi
        $this->tnotification->set_rules("kepengurusan_id", "ID Kepengurusan", "trim|required");
        $this->tnotification->set_rules("kepengurusan_nama", "Nama Kepengurusan", "trim|required");
        $this->tnotification->set_rules("kepengurusan_tahun_mulai", "Tahun Mulai Kepengurusan", "trim|required|numeric");
        $this->tnotification->set_rules("kepengurusan_tahun_berakhir", "Tahun Berakhir Kepengurusan", "trim|required|numeric");
        // deklarasi variabel 
        $kepengurusan_id = $this->input->post('kepengurusan_id', TRUE);
        $kepengurusan_nama = $this->input->post('kepengurusan_nama', TRUE);
		$old_lampiran_path = $this->input->post('old_lampiran_path', TRUE);
        $old_lampiran_file = $this->input->post('old_lampiran_file', TRUE);
        // cek file surat upload
        $file_lampiran = $_FILES['lampiran_file'];
        if(!empty($file_lampiran['name'])){
            // cek file size upload
            if ($file_lampiran['size'] > 10485760) {
                // error message
                $this->tnotification->set_error_message('File upload max 10 MB');
            }
            // cek file extension
            $ext = pathinfo($file_lampiran['name'], PATHINFO_EXTENSION);
            $ext_allowed = array('pdf','doc','docx','xls','xlsx');
            if (!in_array($ext, $ext_allowed)) {
                // error message
                $this->tnotification->set_error_message('Jenis file tidak diperbolehkan');
            }
            if ($this->tnotification->run() !== FALSE) {
                // upload
                $lampiran_path = '';
                $lampiran_file = '';
                if ($file_lampiran != '') {
                    $path_lama = $old_lampiran_path . '/' . $old_lampiran_file;
                    if (file_exists($path_lama)) {
                        unlink($path_lama);
                    }
                    // konfigurasi upload
                    $config['upload_path'] = 'resource/doc/files/kepengurusan/'.$kepengurusan_id;
                    $config['allowed_types'] = 'doc|docx|pdf|xls|xlsx';
                    $config['file_name'] =  'FILE_' . $kepengurusan_id . '_'. $kepengurusan_nama . '.' . $ext;
                    $config['max_size'] = 10240;
                    $this->tupload->initialize($config);
                    // upload process
                    if ($this->tupload->do_upload('lampiran_file')) {
                        //ambil data file yang di upload
                        $data = $this->tupload->data();
                        // set link path untuk di simpan di database
                        $lampiran_path = $config['upload_path'];
                        $lampiran_file = $data['file_name'];
                    } else {
                        // default error
                        $this->tnotification->sent_notification("error", "Data file gagal diupload");
                    }   
                } 
                // params
                $params = array(
                    'kepengurusan_nama'             => $kepengurusan_nama,
                    'kepengurusan_tahun_mulai'      => $this->input->post('kepengurusan_tahun_mulai', true),
                    'kepengurusan_tahun_berakhir'   => $this->input->post('kepengurusan_tahun_berakhir', true),
                    'lampiran_path' 			    => $lampiran_path,
                    'lampiran_file' 			    => $lampiran_file,
                    'mdb'                           => $this->com_user['user_id'],
                    'mdd'                           => date('Y-m-d H:i:s')
                );
                // where
                $where = array(
                    'kepengurusan_id'               => $kepengurusan_id
                );
                // proses simpan
                if ($this->m_struktur_organisasi->update_kepengurusan($params, $where)) {
                    // berhasil
                    $this->tnotification->delete_last_field();
                    $this->tnotification->sent_notification("updated", "Data Kepengurusan Berhasil Disimpan");
                    // success redirect
                    $response = $this->tnotification->display_response();
                    $this->tnotification->clear_session();
                    $response['redirect'] = site_url('profil/struktur_organisasi');
                    echo json_encode($response);
                    return;
                } else {
                    // default error
                    $this->tnotification->sent_notification("error", "Data Kepengurusan gagal disimpan");
                }
            } else {
                // gagal
                $this->tnotification->sent_notification("error", "Data Kepengurusan Gagal Disimpan");
            }    
        } else {
            if ($this->tnotification->run() !== FALSE) {
                // params
                $params = array(
                    'kepengurusan_nama'             => $kepengurusan_nama,
                    'kepengurusan_tahun_mulai'      => $this->input->post('kepengurusan_tahun_mulai', true),
                    'kepengurusan_tahun_berakhir'   => $this->input->post('kepengurusan_tahun_berakhir', true),
                    'lampiran_path' 			    => $old_lampiran_path,
                    'lampiran_file' 			    => $old_lampiran_file,
                    'mdb'                           => $this->com_user['user_id'],
                    'mdd'                           => date('Y-m-d H:i:s')
                );
                // where
                $where = array(
                    'kepengurusan_id'               => $kepengurusan_id
                );
                // proses simpan
                if ($this->m_struktur_organisasi->update_kepengurusan($params, $where)) {
                    // berhasil
                    $this->tnotification->delete_last_field();
                    $this->tnotification->sent_notification("updated", "Data Kepengurusan Berhasil Disimpan");
                    // success redirect
                    $response = $this->tnotification->display_response();
                    $this->tnotification->clear_session();
                    $response['redirect'] = site_url('profil/struktur_organisasi');
                    echo json_encode($response);
                    return;
                } else {
                    // default error
                    $this->tnotification->sent_notification("error", "Data Kepengurusan gagal disimpan");
                }
            } else {
                // gagal
                $this->tnotification->sent_notification("error", "Data Kepengurusan Gagal Disimpan");
            }                  
        }
        // default redirect
        $response = $this->tnotification->display_response();
        $this->tnotification->clear_session();
        echo json_encode($response);
        return;
    }

    public function delete_process($kepengurusan_id = '') {
        // set page rule
        $this->_set_page_rule("D");
        // data detail struktur organisasi
        $rs_detail = $this->m_struktur_organisasi->get_kepengurusan_by_id($kepengurusan_id);
        $this->smarty->assign('rs_detail', $rs_detail);
        if(!empty($rs_detail)){
            $where = array(
                'kepengurusan_id' => $kepengurusan_id,
            );
            // delete
            if ($this->m_struktur_organisasi->delete_kepengurusan($where)) {
                $path_lama = $rs_detail['lampiran_path'] . '/' . $rs_detail['lampiran_file'];
                if (file_exists($path_lama)) {
                    unlink($path_lama);
                }
                // notification
                $this->tnotification->delete_last_field();
                $this->tnotification->sent_notification("deleted", "Data Kepengurusan berhasil dihapus");
                // success redirect
                $response = $this->tnotification->display_response();
                $this->tnotification->clear_session();
                $response['redirect'] = site_url('profil/struktur_organisasi');
                echo json_encode($response);
                return;
            } else {
                // default error
                $this->tnotification->sent_notification("error", "Data Kepengurusan gagal dihapus");
            }
        } else {
            // default error
            $this->tnotification->sent_notification("error", "Data Kepengurusan gagal dihapus");
        }
        // default redirect
        $response = $this->tnotification->display_response();
		$this->tnotification->clear_session();
		echo json_encode($response);
		return;
    }

    public function download($kepengurusan_id = '') {
		// set page rules
        $this->_set_page_rule("R");
        // load helper
        $this->load->helper('download');
		// get file
        $result = $this->m_struktur_organisasi->get_kepengurusan_by_id($kepengurusan_id);
        if (empty($result)) {
            $this->tnotification->sent_notification("error", "Data tidak ditemukan.");
        } else {
            $path = $result['lampiran_path'];
            $file = $result['lampiran_file'];
            $file_download = $path . '/' . $file;
            if(file_exists($file_download)){
                // get file content
                $data = file_get_contents($file_download);
                // force download
                force_download($file, $data);
            } else {
                // error notification
                $this->tnotification->sent_notification('error', 'Data file tidak tersedia');
            }
        }
        // default redirect
        $response = $this->tnotification->display_response();
		$this->tnotification->clear_session();
		echo json_encode($response);
		return;
	}
}