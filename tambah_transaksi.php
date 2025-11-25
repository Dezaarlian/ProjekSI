<?php 
include 'koneksi.php'; 

if(isset($_POST['simpan'])){
    $tgl = date('Y-m-d');
    $status = 'pinjam';

    // Menggunakan Prepared Statement (Anti SQL Injection)
    $stmt = mysqli_prepare($koneksi, "INSERT INTO transaksi (id_buku, id_anggota, tgl_pinjam, status) VALUES (?, ?, ?, ?)");
    
    mysqli_stmt_bind_param($stmt, "iiss", 
        $_POST['id_buku'], 
        $_POST['id_anggota'], 
        $tgl, 
        $status
    );

    if(mysqli_stmt_execute($stmt)){
        header("location:transaksi.php");
    } else {
        echo "Gagal menyimpan: " . mysqli_error($koneksi);
    }
    mysqli_stmt_close($stmt);
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Transaksi Baru</title>
    <link rel="stylesheet" href="style.css">
    
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    
    <style>
        /* Mengatur agar kotak input Select2 tingginya pas dan responsif */
        .select2-container .select2-selection--single {
            height: 45px !important;
            padding: 8px;
            border: 1px solid #cbd5e1;
            border-radius: 8px;
        }
        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 40px !important;
        }
    </style>
</head>
<body style="background:var(--bg-light); display:flex; justify-content:center; align-items:center; height:100vh">
    <div class="card" style="width:400px">
        <h3>➕ Pinjam Buku</h3>
        <hr style="margin:15px 0; border:0; border-top:1px solid #eee">
        
        <form method="POST">
            
            <label>Nama Siswa / Peminjam</label>
            <select name="id_anggota" class="select2-data" style="width:100%" required>
                <option value="">-- Cari Nama Siswa --</option>
                <?php
                $a = mysqli_query($koneksi, "SELECT * FROM anggota ORDER BY nama_siswa ASC");
                while($row = mysqli_fetch_array($a)){
                    echo "<option value='".htmlspecialchars($row['id_anggota'])."'>".htmlspecialchars($row['nis'])." - ".htmlspecialchars($row['nama_siswa'])."</option>";
                }
                ?>
            </select>
            <div style="margin-bottom:15px;"></div>

            <label>Pilih Buku</label>
            <select name="id_buku" class="select2-data" style="width:100%" required>
                <option value="">-- Cari Judul Buku --</option>
                <?php
                $b = mysqli_query($koneksi, "SELECT * FROM buku ORDER BY judul ASC");
                while($row = mysqli_fetch_array($b)){
                    echo "<option value='".htmlspecialchars($row['id_buku'])."'>".htmlspecialchars($row['judul'])."</option>";
                }
                ?>
            </select>
            <div style="margin-bottom:20px;"></div>

            <button name="simpan" class="btn btn-primary" style="width:100%">Proses Pinjam</button>
            <a href="transaksi.php" class="btn btn-danger" style="width:100%; margin-top:10px; text-align:center">Batal</a>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        $(document).ready(function() {
            // Terapkan Select2 pada elemen dengan class .select2-data
            $('.select2-data').select2({
                placeholder: "Silakan ketik untuk mencari...",
                allowClear: true
            });
        });
    </script>

</body>
</html>