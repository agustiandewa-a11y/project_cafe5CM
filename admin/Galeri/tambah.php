<?php
session_start();
include "../../koneksi.php";

/* ==========================
   Cek Login Admin
========================== */
if (!isset($_SESSION['admin_id'])) {
    header("Location: ../../login.php");
    exit();
}

/* ==========================
   Proses Upload
========================== */

if (isset($_POST['simpan'])) {

    $admin_id = $_SESSION['admin_id'];

    $namaFile = $_FILES['gambar']['name'];
    $tmpFile = $_FILES['gambar']['tmp_name'];

    if ($namaFile != "") {

        move_uploaded_file(
            $tmpFile,
            "../../Aset/" . $namaFile
        );

        mysqli_query($koneksi, "
            INSERT INTO galeri(admin_id,nama_gambar)
            VALUES('$admin_id','$namaFile')
        ");

        header("Location:index.php");
        exit();

    } else {

        echo "<script>alert('Silahkan pilih gambar terlebih dahulu!');</script>";

    }

}
?>

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Tambah Galeri</title>

    <link rel="stylesheet" href="../../css/style.css">

</head>

<body class="dm-layout-body">

    <div class="dm-sidebar-wrapper">

        <div class="dm-logo-text">
            5CM
        </div>

        <nav class="dm-navigation">

            <a href="../dashboard.php" class="dm-nav-item">
                Dashboard
            </a>

            <a href="../menu/index.php" class="dm-nav-item">
                Kelola Menu
            </a>

            <a href="../kategori/index.php" class="dm-nav-item">
                Kelola Kategori
            </a>

            <a href="index.php" class="dm-nav-item dm-item-active">
                Kelola Galeri
            </a>

            <a href="../../logout.php" class="dm-nav-item">
                Logout
            </a>

        </nav>

    </div>


    <div class="dm-main-container">

        <div class="dm-top-navbar">

            <h1>Tambah Galeri</h1>

        </div>

        <div class="dm-content-page">

            <div class="dm-card-table">

                <form method="POST" enctype="multipart/form-data">

                    <table>

                        <tr>

                            <td>Pilih Gambar</td>

                            <td>

                                <input type="file" name="gambar" accept="image/*" required>

                            </td>

                        </tr>

                        <tr>

                            <td></td>

                            <td>

                                <br>

                                <button type="submit" name="simpan" class="dm-btn-add">

                                    Simpan

                                </button>

                                <a href="index.php" class="dm-action-link dm-lnk-delete">

                                    Batal

                                </a>

                            </td>

                        </tr>

                    </table>

                </form>

            </div>

        </div>

    </div>

</body>

</html>