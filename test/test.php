<?php

	/*function getTime($dist, $road) {
	    $roads = array('I' => 65, 'H' => 60, 'M' => 55, 'S' => 45);
	    $time = $dist / $roads[$road];
	    return round($time -1) . ':' . substr((float)explode('.', $time)[1] * 60, 0, 2);
	}

	echo "Hello<br>";
	$time = 42582.944849537;
	var_dump($time);
	echo "<br>";*/

	/*$micro_time = sprintf("%06d",($time - floor($time)) * 1000000);
	$date = new DateTime( date('Y-m-d H:i:s.'.$micro_time,$time) );
	echo "Date with microseconds :<br> ".$date->format("Y-m-d H:i:s.u");*/
	//echo date('Y-m-d H:i:s.u', $time)
	/*$begin_day_unix   = strtotime('2016-09-01 00:00:00');
	$time1 = strtotime("18:00:00");
	$time2 = strtotime("18:23:55");
	$selisih = date('i', ($time2 - $time1));
	$batas = date('H:i:s', (strtotime("05:00:00")));
	//$jam_telat = date('i', strtotime($val2->jam_start - $val2->jam_masuk1));
	$jam1 = 60;
	$jam2 = 8;
	echo "<br>";
	echo 1-round($selisih/$jam1/$jam2,2,PHP_ROUND_HALF_DOWN);
	echo "<br>";*/
	/*$telat = 23;
	$jam1 = 60;
	$jam2 = 8;
	echo round($telat/$jam1/$jam2,2,PHP_ROUND_HALF_DOWN);*/
	/*$nilai = intval(593758934*4.4/100);
	$nilai2 = intval(593758934*1/100);
	//echo $nilai2;
	$hari_ini   = date('Y-m-d', strtotime('2016-09-01'));
	$tgl_new 	= '2015-06-22';//strtotime('2005-12-05');
	$bln        = date('m', strtotime($hari_ini));

    if (date('m', strtotime($tgl_new))>$bln) {
      $senioritas = $hari_ini - $tgl_new - 1;
    } else {
      $senioritas = $hari_ini - $tgl_new;
    }*/
    //echo $senioritas;
    //echo date('Y-m-d', strtotime('+1 month',$tgl_new));
    /*$tgl_set = strtotime("2016-08-04");
    echo date('Y-m-d',strtotime('-1 day',$tgl_set));*/
    $ontime = date('H:i:s',strtotime('10:00:00'));
    $finish = date('H:i:s',strtotime('10:00:00'));
    $jam_real = strtotime('10:00:00');
    echo date('H:i:s',$jam_real);
?>