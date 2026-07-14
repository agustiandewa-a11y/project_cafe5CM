<?php
session_start();
include '../../koneksi.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: ../../login.php");
    exit();
}

if (isset($_GET['id'])) {
    $admin_id = intval($_GET['id']);

    if ($admin_id == $_SESSION['admin_id']) {
        header("Location: index.php?pesan=gagal_hapus_diri");
        exit();
    }

    $total = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM admin"))['total'];
    if ($total <= 1) {
        header("Location: index.php?pesan=gagal_hapus_terakhir");
        exit();
    }

    $stmt = $koneksi->prepare("DELETE FROM admin WHERE admin_id = ?");
    $stmt->bind_param("i", $admin_id);

    if ($stmt->execute()) {
        header("Location: index.php?pesan=hapus_sukses");
        exit();
    } else {
        echo "Gagal menghapus data: " . htmlspecialchars($koneksi->error);
    }

    $stmt->close();

} else {
    header("Location: index.php");
    exit();
}