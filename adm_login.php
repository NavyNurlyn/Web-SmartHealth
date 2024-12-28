<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>SmartHealth - Petugas Puskesmas</title>
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

    <!-- Custom CSS -->
    <style>
        .password-wrapper {
            position: relative;
        }

        .password-wrapper .toggle-password {
            position: absolute;
            top: 50%;
            right: 10px;
            transform: translateY(-50%);
            cursor: pointer;
        }
    </style>
</head>

<body>
    <?php
    // Start the session
    session_start();

    // Database connection
    $conn = new mysqli('localhost', 'root', '', 'db_smarthealth3');

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $error_message = '';

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $id_petugas = $_POST['username'];
        $password = $_POST['password'];

        // Sanitize input
        $id_petugas = $conn->real_escape_string($id_petugas);
        $password = $conn->real_escape_string($password);

        // Check credentials
        $sql = "SELECT * FROM petugas WHERE ID_PETUGAS = '$id_petugas' AND PASSWORD = '$password'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // Credentials are correct, redirect to admin page
            // Get id_puskesmas from database based on id_petugas
            $row = $result->fetch_assoc();
            $id_puskesmas = $row['ID_PUSKESMAS'];

            // Save id_puskesmas to session
            $_SESSION['id_puskesmas'] = $id_puskesmas;

            // Redirect to another page after successful login
            header('Location: admin.php');
            exit;
        } else {
            // Credentials are incorrect, display error message
            $error_message = 'ID Petugas atau Password salah.';
        }
    }

    $conn->close();
    ?>

    <div class="container-xxl position-relative bg-white d-flex p-0">
        <!-- Spinner Start -->
        <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        <!-- Spinner End -->

        <!-- Log In Start -->
        <div class="container-fluid">
            <div class="row h-100 align-items-center justify-content-center" style="min-height: 100vh;">
                <div class="col-12 col-sm-8 col-md-6 col-lg-6 col-xl-5 text-center">

                    <p onclick="window.location.href='index.php'" style="color: #009CFF; font-size: 42px; font-weight: bold;">
                        <img class="logo mb-1" src="img\smarthealth.png" alt="SmartHealth Logo" onclick="window.location.href='index.php'" style="width: 100px; height: 100px; margin-right:10px;">
                        SmartHealth
                    </p>
                    <div class="bg-light rounded p-4 p-sm-5 my-2 mx-3">
                        <h3 class="mb-3" style="margin-top: -30px;">Log In</h3>
                        <?php if ($error_message) : ?>
                            <div class="alert alert-danger" role="alert">
                                <?php echo $error_message; ?>
                            </div>
                        <?php endif; ?>
                        <form method="post" action="adm_login.php">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="username" name="username" placeholder="name@example.com">
                                <label for="username" style="color: rgba(0, 0, 0, 0.3);">ID Petugas</label>
                            </div>
                            <div class="form-floating mb-4 password-wrapper">
                                <input type="password" class="form-control" id="password" name="password" placeholder="Password">
                                <label for="password" style="color: rgba(0, 0, 0, 0.3);">Password</label>
                                <i class="bi bi-eye-slash toggle-password" id="togglePassword"></i>
                            </div>
                            <button type="submit" class="btn btn-primary py-3 w-100 mb-4">Log In</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Log In End -->
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

    <!-- Template Javascript -->
    <script src="js/main.js"></script>

    <!-- Custom Javascript -->
    <script>
        document.getElementById('togglePassword').addEventListener('click', function() {
            const passwordField = document.getElementById('password');
            const passwordFieldType = passwordField.getAttribute('type');
            const newType = passwordFieldType === 'password' ? 'text' : 'password';
            passwordField.setAttribute('type', newType);
            this.classList.toggle('bi-eye');
            this.classList.toggle('bi-eye-slash');
        });
    </script>
</body>

</html>