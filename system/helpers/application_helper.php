<?php

if (!function_exists('clean_string')) {
  function clean_string($data) {
    return str_replace(array('.', ','), array('', '.'), $data);
  }
}

if (!function_exists('format_rupiah')) {
  function format_rupiah($nominal, $default = '0,00', $decimals = 2) {
    if (empty($nominal)) {
      return $default;
    }
    $format_rupiah = number_format($nominal, $decimals, ',', '.');
    if ($nominal < 0) {
      $rupiah = str_replace("-", "", $format_rupiah);
      $format_rupiah = "($rupiah)";
    }
    return $format_rupiah;
  }
}

if (!function_exists('toJSArray')) {
  function toJSArray($data) {
    if (!is_array($data)) {
      return '[]';
    }
    $result = '[';
    foreach ($data as $value) {
      $result .= '"' . $value . '", ';
    }
    $result .= ']';
    return $result;
  }
}
