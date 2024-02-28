<?php
require('config.php');

// Periksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Langkah 2: Proses untuk memasukkan data ke tabel peminjaman
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data dari formulir
    $userid = $_POST['userid'];
    $bukuid = $_POST['bukuid'];
    $tanggal_peminjaman = $_POST['tanggal_peminjaman'];
    $tanggal_pengembalian = $_POST['tanggal_pengembalian'];
    // Set status secara otomatis
    $status = "belum dikembalikan";

    // Periksa apakah user sudah memiliki peminjaman untuk buku yang sama yang belum dikembalikan
    $sql_check = "SELECT * FROM peminjaman WHERE userid = ? AND bukuid = ? AND status = 'belum dikembalikan'";
    $stmt_check = $conn->prepare($sql_check);
    $stmt_check->bind_param("ii", $userid, $bukuid);
    $stmt_check->execute();
    $result_check = $stmt_check->get_result();

    if ($result_check->num_rows > 0) {
        // Jika user memiliki peminjaman untuk buku yang sama yang belum dikembalikan
        echo "<script>alert('Maaf, Anda sudah meminjam buku ini dan belum mengembalikannya.'); window.location.href='../dashboardmember/buku/pinjambuku.php';</script>";
        exit();
    }

    // Siapkan pernyataan SQL untuk dimasukkan ke dalam tabel peminjaman
    $sql_insert = "INSERT INTO peminjaman (userid, bukuid, tanggal_peminjaman, tanggal_pengembalian, status) 
            VALUES (?, ?, ?, ?, ?)";

    // Persiapkan pernyataan SQL
    $stmt_insert = $conn->prepare($sql_insert);

    // Binding parameter
    $stmt_insert->bind_param("iisss", $userid, $bukuid, $tanggal_peminjaman, $tanggal_pengembalian, $status);

    if ($stmt_insert->execute()) {
        echo "<script>alert('Peminjaman Berhasil'); window.location.href='../dashboardmember/buku/detailpeminjaman.php';</script>";
        exit();
    } else {
        echo "<script>alert('Peminjaman Gagal'); window.location.href='../dashboardmember/buku/pinjambuku.php';</script>";
        exit();
    }
}

// Tutup koneksi
$conn->close();
?>
