<?php
session_start();
include 'koneksi.php';
if (isset($_POST['login'])) {
    $u = $_POST['user'];
    $p = md5($_POST['pass']);
    $cek = mysqli_query($koneksi, "SELECT * FROM admin WHERE username='$u' AND password='$p'");
   // Di dalam index.php, ubah bagian ini:

if (mysqli_num_rows($cek) > 0) {
    $_SESSION['login'] = true;
    header("location:dashboard.php");
}
}
?>
<!DOCTYPE html>
<html>
<head><title>Login PerpusPro</title><link rel="stylesheet" href="style.css"></head>
<body class="login-body">
    <div class="login-card">
        <h2>👋 Welcome Back</h2>
        <p>Silakan masuk untuk mengelola perpustakaan.</p>
        <form method="POST">
            <input type="text" name="user" placeholder="Username" required>
            <input type="password" name="pass" placeholder="Password" required>
            <button type="submit" name="login" class="btn btn-primary" style="width:100%">MASUK DASHBOARD</button>
        </form>
        <?php if(isset($msg)) echo "<p style='color:red; margin-top:10px'>$msg</p>"; ?>
    </div>
</body>
</html>