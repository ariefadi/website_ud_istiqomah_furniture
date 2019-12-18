<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class m_jabatan extends CI_Model {

	// insert jabatan
    function insert_jabatan($params) {
        return $this->db->insert('jabatan', $params);
    }

    // update jabatan
    function update_jabatan($params, $where) {
        return $this->db->update('jabatan', $params, $where);
    }

    // delete jabatan
    function delete_jabatan($params) {
        return $this->db->delete('jabatan', $params);
    }

    // get detail jabatan by id
    function get_detail_jabatan_by_id($jabatan_id) {
        $sql = "SELECT * FROM jabatan WHERE jabatan_id = ?";
        $query = $this->db->query($sql, $jabatan_id);
        if ($query->num_rows() > 0) {
            $result = $query->row_array();
            $query->free_result();
            return $result;
        } else {
            return array();
        }
    }

    function get_all_jabatan() {
        $sql = "SELECT * FROM jabatan";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            $query->free_result();
            return $result;
        } else {
            return array();
        }
    }

    // get all menu by parent
    function get_all_jabatan_by_parent($params) {
        $sql = "SELECT * FROM jabatan
                WHERE parent_id = ?
                ORDER BY jabatan_nm ASC";
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

/* End of file m_jabatan.php */
/* Location: ./application/models/master/m_jabatan.php */