<?php
session_start();
include 'koneksi.php';
if (!isset($_SESSION['login'])) header("location:index.php");
?>
<!DOCTYPE html>
<html>
<head><title>Dashboard Buku</title><link rel="stylesheet" href="style.css"></head>
<body>
    <?php include 'sidebar.php'; ?>
    
    <div class="main-content">
        <div class="header-title">
            <h2>Data Buku Perpustakaan</h2>
            <p style="color:var(--text-grey)">Kelola koleksi buku anda di sini.</p>
        </div>

        <div class="card">
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px;">
                <h3>📚 Daftar Buku</h3>
                <a href="tambah_buku.php" class="btn btn-primary">+ Tambah Buku</a>
            </div>
            
            <table>
                <thead>
                    <tr><th>No</th><th>Judul</th><th>Pengarang</th><th>Penerbit</th><th>Rak</th><th>Aksi</th></tr>
                </thead>
                <tbody>
                    <?php
                    $no=1;
                    $q = mysqli_query($koneksi, "SELECT * FROM buku");
                    while($d = mysqli_fetch_array($q)){
                    ?>
                    <tr>
                        <td><?php echo $no++; ?></td>
                        <td style="font-weight:bold"><?php echo $d['judul']; ?></td>
                        <td><?php echo $d['pengarang']; ?></td>
                        <td><?php echo $d['penerbit']; ?></td>
                        <td><span class="badge bg-soft-green"><?php echo $d['rak']; ?></span></td>
                        <td>
                            <a href="hapus_buku.php?id=<?php echo $d['id_buku']; ?>" class="btn btn-danger" style="padding:5px 10px; font-size:0.8rem" onclick="return confirm('Yakin?')">Hapus</a>
                        </td>
                        
                        <td>
                              <a href="edit_buku.php?id=<?php echo $d['id_buku']; ?>" class="btn btn-warning" style="padding:5px 10px; font-size:0.8rem; margin-right:5px;">✏️ Edit</a>
    
                             <a href="hapus_buku.php?id=<?php echo $d['id_buku']; ?>" class="btn btn-danger" style="padding:5px 10px; font-size:0.8rem" onclick="return confirm('Yakin hapus buku ini?')">🗑️ Hapus</a>
</td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>