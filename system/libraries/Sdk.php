<?php
class Sdk {
	private $url = 'http://kukm.serversatu.com/index.php/publicservice';
	private $apikey = '498e975a333a411fc75773c1aa3fb54944ee48e6';
	private $authuser = "excelcom";
	private $authpass = "kj3Df6";
	
	private $ishttps = false;
	private $withauth = true;
	private $certificate = "/etc/apache2/sslweb.crt";
	private $certificatekey = "/etc/apache2/sslweb.key";
	
	
	function __construct() {
		//parent::__construct();
	}
	
	private function showresult($url, $post=array()) {		
		$strpost = "";
		if (count($post) > 0) { 
			$posttemp = array();
			foreach ($post as $k=>$v) {
				$posttemp[] = $k."=".$v;
			}
			$strpost = implode("&", $posttemp);
		}
		$ch = curl_init();                    // initiate curl
		curl_setopt($ch, CURLOPT_URL,$url);
		curl_setopt($ch, CURLOPT_POST, true);  // tell curl you want to post something
		curl_setopt($ch, CURLOPT_POSTFIELDS, $strpost); // define what you want to post
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // return the output in string format
		if ($this->withauth == true) {
			curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
			curl_setopt($ch, CURLOPT_USERPWD, $this->authuser.':'.$this->authpass);
		}
		if ($this->ishttps==true) {
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
			curl_setopt($ch, CURLOPT_SSLCERT, $this->certificate);
			curl_setopt($ch, CURLOPT_SSLKEY, $this->certificatekey);

		} 
		$output = curl_exec($ch); // execute
		curl_close ($ch);
		return $output;
	}
	
	private function address() {
		return $this->url;
	}
	
	/**
	 * Daftar satker
	 * 
	 */
	function Satker_list() {
		$url = $this->address().'/serv001/'.$this->apikey.'/satker_list';
		return $this->showresult($url);
	}
	
	/**
	 * Daftar lokasi
	 * 
	 */
	
	function Lokasi_list() {
		$url = $this->address().'/serv001/'.$this->apikey.'/lokasi_list';
		return $this->showresult($url);
	}
	
	/**
	 * Daftar Kabkota
	 * 
	 */
	function Kabkota_list() {
		$url = $this->address().'/serv001/'.$this->apikey.'/kabkota_list';
		return $this->showresult($url);
	}
	
	
	/**
	 * Daftar DEKON
	 * 
	 */
	function Dekon_list() {
		$url = $this->address().'/serv001/'.$this->apikey.'/dekon_list';
		return $this->showresult($url);
	}
	
	/**
	 * Daftar IB
	 * 
	 */
	function Ib_list() {
		$url = $this->address().'/serv001/'.$this->apikey.'/ib_list';
		return $this->showresult($url);
	}
	
	/**
	 * Daftar program
	 * @param thang : Tahun Anggaran
	 * @param kdsatker : Kode Satker
	 * @param tglreport : Tanggal pengambilan data dalam format yyyy-mm-dd
	 * 
	 */
	function Program_view($thang, $kdsatker, $tglreport) {
		$url = $this->address().'/serv001/'.$this->apikey.'/program_view';
		return $this->showresult($url, 
				array('thang' => $thang, 
						'kdsatker' => $kdsatker, 
						'tglreport' => $tglreport
				));
	}
	
	/**
	 * Daftar Kegiatan
	 * @param thang : Tahun Anggaran
	 * @param kdsatker : Kode Satker
	 * @param kdprogram : Kode Program (lihat function Program_view)
	 * @param tglreport : Tanggal pengambilan data dalam format yyyy-mm-dd
	 *
	 */
	function Kegiatan_view($thang, $kdsatker, $kdprogram, $tglreport) {
		$url = $this->address().'/serv001/'.$this->apikey.'/giat_view';
		return $this->showresult($url,
				array('thang' => $thang,
						'kdsatker' => $kdsatker,
						'kdprogram' => $kdprogram,
						'tglreport' => $tglreport
				));
	}
	
	/**
	 * Daftar Output
	 * @param thang : Tahun Anggaran
	 * @param kdsatker : Kode Satker
	 * @param kdprogram : Kode Program (lihat function Program_view)
	 * @param kdgiat : Kode Kegiatan (lihat function Kegiatan_view)
	 * @param tglreport : Tanggal pengambilan data dalam format yyyy-mm-dd
	 *
	 */
	function Output_view($thang, $kdsatker, $kdprogram, $kdgiat, $tglreport) {
		$url = $this->address().'/serv001/'.$this->apikey.'/output_view';
		return $this->showresult($url,
				array('thang' => $thang,
						'kdsatker' => $kdsatker,
						'kdprogram' => $kdprogram,
						'kdgiat' => $kdgiat,
						'tglreport' => $tglreport
				));
	}
	
	/**
	 * Daftar SOutput
	 * @param thang : Tahun Anggaran
	 * @param kdsatker : Kode Satker
	 * @param kdprogram : Kode Program (lihat function Program_view)
	 * @param kdgiat : Kode Kegiatan (lihat function Kegiatan_view)
	 * @param kdoutput : Kode Output (lihat function Output_view)
	 * @param kddekon : Kode DEKON (lihat function Dekon_list)
	 * @param kdib : Kode IB (lihat function Ib_list)
	 * @param tglreport : Tanggal pengambilan data dalam format yyyy-mm-dd
	 *
	 */
	function Soutput_view($thang, $kdsatker, $kdprogram, $kdgiat, $kdoutput, $kddekon, $kdib, $tglreport) {
		$url = $this->address().'/serv001/'.$this->apikey.'/soutput_view';
		return $this->showresult($url,
				array('thang' => $thang,
						'kdsatker' => $kdsatker,
						'kdprogram' => $kdprogram,
						'kdgiat' => $kdgiat,
						'kdoutput' => $kdoutput,
						'kddekon' => $kddekon,
						'kdib' => $kdib,
						'tglreport' => $tglreport
				));
	}
	
	/**
	 * Daftar Komponen
	 * @param thang : Tahun Anggaran
	 * @param kdsatker : Kode Satker
	 * @param kdprogram : Kode Program (lihat function Program_view)
	 * @param kdgiat : Kode Kegiatan (lihat function Kegiatan_view)
	 * @param kdoutput : Kode Output (lihat function Output_view)
	 * @param kddekon : Kode DEKON (lihat function Dekon_list)
	 * @param kdib : Kode IB (lihat function Ib_list)
	 * @param kdsoutput : Kode Soutput (lihat function Soutput_view)
	 * @param tglreport : Tanggal pengambilan data dalam format yyyy-mm-dd
	 *
	 */
	function Komponen_view($thang, $kdsatker, $kdprogram, $kdgiat, $kdoutput, $kddekon, $kdib, 
							$kdsoutput, $tglreport) {
		$url = $this->address().'/serv001/'.$this->apikey.'/kmpnen_view';
		return $this->showresult($url,
				array('thang' => $thang,
						'kdsatker' => $kdsatker,
						'kdprogram' => $kdprogram,
						'kdgiat' => $kdgiat,
						'kdoutput' => $kdoutput,
						'kddekon' => $kddekon,
						'kdib' => $kdib,
						'kdsoutput' => $kdsoutput,
						'tglreport' => $tglreport
				));
	}
	
	/**
	 * Daftar SKomponen
	 * @param thang : Tahun Anggaran
	 * @param kdsatker : Kode Satker
	 * @param kdprogram : Kode Program (lihat function Program_view)
	 * @param kdgiat : Kode Kegiatan (lihat function Kegiatan_view)
	 * @param kdoutput : Kode Output (lihat function Output_view)
	 * @param kddekon : Kode DEKON (lihat function Dekon_list)
	 * @param kdib : Kode IB (lihat function Ib_list)
	 * @param kdsoutput : Kode Soutput (lihat function Soutput_view)
	 * @param kdkomponen : Kode Komponen (lihat function Komponen_view)
	 * @param tglreport : Tanggal pengambilan data dalam format yyyy-mm-dd
	 *
	 */
	function Skomponen_view($thang, $kdsatker, $kdprogram, $kdgiat, $kdoutput, $kddekon, $kdib,
			$kdsoutput,$kdkmpnen, $tglreport) {
				$url = $this->address().'/serv001/'.$this->apikey.'/skmpnen_view';
				return $this->showresult($url,
						array('thang' => $thang,
								'kdsatker' => $kdsatker,
								'kdprogram' => $kdprogram,
								'kdgiat' => $kdgiat,
								'kdoutput' => $kdoutput,
								'kddekon' => $kddekon,
								'kdib' => $kdib,
								'kdsoutput' => $kdsoutput,
								'kdkmpnen' => $kdkmpnen,
								'tglreport' => $tglreport
						));
	}
	
	/**
	 * Daftar Akun
	 * @param thang : Tahun Anggaran
	 * @param kdsatker : Kode Satker
	 * @param kdprogram : Kode Program (lihat function Program_view)
	 * @param kdgiat : Kode Kegiatan (lihat function Kegiatan_view)
	 * @param kdoutput : Kode Output (lihat function Output_view)
	 * @param kddekon : Kode DEKON (lihat function Dekon_list)
	 * @param kdib : Kode IB (lihat function Ib_list)
	 * @param kdsoutput : Kode Soutput (lihat function Soutput_view)
	 * @param kdkmpnen : Kode Komponen (lihat function Komponen_view)
	 * @param kdskmpnen : Kode SKomponen (lihat function Skomponen_view)
	 * @param tglreport : Tanggal pengambilan data dalam format yyyy-mm-dd
	 *
	 */
	function Akun_view($thang, $kdsatker, $kdprogram, $kdgiat, $kdoutput, $kddekon, $kdib,
			$kdsoutput,$kdkmpnen,$kdskmpnen, $tglreport) {
				$url = $this->address().'/serv001/'.$this->apikey.'/akun_view';
				return $this->showresult($url,
						array('thang' => $thang,
								'kdsatker' => $kdsatker,
								'kdprogram' => $kdprogram,
								'kdgiat' => $kdgiat,
								'kdoutput' => $kdoutput,
								'kddekon' => $kddekon,
								'kdib' => $kdib,
								'kdsoutput' => $kdsoutput,
								'kdkmpnen' => $kdkmpnen,
								'kdskmpnen' => $kdskmpnen,
								'tglreport' => $tglreport
						));
	}
	
	function Validatekey($key) {
		$url = $this->address().'/serv002/validate_key';
		return $this->showresult($url, array('key'=> $key));
	}
}
