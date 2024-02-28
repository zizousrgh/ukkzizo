<?php 
// koneksi database
include '../../koneksi/koneksi.php';
 
// menangkap data yang di kirim dari form
$judul = $_POST['judul'];
$penulis = $_POST['penulis'];
$penerbit = $_POST['penerbit'];
$tahunterbit = $_POST['tahunterbit'];
$foto = $_FILES['foto']['name'];
$buku = $_FILES['buku']['name'];
$file = $_FILES['foto']['tmp_name'];
$file_tmp = $_FILES['buku']['tmp_name'];
$ekstensi_diperbolehkan = array('pdf');
 
// menginput data ke database
move_uploaded_file($file, '../asset/sampul/' .$foto);
move_uploaded_file($file_tmp, '../asset/buku/' .$buku);
mysqli_query($koneksi,"INSERT into buku
                             values('','$judul','$penulis','$penerbit','$tahunterbit','$foto','$buku')");
 
// mengalihkan halaman kembali ke index.php
header("location:../buku.php");
 
?> 