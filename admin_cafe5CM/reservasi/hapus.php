<?php
include '../security.php';
include '../../koneksi.php';

$id = intval($_GET['id'] ?? 0);
if (!$id) { header("Location: index.php"); exit(); }

$stmt = $koneksi->prepare("DELETE FROM reservasi WHERE reservasi_id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$stmt->close();

header("Location: index.php?pesan=hapus_sukses");
exit();