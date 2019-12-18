<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class datetimemanipulation {

    // init var
    public $arr_lang = array();
    public $arr_hari = array();

    function __construct() {
        // indonesia
        $this->arr_lang['in'] = array('01' => 'Januari', '02' => 'Februari', '03' => 'Maret', '04' => 'April', '05' => 'Mei', '06' => 'Juni', '07' => 'Juli', '08' => 'Agustus', '09' => 'September', '10' => 'Oktober', '11' => 'November', '12' => 'Desember', '00' => '--');
        // english
        $this->arr_lang['en'] = array('01' => 'January', '02' => 'February', '03' => 'Maret', '04' => 'April', '05' => 'May', '06' => 'June', '07' => 'July', '08' => 'August', '09' => 'September', '10' => 'October', '11' => 'November', '12' => 'December', '00' => '--');
        // indonesia short date
        $this->arr_lang['ins'] =  array('01' => 'Jan', '02' => 'Feb', '03' => 'Mar', '04' => 'Apr', '05' => 'Mei', '06' => 'Jun', '07' => 'Jul', '08' => 'Ags', '09' => 'Sep', '10' => 'Okt', '11' => 'Nov', '12' => 'Des', '00' => '--');
        // english short date
        $this->arr_lang['ens'] =  array('01' => 'Jan', '02' => 'Feb', '03' => 'Mar', '04' => 'Apr', '05' => 'May', '06' => 'Jun', '07' => 'Jul', '08' => 'Ags', '09' => 'Sep', '10' => 'Oct', '11' => 'Nov', '12' => 'Dec', '00' => '--');
        // indonesia month date
        $this->arr_lang['inl'] = array('januari' => '01', 'februari' => '02', 'maret' => '03', 'april' => '04', 'mei' => '05', 'juni' => '06', 'juli' => '07', 'agustus' => '08', 'september' => '09', 'oktober' => '10', 'november' => '11', 'desember' => '12', '--' => '00');
        // indonesia month date
        $this->arr_lang['enl'] = array('january' => '01', 'february' => '02', 'march' => '03', 'april' => '04', 'may' => '05', 'juny' => '06', 'july' => '07', 'august' => '08', 'september' => '09', 'october' => '10', 'november' => '11', 'december' => '12', '--' => '00');
        // hari indonesia
        $this->arr_hari =  array('1' => 'Senin', '2' => 'Selasa', '3' => 'Rabu', '4' => 'Kamis', '5' => 'Jumat', '6' => 'Sabtu', '7' => 'Minggu');
    }

    function __destruct() {

    }
    
    public function get_list_month($lang = "in") {
        $month = $this->arr_lang[$lang];
        unset($month['00']);
        return $month;
    }

    public function get_full_date($tgl, $lang = "in") {
        // check input tanggal
        $tgl = explode(' ', $tgl);
        $tgl_day = isset($tgl[0])?$tgl[0]:'00-00-0000';
        $tgl_jam  = isset($tgl[1])?$tgl[1]:'';
        // tanggal
        $tgl_day = explode('-', $tgl_day);
        if(count($tgl_day) != 3) {
            return '';
        }
        // jam
        $tgl_jam = explode(':', $tgl_jam);
        if(count($tgl_jam) != 3) {
            $tgl_jam = '';
        }
        // parse date
        $month_label = isset($this->arr_lang[$lang][$tgl_day[1]])?$this->arr_lang[$lang][$tgl_day[1]]:$this->arr_lang[$lang]['00'];
        $date_label = $tgl_day[2] . ' ' . $month_label . ' ' . $tgl_day[0];
        // parse time
        if(!empty($tgl_jam)) {
            $tgl_jam = $tgl_jam[0] . ':' . $tgl_jam[1] . ':' . $tgl_jam[2];
            $date_label .= ' ' . $tgl_jam;
        }
        // return
        return $date_label;
    }

    public function get_full_date_split($tgl, $lang = "in") {
        // check input tanggal
        $tgl = explode(' ', $tgl);
        $tgl_day = isset($tgl[0])?$tgl[0]:'00-00-0000';
        $tgl_jam  = isset($tgl[1])?$tgl[1]:'';
        // tanggal
        $tgl_day = explode('-', $tgl_day);
        if(count($tgl_day) != 3) {
            return '';
        }
        // jam
        $tgl_jam = explode(':', $tgl_jam);
        if(count($tgl_jam) != 3) {
            $tgl_jam = '';
        }
        // parse date
        $month_label = isset($this->arr_lang[$lang][$tgl_day[1]])?$this->arr_lang[$lang][$tgl_day[1]]:$this->arr_lang[$lang]['00'];
        $date_label = $tgl_day[2] . ' ' . substr($month_label, 0, 3) . ' ' . $tgl_day[0];
        // parse time
        if(!empty($tgl_jam)) {
            $tgl_jam = $tgl_jam[0] . ':' . $tgl_jam[1] . ':' . $tgl_jam[2];
            $date_label .= ' ' . $tgl_jam;
        }
        // return
        return $date_label;
    }

    public function get_short_date($tgl) {
        // check input tanggal
        $tgl = explode(' ', $tgl);
        $tgl_day = isset($tgl[0])?$tgl[0]:'00-00-0000';
        $tgl_jam  = isset($tgl[1])?$tgl[1]:'';
        // tanggal
        $tgl_day = explode('-', $tgl_day);
        if(count($tgl_day) != 3) {
            return '';
        }
        // jam
        $tgl_jam = explode(':', $tgl_jam);
        if(count($tgl_jam) != 3) {
            $tgl_jam = '';
        }
        // parse date
        $date_label = $tgl_day[0] . '/' . $tgl_day[1] . '/' . $tgl_day[2];
        // parse time
        if(!empty($tgl_jam)) {
            $tgl_jam = $tgl_jam[0] . ':' . $tgl_jam[1] . ':' . $tgl_jam[2];
            $date_label .= ' ' . $tgl_jam;
        }
        // return
        return $date_label;
    }

    //create data format
    public function create_date_format_ym($tahun,$bulan){
        $month = str_pad($bulan,2,"0",STR_PAD_LEFT);
        return $tahun."-".$month;
    }

    public function get_short_date_indo($tgl) {
        // check input tanggal
        $tgl = explode(' ', $tgl);
        $tgl_day = isset($tgl[0]) ? $tgl[0] : '00-00-0000';

        // tanggal
        $tgl_day = explode('-', $tgl_day);
        if (count($tgl_day) != 3) {
            return '';
        }

        // parse date
        $date_label = $tgl_day[2] . '-' . $tgl_day[1] . '-' . $tgl_day[0];

        // return
        return $date_label;
    }

    // get date now
    public function get_date_now() {
        // hari ind
        $date['hari'] = $this->arr_hari[date('N')];
        // tanggal
        $date['tanggal'] = date('d');
        // bulan ind
        $date['bulan'] = $this->arr_lang['in'][date('m')];
        // tahun
        $date['tahun'] = date('Y');
        // return
        return $date;
    }

    // get date now
    public function get_date_indonesia($date_indo) {
        // hari ind
        $hari = date("N", strtotime($date_indo));
        $date['hari'] = $this->arr_hari[$hari];
        // tanggal
        $tanggal = date("d", strtotime($date_indo));
        $date['tanggal'] = $tanggal;
        // bulan ind
        $bulan = date("m", strtotime($date_indo));
        $date['bulan'] = $this->arr_lang['in'][$bulan];
        $date['numeric_bulan']  = date("m", strtotime($date_indo));
        // tahun
        $tahun = date("Y", strtotime($date_indo));
        $date['tahun'] = $tahun;
        // return
        return $date;
    }

    public function get_full_date_indonesia($date_indo) {
        // hari ind
        $hari = date("N", strtotime($date_indo));
        $date['hari'] = $this->arr_hari[$hari];
        // tanggal
        $tanggal = date("d", strtotime($date_indo));
        $date['tanggal'] = $tanggal;
        // bulan ind
        $bulan = date("m", strtotime($date_indo));
        $date['bulan'] = $this->arr_lang['in'][$bulan];
        $date['numeric_bulan']  = date("m", strtotime($date_indo));
        // tahun
        $tahun = date("Y", strtotime($date_indo));
        $date['tahun'] = $tahun;
        // return
        return $date['tanggal'].' '.$date['bulan'].' '.$date['tahun'];
    }

    function nicetime($date) {
        if (empty($date)) {
            return "";
        }

        $periods = array("detik", "menit", "jam", "hari", "minggu", "bulan", "tahun", "dekade");
        $lengths = array("60", "60", "24", "7", "4.35", "12", "10");

        $now = time();
        $unix_date = strtotime($date);

        // check validity of date
        if (empty($unix_date)) {
            return "";
        }

        // is it future date or past date
        if ($now > $unix_date) {
            $difference = $now - $unix_date;
            $tense = "yang lalu";
        } else {
            $difference = $unix_date - $now;
            $tense = "yang lalu";
        }

        for ($j = 0; $difference >= $lengths[$j] && $j < count($lengths) - 1; $j++) {
            $difference /= $lengths[$j];
        }

        $difference = round($difference);

        if ($difference != 1) {
            $periods[$j].= "";
        }

        return "$difference $periods[$j] {$tense}";
    }

    function get_month_name($bln){
        $data = $this->arr_lang['in'][$bln];
        return $data;
    }

    public function get_month_indonesia() {
        return $this->arr_lang['in'];
    }

    // short date indo
    public function get_short_date_timer($tgl) {
        // check input tanggal
        $tgl = explode(' ', $tgl);
        $tgl_day = isset($tgl[0]) ? $tgl[0] : '00-00-0000';
        $tgl_jam = isset($tgl[1]) ? $tgl[1] : '';
        // tanggal
        $tgl_day = explode('-', $tgl_day);
        if (count($tgl_day) != 3) {
            return '';
        }
        // jam
        $tgl_jam = explode(':', $tgl_jam);
        if (count($tgl_jam) != 3) {
            $tgl_jam = '';
        }
        // parse date
        $date_label = $tgl_day[1] . '/' . $tgl_day[2] . '/' . $tgl_day[0];
        // parse time
        if (!empty($tgl_jam)) {
            $tgl_jam = $tgl_jam[0] . ':' . $tgl_jam[1] . ':' . $tgl_jam[2];
            $date_label .= ' ' . $tgl_jam;
        }
        // return
        return $date_label;
    }

    // get date from month
    public function get_date_from_month($tgl, $lang = "inl") {
        // check input tanggal
        $tgl = explode(' ', $tgl);
        if (count($tgl) < 3) {
            return '0000-00-00';
        }
        $tgl_jam = isset($tgl[3]) ? $tgl[3] : '';
        // jam
        $tgl_jam = explode(':', $tgl_jam);
        if (count($tgl_jam) != 3) {
            $tgl_jam = '';
        }
        // parse date
        $month = strtolower($tgl[1]);
        $month_label = isset($this->arr_lang[$lang][$month]) ? $this->arr_lang[$lang][$month] : $this->arr_lang[$lang]['--'];
        $date_label = $tgl[2] . '-' . $month_label . '-' . $tgl[0];
        // parse time
        if (!empty($tgl_jam)) {
            $tgl_jam = $tgl_jam[0] . ':' . $tgl_jam[1] . ':' . $tgl_jam[2];
            $date_label .= ' ' . $tgl_jam;
        }
        // return
        return $date_label;
    }
}
