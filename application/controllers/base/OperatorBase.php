<?php

class ApplicationBase extends CI_Controller {

  // init base variable
  protected static $portal_id;
  protected static $com_portal;
  protected static $nav_child = array();
  protected static $com_user;
  protected static $nav_id = 0;
  protected static $parent_id = 0;
  protected static $arr_parent = array();
  protected static $parent_selected = 0;
  protected static $role_tp = array();

  public function __construct() {
    date_default_timezone_set("Asia/Jakarta");
    // load basic controller
    parent::__construct();
    // load app data
    $this->base_load_app();
    // view app data
    $this->base_view_app();
  }

  /*
  * Method pengolah base load
  * diperbolehkan untuk dioverride pada class anaknya
  */

  protected function base_load_app() {
    // load themes (themes default : default)
    $this->smarty->load_themes("default");
    // load library
    $this->load->library("datetimemanipulation");
    $this->smarty->assign("dtm", $this->datetimemanipulation);
    //load styles
    $this->smarty->load_style("default/plugins/select2/css/select2.min.css");
    $this->smarty->load_style("default/plugins/sweetalert/sweetalert.css");
    // load javascript

		$this->smarty->load_javascript("resource/themes/default/plugins/moment/min/moment.min.js");
		$this->smarty->load_javascript("resource/themes/default/plugins/bootstrap-daterangepicker/daterangepicker.js");
		$this->smarty->load_javascript("resource/themes/default/plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js");

    $this->smarty->load_javascript("resource/themes/default/plugins/select2/js/select2.min.js");
    $this->smarty->load_javascript("resource/themes/default/plugins/uniform/uniform.min.js");

    $this->smarty->load_javascript("resource/themes/default/plugins/sweetalert/sweetalert.min.js");
		$this->smarty->load_javascript('resource/themes/default/plugins/sweetalert/jquery.sweet-alert.custom.js');
		$this->smarty->load_javascript("resource/themes/default/plugins/sweetalert/sweetalert-custom.js");

    $this->smarty->load_javascript('resource/themes/default/plugins/inputmask/dependencyLibs/inputmask.dependencyLib.js');
    $this->smarty->load_javascript('resource/themes/default/plugins/inputmask/jquery.inputmask.bundle.js');
  }

  /*
  * Method pengolah base view
  * diperbolehkan untuk dioverride pada class anaknya
  */

  protected function base_view_app() {
		$this->smarty->assign("config", $this->config);
		// portal
    $this->portal_id = $this->config->item('portal_operator');
    $session = $this->tsession->userdata('session_operator');
		if (!empty($session)) {
      $data_user = $this->m_account->get_detail_operator_by_id(array($session['user_id'], $this->portal_id, $session['role_id']));
			if (!empty($data_user)){
				$this->com_user = $data_user;
				// parameters
        $params = $this->com_user['personal_img'];
				// cek
				if ($params != '') {
          $this->com_user['personal_img'] = base_url() . $data_user['img_path'] . '/' . $data_user['personal_img']; 
				} else {
					$this->com_user['personal_img'] = base_url() . 'resource/doc/images/users/3.png';
				}
				$this->tsession->set_userdata('session_operator', $this->com_user);
			} else {
				// tidak ada data
				redirect('login/operatorlogin/logout_process');
			}
		}
		if (!empty($this->com_user)){
			// assign user
			$this->smarty->assign("sidebar_list_roles", $this->m_account->get_all_roles_by_users(array($this->portal_id, $this->com_user['user_id'])));
		}
		//    print_r($this->com_user);
		$this->smarty->assign("com_user", $this->com_user);
		// display global link
		self::_display_base_link();
		// display site title
    self::_display_site_title();
		// display current page
		self::_display_current_page();
		// check security
		self::_check_authority();
		// display user profil
    self::_display_user_profil();
    // get all nav child
    self::_get_all_nav_child();
		// display top navigation
    self::_display_sidebar_navigation();
		// display top navigation
		// self::_display_top_notification();
	}

  /*
  * Method layouting base document
  * diperbolehkan untuk dioverride pada class anaknya
  */

  protected function display($tmpl_name = 'base/default/document.html') {
    // --
    $this->smarty->assign("template_sidebar", "base/default/sidebar.html");
    // set template
    $this->smarty->display($tmpl_name);
  }

  //
  // base private method here
  // prefix ( _ )
  // base link
  private function _display_base_link() {

  }

  // site title
  private function _display_site_title() {
    $this->portal_id = $this->config->item('portal_operator');
    // site data
    $this->com_portal = $this->m_site->get_site_data_by_id($this->portal_id);
    if (!empty($this->com_portal)) {
      $this->smarty->assign("site", $this->com_portal);
    }
  }

  // get current page
  private function _display_current_page() {
    // get current page (segment 1 : folder, segment 2 : controller)
    $url_menu = $this->uri->segment(1) . '/' . $this->uri->segment(2);
    $url_menu = trim($url_menu, '/');
    $url_menu = (empty($url_menu)) ? 'dashboard/welcome' : $url_menu;
    $params = array($url_menu, $this->portal_id);
    $result = $this->m_site->get_current_page($params);
    if (!empty($result)) {
      $this->smarty->assign("page", $result);
      $this->nav_id = $result['nav_id'];
      $this->parent_id = $result['parent_id'];
      $this->portal_id = $result['portal_id'];
      $this->arr_parent = $this->__get_nav_parent($result['parent_id']);
    }
  }

  protected function __get_nav_parent($parent_id){
    $arr_parent = $this->__get_nav_parent_id($this->portal_id, $parent_id, array($parent_id));
    return $arr_parent;
  }

  protected function __get_nav_parent_id($portal_id, $nav_id, $arr_parent){
    $result = $this->m_site->get_nav_parent_id(array($portal_id,$nav_id));
    if(!empty($result)){
      array_push($arr_parent, $result['parent_id']);
      $this->__get_nav_parent_id($portal_id, $result['parent_id'], $arr_parent);
    }
    return $arr_parent;
  }

  // authority
  protected function _check_authority() {
    // default rule tp
    $this->role_tp = array("C" => "0", "R" => "0", "U" => "0", "D" => "0");
    $user = $this->com_user;
    // check
    if (!empty($this->com_user)) {
      // user authority
      $params = array($this->com_user['user_id'], $this->nav_id, $this->portal_id);
      $role_tp = $this->m_site->get_user_authority_by_nav($params);
      // get rule tp
      $i = 0;
      foreach ($this->role_tp as $rule => $val) {
        $N = substr($role_tp, $i, 1);
        $this->role_tp[$rule] = $N;
        $i++;
      }
    } else {
      // tidak memiliki authority
      redirect('login/welcome/logout_process');
    }
  }

  // set rule per pages
  protected function _set_page_rule($rule) {
    if (!isset($this->role_tp[$rule]) OR $this->role_tp[$rule] != "1") {
      // redirect to forbiden access
      redirect('login/operatorforbidden/page/' . $this->nav_id);
    }
  }

  // sidebar navigation
  protected function _display_sidebar_navigation($return = FALSE) {
    $html = "";
    // get data
    $params = array($this->portal_id, $this->com_user['user_id'], 0);
    $rs_id = $this->m_site->get_navigation_user_by_parent($params);
    if ($rs_id) {
      foreach ($rs_id as $rec) {
        // parent active
        $parent_class = '';
        $parent_active = '';

        $this->parent_selected = self::_get_parent_group($this->parent_id, 0);
				if ($this->parent_selected == 0) {
					$this->parent_selected = $this->nav_id;
        }
        
        // get child navigation
        $child = $this->_get_child_navigation($rec['nav_id']);
        if (!empty($child)) {
          $parent_class = '';
          $url_parent = '#';
          $arrow = '<i class="fa arrow"></i>';
        } else {
          $url_parent = '';
          $url_parent = site_url($rec['nav_url']);
          $arrow = '';
        }
         // parent active
         if (in_array($rec['nav_id'], $this->arr_parent)) {
          if (!empty($child)) {
            $parent_active = 'active';
          } else {
            $parent_active = 'active';
          }
        }
        // data
        $html .= '<li class="' . $parent_class . ' ' . $parent_active . '">';
        $html .= '<a href="' . $url_parent . '" class="waves-effect '.$parent_active.'"> <i class="m-r-5 ' . $rec['nav_icon'] . ' fa-fw" data-icon="' . $rec['nav_icon'] . '"></i>  <span class="hide-menu"> ' . $rec['nav_title'] . $arrow . ' </span></a>';
        $html .= $child;
        $html .= '</li>';

      }
    }
    // output
    if ($return == FALSE) {
      $this->smarty->assign("list_sidebar_nav", $html);
    } else {
      return $html;
    }
  }

  protected function _get_all_nav_child() {
    // get parent nav
    $rs_nav_parent = $this->m_site->get_all_nav_parent(array($this->portal_id, $this->com_user['user_id']));
    // get child from parent
    $rs_nav_child = $this->m_site->get_all_nav_child(array($this->portal_id, $this->com_user['user_id']));
    $arr_nav_child = array();
    foreach($rs_nav_parent as $parent){

      $no = 0;
      foreach($rs_nav_child as $child){
        if($child['parent_id'] != $parent['nav_id']){
          continue;
        }
        $arr_nav_child[$parent['nav_id']][$no] = $child;
        $no++;
      }

    }

    $this->nav_child = $arr_nav_child;
  }

  // get child
  protected function _get_child_navigation($parent_id, $third = false) {
    $html = "";

    if(!empty($this->nav_child[$parent_id])){
      $rs_id = $this->nav_child[$parent_id];
      if (!empty($rs_id)) {
        $collapse = ($parent_id == $this->parent_selected) ? 'collapse in' : 'collapse' ;

        if($third == true){
          $nav_level = "nav-third-level";
        }else{
          $nav_level = "nav-second-level";
        }

        $html = '<ul class="nav '.$nav_level.' '.$collapse.'">';
        foreach ($rs_id as $rec) {
          $parent_class = "";
          $parent_active = "";

          $third = $rec['child'] > 0 ? true : false ;
          $child = $this->_get_child_navigation($rec['nav_id'], $third);
          if (!empty($child)) {
            $parent_class = '';
            $url_parent = '#';
            $arrow = '<span class="fa arrow"></span>';
            if (in_array($rec['nav_id'], $this->arr_parent)) {
              $parent_active = 'active';
            }

          } else {
            $url_parent = '';
            $url_parent = site_url($rec['nav_url']);
            $arrow = '';
          }

          // parse
          $html .= '<li>';
          $html .= '<a class="waves-effect '.$parent_active.'" href="' . $url_parent . '" title="' . $rec['nav_desc'] . '">';
          $html .= '<span class="hide-menu"> ' . $rec['nav_title'] . $arrow . ' </span></a>';
          $html .= '</a>';
          $html .= $child;
          $html .= '</li>';
        }
        $html .= '</ul>';
      }
    }

    return $html;
  }

  // utility to get modul selected
  protected function _get_modul_group($int_nav, $int_limit) {
    $result = $this->m_site->get_menu_by_id($int_nav);
    if (!empty($result)) {
      if ($result['parent_id'] == $int_limit) {
        $selected_parent = $result['nav_id'];
      } else {
        return self::_get_parent_group($result['parent_id'], $int_limit);
      }
    } else {
      $selected_modul = $result['modul_id'];
    }
    return $selected_modul;
  }

  protected function _get_parent_group($int_nav, $int_limit) {
    $selected_parent = 0;
    $result = $this->m_site->get_menu_by_id($int_nav);
    if (!empty($result)) {
      if ($result['parent_id'] == $int_limit) {
        $selected_parent = $result['nav_id'];
      } else {
        return self::_get_parent_group($result['parent_id'], $int_limit);
      }
    } else {
      $selected_parent = $result['nav_id'];
    }
    return $selected_parent;
  }

  // sidebar reset password info
  private function _display_reset_password() {
    // get data get_reset_passwords(offset, limit)
    $rs_id = $this->m_site->get_reset_passwords(array(0, 20));
    // assign
    $this->smarty->assign("rs_reset_pass", $rs_id);
  }

  // sidebar roles
  private function _display_user_roles() {
    // get data
    $params = array($this->portal_id, $this->com_user['user_id']);
    $rs_id = $this->m_site->get_list_user_roles($params);
    // assign
    $this->smarty->assign("rs_base_role", $rs_id);
  }

  /*
	* User Profil
	*/

	private function _display_user_profil() {
		// get user profil
		$result = $this->m_account->get_user_profil(array($this->com_user['user_id'], $this->com_user['role_id']));
		$this->load->library("tupload");
		// images
		$filepath = 'resource/doc/images/users/' . $result['user_img'];
		if (!is_file($filepath)) {
			$result['user_img'] = 'no-foto.jpg';
		}
		$this->smarty->assign("user_profil", $result);
  }

}
