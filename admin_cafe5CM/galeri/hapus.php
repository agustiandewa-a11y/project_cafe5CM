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

$id = intval($_GET['id']);

// Ambil nama file sebelum dihapus dari DB
$stmt_get = $koneksi->prepare("SELECT nama_gambar FROM galeri WHERE gambar_id = ?");
$stmt_get->bind_param("i", $id);
$stmt_get->execute();
$result = $stmt_get->get_result()->fetch_assoc();
$stmt_get->close();

if ($result) {
    
    $path_file = "../../Aset/" . $result['nama_gambar'];
    if (file_exists($path_file) && !empty($result['nama_gambar'])) {
        unlink($path_file);
    }

    // Hapus record dari database
    $stmt = $koneksi->prepare("DELETE FROM galeri WHERE gambar_id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
}

header("Location: index.php?pesan=hapus_sukses");
exit();