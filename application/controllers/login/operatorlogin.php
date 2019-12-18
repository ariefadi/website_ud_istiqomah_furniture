<?php

if (!defined('BASEPATH'))
exit('No direct script access allowed');
// load base class if needed
require_once( APPPATH . 'controllers/base/OperatorLoginBase.php' );

// --

class operatorlogin extends ApplicationBase {

	// constructor
	public function __construct() {
		// parent constructor
		parent::__construct();
		// load global
		$this->load->model('m_rest');
		$this->load->library('tnotification');
		$this->load->library('tupload');
	}

	// view
	public function index($status = "") {
		// set template content
		$this->smarty->assign("template_content", "login/operator/form.html");
		//set captcha
		$this->load->helper("captcha");
		$vals = array(
			'img_path' => FCPATH . '/resource/doc/captcha/',
			'img_url' => base_url() . '/resource/doc' . '/captcha/',
			'img_width' => '120',
			'font_path' => FCPATH . '/resource/doc/font/CONSOLAS.TTF',
			'font_size' => 45,
			'img_height' => 34,
			'expiration' => 7200
		);
		$captcha = create_captcha($vals);
		$data = array(
			'captcha_time' => $captcha['time'],
			'ip_address' => $_SERVER["REMOTE_ADDR"],
			'word' => $captcha['word']
		);
		$this->tsession->set_userdata("ses_captcha", $data);
		$this->smarty->assign("captcha", $captcha);
		// bisnis proses
        if (!empty($this->com_user)) {
            // still login
            $this->smarty->assign("login_st", 'still');
        } else {
            $this->smarty->assign("login_st", $status);
        }
		// output
		parent::display();
	}

	// login process
	public function login_process() {
		// set rules
		$this->tnotification->set_rules('username', 'Username', 'trim|required|max_length[30]');
		$this->tnotification->set_rules('password', 'Password', 'trim|required|max_length[30]');
		$this->tnotification->set_rules('captcha', 'Captcha', 'trim|required');
		// data
		$data_captcha = $this->tsession->userdata('ses_captcha');
		// process
		if ($this->tnotification->run() !== FALSE) {
			// cek captcha
			$captcha = $this->input->post('captcha');
			$expiration = time() - 7200;
			if ($data_captcha['word'] == $captcha AND $data_captcha['ip_address'] == $_SERVER["REMOTE_ADDR"] AND $data_captcha['captcha_time'] > $expiration) {
				// params
				$username = trim($this->input->post('username'));
				$password = trim($this->input->post('password'));
				// login
				$result = $this->m_account->get_user_login_all_roles($username, $password, $this->portal_id);
				// check
				if (!empty($result)) {
					// cek lock status
					if ($result['user_st'] == '0') {
						// output
						redirect('login/operatorlogin/index/locked');
					}
					// set session
					$data_user = $this->m_account->get_detail_operator_by_id(array($result['user_id'], $this->portal_id, $result['role_id']));
					$this->tsession->set_userdata('session_operator', $data_user);
					// insert login time
					$this->m_account->save_user_login($result['user_id'], $_SERVER['REMOTE_ADDR']);
					// redirect
					redirect($result['default_page']);
				} else {
					// output
					redirect('login/operatorlogin/index/error');
				}
			} else {
				redirect('login/operatorlogin/index/error');
			}
		} else {
			// default error
			redirect('login/operatorlogin/index/error');
		}
		// output
		redirect('login/operatorlogin');
	}

	// logout process
	public function logout_process() {
		// user id
		$user_id = $this->tsession->userdata('session_operator');
		// removing directory
		if (!empty($user_id)) {
			$path = "resource/doc/temp/" . $user_id['user_id'];
			$this->tupload->remove_dir($path);
		}
		// insert logout time
		$this->m_account->update_user_logout($user_id['user_id']);
		// delete
		$this->tsession->unset_userdata('session_operator');
		// output
		redirect('login/operatorlogin');
	}

}
