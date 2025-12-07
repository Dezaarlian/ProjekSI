<?php
session_start();
include 'koneksi.php';

// Cek session login
if (!isset($_SESSION['login'])) header("location:index.php");
?>
<!DOCTYPE html>
<html>
<head><title>Dashboard Buku</title>
<link rel="stylesheet" href="style.css">
</head>
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
                    <tr>
                        <th width="5%">No</th>
                        <th>Judul</th>
                        <th>Jenis</th> <th>Pengarang</th>
                        <th>Penerbit</th>
                        <th>Tahun</th> <th>Rak</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no=1;
                    $q = mysqli_query($koneksi, "SELECT * FROM buku ORDER BY id_buku DESC");
                    while($d = mysqli_fetch_array($q)){
                    ?>
                    <tr>
                        <td><?php echo $no++; ?></td>
                        <td style="font-weight:bold"><?php echo htmlspecialchars($d['judul']); ?></td>
                        
                        <td>
                            <span class="badge bg-soft-blue" style="background:#e0f2fe; color:#0284c7;">
                                <?php echo htmlspecialchars($d['jenis_buku']); ?>
                            </span>
                        </td>
                        
                        <td><?php echo htmlspecialchars($d['pengarang']); ?></td>
                        <td><?php echo htmlspecialchars($d['penerbit']); ?></td>
                        
                        <td><?php echo htmlspecialchars($d['tahun_terbit']); ?></td>
                        
                        <td><span class="badge bg-soft-green"><?php echo htmlspecialchars($d['rak']); ?></span></td>
                        
                        <td>
                            <a href="edit_buku.php?id=<?php echo $d['id_buku']; ?>" class="btn btn-warning" style="padding:5px 10px; font-size:0.8rem; margin-right:5px;">Edit</a>
                            <a href="hapus_buku.php?id=<?php echo $d['id_buku']; ?>" class="btn btn-danger" style="padding:5px 10px; font-size:0.8rem" onclick="return confirm('Yakin hapus buku ini?')">Hapus</a>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>