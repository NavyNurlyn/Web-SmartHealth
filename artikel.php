<?php
include("koneksi.php");

function truncateText($text, $maxWords)
{
    $words = explode(' ', $text);
    if (count($words) > $maxWords) {
        $words = array_slice($words, 0, $maxWords);
        return implode(' ', $words) . '...';
    }
    return $text;
}
$sql = "SELECT * FROM artikel_kesehatan ORDER BY TGL_ARTIKEL DESC";
$hasil = mysqli_query($con, $sql);

?>

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
    <link rel="stylesheet" href="assets/css/artikel.css" />
    <link rel="stylesheet" href="assets/css/utilities.css" />
    <!-- normalize.css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/8.0.1/normalize.min.css" integrity="sha512-NhSC1YmyruXifcj/KFRWoC561YpHpc5Jtzgvbuzx5VozKpWvQ+4nXhPdFgmx8xqexRcpAglTj9sIBWINXa8x5w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        .btn {
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

        .btn:hover {
            color: var(--clr-white);
            background-color: #1472f4;
            box-shadow: rgba(17, 17, 26, 0.1) 0px 8px 24px, rgba(17, 17, 26, 0.1) 0px 16px 56px, rgba(17, 17, 26, 0.1) 0px 24px 80px;
        }
    </style>
</head>

<body>
    <div class="page-wrapper">
        <!-- navigasi start-->
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
                        <a href="index.php" class="nav-link" aria-current="page">Beranda</a>
                        <a href="pendaftaran.php" class="nav-link" aria-current="page">Pendaftaran</a>
                        <a href="artikel.php" class="nav-link active" aria-current="page">Artikel</a>
                        <a href="pengumuman.php" class="nav-link" aria-current="page">Pengumuman</a>
                        <a href="index.php#infodarurat" class="nav-link" aria-current="page">Info Layanan Darurat</a>
                    </div>
                </div>
            </div>
        </nav>
        <!-- navigasi end-->
        <main>
            <section id="artikelutama" class="artikelutama">
                <div class="artikelutama-shape">
                    <img src="assets/images/curve-shape-1.png" alt="" />
                </div>
                <div class="container">
                    <div class="artikelutama-content">
                        <div class="title-box text-center">
                            <div class="content-wrapper">
                                <h3 class="title-box-name fs-2">Artikel Seputar Kesehatan</h3>
                                <div class="title-separator mx-auto"></div>
                                <p class="text title-box-text">
                                    Lihat dan baca artikel seputar Kesehatan yang bermanfaat untuk kesehatan keluarga Anda. Kami menyediakan berbagai artikel kesehatan yang Up to Date untuk Anda
                                </p>
                            </div>
                        </div>
                        <div class="carousel-container">
                            <div id="carouselExampleCaptions" class="carousel slide">
                                <div class="carousel-indicators">
                                    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                                    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1" aria-label="Slide 2"></button>
                                    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2" aria-label="Slide 3"></button>
                                </div>
                                <div class="carousel-inner">
                                    <div class="carousel-item active">
                                        <img src="assets/images/artikel/corouselslide1.jpg" class="d-block w-90" style="max-width: 65%;" alt="...">
                                        <div class="carousel-caption d-none d-md-block">
                                            <h5>Belajar Dari Warga Blue Zone</h5>
                                            <p>Konsumsi Minuman Ini untuk Hidup Sehat-Panjang Umur</p>
                                        </div>
                                    </div>
                                    <div class="carousel-item">
                                        <img src="assets/images/artikel/corouselslide2.jpg" class="d-block w-90" style="max-width: 65%;" alt="...">
                                        <div class="carousel-caption d-none d-md-block">
                                            <h5>Gula penyebab utama Diabetes</h5>
                                            <p>Waspadai bahaya gula dan kontrol konsumsi gula Anda</p>
                                        </div>
                                    </div>
                                    <div class="carousel-item">
                                        <img src="assets/images/artikel/corouselslide3.jpg" class="d-block w-90" style="max-width: 65%;" alt="...">
                                        <div class="carousel-caption d-none d-md-block">
                                            <h5>Makanan Pencegah Kanker</h5>
                                            <p>Makanan rendah lemak bermanfaat untuk mencegah kanker</p>
                                        </div>
                                    </div>
                                </div>
                                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Previous</span>
                                </button>
                                <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Next</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
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
                                <h5 class="title-box-name fs-2">Artikel Kesehatan Terbaru</h5>
                                <div class="title-separator mx-auto"></div>
                            </div>
                        </div>

                        <div class="row row-cols-1 row-cols-md-3 g-4">
                            <?php
                            if (mysqli_num_rows($hasil) > 0) {
                                while ($row = mysqli_fetch_assoc($hasil)) {
                                    $shortText = truncateText($row["ISI_ARTIKEL"], 15);
                                    // Ambil gambar dari kolom FOTO_PENGUMUMAN di database
                                    $imageData = $row["FOTO_ARTIKEL"];
                                    // Ubah format data base64 ke tag img HTML
                                    $imageHTML = '<img src="data:image/jpeg;base64,' . base64_encode($imageData) . '" class="card-img-top" alt="...">';
                            ?>
                                    <div class="col">
                                        <div class="card">
                                            <?php echo $imageHTML; ?>
                                            <div class="card-body">
                                                <h5 class="card-title"><?php echo $row["JUDUL_ARTIKEL"]; ?></h5>
                                                <p class="card-text"><?php echo htmlspecialchars($shortText); ?></p>
                                                <a href="artikel-detail.php?id=<?php echo $row['ID_ARTIKEL']; ?>" class="item-link text-blue d-flex align-items-baseline">
                                                    <span class="item-link-text">Read more </span>
                                                    <span class="item-link-icon">
                                                        <i class="fas fa-arrow-right"></i>
                                                    </span>
                                                </a>
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
                            <button type="button" class="btn btn-primary" onclick="window.location.href='adm_login.php'" style="background-color: white; color:#1472f4">
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
        </footer>
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