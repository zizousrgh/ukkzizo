<?php
$conn = mysqli_connect("localhost", "root", "", "eperpus");
session_start();

if(!isset($_SESSION["user_id"]) ) {
  header("Location: ../../login.php");
  exit;
}

if (isset($_POST['search'])) {
    $keyword = $_POST['keyword'];
    // Buat query pencarian
    $query = "SELECT buku.*, kategoribuku.nama_kategori FROM buku
              JOIN kategoribuku_relasi ON buku.id = kategoribuku_relasi.buku_id
              JOIN kategoribuku ON kategoribuku_relasi.kategori_id = kategoribuku.id
              WHERE buku.judul LIKE '%$keyword%'
              OR kategoribuku.nama_kategori LIKE '%$keyword%'";
  } else {
    // Jika tidak ada pencarian, ambil semua buku
    $query = "SELECT buku.*, kategoribuku.nama_kategori FROM buku
              JOIN kategoribuku_relasi ON buku.id = kategoribuku_relasi.buku_id
              JOIN kategoribuku ON kategoribuku_relasi.kategori_id = kategoribuku.id";
  }

$result = mysqli_query($conn, $query);
$buku = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola buku || Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://kit.fontawesome.com/de8de52639.js" crossorigin="anonymous" rel="stylesheet">
    <style>
        body {
            background-image: radial-gradient(circle at 50% -20.71%, #a4d8ec 0, #a7d7ef 6.25%, #abd6f1 12.5%, #b0d5f3 18.75%, #b5d3f4 25%, #bbd2f4 31.25%, #c1d0f4 37.5%, #c7cff3 43.75%, #cdcdf2 50%, #d3cbf0 56.25%, #d9caed 62.5%, #dec8ea 68.75%, #e3c7e7 75%, #e8c6e3 81.25%, #ecc5df 87.5%, #efc4da 93.75%, #f2c4d6 100%);
            height: 100vh; /* Set height to 100% of viewport height */
        }

        .title {
            text-align: center;
            color: #fff;
            margin-bottom: 2rem;
            text-shadow: 0 0 3px black; /* Tambahkan stroke pada judul */
        }

        .layout-card-custom {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 1.5rem;
        }

        .back-btn {
            text-align:center;
            margin-bottom: 20px;            
            margin-left: -40px;
            position: absolute;
            top: 0;
            transform: translate(-50%, 50%);
            background-color: #3c4a6b;
            border: none;
            color: #fff;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }

        .back-btn:hover {
            background-color: #2c3859;
        }

        .card{
            border: 2px solid #000;
        }

    </style>
</head>
<body>
<a class="navbar-brand">
        <img src="../../assets/logoo.png" alt="logo" width="100px">
    </a>
    <ul class="position-absolute top-0 end-0 mt-2 p-2">
    <a href="../dashboardadmin.php" class="btn btn-primary back-btn"><i class="fas fa-arrow-left me-2"></i>Kembali</a>
    </ul>
        <!-- Content -->
        <div class="p-4 mt-4">
            <h2 class="title">Daftar Buku</h2>
            
            <!-- Form pencarian -->
            <form action="" method="post" class="mt-3">
                <div class="input-group d-flex justify-content-end mb-3">
                    <input class="border p-2 rounded rounded-end-0 bg-tertiary" type="text" name="keyword" id="keyword" placeholder="cari data buku...">
                    <button class="border border-start-0 bg-light rounded rounded-start-0" type="submit" name="search"><i class="fa-solid fa-magnifying-glass"></i></button>
                </div>
            </form>
            
            <!-- Card buku -->
            <div class="layout-card-custom">
                <?php foreach ($buku as $item) : ?>
                    <div class="card" style="width: 15rem;">
                        <img src="../../imgDB/<?= $item["cover"]; ?>" class="card-img-top" alt="coverBuku" height="250px">
                        <div class="card-body">
                            <h5 class="card-title"><?= $item["judul"]; ?></h5>
                        </div>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">Kategori : <?= $item["nama_kategori"]; ?></li>
                            <li class="list-group-item">Id Buku : <?= $item["id"]; ?></li>                    
                        </ul>
                        <div class="card-body">
                            <a class="btn btn-success" href="updatebuku.php?id=<?= $item["id"]; ?>" id="review">Edit</a>
                            <a name ="delete" class="btn btn-danger" href="../../backend/deletebuku.php?id=<?= $item["id"]; ?>" onclick="return confirm('Yakin ingin menghapus data buku ? ');">Delete</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

