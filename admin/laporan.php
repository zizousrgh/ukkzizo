<?php
include 'layout/header.php'
?>

    <div class="container">
        <div class="row" style="margin-top: 2rem;">
            <div class="col-sm-4">
                <div class="card text-white text-center bg-primary">
                    <h3 class="m-2">Laporan Data Anggota</h3>
                    <a href="laporan_da.php" class="btn btn-dark btn-sm">Lihat Laporan</a>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="card text-white text-center bg-success">
                    <h3 class="m-2">Laporan Data Buku</h3>
                    <a href="laporan_db.php" class="btn btn-dark btn-sm">Lihat Laporan</a>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="card text-white text-center bg-danger">
                    <h3 class="m-2">Laporan Peminjaman</h3>
                    <a href="laporan_dp.php" class="btn btn-dark btn-sm">Lihat Laporan</a>
                </div>
            </div>
        </div>
    </div>

<?php
include 'layout/footer.php'
?>