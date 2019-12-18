<?php

if (!function_exists('reverse_date')) {
  function reverse_date($date, $delimiter = '-') {
    $exp_date = explode($delimiter, $date);
    return implode($delimiter, array_reverse($exp_date));
  }
}

if (!function_exists('prev_year')) {
  function prev_year($year, $default = false) {
    $dateTime = DateTime::createFromFormat('Y', $year);
    if (! $dateTime) return $default;
    $dateInterval = DateInterval::createFromDateString('1 year');
    $dateTime->sub($dateInterval);
    return $dateTime->format('Y');
  }
}

if (!function_exists('list_year_from')) {
  function list_year_from($year) {
    $min_year = empty($year['min_year']) ? date('Y') : $year['min_year'];
    $max_year = empty($year['max_year']) ? date('Y') : $year['max_year'];
    $list_year = array();
    for ($i=$min_year; $i <= $max_year; $i++) {
      array_push($list_year, $i);
    }
    return $list_year;
  }
}

if (!function_exists('list_bulan')) {
  function list_bulan($bulan = false, $type = 'long') {
    $data = array(
      array('index' => '1', 'long' =>'Januari', 'short' => 'Jan'),
      array('index' => '2', 'long' =>'Februari', 'short' => 'Feb'),
      array('index' => '3', 'long' =>'Maret', 'short' => 'Mar'),
      array('index' => '4', 'long' =>'April', 'short' => 'Apr'),
      array('index' => '5', 'long' =>'Mei', 'short' => 'Mei'),
      array('index' => '6', 'long' =>'Juni', 'short' => 'Jun'),
      array('index' => '7', 'long' =>'Juli', 'short' => 'Jul'),
      array('index' => '8', 'long' =>'Agustus', 'short' => 'Ags'),
      array('index' => '9', 'long' =>'September', 'short' => 'Sep'),
      array('index' => '10', 'long' =>'Oktober', 'short' => 'Okt'),
      array('index' => '11', 'long' =>'November', 'short' => 'Nov'),
      array('index' => '12', 'long' =>'Desember', 'short' => 'Des'),
    );
    if($bulan) {
      return $data[$bulan - 1][$type];
    }
    return array_column($data, $type, 'index');
  }
}