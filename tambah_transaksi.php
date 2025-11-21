<?php include 'koneksi.php'; 
if(isset($_POST['simpan'])){
    $tgl = date('Y-m-d');
    mysqli_query($koneksi, "INSERT INTO transaksi (id_buku, peminjam, tgl_pinjam, status) VALUES ('$_POST[id_buku]','$_POST[peminjam]','$tgl','pinjam')");
    header("location:transaksi.php");
}
?>
<!DOCTYPE html>
<html>
<head><title>Transaksi Baru</title><link rel="stylesheet" href="style.css"></head>
<body style="background:var(--bg-light); display:flex; justify-content:center; align-items:center; height:100vh">
    <div class="card" style="width:400px">
        <h3>➕ Pinjam Buku</h3><hr style="margin:15px 0; border:0; border-top:1px solid #eee">
        <form method="POST">
            <label>Nama Peminjam</label><input type="text" name="peminjam" required>
            <label>Pilih Buku</label>
            <select name="id_buku">
                <?php
                $b = mysqli_query($koneksi, "SELECT * FROM buku");
                while($row = mysqli_fetch_array($b)){
                    echo "<option value='$row[id_buku]'>$row[judul]</option>";
                }
                ?>
            </select>
            <button name="simpan" class="btn btn-primary" style="width:100%">Proses Pinjam</button>
            <a href="transaksi.php" class="btn btn-danger" style="width:100%; margin-top:10px; text-align:center">Batal</a>
        </form>
    </div>
</body>
</html>