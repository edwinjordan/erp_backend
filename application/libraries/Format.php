<?php 
//ini gak begitu penting
if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

//ini yang penting
class Format
{
public function indo($cb){
  //sebuah perintah, misal:
	$desimal='0';
	$pemisah=',';
	$ribuan='.';
	if(!empty($cb))	$pesan = number_format($cb,$desimal,$pemisah,$ribuan); else $pesan=0;
  	return "Rp ".$pesan; 
}

function TanggalIndo($date){
	$BulanIndo = array("Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");
 
	$tahun = substr($date, 0, 4);
	$bulan = substr($date, 5, 2);
	$tgl   = substr($date, 8, 2);
 
	$result = $tgl . " " . $BulanIndo[(int)$bulan-1] . " ". $tahun;
			
	return($result);
}

function BulanIndo($date){
	$BulanIndo = array("Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");
	$result = $BulanIndo[(int)$date-1];		
	return($result);
}

public function hari($tanggal){
	$day = date('D', strtotime($tanggal));
	$dayList = array(
		'Sun' => 'Minggu',
		'Mon' => 'Senin',
		'Tue' => 'Selasa',
		'Wed' => 'Rabu',
		'Thu' => 'Kamis',
		'Fri' => 'Jumat',
		'Sat' => 'Sabtu'
	);
	return $dayList[$day];
} 

public function bulan($bln){
	if ($bln=='01') {
		$rs='I';
	} elseif ($bln=='02') {
		$rs='II';
	} elseif ($bln=='03') {
		$rs='III';
	} elseif ($bln=='04') {
		$rs='IV';
	} elseif ($bln=='05') {
		$rs='V';
	} elseif ($bln=='06') {
		$rs='VI';
	} elseif ($bln=='07') {
		$rs='VII';
	} elseif ($bln=='08') {
		$rs='VIII';
	} elseif ($bln=='09') {
		$rs='IX';
	} elseif ($bln='10') {
		$rs='X';
	} elseif ($bln='11') {
		$rs='XI';
	} else {
		$rs='XII';
	}
	return $rs;
} 

}