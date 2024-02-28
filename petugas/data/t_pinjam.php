<?php 
// koneksi database
include '../../koneksi/koneksi.php';
 
// menangkap data yang di kirim dari form
$IDuser = $_POST['IDuser'];
$IDbuku = $_POST['IDbuku'];
$tgl_peminjaman = $_POST['tgl_peminjaman'];
$tgl_pengembalian = $_POST['tgl_pengembalian'];
$nama = $_POST['nama'];
$status_peminjaman = $_POST['status_peminjaman'];
 
// menginput data ke database
mysqli_query($koneksi,"INSERT into peminjaman (IDuser ,IDbuku,tgl_peminjaman,tgl_pengembalian,nama, status_peminjaman)
                             values('$IDuser','$IDbuku','$tgl_peminjaman','$tgl_pengembalian','$nama','$status_peminjaman')");
 
// mengalihkan halaman kembali ke index.php
header("location:../peminjam.php");
 
?>