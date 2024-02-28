<?php 
// mengaktifkan session pada php
session_start();
 
// menghubungkan php dengan koneksi database
include '../koneksi/koneksi.php';
 
// menangkap data yang dikirim dari form login
$username = $_POST['username'];
$password = md5($_POST['password']);
 
 
// menyeleksi data user dengan username dan password yang sesuai
$login = mysqli_query($koneksi,"SELECT * from user where username='$username' and password='$password'");
// menghitung jumlah data yang ditemukan
$cek = mysqli_num_rows($login);
 
// cek apakah username dan password di temukan pada database
if($cek > 0){
 
 $data = mysqli_fetch_assoc($login);
 
 // cek jika user login sebagai admin
 if($data['level']=="admin"){
 
 // buat session login dan username
 $_SESSION['username'] = $username;
 $_SESSION['level'] = "admin";
 // alihkan ke halaman dashboard admin
 header("location:../admin/index_adm.php");
 
 // cek jika user login sebagai pegawai
 }else if($data['level']=="petugas"){
 // buat session login dan username
 $_SESSION['username'] = $username;
 $_SESSION['level'] = "petugas";
 // alihkan ke halaman dashboard pegawai
 header("location:../petugas/index_pts.php");
 
 // cek jika user login sebagai pengurus
 }else if($data['level']=="peminjam"){
 // buat session login dan username
 $_SESSION['username'] = $username;
 $_SESSION['level'] = "peminjam";
 // alihkan ke halaman dashboard pengurus
 header("location:../peminjam/index_pmj.php");
 
 }else{
 
 // alihkan ke halaman login kembali
 header("location:../index.php?pesan=gagal");
 } 
}else{
 header("location:../index.php?pesan=gagal");
}
 
?>