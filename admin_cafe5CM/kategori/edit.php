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

$kategori_id = intval($_GET['id']);

$stmt_get = $koneksi->prepare("SELECT * FROM kategori WHERE kategori_id = ?");
$stmt_get->bind_param("i", $kategori_id);
$stmt_get->execute();
$result_get = $stmt_get->get_result();
$kategori   = $result_get->fetch_assoc();
$stmt_get->close();

if (!$kategori) {
    echo "Data kategori tidak ditemukan.";
    exit();
}

if (isset($_POST['submit'])) {

    $nama_kategori = htmlspecialchars(trim($_POST['nama_kategori']));
    $admin_id      = intval($_SESSION['admin_id']);

    $stmt_update = $koneksi->prepare("UPDATE kategori SET nama_kategori = ?, admin_id = ? WHERE kategori_id = ?");
    $stmt_update->bind_param("sii", $nama_kategori, $admin_id, $kategori_id);

    if ($stmt_update->execute()) {
        header("Location: index.php?pesan=edit_sukses");
        exit();
    } else {
        $error = "Gagal memperbarui data: " . htmlspecialchars($koneksi->error);
    }

    $stmt_update->close();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Kategori - 5Cm Cafe</title>
    <link rel="stylesheet" href="../../css/style.css">
</head>

<body class="dm-layout-body">
    <div class="dm-sidebar-wrapper">
        <div class="dm-logo-text">5CM</div>
        <nav class="dm-navigation">
            <a href="../dashboard.php" class="dm-nav-item">Dashboard</a>
            <a href="index.php" class="dm-nav-item dm-item-active">Kelola Semua Kategori</a>
            <a href="../../logout.php" class="dm-nav-item">Logout</a>
        </nav>
    </div>

    <div class="dm-main-container">
        <div class="dm-top-navbar">
            <h1>Edit Kategori</h1>
        </div>

        <div class="dm-content-page">
            <div class="dm-card-table">
                <div class="dm-header-action">
                    <h2>Form Edit Kategori</h2>
                    <a href="index.php" class="dm-btn-add">← Kembali</a>
                </div>

                <?php if (isset($error)): ?>
                    <p style="color:red;"><?= $error ?></p>
                <?php endif; ?>

                <form action="" method="POST">
                    <div class="form-group">
                        <label>Nama Kategori</label>
                        <input type="text" name="nama_kategori"
                            value="<?= htmlspecialchars($kategori['nama_kategori']); ?>" required>
                    </div>

                    <button type="submit" name="submit" class="btn-submit">Simpan Perubahan</button>
                </form>

            </div>
        </div>
    </div>

</body>
</html>