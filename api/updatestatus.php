<?php
    if($_SERVER['REQUEST_METHOD']=='POST'){
        $id_detail_penjualan = $_POST['id_detail_penjualan'];
        $array = array($id_detail_penjualan);
        $jumlah_data = $_POST['jumlah_data'];
        
        require_once('koneksi.php');
        
        for($i = 0; $i < $jumlah_data ; $i++){
            $sql = "UPDATE detail_penjualan SET status = '0' WHERE id_detail_penjualan = '$id_detail_penjualan'";
        }

        
        if (mysqli_query($con, $sql)){
            echo "success!";
        } else {
             echo "failure";
        }
        
        mysqli_close($con);
    }