<?php
require_once('../../backend/config.php');

// Pastikan user sudah login
session_start();
if (!isset($_SESSION["user_id"])) {
    header("Location: ../../login.php");
    exit;
}

// Ambil ID buku yang akan diupdate dari parameter URL
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

// Ambil kategori buku
$query_kategori = "SELECT * FROM kategoribuku";
$result_kategori = mysqli_query($conn, $query_kategori);
$kategoribuku = mysqli_fetch_all($result_kategori, MYSQLI_ASSOC);

// Handle submit form update
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $judul = $_POST['judul'];
    $penulis = $_POST['penulis'];
    $penerbit = $_POST['penerbit'];
    $tahun_terbit = $_POST['tahun_terbit'];
    $sinopsis = $_POST['sinopsis'];
    $kategori_id = $_POST['kategori'];

    // Update data buku
    $query_update = "UPDATE buku SET judul=?, penulis=?, penerbit=?, tahun_terbit=?, sinopsis=? WHERE id=?";
    $stmt_update = $conn->prepare($query_update);
    $stmt_update->bind_param("sssssi", $judul, $penulis, $penerbit, $tahun_terbit, $sinopsis, $id_buku);
    if ($stmt_update->execute()) {
        // Update kategori buku
        $query_update_kategori = "UPDATE kategoribuku_relasi SET kategori_id=? WHERE buku_id=?";
        $stmt_update_kategori = $conn->prepare($query_update_kategori);
        $stmt_update_kategori->bind_param("ii", $kategori_id, $id_buku);
        $stmt_update_kategori->execute();

        // Redirect ke halaman daftar buku setelah update berhasil
        header("Location: daftarbuku.php");
        exit;
    } else {
        // Redirect ke halaman error jika update gagal
        header("Location: error.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Buku || Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://kit.fontawesome.com/de8de52639.js" crossorigin="anonymous" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #71b7e6, #9b59b6);
            height: 100vh;
        }
        .container {
            background-color: rgba(255, 255, 255, 0.8); /* Warna latar belakang dengan opasitas 80% */
            border-radius: 10px; /* Membuat sudut elemen melengkung */
            padding: 20px; /* Padding untuk konten di dalamnya */
        }
    </style>
</head>
<body>
<div class="container mt-4">
    <h2>Update Buku</h2>
    <form action="" method="POST">
        <div class="mb-3">
            <label for="judul" class="form-label">Judul</label>
            <input type="text" class="form-control" id="judul" name="judul" value="<?= $buku['judul']; ?>">
        </div>
        <div class="mb-3">
            <label for="penulis" class="form-label">Penulis</label>
            <input type="text" class="form-control" id="penulis" name="penulis" value="<?= $buku['penulis']; ?>">
        </div>
        <div class="mb-3">
            <label for="penerbit" class="form-label">Penerbit</label>
            <input type="text" class="form-control" id="penerbit" name="penerbit" value="<?= $buku['penerbit']; ?>">
        </div>
        <div class="mb-3">
            <label for="tahun_terbit" class="form-label">Tahun Terbit</label>
            <input type="text" class="form-control" id="tahun_terbit" name="tahun_terbit" value="<?= $buku['tahun_terbit']; ?>">
        </div>
        <div class="mb-3">
            <label for="sinopsis" class="form-label">Sinopsis</label>
            <textarea class="form-control" id="sinopsis" name="sinopsis"><?= $buku['sinopsis']; ?></textarea>
        </div>
        <div class="mb-3">
            <label for="kategori" class="form-label">Kategori</label>
            <select class="form-select" id="kategori" name="kategori">
                <?php foreach ($kategoribuku as $kategori) : ?>
                    <option value="<?= $kategori['id']; ?>" <?= ($kategori['id'] == $buku['kategori_id']) ? 'selected' : ''; ?>><?= $kategori['nama_kategori']; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
