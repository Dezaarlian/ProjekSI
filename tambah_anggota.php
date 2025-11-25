<?php 
include 'koneksi.php'; 

if(isset($_POST['simpan'])){
    // Menggunakan Prepared Statement (Aman dari SQL Injection)
    $stmt = mysqli_prepare($koneksi, "INSERT INTO anggota (nis, nama_siswa, kelas, jurusan) VALUES (?, ?, ?, ?)");
    
    mysqli_stmt_bind_param($stmt, "ssss", 
        $_POST['nis'], 
        $_POST['nama'], 
        $_POST['kelas'], 
        $_POST['jurusan']
    );

    if(mysqli_stmt_execute($stmt)){
        header("location:anggota.php");
    } else {
        echo "Gagal menyimpan: " . mysqli_error($koneksi);
    }
    mysqli_stmt_close($stmt);
}
?>
<!DOCTYPE html>
<html>
<head><title>Tambah Anggota</title><link rel="stylesheet" href="style.css"></head>
<body style="background:var(--bg-light); display:flex; justify-content:center; align-items:center; height:100vh">
    <div class="card" style="width:400px">
        <h3>➕ Tambah Siswa</h3><hr style="margin:15px 0; border:0; border-top:1px solid #eee">
        <form method="POST">
            <label>NIS (Nomor Induk)</label>
            <input type="number" name="nis" required placeholder="Contoh: 10523">
            
            <label>Nama Lengkap</label>
            <input type="text" name="nama" required placeholder="Nama Siswa">
            
            <label>Kelas</label>
            <select name="kelas" required>
                <option value="">-- Pilih Kelas --</option>
                <option value="X">Kelas X</option>
                <option value="XI">Kelas XI</option>
                <option value="XII">Kelas XII</option>
            </select>
            
            <label>Jurusan</label>
            <input type="text" name="jurusan" required placeholder="Contoh: RPL, TKJ, Multimedia">
            
            <button name="simpan" class="btn btn-primary" style="width:100%">Simpan Data</button>
            <a href="anggota.php" class="btn btn-danger" style="width:100%; margin-top:10px; text-align:center">Batal</a>
        </form>
    </div>
</body>
</html>