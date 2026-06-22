<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login Admin - 5Cm Cafe</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<div class="login-box">
    <h2>Login Admin</h2>
    <form action="sv_login.php" method="POST">
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