<?php
include("koneksi.php");

$sql = "SELECT * FROM puskesmas ORDER BY ID_PUSKESMAS ASC";
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
    <!-- normalize.css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/8.0.1/normalize.min.css" integrity="sha512-NhSC1YmyruXifcj/KFRWoC561YpHpc5Jtzgvbuzx5VozKpWvQ+4nXhPdFgmx8xqexRcpAglTj9sIBWINXa8x5w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        .responsive-cell-block {
            min-height: 75px;
        }

        .text-blk {
            margin-top: 0px;
            margin-right: 0px;
            margin-bottom: 0px;
            margin-left: 0px;
            line-height: 25px;
        }

        .responsive-container-block {
            min-height: 75px;
            height: fit-content;
            width: 100%;
            display: flex;
            flex-wrap: wrap;
            margin-top: 0px;
            margin-right: 0px;
            margin-bottom: 0px;
            margin-left: 0px;
            justify-content: space-evenly;
        }

        .team-head-text {
            font-size: 39px;
            font-weight: 900;
            text-align: center;
        }

        .team-head-text {
            line-height: 50px;
            width: 100%;
            margin-top: 0px;
            margin-right: 0px;
            margin-bottom: 50px;
            margin-left: 0px;
        }

        .container {
            max-width: 1380px;
            margin-top: 60px;
            margin-right: auto;
            margin-bottom: 60px;
            margin-left: auto;
            padding-top: 0px;
            padding-right: 30px;
            padding-bottom: 0px;
            padding-left: 30px;
        }

        .card {
            text-align: center;
            box-shadow: rgba(0, 0, 0, 0.05) 0px 4px 20px 7px;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding-top: 30px;
            padding-right: 25px;
            padding-bottom: 30px;
            padding-left: 25px;
            height: 450px;
        }

        .card-container {
            width: 350px;
            margin-top: 0px;
            margin-right: 10px;
            margin-bottom: 25px;
            margin-left: 10px;
        }

        .name {
            margin-top: 20px;
            margin-right: 0px;
            margin-bottom: 5px;
            margin-left: 0px;
            font-size: 18px;
            font-weight: 800;
        }

        .position {
            margin-top: 0px;
            margin-right: 0px;
            margin-bottom: 10px;
            margin-left: 0px;
        }

        .feature-text {
            margin-top: 0px;
            margin-right: 0px;
            margin-bottom: 20px;
            margin-left: 0px;
            color: rgb(122, 122, 122);
            line-height: 10px;
        }

        .social-icons {
            width: 70px !important;
            display: flex;
            justify-content: space-between;
        }

        .team-image-wrapper {
            clip-path: circle(50% at 50% 50%);
            width: 170px;
            height: 170px;
        }

        .team-member-image {
            max-width: 100%;
        }

        @media (max-width: 500px) {
            .card-container {
                width: 100%;
                margin-top: 0px;
                margin-right: 0px;
                margin-bottom: 25px;
                margin-left: 0px;
            }
        }
    </style>
    <!-- custom css -->
    <link rel="stylesheet" href="assets/css/pendaftaran-pilihpuskesmas.css" />
    <link rel="stylesheet" href="assets/css/utilities.css" />
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
        <!-- navigasi -->
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
                        <a href="artikel.php" class="nav-link" aria-current="page">Artikel</a>
                        <a href="pengumuman.php" class="nav-link" aria-current="page">Pengumuman</a>
                        <a href="index.php#infodarurat" class="nav-link" aria-current="page">Info Layanan Darurat</a>
                    </div>
                </div>
            </div>
        </nav>
        <!-- navigasi -->
        <div class="responsive-container-block container">
            <p class="text-blk team-head-text">
                Meet Our Team
            </p>
            <div class="responsive-container-block">
                <div class="responsive-cell-block wk-desk-3 wk-ipadp-3 wk-tab-6 wk-mobile-12 card-container">
                    <div class="card">
                        <div class="team-image-wrapper">
                            <img class="team-member-image" src="img/anis.jpg">
                        </div>
                        <p class="text-blk name">
                            Fathimatus Zahrotun Nisa'
                        </p>
                        <p class="text-blk position">
                            22082010156
                        </p>
                        <p class="text-blk feature-text">
                            Undergraduate Information System
                        </p>
                        <p class="text-blk feature-text" style="line-height: 20px; font-size:12px;">
                            "It's okay, sometimes you just need to give yourself a break."
                        </p>
                        <div class="social-icons">
                            <a href="mailto:22082010156@student.upnjatim.ac.id" target="_blank" style="margin-right: 10px">
                                <img class="email-icon" src="https://img.icons8.com/?size=100&id=85500&format=png&color=000000">
                            </a>
                            <a href="https://linkedin.com/in/fathimatuszn" target="_blank">
                                <img class="linkedin-icon" src="https://img.icons8.com/?size=100&id=8808&format=png&color=000000">
                            </a>
                        </div>
                    </div>
                </div>
                <div class="responsive-cell-block wk-desk-3 wk-ipadp-3 wk-tab-6 wk-mobile-12 card-container">
                    <div class="card">
                        <div class="team-image-wrapper">
                            <img class="team-member-image" src="img/ganes.jpg">
                        </div>
                        <p class="text-blk name">
                            Ganes Dwi Febrianti
                        </p>
                        <p class="text-blk position">
                            22082010157
                        </p>
                        <p class="text-blk feature-text">
                            Undergraduate Information System
                        </p>
                        <p class="text-blk feature-text" style="line-height: 20px; font-size:12px;">
                            "berpikirlah sebelum berbicara, jangan berbicara sebelum berpikir"
                        </p>
                        <div class="social-icons">
                            <a href="mailto:22082010157@student.upnjatim.ac.id" target="_blank" style="margin-right: 10px">
                                <img class="email-icon" src="https://img.icons8.com/?size=100&id=85500&format=png&color=000000">
                            </a>
                            <a href="https://www.linkedin.com/in/ganes-dwi-50a945269?trk=contact-info" target="_blank">
                                <img class="linkedin-icon" src="https://img.icons8.com/?size=100&id=8808&format=png&color=000000">
                            </a>
                        </div>
                    </div>
                </div>
                <div class="responsive-cell-block wk-desk-3 wk-ipadp-3 wk-tab-6 wk-mobile-12 card-container">
                    <div class="card">
                        <div class="team-image-wrapper">
                            <img class="team-member-image" src="img/navy.jpg">
                        </div>
                        <p class="text-blk name">
                            Navy Nurlyn Ajrina
                        </p>
                        <p class="text-blk position">
                            22082010158
                        </p>
                        <p class="text-blk feature-text">
                            Undergraduate Information System
                        </p>
                        <p class="text-blk feature-text" style="line-height: 20px; font-size:12px;">
                            "Setiap baris kode adalah peluang untuk tumbuh, berinovasi, dan menghadirkan solusi yang bermakna"
                        </p>
                        <div class="social-icons">
                            <a href="mailto:22082010158@student.upnjatim.ac.id" target="_blank" style="margin-right: 10px">
                                <img class="email-icon" src="https://img.icons8.com/?size=100&id=85500&format=png&color=000000">
                            </a>
                            <a href="https://linkedin.com/in/navynurlyn" target="_blank">
                                <img class="linkedin-icon" src="https://img.icons8.com/?size=100&id=8808&format=png&color=000000">
                            </a>
                        </div>
                    </div>
                </div>
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