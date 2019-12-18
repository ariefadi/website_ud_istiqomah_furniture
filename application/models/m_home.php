<?php

class m_home extends CI_Model {

  //put your code here
  public function __construct() {
    parent::__construct();
	}

	function get_all_wilayah(){
		$sql = "
			SELECT prov_id AS 'wilayah_id', prov_nama AS 'wilayah_nm', CONCAT(prov_nama) AS 'wilayah_detail', CONCAT('level_1') AS 'wilayah_level'
				FROM lokasi_prov
			UNION ALL
			SELECT kab_id AS 'wilayah_id', kab_nama AS 'wilayah_nm', CONCAT(kab_nama,',',prov_nama) AS 'wilayah_detail', CONCAT('level_2') AS 'wilayah_level'
				FROM lokasi_kab a
					INNER JOIN lokasi_prov b ON a.prov_id = b.prov_id
			-- UNION ALL
			-- SELECT kec_id AS 'wilayah_id', kec_nama AS 'wilayah_nm', CONCAT(kec_nama,',',kab_nama,',',prov_nama) AS 'wilayah_detail', CONCAT('level_3') AS 'wilayah_level'
			-- 	FROM lokasi_kec a
			-- 		INNER JOIN lokasi_kab b ON a.kab_id = b.kab_id
			-- 		INNER JOIN lokasi_prov c ON b.prov_id = c.prov_id
			-- UNION ALL
			-- SELECT kel_id AS 'wilayah_id', kel_nama AS 'wilayah_nm', CONCAT(kel_nama,',',kec_nama,',',kab_nama,',',prov_nama) AS 'wilayah_detail', CONCAT('level_4') AS 'wilayah_level'
			-- 	FROM lokasi_kel a
			-- 		INNER JOIN lokasi_kec b ON a.kec_id = b.kec_id
			-- 		INNER JOIN lokasi_kab c ON b.kab_id = c.kab_id
			-- 		INNER JOIN lokasi_prov d ON c.prov_id = d.prov_id
		";
		$query = $this->db->query($sql);
		if($query->num_rows() > 0){
			$result = $query->result_array();
			$query->free_result();
			return $result;
		}else{
			return array();
		}
	}

	function get_detail_wilayah_by_id($params){
		$sql = "
			(SELECT prov_id AS 'wilayah_id', prov_nama AS 'wilayah_nm', CONCAT(prov_nama) AS 'wilayah_detail', CONCAT('level_1') AS 'wilayah_level', border AS 'batas_wilayah', relation_id AS 'rel_id'
				FROM lokasi_prov
				WHERE prov_id = ?)
			UNION ALL
			(SELECT kab_id AS 'wilayah_id', kab_nama AS 'wilayah_nm', CONCAT(kab_nama,',',prov_nama) AS 'wilayah_detail', CONCAT('level_2') AS 'wilayah_level', a.border AS 'batas_wilayah', a.relation_id AS 'rel_id'
				FROM lokasi_kab a
					INNER JOIN lokasi_prov b ON a.prov_id = b.prov_id
				WHERE kab_id = ?)
		";
		$query = $this->db->query($sql, $params);
		if($query->num_rows() > 0){
			$result = $query->row_array();
			$query->free_result();
			return $result;
		}else{
			return array();
		}
	}

	function get_all_lahan_by_wilayah($params){
		$sql = "SELECT lahan_id'lahanId',personal_nama'lahanPemilik', lahan_alamat'lahanAlamat', komoditas_nama'lahanKomoditas', varietas_nama'lahanVarietas', lahan_titik'lahanCenter', lahan_koordinat'lahanCoord', CONCAT(0)'lahanLuas'
			FROM ipangan_erp_v1_db.lahan a
				INNER JOIN ipangan_erp_v1_db.petani b ON a.petani_id = b.petani_id
				INNER JOIN ipangan_auth_v1_db.personal c ON b.personal_id = c.personal_id
				INNER JOIN ipangan_erp_v1_db.master_varietas d ON a.varietas_id = d.varietas_id
				INNER JOIN ipangan_erp_v1_db.master_komoditas e ON d.komoditas_id = e.komoditas_id
			WHERE (a.prov_id = ? OR a.kab_id = ?)";
		$query = $this->db->query($sql,$params);
		if($query->num_rows() > 0){
			$result = $query->result_array();
			$query->free_result();
			return $result;
		}else{
			return array();
		}
	}

	function get_resume_lahan_by_wilayah($params){
		$sql = "SELECT COALESCE(COUNT(*),0)'jumlah_lahan', jumlah_petani, jumlah_varietas
		FROM lahan a
		LEFT JOIN (
			SELECT lahan_id, COUNT(*)'jumlah_petani'
			FROM lahan
			GROUP BY petani_id
		) b ON a.lahan_id = b.lahan_id
		LEFT JOIN (
			SELECT lahan_id, COUNT(*)'jumlah_varietas'
			FROM lahan
			GROUP BY varietas_id
		) c ON a.lahan_id = c.lahan_id
		LEFT JOIN (
			SELECT lahan_id, COUNT(*)'jumlah_komoditas'
			FROM lahan d1
			INNER JOIN master_varietas d2 ON d1.varietas_id = d2.varietas_id
			GROUP BY d2.komoditas_id
		) d ON a.lahan_id = d.lahan_id ";

		if(!empty($params[0]) && !empty($params[1])){
			$sql .= " WHERE (a.prov_id = ? OR a.kab_id = ?) ";
		}

		$query = $this->db->query($sql,$params);
		if($query->num_rows() > 0){
			$result = $query->row_array();
			$query->free_result();
			return $result;
		}else{
			return array();
		}
	}


}
