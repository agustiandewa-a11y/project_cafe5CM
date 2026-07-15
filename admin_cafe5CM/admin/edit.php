<?php
session_start();
include '../../koneksi.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: ../../login.php");
    exit();
}

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit();
}

$admin_id = intval($_GET['id']);

$stmt_get = $koneksi->prepare("SELECT * FROM admin WHERE admin_id = ?");
$stmt_get->bind_param("i", $admin_id);
$stmt_get->execute();
$result_get = $stmt_get->get_result();
$akun = $result_get->fetch_assoc();
$stmt_get->close();

if (!$akun) {
    echo "Data akun tidak ditemukan.";
    exit();
}

$error = '';

if (isset($_POST['submit'])) {

    $username = htmlspecialchars(trim($_POST['username'] ?? ''));
    $password = $_POST['password'] ?? '';

    if ($username === '') {
        $error = "Username wajib diisi.";
    } else {
        $stmt_cek = $koneksi->prepare("SELECT admin_id FROM admin WHERE username = ? AND admin_id != ?");
        $stmt_cek->bind_param("si", $username, $admin_id);
        $stmt_cek->execute();
        $ada = $stmt_cek->get_result()->fetch_assoc();
        $stmt_cek->close();

        if ($ada) {
            header("Location: index.php?pesan=username_ada");
            exit();
        }

        if ($password !== '') {
            $password_hash = md5($password);
            $stmt_update = $koneksi->prepare("UPDATE admin SET username = ?, password = ? WHERE admin_id = ?");
            $stmt_update->bind_param("ssi", $username, $password_hash, $admin_id);
        } else {
            $stmt_update = $koneksi->prepare("UPDATE admin SET username = ? WHERE admin_id = ?");
            $stmt_update->bind_param("si", $username, $admin_id);
        }

        if ($stmt_update->execute()) {
            if ($admin_id == $_SESSION['admin_id']) {
                $_SESSION['username'] = $username;
            }
            header("Location: index.php?pesan=edit_sukses");
            exit();
        } else {
            $error = "Gagal memperbarui data: " . htmlspecialchars($koneksi->error);
        }

        $stmt_update->close();
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Akun Admin - 5Cm Cafe</title>
    <link rel="stylesheet" href="../../css/style.css">
</head>

<body class="dm-layout-body">
    <div class="dm-sidebar-wrapper">
        <div class="dm-logo-text">5CM</div>
        <nav class="dm-navigation">
            <a href="../dashboard.php" class="dm-nav-item">Dashboard</a>
            <a href="index.php" class="dm-nav-item dm-item-active">Kelola Akun Admin</a>
            <a href="../../logout.php" class="dm-nav-item">Logout</a>
        </nav>
    </div>

    <div class="dm-main-container">
        <div class="dm-top-navbar">
            <h1>Edit Akun Admin</h1>
        </div>

        <div class="dm-content-page">
            <div class="dm-card-table">
                <div class="dm-header-action">
                    <h2>Form Edit Akun Admin</h2>
                    <a href="index.php" class="dm-btn-add">← Kembali</a>
                </div>

                <?php if ($error): ?>
                    <p style="color:red;"><?= $error ?></p>
                <?php endif; ?>

                <!-- Form Input Edit hanya memuat Username & Password Baru -->
                <form action="" method="POST">
                    <div class="form-group">
                        <label>Username</label>
                        <input type="text" name="username"
                            value="<?= htmlspecialchars($akun['username'] ?? ''); ?>" required>
                    </div>
                    <div class="form-group">
                        <label>Password Baru</label>
                        <input type="password" name="password" placeholder="Kosongkan jika tidak diubah">
                    </div>

                    <button type="submit" name="submit" class="btn-submit">Simpan Perubahan</button>
                </form>

            </div>
        </div>
    </div>

</body>
</html>