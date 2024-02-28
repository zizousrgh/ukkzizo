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
function isBookSaved($userId, $bookId, $connection) {
    $query = "SELECT * FROM koleksi WHERE userid = $userId AND bukuid = $bookId";
    $result = mysqli_query($connection, $query);
    return mysqli_num_rows($result) > 0;
}

// Handle simpan dan hapus simpan
if(isset($_POST['simpan'])) {
    $userId = $_SESSION["user_id"];
    $bookId = $_POST['bukuid'];
    $isSaved = isBookSaved($userId, $bookId, $conn);
    
    if($isSaved) {
        // Hapus penyimpanan buku
        $deleteQuery = "DELETE FROM koleksi WHERE userid = $userId AND bukuid = $bookId";
        mysqli_query($conn, $deleteQuery);
    } else {
        // Simpan buku
        $insertQuery = "INSERT INTO koleksi (userid, bukuid) VALUES ($userId, $bookId)";
        mysqli_query($conn, $insertQuery);
    }
    // Redirect kembali ke halaman setelah simpan atau hapus simpan
    header("Location: {$_SERVER['PHP_SELF']}");
    exit;
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/de8de52639.js" crossorigin="anonymous"></script>
    <title>User Dashboard</title>
    <style>
        body {
            background-image: radial-gradient(circle at 50% -20.71%, #a4d8ec 0, #a7d7ef 6.25%, #abd6f1 12.5%, #b0d5f3 18.75%, #b5d3f4 25%, #bbd2f4 31.25%, #c1d0f4 37.5%, #c7cff3 43.75%, #cdcdf2 50%, #d3cbf0 56.25%, #d9caed 62.5%, #dec8ea 68.75%, #e3c7e7 75%, #e8c6e3 81.25%, #ecc5df 87.5%, #efc4da 93.75%, #f2c4d6 100%);
            margin-top: 70px; /* Add margin-top to create space for the navbar */
            height: 100vh; /* Set height to 100% of viewport height */
        }

        .navbar-brand {
            position: absolute;
            top: 0;
            left: 0;
            margin: 10px; /* Add margin to adjust positioning */
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

        .dropdown {
            position: absolute;
            top: 25px;
            right: 0;
        }

        .dropdown-menu {
            margin-top: 10px;
        }

        .card{
            border: 2px solid #000;
        }
        .btn-tandai {
            background-color: #3c4a6b;
            color: #fff;
            border: none;
            border-radius: 5px;
            margin-left:10px;
            text-decoration: none;
            transition: background-color 0.3s ease;
            margin-right: 0px; /* Sesuaikan jarak dengan tombol Detail */
        }

        .btn-tandai:hover {
            background-color: #2c3756;
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

        @media screen and (max-width: 600px) {
            .d-flex flex-wrap gap-2 cardImg a img {
                width: 200px;
            }
        }
    </style>
</head>
<body>
<h2 class="title">Daftar Buku</h2>
    <a class="navbar-brand">
        <img src="../../assets/logoo.png" alt="logo" width="100px">
    </a>
    
    <ul class="position-absolute top-0 end-0 mt-2 p-2">
    <a href="../dashboardmember.php" class="btn btn-primary back-btn"><i class="fas fa-arrow-left me-2"></i>Kembali</a>
    </ul>
     <div class="p-4 mt-5">      
       <form action="" method="post" class="mt-5">
       <div class="input-group d-flex justify-content-end mb-3">
         <input class="border p-2 rounded rounded-end-0 bg-tertiary" type="text" name="keyword" id="keyword" placeholder="cari judul atau kategori buku...">
         <button class="border border-start-0 bg-light rounded rounded-start-0" type="submit" name="search"><i class="fa-solid fa-magnifying-glass"></i></button>
       </div>
      </form>
      
      <!--Card buku-->
    <div class="layout-card-custom">
    <?php foreach ($buku as $item) : ?>
                <?php
                // Periksa apakah buku sudah disimpan atau belum
                $isSaved = isBookSaved($_SESSION["user_id"], $item["id"], $conn);
                // Tentukan warna tombol berdasarkan status buku
                $buttonColor = $isSaved ? 'pink' : '#3c4a6b';
                // Tentukan teks label tombol berdasarkan status buku
                $buttonLabel = $isSaved ? '<i class="fas fa-check"></i> Disimpan' : '<i class="far fa-bookmark"></i> Simpan';
                ?>
       <div class="card" style="width: 15rem;">
         <img src="../../imgDB/<?= $item["cover"]; ?>" class="card-img-top" alt="coverBuku" height="250px">
         <div class="card-body">
           <h5 class="card-title"><?= $item["judul"]; ?></h5>
          </div>
          <ul class="list-group list-group-flush">
            <li class="list-group-item">Kategori : <?= $item["nama_kategori"]; ?></li>            
          </ul>
          <div class="card-body text-center"> <!-- Mengatur tombol detail menjadi berada di tengah -->
                    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>"> <!-- Ganti action ke halaman ini sendiri -->
                        <input type="hidden" name="userid" value="<?php echo $_SESSION["user_id"]; ?>"> <!-- Menggunakan session untuk user id -->
                        <input type="hidden" name="bukuid" value="<?= $item["id"]; ?>"> <!-- Menggunakan id buku dari iterasi foreach -->
                        <button type="submit" name="simpan" class="btn btn-tandai" data-bukuid="<?= $item["id"]; ?>" style="background-color: <?= $buttonColor; ?>">
                            <?= $buttonLabel; ?>
                        </button>
                        <a class="btn btn-primary btn-ulasan" href="ulasan.php?id=<?= $item["id"]; ?>">Ulasan</a>
                        <a class="btn btn-success" href="detailBuku.php?id=<?= $item["id"]; ?>">Pinjam</a>
                    </form>
                </div>
        </div>
       <?php endforeach; ?>
      <div>
     </div>
    </body>
    </html>
