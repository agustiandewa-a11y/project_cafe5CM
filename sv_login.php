<?php

include "koneksi.php"; 
session_start();

if(isset($_POST['submit_login'])) {

    $username = $_POST['username'];
    $password = md5($_POST['password']);

    $sql = "SELECT * FROM admin WHERE username = ? AND password = ?";
    $stmt = mysqli_prepare($koneksi, $sql);
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "ss", $username, $password);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $cek = mysqli_num_rows($result);

        if ($cek > 0) {
            
            $data_admin = mysqli_fetch_assoc($result);

            $_SESSION['status'] = "login";
            $_SESSION['username'] = $username;
            
            
            $_SESSION['admin_id'] = $data_admin['admin_id']; 

            mysqli_stmt_close($stmt);

            header("Location: admin_cafe5CM/dashboard.php");
            exit;
        } else {
            mysqli_stmt_close($stmt);
            header("Location: login.php?pesan=gagal");
            exit;
        }
    } else {
        header("Location: login.php");
    }
}
?>