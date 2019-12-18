<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
// load base class if needed
require_once( APPPATH . 'controllers/base/OperatorBase.php');

class logo extends ApplicationBase {

    // constructor
    public function __construct() {
        // parent constructor
        parent::__construct();
        // load model
        $this->load->model('m_settings');
        $this->load->model('m_preferences');
        // load library
        $this->load->library('tnotification');
        $this->load->library('tftp');
        //page header
        $this->smarty->assign("page_title","Pengaturan Logo");

        //load javascript and css
        $this->smarty->load_style('default/plugins/dropify/dist/css/dropify.min.css');

        // load js
		$this->smarty->load_javascript('resource/js/vue-js/axios.min.js');
		$this->smarty->load_javascript('resource/js/vue-js/vue.js');
		$this->smarty->load_javascript('resource/js/vue-js/vue-custom.js');
		$this->smarty->load_javascript('resource/js/vue-js/vue-plugins/vuejs-paginate/index.js');

    }

    public function index() {
        // set page rules
        $this->_set_page_rule("R");
        // set template content
        $this->smarty->assign("template_content", "settings/logo/index.html");
        // get data
        $this->smarty->assign("logo_perusahaan",$this->m_preferences->get_pref_value_by_grup_name(array("ipangan","logo_perusahaan")));
        $this->smarty->assign("logo_ipangan",$this->m_preferences->get_pref_value_by_grup_name(array("ipangan","logo_ipangan")));
        // notification
        $this->tnotification->display_notification();
        $this->tnotification->display_last_field();
        // output
        parent::display();
    }

    public function upload_logo_process(){
        $this->_set_page_rule("U");

        if (!empty($_FILES['logo_perusahaan']['tmp_name']) || !empty($_FILES['logo_ipangan']['tmp_name'])) {
            // ftp config
            $config['ftp'] = $this->config->item('ftp_config');
            $config2['ftp'] = $this->config->item('ftp_config');
            // upload config
            $folder = "images";
            $config['upload']['file_name'] = 'logo_perusahaan';
            $config['upload']['files'] = 'logo_perusahaan';
            $config['upload']['upload_path'] = $folder;
            $config['upload']['allowed_types'] = 'jpg|png|gif';
            $config['upload']['overwrite'] = TRUE;

            $config2['upload']['file_name'] = 'logo_ipangan';
            $config2['upload']['files'] = 'logo_ipangan';
            $config2['upload']['upload_path'] = $folder;
            $config2['upload']['allowed_types'] = 'jpg|png|gif';
            $config2['upload']['overwrite'] = TRUE;

            if ($this->tftp->upload_images_to_ftp_server($config)) {
                $logo_perusahaan = $this->tftp->ftp_data();
                // logo perusahaan
                $params = array(
                    "pref_value" => $folder."/".$logo_perusahaan['file_name']
                    );
                $where = array(
                    "pref_group" => "ipangan",
                    "pref_nm" => "logo_perusahaan"
                    );
                $this->m_preferences->update_preferences($params, $where);
            }

            if($this->tftp->upload_images_to_ftp_server($config2)){
                $logo_ipangan = $this->tftp->ftp_data();
                // logo ipangan
                $params = array(
                    "pref_value" => $folder."/".$logo_ipangan['file_name']
                    );
                $where = array(
                    "pref_group" => "ipangan",
                    "pref_nm" => "logo_ipangan"
                    );
                $this->m_preferences->update_preferences($params, $where);
            }

            $this->tnotification->sent_notification("success","Logo Berhasil Disimpan");
        }else{
            $this->tnotification->sent_notification("error","Logo Harus Diisi");
        }
        $response = $this->tnotification->display_response();
        $this->tnotification->clear_session();
        echo json_encode($response);
        return;
    }

}
