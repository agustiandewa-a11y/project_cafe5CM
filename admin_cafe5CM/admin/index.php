<?php
include '../security.php';
include "../../koneksi.php";

if (!isset($_SESSION['admin_id'])) {
    header("Location: ../../login.php");
    exit();
}

$query = mysqli_query($koneksi, "SELECT * FROM admin ORDER BY admin_id ASC");

$pesan = $_GET['pesan'] ?? '';
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Akun Admin - 5Cm Cafe</title>
    <link rel="stylesheet" href="../../css/style.css">
</head>

<body class="dm-layout-body">
    <div class="dm-sidebar-wrapper">
        <div class="dm-logo-text">5CM</div>
        <nav class="dm-navigation">
            <a href="../dashboard.php" class="dm-nav-item">Dashboard</a>
            <a href="../menu/index.php" class="dm-nav-item">Kelola Menu</a>
            <a href="../kategori/index.php" class="dm-nav-item">Kelola Kategori</a>
            <a href="../Galeri/index.php" class="dm-nav-item">Kelola Galeri</a>
            <a href="../reservasi/index.php" class="dm-nav-item">Kelola Reservasi</a>
            <a href="index.php" class="dm-nav-item dm-item-active">Kelola Akun Admin</a>
        </nav>
    </div>

    <div class="dm-main-container">
        <div class="dm-top-navbar">
            <h1>Kelola Akun Admin</h1>
        </div>

        <div class="dm-content-page">
            <div class="dm-header-action">
                <h2>Data Akun Admin</h2>
                <a href="tambah.php" class="dm-btn-add"><span>➕</span> Tambah Akun</a>
            </div>

            <?php if ($pesan === 'tambah_sukses'): ?>
                <p style="color:green;">Akun admin berhasil ditambahkan.</p>
            <?php elseif ($pesan === 'edit_sukses'): ?>
                <p style="color:green;">Akun admin berhasil diperbarui.</p>
            <?php elseif ($pesan === 'hapus_sukses'): ?>
                <p style="color:green;">Akun admin berhasil dihapus.</p>
            <?php elseif ($pesan === 'gagal_hapus_diri'): ?>
                <p style="color:red;">Tidak bisa menghapus akun yang sedang digunakan.</p>
            <?php elseif ($pesan === 'gagal_hapus_terakhir'): ?>
                <p style="color:red;">Tidak bisa menghapus akun admin terakhir.</p>
            <?php elseif ($pesan === 'username_ada'): ?>
                <p style="color:red;">Username sudah digunakan, silakan pilih yang lain.</p>
            <?php endif; ?>

            <div class="dm-card-table">
                <table class="dm-table-premium">
                    <thead>
                        <tr>
                            <th style="width: 60px;">No</th>
                            <th>Username</th>
                            <th style="text-align: center; width: 180px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        while ($data = mysqli_fetch_assoc($query)) {
                        ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td>
                                <?= htmlspecialchars($data['username']); ?>
                                <?php if ($data['admin_id'] == $_SESSION['admin_id']): ?>
                                    <em>(Anda)</em>
                                <?php endif; ?>
                            </td>
                            <td>
                                <div class="dm-btn-group">
                                    <a href="edit.php?id=<?= $data['admin_id']; ?>" class="dm-action-link dm-lnk-edit">Edit</a>
                                    <a href="hapus.php?id=<?= $data['admin_id']; ?>"
                                    class="dm-action-link dm-lnk-delete"
                                    onclick="return confirm('Yakin hapus akun ini?')">Hapus</a>
                                </div>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</body>
</html>