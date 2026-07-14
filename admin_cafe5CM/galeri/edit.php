<?php
include '../security.php';
include '../../koneksi.php';

$id = intval($_GET['id'] ?? 0);
if (!$id) { header("Location: index.php"); exit(); }

$stmt_get = $koneksi->prepare("SELECT * FROM galeri WHERE gambar_id = ?");
$stmt_get->bind_param("i", $id);
$stmt_get->execute();
$data = $stmt_get->get_result()->fetch_assoc();
$stmt_get->close();

if (!$data) { header("Location: index.php"); exit(); }

if (isset($_POST['submit'])) {
    $admin_id = intval($_SESSION['admin_id']);

    if (!empty($_FILES['gambar']['name'])) {
        $nama_baru = $_FILES['gambar']['name'];
        $tmp_name  = $_FILES['gambar']['tmp_name'];
        $ext       = strtolower(pathinfo($nama_baru, PATHINFO_EXTENSION));
        $allowed   = ['jpg', 'jpeg', 'png', 'webp'];

        if (!in_array($ext, $allowed)) {
            $error = "Format file tidak didukung. Gunakan JPG, PNG, atau WEBP.";
        } elseif (move_uploaded_file($tmp_name, "../../Aset/" . $nama_baru)) {

            $file_lama = "../../Aset/" . $data['nama_gambar'];
            if (file_exists($file_lama) && !empty($data['nama_gambar'])) {
                unlink($file_lama);
            }
            $stmt = $koneksi->prepare("UPDATE galeri SET nama_gambar=?, admin_id=? WHERE gambar_id=?");
            $stmt->bind_param("sii", $nama_baru, $admin_id, $id);
            if ($stmt->execute()) {
                header("Location: index.php?pesan=edit_sukses");
                exit();
            } else {
                $error = "Gagal update database: " . htmlspecialchars($koneksi->error);
            }
            $stmt->close();
        } else {
            $error = "Gagal upload file baru.";
        }
    } else {
        $error = "Pilih file gambar baru terlebih dahulu.";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Galeri - 5CM Cafe</title>
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
            <a href="/project_cafe5CM/admin/logout.php" class="dm-nav-item">Logout</a>
        </nav>
    </div>

    <div class="dm-main-container">
        <div class="dm-top-navbar">
            <h1>Edit Galeri</h1>
        </div>

        <div class="dm-content-page">
            <div class="dm-card-table">
                <div class="dm-header-action">
                    <h2>Ganti Gambar</h2>
                    <a href="index.php" class="dm-btn-add">← Kembali</a>
                </div>

                <?php if (isset($error)): ?>
                    <p class="dm-alert dm-alert-error"><?= $error ?></p>
                <?php endif; ?>

                <!-- Gambar saat ini -->
                <div class="form-group">
                    <label>Gambar Saat Ini</label><br>
                    <img src="../../Aset/<?= htmlspecialchars($data['nama_gambar']) ?>"
                         class="dm-img-thumb"
                         style="width:150px;height:150px;object-fit:cover;border-radius:10px;margin-top:8px;"
                         alt="Gambar">
                    <p style="margin-top:8px;color:#6b7280;font-size:13px;">
                        <?= htmlspecialchars($data['nama_gambar']) ?>
                    </p>
                </div>

                <form action="" method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <label>Upload Gambar Baru (JPG, PNG, WEBP)</label>
                        <input type="file" name="gambar" accept="image/*" required>
                    </div>
                    <button type="submit" name="submit" class="btn-submit">Simpan Perubahan</button>
                </form>
            </div>
        </div>
    </div>

</body>
</html>