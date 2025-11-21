<?php include 'koneksi.php'; 
if(isset($_POST['simpan'])){
    mysqli_query($koneksi, "INSERT INTO buku VALUES('','$_POST[judul]','$_POST[pengarang]','$_POST[penerbit]','$_POST[tahun]','$_POST[rak]')");
    header("location:dashboard.php");
}
?>
<!DOCTYPE html>
<html>
<head><title>Tambah Buku</title><link rel="stylesheet" href="style.css"></head>
<body style="background:var(--bg-light); display:flex; justify-content:center; align-items:center; height:100vh">
    <div class="card" style="width:400px">
        <h3>➕ Tambah Buku</h3><hr style="margin:15px 0; border:0; border-top:1px solid #eee">
        <form method="POST">
            <label>Judul Buku</label><input type="text" name="judul" required>
            <label>Pengarang</label><input type="text" name="pengarang" required>
            <label>Penerbit</label><input type="text" name="penerbit" required>
            <label>Tahun</label><input type="number" name="tahun" required>
            <label>Lokasi Rak</label><input type="text" name="rak" placeholder="Contoh: Rak A1" required>
            <button name="simpan" class="btn btn-primary" style="width:100%">Simpan Data</button>
            <a href="dashboard.php" class="btn btn-danger" style="width:100%; margin-top:10px; text-align:center">Batal</a>
        </form>
    </div>
</body>
</html>