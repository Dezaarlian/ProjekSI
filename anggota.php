<?php
session_start();
include 'koneksi.php';
if (!isset($_SESSION['login'])) header("location:index.php");
?>
<!DOCTYPE html>
<html>
<head><title>Data Anggota</title><link rel="stylesheet" href="style.css"></head>
<body>
    <?php include 'sidebar.php'; ?>
    
    <div class="main-content">
        <div class="header-title">
            <h2>Data Anggota Siswa</h2>
            <p style="color:var(--text-grey)">Kelola data siswa peminjam buku.</p>
        </div>

        <div class="card">
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px;">
                <h3>👥 Daftar Siswa</h3>
                <a href="tambah_anggota.php" class="btn btn-primary">+ Tambah Anggota</a>
            </div>
            
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>NIS</th>
                        <th>Nama Siswa</th>
                        <th>Kelas</th>
                        <th>Jurusan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no=1;
                    $q = mysqli_query($koneksi, "SELECT * FROM anggota ORDER BY id_anggota DESC");
                    while($d = mysqli_fetch_array($q)){
                    ?>
                    <tr>
                        <td><?php echo $no++; ?></td>
                        <td><span class="badge bg-soft-yellow"><?php echo htmlspecialchars($d['nis']); ?></span></td>
                        <td style="font-weight:bold"><?php echo htmlspecialchars($d['nama_siswa']); ?></td>
                        <td><?php echo htmlspecialchars($d['kelas']); ?></td>
                        <td><?php echo htmlspecialchars($d['jurusan']); ?></td>
                        <td>
                            <a href="edit_anggota.php?id=<?php echo $d['id_anggota']; ?>" class="btn btn-warning" style="padding:5px 10px; font-size:0.8rem">✏️ Edit</a>
                            <a href="hapus_anggota.php?id=<?php echo $d['id_anggota']; ?>" class="btn btn-danger" style="padding:5px 10px; font-size:0.8rem" onclick="return confirm('Yakin hapus siswa ini? Data peminjaman terkait mungkin akan ikut terhapus/error.')">🗑️ Hapus</a>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>