<?php
// Include file config.php yang berisi fungsi-fungsi penting
require_once 'config.php';

// Mengambil id_puskesmas dari session
$id_puskesmas = ambil_session('id_puskesmas');

// Membuat koneksi ke database
$conn = buat_koneksi();

// Query untuk mengambil nama puskesmas berdasarkan id_puskesmas
$query = "SELECT NAMA_PUSKESMAS FROM puskesmas WHERE ID_PUSKESMAS = '$id_puskesmas'";
$result = mysqli_query($conn, $query);

// Memeriksa apakah query berhasil dieksekusi
if ($result) {
    // Mendapatkan baris hasil query
    $row = mysqli_fetch_assoc($result);
    // Mengambil nama puskesmas
    $nama_puskesmas = $row['NAMA_PUSKESMAS'];
} else {
    // Jika query gagal dieksekusi
    $nama_puskesmas = "Nama Puskesmas Tidak Ditemukan";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>SmartHealth - Pendaftaran Puskesmas Online</title>
    <link rel="icon" type="image/png" href="img\smarthealth.png">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css" rel="stylesheet" />

    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="css/style.css" rel="stylesheet">

    <!-- Google Charts -->
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <!-- jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <!-- Script -->
    <script src="js/main.js"></script>
</head>

<body>
    <div class="container-xxl position-relative bg-white d-flex p-0">
        <!-- Spinner Start -->
        <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        <!-- Spinner End -->

        <!-- Sidebar Start -->
        <div class="sidebar pe-4 pb-3">
            <nav class="navbar bg-light navbar-light">
                <a href="admin.php" class="navbar-brand mx-4 mb-3" style="border-bottom: #009CFF solid 2px; margin-top : 6px;">
                    <p style="color : #009CFF; font-size: 22px; font-weight: bold;"><img class="logo" src="img\smarthealth.png" alt="" style="width: 60px; height: 60px; margin-right: 6px;">
                        SmartHealth</p>
                </a>
                <div class="d-flex align-items-center ms-4 mb-4">
                    <div class="position-relative">
                        <div style="display: flex; justify-content: center; align-items: center; width: 50px; height: 50px; border: 1.5px solid #000; border-radius: 50%;">
                            <i class="fa fa-user-md me-2" style="font-size: 30px; color: #333; margin-left: 8px;"></i>
                        </div>
                    </div>
                    <div class="ms-3">
                        <h6 class="mb-0"><?php echo $nama_puskesmas; ?></h6>
                        <span>Admin</span>
                    </div>
                </div>

                <div class="navbar-nav w-100" style="margin-top: -10px;">
                    <?php
                    $page = isset($_GET['page']) ? $_GET['page'] : 'dashboard';
                    ?>
                    <a href="admin.php?page=dashboard" class="nav-item nav-link <?php echo $page == 'dashboard' ? 'active' : ''; ?>"><i class="fa fa-tachometer-alt me-2"></i>Dashboard</a>
                    <a href="admin.php?page=puskesmas" class="nav-item nav-link <?php echo $page == 'puskesmas' ? 'active' : ''; ?>"><i class="fa fa-clinic-medical me-2"></i>Puskesmas</a>
                    <a href="admin.php?page=riwayat" class="nav-item nav-link <?php echo $page == 'riwayat' ? 'active' : ''; ?>"><i class="fa fa-history me-2"></i>Riwayat</a>
                    <a href="admin.php?page=antrian" class="nav-item nav-link <?php echo $page == 'antrian' ? 'active' : ''; ?>"><i class="fa fa-edit me-2"></i>Proses Antrian</a>
                    <a href="admin.php?page=artikel" class="nav-item nav-link <?php echo $page == 'artikel' ? 'active' : ''; ?>"><i class="fa fa-newspaper me-2"></i>Artikel</a>
                    <a href="admin.php?page=pengumuman" class="nav-item nav-link <?php echo $page == 'pengumuman' ? 'active' : ''; ?>"><i class="fa fa-bullhorn me-2"></i>Pengumuman</a>
                    <a href="adm_logout.php" class="nav-item nav-link"><i class="fa fa-sign-out-alt me-2"></i>Logout</a>
                </div>
            </nav>
        </div>
        <!-- Sidebar End -->

        <!-- Content Start -->
        <div class="content">
            <!-- Navbar Start -->
            <nav class="navbar navbar-expand bg-light navbar-light sticky-top px-4 py-0">
                <a href="admin.php" class="navbar-brand d-flex d-lg-none me-4">
                    <h2 class="text-primary mb-0"><i class="fa fa-hashtag"></i></h2>
                </a>
                <a href="#" class="sidebar-toggler flex-shrink-0">
                    <i class="fa fa-bars"></i>
                </a>
                <div class="header" style="padding-left: 60px; margin-left: auto; margin-right: auto; width: fit-content;">
                    <h3 style="color: #009CFF;">SmartHealth Kabupaten Sidoarjo | <?php echo $nama_puskesmas; ?></h3>
                </div>
                <div class="navbar-nav align-items-center ms-auto">
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                            <img class="rounded-circle me-lg-2" src="img/user.png" alt="" style="width: 40px; height: 40px;">
                        </a>
                        <div class="dropdown-menu dropdown-menu-end bg-light border-0 rounded-0 rounded-bottom m-0">
                            <a href="admin.php?page=puskesmas" class="dropdown-item"> Detail Puskesmas</a>
                            <a href="adm_logout.php" class="dropdown-item">Log Out</a>
                        </div>
                    </div>
                </div>
            </nav>
            <!-- Navbar End -->

            <!-- Content -->
            <?php
            // Default page
            $page = 'dashboard';
            // Check if 'page' parameter exists in the URL
            if (isset($_GET['page'])) {
                $page = $_GET['page'];
            }

            // Include the corresponding file based on the value of 'page' parameter
            switch ($page) {
                case 'puskesmas':
                    include 'adm_puskesmas.php';
                    break;
                case 'riwayat':
                    include 'adm_riwayat.php';
                    break;
                case 'antrian':
                    include 'adm_antrian.php';
                    break;
                case 'artikel':
                    include 'adm_artikel.php';
                    break;
                case 'pengumuman':
                    include 'adm_pengumuman.php';
                    break;
                default:
                    include 'adm_dashboard.php';
                    break;
            }
            ?>

            <!-- Footer Start -->
            <div class="container-fluid pt-4 px-4">
                <div class="bg-light rounded-top p-4">
                    <div class="row">
                        <div class="col-12 col-sm-6 text-center text-sm-start">
                            &copy; <a href="#">SmartHealth</a>, All Right Reserved.
                        </div>
                        <div class="col-12 col-sm-6 text-center text-sm-end" style="font-size: 3px;">
                            <!-- /*** This template is free as long as you keep the footer author’s credit link/attribution link/backlink. If you'd like to use the template without the footer author’s credit link/attribution link/backlink, you can purchase the Credit Removal License from "https://htmlcodex.com/credit-removal". Thank you for your support. ***/ -->
                            Designed By <a href="https://htmlcodex.com">HTML Codex</a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Footer End -->
        </div>
        <!-- Content End -->

        <!-- Back to Top -->
        <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>
    </div>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="lib/chart/chart.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="lib/tempusdominus/js/moment.min.js"></script>
    <script src="lib/tempusdominus/js/moment-timezone.min.js"></script>
    <script src="lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js"></script>

    <!-- Javascript -->
    <script src="js/main.js"></script>
</body>

</html>