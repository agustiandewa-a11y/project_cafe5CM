<?php
include '../security.php';
include "../../koneksi.php";

if (!isset($_SESSION['admin_id'])) {
    header("Location: ../../login.php");
    exit();
}

$query = mysqli_query($koneksi, "
    SELECT r.*, a.username AS nama_admin 
    FROM reservasi r
    LEFT JOIN admin a ON r.admin_id = a.admin_id
    ORDER BY r.tanggal_input DESC
");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Reservasi - 5Cm Cafe</title>
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
        </nav>
    </div>

    <div class="dm-main-container">
        <div class="dm-top-navbar">
            <h1>Kelola Data Reservasi</h1>
        </div>

        <div class="dm-content-page">
            <div class="dm-header-action">
                <h2>Data Reservasi</h2>
            </div>

            <?php if (isset($_GET['pesan'])): ?>
                <?php if ($_GET['pesan'] === 'hapus_sukses'): ?>
                    <p class="dm-alert dm-alert-success">Reservasi berhasil dihapus.</p>
                <?php elseif ($_GET['pesan'] === 'update_sukses'): ?>
                    <p class="dm-alert dm-alert-success">Status reservasi berhasil diupdate.</p>
                <?php endif; ?>
            <?php endif; ?>

            <div class="dm-card-table">
                <table class="dm-table-premium">
                    <thead>
                        <tr>
                            <th style="width: 50px;">No</th>
                            <th>Nama Customer</th>
                            <th>No HP</th>
                            <th>Tanggal Reservasi</th>
                            <th>Jumlah</th>
                            <th>Catatan</th>
                            <th>Status</th>
                            <th>Tanggal Input</th>
                            <th>Diubah Oleh</th>
                            <th style="text-align:center; width:180px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        while ($data = mysqli_fetch_assoc($query)):
                            switch ($data['status']) {
                            case 'confirmed': $badge = 'dm-kat-confirmed'; break;
                            default:          $badge = 'dm-kat-pending';   break;
                        }
                        ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><span class="dm-txt-name"><?= htmlspecialchars($data['nama_customer']) ?></span></td>
                            <td><?= htmlspecialchars($data['no_hp']) ?></td>
                            <td><?= date('d M Y H:i', strtotime($data['tanggal_reservasi'])) ?></td>
                            <td><?= (int)$data['jumlah_customer'] ?> orang</td>
                            <td><?= ($data['catatan'] === '0' || empty($data['catatan'])) ? '-' : htmlspecialchars($data['catatan']) ?></td>
                            <td>
                                <span class="<?= $badge ?>"><?= ucfirst($data['status']) ?></span>
                            </td>
                            <td><span class="dm-txt-date"><?= $data['tanggal_input'] ? date('d M Y H:i', strtotime($data['tanggal_input'])) : '-' ?></span></td>
                            <td>
                                <?php if ($data['admin_id']): ?>
                                    <span class="dm-txt-admin"><?= htmlspecialchars($data['nama_admin']) ?></span>
                                <?php else: ?>
                                    <em class="dm-txt-muted">-</em>
                                <?php endif; ?>
                            </td>
                            <td>
                                <div class="dm-btn-group">
                                    <a href="edit.php?id=<?= $data['reservasi_id'] ?>" class="dm-action-link dm-lnk-edit">Edit</a>
                                    <a href="hapus.php?id=<?= $data['reservasi_id'] ?>" class="dm-action-link dm-lnk-delete" onclick="return confirm('Yakin hapus data?')">Hapus</a>
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