<?php
include '../security.php';
include '../../koneksi.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: ../../login.php");
    exit();
}

$query = mysqli_query($koneksi, "
    SELECT g.*, a.username AS nama_admin
    FROM galeri g
    LEFT JOIN admin a ON g.admin_id = a.admin_id
    ORDER BY g.gambar_id DESC
");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Galeri - 5CM Cafe</title>
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
        </nav>
    </div>

    <div class="dm-main-container">
        <div class="dm-top-navbar">
            <h1>Kelola Galeri</h1>
        </div>

        <div class="dm-content-page">
            <div class="dm-header-action">
                <h2>Data Galeri</h2>
                <a href="tambah.php" class="dm-btn-add"><span>➕</span> Tambah Gambar</a>
            </div>

            <?php if (isset($_GET['pesan'])): ?>
                <?php if ($_GET['pesan'] === 'tambah_sukses'): ?>
                    <p style="color:green;margin-bottom:16px;">Gambar berhasil ditambahkan.</p>
                <?php elseif ($_GET['pesan'] === 'hapus_sukses'): ?>
                    <p style="color:green;margin-bottom:16px;">Gambar berhasil dihapus.</p>
                <?php endif; ?>
            <?php endif; ?>

            <div class="dm-card-table">
                <table class="dm-table-premium">
                    <thead>
                        <tr>
                            <th style="width:60px">No</th>
                            <th>Gambar</th>
                            <th>Nama File</th>
                            <th>Diupload Oleh</th>
                            <th style="text-align:center;width:120px">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    $no = 1;
                    while ($data = mysqli_fetch_assoc($query)):
                    ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td>
                                <img src="../../Aset/<?= htmlspecialchars($data['nama_gambar']) ?>"
                                     class="dm-img-thumb" alt="Galeri">
                            </td>
                            <td>
                                <span class="dm-txt-name"><?= htmlspecialchars($data['nama_gambar']) ?></span>
                            </td>
                            <td>
                                <span class="dm-txt-admin"><?= htmlspecialchars($data['nama_admin'] ?? '-') ?></span>
                            </td>
                            <td style="text-align:center">
                                <div class="dm-btn-group">
                                    <a href="hapus.php?id=<?= $data['gambar_id'] ?>"
                                       class="dm-action-link dm-lnk-delete"
                                       onclick="return confirm('Yakin hapus gambar ini?')">Hapus</a>
                                </div>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</body>
</html>