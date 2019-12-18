<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// class for core system
class m_struktur extends CI_Model {

    function __construct() {
        // Call the Model constructor
        parent::__construct();
    }

    // get user img
    public function get_user_img($user_id) {
        // query
        $sql = "SELECT b.img_path, b.personal_img FROM anggota a
                INNER JOIN personal b ON a.nik = b.nik
                WHERE user_id = ?";
        $query = $this->db->query($sql, $anggota_id);
        if ($query->num_rows() > 0) {
            $result = $query->row_array();
            $query->free_result();
            $file_path = $result['img_path'] . "/" . $result['personal_img'];
            if (is_file($file_path)) {
                return base_url() . $result['img_path'] . "/" . $result['personal_img'];
            } else {
                return base_url() . $result['img_path'] . "/default.png";
            }
        } else {
            return base_url() . $result['img_path'] . "/default.png";
        }
    }

    // // display struktur organisasi
    // public function display_struktur_organisasi($kepengurusan_id) {
    //     $sql = "SELECT a.*, f.kepengurusan_nama, b.no_anggota, b.status_anggota, d.personal_nama,
    //             d.status_pekerjaan,d.personal_hp,e.jabatan_nm 
    //             FROM kepengurusan_pengurus a
    //             INNER JOIN anggota b ON a.anggota_id = b.anggota_id
    //             INNER JOIN anggota_personal c ON b.anggota_id = c.anggota_id
    //             INNER JOIN personal d ON c.personal_id = d.personal_id
    //             INNER JOIN jabatan e ON a.jabatan_id = e.jabatan_id
    //             INNER JOIN kepengurusan f ON a.kepengurusan_id = f.kepengurusan_id
    //             WHERE e.parent_id IS NOT NULL AND e.parent_id = '0' AND a.kepengurusan_id = ?
    //             GROUP BY a.jabatan_id
    //             ORDER BY a.jabatan_id ASC";
    //     $query = $this->db->query($sql,$kepengurusan_id);
    //     if ($query->num_rows() > 0) {
    //         $result = $query->result_array();
    //         $query->free_result();
    //         $html = '<ul id="primaryNav" class="col5">';
    //         foreach ($result as $rec) {
    //             $html .= '<li id="home">';
    //             $html .= '<a href="#">';
    //             $html .= '<span class="text-subsection">' . (empty($rec['kepengurusan_nama']) ? '-' : $rec['kepengurusan_nama']) . '</span>';
    //             $html .= '<img class="section-pic" src="' . $this->get_anggota_img($rec['anggota_id']) . '" alt="" />';
    //             $html .= '<span class="text-nama">' . (empty($rec['personal_nama']) ? '-' : $rec['personal_nama']) . '</span>';
    //             $html .= '<span class="text-no">' . (empty($rec['no_anggota']) ? '-' : $rec['no_anggota']) . '</span>';
    //             $html .= '<span class="text-nama">' . (empty($rec['status_pekerjaan']) ? '-' : $rec['status_pekerjaan']) . '</span>';
    //             $html .= '<span class="text-no">' . (empty($rec['personal_hp']) ? '-' : $rec['personal_hp']) . '</span>';
    //             $html .= '</br>';
    //             $html .= '</br>';
    //             $html .= '<span class="text-section">' . $rec['jabatan_nm'] . '</span>';
    //             $html .= '</li>';
    //             // --
    //             $html .= '</a>';
    //             // --
    //             $html .= '</li>';
    //             // child
    //             $html .= $this->get_struktur_organisasi_level_1_by_parent($rec['jabatan_id']);
    //         }
    //         $html .= '</ul>';
    //         return $html;
    //     } else {
    //         return '';
    //     }
    // }

    // // get struktur organisasi level 1
    // public function get_struktur_organisasi_level_1_by_parent($params) {
    //     $sql = "SELECT a.*, f.kepengurusan_nama, b.no_anggota, d.personal_nama,
    //             d.status_pekerjaan,d.personal_hp,e.jabatan_nm
    //             FROM kepengurusan_pengurus a
    //             INNER JOIN anggota b ON a.anggota_id = b.anggota_id
    //             INNER JOIN anggota_personal c ON b.anggota_id = c.anggota_id
    //             INNER JOIN personal d ON c.personal_id = d.personal_id
    //             INNER JOIN jabatan e ON a.jabatan_id = e.jabatan_id
    //             INNER JOIN kepengurusan f ON a.kepengurusan_id = f.kepengurusan_id
    //             WHERE e.parent_id IS NOT NULL AND e.parent_id = ?
    //             GROUP BY a.jabatan_id
    //             ORDER BY a.jabatan_id ASC";
    //     $query = $this->db->query($sql, $params);
    //     if ($query->num_rows() > 0) {
    //         $result = $query->result_array();
    //         $query->free_result();
    //         $html = '<ul>';
    //         foreach ($result as $rec) {
    //             $html .= '<li>';
    //             $html .= '<a href="#">';
    //             $html .= '<span class="text-subsection">' . (empty($rec['kepengurusan_nama']) ? '-' : $rec['kepengurusan_nama']) . '</span>';
    //             $html .= '<img class="section-pic" src="' . $this->get_anggota_img($rec['anggota_id']) . '" alt="" />';
    //             $html .= '<span class="text-nama">' . (empty($rec['personal_nama']) ? '-' : $rec['personal_nama']) . '</span>';
    //             $html .= '<span class="text-nama">' . (empty($rec['no_anggota']) ? '-' : $rec['no_anggota']) . '</span>';
    //             $html .= '<span class="text-nama">' . (empty($rec['status_pekerjaan']) ? '-' : $rec['status_pekerjaan']) . '</span>';
    //             $html .= '<span class="text-nama">' . (empty($rec['personal_hp']) ? '-' : $rec['personal_hp']) . '</span>';
    //             $html .= '</br>';
    //             $html .= '<span class="text-section">' . $rec['jabatan_nm'] . '</span>';
    //             // --
    //             $html .= '</a>';
    //             // --
    //             // child
    //             $html .= $this->get_struktur_organisasi_level_2_by_parent($rec['jabatan_id']);
    //             // --
    //             $html .= '</li>';
    //         }
    //         return $html;
    //     } else {
    //         return '';
    //     }
    // }

    // // get struktur organisasi level 2
    // public function get_struktur_organisasi_level_2_by_parent($params) {
    //     $sql = "SELECT a.*, f.kepengurusan_nama, b.no_anggota, d.personal_nama,
    //             d.status_pekerjaan,d.personal_hp,e.jabatan_nm 
    //             FROM kepengurusan_pengurus a
    //             INNER JOIN anggota b ON a.anggota_id = b.anggota_id
    //             INNER JOIN anggota_personal c ON b.anggota_id = c.anggota_id
    //             INNER JOIN personal d ON c.personal_id = d.personal_id
    //             INNER JOIN jabatan e ON a.jabatan_id = e.jabatan_id
    //             INNER JOIN kepengurusan f ON a.kepengurusan_id = f.kepengurusan_id
    //             WHERE e.parent_id IS NOT NULL AND e.parent_id = ?
    //             GROUP BY a.jabatan_id
    //             ORDER BY a.jabatan_id ASC";
    //     $query = $this->db->query($sql, $params);
    //     if ($query->num_rows() > 0) {
    //         $result = $query->result_array();
    //         $query->free_result();
    //         $html = '<ul>';
    //         foreach ($result as $rec) {
    //             $html .= '<li>';
    //             $html .= '<a href="#">';
    //             $html .= '<span class="text-subsection">' . (empty($rec['kepengurusan_nama']) ? '-' : $rec['kepengurusan_nama']) . '</span>';
    //             $html .= '<img class="section-pic" src="' . $this->get_anggota_img($rec['anggota_id']) . '" alt="" />';
    //             $html .= '<span class="text-nama">' . (empty($rec['personal_nama']) ? '-' : $rec['personal_nama']) . '</span>';
    //             $html .= '<span class="text-nama">' . (empty($rec['no_anggota']) ? '-' : $rec['no_anggota']) . '</span>';
    //             $html .= '<span class="text-nama">' . (empty($rec['status_pekerjaan']) ? '-' : $rec['status_pekerjaan']) . '</span>';
    //             $html .= '<span class="text-nama">' . (empty($rec['personal_hp']) ? '-' : $rec['personal_hp']) . '</span>';
    //             $html .= '</br>';
    //             $html .= '<span class="text-section">' . $rec['jabatan_nm'] . '</span>';
    //             // --
    //             $html .= '</a>';
    //             // --
    //             $html .= '</li>';
    //         }
    //         $html .= '</ul>';
    //         return $html;
    //     } else {
    //         return '';
    //     }
    // }

}


/* End of file m_struktur.php */
/* Location: ./application/models/profil/m_struktur.php */