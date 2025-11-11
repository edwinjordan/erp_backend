<?php

    define('HOST','localhost');
    define('USER','k9170490');
    define('PASS','62zTxyt95I');
    define('DB','k9170490_laris23');
    
    $conn = new mysqli(HOST, USER, PASS, DB);
 
    if (mysqli_connect_errno()) {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
        die();
    }
    $stmt = $conn->prepare("SELECT barang.id_barang, barang.kode_barang, barang.kode_barcode, barang.nama_barang,barang.diskon_persen, barang.diskon_rupiah,varian_harga.ukuran,varian_harga.meter,varian_harga.warna, varian_harga.stok_jual, barang.date_input, barang.date_edit, varian_harga.harga FROM barang inner join varian_harga on varian_harga.id_barang = barang.id_barang order by id_barang DESC;");
  
    $stmt->execute();
  
    $stmt->bind_result($id_barang, $kode_barang, $kode_barcode, $nama_barang,$diskon_persen, $diskon_rupiah, $ukuran, $meter, $warna, $stok_jual, $date_input, $date_edit, $harga);
 
    $products = array(); 
 
    while($stmt->fetch()){
    $temp = array();
    $temp['id_barang'] = $id_barang;
    $temp['kode_barang'] = $kode_barang;
    $temp['kode_barcode'] = $kode_barcode;
    $temp['nama_barang'] = $nama_barang;
    $temp['diskon_persen'] = $diskon_persen;
    $temp['diskon_rupiah'] = $diskon_rupiah;
    $temp['ukuran'] = $ukuran;
    $temp['meter'] = $meter;
    $temp['warna'] = $warna;
    $temp['stok_jual'] = $stok_jual;
    $temp['date_input'] = $date_input;
    $temp['date_edit'] = $date_edit;
    $temp['harga_barang'] = $harga;
    
    array_push($products, $temp);
    }
 
    echo json_encode($products);
?>