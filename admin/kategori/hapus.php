<?php
session_start();
include '../../koneksi.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: ../../login.php");
    exit();
}

if (isset($_GET['id'])) {
    $kategori_id = intval($_GET['id']);


    $stmt_cek = $koneksi->prepare("SELECT COUNT(*) AS total FROM menu WHERE kategori_id = ?");
    $stmt_cek->bind_param("i", $kategori_id);
    $stmt_cek->execute();
    $result_cek = $stmt_cek->get_result()->fetch_assoc();
    $stmt_cek->close();

    if ($result_cek['total'] > 0) {
        // Kategori masih digunakan — tolak penghapusan
        header("Location: index.php?pesan=gagal_hapus");
        exit();
    }

    // ============================================================
    // DELETE: Aman dihapus karena tidak ada relasi ke tabel menu
    // ============================================================
    $stmt = $koneksi->prepare("DELETE FROM kategori WHERE kategori_id = ?");
    $stmt->bind_param("i", $kategori_id);

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