<?php
session_start();

if(!isset($_SESSION["user_id"]) ) {
  header("Location: ../login.php");
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
    <title>Admin Dashboard</title>
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

        .dropdown {
            position: absolute;
            top: 25px;
            right: 0;
        }

        .dropdown-menu {
            margin-top: 10px;
        }

        @media screen and (max-width: 600px) {
            .d-flex flex-wrap gap-2 cardImg a img {
                width: 200px;
            }
        }
    </style>
</head>
<body>
    <a class="navbar-brand">
        <img src="../assets/logoo.png" alt="logo" width="100px">
    </a>
    
    <div class="dropdown">
        <button class="btn btn-light dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
            <img src="../assets/logoadmin.png" alt="memberLogo" width="40px">
        </button>
        <ul class="dropdown-menu position-absolute mt-2 p-2">
        <li>
            <a class="dropdown-item text-center" href="#">
            <img src="../assets/logoadmin.png" alt="adminLogo" width="30px">
            </a>
          </li>
          <div class="alert alert-success" role="alert">Selamat datang - <span class="fw-bold text-capitalize"><?php echo $_SESSION['username']; ?></span> di Dashboard EPerpus</div>
          <hr>         
          <li>
            <a class="dropdown-item text-center p-2 bg-danger text-light rounded" href="signout.php">Sign Out <i class="fa-solid fa-right-to-bracket"></i></a>
          </li>
        </ul>
    </div>

    <div class="mt-5 p-4">
      <?php
      // Mendapatkan tanggal dan waktu saat ini
      $date = date('Y-m-d H:i:s'); // Format tanggal dan waktu default (tahun-bulan-tanggal jam:menit:detik)
      // Mendapatkan hari dalam format teks (e.g., Senin, Selasa, ...)
      $day = date('l');
      // Mendapatkan tanggal dalam format 1 hingga 31
      $dayOfMonth = date('d');
      // Mendapatkan bulan dalam format teks (e.g., Januari, Februari, ...)
      $month = date('F');
      // Mendapatkan tahun dalam format 4 digit (e.g., 2023)
      $year = date('Y');
      ?>

      <h1 class="mt-5 fw-bold">Dashboard - <span class="fs-4 text-secondary"> <?php echo $day. " ". $dayOfMonth." ". " ". $month. " ". $year; ?> </span></h1>
    
      <div class="alert alert-success" role="alert">Selamat datang - <span class="fw-bold text-capitalize"><?php echo $_SESSION['username']; ?></span> di Dashboard EPerpus</div>
      
      <div class="mt-4 p-3">
        <div class="d-flex flex-wrap justify-content-center gap-2">
        <div class="cardImg">
          <a href="generatelaporan/generatelaporan.php">
            <img src="../assets/generatelaporann.png" alt="daftar buku" style="max-width: 100%;" width="600px">
          </a>
        </div>
        <div class="cardImg">
          <a href="buku/tambahBuku.php">
          <img src="../assets/tambahbrgkategori.png" alt="daftar buku" style="max-width: 100%;" width="600px">
          </a>
        </div>

        <div class="cardImg">
          <a href="peminjaman/daftarpinjam.php">
            <img src="../assets/peminjamann.png" alt="daftar buku" style="max-width: 100%;" width="600px">
          </a>
        </div>
        <div class="cardImg">
          <a href="pengembalian/daftarpengembalian.php">
          <img src="../assets/pengembalianadmin.png" alt="daftar buku" style="max-width: 100%;" width="600px">
          </a>
        </div>
        <div class="cardImg">
          <a href="buku/daftarbuku.php">
          <img src="../assets/daftarBuku.png" alt="daftar buku" style="max-width: 100%;" width="600px">
          </a>
        </div>
        </div>

      </div>
      
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
  </body>
</html>