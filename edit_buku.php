<?php 
session_start();
include 'koneksi.php';

// Cek Login
if (!isset($_SESSION['login'])) header("location:index.php");

// Ambil ID dari URL
$id = $_GET['id'];

// Ambil data buku berdasarkan ID
$query = mysqli_query($koneksi, "SELECT * FROM buku WHERE id_buku='$id'");
$d = mysqli_fetch_array($query);

// Proses Update Data
if(isset($_POST['update'])){
    $judul = $_POST['judul'];
    $pengarang = $_POST['pengarang'];
    $penerbit = $_POST['penerbit'];
    $tahun = $_POST['tahun'];
    $rak = $_POST['rak'];

    mysqli_query($koneksi, "UPDATE buku SET judul='$judul', pengarang='$pengarang', penerbit='$penerbit', tahun_terbit='$tahun', rak='$rak' WHERE id_buku='$id'");
    
    echo "<script>alert('Data Berhasil Diupdate!'); window.location='dashboard.php';</script>";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Buku</title>
    <link rel="stylesheet" href="style.css">
</head>
<body style="background:var(--bg-light); display:flex; justify-content:center; align-items:center; height:100vh">

    <div class="card" style="width:400px">
        <div style="text-align:center; margin-bottom:20px;">
            <h3 style="color:var(--bg-dark)">✏️ Edit Buku</h3>
            <p style="font-size:0.9rem; color:var(--text-grey)">Ubah data buku perpustakaan</p>
        </div>
        <hr style="margin:15px 0; border:0; border-top:1px solid #eee">

        <form method="POST">
            <label>Judul Buku</label>
            <input type="text" name="judul" value="<?php echo $d['judul']; ?>" required>

            <label>Pengarang</label>
            <input type="text" name="pengarang" value="<?php echo $d['pengarang']; ?>" required>

            <label>Penerbit</label>
            <input type="text" name="penerbit" value="<?php echo $d['penerbit']; ?>" required>

            <div style="display:flex; gap:10px;">
                <div style="width:50%">
                    <label>Tahun</label>
                    <input type="number" name="tahun" value="<?php echo $d['tahun_terbit']; ?>" required>
                </div>
                <div style="width:50%">
                    <label>Rak</label>
                    <input type="text" name="rak" value="<?php echo $d['rak']; ?>" required>
                </div>
            </div>

            <button name="update" class="btn btn-warning" style="width:100%; margin-bottom:10px;">Update Data</button>
            <a href="dashboard.php" class="btn btn-danger" style="width:100%; text-align:center; display:block;">Batal</a>
        </form>
    </div>

</body>
</html>