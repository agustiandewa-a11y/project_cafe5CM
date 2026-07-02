<?php
session_start();
include "../../koneksi.php";

if (!isset($_SESSION['admin_id'])) {
    header("Location: ../../login.php");
    exit();
}

// Pastikan id ada
if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit();
}

$id = (int) $_GET['id'];

// Ambil nama file gambar
$query = mysqli_query($koneksi, "SELECT nama_gambar FROM galeri WHERE gambar_id = '$id'");
$data = mysqli_fetch_assoc($query);

if ($data) {

    // Lokasi file gambar
    $file = "../../Aset/" . $data['nama_gambar'];

    // Hapus file jika ada
    if (file_exists($file)) {
        unlink($file);
    }

    // Hapus data dari database
    mysqli_query($koneksi, "DELETE FROM galeri WHERE gambar_id = '$id'");
}

header("Location: index.php");
exit();
?>