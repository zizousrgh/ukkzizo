<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Detail Peminjaman</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  </head>
  <body>
    <div class="container" style="margin-top: 5rem;">
        <div class="card">
            <div class="row m-4">
            <?php
                include '../../koneksi/koneksi.php';
                if (isset($_GET['idp'])) {
                    $idp = $_GET['idp'];
                }else{
                    die ("error, Data tidak ditemukan");
                }
                $query = mysqli_query($koneksi, "SELECT * FROM peminjaman WHERE IDpeminjaman='$idp' ");
                $result = mysqli_fetch_array($query);
            ?>
                <div class="col">
                <h2>Detail Peminjam</h2>
                <a href="../peminjam.php" class="btn btn-danger">Kembali</a> <hr>
                    <table>
                        <tr>
                            <td><h5>ID Peminjaman</h5></td>
                            <td><h5>: <?php echo $result['IDpeminjaman']; ?></h5></td>
                        </tr>
                        <tr>
                            <td><h5>ID User</h5></td>
                            <td><h5>: <?php echo $result['IDuser']; ?></h5></td>
                        </tr>
                        <tr>
                            <td><h5>ID Buku</h5></td>
                            <td><h5>:  <?php echo $result['IDbuku']; ?></h5></td>
                        </tr>
                        <tr>
                            <td><h5>Nama Peminjam</h5></td>
                            <td><h5>: <?php echo $result['nama']; ?></h5></td>
                        </tr>
                        <tr>
                            <td><h5>Tanggal Peminjaman</h5></td>
                            <td><h5>: <?php echo $result['tgl_peminjaman']; ?></h5></td>
                        </tr>
                        <tr>
                            <td><h5>Tanggal Pengembalian</h5></td>
                            <td><h5>: <?php echo $result['tgl_pengembalian']; ?></h5></td>
                        </tr>
                        <tr>
                            <td><h5>Status Peminjaman</h5></td>
                            <td><h5>: <?php echo $result['status_peminjaman']; ?></h5></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  </body>
</html>