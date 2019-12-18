<?php

class m_account extends CI_Model {

    function __construct() {
        // Call the Model constructor
        parent::__construct();
        // load encrypt
        $this->load->library('encrypt');
    }

    // get user alias
    function get_user_alias_by_id($params) {
        $sql = "SELECT user_alias
                FROM com_user
                WHERE user_id = ?";
        $query = $this->db->query($sql, $params);
        if ($query->num_rows() > 0) {
            $result = $query->row_array();
            $query->free_result();
            return $result['user_alias'];
        } else {
            return '';
        }
    }

    // get user account
    function get_user_account_by_id($params) {
        $sql = "SELECT * FROM com_user WHERE user_id = ?";
        $query = $this->db->query($sql, $params);
        if ($query->num_rows() > 0) {
            $result = $query->row_array();
            $query->free_result();
            $role = $this->get_role_user_by_user($result['user_id']);
            $result['role'] = $role['role_id'];
            $result['role_nm'] = $role['role_nm'];
            $personal = $this->get_detail_personal_by_user_id($result['user_id']);
            $result['personal_id'] = $personal['user_id'];
            $result['personal_nama'] = $personal['nama'];
            $result['personal_no_id'] = $personal['nik'];
            $result['personal_alamat'] = $personal['alamat'];
            $result['personal_jk'] = $personal['jenis_kelamin'];
            $result['personal_hp'] = $personal['telp'];
            $result['user_img'] = empty($personal['personal_img']) ? '/resource/doc/images/users/default.png': $personal['personal_img'];

            return $result;
        } else {
            return array();
        }
    }

    function get_role_user_by_user($user){
        $sql = "SELECT a.role_id,role_nm FROM com_role_user a
                INNER JOIN com_role b ON a.role_id = b.role_id
                WHERE user_id = ? ";
        $query = $this->db->query($sql,$user);
        if($query->num_rows() > 0){
            $result = $query->row_array();
            $query->free_result();
            return $result;
        }else{
            return array();
        }
    }

    //get detail personal by user id
    function get_detail_personal_by_user_id($user_id){
        $sql = "SELECT a.*, b.user_id FROM personal a
                INNER JOIN com_user b ON a.nik = b.nik
                WHERE b.user_id = ? ";
        $query = $this->db->query($sql,$user_id);
        if($query->num_rows() > 0){
            $result = $query->row_array();
            $query->free_result();
            return $result;
        }else{
            return array();
        }
    }

    // get user profil
    function get_user_profil($params) {
        $sql = "SELECT * FROM
                (
                        SELECT a.*, d.role_nm, login_date, ip_address
                        FROM com_user a
                        INNER JOIN com_role_user c ON a.user_id = c.user_id
                        INNER JOIN com_role d ON c.role_id = d.role_id
                        LEFT JOIN com_user_login e ON a.user_id = e.user_id
                        WHERE a.user_id = ? AND c.role_id = ?
                        ORDER BY login_date DESC
                ) result
                GROUP BY user_id";
        $query = $this->db->query($sql, $params);
        if ($query->num_rows() > 0) {
            $result = $query->row_array();
            $query->free_result();
            return $result;
        } else {
            return array();
        }
    }

    // get user detail
    function get_user_detail_by_username($params) {
        $sql = "SELECT a.*, c.role_id, c.role_nm, c.default_page
                FROM com_user a
                LEFT JOIN com_role_user b ON a.user_id = b.user_id
                LEFT JOIN com_role c ON b.role_id = c.role_id
                WHERE user_name = ? AND c.portal_id = ?
                AND c.role_id = ?
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

    // user detail by instansi
    function get_user_detail_by_instansi($params) {
        $sql = "SELECT b.*
                FROM com_user_instansi a
                INNER JOIN com_user b ON a.user_id = b.user_id
                WHERE a.instansi_id = ?
                LIMIT 0, 1";
        $query = $this->db->query($sql, $params);
        if ($query->num_rows() > 0) {
            $result = $query->row_array();
            $query->free_result();
            return $result;
        } else {
            return array();
        }
    }

    // get login
    function get_user_login($username, $password, $role_id, $portal) {
        // load encrypt
        $this->load->library('encrypt');
        // process
        // get hash key
        $result = $this->get_user_detail_by_username(array($username, $portal, $role_id));
        if (!empty($result)) {
            $password_decode = $this->encrypt->decode($result['user_pass'], $result['user_key']);

            // get user
            if ($password_decode === $password) {
                // cek authority then return id
                return $result;
            } else {
                return FALSE;
            }
        } else {
            return FALSE;
        }
    }

    // save user login
    function save_user_login($user_id, $remote_address) {
        // get today login
        $sql = "SELECT * FROM com_user_login WHERE user_id = ? AND DATE(login_date) = CURRENT_DATE";
        $query = $this->db->query($sql, array($user_id));
        if ($query->num_rows() > 0) {
            // tidak perlu diinputkan lagi
            return false;
        } else {
            $sql = "INSERT INTO com_user_login (user_id, login_date, ip_address) VALUES (?, NOW(), ?)";
            return $this->db->query($sql, array($user_id, $remote_address));
        }
    }

    // save user logout
    function update_user_logout($user_id) {
        // update by this date
        $sql = "UPDATE com_user_login SET logout_date = NOW() WHERE user_id = ? AND DATE(login_date) = CURRENT_DATE";
        return $this->db->query($sql, $user_id);
    }

    /*
    * op log
    */
    // get login
    function get_operator_login($username, $password, $portal) {
        // load encrypt
        $this->load->library('encrypt');
        // process
        // get hash key
        $result = $this->get_operator_detail_by_username(array($username, $portal));
        if (!empty($result)) {
            $password_decode = $this->encrypt->decode($result['user_pass'], $result['user_key']);

            // get user
            if ($password_decode === md5($password)) {
                // cek authority then return id
                return $result;
            } else {
                return FALSE;
            }
        } else {
            return FALSE;
        }
    }

    // get operator detail
    function get_operator_detail_by_username($params) {
        $sql = "SELECT a.*, c.role_id, c.role_nm, c.default_page
                FROM com_user a
                LEFT JOIN com_role_user b ON a.user_id = b.user_id
                LEFT JOIN com_role c ON b.role_id = c.role_id
                WHERE user_name = ? AND c.portal_id = ? AND user_group = 'otoritas'
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

    // get operator detail
    function get_detail_operator_by_id($params) {
        $sql = "SELECT a.*, c.role_id, c.role_nm, c.default_page, e.portal_id, f.*
                FROM com_user a
                LEFT JOIN com_role_user b ON a.user_id = b.user_id
                LEFT JOIN com_role c ON b.role_id = c.role_id
                LEFT JOIN com_role_menu d ON c.role_id = d.role_id
                LEFT JOIN com_menu e ON d.nav_id = e.nav_id
                LEFT JOIN personal f ON a.nik = f.nik
                WHERE a.user_id = ? AND e.portal_id = ?
                AND b.role_id = ? LIMIT 0, 1";
        $query = $this->db->query($sql, $params);
        if ($query->num_rows() > 0) {
            $result = $query->row_array();
            $query->free_result();
            return $result;
        } else {
            return false;
        }
    }

    // get all role by portal
    function get_all_role_by_portal($portal_id) {
        $sql = "SELECT * FROM com_role WHERE portal_id = ? ORDER BY role_nm ASC";
        $query = $this->db->query($sql, $portal_id);
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            $query->free_result();
            return $result;
        } else {
            return array();
        }
    }

    //----------ACCOUNT---------------
    // get user account
    function get_user_account($id) {
        $sql = "SELECT a.* FROM com_user a
            WHERE a.user_id = ?";
        $query = $this->db->query($sql, $id);
        if ($query->num_rows() > 0) {
            $result = $query->row_array();
            $query->free_result();
            return $result;
        } else {
            return array();
        }
    }

    // get detail instansi
    function get_detail_instansi_by_id($params) {
        $sql = "SELECT instansi_id, instansi_name
                FROM otoritas
                WHERE instansi_id = ?";
        $query = $this->db->query($sql, $params);
        if ($query->num_rows() > 0) {
            $result = $query->row_array();
            $query->free_result();
            return $result;
        } else {
            return array();
        }
    }

    // check username
    function is_exist_username($params) {
        $sql = "SELECT * FROM com_user WHERE user_name = ?";
        $query = $this->db->query($sql, $params);
        if ($query->num_rows() > 0) {
            $query->free_result();
            return true;
        } else {
            return false;
        }
    }

    // check password
    function is_exist_password($user_id, $password) {
        $sql = "SELECT * FROM com_user WHERE user_id = ?";
        $query = $this->db->query($sql, $user_id);
        if ($query->num_rows() > 0) {
            $result = $query->row_array();
            $query->free_result();
            // --
            $password_decode = $this->encrypt->decode($result['user_pass'], $result['user_key']);
            if ($password_decode == $password) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    // update data account
    function update_data_account($params) {
        $sql = "SELECT * FROM com_user WHERE user_id = ?";
        $query = $this->db->query($sql, $params[2]);
        if ($query->num_rows() > 0) {
            $result = $query->row_array();
            $query->free_result();
        } else {
            return false;
        }
        // encode password
        $params[1] = $this->encrypt->encode(md5($params[1]), $result['user_key']);
        // update
        $sql = "UPDATE com_user SET user_name = ?, user_pass = ? WHERE user_id = ?";
        return $this->db->query($sql, $params);
    }

    // update data account
    function update_data_account_member($params) {
        $sql = "SELECT * FROM com_user WHERE user_id = ?";
        $query = $this->db->query($sql, $params[3]);
        if ($query->num_rows() > 0) {
            $result = $query->row_array();
            $query->free_result();
        } else {
            return false;
        }
        // encode password
        $params[1] = $this->encrypt->encode(md5($params[1]), $result['user_key']);
        // update
        $sql = "UPDATE com_user SET user_name = ?, user_pass = ?, user_mail = ? WHERE user_id = ?";
        return $this->db->query($sql, $params);
    }

    // roles
    function get_all_roles_by_users($params) {
        $sql = "SELECT a.*, b.*, c.role_id, c.group_id, c.role_nm, c.role_desc, c.default_page, d.* FROM com_role a
                INNER JOIN com_role_user b ON a.role_id = b.role_id
                INNER JOIN com_role c ON b.role_id = c.role_id
                INNER JOIN com_role_menu d ON c.role_id = d.role_id
                INNER JOIN com_menu e ON d.nav_id = e.nav_id
                WHERE a.portal_id = ? AND b.user_id = ?
                GROUP BY a.role_id
                ORDER BY a.role_nm ASC";
        $query = $this->db->query($sql, $params);
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            $query->free_result();
            return $result;
        } else {
            return array();
        }
    }

    function get_roles_by_users($params) {
        $sql = "SELECT * FROM com_role a
                INNER JOIN com_role_user b ON a.role_id = b.role_id
                WHERE b.user_id = ? AND a.role_id = ?";
        $query = $this->db->query($sql, $params);
        if ($query->num_rows() > 0) {
            $result = $query->row_array();
            $query->free_result();
            return $result;
        } else {
            return array();
        }
    }

    function update_user_mail($params) {
        // update
        $sql = "UPDATE com_user SET user_mail = ? WHERE user_id = ?";
        return $this->db->query($sql, $params);
    }


    // get user detail
    function get_user_detail_by_email($params) {
        $sql = "SELECT user_mail, user_name, user_pass, user_key
                FROM com_user a
                WHERE user_mail = ? ORDER BY a.mdd DESC
                LIMIT 0, 1";
        $query = $this->db->query($sql, $params);
        if ($query->num_rows() > 0) {
            $result = $query->row_array();
            $query->free_result();
            $password_decode = $this->encrypt->decode($result['user_pass'], $result['user_key']);
            $result['user_pass'] = $password_decode;
            return $result;
        } else {
            return false;
        }
    }

    // check email
    function is_exist_email($email) {
        $sql = "SELECT COUNT(*)'total' FROM com_user WHERE user_mail = ?";
        $query = $this->db->query($sql, $email);
        if ($query->num_rows() > 0) {
            $result = $query->row_array();
            $query->free_result();
            if ($result['total'] == 0) {
                return false;
            }
        }
        return true;
    }

    /*
     * LOGIN WITH ALL ROLES
     */

    // get user detail with auto role
    function get_user_detail_with_all_roles($params) {
        $sql = "SELECT a.*, b.role_id, c.default_page
                FROM com_user a
                INNER JOIN com_role_user b ON a.user_id = b.user_id
                INNER JOIN com_role c ON b.role_id = c.role_id
                INNER JOIN com_role_menu d ON c.role_id = d.role_id
                INNER JOIN com_menu e ON d.nav_id = e.nav_id
                WHERE user_name = ? AND e.portal_id = ? 
                ORDER BY b.role_id ASC
                LIMIT 0, 1";
        $query = $this->db->query($sql, $params);
        if ($query->num_rows() > 0) {
            $result = $query->row_array();
            $query->free_result();
            return $result;
        } else {
            return array();
        }
    }

    // get login auto role
    function get_user_login_all_roles($username, $password, $portal) {
        // load encrypt
        $this->load->library('encrypt');
        // process
        // get hash key
        $result = $this->get_user_detail_with_all_roles(array($username, $portal));
        if (!empty($result)) {
            $password_decode = $this->encrypt->decode($result['user_pass'], $result['user_key']);
            // get user
            if ($password_decode === md5($password)) {
                // cek authority then return id
                return $result;
            } else {
                return FALSE;
            }
        } else {
            return FALSE;
        }
    }

    // get user detail with auto role
    function get_user_wilker_detail_with_all_roles($params) {
        $sql = "SELECT a.*, b.role_id, c.default_page
                FROM com_user a
                INNER JOIN com_role_user b ON a.user_id = b.user_id
                INNER JOIN com_role c ON b.role_id = c.role_id
                INNER JOIN com_role_menu d ON c.role_id = d.role_id
                INNER JOIN com_menu e ON d.nav_id = e.nav_id
                WHERE user_name = ? AND e.portal_id = ? AND user_group = 'wilker'
                ORDER BY b.role_id ASC
                LIMIT 0, 1";
        $query = $this->db->query($sql, $params);
        if ($query->num_rows() > 0) {
            $result = $query->row_array();
            $query->free_result();
            return $result;
        } else {
            return array();
        }
    }

    // get login auto role
    function get_user_wilker_login_all_roles($username, $password, $portal) {
        // load encrypt
        $this->load->library('encrypt');
        // process
        // get hash key
        $result = $this->get_user_wilker_detail_with_all_roles(array($username, $portal));
        if (!empty($result)) {
            $password_decode = $this->encrypt->decode($result['user_pass'], $result['user_key']);
            // get user
            if ($password_decode === md5($password)) {
                // cek authority then return id
                return $result;
            } else {
                return FALSE;
            }
        } else {
            return FALSE;
        }
    }

    // update
    function update_user($params, $where) {
        // update
        return $this->db->update('com_user', $params, $where);
    }

    // get login history
    function get_login_history($params) {
        $sql = "SELECT a.*, b.user_alias
                FROM com_user_login a
                INNER JOIN com_user b ON a.user_id = b.user_id
                WHERE a.user_id = ? AND a.login_date LIKE ?
                ORDER BY a.login_date DESC
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

    // get user img
    function get_user_img($user_id) {
        // ftp config
        $config['ftp'] = $this->config->item('ftp_config');
        // query
        $sql = "SELECT user_img FROM com_user
                WHERE user_id = ?";
        $query = $this->db->query($sql, $user_id);
        if ($query->num_rows() > 0) {
            $result = $query->row_array();
            $query->free_result();
            // images
            $this->load->library('tftp');
            // check file is exist
            $params['dir_path'] = 'images/users/';
            $params['file_name'] = $result['user_img'];
            // return foto
            if ($this->tftp->is_file_exist($config, $params)) {
                return $config['ftp']['ftp_http'] . 'users/' . $result['user_img'];
            }
        }
        return $config['ftp']['ftp_http'] . 'users/default.png';
    }
}
