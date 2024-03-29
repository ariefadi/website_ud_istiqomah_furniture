<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

require_once( BASEPATH . 'libraries/Form_validation.php' );

class CI_Tnotification extends CI_Form_validation {

    private $prefix = "";
    private $suffix = "";
    private $data = array();

    // constructor
    function __construct($pstr_prefix = "<li>", $pstr_suffix = "</li>") {
        // smarty constructor
        parent::__construct();
        // set default delimiter
        $this->prefix = $pstr_prefix;
        $this->suffix = $pstr_suffix;
    }

    // get latest field data from post
    private function _get_field_data() {
        return $this->_field_data;
    }

    // get post data
    public function get_post_data() {
        return $this->_field_data;
    }

    // get latest field data from session
    public function get_field_data() {
        if (!empty($this->data)) {
            return $this->data['data'];
        } else {
            return array();
        }
    }

    // set error message
    public function set_error_message($message) {
        $this->_error_array[] = $message;
    }

    // get error message
    public function get_error_message() {
        return $this->error_string($this->prefix, $this->suffix);
    }

    // clear session
    public function clear_session() {
        // native session
        if (isset($_SESSION['CI_notification'])) {
            unset($_SESSION['CI_notification']);
        }
    }

    // get session
    public function get_session() {
        if (empty($this->data)) {
            $this->data = isset($_SESSION['CI_notification']) ? $_SESSION['CI_notification'] : array();
        }
    }

    // set session
    private function set_session($data) {
        $_SESSION['CI_notification'] = $data;
    }

    public function sent_notification($status, $message) {
        // clear session
        $this->clear_session();
        // assign data
        $data = array("error" => $this->get_error_message(), "data" => $this->_get_field_data(),
            "status" => trim($status), "message" => trim($message));
        // save session
        $this->set_session($data);
    }

    // Tambahan
    public function display_response($open = "<ul>", $close = "</ul>"){
      // get session
      $this->get_session();

      $response = array();

      if (!empty($this->data)) {
        $response['status'] = $this->data['status'];
        $response['message'] = $this->data['message'];
        if (!empty($this->data['error'])) {
            $response['errors'] = $open . $this->data['error'] . $close;
        } else {
            $response['errors'] = "";
        }
      }
      return $response;
    }

    public function display_notification($open = "<ul>", $close = "</ul>") {
        // get session
        $this->get_session();
        // display header
        $this->CI->smarty->assign("notification_header", "");
        if (!empty($this->data)) {
            $this->CI->smarty->assign("notification_header", $this->data['status']);
            $this->CI->smarty->assign("notification_message", $this->data['message']);
            if (!empty($this->data['error'])) {
                $this->CI->smarty->assign("notification_error", $open . $this->data['error'] . $close);
            } else {
                $this->CI->smarty->assign("notification_error", "");
            }
        }
        // clear session
        $this->clear_session();
    }

    public function display_last_field($var_name = "result") {
        $output = array();
        // get session
        $this->get_session();
        // display latest field
        if (!empty($this->data['data'])) {
            foreach ($this->data['data'] as $field) {
                $output[$field['field']] = $field['postdata'];
            }
            // return
            $this->CI->smarty->assign($var_name, $output);
        }
        // clear session when finish
        $this->clear_session();
    }

    public function delete_last_field() {
        $this->_field_data = array();
    }

    function alpha_space($str){
        $this->set_message('alpha_space', "%s Hanya boleh diisi huruf dan spasi");
        return ( ! preg_match("/^([-a-z ])+$/i", $str)) ? FALSE : TRUE;
    }

}
