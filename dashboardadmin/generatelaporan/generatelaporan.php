<?php
$conn = mysqli_connect("localhost", "root", "", "eperpus");

// Periksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Mendapatkan jumlah peminjaman
$sql_peminjaman = "SELECT COUNT(*) as total_peminjaman FROM peminjaman";
$result_peminjaman = $conn->query($sql_peminjaman);
$row_peminjaman = $result_peminjaman->fetch_assoc();
$total_peminjaman = $row_peminjaman['total_peminjaman'];

// Mendapatkan jumlah member yang statusnya peminjam
$sql_member_peminjam = "SELECT COUNT(*) as total_peminjam FROM user WHERE role = 'peminjam'";
$result_member_peminjam = $conn->query($sql_member_peminjam);
$row_member_peminjam = $result_member_peminjam->fetch_assoc();
$total_peminjam = $row_member_peminjam['total_peminjam'];

// Mendapatkan user yang paling banyak meminjam
$sql_user_paling_banyak_meminjam = "SELECT u.fullname, COUNT(*) as total_peminjaman_user 
                                    FROM peminjaman p 
                                    JOIN user u ON p.userid = u.id 
                                    GROUP BY u.id 
                                    ORDER BY total_peminjaman_user DESC 
                                    LIMIT 1";
$result_user_paling_banyak_meminjam = $conn->query($sql_user_paling_banyak_meminjam);
$row_user_paling_banyak_meminjam = $result_user_paling_banyak_meminjam->fetch_assoc();
$user_paling_banyak_meminjam = $row_user_paling_banyak_meminjam['fullname'];
$total_peminjaman_user = $row_user_paling_banyak_meminjam['total_peminjaman_user'];

// Mendapatkan buku yang paling banyak dipinjam
$sql_buku_paling_banyak_dipinjam = "SELECT b.judul, COUNT(*) as total_peminjaman_buku 
                                    FROM peminjaman p 
                                    JOIN buku b ON p.bukuid = b.id 
                                    GROUP BY b.id 
                                    ORDER BY total_peminjaman_buku DESC 
                                    LIMIT 1";
$result_buku_paling_banyak_dipinjam = $conn->query($sql_buku_paling_banyak_dipinjam);
$row_buku_paling_banyak_dipinjam = $result_buku_paling_banyak_dipinjam->fetch_assoc();
$buku_paling_banyak_dipinjam = $row_buku_paling_banyak_dipinjam['judul'];
$total_peminjaman_buku = $row_buku_paling_banyak_dipinjam['total_peminjaman_buku'];

// Mendapatkan jumlah buku per kategori
$sql_kategori_buku = "SELECT kb.nama_kategori, COUNT(*) as total_buku_kategori 
                      FROM kategoribuku_relasi kr 
                      JOIN kategoribuku kb ON kr.kategori_id = kb.id 
                      GROUP BY kb.id";
$result_kategori_buku = $conn->query($sql_kategori_buku);

// Mendapatkan buku yang paling banyak disimpan
$sql_buku_paling_banyak_disimpan = "SELECT b.judul, COUNT(*) as total_koleksi 
                                    FROM koleksi k 
                                    JOIN buku b ON k.bukuid = b.id 
                                    GROUP BY b.id 
                                    ORDER BY total_koleksi DESC 
                                    LIMIT 1";
$result_buku_paling_banyak_disimpan = $conn->query($sql_buku_paling_banyak_disimpan);
$row_buku_paling_banyak_disimpan = $result_buku_paling_banyak_disimpan->fetch_assoc();
$buku_paling_banyak_disimpan = $row_buku_paling_banyak_disimpan['judul'];
$total_koleksi_buku = $row_buku_paling_banyak_disimpan['total_koleksi'];

// Menutup koneksi
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generate Laporan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://kit.fontawesome.com/de8de52639.js" crossorigin="anonymous" rel="stylesheet">
    <style>
        body {
            background-image: radial-gradient(circle at 50% -20.71%, #a4d8ec 0, #a7d7ef 6.25%, #abd6f1 12.5%, #b0d5f3 18.75%, #b5d3f4 25%, #bbd2f4 31.25%, #c1d0f4 37.5%, #c7cff3 43.75%, #cdcdf2 50%, #d3cbf0 56.25%, #d9caed 62.5%, #dec8ea 68.75%, #e3c7e7 75%, #e8c6e3 81.25%, #ecc5df 87.5%, #efc4da 93.75%, #f2c4d6 100%);
            height: 100vh;
        }

        .title {
            text-align: center;
            color: #fff;
            margin-bottom: 2rem;
            text-shadow: 0 0 3px black;
        }

        .layout-table {
            margin-top: 20px;
        }

        .layout-table table {
            width: 100%;
            border-collapse: collapse;
        }

        .layout-table th, .layout-table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
            font-weight: normal;
        }

        .layout-table th {
            background-color: #f2f2f2;
            color: #333;
            font-weight: bold;
            text-transform: uppercase;
        }

        .layout-table tbody tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .layout-table tbody tr:hover {
            background-color: #ddd;
        }

        .layout-table ul {
            padding: 0;
            margin: 0;
            list-style: none;
        }

        .layout-table ul li {
            margin-bottom: 4px;
        }

        @media print {
            .print-button, .back-btn {
                display: none !important;
            }
        }

        .back-btn {
            text-align:center;
            margin-bottom: 20px;            
            margin-left: 40px;
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

        .print-button {
            background-color: #4caf50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-bottom: 20px;
            text-decoration: none;
            transition: background-color 0.3s ease;
            display: block;
            margin: auto;
        }

        .print-button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <a href="../dashboardadmin.php" class="btn btn-primary back-btn"><i class="fas fa-arrow-left me-2"></i>Kembali</a>
    <div class="container p-4 mt-4">
        <h2 class="title">Generate Laporan</h2>
        <!-- Data Laporan -->
        <div class="layout-table">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Keterangan</th>
                        <th>Jumlah</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Total Peminjaman</td>
                        <td><?php echo $total_peminjaman; ?></td>
                    </tr>
                    <tr>
                        <td>Total Member</td>
                        <td><?php echo $total_peminjam; ?></td>
                    </tr>
                    <tr>
                        <td>User Paling Banyak Meminjam</td>
                        <td><?php echo $user_paling_banyak_meminjam; ?> (Total Peminjaman: <?php echo $total_peminjaman_user; ?>)</td>
                    </tr>
                    <tr>
                        <td>Buku Paling Banyak Dipinjam</td>
                        <td><?php echo $buku_paling_banyak_dipinjam; ?> (Total Peminjaman: <?php echo $total_peminjaman_buku; ?>)</td>
                    </tr>
                    <tr>
                        <td>Kategori Buku</td>
                        <td>
                            <ul>
                                <?php while($row_kategori_buku = $result_kategori_buku->fetch_assoc()): ?>
                                    <li><?php echo $row_kategori_buku['nama_kategori']; ?>: <?php echo $row_kategori_buku['total_buku_kategori']; ?> buku</li>
                                <?php endwhile; ?>
                            </ul>
                        </td>
                    </tr>
                    <tr>
                        <td>Buku Paling Banyak Disimpan</td>
                        <td><?php echo $buku_paling_banyak_disimpan; ?> (Total Koleksi: <?php echo $total_koleksi_buku; ?>)</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <a href="javascript:void(0)" class="print-button" onclick="window.print()">Cetak Laporan</a>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
