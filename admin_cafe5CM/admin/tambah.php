<?php
session_start();
include '../../koneksi.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: ../../login.php");
    exit();
}

$error = '';

if (isset($_POST['submit'])) {


    $username = htmlspecialchars(trim($_POST['username'] ?? ''));
    $password = $_POST['password'] ?? '';


    if ($username === '' || $password === '') {
        $error = "Username dan password wajib diisi.";
    } else {

        $stmt_cek = $koneksi->prepare("SELECT admin_id FROM admin WHERE username = ?");
        $stmt_cek->bind_param("s", $username);
        $stmt_cek->execute();
        $ada = $stmt_cek->get_result()->fetch_assoc();
        $stmt_cek->close();

        if ($ada) {
            header("Location: index.php?pesan=username_ada");
            exit();
        }

        $password_hash = md5($password);
        $stmt = $koneksi->prepare("INSERT INTO admin (username, password) VALUES (?, ?)");
        $stmt->bind_param("ss", $username, $password_hash);

        if ($stmt->execute()) {
            header("Location: index.php?pesan=tambah_sukses");
            exit();
        } else {
            $error = "Gagal menyimpan data: " . htmlspecialchars($koneksi->error);
        }

        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Akun Admin - 5Cm Cafe</title>
    <link rel="stylesheet" href="../../css/style.css">
</head>

<body class="dm-layout-body">
    <div class="dm-sidebar-wrapper">
        <div class="dm-logo-text">5CM</div>
        <nav class="dm-navigation">
            <a href="../dashboard.php" class="dm-nav-item">Dashboard</a>
            <a href="../menu/index.php" class="dm-nav-item">Kelola Menu</a>
            <a href="../kategori/index.php" class="dm-nav-item">Kelola Kategori</a>
            <a href="../galeri/index.php" class="dm-nav-item">Kelola Galeri</a>
            <a href="../reservasi/index.php" class="dm-nav-item">Kelola Reservasi</a>
            <a href="index.php" class="dm-nav-item dm-item-active">Kelola Akun Admin</a>
            <a href="../../logout.php" class="dm-nav-item">Logout</a>
        </nav>
    </div>

    <div class="dm-main-container">
        <div class="dm-top-navbar">
            <h1>Tambah Akun Admin</h1>
        </div>

        <div class="dm-content-page">
            <div class="dm-card-table">
                <div class="dm-header-action">
                    <h2>Form Tambah Akun Admin</h2>
                    <a href="index.php" class="dm-btn-add">← Kembali</a>
                </div>

                <?php if ($error): ?>
                    <p style="color:red;"><?= $error ?></p>
                <?php endif; ?>

                <form action="" method="POST">
                    <div class="form-group">
                        <label>Username</label>
                        <input type="text" name="username" required>
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" name="password" required>
                    </div>

                    <button type="submit" name="submit" class="btn-submit">Simpan Akun</button>
                </form>
            </div>
        </div>
    </div>

</body>
</html>