<?php
session_start(); 
include "../../koneksi.php";


if (!isset($_SESSION['admin_id'])) {
    header("Location: ../../login.php");
    exit();
}

$query = mysqli_query($koneksi, "
    SELECT menu.*, kategori.nama_kategori, admin.username AS nama_admin 
    FROM menu 
    LEFT JOIN kategori ON menu.kategori_id = kategori.kategori_id
    LEFT JOIN admin ON menu.admin_id = admin.admin_id
");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Menu - 5Cm Cafe</title>
    <link rel="stylesheet" href="../../css/style.css">
</head>

<body class="dm-layout-body">
    <div class="dm-sidebar-wrapper">
        <div class="dm-logo-text">5CM</div>
        <nav class="dm-navigation">
            <a href="../dashboard.php" class="dm-nav-item">Dashboard</a>
            <a href="index.php" class="dm-nav-item dm-item-active">Kelola Semua Menu</a>
            <a href="../../logout.php" class="dm-nav-item">Logout</a>
        </nav>
    </div>

    <div class="dm-main-container">
        <div class="dm-top-navbar">
            <h1>Kelola Data Menu</h1>
        </div>
        
        <div class="dm-content-page">
            <div class="dm-header-action">
                <h2>Data Menu</h2>
                <a href="tambah.php" class="dm-btn-add"><span>➕</span> Tambah Menu</a>
            </div>
            
            <div class="dm-card-table">
                <table class="dm-table-premium">
                    <thead>
                        <tr>
                            <th style="width: 60px;">No</th>
                            <th>Nama Menu</th>
                            <th>Kategori</th>
                            <th>Harga</th>
                            <th>Gambar</th>
                            <th>Diubah Oleh</th> <th style="text-align: center; width: 180px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        while($data = mysqli_fetch_assoc($query)){
                            $kat = htmlspecialchars($data['nama_kategori'] ?? 'Tidak ada kategori');
                            $badge_class = (strtolower($kat) == 'makanan') ? 'dm-tag-cat dm-cat-makanan' : 'dm-tag-cat';
                        ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td>
                                <span class="dm-txt-name"><?= htmlspecialchars($data['nama_menu']); ?></span>
                            </td>
                            <td>
                                <span class="<?= $badge_class; ?>"><?= $kat; ?></span>
                            </td>
                            <td>
                                <span class="dm-txt-price">Rp <?= number_format($data['harga'], 0, ',', '.'); ?></span>
                            </td>
                            <td>
                                <img src="../../Aset/<?= htmlspecialchars($data['gambar']); ?>" class="dm-img-thumb" alt="Menu">
                            </td>
                            
                            <td>
                                <span class="dm-txt-admin">
                                    <?= htmlspecialchars($data['nama_admin'] ?? ''); ?>
                                </span>
                            </td>
                            
                            <td>
                                <div class="dm-btn-group">
                                    <a href="edit.php?id=<?= $data['menu_id']; ?>" class="dm-action-link dm-lnk-edit">Edit</a>
                                    <a href="hapus.php?id=<?= $data['menu_id']; ?>" 
                                    class="dm-action-link dm-lnk-delete"
                                    onclick="return confirm('Yakin hapus data?')">Hapus</a>
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