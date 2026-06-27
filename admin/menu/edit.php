<?php
include '../../koneksi.php';

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit();
}

$menu_id = intval($_GET['id']);


$stmt_get = $koneksi->prepare("SELECT * FROM menu WHERE menu_id = ?");
$stmt_get->bind_param("i", $menu_id);
$stmt_get->execute();
$result_get = $stmt_get->get_result();
$menu = $result_get->fetch_assoc();
$stmt_get->close();

if (!$menu) {
    echo "Data menu tidak ditemukan.";
    exit();
}

if (isset($_POST['submit'])) {
    
    $nama_menu   = htmlspecialchars($_POST['nama_menu']);
    $kategori_id = intval($_POST['kategori_id']);
    $harga       = intval($_POST['harga']);
    
    $gambar_baru = $_FILES['gambar']['name'];
    $tmp_name    = $_FILES['gambar']['tmp_name'];

    if (!empty($gambar_baru)) {
        
        $target_dir = "../../Aset/" . $gambar_baru;
        if (move_uploaded_file($tmp_name, $target_dir)) {
            // Hapus file gambar lama dari server
            $gambar_lama = "../../Aset/" . $menu['gambar'];
            if (file_exists($gambar_lama) && !empty($menu['gambar'])) {
                unlink($gambar_lama);
            }
            
            
            $stmt_update = $koneksi->prepare("UPDATE menu SET nama_menu = ?, harga = ?, kategori_id = ?, gambar = ? WHERE menu_id = ?");
            $stmt_update->bind_param("siisi", $nama_menu, $harga, $kategori_id, $gambar_baru, $menu_id);
        } else {
            echo "Gagal mengunggah gambar baru.";
            exit();
        }
    } else {
        
        $stmt_update = $koneksi->prepare("UPDATE menu SET nama_menu = ?, harga = ?, kategori_id = ? WHERE menu_id = ?");
        $stmt_update->bind_param("siii", $nama_menu, $harga, $kategori_id, $menu_id);
    }

    if ($stmt_update->execute()) {
        header("Location: index.php?pesan=edit_sukses");
        exit();
    } else {
        echo "Gagal memperbarui data: " . htmlspecialchars($koneksi->error);
    }
    $stmt_update->close();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Menu - Admin5CM</title>
    <link rel="stylesheet" href="../../css/style.css">
</head>
<body>
<div class="form-container">
    <h2>Edit Menu</h2>
    <form action="" method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label>Nama Menu</label>
            <input type="text" name="nama_menu" value="<?= htmlspecialchars($menu['nama_menu']); ?>" required>
        </div>
        
        <div class="form-group">
            <label>Kategori</label>
            <select name="kategori_id" required>
                <option value="">-- Pilih Kategori --</option>
                <?php
                $kat_query = mysqli_query($koneksi, "SELECT * FROM kategori");
                while ($kat = mysqli_fetch_assoc($kat_query)) {
                    $selected = ($kat['kategori_id'] == $menu['kategori_id']) ? 'selected' : '';
                    echo "<option value='" . intval($kat['kategori_id']) . "' $selected>" . htmlspecialchars($kat['nama_kategori']) . "</option>";
                }
                ?>
            </select>
        </div>
        
        <div class="form-group">
            <label>Harga (Rp)</label>
            <input type="number" name="harga" value="<?= intval($menu['harga']); ?>" required>
        </div>
        
        <div class="form-group">
            <label>Gambar Menu saat ini:</label><br>
            <img id="previewGambar" src="../../Aset/<?= htmlspecialchars($menu['gambar']); ?>" width="100" style="margin-bottom:10px;"><br>
            
            <label>Pilih Gambar Baru (Kosongkan jika tidak diubah)</label>
            <input type="file" name="gambar" id="inputGambar" accept="image/*">
        </div>
        
        <button type="submit" name="submit" class="btn-submit">Simpan Perubahan</button>
    </form>
    <a href="index.php" class="btn btn-secondary" style="display:inline-block; margin-top:15px;">&larr; Kembali</a>
</div>

    <script src="../../JavaScript/script.js"></script>
</body>
</html>