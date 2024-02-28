<?php 
// koneksi database
include '../koneksi/koneksi.php';
 
// menangkap data yang di kirim dari form
$namalengkap = $_POST['namalengkap'];
$email = $_POST['email'];
$alamat = $_POST['alamat'];
$username = $_POST['username'];
$password = md5($_POST['password']);
$level = $_POST['level'];
 
// menginput data ke database
mysqli_query($koneksi,"INSERT into user(namalengkap,email,alamat,username, password,level)
                             values('$namalengkap','$email','$alamat','$username','$password','$level')");
 
// mengalihkan halaman kembali ke index.php
header("location:../index.php");
 
?>