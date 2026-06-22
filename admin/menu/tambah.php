<?php
include '../../koneksi.php';

if (isset($_POST['submit'])) {
    
    $nama_menu   = htmlspecialchars($_POST['nama_menu']);
    $kategori_id = intval($_POST['kategori_id']);
    $harga       = intval($_POST['harga']);

    // Manajemen Upload Gambar
    $gambar     = $_FILES['gambar']['name'];
    $tmp_name   = $_FILES['gambar']['tmp_name'];
    $target_dir = "../../Aset/" . $gambar;

    if (move_uploaded_file($tmp_name, $target_dir)) {
        
        $stmt = $koneksi->prepare("INSERT INTO menu (nama_menu, harga, kategori_id, gambar) VALUES (?, ?, ?, ?)");
        
        
        $stmt->bind_param("siis", $nama_menu, $harga, $kategori_id, $gambar);

        if ($stmt->execute()) {
            header("Location: index.php?pesan=tambah_sukses");
            exit();
        } else {
            echo "Gagal menyimpan ke database: " . htmlspecialchars($koneksi->error);
        }
        $stmt->close();
    } else {
        echo "Gagal mengunggah gambar. Periksa hak akses folder Aset.";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Menu - Admin5CM</title>
</head>
<body>
<div class="form-container">
    <h2>Tambah Menu Baru</h2>
    <form action="" method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label>Nama Menu</label>
            <input type="text" name="nama_menu" required>
        </div>
        
        <div class="form-group">
            <label>Kategori</label>
            <select name="kategori_id" required>
                <option value="">-- Pilih Kategori --</option>
                <?php
                
                $kat_query = mysqli_query($koneksi, "SELECT * FROM kategori");
                while ($kat = mysqli_fetch_assoc($kat_query)) {
                    
                    echo "<option value='" . intval($kat['kategori_id']) . "'>" . htmlspecialchars($kat['nama_kategori']) . "</option>";
                }
                ?>
            </select>
        </div>
        
        <div class="form-group">
            <label>Harga (Rp)</label>
            <input type="number" name="harga" required>
        </div>
        
        <div class="form-group">
            <label>Gambar Menu</label>
            <input type="file" name="gambar" accept="image/*" required>
        </div>
        
        <button type="submit" name="submit" class="btn-submit">Tambah Menu</button>
    </form>
    <a href="index.php" class="btn btn-secondary"> Kembali</a>
</div>
</body>
</html>