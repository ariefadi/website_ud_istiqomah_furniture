<?php

class m_visi_misi extends CI_Model {

    function __construct() {
        // Call the Model constructor
        parent::__construct();
    }

    // generate visi misi id
    function generate_visi_misi_id($params = "V") {
        $sql = "SELECT SUBSTRING(id_visi_misi, 4, 7)'last_number'
                FROM profil_visi_misi
                WHERE SUBSTRING(id_visi_misi, 2, 2) = SUBSTRING(YEAR(NOW()), 3, 2)
                ORDER BY id_visi_misi DESC
                LIMIT 0, 1";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            $result = $query->row_array();
            $query->free_result();
            // create next number
            $number = intval($result['last_number']) + 1;
            $zero = '';
            for ($i = strlen($number); $i < 7; $i++) {
                $zero .= '0';
            }
            return $params . substr(date("Y"), -2) . $zero . $number;
        } else {
            // create new number
            return $params . substr(date("Y"), -2) . '0000001';
        }
    }

    // get all total visi misi 
    function get_total_data_visi_misi($params){
        $arr_params = array();
        $sql = "SELECT COUNT(*)'total'
                FROM profil_visi_misi
                WHERE id_visi_misi <> '' ";

                if($params[0]){
                    $sql .=" AND visi_misi_title LIKE ? ";
                    array_push($arr_params, $params[0]);
                }
        $query = $this->db->query($sql,$arr_params);
        if ($query->num_rows() > 0) {
            $result = $query->row_array();
            $query->free_result();
            return $result['total'];
        } else {
            return 0;
        }
    }

    // get data all visi misi
    function get_all_data_visi_misi($params) {
        $arr_params = array();
        $sql = "SELECT *
                FROM profil_visi_misi
                WHERE id_visi_misi <> '' ";

                if($params[0]){
                    $sql .=" AND visi_misi_title LIKE ? ";
                    array_push($arr_params, $params[0]);
                }

        $sql .=" ORDER BY id_visi_misi ASC LIMIT ?,? ";
        array_push($arr_params, $params[1]);
        array_push($arr_params, $params[2]);

        $query = $this->db->query($sql,$arr_params);
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            $query->free_result();
            return $result;
        } else {
            return array();
        }
    }

    // get detail data visi misi by id
    function get_detail_visi_misi_by_id($id_visi_misi) {
        $sql = "SELECT * FROM profil_visi_misi WHERE id_visi_misi = ?";
        $query = $this->db->query($sql, $id_visi_misi);
        if ($query->num_rows() > 0) {
            $result = $query->row_array();
            $query->free_result();
            return $result;
        } else {
            return array();
        }
    }

    // insert data visi misi
    function insert_visi_misi($params) {
        return $this->db->insert('profil_visi_misi', $params);
    }

    // update data visi misi
    function update_visi_misi($params, $where) {
        return $this->db->update('profil_visi_misi', $params, $where);
    }

    // delete data visi misi
    function delete_visi_misi($params) {
        return $this->db->delete('profil_visi_misi', $params);
    }
}    