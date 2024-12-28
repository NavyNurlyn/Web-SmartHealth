<?php
include("koneksi.php");

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM puskesmas WHERE ID_PUSKESMAS = '$id'";
    $hasil = mysqli_query($con, $sql);

    if ($hasil && mysqli_num_rows($hasil) > 0) {
        $row = mysqli_fetch_assoc($hasil);
        // Ambil data gambar dari database
        $imageData = $row['FOTO_PUSKESMAS']; // Gambar disimpan dalam kolom 'gambar'
        // Konversi data gambar dari BLOB menjadi format base64
        $gambarBase64 = base64_encode($imageData);
        // Format sumber gambar untuk ditampilkan di tag <img>
        $gambarSrc = 'data:image/jpeg;base64,' . $gambarBase64;
    } else {
        echo "Puskesmas tidak ditemukan.";
        exit;
    }
} else {
    echo "ID Puskesmas tidak disediakan.";
    exit;
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

        <main class="container my-5">
            <div class="card mx-auto" style="max-width: 800px;">
                <div class="card-body text-center" style="margin-left: 40px; margin-right: 40px; margin-top: 40px">
                    <h2 class="card-title fw-bold"><?php echo htmlspecialchars($row['NAMA_PUSKESMAS']); ?></h2>
                    <p class="card-subtitle text-muted mb-3">Jam Buka: <?php echo htmlspecialchars($row['JAM_BUKA']); ?> - <?php echo htmlspecialchars($row['JAM_TUTUP']); ?></p>
                    <img src="<?php echo $gambarSrc; ?>" class="card-img-top mx-auto" alt="Gambar Puskesmas" style="width: 500px; height: auto; margin-top: 40px; margin-bottom: 40px">
                    <div class="text-start">
                        <p class="card-text mt-3"><strong>Alamat:</strong> <?php echo htmlspecialchars($row['ALAMAT_PUSKESMAS']); ?></p>
                        <p class="card-text"><strong>Telepon:</strong> <?php echo htmlspecialchars($row['TELP_PUSKESMAS']); ?></p>
                        <p class="card-text"><strong>Koordinat:</strong> <?php echo htmlspecialchars($row['KOORDINAT_LINTANG']); ?>, <?php echo htmlspecialchars($row['KOORDINAT_BUJUR']); ?></p>
                        <p class="card-text"><strong>Deskripsi:</strong> <?php echo nl2br(htmlspecialchars($row['DESKRIPSI_PUSKESMAS'])); ?></p>
                    </div>
                </div>
            </div>
        </main>
</body>

</html>