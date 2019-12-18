<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class m_struktur_organisasi extends CI_Model {

	// get count data kepengurusan
    function get_count_kepengurusan($params) {
        $sql = "SELECT COUNT(*)'total' FROM kepengurusan
                WHERE kepengurusan_nama LIKE ?";
        $query = $this->db->query($sql, $params);
        if ($query->num_rows() > 0) {
            $result = $query->row_array();
            $query->free_result();
            return $result['total'];
        } else {
            return NULL;
        }
    }

    // get data kepengurusan kode
    function get_kepengurusan_kode() {
        $sql = "SELECT kepengurusan_id FROM kepengurusan 
                GROUP BY mdd DESC";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            $result = $query->row_array();
            $query->free_result();
            return $result['kepengurusan_id'];
        } else {
            return array();
        }
    }


    // get all data kepengurusan
    function get_all_kepengurusan($params) {
        $sql = "SELECT * FROM kepengurusan
                WHERE kepengurusan_nama LIKE ? LIMIT ?,?";
        $query = $this->db->query($sql, $params);
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            $query->free_result();
            return $result;
        } else {
            return array();
        }
    }

    // get last id
    function get_kepengurusan_last_id($prefixdate, $params) {
        $sql = "SELECT RIGHT(kepengurusan_id, 4)'last_number'
                FROM kepengurusan
                WHERE kepengurusan_id LIKE ?
                ORDER BY kepengurusan_id DESC
                LIMIT 1";
        $query = $this->db->query($sql, $params);
        if ($query->num_rows() > 0) {
            $result = $query->row_array();
            $query->free_result();
            // create next number
            $number = intval($result['last_number']) + 1;
            if ($number > 9999) {
                return false;
            }
            $zero = '';
            for ($i = strlen($number); $i < 4; $i++) {
                $zero .= '0';
            }
            return $prefixdate . $zero . $number;
        } else {
            // create new number
            return $prefixdate . '0001';
        }
    }    

    // get data kepengurusan by id
    function get_kepengurusan_by_id($params) {
        $sql = "SELECT * FROM kepengurusan
                WHERE kepengurusan_id = ?";
        $query = $this->db->query($sql, $params);
        if ($query->num_rows() > 0) {
            $result = $query->row_array();
            $query->free_result();
            return $result;
        } else {
            return array();
        }
    }

	// Penasihat
    // get count data Penasihat
    function get_count_penasihat($params) {
        $sql = "SELECT COUNT(*)'total' FROM penasihat
                WHERE kepengurusan_id LIKE ?";
        $query = $this->db->query($sql, $params);
        if ($query->num_rows() > 0) {
            $result = $query->row_array();
            $query->free_result();
            return $result['total'];
        } else {
            return NULL;
        }
    }

    function get_penasihat_id($personal_id) {
        $sql = "SELECT personal_id FROM penasihat
                WHERE personal_id LIKE ?";
        $query = $this->db->query($sql, $personal_id);
        if ($query->num_rows() > 0) {
            $result = $query->row_array();
            $query->free_result();
            return $result['total'];
        } else {
            return NULL;
        }
    }

    // get all data penasihat
    function get_all_penasihat($kepengurusan_id) {
        $sql = "SELECT a.*,b.personal_nama FROM penasihat a
                INNER JOIN personal b ON a.personal_id = b.personal_id
		WHERE kepengurusan_id = ?";
        $query = $this->db->query($sql, $kepengurusan_id);
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            $query->free_result();
            return $result;
        } else {
            return array();
        }
    }

    // get personial
    function get_all_personal() {
        $sql = "SELECT * FROM personal ";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            $query->free_result();
            return $result;
        } else {
            return array();
        }
    }

    function is_exist_penasihat($params) {
        $sql = "SELECT COUNT(*)'total' FROM penasihat a
                INNER JOIN personal b ON a.personal_id = b.personal_id
                WHERE a.personal_id LIKE ? ";
        $query = $this->db->query($sql, $params);
        if ($query->num_rows() > 0) {
            $result = $query->row_array();
            $query->free_result();
            if ($result['total'] == 0) {
                return false;
            }
        }
        return true;
    }

    function is_exist_data($params) {
        $sql = "SELECT COUNT(*)'total' FROM penasihat a
                INNER JOIN personal b ON a.personal_id = b.personal_id
                WHERE a.kepengurusan_id LIKE ? AND a.personal_id LIKE ?";
        $query = $this->db->query($sql, $params);
        if ($query->num_rows() > 0) {
            $result = $query->row_array();
            $query->free_result();
            if ($result['total'] == 0) {
                return false;
            }
        }
        return true;
    }

    // check personal
    function is_exist_personal($params) {
        $sql = "SELECT COUNT(*)'total' FROM penasihat a 
                INNER JOIN personal b ON a.personal_id = b.personal_id
                INNER JOIN kepengurusan c ON a.kepengurusan_id = c.kepengurusan_id 
                WHERE a.personal_id LIKE ? ";
        $query = $this->db->query($sql, $params);
        if ($query->num_rows() > 0) {
            $result = $query->row_array();
            $query->free_result();
            if ($result['total'] == 0) {
                return false;
            }
        }
        return true;
    }

    // get detail kepengurusan penasihat by id
    function get_detail_kepengurusan_penasihat_by_id($params) {
        $sql = "SELECT a.*,personal_nama FROM penasihat a
                INNER JOIN personal b ON a.personal_id = b.personal_id
                WHERE a.personal_id = ?";
        $query = $this->db->query($sql, $params);
        if ($query->num_rows() > 0) {
            $result = $query->row_array();
            $query->free_result();
            return $result;
        } else {
            return array();
        }
    }    

    // get personal non karyawan
    function get_all_personal_non_penasihat() {
        $sql = "SELECT * FROM personal
                WHERE personal_id NOT IN (SELECT personal_id FROM penasihat)";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            $query->free_result();
            return $result;
        } else {
            return array();
        }
    }


    // get all struktur kepengurusan by id_kepengurusan
    function get_all_struktur_by_parent($params) {
        $sql = "SELECT a.*, personal_nama, jabatan_nm FROM kepengurusan_pengurus a
                INNER JOIN com_user b ON a.user_id = b.user_id
            	INNER JOIN personal c ON b.nik = c.nik
            	INNER JOIN jabatan d ON a.jabatan_id = d.jabatan_id
                WHERE d.parent_id = ?
                GROUP BY d.jabatan_id ASC";
        $query = $this->db->query($sql, $params);
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            $query->free_result();
            return $result;
        } else {
            return array();
        }
    }

    // get personil
    function get_personil_by_user() {
        $sql = "SELECT a.user_id, b.* FROM com_user a
                INNER JOIN personal b ON a.nik = b.nik
                WHERE a.user_status = '1' ";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            $query->free_result();
            return $result;
        } else {
            return array();
        }
    }

    // check registrar data
    function is_exist_kepengurusan($params) {
        $sql = "SELECT COUNT(*)'total' FROM kepengurusan_pengurus a
                INNER JOIN jabatan b ON a.jabatan_id = b.jabatan_id
				INNER JOIN com_user c ON a.user_id = c.user_id
				INNER JOIN personal d ON c.nik = d.nik
        		WHERE a.kepengurusan_id LIKE ? AND a.user_id LIKE ?";
        $query = $this->db->query($sql, $params);
        if ($query->num_rows() > 0) {
            $result = $query->row_array();
            $query->free_result();
            if ($result['total'] == 0) {
                return false;
            }
        }
        return true;
    }

    // check Jabatan
    function is_exist_jabatan($jabatan_id) {
        $sql = "SELECT COUNT(*)'total' FROM kepengurusan_pengurus WHERE jabatan_id = ?";
        $query = $this->db->query($sql, $jabatan_id);
        if ($query->num_rows() > 0) {
            $result = $query->row_array();
            $query->free_result();
            if ($result['total'] == 0) {
                return false;
            }
        }
        return true;
    }

    // insert kepengurusan
    function insert_kepengurusan($params) {
        return $this->db->insert("kepengurusan", $params);
    }

    // update
    function update_kepengurusan($params, $where) {
        return $this->db->update("kepengurusan", $params, $where);
    }

    // delete
    function delete_kepengurusan($where) {
        return $this->db->delete("kepengurusan", $where);
    }

    // insert kepengurusan struktur
    function insert_kepengurusan_pengurus($params) {
        return $this->db->insert("kepengurusan_pengurus", $params);
    }

    // update kepengurusan struktur
    function update_kepengurusan_pengurus($params, $where) {
        return $this->db->update("kepengurusan_pengurus", $params, $where);
    }

    // delete kepengurusan struktur
    function delete_kepengurusan_pengurus($where) {
        return $this->db->delete("kepengurusan_pengurus", $where);
    }

    // insert kepengurusan penasihat
    function insert_kepengurusan_penasihat($params) {
        return $this->db->insert("penasihat", $params);
    }

    // update kepengurusan penasihat
    function update_kepengurusan_penasihat($params, $where) {
        return $this->db->update("penasihat", $params, $where);
    }

    // delete kepengurusan penasihat
    function delete_kepengurusan_penasihat($where) {
        return $this->db->delete("penasihat", $where);
    }

    // get detail kepengurusan pengurus by id
    function get_detail_kepengurusan_pengurus_by_id($params) {
        $sql = "SELECT a.*, jabatan_nm, personal_nama FROM kepengurusan_pengurus a
		        INNER JOIN com_user b ON a.user_id = b.user_id
        	    INNER JOIN personal c ON b.nik = c.nik
        	    INNER JOIN jabatan d ON a.jabatan_id = d.jabatan_id
        	    WHERE a.user_id = ?";
        $query = $this->db->query($sql, $params);
        if ($query->num_rows() > 0) {
            $result = $query->row_array();
            $query->free_result();
            return $result;
        } else {
            return array();
        }
    }

    // check registrar data
    function is_exist_kepengurusan_jabatan($params) {
        $sql = "SELECT COUNT(*)'total' FROM kepengurusan_pengurus a
                INNER JOIN jabatan b ON a.jabatan_id = b.jabatan_id
        		INNER JOIN com_user c ON a.user_id = c.user_id
        		INNER JOIN personal d ON c.nik = d.nik
                WHERE a.user_id LIKE ? AND a.jabatan_id LIKE ?";
        $query = $this->db->query($sql, $params);
        if ($query->num_rows() > 0) {
            $result = $query->row_array();
            $query->free_result();
            if ($result['total'] == 0) {
                return false;
            }
        }
        return true;
    }

    //get detail personal by id
    function get_detail_personal_by_id($personal_id) {
        $sql = "SELECT * FROM personal WHERE personal_id = ? ";
        $query = $this->db->query($sql, $personal_id);
        if ($query->num_rows() > 0) {
            $result = $query->row_array();
            $query->free_result();
            return $result;
        } else {
            return array();
        }
    }

}

/* End of file m_struktur_organisasi.php */
/* Location: ./application/models/organisasi/m_struktur_organisasi.php */