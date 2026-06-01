<?php
include 'koneksi.php';
session_start();

if (isset($_POST['submit_login'])) {
    $username = $_POST['username'];
    $password = md5($_POST['password']); 
    $query = mysqli_query($koneksi, "SELECT * FROM admin WHERE username='$username' AND password='$password'");
    $cek = mysqli_num_rows($query);

    if ($cek > 0) {
        $_SESSION['status'] = "login";
        $_SESSION['username'] = $username;
        header("Location: dashboard.php");
        exit();
    } else {
        // Jika tidak cocok
        echo "<script>alert('Username atau Password Salah!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login Admin - 5Cm Cafe</title>
    </head>
<body>

<div class="login-box">
    <h2>Login Admin</h2>
    <form action="login.php" method="POST">
        <div class="input-group">
            <label>Username</label>
            <input type="text" name="username" required>
        </div>
        <div class="input-group">
            <label>Password</label>
            <input type="password" name="password" required>
        </div>
        <button type="submit" name="submit_login" class="btn-login">Masuk</button>
    </form>
</div>

</body>
</html>