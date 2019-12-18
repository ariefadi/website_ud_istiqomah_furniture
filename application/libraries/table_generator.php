<?php
/**
* Generate table detail Pelaporan KSP
*/
class Table_Generator {

  private $result;

  public function __construct($result) {
    $this->result = $result;
  }

  public function aruskas($data, $open_tag = '', $close_tag = '') {
    $params = array(
      'no' => $data['akun_kd'],
      'uraian'  => $open_tag . $data['akun_nama'] . $close_tag,
      'catatan' => false,
      'nominal' => $data['nominal'],
      'akun_kd' => $data['akun_kd'],
      'is_show' => (bool)$data['dibaca'],
      'is_label' => isset($data['jumlah']),
    );
    return $this->_generate($params);
  }

  public function shu($data, $open_tag = '', $close_tag = '') {
    $params = array(
      'no' => $open_tag . $data['akun_kd'] . $close_tag,
      'uraian'  => $open_tag . $data['akun_nama'] . $close_tag,
      'catatan' => $data['akun_kd'],
      'nominal' => $data['nominal'],
      'akun_kd' => $data['akun_kd'],
      'is_show' => (bool)$data['dibaca'],
      'is_label' => isset($data['jumlah']),
    );
    return $this->_generate($params);
  }

  public function neraca($data, $open_tag = '', $close_tag = '') {
    $params = array(
      'no' => $open_tag . $data['akun_kd'] . $close_tag,
      'uraian'  => $open_tag . $data['akun_nama'] . $close_tag,
      'catatan' => $data['akun_kd'],
      'nominal' => $data['nominal'],
      'akun_kd' => $data['akun_kd'],
      'is_show' => (bool)$data['dibaca'],
      'is_label' => isset($data['jumlah']),
    );
    return $this->_generate($params);
  }

  private function _generate($data) {
    $html = "<tr>
      <td>{$data['no']}</td>
      <td class='text-left'>{$data['uraian']}</td>";
      if ($data['catatan'] !== false) {
        $html .= "<td>{$data['catatan']}</td>";
      }
      $html .= "<td class='text-right'>";
      if ($data['is_show']) {
        if ($data['is_label']) {
          $html .= "<strong style='margin-right:10px'>" . number_format($data['nominal'] ,0,',','.') . "</strong>";
        } else {
          $readonly = $this->result['verified_st'] ? 'readonly="readonly"' : '';
          $html .= '<input type="text" class="form-control input-mask" autocomplete="off" name="nominal[' .
            str_replace('.', '_', $data['akun_kd']) . ']" value="' . (int)$data['nominal'] . '" ' . $readonly . '>';
        }
      }
    $html .= "</td>
      </tr>";
    return $html;
  }

}