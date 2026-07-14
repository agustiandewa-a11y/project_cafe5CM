<?php
session_start();
include '../../koneksi.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: ../../login.php");
    exit();
}


if (isset($_POST['submit'])) {
    $admin_id    = intval($_SESSION['admin_id']);
    $nama_gambar = $_FILES['gambar']['name'];
    $tmp_name    = $_FILES['gambar']['tmp_name'];
    $target_dir  = "../../Aset/" . $nama_gambar;

    
    $allowed = ['jpg', 'jpeg', 'png', 'webp'];
    $ext     = strtolower(pathinfo($nama_gambar, PATHINFO_EXTENSION));

    if (!in_array($ext, $allowed)) {
        $error = "Format file tidak didukung. Gunakan JPG, PNG, atau WEBP.";
    } elseif (move_uploaded_file($tmp_name, $target_dir)) {
        $stmt = $koneksi->prepare("INSERT INTO galeri (admin_id, nama_gambar) VALUES (?, ?)");
        $stmt->bind_param("is", $admin_id, $nama_gambar);

        if ($stmt->execute()) {
            header("Location: index.php?pesan=tambah_sukses");
            exit();
        } else {
            $error = "Gagal menyimpan ke database: " . htmlspecialchars($koneksi->error);
        }
        $stmt->close();
    } else {
        $error = "Gagal mengupload gambar. Periksa hak akses folder Aset.";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Gambar - 5CM Cafe</title>
    <link rel="stylesheet" href="../../css/style.css">
</head>
<body class="dm-layout-body">

    <div class="dm-sidebar-wrapper">
        <div class="dm-logo-text">5CM</div>
        <nav class="dm-navigation">
            <a href="../dashboard.php" class="dm-nav-item">Dashboard</a>
            <a href="../menu/index.php" class="dm-nav-item">Kelola Menu</a>
            <a href="../kategori/index.php" class="dm-nav-item">Kelola Kategori</a>
            <a href="index.php" class="dm-nav-item dm-item-active">Kelola Galeri</a>
            <a href="../reservasi/index.php" class="dm-nav-item">Kelola Reservasi</a>
            <a href="../../logout.php" class="dm-nav-item">Logout</a>
        </nav>
    </div>

    <div class="dm-main-container">
        <div class="dm-top-navbar">
            <h1>Tambah Gambar</h1>
        </div>

        <div class="dm-content-page">
            <div class="dm-card-table">
                <div class="dm-header-action">
                    <h2>Form Upload Gambar</h2>
                    <a href="index.php" class="dm-btn-add">← Kembali</a>
                </div>

                <?php if (isset($error)): ?>
                    <p style="color:red;margin-bottom:16px;"><?= $error ?></p>
                <?php endif; ?>

                <form action="" method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <label>Pilih Gambar (JPG, PNG, WEBP)</label>
                        <input type="file" name="gambar" accept="image/*" required>
                    </div>
                    <button type="submit" name="submit" class="btn-submit">Upload Gambar</button>
                </form>
            </div>
        </div>
    </div>

</body>
</html>