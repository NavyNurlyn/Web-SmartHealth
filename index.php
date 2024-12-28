<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <title>SmartHealth - Pendaftaran Antrian Puskesmas Online</title>
  <link rel="icon" type="image/png" href="img\smarthealth.png">
  <meta name="description" content="" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <!-- font awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <!-- owl carousel -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" integrity="sha512-tS3S5qG0BlhnQROyJXvNjeEM4UpMXHrQfTGmbQ1gKmelCxlSEBUaxhRBj/EFTzpbP4RVSrpEikbmdJobCvhE3g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css" integrity="sha512-sMXtMNL1zRzolHYKEujM2AqCLUR9F2C4/05cdbxjjLSRvMQIciEPCQZo++nk7go3BtSuK9kfa/s+a4f4i5pLkw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous" />
  <!-- custom css -->
  <link rel="stylesheet" href="assets/css/main.css" />
  <link rel="stylesheet" href="assets/css/utilities.css" />
  <!-- normalize.css -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/8.0.1/normalize.min.css" integrity="sha512-NhSC1YmyruXifcj/KFRWoC561YpHpc5Jtzgvbuzx5VozKpWvQ+4nXhPdFgmx8xqexRcpAglTj9sIBWINXa8x5w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <style>
    .btnlogin {
      min-width: 130px;
      height: 40px;
      border-radius: 54px;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      font-weight: 700;
      font-size: 15px;
      color: var(--clr-white);
      transition: var(--transition-default);
    }

    .btnlogin:hover {
      color: var(--clr-white);
      background-color: #1472f4;
      box-shadow: rgba(17, 17, 26, 0.1) 0px 8px 24px, rgba(17, 17, 26, 0.1) 0px 16px 56px, rgba(17, 17, 26, 0.1) 0px 24px 80px;
    }
  </style>
</head>

<body>
  <div class="page-wrapper">
    <!-- header -->
    <header class="header">
      <nav class="navbar sticky-top navbar-expand-lg navbar-dark shadow" style="background: #1e46af">
        <div class="container">
          <a class="navbar-brand" href="#">
            <img src="img/smarthealth.png" alt="" width="30" height="30" class="d-inline-block align-text-top" />
            SmartHealth
          </a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
            <div class="navbar-nav ms-auto">
              <a href="index.php" class="nav-link active" aria-current="page">Beranda</a>
              <a href="pendaftaran.php" class="nav-link" aria-current="page">Pendaftaran</a>
              <a href="artikel.php" class="nav-link" aria-current="page">Artikel</a>
              <a href="pengumuman.php" class="nav-link" aria-current="page">Pengumuman</a>
              <a class="nav-link" aria-current="page" href="#infodarurat">Info Layanan Darurat</a>
            </div>
          </div>
        </div>
      </nav>

      <div id="beranda" class="landingpage">
        <img src="assets/images/element-img-1.png" alt="" />
      </div>
      <div class="jumbotron">
        <div class="container">
          <div class="jumbotron-content">
            <div class="jumbotron-left">
              <div class="content-wrapper">
                <h1 class="jumbotron-title">Welcome to SmartHealth</h1>
                <p class="text text-white">
                  SmartHealth adalah sebuah platform inovatif yang
                  menghubungkan semua Puskesmas di Sidoarjo dalam mendukung
                  program Smart Village. Aplikasi ini dirancang untuk
                  memudahkan akses layanan kesehatan bagi seluruh warga dan
                  memastikan Anda mendapatkan perawatan terbaik.
                </p>
                <a href="#fitur" class="btn btn-secondary">Lihat Selengkapnya</a>
              </div>
            </div>
            <div class="jumbotron-right d-flex align-items-center justify-content-end">
              <img src="assets/images/banner-image.png" alt="" />
            </div>
          </div>
        </div>
      </div>
    </header>
    <!-- end of header -->

    <main>
      <section id="fitur" class="sc-services">
        <div class="services-shape">
          <img src="assets/images/curve-shape-1.png" alt="" />
        </div>
        <div class="container">
          <div class="services-content">
            <div class="title-box text-center">
              <div class="content-wrapper">
                <h3 class="title-box-name">Fitur dan Layanan Kami</h3>
                <div class="title-separator mx-auto"></div>
                <p class="text title-box-text">
                  SmartHealth menyediakan berbagai fitur dan layanan unggulan
                  yang dapat menjadi solusi pintar kesehatan Anda!
                </p>
              </div>
            </div>
            <div class="services-list">
              <div class="services-item">
                <div class="item-icon">
                  <img src="assets/images/service-icon-1.png" alt="service icon" />
                </div>
                <h5 class="item-title fw-7">Pendaftaran Online</h5>
                <p class="text">
                  Lakukan pendaftaran untuk mendapat nomor antrian online di
                  Puskesmas pilihan anda
                </p>
                <div class="d-flex align-items-center justify-content-center services-main-btn" style="margin-top: 20px">
                  <button type="button" class="btn btn-primary-outline" onclick="window.location.href='pendaftaran.php'">
                    Daftar Sekarang
                  </button>
                </div>
              </div>

              <div class="services-item">
                <div class="item-icon">
                  <img src="assets/images/service-icon-2.png" alt="service icon" />
                </div>
                <h5 class="item-title fw-7">Informasi Puskesmas</h5>
                <p class="text">
                  Lihat dan cek informasi detail seputar Puskesmas yang ada di
                  Sidoarjo
                </p>
                <div class="d-flex align-items-center justify-content-center services-main-btn" style="margin-top: 49px">
                  <button type="button" class="btn btn-primary-outline" onclick="window.location.href='daftar-puskesmas.php'">
                    Lihat Sekarang
                  </button>
                </div>
              </div>

              <div class="services-item">
                <div class="item-icon">
                  <img src="assets/images/service-icon-3.png" alt="service icon" />
                </div>
                <h5 class="item-title fw-7">
                  Kalkulator BMI (Body Mass Index)
                </h5>
                <p class="text">
                  Hitung Indeks Masa Tubuh (Body Mass Index) Anda secara
                  mandiri
                </p>
                <div class="d-flex align-items-center justify-content-center services-main-btn">
                  <button type="button" class="btn btn-primary-outline" onclick="window.location.href='template_bmi.php'">
                    Hitung Sekarang
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
      <!-- Berita Start -->
      <section id="pengumuman" class="berita">
        <div class="container">
          <div class="berita-content">
            <div class="title-box text-center">
              <div class="content-wrapper">
                <h3 class="title-box-name">Berita dan Pengumuman</h3>
                <div class="title-separator mx-auto"></div>
                <p class="text title-box-text">
                  Jangan Lewatkan! Cek Berita dan Pengumuman terkait program
                  kesehatan terbaru oleh Puskesmas Sidoarjo
                </p>
              </div>
            </div>
            <div class="berita-list">
              <?php
              include("koneksi.php");
              // Fungsi untuk memotong teks menjadi maksimal 15 kata
              function truncateTextBerita($text, $maxWords)
              {
                $words = explode(' ', $text);
                if (count($words) > $maxWords) {
                  $words = array_slice($words, 0, $maxWords);
                  return implode(' ', $words) . '...';
                }
                return $text;
              }
              $sql = "SELECT * FROM pengumuman ORDER BY TGL_DIBUAT DESC LIMIT 4";
              $hasil = mysqli_query($con, $sql);
              $jmlatikel = mysqli_num_rows($hasil);
              if ($jmlatikel > 0) {
                while ($row = mysqli_fetch_assoc($hasil)) {
                  $shortTextBerita = truncateTextBerita($row["ISI_PENGUMUMAN"], 15);
                  // Pilih gambar berdasarkan indeks dan modulus operator
                  // Ambil gambar dari kolom FOTO_PENGUMUMAN di database
                  $imageData = $row["FOTO_PENGUMUMAN"];
                  // Ubah format data base64 ke tag img HTML
                  $imageHTML = '<img src="data:image/jpeg;base64,' . base64_encode($imageData) . '" class="card-img-top" alt="...">';
              ?>
                  <div class="card mb-3 berita-item" style="max-width: 540px">
                    <div class="row g-3">
                      <div class="col-md-5 ">
                        <?php echo $imageHTML; ?>
                      </div>
                      <div class="col-md-6">
                        <div class="berita-card-body">
                          <h6 class="berita-card-title" style="font-size: 20px;">
                            <?php echo $row["JUDUL_PENGUMUMAN"]; ?>
                          </h6>
                          <p class="berita-card-text">
                            <?php echo htmlspecialchars($shortTextBerita); ?>
                          </p>
                          <div class="d-flex align-items-end justify-content-start berita-main-btn">
                            <button type="button" class="btn btn-primary" style="color: white" onclick="window.location.href='pengumuman-detail.php?id=<?php echo $row["ID_PENGUMUMAN"]; ?>'">
                              Lihat Berita
                            </button>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
              <?php
                }
              }
              ?>
            </div>
          </div>
        </div>
      </section>
      <!-- berita finish -->
      <section id="infodarurat" class="sc-grid sc-grid-one">
        <div class="container">
          <div class="grid-content d-grid align-items-center">
            <div class="grid-img">
              <img src="assets/images/health-care-img.png" alt="" />
            </div>
            <div class="grid-text">
              <div class="content-wrapper text-start">
                <div class="title-box">
                  <h3 class="title-box-name text-white">
                    Infrormasi Layanan Darurat
                  </h3>
                  <div class="title-separator mx-auto"></div>
                </div>
                <p class="text title-box-text text-white">
                  Memberikan informasi cepat terkait Telpon Darurat Sidoarjo, Jika anda mengalami kesulitan dan dalam bahaya hubungi nomor telepon berikut ini
                </p>
                <div class="container overflow-hidden text-center">
                  <div class="row gy-3">
                    <div class="col-6">
                      <div class="card">
                        <div class="card-header fw-bold" style="background-color: #1e46af;color: var(--clr-white);">
                          Ambulance
                        </div>
                        <div class="card-body">
                          <h5 class="fw-semibold">118</h5>
                        </div>
                      </div>
                    </div>
                    <div class="col-6">
                      <div class="card">
                        <div class="card-header fw-bold" style="background-color: #1e46af;color: var(--clr-white);">
                          DamKar
                        </div>
                        <div class="card-body">
                          <h5 class="fw-semibold">123</h5>
                        </div>
                      </div>
                    </div>
                    <div class="col-6">
                      <div class="card">
                        <div class="card-header fw-bold" style="background-color: #1e46af; color: var(--clr-white);">
                          Tim SAR
                        </div>
                        <div class="card-body">
                          <h5 class="fw-semibold">123</h5>
                        </div>
                      </div>
                    </div>
                    <div class="col-6">
                      <div class="card">
                        <div class="card-header fw-bold" style="background-color: #1e46af;color: var(--clr-white);">
                          Polisi
                        </div>
                        <div class="card-body">
                          <h5 class="fw-semibold">110</h5>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
      <!-- Artikel Start -->
      <section id="artikel" class="sc-articles">
        <div class="articles-shape">
          <img src="assets/images/curve-shape-2.png" alt="" />
        </div>
        <div class="container">
          <div class="articles-content">
            <div class="articles-element">
              <img src="assets/images/element-img-2.png" alt="" />
            </div>
            <div class="title-box text-center">
              <div class="content-wrapper">
                <h3 class="title-box-name">Artikel Kesehatan</h3>
                <div class="title-separator mx-auto"></div>
              </div>
            </div>

            <div class="articles-list d-flex flex-wrap justify-content-center">
              <?php
              include("koneksi.php");
              // Fungsi untuk memotong teks menjadi maksimal 15 kata
              function truncateText($text, $maxWords)
              {
                $words = explode(' ', $text);
                if (count($words) > $maxWords) {
                  $words = array_slice($words, 0, $maxWords);
                  return implode(' ', $words) . '...';
                }
                return $text;
              }
              $sql = "SELECT * FROM artikel_kesehatan ORDER BY TGL_ARTIKEL DESC LIMIT 6";
              $hasil = mysqli_query($con, $sql);
              $jmlatikel = mysqli_num_rows($hasil);
              if ($jmlatikel > 0) {
                while ($row = mysqli_fetch_assoc($hasil)) {
                  $shortText = truncateText($row["ISI_ARTIKEL"], 15);
                  // Ambil gambar dari kolom FOTO_ARTIKEL di database
                  $imageData = $row["FOTO_ARTIKEL"];
                  // Ubah format data base64 ke tag img HTML
                  $imageHTML = '<img src="data:image/jpeg;base64,' . base64_encode($imageData) . '" class="card-img-top" alt="...">';
              ?>
                  <article class="articles-item" style="margin-bottom: 20px;">
                    <div class="item-img">
                      <?php echo $imageHTML; ?>
                    </div>
                    <div class="item-body">
                      <div class="item-title">
                        <?php echo $row["JUDUL_ARTIKEL"]; ?>
                      </div>
                      <p class="text">
                        <?php echo htmlspecialchars($shortText); ?>
                      </p>
                      <a href="artikel-detail.php?id=<?php echo $row['ID_ARTIKEL']; ?>" class="item-link text-blue d-flex align-items-baseline">
                        <span class="item-link-text">Read more</span>
                        <span class="item-link-icon">
                          <i class="fas fa-arrow-right"></i>
                        </span>
                      </a>
                    </div>
                  </article>
              <?php
                }
              }
              ?>
            </div>
          </div>
        </div>
      </section>
    </main>

    <!-- Footer Start -->
    <div class="container-fluid footer py-5 wow fadeIn" data-wow-delay="0.2s">
      <div class="container py-3">
        <div class="row g-2" style="color: white;">
          <div class="col-md-4 col-lg-4 col-xl-4">
            <div class="footer-item ">
              <a href="#" class="navbar-brand d-flex align-items-center">
                <img src="img/smarthealth.png" alt="" width="40" height="40" class="d-inline-block align-text-top" style="margin-right: 5px;" />
                <span class="brand-text fw-7">SmartHealth</span>
              </a>
              <p class="text-white fs-6">
                SmartHealth adalah sebuah platform inovatif yang menghubungkan semua Puskesmas di Sidoarjo dalam mendukung program Smart Village.
                <br>Sistem Informasi UPN Veteran Jawa Timur
              </p>
              <p class="text-white copyright-text fs-6 fw-bold">
                &copy; SmartHealth Core Team LTD 2024. All rights reserved.
              </p>
            </div>
          </div>
          <div class="col-md-3 col-lg-3 col-xl-3">
            <div class="footer-item d-flex flex-column">
              <h4 class="mb-4 text-white fw-7">Quick Links</h4>
              <a href="about_us.php"><i class="fas fa-angle-right me-3"></i> Our Team</a>
            </div>
          </div>
          <div class="col-md-3 col-lg-3 col-xl-3">
            <div class="footer-item d-flex flex-column">
              <h4 class="mb-4 text-white fw-7">Contact Info</h4>
              <a href=""><i class="fa fa-map-marker-alt me-3"></i>UPN "Veteran" Jatim<br>Fakultas Ilmu Komputer<br>Sistem Informasi 2022</a>
            </div>
          </div>
          <div class="col-md-2 col-lg-2 col-xl-2">
            <div class="footer-item d-flex flex-column">
              <p class="text-white fs-5 fw-bold">
                Petugas Puskesmas?
              </p>
              <button type="button" class="btnlogin btn-primary" onclick="window.location.href='adm_login.php'" style="background-color: white; color:#1472f4">
                LOGIN
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="footer-element-1">
      <img src="assets/images/element-img-4.png" alt="" />
    </div>
    <div class="footer-element-2">
      <img src="assets/images/element-img-5.png" alt="" />
    </div>
  </div>

  <!-- jQuery -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <!-- Popper.js -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.11.6/umd/popper.min.js"></script>
  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"></script>
  <!-- Custom JS -->
  <script src="assets/js/main.js"></script>
</body>

</html>