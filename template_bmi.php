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
  <!-- custom css -->
  <link rel="stylesheet" href="assets/css/pendaftaran-pilihpuskesmas.css" />
  <link rel="stylesheet" href="assets/css/utilities.css" />
  <!-- normalize.css -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/8.0.1/normalize.min.css" integrity="sha512-NhSC1YmyruXifcj/KFRWoC561YpHpc5Jtzgvbuzx5VozKpWvQ+4nXhPdFgmx8xqexRcpAglTj9sIBWINXa8x5w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <style>
    @import url("https://fonts.googleapis.com/css2?family=Jost:wght@400;500;600&display=swap");

    :root {
      --underweight: orange;
      --normal: green;
      --overweight: lightcoral;
      --obese: crimson;
    }

    * {
      box-sizing: border-box;
      padding: 0;
      margin: 0;
      font-family: "Jost", sans-serif;
    }

    body {
      background: linear-gradient(to right, #479ED0, #274EAC);
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      margin: 0;
      padding: 0;
    }

    .main-container {
      width: 100%;
      max-width: 1200px;
      display: flex;
      color: #000000;
    }

    .description {
      flex: 1;
      padding: 0rem 2rem;
      border-right: none;
      color: #ffffff;
      margin-left: 50px;
      margin-right: 5rem;
    }

    .calculator-container {
      flex: 1;
      padding: 1rem;
      background: #fff;
      border-radius: 10px;
      box-shadow: 0 10px 15px rgba(0, 0, 0, 0.25);
    }

    h1 {
      text-align: center;
    }

    .calculator {
      display: grid;
      gap: 1rem;
    }

    .calculator div {
      display: flex;
      align-items: center;
      gap: 1rem;
    }

    .calculator label {
      flex: 0 1 120px;
      font-weight: 600;
      color: #444;
    }

    .calculator input {
      flex: 1;
      border: 1px solid #ccc;
      border-radius: 5px;
      padding: 10px;
      outline-color: #555;
      font-size: 1.25rem;
      text-align: center;
    }

    .calculator button {
      width: 50%;
      border-radius: 5px;
      border: none;
      cursor: pointer;
      padding: 10px;
      background: #00a1a3;
      color: #fff;
      text-transform: uppercase;
      letter-spacing: 1px;
    }

    .calculator button[type="reset"] {
      background: #444;
    }

    .calculator button:hover {
      filter: brightness(120%);
    }

    .output {
      text-align: center;
    }

    .output #bmi {
      font-size: 4rem;
    }

    .output #desc strong {
      text-transform: uppercase;
    }

    .bmi-scale {
      display: flex;
      color: #444;
    }

    .bmi-scale div {
      flex: 1;
      text-align: center;
      text-transform: uppercase;
      border-top: 5px solid var(--color);
      padding: 10px;
    }

    .bmi-scale h4 {
      font-size: 0.75rem;
      color: slategray;
    }

    .underweight {
      color: var(--underweight);
    }

    .healthy {
      color: var(--normal);
    }

    .overweight {
      color: var(--overweight);
    }

    .obese {
      color: var(--obese);
    }
  </style>
  <!-- custom css -->
  <link rel="stylesheet" href="assets/css/pendaftaran-pilihpuskesmas.css" />
  <link rel="stylesheet" href="assets/css/utilities.css" />
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
    <div class="main-container">
      <div class="description">
        <h1>Welcome to the BMI Calculator</h1>
        <p>BMI (Body Mass Index) atau Indeks Massa Tubuh adalah sebuah pengukuran yang digunakan untuk menentukan apakah
          seseorang memiliki berat badan yang sehat berdasarkan tinggi dan berat badannya. BMI dihitung dengan membagi
          berat
          badan seseorang dalam kilogram dengan kuadrat tinggi badannya dalam meter.
          <br>
          <br>
          Kategori BMI
          <br>Berdasarkan nilai BMI, seseorang dapat dikategorikan ke dalam beberapa kelompok berikut:

          <br>* Kurus (Underweight): BMI kurang dari 18.5
          <br>* Normal: BMI antara 18.5 dan 24.9
          <br>* Gemuk (Overweight): BMI antara 25 dan 29.9
          <br>* Obesitas: BMI 30 atau lebih
          <br>
          <br>
          Pentingnya Memantau BMI
          <br>Mengawasi BMI dapat membantu dalam:

          Identifikasi Risiko Kesehatan: BMI yang tinggi dapat menunjukkan risiko lebih tinggi untuk penyakit seperti
          diabetes tipe 2, penyakit jantung, hipertensi, dan beberapa jenis kanker.
          Pencegahan dan Intervensi: Dengan mengetahui BMI, seseorang dapat mengambil langkah-langkah untuk mencapai atau
          mempertahankan berat badan yang sehat melalui diet dan aktivitas fisik.
          Kesadaran Kesehatan: Pemahaman tentang BMI dapat meningkatkan kesadaran individu terhadap kesehatan dan
          kebugaran
          mereka.
        </p>
      </div>
      <div class="calculator-container">
        <h1>BMI Calculator</h1>

        <form class="calculator" id="bmi-form">
          <div>
            <label for="weight">Berat (kg)</label>
            <input type="number" id="weight" min="0" step="0.01" value="0" required />
          </div>

          <div>
            <label for="height">Tinggi (cm)</label>
            <input type="number" id="height" min="0" step="0.01" value="0" required />
          </div>

          <div>
            <button type="reset">Reset</button>
            <button type="submit">Submit</button>
          </div>
        </form>

        <section class="output">
          <h3>Your BMI is</h3>
          <p id="bmi">0</p>
          <p id="desc">N/A</p>
        </section>

        <section class="bmi-scale">
          <div style="--color: var(--underweight)">
            <h4>Underweight</h4>
            <p>&lt; 18.5</p>
          </div>

          <div style="--color: var(--normal)">
            <h4>Normal</h4>
            <p>18.5 – 24.9</p>
          </div>

          <div style="--color: var(--overweight)">
            <h4>Overweight</h4>
            <p>25 – 29.9</p>
          </div>

          <div style="--color: var(--obese)">
            <h4>Obese</h4>
            <p>≥ 30</p>
          </div>
        </section>
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
  <script>
    const bmiText = document.getElementById("bmi");
    const descText = document.getElementById("desc");
    const form = document.querySelector("form");

    form.addEventListener("submit", onFormSubmit);
    form.addEventListener("reset", onFormReset);

    function onFormReset() {
      bmiText.textContent = 0;
      bmiText.className = "";
      descText.textContent = "N/A";
    }

    function onFormSubmit(e) {
      e.preventDefault();

      const weight = parseFloat(form.weight.value);
      const height = parseFloat(form.height.value);

      if (isNaN(weight) || isNaN(height) || weight <= 0 || height <= 0) {
        alert("Please enter a valid weight and height");
        return;
      }

      const heightInMeters = height / 100; // cm -> m
      const bmi = weight / Math.pow(heightInMeters, 2);
      const desc = interpretBMI(bmi);

      bmiText.textContent = bmi.toFixed(2);
      bmiText.className = desc;
      descText.innerHTML = `You are <strong>${desc}</strong>`;
    }

    function interpretBMI(bmi) {
      if (bmi < 18.5) {
        return "underweight";
      } else if (bmi < 25) {
        return "normal";
      } else if (bmi < 30) {
        return "overweight";
      } else {
        return "obese";
      }
    }
  </script>
</body>

</html>