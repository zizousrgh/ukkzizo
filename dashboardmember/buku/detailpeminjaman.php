<?php
require_once('../../backend/config.php');

// Pastikan user sudah login
session_start();
if (!isset($_SESSION["user_id"])) {
    header("Location: ../../login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Buku yang Dipinjam</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://kit.fontawesome.com/de8de52639.js" crossorigin="anonymous" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #71b7e6, #9b59b6);
            height: auto;
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
        .btn-back {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
<div class="container mt-4">
    <div class="btn-back">
        <a href="../dashboardmember.php" class="btn btn-primary">Kembali</a>
    </div>
    <h2 style="text-align: center;">Daftar Buku yang Dipinjam</h2>
    <div class="row">
        <?php 
        require_once('../../backend/config.php');
        session_start();
        if (!isset($_SESSION["user_id"])) {
            header("Location: ../../login.php");
            exit;
        }
        $user_id = $_SESSION["user_id"];
        $query_pinjaman = "SELECT * FROM peminjaman WHERE userid = ?";
        $stmt_pinjaman = $conn->prepare($query_pinjaman);
        $stmt_pinjaman->bind_param("i", $user_id);
        $stmt_pinjaman->execute();
        $result_pinjaman = $stmt_pinjaman->get_result();
        while ($row_pinjaman = $result_pinjaman->fetch_assoc()) { 
            $buku_id = $row_pinjaman['bukuid'];
            $query_buku = "SELECT * FROM buku WHERE id = ?";
            $stmt_buku = $conn->prepare($query_buku);
            $stmt_buku->bind_param("i", $buku_id);
            $stmt_buku->execute();
            $result_buku = $stmt_buku->get_result();
            $buku = $result_buku->fetch_assoc();
            if ($row_pinjaman['status'] === 'belum dikembalikan') {
        ?>
        <div class="col-md-4">
    <div class="img-container">
        <img src="../../imgDB/<?= $buku["cover"]; ?>" alt="Gambar Buku">
    </div>
    <h5><?= $buku['judul']; ?></h5>
    <p><strong>Penulis:</strong> <?= $buku['penulis']; ?></p>
    <p><strong>Penerbit:</strong> <?= $buku['penerbit']; ?></p>
    <p><strong>Tanggal Peminjaman:</strong> <?= $row_pinjaman['tanggal_peminjaman']; ?></p>
    <p><strong>Tanggal Pengembalian:</strong> <?= $row_pinjaman['tanggal_pengembalian']; ?></p>
    <p><strong>Status:</strong> <?= $row_pinjaman['status']; ?></p>
    <!--<form action="../../backend/kembalikan.php" method="get">
        <input type="hidden" name="pinjaman_id" value="<?= $row_pinjaman['id']; ?>">
        <input type="hidden" name="book_id" value="<?= $buku_id ?>">
        <button type="submit" class="btn btn-danger">Kembalikan</button>
    </form>!-->
    <form class="rating-form" action="../../backend/prosesrating.php" method="GET">
                <input type="hidden" name="pinjaman_id" value="<?= $row_pinjaman['id']; ?>">
                <input type="hidden" name="book_id" value="<?= $buku_id ?>">
                <div class="mb-3">
                    <label for="rating" class="form-label">Rating (1-5)</label>
                    <input type="number" class="form-control" id="rating" name="rating" min="1" max="5" required>
                </div>
                <div class="mb-3">
                    <label for="review" class="form-label">Ulasan</label>
                    <textarea class="form-control" id="review" name="ulasan"></textarea>
                </div>
                <button type="submit" class="btn btn-danger">Kembalikan</button>
    </form>
</div>
        <?php 
            } // end if
        } // end while
        ?>
    </div>
</div>
</body>
</html>