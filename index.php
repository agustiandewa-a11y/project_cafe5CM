<?php include 'koneksi.php'; ?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>5Cm Cafe</title>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="css/style.css">
</head>

<body class="landing-page">
<nav class="navbar-utama">
  <h2>Cafe 5CM</h2>
  <div>
    <a href="#home">Home</a>
    <a href="#Tentang">Tentang</a>
    <a href="#Visi">Visi & Misi</a>
    <a href="#kontak">Kontak</a>
  </div>
</nav>

<section id="home" class="hero">
  <h1>5Cm Coffee Experience</h1>
  <p>Segar, Santai, Nikmat</p>
  <button class="btn" onclick="scrollToMenu(document.getElementById('menu'))">Lihat Menu</button>
</section>


<!-- Menu Section -->
<section id="menu">
    <h2>Menu 5Cm</h2>
    <div class="filter-menu">
        <a href="index.php#menu" class="filter-btn">Semua</a>
        <a href="index.php?kategori=Makanan#menu" class="filter-btn">Makanan</a>
        <a href="index.php?kategori=Minuman#menu" class="filter-btn">Minuman</a>
        <a href="index.php?kategori=Snack#menu" class="filter-btn">Snack</a>
    </div>
    <div class="menu-grid">
    <?php
    $kategori = isset($_GET['kategori']) ? $_GET['kategori'] : '';
    if($kategori != ''){
        $query = mysqli_query($koneksi,"
            SELECT menu.*, kategori.nama_kategori
            FROM menu
            JOIN kategori
            ON menu.kategori_id = kategori.kategori_id
            WHERE kategori.nama_kategori = '$kategori'
        ");
    } else {
        $query = mysqli_query($koneksi,"
            SELECT menu.*, kategori.nama_kategori
            FROM menu
            JOIN kategori
            ON menu.kategori_id = kategori.kategori_id
        ");
    }
    if(mysqli_num_rows($query) > 0){
        while($data = mysqli_fetch_assoc($query)){
    ?>
        <div class="card">
            <img src="Aset/<?php echo $data['gambar']; ?>" alt="<?php echo $data['nama_menu']; ?>">
            <div class="card-content">
                <h3><?php echo $data['nama_menu']; ?></h3>
                <p>
                    Rp <?php echo number_format($data['harga'],0,',','.'); ?>
                </p>
                <button class="btn"
                    onclick="addToCart('<?php echo $data['nama_menu']; ?>')">
                    +
                </button>
                <button class="btn"
                    onclick="decreaseItem('<?php echo $data['nama_menu']; ?>')">
                    -
                </button>
            </div>
        </div>
    <?php
        }
    }
    ?>
    </div>
</section>


<!-- tentang Section -->
<section class="tentang" id="Tentang">
  <div class="container">
    <div class="section-tentang">
    <h3>Tentang <span>5cm</span></h3>
        <p>Kami menyajikan berbagai pilihan kopi berkualitas, mulai dari espresso hingga kopi susu kekinian, yang diracik dengan penuh perhatian. Tidak hanya itu, kami juga menyediakan minuman non-kopi bagi kamu yang ingin menikmati suasana tanpa kafein.</p>
          <br>    
            <p>Bagi kami, yang terpenting bukan hanya rasa kopi, tetapi juga suasana yang hangat, pelayanan yang ramah, dan momen yang tercipta di dalamnya.</p>
            <br>
            <p>Karena di sini, setiap cerita dimulai dari secangkir kopi.</p>
          </div>
          <div class="galerry">
            <img src="Aset/image1.jpeg">
            <img src="Aset/image2.jpeg">
            <img src="Aset/image3.jpeg">
          </div>
        </div>
      </section>


<!-- visi & misi -->
      <section class="visi-misi" id="Visi">
        <div class="overlay">
        <div class="box-visi">
          <h4>Visi</h4>
          <p>Menjadi coffee shop pilihan yang menghadirkan pengalaman ngopi berkualitas dengan cita rasa unik, 
            suasana nyaman, dan pelayanan terbaik bagi setiap pelanggan.</p>
          </div>

        <div class="box-misi">
          <h4>Misi</h4>
            <p>- Berkomitmen untuk menyajikan kopi dan makanan dengan kualitas terbaik.</p>
            <br>
            <p>- Menjadi pemimpin dalam industri kopi dan kuliner di Indonesia.</p>
        </div>
      </div>
    </section>


<!-- kontak Section -->
<section id="kontak" class="kontak-modern">
  <div class="kontak-header">
    <h2>KONTAK</h2>
    <p>Punya pertanyaan, kritik, atau ingin reservasi? Yuk mampir atau hubungi kami!</p>
  </div>

  <div class="kontak-grid-modern">
    <div class="kontak-info">
      
      <div class="info-card">
        <span class="icon">📍</span>
        <div>
          <h3>Lokasi Kafe</h3>
          <p>5CM Coffee & Eatery (Cabang Pancasila)<br>Kota Singkawang, Kalimantan Barat</p>
        </div>
      </div>

      <div class="info-card">
        <span class="icon">⏰</span>
        <div>
          <h3>Jam Operasional</h3>
          <p>Buka Setiap Hari<br>10.00 - 22.00 WIB</p>
        </div>
      </div>

      <div class="info-card">
        <span class="icon">📱</span>
        <div>
          <h3>WhatsApp / Reservasi</h3>
          <p>+62 895-0891-543</p>
        </div>
      </div>

      <div class="info-card">
        <span class="icon">📷</span>
        <div>
          <h3>Instagram Kami</h3>
          <p>Username: 5cmcoffee</p>
        </div>
      </div>
    </section>


<!-- INI LOKASI -->
<section class="lokasi">
      <h2>LOKASI</h2>
        <div class="map-container">
          <iframe 
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3989.81788377264!2d109.31679257472328!3d-0.02680329997292374!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e1d59007178ab37%3A0x2159dd29619903b9!2s5CM%20Coffee%20%26%20Eatery%20(Cabang%20Pancasila)!5e0!3m2!1sid!2sid!4v1777717066080!5m2!1sid!2sid"
            width="600"
            height="450"
            style="border:0;"
            allowfullscreen=""
            loading="lazy">
          </iframe>
        </div>
      </section>

      
<!--INI CART-->
<div class="cart" onclick="showCart()">🛒 Cart (<span id="cartCount">0</span>)</div>
<div id="totalHarga">Total: Rp 0</div>
<div id="backTop" onclick="scrollToTop()">⬆ Top</div>


<!-- INI FOOTER -->
<footer>
  <p>© 2026 5Cm Cafe</p>
</footer>

     <script src="js/script.js"></script>
  </body>
</html>