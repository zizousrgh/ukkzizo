<?php
include 'layout/header.php'
?>

  <div class="container">
    <div class="row" style="margin-top: 1rem ;">
    <h2>Data Anggota</h2>
    <div class="call">
        <table class="table my-3">
            <thead class="table table-danger">
                <tr>
                <th scope="col">ID User</th>
                <th scope="col">Nama</th>
                <th scope="col">Aksi</th>
                </tr>
            </thead>
            <?php
                include '../koneksi/koneksi.php';

                $data = mysqli_query($koneksi, "SELECT * FROM user");
                while ($d = mysqli_fetch_array($data)) {

                
            ?>
            <tbody>
                <tr>
                <th scope="row"><?php echo $d['IDuser']; ?></th>
                <th scope="row"><?php echo $d['namalengkap']; ?></th>
                <td>
                    <a href="data/detail_anggota.php?iduser=<?php echo $d['IDuser'];?>" class="btn btn-warning twxy-white">Detail</a>
                </td>
                </tr>
            </tbody>
            <?php
            }
            ?>
        </table>
    </div>
    </div>
  </div>

<?php
include 'layout/footer.php'
?>