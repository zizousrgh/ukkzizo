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

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pinjam Buku</title>
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
            max-width: 300px;
            height: auto;
        }
    </style>
</head>
<body>
<div class="container mt-4">
    <h2>Pinjam Buku</h2>
    <div class="row">
        <div class="col-md-4">
            <div class="img-container">
                <img src="../../imgDB/<?= $buku["cover"]; ?>" alt="Gambar Buku">
            </div>
        </div>
        <div class="col-md-8">
            <!-- Detail Buku -->
            <h3>Detail Buku</h3>
            <form>
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
                <!-- tambahkan atribut lainnya sesuai kebutuhan -->
            </form>
            <!-- Form untuk peminjaman -->
            <h3>Form Peminjaman</h3>
            <form action="../../backend/pinjam.php" method="POST">
                <!-- Input hidden untuk ID user -->
                <input type="hidden" name="userid" value="<?= isset($_SESSION['user_id']) ? $_SESSION['user_id'] : ''; ?>">
                <!-- Input hidden untuk ID buku -->
                <input type="hidden" name="bukuid" value="<?= $buku['id']; ?>">
                <div class="mb-3">
                    <label for="tanggal_pinjam" class="form-label">Tanggal Peminjaman</label>
                    <input type="date" class="form-control" id="tanggal_pinjam" name="tanggal_peminjaman" min="<?= date('Y-m-d'); ?>" required>
                </div>
                <div class="mb-3">
                    <label for="tanggal_pengembalian" class="form-label">Tanggal Pengembalian (Maksimal 7 hari)</label>
                    <!-- Input tanggal pengembalian -->
                    <input type="date" class="form-control" id="tanggal_pengembalian" name="tanggal_pengembalian" required>
                </div>
                <button type="submit" class="btn btn-success">Pinjam</button>
                <a href="daftarbuku.php" class="btn btn-danger ms-2">Batal</a>
            </form>
        </div>
    </div>
</div>

<script>
// Fungsi untuk menghitung tanggal pengembalian setelah tanggal peminjaman dipilih
function hitungTanggalPengembalian() {
    var tanggalPinjam = new Date(document.getElementById("tanggal_pinjam").value);
    var tanggalPengembalian = new Date(tanggalPinjam);
    tanggalPengembalian.setDate(tanggalPengembalian.getDate() + 7);

    // Mendapatkan tanggal hari ini
    var tanggalHariIni = new Date();

    // Jika tanggal pengembalian lebih awal dari hari ini, atur tanggal pengembalian sama dengan hari ini
    if (tanggalPengembalian < tanggalHariIni) {
        tanggalPengembalian = new Date(tanggalHariIni);
    }

    // Format tanggal ke format yang sesuai dengan input date
    var tanggalFormatted = tanggalPengembalian.toISOString().slice(0, 10);

    // Set nilai minimum dan maksimum pada input tanggal pengembalian
    document.getElementById("tanggal_pengembalian").setAttribute("min", tanggalPinjam.toISOString().slice(0, 10));
    document.getElementById("tanggal_pengembalian").setAttribute("max", tanggalFormatted);
}

// Panggil fungsi saat tanggal peminjaman berubah
document.getElementById("tanggal_pinjam").addEventListener("change", hitungTanggalPengembalian);

// Panggil fungsi untuk pertama kali saat halaman dimuat
hitungTanggalPengembalian();
</script>



</body>
</html>
