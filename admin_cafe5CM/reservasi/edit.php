<?php

include '../security.php';
include '../../koneksi.php';

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($id <= 0) {
    header("Location: index.php");
    exit();
}

$stmt_get = $koneksi->prepare("SELECT * FROM reservasi WHERE reservasi_id = ?");
$stmt_get->bind_param("i", $id);
$stmt_get->execute();
$result = $stmt_get->get_result();
$data = $result->fetch_assoc();
$stmt_get->close();

if (!$data) {
    die("Error: Data reservasi dengan ID " . htmlspecialchars($id) . " tidak ditemukan di database.");
}

if (isset($_POST['submit'])) {
    // 1. Ambil data mentah tanpa mengubah strukturnya terlebih dahulu
    $nama_customer   = trim($_POST['nama_customer']);
    $no_hp           = trim($_POST['no_hp']);
    
    // 2. PERBAIKAN FATAL: Konversi paksa waktu dari HTML (T) ke format standar MySQL
    $tanggal_mentah  = $_POST['tanggal_reservasi'];
    $tanggal         = date('Y-m-d H:i:s', strtotime($tanggal_mentah));
    
    $jumlah_customer = intval($_POST['jumlah_customer']);
    $status          = $_POST['status'];
    
    // 3. PERBAIKAN LOGIKA CATATAN: Ambil apa adanya. Jika isi '0', paksa kosong
    $catatan         = trim($_POST['catatan'] ?? '');
    if ($catatan === '0') {
        $catatan = '';
    }
    
    $admin_id        = isset($_SESSION['admin_id']) ? intval($_SESSION['admin_id']) : 0;

    $stmt_update = $koneksi->prepare("
        UPDATE reservasi 
        SET nama_customer = ?, no_hp = ?, tanggal_reservasi = ?, 
            jumlah_customer = ?, status = ?, catatan = ?, admin_id = ?
        WHERE reservasi_id = ?
    ");
    
    $stmt_update->bind_param("sssissii",
        $nama_customer, $no_hp, $tanggal,
        $jumlah_customer, $status, $catatan, $admin_id, $id
    );
    
    if ($stmt_update->execute()) {
        $stmt_update->close();
        header("Location: index.php?pesan=update_sukses");
        exit();
    } else {
        $error = "Gagal mengupdate: " . htmlspecialchars($koneksi->error);
        $stmt_update->close();
    }
}

$tanggal_format = date('Y-m-d\TH:i', strtotime($data['tanggal_reservasi']));
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Reservasi - 5CM Cafe</title>
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
            <a href="index.php" class="dm-nav-item dm-item-active">Kelola Reservasi</a>
            <a href="/project_cafe5CM/admin/logout.php" class="dm-nav-item">Logout</a>
        </nav>
    </div>

    <div class="dm-main-container">
        <div class="dm-top-navbar">
            <h1>Edit Reservasi</h1>
        </div>

        <div class="dm-content-page">
            <div class="dm-card-table">
                <div class="dm-header-action">
                    <h2>Form Edit Reservasi</h2>
                    <a href="index.php" class="dm-btn-add">← Kembali</a>
                </div>

                <?php if (isset($error)): ?>
                    <p class="dm-alert dm-alert-error"><?= $error ?></p>
                <?php endif; ?>

                <form action="edit.php?id=<?= $id ?>" method="POST">
                    <div class="form-group">
                        <label>Nama Customer</label>
                        <input type="text" name="nama_customer" value="<?= htmlspecialchars($data['nama_customer']) ?>" required>
                    </div>
                    <div class="form-group">
                        <label>No HP</label>
                        <input type="text" name="no_hp" value="<?= htmlspecialchars($data['no_hp']) ?>" required>
                    </div>
                    <div class="form-group">
                        <label>Tanggal Reservasi</label>
                        <input type="datetime-local" name="tanggal_reservasi" value="<?= $tanggal_format ?>" required>
                    </div>
                    <div class="form-group">
                        <label>Jumlah Customer</label>
                        <input type="number" name="jumlah_customer" value="<?= intval($data['jumlah_customer']) ?>" min="1" required>
                    </div>
                    <div class="form-group">
                        <label>Status</label>
                        <select name="status">
                        <?php foreach (['pending', 'confirmed'] as $s): ?>
                            <option value="<?= $s ?>" <?= $data['status'] === $s ? 'selected' : '' ?>>
                                <?= ucfirst($s) ?>
                            </option>
                        <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Catatan</label>
                        <textarea name="catatan" rows="3"><?= ($data['catatan'] === '0' || $data['catatan'] === null) ? '' : htmlspecialchars($data['catatan']) ?></textarea>
                    </div>
                    <button type="submit" name="submit" class="btn-submit">Simpan Perubahan</button>
                </form>
            </div>
        </div>
    </div>

</body>
</html>