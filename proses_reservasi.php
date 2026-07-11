<?php
include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: index.php");
    exit();
}

$nama_customer   = htmlspecialchars(trim($_POST['nama_lengkap']));
$no_hp           = htmlspecialchars(trim($_POST['no_telepon']));
$tanggal = htmlspecialchars(trim($_POST['tanggal']));
$jumlah_customer = intval($_POST['jumlah_pelanggan']);
$catatan         = htmlspecialchars(trim($_POST['catatan'] ?? ''));


if (empty($nama_customer) || empty($no_hp) || empty($tanggal) || $jumlah_customer < 1) {
    header("Location: index.php?reservasi=gagal");
    exit();
}


$stmt = $koneksi->prepare("
    INSERT INTO reservasi (nama_customer, no_hp, tanggal_reservasi, jumlah_customer, catatan)
    VALUES (?, ?, ?, ?, ?)
");
$stmt->bind_param("sssis", $nama_customer, $no_hp, $tanggal, $jumlah_customer, $catatan);

if ($stmt->execute()) {
    header("Location: index.php?reservasi=sukses");
    exit();
} else {
    header("Location: index.php?reservasi=gagal");
    exit();
}

$stmt->close();