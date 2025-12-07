<?php
include 'koneksi.php';

if(isset($_GET['id'])){
    $id = (int)$_GET['id'];
    
    // Gunakan prepared statement untuk keamanan
    $stmt = mysqli_prepare($koneksi, "DELETE FROM anggota WHERE id_anggota = ?");
    mysqli_stmt_bind_param($stmt, "i", $id);
    
    if(mysqli_stmt_execute($stmt)){
        header("location:anggota.php");
    } else {
        // Jika gagal (biasanya karena data sedang dipakai di transaksi), tampilkan pesan
        echo "<script>alert('Gagal menghapus! Siswa ini mungkin masih memiliki data peminjaman.'); window.location='anggota.php';</script>";
    }
}
?>