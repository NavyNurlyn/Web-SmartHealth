<?php
// Include file config.php yang berisi fungsi-fungsi penting
require_once 'config.php';

// Mulai session menggunakan fungsi dari config.php
mulai_session();

// Periksa apakah session id_puskesmas sudah diset
if (!isset($_SESSION['id_puskesmas'])) {
  // Jika tidak, arahkan pengguna ke halaman login
  header('Location: adm_login.php');
  exit();
}

// Ambil id_puskesmas dari session
$id_puskesmas = $_SESSION['id_puskesmas'];

// Membuat koneksi ke database menggunakan fungsi dari config.php
$koneksi = buat_koneksi();

// Inisialisasi array untuk menyimpan data 7 hari terakhir
$data = array();
$data[] = ['Tanggal', 'Jumlah Pendaftar'];

// Mendapatkan tanggal hari ini
date_default_timezone_set('Asia/Jakarta');
$today = new DateTime();

// Mengisi array dengan 7 hari terakhir, nilai default 0 untuk pendaftar
$date_labels = array();
for ($i = 6; $i >= 0; $i--) {
  $date = clone $today;
  $date->modify("-$i day");
  $formatted_date = $date->format('Y-m-d');
  $date_labels[$formatted_date] = 0; // Nilai default
}

// Query untuk mengambil data pendaftar harian selama 7 hari terakhir termasuk hari ini
$query = "
    SELECT DATE(a.HARI_TGL) AS TANGGAL, COUNT(a.ID_ANTRIAN) AS JUMLAH_PENDAFTAR
    FROM antrian a
    JOIN poli p ON a.ID_POLI = p.ID_POLI
    WHERE p.ID_PUSKESMAS = '$id_puskesmas' -- Menggunakan id_puskesmas dari session
      AND a.HARI_TGL >= DATE_SUB(CURDATE(), INTERVAL 6 DAY)
      AND a.HARI_TGL <= CURDATE()
    GROUP BY DATE(a.HARI_TGL)
    ORDER BY TANGGAL ASC";

$result = mysqli_query($koneksi, $query);

// Memasukkan data dari query ke dalam array, menggantikan nilai default 0
while ($row = mysqli_fetch_assoc($result)) {
  $date_labels[$row['TANGGAL']] = (int)$row['JUMLAH_PENDAFTAR'];
}

// Set locale to Indonesian for the day and month names
setlocale(LC_TIME, 'id_ID', 'id_ID.UTF-8', 'Indonesian_Indonesia.1252', 'Indonesian');

// Format data ke dalam array untuk JSON
$json_data = array();
$json_data[] = ['Tanggal', 'Jumlah Pendaftar']; // Header for the Google Chart

foreach ($date_labels as $date => $jumlah_pendaftar) {
  // Format tanggal ke format "tanggal - bulan (bahasa indonesia)"
  $date_obj = new DateTime($date);
  $formatted_date = strftime("%e %b", $date_obj->getTimestamp());
  $json_data[] = [$formatted_date, $jumlah_pendaftar];
}

// Tutup koneksi database
mysqli_close($koneksi);

// Mengirim data dalam format JSON dengan header yang sesuai
header('Content-Type: application/json');
echo json_encode($json_data);
