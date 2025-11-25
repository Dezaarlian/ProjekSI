<?php include 'koneksi.php'; 
if(isset($_POST['simpan'])){
    // Menggunakan query spesifik kolom agar urutan aman
    $judul    = $_POST['judul'];
    $jenis    = $_POST['jenis_buku']; // Tangkap data jenis buku
    $pengarang= $_POST['pengarang'];
    $penerbit = $_POST['penerbit'];
    $tahun    = $_POST['tahun'];
    $rak      = $_POST['rak'];

    $query = "INSERT INTO buku (judul, jenis_buku, pengarang, penerbit, tahun_terbit, rak) 
              VALUES ('$judul', '$jenis', '$pengarang', '$penerbit', '$tahun', '$rak')";
    
    if(mysqli_query($koneksi, $query)){
        header("location:dashboard.php");
    } else {
        echo "Error: " . mysqli_error($koneksi);
    }
}
?>
<!DOCTYPE html>
<html>
<head><title>Tambah Buku</title><link rel="stylesheet" href="style.css"></head>
<body style="background:var(--bg-light); display:flex; justify-content:center; align-items:center; height:100vh">
    <div class="card" style="width:400px">
        <h3>➕ Tambah Buku</h3><hr style="margin:15px 0; border:0; border-top:1px solid #eee">
        <form method="POST">
            <label>Judul Buku</label>
            <input type="text" name="judul" required>
            
            <label>Jenis Buku</label>
            <select name="jenis_buku" required>
                <option value="">-- Pilih Jenis --</option>
                <option value="Pelajaran">Buku Pelajaran</option>
                <option value="Novel">Novel / Fiksi</option>
                <option value="Komik">Komik</option>
                <option value="Jurnal">Jurnal Ilmiah</option>
                <option value="Lainnya">Lainnya</option>
            </select>

            <label>Pengarang</label>
            <input type="text" name="pengarang" required>
            
            <label>Penerbit</label>
            <input type="text" name="penerbit" required>
            
            <label>Tahun Terbit</label>
            <input type="number" name="tahun" required>
            
            <label>Lokasi Rak</label>
            <input type="text" name="rak" placeholder="Contoh: Rak A1" required>
            
            <button name="simpan" class="btn btn-primary" style="width:100%">Simpan Data</button>
            <a href="dashboard.php" class="btn btn-danger" style="width:100%; margin-top:10px; text-align:center">Batal</a>
        </form>
    </div>
</body>
</html>