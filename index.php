<?php
session_start();
include 'koneksi.php';

if (isset($_POST['login'])) {
    $u = $_POST['user'];
    $p = md5($_POST['pass']);
    
    $cek = mysqli_query($koneksi, "SELECT * FROM admin WHERE username='$u' AND password='$p'");

    if (mysqli_num_rows($cek) > 0) {
        $_SESSION['login'] = true;
        header("location:dashboard.php");
        exit;
    } else {
        // Tambahkan pesan error jika password salah
        $msg = "Username atau Password salah!";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login PerpusPro</title>
    <link rel="stylesheet" href="style.css">
    <style>
        /* Style Tambahan Khusus Toggle Password */
        .pass-box {
            position: relative; 
            width: 100%; 
            margin-bottom: 15px; /* Jarak ke tombol bawah */
        }
        
        .pass-box input {
            width: 100%;
            margin-bottom: 0; /* Margin dihandle oleh .pass-box */
            padding-right: 40px; /* Ruang untuk ikon mata */
        }

        .toggle-icon {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            font-size: 1.2rem;
            user-select: none; /* Agar ikon tidak terblok saat diklik */
        }
    </style>
</head>
<body class="login-body">
    <div class="login-card">
        <h2>Selamat Datang, Min!</h2>
        <p>Silakan masuk untuk mengelola perpustakaan.</p>
        
        <form method="POST">
            <input type="text" name="user" placeholder="Username" required>
            
            <div class="pass-box">
                <input type="password" name="pass" id="passInput" placeholder="Password" required>
                <span class="toggle-icon" onclick="togglePassword()" id="eyeIcon">👁️</span>
            </div>
            
            <button type="submit" name="login" class="btn btn-primary" style="width:100%">MASUK</button>
        </form>
        
        <?php if(isset($msg)) echo "<p style='color:red; margin-top:10px; font-weight:bold;'>$msg</p>"; ?>
    </div>

    <script>
        function togglePassword() {
            var input = document.getElementById("passInput");
            var icon = document.getElementById("eyeIcon");

            if (input.type === "password") {
                input.type = "text";
                icon.innerHTML = "🚫"; // Ubah jadi ikon 'Sembunyikan'
            } else {
                input.type = "password";
                icon.innerHTML = "👁️"; // Ubah balik jadi ikon 'Lihat'
            }
        }
    </script>
</body>
</html>