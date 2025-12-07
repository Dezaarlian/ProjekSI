<?php 
session_start();
include 'koneksi.php';

// Cek apakah user sudah login
if (!isset($_SESSION['login'])) header("location:index.php");

// 1. Ambil ID dari URL dengan aman
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// 2. Ambil data siswa lama untuk ditampilkan di form
$stmt_get = mysqli_prepare($koneksi, "SELECT * FROM anggota WHERE id_anggota = ?");
mysqli_stmt_bind_param($stmt_get, "i", $id);
mysqli_stmt_execute($stmt_get);
$result = mysqli_stmt_get_result($stmt_get);
$d = mysqli_fetch_array($result);

// Jika data tidak ditemukan (misal ID salah), kembalikan ke halaman anggota
if(!$d) { 
    echo "<script>alert('Data siswa tidak ditemukan!'); window.location='anggota.php';</script>"; 
    exit; 
}

// 3. Proses Update Data (Saat tombol ditekan)
if(isset($_POST['update'])){
    // Siapkan query update menggunakan Prepared Statement
    $stmt_upd = mysqli_prepare($koneksi, "UPDATE anggota SET nis=?, nama_siswa=?, kelas=?, jurusan=? WHERE id_anggota=?");
    
    // Bind parameter (s=string, i=integer)
    mysqli_stmt_bind_param($stmt_upd, "ssssi", 
        $_POST['nis'], 
        $_POST['nama'],
        $_POST['kelas'], 
        $_POST['jurusan'],
        $id
    );

    if(mysqli_stmt_execute($stmt_upd)){
        echo "<script>alert('Data Anggota Berhasil Diupdate!'); window.location='anggota.php';</script>";
    } else {
        echo "Gagal update: " . mysqli_error($koneksi);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Anggota</title>
    <link rel="stylesheet" href="style.css">
</head>
<body style="background:var(--bg-light); display:flex; justify-content:center; align-items:center; height:100vh">

    <div class="card" style="width:400px">
        <div style="text-align:center; margin-bottom:20px;">
            <h3 style="color:var(--bg-dark)">Edit Siswa</h3>
            <p style="font-size:0.9rem; color:var(--text-grey)">Ubah data anggota perpustakaan</p>
        </div>
        <hr style="margin:15px 0; border:0; border-top:1px solid #eee">

        <form method="POST">
            <label>NIS (Nomor Induk)</label>
            <input type="number" name="nis" value="<?php echo htmlspecialchars($d['nis']); ?>" required>
            
            <label>Nama Lengkap</label>
            <input type="text" name="nama" value="<?php echo htmlspecialchars($d['nama_siswa']); ?>" required>
            
            <label>Kelas</label>
            <select name="kelas" required>
                <option value="<?php echo $d['kelas']; ?>"><?php echo $d['kelas']; ?> (Saat ini)</option>
                <option value="X">Kelas X</option>
                <option value="XI">Kelas XI</option>
                <option value="XII">Kelas XII</option>
            </select>
            
            <label>Jurusan</label>
            <input type="text" name="jurusan" value="<?php echo htmlspecialchars($d['jurusan']); ?>" required>
            
            <button name="update" class="btn btn-warning" style="width:100%; margin-bottom:10px; margin-top:10px;">Update Data</button>
            <a href="anggota.php" class="btn btn-danger" style="width:100%; text-align:center; display:block;">Batal</a>
        </form>
    </div>

</body>
</html>