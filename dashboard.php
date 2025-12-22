<?php
session_start();
include 'koneksi.php';

// Cek session login
if (!isset($_SESSION['login'])) header("location:index.php");

// --- LOGIK 1: HITUNG STATISTIK (Widget) ---
$jml_buku    = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM buku"));
$jml_anggota = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM anggota"));
// Menghitung status 'pinjam' dari tabel transaksi
$jml_pinjam  = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM transaksi WHERE status='pinjam'"));

// --- LOGIK 2: PENCARIAN BUKU ---
$keyword = "";
if (isset($_POST['cari'])) {
    $keyword = $_POST['keyword'];
    // Mencari berdasarkan Judul, Pengarang, atau Penerbit
    $query_str = "SELECT * FROM buku WHERE 
                  judul LIKE '%$keyword%' OR 
                  pengarang LIKE '%$keyword%' OR 
                  penerbit LIKE '%$keyword%' 
                  ORDER BY id_buku DESC";
} else {
    $query_str = "SELECT * FROM buku ORDER BY id_buku DESC";
}
$q = mysqli_query($koneksi, $query_str);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Dashboard Admin</title>
    <link rel="stylesheet" href="style.css">
    <style>
        /* CSS KHUSUS DASHBOARD (Bisa dipindah ke style.css nanti) */
        
        /* Grid untuk Kartu Statistik */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: white;
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
            display: flex;
            align-items: center;
            justify-content: space-between;
            transition: transform 0.2s;
        }
        .stat-card:hover { transform: translateY(-5px); }

        .stat-info h3 { 
            font-size: 2.2rem; 
            margin-bottom: 5px; 
            color: var(--primary); 
        }
        .stat-info p { color: var(--text-grey); font-size: 0.95rem; font-weight: 600; }
        .stat-icon { font-size: 3rem; opacity: 0.8; }

        /* Search Bar Style */
        .search-box {
            display: flex;
            gap: 10px;
            max-width: 400px;
        }
        .search-box input { margin-bottom: 0; } /* Reset margin bawaan */
    </style>
</head>
<body>
    <?php include 'sidebar.php'; ?>
    
    <div class="main-content">
        <div class="header-title">
            <h2>Dashboard Utama</h2>
            <p style="color:var(--text-grey)">Ringkasan data perpustakaan hari ini.</p>
        </div>

        <div class="stats-grid">
            <div class="stat-card" style="border-left: 5px solid #3f37c9;">
                <div class="stat-info">
                    <h3><?php echo $jml_buku; ?></h3>
                    <p>Total Buku</p>
                </div>
                <div class="stat-icon">📚</div>
            </div>

            <div class="stat-card" style="border-left: 5px solid #10b981;">
                <div class="stat-info">
                    <h3><?php echo $jml_anggota; ?></h3>
                    <p>Siswa Terdaftar</p>
                </div>
                <div class="stat-icon">👥</div>
            </div>

            <div class="stat-card" style="border-left: 5px solid #f59e0b;">
                <div class="stat-info">
                    <h3><?php echo $jml_pinjam; ?></h3>
                    <p>Sedang Dipinjam</p>
                </div>
                <div class="stat-icon">🔄</div>
            </div>
        </div>

        <div class="card">
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px; flex-wrap:wrap; gap:15px;">
                <h3>📖 Katalog Buku</h3>
                
                <form method="POST" class="search-box">
                    <input type="text" name="keyword" placeholder="Cari judul / pengarang..." value="<?php echo htmlspecialchars($keyword); ?>">
                    <button type="submit" name="cari" class="btn btn-primary">🔍 Cari</button>
                    <?php if($keyword != ""): ?>
                        <a href="dashboard.php" class="btn btn-danger" style="padding:12px;">X</a>
                    <?php endif; ?>
                </form>

                <a href="tambah_buku.php" class="btn btn-primary" style="margin-left:auto;">+ Tambah Buku</a>
            </div>
            
            <table>
                <thead>
                    <tr>
                        <th width="5%">No</th>
                        <th>Judul Buku</th>
                        <th>Kategori</th>
                        <th>Pengarang</th>
                        <th>Rak</th>
                        <th width="150px">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    if(mysqli_num_rows($q) > 0){
                        while($d = mysqli_fetch_array($q)){
                    ?>
                    <tr>
                        <td><?php echo $no++; ?></td>
                        <td>
                            <b style="color:var(--primary);"><?php echo htmlspecialchars($d['judul']); ?></b><br>
                            <small style="color:#888"><?php echo htmlspecialchars($d['penerbit']); ?> (<?php echo $d['tahun_terbit']; ?>)</small>
                        </td>
                        
                        <td><span class="badge bg-soft-blue" style="background:#e0f2fe; color:#0284c7;"><?php echo htmlspecialchars($d['jenis_buku']); ?></span></td>
                        <td><?php echo htmlspecialchars($d['pengarang']); ?></td>
                        <td><span class="badge bg-soft-green"><?php echo htmlspecialchars($d['rak']); ?></span></td>
                        
                        <td>
                            <a href="edit_buku.php?id=<?php echo $d['id_buku']; ?>" class="btn btn-warning" style="padding:5px 8px; font-size:0.8rem;">edit</a>
                            <a href="hapus_buku.php?id=<?php echo $d['id_buku']; ?>" class="btn btn-danger" style="padding:5px 8px; font-size:0.8rem;" onclick="return confirm('Hapus buku ini?')">hapus</a>
                        </td>
                    </tr>
                    <?php 
                        }
                    } else {
                        echo "<tr><td colspan='6' style='text-align:center; padding:20px; color:red;'>Data buku tidak ditemukan.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>