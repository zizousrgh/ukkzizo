<?php
// Lakukan koneksi ke database (disesuaikan dengan detail koneksi Anda)
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'eperpus';

$conn = new mysqli($host, $username, $password, $database);

// Periksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Cek apakah tombol simpan diklik
if(isset($_POST['simpan'])){
    // Ambil nilai user id dan buku id dari form
    $userid = $_POST['userid'];
    $bukuid = $_POST['bukuid'];

    // Query untuk memeriksa apakah buku sudah ada dalam koleksi user
    $check_query = "SELECT * FROM koleksi WHERE userid = '$userid' AND bukuid = '$bukuid'";
    $result = $conn->query($check_query);

    if ($result->num_rows > 0) {
        // Buku sudah ada dalam koleksi, tidak perlu tambahkan entri baru
        echo "<script>alert('Buku sudah ada dalam koleksi.'); window.location.href='../dashboardmember/buku/daftarbuku.php';</script>";
        exit();
    } else {
        // Buku belum ada dalam koleksi, tambahkan entri baru
        $query = "INSERT INTO koleksi (userid, bukuid) VALUES ('$userid', '$bukuid')";
        if ($conn->query($query) === TRUE) {
            echo "<script>alert('Buku Telah Ditambahkan ke Koleksi'); window.location.href='../dashboardmember/buku/daftarbuku.php';</script>";
            exit();
        } else {
            echo "Error: " . $query . "<br>" . $conn->error;
        }
    }
}

// Tutup koneksi
$conn->close();
?>
