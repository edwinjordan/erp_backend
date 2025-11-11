<?php
    if($_SERVER['REQUEST_METHOD']=='POST'){
        $arr_id_detail_penjualan = array();
        $jumlah_data = $_POST['jumlah_data'];
        $sql = "UPDATE detail_penjualan SET status = '0' WHERE ";

        for($i=0; $i<$jumlah_data; $i++) {
            $arr_id_detail_penjualan[$i] = $_POST['id_detail_penjualan'.$i];
            $sqlColl = "id_detail_penjualan = $arr_id_detail_penjualan[$i]";
            if($i < $jumlah_data - 1) {
                $sqlColl = "$sqlColl OR ";
            } else {
                $sqlColl = "$sqlColl;";
            }
            $sql = $sql.$sqlColl;
        }

        require_once('koneksi.php');

        if (mysqli_query($con, $sql)){
            echo "success!";
        } else {
             echo "failure";
        }
        
        mysqli_close($con);
    }