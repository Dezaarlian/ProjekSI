<?php 
session_start();
include 'koneksi.php';

if (!isset($_SESSION['login'])) header("location:index.php");

// 1. Ambil ID dengan aman
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// 2. Ambil data lama untuk ditampilkan di form
$stmt_get = mysqli_prepare($koneksi, "SELECT * FROM buku WHERE id_buku = ?");
mysqli_stmt_bind_param($stmt_get, "i", $id);
mysqli_stmt_execute($stmt_get);
$result = mysqli_stmt_get_result($stmt_get);
$d = mysqli_fetch_array($result);

if(!$d) { echo "Data tidak ditemukan!"; exit; }

// 3. Proses Update Data (Saat tombol ditekan)
if(isset($_POST['update'])){
    // Siapkan query update dengan placeholder (?)
    $stmt_upd = mysqli_prepare($koneksi, "UPDATE buku SET judul=?, jenis_buku=?, pengarang=?, penerbit=?, tahun_terbit=?, rak=? WHERE id_buku=?");
    
    // Bind parameter (s=string, i=integer)
    mysqli_stmt_bind_param($stmt_upd, "ssssisi", 
        $_POST['judul'], 
        $_POST['jenis_buku'],
        $_POST['pengarang'], 
        $_POST['penerbit'], 
        $_POST['tahun'], 
        $_POST['rak'],
        $id
    );

    if(mysqli_stmt_execute($stmt_upd)){
        echo "<script>alert('Data Berhasil Diupdate!'); window.location='dashboard.php';</script>";
    } else {
        echo "Gagal update: " . mysqli_error($koneksi);
    }
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
            <input type="text" name="judul" value="<?php echo htmlspecialchars($d['judul']); ?>" required>

            <label>Jenis Buku</label>
            <select name="jenis_buku" required>
                <option value="<?php echo $d['jenis_buku']; ?>"><?php echo $d['jenis_buku']; ?> (Saat ini)</option>
                <option value="Pelajaran">Buku Pelajaran</option>
                <option value="Novel">Novel / Fiksi</option>
                <option value="Komik">Komik</option>
                <option value="Jurnal">Jurnal Ilmiah</option>
                <option value="Lainnya">Lainnya</option>
            </select>

            <label>Pengarang</label>
            <input type="text" name="pengarang" value="<?php echo htmlspecialchars($d['pengarang']); ?>" required>

            <label>Penerbit</label>
            <input type="text" name="penerbit" value="<?php echo htmlspecialchars($d['penerbit']); ?>" required>

            <div style="display:flex; gap:10px;">
                <div style="width:50%">
                    <label>Tahun</label>
                    <input type="number" name="tahun" value="<?php echo htmlspecialchars($d['tahun_terbit']); ?>" required>
                </div>
                <div style="width:50%">
                    <label>Rak</label>
                    <input type="text" name="rak" value="<?php echo htmlspecialchars($d['rak']); ?>" required>
                </div>
            </div>

            <button name="update" class="btn btn-warning" style="width:100%; margin-bottom:10px; margin-top:10px;">Update Data</button>
            <a href="dashboard.php" class="btn btn-danger" style="width:100%; text-align:center; display:block;">Batal</a>
        </form>
    </div>

</body>
</html>