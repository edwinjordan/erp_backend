<?php

 require_once('koneksi.php');
 
 if($_SERVER['REQUEST_METHOD']=='POST'){
 $username = $_POST['username'];
 $password = $_POST['password'];

 $sql = "SELECT * FROM karyawan WHERE username='$username' AND password='$password'  ";

 $result = mysqli_query($con,$sql);

 $check = mysqli_fetch_array($result);

 if(isset($check)){
    $status = "success".";".$check['id_karyawan'].";".$check['kode_karyawan'].";".$check['nama'].";".$check['alamat'].";".$check['kota'].";".$check['negara'].";".$check['kode_pos'].";".$check['no_telp'].";".$check['email'].";".$check['status'];
    echo $status;
 }else{
 echo "failure";
 }
 mysqli_close($con);
 }
?>