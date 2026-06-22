<?php
include '../../koneksi.php';

if (isset($_GET['id'])) {
    $menu_id = intval($_GET['id']); 

    
    $stmt_img = $koneksi->prepare("SELECT gambar FROM menu WHERE menu_id = ?");
    $stmt_img->bind_param("i", $menu_id);
    $stmt_img->execute();
    $result = $stmt_img->get_result();
    if ($data = $result->fetch_assoc()) {
        $gambar_lama = "../../Aset/" . $data['gambar'];
        if (file_exists($gambar_lama) && !empty($data['gambar'])) {
            unlink($gambar_lama); 
        }
    }
    $stmt_img->close();

    
    $stmt = $koneksi->prepare("DELETE FROM menu WHERE menu_id = ?");
    $stmt->bind_param("i", $menu_id);

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
?>