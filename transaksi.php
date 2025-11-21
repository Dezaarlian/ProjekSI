<?php
session_start();
include 'koneksi.php';
if (!isset($_SESSION['login'])) header("location:index.php");
?>
<!DOCTYPE html>
<html>
<head><title>Transaksi Sirkulasi</title><link rel="stylesheet" href="style.css"></head>
<body>
    <?php include 'sidebar.php'; ?>
    
    <div class="main-content">
        <div class="header-title">
            <h2>Sirkulasi Peminjaman</h2>
            <p style="color:var(--text-grey)">Pantau peminjaman dan denda keterlambatan.</p>
        </div>

        <div class="card">
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px;">
                <h3>🔄 Data Transaksi</h3>
                <a href="tambah_transaksi.php" class="btn btn-primary">+ Transaksi Baru</a>
            </div>

            <table>
                <thead>
                    <tr><th>Peminjam</th><th>Buku</th><th>Tgl Pinjam</th><th>Jatuh Tempo</th><th>Denda</th><th>Status</th><th>Aksi</th></tr>
                </thead>
                <tbody>
                    <?php
                    $q = mysqli_query($koneksi, "SELECT * FROM transaksi JOIN buku ON transaksi.id_buku = buku.id_buku ORDER BY id_transaksi DESC");
                    while($d = mysqli_fetch_array($q)){
                        // Hitung Jatuh Tempo (7 hari dari pinjam)
                        $jatuh_tempo = date('Y-m-d', strtotime($d['tgl_pinjam'] . ' + 7 days'));
                        $sekarang = date('Y-m-d');
                        
                        // Hitung estimasi denda real-time untuk yang belum kembali
                        $denda_est = 0;
                        if($d['status'] == 'pinjam' && $sekarang > $jatuh_tempo){
                            $tgl1 = new DateTime($jatuh_tempo);
                            $tgl2 = new DateTime($sekarang);
                            $denda_est = ($tgl1->diff($tgl2)->d) * 1000;
                        }
                    ?>
                    <tr>
                        <td><?php echo $d['peminjam']; ?></td>
                        <td><?php echo $d['judul']; ?></td>
                        <td><?php echo $d['tgl_pinjam']; ?></td>
                        <td><?php echo $jatuh_tempo; ?></td>
                        <td>
                            <?php 
                            if($d['status'] == 'kembali'){
                                echo "Rp " . number_format($d['denda']);
                            } else {
                                if($denda_est > 0) echo "<span style='color:red; font-weight:bold'>Est: Rp ".number_format($denda_est)."</span>";
                                else echo "-";
                            }
                            ?>
                        </td>
                        <td>
                            <?php if($d['status'] == 'pinjam') { ?>
                                <span class="badge bg-soft-yellow">Sedang Pinjam</span>
                            <?php } else { ?>
                                <span class="badge bg-soft-green">Dikembalikan</span>
                            <?php } ?>
                        </td>
                        <td>
                            <?php if($d['status'] == 'pinjam') { ?>
                                <a href="proses_kembali.php?id=<?php echo $d['id_transaksi']; ?>" class="btn btn-primary" style="padding:5px 10px; font-size:0.8rem">✅ Selesai</a>
                            <?php } else { ?>
                                ✔
                            <?php } ?>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>