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

// Query sederhana untuk mengambil semua data dari tabel "antrian"
$query = "SELECT 
            p.NAMA_POLI,
            COUNT(a.ID_ANTRIAN) AS JUMLAH_ANTRIAN
          FROM 
            antrian a
          JOIN 
            poli p ON a.ID_POLI = p.ID_POLI
          WHERE 
            a.HARI_TGL = CURDATE() -- Hanya untuk antrian pada hari ini
            AND p.ID_PUSKESMAS = '$id_puskesmas' -- Menggunakan id_puskesmas dari session
          GROUP BY 
            p.NAMA_POLI;";
$result = mysqli_query($koneksi, $query);

// Format data ke dalam array
$data = array();
$data[] = ['Poli', 'Jumlah Antrian']; // Header for the Google Chart

// Periksa apakah ada baris yang diambil dari hasil query
if (mysqli_num_rows($result) > 0) {
  while ($row = mysqli_fetch_assoc($result)) {
    $data[] = [(string)$row['NAMA_POLI'], (int)$row['JUMLAH_ANTRIAN']];
  }
} else {
  // Jika tidak ada data, tambahkan pesan default
  $data[] = ['Belum ada data', 0];
}

// Tutup koneksi database
mysqli_close($koneksi);

// Mengirim data dalam format JSON dengan header yang sesuai
header('Content-Type: application/json');
echo json_encode($data);
