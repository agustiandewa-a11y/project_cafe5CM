<?php
// Langsung panggil karena satu folder di root
include "koneksi.php"; 
session_start();

if (isset($_POST['submit_login'])) {
    
    $username = $_POST['username'];
    $password = md5($_POST['password']); 
    
    $query = mysqli_query($koneksi, "SELECT * FROM admin WHERE username='$username' AND password='$password'");
    $cek = mysqli_num_rows($query);

    if ($cek > 0) {
        $_SESSION['status'] = "login";
        $_SESSION['username'] = $username;
        
        // Masuk ke dalam folder admin
        header("Location: admin/dashboard.php");
        exit;
    } else {
        // Tetap di root
        header("Location: login.php?pesan=gagal");
        exit;
    }
} else {
    header("Location: login.php");
    exit;
}
?>