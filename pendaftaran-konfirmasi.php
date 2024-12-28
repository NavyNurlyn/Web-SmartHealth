<?php
include("koneksi.php"); // Pastikan koneksi ke database sudah ada di file koneksi.php

if (isset($_GET['id_poli']) && isset($_GET['tanggal']) && isset($_GET['total_antrian'])) {
    $id_poli = $_GET['id_poli'];
    $tanggal = $_GET['tanggal'];
    $total_antrian = $_GET['total_antrian'];

    // Mendapatkan informasi poli dan puskesmas
    $sql_poli = "SELECT p.ID_PUSKESMAS, p.NAMA_POLI, pusk.NAMA_PUSKESMAS, pusk.ALAMAT_PUSKESMAS, pusk.TELP_PUSKESMAS 
    FROM poli p JOIN puskesmas pusk ON p.ID_PUSKESMAS = pusk.ID_PUSKESMAS WHERE p.ID_POLI = ?";
    $stmt_poli = $con->prepare($sql_poli);
    $stmt_poli->bind_param("s", $id_poli);
    $stmt_poli->execute();
    $hasil_poli = $stmt_poli->get_result();

    if ($hasil_poli->num_rows > 0) {
        $row_poli = $hasil_poli->fetch_assoc();
        $id_puskesmas = $row_poli['ID_PUSKESMAS'];
        $nama_poli = $row_poli['NAMA_POLI'];
        $nama_puskesmas = $row_poli['NAMA_PUSKESMAS'];
        $alamat_puskesmas = $row_poli['ALAMAT_PUSKESMAS'];
        $telepon_puskesmas = $row_poli['TELP_PUSKESMAS'];
    } else {
        echo "Informasi Poli atau Puskesmas tidak ditemukan.";
        exit;
    }
} else {
    echo "Data tidak lengkap.";
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nik = $_POST['nik'];
    $waktu_daftar = date('Y-m-d H:i:s');
    $nomor_antrian = $total_antrian + 1;

    // Mendapatkan informasi pasien
    $sql_pasien = "SELECT NAMA_PASIEN, ASURANSI FROM pasien WHERE NIK_PASIEN = ?";
    $stmt_pasien = $con->prepare($sql_pasien);
    $stmt_pasien->bind_param("s", $nik);
    $stmt_pasien->execute();
    $hasil_pasien = $stmt_pasien->get_result();

    if ($hasil_pasien->num_rows > 0) {
        $row_pasien = $hasil_pasien->fetch_assoc();
        $nama_pasien = $row_pasien['NAMA_PASIEN'];
        $asuransi_pasien = $row_pasien['ASURANSI'];
    } else {
        echo "Informasi Pasien tidak ditemukan.";
        exit;
    }

    // Menghitung estimasi waktu berdasarkan nomor antrian
    $slot_duration_minutes = 10;
    $start_time = strtotime("07:00");
    $estimasi_start_time = date("H:i", strtotime("+" . ($slot_duration_minutes * ($nomor_antrian - 1)) . " minutes", $start_time));
    $estimasi_end_time = date("H:i", strtotime("+" . ($slot_duration_minutes * $nomor_antrian) . " minutes", $start_time));
    $estimasi_waktu = $estimasi_start_time . " - " . $estimasi_end_time;

    $status = 1;

    // Generate ID Antrian
    function generateAntrianID($id_puskesmas, $tanggal, $id_poli, $nomor_antrian)
    {
        // Ambil 2 digit terakhir dari ID_PUSKESMAS
        $puskesmas_suffix = substr($id_puskesmas, -2);

        // Ambil 2 digit terakhir dari ID_POLI
        $poli_suffix = substr($id_poli, -2);

        // Format tanggal (YYYYMMDD)
        $tanggal_formatted = date('Ymd', strtotime($tanggal));

        // Format nomor antrian menjadi 3 digit
        $antrian_number = str_pad($nomor_antrian, 3, '0', STR_PAD_LEFT);

        // Buat ID antrian dengan format yang diinginkan
        $id_antrian = "ANT" . $puskesmas_suffix . $tanggal_formatted . $poli_suffix . $antrian_number;

        return $id_antrian;
    }

    $id_antrian = generateAntrianID($id_puskesmas, $tanggal, $id_poli, $nomor_antrian);

    // Simpan data ke database
    $sql_simpan = "INSERT INTO antrian (ID_ANTRIAN, ID_POLI, NIK_PASIEN, WAKTU_DAFTAR, HARI_TGL, NOMOR_ANTRIAN, ESTIMASI_WAKTU, STATUS) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt_simpan = $con->prepare($sql_simpan);
    $stmt_simpan->bind_param("ssssssss", $id_antrian, $id_poli, $nik, $waktu_daftar, $tanggal, $nomor_antrian, $estimasi_waktu, $status);

    if ($stmt_simpan->execute()) {
        // Tentukan nilai notaPenjaminan berdasarkan nilai asuransi_pasien
        if ($asuransi_pasien == 1) {
            $notaPenjaminan = "BPJS";
        } elseif ($asuransi_pasien == 2) {
            $notaPenjaminan = "Asuransi Lain";
        } else {
            $notaPenjaminan = "Lainnya";
        }
        echo "<script>
            var puskesmas = '" . $nama_puskesmas . "';
            var alamat = '" . $alamat_puskesmas . "';
            var telepon = '" . $telepon_puskesmas . "';
            var poli = '" . $nama_poli . "';
            var nomorAntrian = '" . $nomor_antrian . "';
            var idAntrian = '" . $id_antrian . "';
            var nik = '" . $nik . "';
            var namaPasien = '" . $nama_pasien . "';
            var tanggalKunjungan = '" . date('l, d F Y', strtotime($tanggal)) . "';
            var waktuEstimasi = '" . $estimasi_waktu . "';
            var penjaminan = '" . $notaPenjaminan . "';

            window.onload = function() {
                document.getElementById('notaPuskesmas').innerText = puskesmas;
                document.getElementById('notaAlamat').innerText = alamat;
                document.getElementById('notaTelepon').innerText = telepon;
                document.getElementById('notaPoli').innerText = poli;
                document.getElementById('notaNomorAntrian').innerText = nomorAntrian;
                document.getElementById('notaIDAntrian').innerText = idAntrian;
                document.getElementById('notaNIK').innerText = nik;
                document.getElementById('notaNamaPasien').innerText = namaPasien;
                document.getElementById('notaTanggalKunjungan').innerText = tanggalKunjungan;
                document.getElementById('notaWaktuEstimasi').innerText = waktuEstimasi;
                document.getElementById('notaPenjaminan').innerText = penjaminan;
                var notaModal = new bootstrap.Modal(document.getElementById('notaModal'));
                notaModal.show();
            }
        </script>";
    } else {
        echo "Terjadi kesalahan saat menyimpan data.";
    }
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
                        <a href="pendaftaran-pilihpuskesmas.php" class="nav-link active" aria-current="page">Pendaftaran</a>
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
                <div class="container">
                    <div class="title-box text-center">
                        <div class="content-wrapper">
                            <h5 class="title-box-name" style="font-size: 31px;">Konfirmasi Pendaftaran</h5>
                            <div class="title-separator mx-auto"></div>
                        </div>
                    </div>

                    <form method="POST" action="pendaftaran-konfirmasi.php?id_poli=<?php echo $id_poli; ?>&tanggal=<?php echo $tanggal; ?>&total_antrian=<?php echo $total_antrian; ?>">
                        <div class="mb-3">
                            <label for="nik" class="form-label">NIK</label>
                            <input type="text" class="form-control" id="nik" name="nik" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Tanggal Layanan</label>
                            <input type="text" class="form-control" value="<?php echo date('l, d F Y', strtotime($tanggal)); ?>" disabled>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Nama Puskesmas</label>
                            <input type="text" class="form-control" value="<?php echo htmlspecialchars($nama_puskesmas); ?>" disabled>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Nama Poli</label>
                            <input type="text" class="form-control" value="<?php echo htmlspecialchars($nama_poli); ?>" disabled>
                        </div>
                        <button type="submit" class="btn btn-primary">Daftar Sekarang</button>
                    </form>
                </div>
            </section>
        </main>
        <!-- Modal -->
        <div class="modal fade" id="notaModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Nota Pendaftaran Antrian Puskesmas</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="container">
                            <h5 class="modal-title text-center" id="exampleModalLabel">
                                <span class="fw-bold" style="font-size: 24px;" id="notaPuskesmas"></span>
                                <p class="text-muted" style="font-size: 16px;" id="notaAlamat"></p>
                                <p class="text-muted" style="font-size: 16px;" id="notaTelepon"></p>
                                <h2 class="fw-bold text-center" style="font-size: 50px;" id="notaNomorAntrian"></h2>
                            </h5>
                            <p>

                            </p>
                            <div class="row">
                                <div class="col-6">
                                    <p class="fw-bold">Poli:</p>
                                </div>
                                <div class="col-6">
                                    <p id="notaPoli"></p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <p class="fw-bold">ID Antrian:</p>
                                </div>
                                <div class="col-6">
                                    <p id="notaIDAntrian"></p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <p class="fw-bold">NIK:</p>
                                </div>
                                <div class="col-6">
                                    <p id="notaNIK"></p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <p class="fw-bold">Nama Pasien:</p>
                                </div>
                                <div class="col-6">
                                    <p id="notaNamaPasien"></p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <p class="fw-bold">Tanggal Kunjungan:</p>
                                </div>
                                <div class="col-6">
                                    <p id="notaTanggalKunjungan"></p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <p class="fw-bold">Waktu Estimasi:</p>
                                </div>
                                <div class="col-6">
                                    <p id="notaWaktuEstimasi"></p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <p class="fw-bold">Penjaminan:</p>
                                </div>
                                <div class="col-6">
                                    <p id="notaPenjaminan"></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal" id="closeModalButton">Tutup</button>
                        <button type="button" class="btn btn-primary" onclick="window.print()">Print</button>
                    </div>
                </div>
            </div>
        </div>
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
    </div>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Popper.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.11.6/umd/popper.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"></script>
    <!-- Custom JS -->
    <script src="assets/js/main.js"></script>
    <!-- JavaScript Libraries -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js" integrity="sha512-oTG5FgQjW4HfMB7qfzTLm7h0yvbW4IpeHczLUSfKgBpwrE1oZJp4qFNtTTl6HdVPm9Y7h4qzr+U+fsYfUXBvBw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js" integrity="sha512-YDh3ZU04UTfUd6+Yqte8QokGTBgYklgFe9HzYoe4uC9IjcT2U+3I+4f5DEi+bZZtMwVL3CM+QbCqPhQ/Ekwd8g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.js" integrity="sha512-p1LGaRzCgHTwN1TnlByCEIeUViGHPduDmb72hA1XvFCpjXfjMYxz1yTLmEqexqU9P9j2QXvXvB5VuDAs5qUsSA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-kQtW33rZJAHjgefvhyyzcGF6F7VD1Pj8aTVWkh9P7bYlJJANJ6Sm2fcQNfFQKukW" crossorigin="anonymous"></script>
    <script>
        document.getElementById('closeModalButton').addEventListener('click', function() {
            window.location.href = 'pendaftaran.php';
        });
    </script>
</body>

</html>