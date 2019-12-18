<?php

// class for core system
class m_site extends CI_Model {

    function __construct() {
        // Call the Model constructor
        parent::__construct();

    }

    // get site data
    function get_site_data_by_id($id_group) {
        $sql = "SELECT * FROM com_portal WHERE portal_id = ? ";
        $query = $this->db->query($sql, $id_group);
        if ($query->num_rows() > 0) {
            $result = $query->row_array();
            $query->free_result();
            return $result;
        } else {
            return false;
        }
    }

    // get current page
    function get_current_page($params) {
        $sql = "SELECT * FROM com_menu
                WHERE nav_url = ? AND portal_id = ?
                ORDER BY nav_no DESC
                LIMIT 0, 1";
        $query = $this->db->query($sql, $params);
        if ($query->num_rows() > 0) {
            $result = $query->row_array();
            $query->free_result();
            return $result;
        } else {
            return false;
        }
    }

    // get menu by id
    function get_menu_by_id($params) {
        $sql = "SELECT * FROM com_menu WHERE nav_id = ?";
        $query = $this->db->query($sql, $params);
        if ($query->num_rows() > 0) {
            $result = $query->row_array();
            $query->free_result();
            return $result;
        } else {
            return false;
        }
    }


    //get modul by url
    function get_current_modul($params){
      $sql = "SELECT a.* FROM com_modul a
        INNER JOIN com_modul_menu b ON a.modul_id = b.modul_id
        INNER JOIN com_menu c ON b.nav_id = c.nav_id
        LEFT JOIN com_menu d ON d.parent_id = b.nav_id
        WHERE (c.nav_url = ? OR d.nav_url = ?) ";
      $query = $this->db->query($sql,$params);
      if($query->num_rows() > 0){
        $result = $query->row_array();
        $query->free_result();
        return $result;
      }else{
        return array();
      }
    }

    //get widget
    function  get_all_widget(){
      $sql = "SELECT * FROM portal_widget WHERE display_st = '1' ORDER BY widget_order";
      $query = $this->db->query($sql);
      if($query->num_rows() > 0){
        $result = $query->result_array();
        $query->free_result();
        return $result;
      }else{
        return array();
      }
    }

    // get modul navigation by user and parent nav
    function get_modul_navigation_user_by_parent($params) {
        $sql = "SELECT a.*
                FROM com_modul a
                INNER JOIN com_modul_menu b ON a.modul_id = b.modul_id
                INNER JOIN com_menu c ON b.nav_id = c.nav_id
                INNER JOIN com_role_menu d ON c.nav_id = d.nav_id
                INNER JOIN com_role_user e ON d.role_id = e.role_id
                WHERE c.portal_id = ? AND e.user_id = ?
                AND a.display_st = '1' AND e.role_display = '1'
                GROUP BY a.modul_id
                ORDER BY modul_no ASC";
        $query = $this->db->query($sql, $params);
        $this->db->last_query();
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            $query->free_result();
            return $result;
        } else {
            return array();
        }
    }

    // get navigation by user and parent nav
    function get_navigation_user_by_parent($params) {
        $sql = "SELECT a.*
                FROM com_menu a
                INNER JOIN com_role_menu b ON a.nav_id = b.nav_id
                INNER JOIN com_role_user c ON b.role_id = c.role_id
                WHERE a.portal_id = ? AND c.user_id = ? AND parent_id = ?
                AND active_st = '1' AND display_st = '1' AND c.role_display = '1'
                GROUP BY a.nav_id
                ORDER BY nav_no ASC";
        $query = $this->db->query($sql, $params);
        $this->db->last_query();
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            $query->free_result();
            return $result;
        } else {
            return array();
        }
    }

    // get navigation by parent nav
    function get_navigation_by_parent($params) {
        $sql = "SELECT a.*, lang_label FROM com_menu a
                LEFT JOIN com_menu_lang b ON a.nav_id = b.nav_id
                WHERE portal_id = ? AND parent_id = ? AND active_st = '1' AND display_st = '1'
                ORDER BY nav_no ASC";
        $query = $this->db->query($sql, $params);
        // echo $this->db->last_query();
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            $query->free_result();
            return $result;
        } else {
            return false;
        }
    }

    public function get_nav_parent_id($params){
        $sql = "SELECT nav_id,parent_id FROM com_menu WHERE portal_id = ? AND nav_id = ? ";
        $query = $this->db->query($sql, $params);
        if($query->num_rows() > 0){
          $result = $query->row_array();
          $query->free_result();
          return $result;
        }else{
          return array();
        }
      }

    // get navigation by parent nav
    function get_navigation_by_parent_desc($params) {
        $sql = "SELECT a.*, lang_label FROM com_menu a
                LEFT JOIN com_menu_lang b ON a.nav_id = b.nav_id
                WHERE portal_id = ? AND parent_id = ? AND active_st = '1' AND display_st = '1'
                ORDER BY nav_no DESC";
        $query = $this->db->query($sql, $params);
        // echo $this->db->last_query();
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            $query->free_result();
            return $result;
        } else {
            return false;
        }
    }

    //get navigation by portal_id
    function get_navigation_by_portal($params){
      $sql = "SELECT * FROM com_menu WHERE portal_id = ? AND display_st = '1'";
      $query = $this->db->query($sql,$params);
      if($query->num_rows() > 0){
        $result = $query->result_array();
        $query->free_result();
        return $result;
      }else{
        return array();
      }
    }

    // get navigation by nav id
    function get_parent_group_by_idnav($int_parent, $limit) {
        $sql = "SELECT a.nav_id, a.parent_id FROM com_menu a WHERE a.nav_id = ?
                ORDER BY a.nav_no DESC LIMIT 0, 1";
        $query = $this->db->query($sql, array($int_parent));
        if ($query->num_rows() > 0) {
            $result = $query->row_array();
            $query->free_result();
            if ($result['parent_id'] == $limit) {
                return $result['nav_id'];
            } else {
                return self::get_parent_group_by_idnav($result['parent_id'], $limit);
            }
        } else {
            return $int_parent;
        }
    }

    // get user authority
    function get_user_authority($user_id, $id_group) {
        $sql = "SELECT a.user_id FROM com_user a
                INNER JOIN com_role_user b ON a.user_id = b.user_id
                INNER JOIN com_role c ON b.role_id = c.role_id
                WHERE a.user_id = ? AND c.portal_id = ?";
        $query = $this->db->query($sql, array($user_id, $id_group));
        if ($query->num_rows() > 0) {
            $result = $query->row_array();
            $query->free_result();
            return $result['user_id'];
        } else {
            return false;
        }
    }

    // get user authority by navigation
    function get_user_authority_by_nav($params) {
        $sql = "SELECT b.* FROM com_menu a
                INNER JOIN com_role_menu b ON a.nav_id = b.nav_id
                INNER JOIN com_role c ON b.role_id = c.role_id
                INNER JOIN com_role_user d ON c.role_id = d.role_id
                WHERE d.user_id = ? AND b.nav_id = ? AND a.portal_id = ? AND active_st = '1'
                GROUP BY b.nav_id";
        $query = $this->db->query($sql, $params);
        if ($query->num_rows() > 0) {
            $result = $query->row_array();
            $query->free_result();
            return $result['role_tp'];
        } else {
            return false;
        }
    }

    //function get reset password
    function get_reset_passwords($params) {
        $sql = "SELECT a.*
                FROM com_reset_pass a
                ORDER BY a.request_date DESC
                LIMIT ?, ?";
        $query = $this->db->query($sql, $params);
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            $query->free_result();
            return $result;
        } else {
            return array();
        }
    }

    // get list authority
    function get_list_user_roles($params) {
        $sql = "SELECT b.*, role_display
                FROM com_role_user a
                INNER JOIN com_role b ON a.role_id = b.role_id
                INNER JOIN com_role_menu c ON b.role_id = c.role_id
                INNER JOIN com_menu d ON c.nav_id = d.nav_id
                WHERE d.portal_id = ? AND a.user_id = ?
                GROUP BY b.role_id
                ORDER BY b.role_id ASC";
        $query = $this->db->query($sql, $params);
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            $query->free_result();
            return $result;
        } else {
            return array();
        }
    }

    // update
    function update_role_display($params, $where) {
        return $this->db->update('com_role_user', $params, $where);
    }


    //CEK STATUS INSTALASI
    function cek_status_instalasi(){
      $sql = "SELECT * FROM ekop_installer WHERE install_st = '1' ";
      $query = $this->db->query($sql);
      if ($query->num_rows() > 0) {
        $query->free_result();
        return TRUE;
      } else {
        return FALSE;
      }
    }

    //counter

    function insert_visitor($pstr_params) {
        $sql = "INSERT INTO trx_webstat (ip_add,browser,host,time) VALUES (?,?,?,?)";
        return $this->db->query($sql, $pstr_params);
    }

    function get_all_visitor() {
       return $this->db->count_all_results("trx_webstat");
    }

    function get_today_visitor(){
        $sql = "SELECT COUNT(*)'today' FROM trx_webstat WHERE CURDATE() = DATE(time) ";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            $result = $query->row_array();
            $query->free_result();
            return $result;
        } else {
            return array();
        }
    }

    function get_online_visitor($pstr_time) {
       $sql = "SELECT COUNT(DISTINCT(ip_add))AS 'online' FROM trx_webstat tw WHERE tw.time > FROM_UNIXTIME(?) ";
       $query = $this->db->query($sql,$pstr_time);
        if ($query->num_rows() > 0) {
            $result = $query->row_array();
            $query->free_result();
            return $result;
        } else {
            return array();
        }
    }

    // PORTAL
    function get_portal_by_alias($alias){
        $sql = "SELECT * FROM com_portal WHERE portal_alias = ? ";
        $query = $this->db->query($sql,$alias);
        if($query->num_rows() > 0){
            $result = $query->row_array();
            $query->free_result();
            return $result;
        }else{
            return array();
        }
    }

    public function get_all_nav_parent($params){
        $sql = "SELECT a.*
                FROM com_menu a
                INNER JOIN (
                    SELECT parent_id
                    FROM com_menu GROUP BY parent_id
                ) b ON a.nav_id = b.parent_id
                INNER JOIN com_role_menu b ON a.nav_id = b.nav_id
                INNER JOIN com_role_user c ON b.role_id = c.role_id
                WHERE a.portal_id = ? AND c.user_id = ?
                AND active_st = '1' AND display_st = '1' AND c.role_display = '1'
                GROUP BY a.nav_id
                ORDER BY nav_no ASC";
        $query = $this->db->query($sql, $params);
        if ($query->num_rows() > 0) {
          $result = $query->result_array();
          $query->free_result();
          return $result;
        } else {
          return array();
        }
    }

    public function get_all_nav_child($params) {
        $sql = "SELECT a.*, COALESCE(child,0)'child'
                FROM com_menu a
                INNER JOIN com_role_menu b ON a.nav_id = b.nav_id
                INNER JOIN com_role_user c ON b.role_id = c.role_id
                LEFT JOIN (
                    SELECT parent_id, COUNT(*)'child'
                    FROM com_menu
                    GROUP BY parent_id
                ) d ON a.nav_id = d.parent_id
                WHERE a.portal_id = ? AND c.user_id = ? AND a.parent_id <> '0'
                AND active_st = '1' AND display_st = '1' AND c.role_display = '1'
                GROUP BY a.nav_id
                ORDER BY nav_no ASC";
        $query = $this->db->query($sql, $params);
        if ($query->num_rows() > 0) {
          $result = $query->result_array();
          $query->free_result();
          return $result;
        } else {
          return array();
        }
    }
}
