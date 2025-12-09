<?php 
include 'koneksi.php'; 

if(isset($_POST['simpan'])){
    $nis     = $_POST['nis'];
    $nama    = $_POST['nama'];
    $kelas   = $_POST['kelas'];
    $jurusan = $_POST['jurusan'];

    // --- VALIDASI 1: Cek Panjang NIS (Wajib 10 Karakter) ---
    if(strlen($nis) != 10){
        echo "<script>alert('❌ GAGAL! Format NIS harus tepat 10 digit.'); window.location='tambah_anggota.php';</script>";
        exit;
    }

    // --- VALIDASI 2: Cek Apakah NIS Ada di Database (Wajib Ada) ---
    $cek_data = mysqli_query($koneksi, "SELECT nis FROM anggota WHERE nis = '$nis'");
    
    // Jika TIDAK ADA di database -> TOLAK
    if(mysqli_num_rows($cek_data) == 0){
        echo "<script>alert('❌ DITOLAK! NIS $nis tidak ditemukan di database. Pastikan NIS sesuai data siswa yang terdaftar.'); window.location='tambah_anggota.php';</script>";
        exit; 
    }

    // --- JIKA DITEMUKAN: Update Data Siswa Tersebut ---
    // Kita gunakan UPDATE karena datanya sudah ada. Jika INSERT akan error (duplicate).
    $stmt = mysqli_prepare($koneksi, "UPDATE anggota SET nama_siswa=?, kelas=?, jurusan=? WHERE nis=?");
    
    mysqli_stmt_bind_param($stmt, "ssss", 
        $nama, 
        $kelas, 
        $jurusan,
        $nis
    );

    if(mysqli_stmt_execute($stmt)){
        echo "<script>alert('✅ Validasi Sukses! Data Anggota Berhasil Diperbarui.'); window.location='anggota.php';</script>";
    } else {
        echo "Gagal menyimpan: " . mysqli_error($koneksi);
    }
    mysqli_stmt_close($stmt);
}
?>
<!DOCTYPE html>
<html>
<head><title>Verifikasi Anggota</title><link rel="stylesheet" href="style.css"></head>
<body style="background:var(--bg-light); display:flex; justify-content:center; align-items:center; height:100vh">
    <div class="card" style="width:400px">
        <h3>🔍 Verifikasi / Tambah Anggota</h3>
        <p style="font-size:0.8rem; color:#64748b; margin-bottom:15px;">Masukkan NIS dari database untuk verifikasi.</p>
        <hr style="margin:15px 0; border:0; border-top:1px solid #eee">
        
        <form method="POST">
            <label>NIS (Nomor Induk)</label>
            <input type="text" name="nis" required placeholder="Wajib 10 Digit Terdaftar" 
                   minlength="10" maxlength="10" pattern="\d{10}"
                   oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');">
            <small style="color:red; font-size:0.8rem">*Hanya menerima NIS yang sudah ada di DB</small>
            
            <label style="margin-top:10px">Nama Lengkap</label>
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
            
            <button name="simpan" class="btn btn-primary" style="width:100%">Verifikasi & Simpan</button>
            <a href="anggota.php" class="btn btn-danger" style="width:100%; margin-top:10px; text-align:center">Batal</a>
        </form>
    </div>
</body>
</html>