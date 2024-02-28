<?php
require_once('config.php');

// Pastikan parameter pinjaman_id dan book_id tersedia
if(isset($_GET['pinjaman_id']) && isset($_GET['book_id'])) {
    $pinjaman_id = $_GET['pinjaman_id'];
    $book_id = $_GET['book_id'];

    // Jalankan query untuk memperbarui status peminjaman menjadi "sudah dikembalikan"
    $update_query = "UPDATE peminjaman SET status = 'sudah dikembalikan' WHERE id = ?";
    $stmt = $conn->prepare($update_query);
    $stmt->bind_param("i", $pinjaman_id);
    
    if ($stmt->execute()) {
        // Redirect ke halaman memberi ulasan
        header("Location: ../dashboardmember/buku/rating.php?id=$book_id");
        exit;
    } else {
        echo "Gagal memperbarui status peminjaman.";
    }    
} 
?>
