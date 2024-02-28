<?php
require_once('../../backend/config.php');

session_start();
if(!isset($_SESSION["user_id"]) ) {
    header("Location: ../../login.php");
    exit;
}

$query = "SELECT * FROM peminjaman WHERE status = 'sudah dikembalikan'";
$result = mysqli_query($conn, $query);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Pengembalian</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://kit.fontawesome.com/de8de52639.js" crossorigin="anonymous" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #71b7e6, #9b59b6);
            height: 100vh;
        }
        .container {
            background-color: rgba(255, 255, 255, 0.8);
            border-radius: 10px;
            padding: 20px;
            margin-top: 20px;
        }
        .img-container {
            text-align: center;
            margin-bottom: 20px;
        }
        .img-container img {
            max-width: 200px;
            height: auto;
        }
    </style>
</head>
<body>
<div class="container mt-4">
    <a href="../dashboardpetugas.php" class="btn btn-primary mb-3"><i class="fas fa-arrow-left"></i> Kembali</a>
    <h2 style="text-align: center;">Daftar Pengembalian</h2>
    <div class="row">
        <?php while ($row_pinjaman = mysqli_fetch_assoc($result)) { ?>
            <?php
            // Ambil data pengguna berdasarkan ID pengguna
            $user_id = $row_pinjaman['userid'];
            $query_user = "SELECT * FROM user WHERE id = $user_id";
            $result_user = mysqli_query($conn, $query_user);
            $user = mysqli_fetch_assoc($result_user);

            // Ambil data buku berdasarkan ID buku
            $buku_id = $row_pinjaman['bukuid'];
            $query_buku = "SELECT * FROM buku WHERE id = $buku_id";
            $result_buku = mysqli_query($conn, $query_buku);
            $buku = mysqli_fetch_assoc($result_buku);
            ?>
            <div class="col-md-4">
                <div class="img-container">
                    <img src="../../imgDB/<?= $buku["cover"]; ?>" alt="Gambar Buku">
                </div>
                <h5><?= $buku['judul']; ?></h5>
                <p><strong>ID User:</strong> <?= $user['id']; ?></p>
                <p><strong>Username User:</strong> <?= $user['username']; ?></p>
                <p><strong>Tanggal Peminjaman:</strong> <?= $row_pinjaman['tanggal_peminjaman']; ?></p>
                <p><strong>Tanggal Pengembalian:</strong> <?= $row_pinjaman['tanggal_pengembalian']; ?></p>
                <p><strong>Status:</strong> <?= $row_pinjaman['status']; ?></p>
            </div>
        <?php } ?>
    </div>
</div>
</body>
</html>
