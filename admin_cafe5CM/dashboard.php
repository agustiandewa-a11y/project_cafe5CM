<?php

session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: ../login.php");
    exit();
}

include '../koneksi.php';

$username = htmlspecialchars($_SESSION['username'] ?? 'Admin');

$total_menu        = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM menu"))['total'];
$total_kategori    = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM kategori"))['total'];
$total_reservasi   = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM reservasi"))['total'];
$reservasi_pending = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM reservasi WHERE status = 'pending'"))['total'];

$q_reservasi = mysqli_query($koneksi, "
    SELECT r.*, a.username AS nama_admin
    FROM reservasi r
    LEFT JOIN admin a ON r.admin_id = a.admin_id
    ORDER BY r.tanggal_input DESC
    LIMIT 5
");

$q_menu = mysqli_query($koneksi, "
    SELECT m.*, k.nama_kategori
    FROM menu m
    LEFT JOIN kategori k ON m.kategori_id = k.kategori_id
    ORDER BY m.menu_id DESC
    LIMIT 5
");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - 5CM Cafe</title>
    <link rel="stylesheet" href="../css/style.css">
</head>

<body class="dm-layout-body">

    <div class="dm-sidebar-wrapper">
        <div class="dm-logo-text">5CM</div>
        <nav class="dm-navigation">
            <a href="dashboard.php" class="dm-nav-item dm-item-active">Dashboard</a>
            <a href="menu/index.php" class="dm-nav-item">Kelola Menu</a>
            <a href="kategori/index.php" class="dm-nav-item">Kelola Kategori</a>
            <a href="galeri/index.php" class="dm-nav-item">Kelola Galeri</a>
            <a href="reservasi/index.php" class="dm-nav-item">Kelola Reservasi</a>
            <a href="admin/index.php" class="dm-nav-item">Kelola Akun Admin</a>
            <a href="logout.php" class="dm-nav-item">Logout</a>
        </nav>
    </div>

    <div class="dm-main-container">
        <div class="dm-top-navbar">
            <h1>Dashboard</h1>
            <span>Selamat datang, <?= $username ?></span>
        </div>

        <div class="dm-content-page">

            <!-- inik banner -->
            <div class="dash-banner">
                <div class="dash-banner-text">
                    <h2>Halo, <?= $username ?>! 👋</h2>
                    <p>Ringkasan data <strong>Restoran 5CM</strong> hari ini.</p>
                </div>
            </div>

            <!-- ini cards -->
            <div class="dash-stats-grid">
                <div class="dash-card dash-card-green">
                    <div class="dash-card-icon">🍽️</div>
                    <div class="dash-card-info">
                        <span class="dash-card-number"><?= $total_menu ?></span>
                        <span class="dash-card-label">Total Menu</span>
                    </div>
                </div>
                <div class="dash-card dash-card-blue">
                    <div class="dash-card-icon">🏷️</div>
                    <div class="dash-card-info">
                        <span class="dash-card-number"><?= $total_kategori ?></span>
                        <span class="dash-card-label">Total Kategori</span>
                    </div>
                </div>
                <div class="dash-card dash-card-teal">
                    <div class="dash-card-icon">📅</div>
                    <div class="dash-card-info">
                        <span class="dash-card-number"><?= $total_reservasi ?></span>
                        <span class="dash-card-label">Total Reservasi</span>
                    </div>
                </div>
                <div class="dash-card dash-card-yellow">
                    <div class="dash-card-icon">⏳</div>
                    <div class="dash-card-info">
                        <span class="dash-card-number"><?= $reservasi_pending ?></span>
                        <span class="dash-card-label">Reservasi Pending</span>
                    </div>
                </div>
            </div>

            <!-- ini div tabel bawah -->
            <div class="dash-bottom-grid">

                <div class="dash-table-card">
                    <div class="dash-table-header">
                        <h3>Reservasi Terbaru</h3>
                        <a href="reservasi/index.php">Lihat Semua →</a>
                    </div>
                    <table class="dm-table-premium">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Tanggal</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php if (mysqli_num_rows($q_reservasi) > 0):
                            while ($r = mysqli_fetch_assoc($q_reservasi)):
                                $status_class = match($r['status']) {
                                    'confirmed' => 'dash-badge-green',
                                    'cancelled' => 'dash-badge-red',
                                    default     => 'dash-badge-yellow'
                                };
                        ?>
                            <tr>
                                <td><?= htmlspecialchars($r['nama_customer']) ?></td>
                                <td><?= date('d M Y', strtotime($r['tanggal_reservasi'])) ?></td>
                                <td>
                                    <span class="dash-badge <?= $status_class ?>">
                                        <?= ucfirst($r['status']) ?>
                                    </span>
                                </td>
                                <td>
                                    <a href="reservasi/edit.php?id=<?= $r['reservasi_id'] ?>"
                                       class="dm-action-link dm-lnk-edit">Edit</a>
                                </td>
                            </tr>
                        <?php endwhile; else: ?>
                            <tr>
                                <td colspan="4" style="text-align:center;color:#9ca3af;">
                                    Belum ada reservasi.
                                </td>
                            </tr>
                        <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <!-- ini untuk menu terbaru -->
                <div class="dash-table-card">
                    <div class="dash-table-header">
                        <h3>Menu Terbaru</h3>
                        <a href="menu/index.php">Lihat Semua →</a>
                    </div>
                    <table class="dm-table-premium">
                        <thead>
                            <tr>
                                <th>Nama Menu</th>
                                <th>Kategori</th>
                                <th>Harga</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php if (mysqli_num_rows($q_menu) > 0):
                            while ($m = mysqli_fetch_assoc($q_menu)):
                                $kat = htmlspecialchars($m['nama_kategori'] ?? '-');
                                $badge_class = "dm-tag-kat";
                                switch (strtolower($kat)) {
                                    case "makanan": $badge_class .= " dm-kat-makanan"; break;
                                    case "minuman": $badge_class .= " dm-kat-minuman"; break;
                                    case "dessert": $badge_class .= " dm-kat-dessert"; break;
                                    default:        $badge_class .= " dm-kat-default";  break;
                                }
                        ?>
                            <tr>
                                <td><?= htmlspecialchars($m['nama_menu']) ?></td>
                                <td><span class="<?= $badge_class ?>"><?= $kat ?></span></td>
                                <td>Rp <?= number_format($m['harga'], 0, ',', '.') ?></td>
                            </tr>
                        <?php endwhile; else: ?>
                            <tr>
                                <td colspan="3" style="text-align:center;color:#9ca3af;">
                                    Belum ada menu.
                                </td>
                            </tr>
                        <?php endif; ?>
                        </tbody>
                    </table>
                </div>

            </div>

        </div>
    </div>

</body>
</html>