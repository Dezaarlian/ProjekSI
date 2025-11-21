<?php
session_start();
include 'koneksi.php';
if ($_SESSION['status'] != "login") header("location:index.php");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Data Buku</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <div class="menu">
        <a href="buku.php">📖 DATA BUKU</a>
        <a href="transaksi.php">🔄 TRANSAKSI</a>
        <a href="logout.php" class="logout">LOGOUT 🚪</a>
    </div>

    <div class="container">
        <div style="display:flex; justify-content:space-between; align-items:center;">
            <h3>Daftar Buku Perpustakaan</h3>
            <a href="tambah_buku.php" class="btn">+ Tambah Buku</a>
        </div>
        <hr style="border: 1px solid #eee;">

        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Judul Buku</th>
                    <th>Pengarang</th>
                    <th>Penerbit</th>
                    <th>Tahun</th>
                    <th width="150px">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                $data = mysqli_query($koneksi, "SELECT * FROM buku");
                while($d = mysqli_fetch_array($data)){
                ?>
                <tr>
                    <td><?php echo $no++; ?></td>
                    <td><b><?php echo $d['judul']; ?></b></td>
                    <td><?php echo $d['pengarang']; ?></td>
                    <td><?php echo $d['penerbit']; ?></td>
                    <td><?php echo $d['tahun_terbit']; ?></td>
                    <td>
                        <a href="hapus_buku.php?id=<?php echo $d['id_buku']; ?>" class="btn btn-danger" onclick="return confirm('Yakin hapus?')">Hapus</a>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

</body>
</html>