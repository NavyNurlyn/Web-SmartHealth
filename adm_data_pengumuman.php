<?php
// Include file config.php yang berisi fungsi koneksi dan fungsi session
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

// Panggil fungsi buat_koneksi() dari config.php
$conn = buat_koneksi();

// Query untuk mengambil pengumuman berdasarkan id_puskesmas dari session
$sql = "SELECT JUDUL_PENGUMUMAN, PEMBUAT_PENGUMUMAN, ISI_PENGUMUMAN, TGL_DIBUAT, FOTO_PENGUMUMAN FROM pengumuman WHERE ID_PUSKESMAS = ? ORDER BY TGL_DIBUAT DESC";

// Persiapkan statement
$stmt = $conn->prepare($sql);

// Bind parameter
$stmt->bind_param("s", $id_puskesmas);

// Jalankan statement
$stmt->execute();

// Dapatkan hasilnya
$result = $stmt->get_result();

$pengumuman = array();
if ($result->num_rows > 0) {
    // Ambil setiap baris data
    while ($row = $result->fetch_assoc()) {
        if ($row['FOTO_PENGUMUMAN']) {
            $row['FOTO_PENGUMUMAN'] = base64_encode($row['FOTO_PENGUMUMAN']);
        }
        $pengumuman[] = $row;
    }
}

// Tutup statement
$stmt->close();

// Tutup koneksi database
$conn->close();

// Kembalikan data dalam format JSON
header('Content-Type: application/json');
echo json_encode($pengumuman);
