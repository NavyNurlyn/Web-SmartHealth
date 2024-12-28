<?php
include("koneksi.php");

$nik = "";
if (isset($_GET['nik'])) {
    $nik = $_GET['nik'];
} elseif (isset($_POST['cari'])) {
    $nik = $_POST['nik'];
}

if (!empty($nik)) {
    $sql = "SELECT antrian.ID_ANTRIAN, puskesmas.NAMA_PUSKESMAS, poli.NAMA_POLI, antrian.WAKTU_DAFTAR, antrian.HARI_TGL, antrian.NOMOR_ANTRIAN 
    FROM antrian 
    JOIN poli ON antrian.ID_POLI = poli.ID_POLI 
    JOIN puskesmas ON poli.ID_PUSKESMAS = puskesmas.ID_PUSKESMAS
    WHERE antrian.NIK_PASIEN = '$nik' AND antrian.STATUS = '1'";
    $hasil = mysqli_query($con, $sql);
}
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
    <link rel="stylesheet" href="assets/css/pendaftaran-pilihpuskesmas.css" />
    <link rel="stylesheet" href="assets/css/utilities.css" />
    <!-- normalize.css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/8.0.1/normalize.min.css" integrity="sha512-NhSC1YmyruXifcj/KFRWoC561YpHpc5Jtzgvbuzx5VozKpWvQ+4nXhPdFgmx8xqexRcpAglTj9sIBWINXa8x5w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        .btn-small {
            padding: 0.25rem 0.5rem;
            font-size: 0.875rem;
            width: 50px;

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
                        <a href="pendaftaran.php" class="nav-link active" aria-current="page">Pendaftaran</a>
                        <a href="artikel.php" class="nav-link" aria-current="page">Artikel</a>
                        <a href="pengumuman.php" class="nav-link" aria-current="page">Pengumuman</a>
                        <a href="index.php#infodarurat" class="nav-link" aria-current="page">Info Layanan Darurat</a>
                    </div>
                </div>
            </div>
        </nav>
        <!-- navigasi -->
        <main>
            <section id="artikel" class="sc-articles">
                <div class="articles-shape">
                    <img src="assets/images/curve-shape-2.png" alt="" />
                </div>
                <div class="container">
                    <div class="articles-element">
                        <img src="assets/images/element-img-2.png" alt="" />
                    </div>
                    <div class="title-box text-center">
                        <div class="content-wrapper">
                            <h5 class="title-box-name" style="font-size: 31px;">Batalkan Antrian Online</h5>
                            <div class="title-separator mx-auto"></div>
                        </div>
                    </div>
                    <div class="container">
                        <form method="post" action="">
                            <div class="mb-3">
                                <label for="nik" class="form-label fw-7">NIK</label>
                                <input type="text" class="form-control" id="nik" name="nik" value="<?php echo htmlspecialchars($nik); ?>" required>
                            </div>
                            <button type="submit" name="cari" class="btn btn-primary btn-sm">Cari</button>
                        </form>
                        <div class="tabelantriansaya text-center">
                            <?php if (!empty($nik) && isset($hasil) && mysqli_num_rows($hasil) > 0) : ?>
                                <table class="table mt-5">
                                    <thead>
                                        <tr>
                                            <th scope="col">ID Antrian</th>
                                            <th scope="col">Nama Puskesmas</th>
                                            <th scope="col">Nama Poli</th>
                                            <th scope="col">Tanggal Daftar</th>
                                            <th scope="col">Hari / Tanggal</th>
                                            <th scope="col">Nomor Antrian</th>
                                            <th scope="col">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php while ($row = mysqli_fetch_assoc($hasil)) : ?>
                                            <tr>
                                                <td><?php echo $row['ID_ANTRIAN']; ?></td>
                                                <td><?php echo $row['NAMA_PUSKESMAS']; ?></td>
                                                <td><?php echo $row['NAMA_POLI']; ?></td>
                                                <td><?php echo $row['WAKTU_DAFTAR']; ?></td>
                                                <td><?php echo $row['HARI_TGL']; ?></td>
                                                <td><?php echo $row['NOMOR_ANTRIAN']; ?></td>
                                                <td>
                                                    <form method="post" action="proses_batal.php" style="display:inline;">
                                                        <input type="hidden" name="id_antrian" value="<?php echo $row['ID_ANTRIAN']; ?>">
                                                        <input type="hidden" name="nik" value="<?php echo $nik; ?>">
                                                        <button type="submit" class="btn btn-secondary btn-small" style="max-width: 20px !important;">Batalkan</button>
                                                    </form>
                                                </td>
                                            </tr>
                                        <?php endwhile; ?>
                                    </tbody>
                                </table>
                            <?php elseif (!empty($nik)) : ?>
                                <p class="mt-5">Tidak ada antrian yang ditemukan untuk NIK ini.</p>
                            <?php endif; ?>
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
        <!-- footer end -->
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