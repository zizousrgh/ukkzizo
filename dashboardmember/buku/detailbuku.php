<?php
require_once('../../backend/config.php');

// Pastikan user sudah login
session_start();
if (!isset($_SESSION["user_id"])) {
    header("Location: ../../login.php");
    exit;
}

// Ambil ID buku yang akan dilihat detailnya dari parameter URL
if (!isset($_GET['id'])) {
    // Redirect jika parameter id tidak ditemukan
    header("Location: daftarbuku.php");
    exit;
}
$id_buku = $_GET['id'];

// Ambil data buku berdasarkan ID
$query_buku = "SELECT * FROM buku WHERE id = ?";
$stmt_buku = $conn->prepare($query_buku);
$stmt_buku->bind_param("i", $id_buku);
$stmt_buku->execute();
$result_buku = $stmt_buku->get_result();
$buku = $result_buku->fetch_assoc();

// Ambil rata-rata rating buku
$query_avg_rating = "SELECT AVG(rating) AS avg_rating FROM ulasan WHERE bukuid = ?";
$stmt_avg_rating = $conn->prepare($query_avg_rating);
$stmt_avg_rating->bind_param("i", $id_buku);
$stmt_avg_rating->execute();
$result_avg_rating = $stmt_avg_rating->get_result();
$row_avg_rating = $result_avg_rating->fetch_assoc();
$avg_rating = $row_avg_rating['avg_rating'];

// Ambil kategori buku yang terkait dengan buku
$query_kategori = "SELECT kb.id, kb.nama_kategori FROM kategoribuku_relasi kbr
                    JOIN kategoribuku kb ON kbr.kategori_id = kb.id
                    WHERE kbr.buku_id = ?";
$stmt_kategori = $conn->prepare($query_kategori);
$stmt_kategori->bind_param("i", $id_buku);
$stmt_kategori->execute();
$result_kategori = $stmt_kategori->get_result();
$kategoribuku = $result_kategori->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Buku</title>
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
        }
        .img-container {
            text-align: center;
            margin-bottom: 20px;
        }
        .img-container img {
            max-width: 300px;
            height: auto;
        }
        .rating {
            color: #black;
            font-size: 24px;
        }
        .btn-pinjam {
            background-color: #6cb2eb;
            border-color: #6cb2eb;
        }
        .btn-pinjam:hover {
            background-color: #55a6e0;
            border-color: #55a6e0;
        }
    </style>
</head>
<body>
<div class="container mt-4">
    <h2>Detail Buku</h2>
    <div class="row">
        <div class="col-md-4">
            <div class="img-container">
                <img src="../../imgDB/<?= $buku["cover"]; ?>" alt="Gambar Buku">
                <div class="rating">
                    <?php
                    if ($avg_rating !== null) {
                        $rating_out_of_5 = ($avg_rating / 5) * 5;
                        echo "Rating: " . number_format($rating_out_of_5, 1) . "/5.0";
                    } else {
                        echo 'Belum ada ulasan';
                    }
                    ?>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="mb-3">
                <label for="judul" class="form-label">Judul</label>
                <input type="text" class="form-control" id="judul" name="judul" value="<?= $buku['judul']; ?>" readonly>
            </div>
            <div class="mb-3">
                <label for="penulis" class="form-label">Penulis</label>
                <input type="text" class="form-control" id="penulis" name="penulis" value="<?= $buku['penulis']; ?>" readonly>
            </div>
            <div class="mb-3">
                <label for="penerbit" class="form-label">Penerbit</label>
                <input type="text" class="form-control" id="penerbit" name="penerbit" value="<?= $buku['penerbit']; ?>" readonly>
            </div>
            <div class="mb-3">
                <label for="tahun_terbit" class="form-label">Tahun Terbit</label>
                <input type="text" class="form-control" id="tahun_terbit" name="tahun_terbit" value="<?= $buku['tahun_terbit']; ?>" readonly>
            </div>
            <div class="mb-3">
                <label for="sinopsis" class="form-label">Sinopsis</label>
                <textarea class="form-control" id="sinopsis" name="sinopsis" readonly><?= $buku['sinopsis']; ?></textarea>
            </div>
            <div class="mb-3">
                <label for="kategori" class="form-label">Kategori</label>
                <select class="form-select" id="kategori" name="kategori" disabled>
                    <?php foreach ($kategoribuku as $kategori) : ?>
                        <option value="<?= $kategori['id']; ?>" <?= ($kategori['id'] == $buku['kategori_id']) ? 'selected' : ''; ?>><?= $kategori['nama_kategori']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="mb-3 text-end">
                <a class="btn btn-pinjam" href="pinjambuku.php?id=<?= $id_buku; ?>">Pinjam</a>
                <a href="daftarbuku.php" class="btn btn-danger me-2">Batal</a>
            </div>
        </div>
    </div>
</div>
</body>
</html>
