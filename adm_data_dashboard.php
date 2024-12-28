<?php
// Koneksi ke database
$koneksi = mysqli_connect("localhost", "root", "", "pemweb");

// Periksa koneksi
if (mysqli_connect_errno()) {
  die("Koneksi ke database gagal: " . mysqli_connect_error());
}

// Inisialisasi array untuk menyimpan semua data
$response = [];

// Query untuk data_poli
$query_poli = "SELECT 
                p.NAMA_POLI,
                COUNT(a.ID_ANTRIAN) AS JUMLAH_ANTRIAN
              FROM 
                antrian a
              JOIN 
                poli p ON a.ID_POLI = p.ID_POLI
              WHERE 
                a.HARI_TGL = CURDATE() 
                AND p.ID_PUSKESMAS = 'PUS01' 
              GROUP BY 
                p.NAMA_POLI;";
$result_poli = mysqli_query($koneksi, $query_poli);

$data_poli = [];
$data_poli[] = ['Poli', 'Jumlah Antrian']; // Header for the Google Chart

while ($row = mysqli_fetch_assoc($result_poli)) {
  $data_poli[] = [(string)$row['NAMA_POLI'], (int)$row['JUMLAH_ANTRIAN']];
}

$response['data_poli'] = $data_poli;

// Inisialisasi array untuk menyimpan data 7 hari terakhir
$data_harian = [];
$data_harian[] = ['Tanggal', 'Jumlah Pendaftar'];

// Mendapatkan tanggal hari ini
$today = new DateTime();

// Mengisi array dengan 7 hari terakhir, nilai default 0 untuk pendaftar
$date_labels = [];
for ($i = 6; $i >= 0; $i--) {
  $date = clone $today;
  $date->modify("-$i day");
  $formatted_date = $date->format('Y-m-d');
  $date_labels[$formatted_date] = 0; // Default value
}

// Query untuk mengambil data pendaftar harian selama 7 hari terakhir termasuk hari ini
$query_harian = "
    SELECT DATE(a.HARI_TGL) AS TANGGAL, COUNT(a.ID_ANTRIAN) AS JUMLAH_PENDAFTAR
    FROM antrian a
    JOIN poli p ON a.ID_POLI = p.ID_POLI
    WHERE p.ID_PUSKESMAS = 'PUS01'
      AND a.HARI_TGL >= DATE_SUB(CURDATE(), INTERVAL 6 DAY)
      AND a.HARI_TGL <= CURDATE()
    GROUP BY DATE(a.HARI_TGL)
    ORDER BY TANGGAL ASC";

$result_harian = mysqli_query($koneksi, $query_harian);

// Memasukkan data dari query ke dalam array, menggantikan nilai default 0
while ($row = mysqli_fetch_assoc($result_harian)) {
  $date_labels[$row['TANGGAL']] = (int)$row['JUMLAH_PENDAFTAR'];
}

// Format data ke dalam array untuk JSON
$json_data_harian = [];
$json_data_harian[] = ['Tanggal', 'Jumlah Pendaftar']; // Header for the Google Chart

foreach ($date_labels as $date => $jumlah_pendaftar) {
  // Format tanggal ke format "tanggal - bulan (bahasa indonesia)"
  $date_obj = new DateTime($date);
  $formatted_date = strftime("%e %b", $date_obj->getTimestamp());
  $json_data_harian[] = [$formatted_date, $jumlah_pendaftar];
}

$response['data_harian'] = $json_data_harian;

// Query untuk data terbaru
$query_terbaru = "
    SELECT antrian.*
    FROM antrian
    JOIN poli ON antrian.ID_POLI = poli.ID_POLI
    WHERE poli.ID_PUSKESMAS = 'PUS01' AND antrian.HARI_TGL = CURDATE()
    ORDER BY antrian.WAKTU_DAFTAR DESC
    LIMIT 10";
$result_terbaru = mysqli_query($koneksi, $query_terbaru);

$data_terbaru = [];
while ($row = mysqli_fetch_assoc($result_terbaru)) {
  $data_terbaru[] = $row;
}

$response['data_terbaru'] = $data_terbaru;

// Tutup koneksi database
mysqli_close($koneksi);

// Mengirim data dalam format JSON dengan header yang sesuai
header('Content-Type: application/json');
echo json_encode($response);
