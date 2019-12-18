<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class m_rest extends CI_Model{

    protected $user = 'ssokumkm';
    protected $pass = '30ffice2016';
    protected $auth = 'digest';

    public function __construct()
    {
        parent::__construct();
        // Load the library
        $this->load->library('rest');
    }

    // get user eoffice
    public function data_user_eoffice(){
        $link = 'list_user_aplikasi/';
        $rs_data = array();
        // Set config options (only 'server' is required to work)
        $config = array('server' => $this->config->item('app_eoffice').'index.php/rest/get_user/',
                        'http_user'       => $this->user,
                        'http_pass'       => $this->pass,
                        'http_auth'       => $this->auth
                    );

        // Run some setup
        $this->rest->initialize($config);
        $content = $this->rest->get($link);
        if (!empty($content)){
            $rs_data = json_decode($content->data, true);
        }
        return $rs_data;
    }

    // login user eoffice
    public function login_user_eoffice($params){
        $link = 'data_user_login/';
        $rs_data = array();
        // Set config options (only 'server' is required to work)
        $config = array('server' => $this->config->item('app_eoffice').'index.php/rest/get_user/',
                        'http_user'       => $this->user,
                        'http_pass'       => $this->pass,
                        'http_auth'       => $this->auth
                    );

        // Run some setup
        $this->rest->initialize($config);
        $content = $this->rest->post($link, $params);
        if (!empty($content)){
            $rs_data = json_decode($content->data, true);
        }
        return $rs_data;
    }

}
