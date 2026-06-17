<?php
include "../../koneksi.php";

$query = mysqli_query($koneksi, "
    SELECT menu.*, kategori.nama_kategori 
    FROM menu 
    LEFT JOIN kategori ON menu.kategori_id = kategori.kategori_id
");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <title>Data Menu</title>
</head>
<body>

<h2>Data Menu</h2>
<a href="tambah.php">Tambah Menu</a>
<br><br>
<a href="../dashboard.php">Kembali ke Dashboard</a>
<br><br>

<table border="1" cellpadding="10" cellspacing="0">
    <tr>
        <th>No</th>
        <th>Nama Menu</th>
        <th>Kategori</th>
        <th>Harga</th>
        <th>Gambar</th>
        <th>Aksi</th>
    </tr>

    <?php
    $no = 1;
    
    while($data = mysqli_fetch_assoc($query)){
    ?>
    <tr>
        <td><?= $no++; ?></td>
        <td><?= htmlspecialchars($data['nama_menu']); ?></td>
        <td><?= htmlspecialchars($data['nama_kategori'] ?? 'Tidak ada kategori'); ?></td>
        <td>Rp <?= number_format($data['harga'], 0, ',', '.'); ?></td>
        <td>
            <img src="../../Aset/<?= htmlspecialchars($data['gambar']); ?>" width="100">
        </td>
        <td>
            <a href="edit.php?id=<?= $data['menu_id']; ?>">Edit</a> |
            <a href="hapus.php?id=<?= $data['menu_id']; ?>" 
               onclick="return confirm('Yakin hapus data?')">Hapus</a>
        </td>
    </tr>
    <?php } ?>
</table>

</body>
</html>