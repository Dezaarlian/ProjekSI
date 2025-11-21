<?php
include 'koneksi.php';
$id = $_GET['id'];
$tgl_kembali = date('Y-m-d');

// 1. Ambil data tanggal pinjam
$q = mysqli_query($koneksi, "SELECT tgl_pinjam FROM transaksi WHERE id_transaksi='$id'");
$d = mysqli_fetch_array($q);
$tgl_pinjam = $d['tgl_pinjam'];

// 2. Hitung Jatuh Tempo (7 hari)
$jatuh_tempo = date('Y-m-d', strtotime($tgl_pinjam . ' + 7 days'));

// 3. Hitung Denda (Rp 1.000 per hari keterlambatan)
$denda = 0;
if ($tgl_kembali > $jatuh_tempo) {
    $tgl1 = new DateTime($jatuh_tempo);
    $tgl2 = new DateTime($tgl_kembali);
    $selisih = $tgl1->diff($tgl2);
    $denda = $selisih->d * 1000;
}

// 4. Update Transaksi
mysqli_query($koneksi, "UPDATE transaksi SET tgl_kembali='$tgl_kembali', denda='$denda', status='kembali' WHERE id_transaksi='$id'");

header("location:transaksi.php");
?>