<?php
header('Content-Type: application/json');
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

// Atur timezone
date_default_timezone_set('Asia/Jakarta'); // Gantilah sesuai timezone Anda

// Ambil id_puskesmas dari session
$id_puskesmas = $_SESSION['id_puskesmas'];

// Membuat koneksi ke database menggunakan fungsi dari config.php
$koneksi = buat_koneksi();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $judul = $_POST['judulpengumuman'];
    $penulis = $_POST['penulispengumuman'];
    $isi = $_POST['isipengumuman'];
    $tgl_dibuat = date('Y-m-d H:i:s'); // Menggunakan format DATETIME

    // Upload file sebagai BLOB
    if (isset($_FILES['gambarpengumuman']) && $_FILES['gambarpengumuman']['error'] == 0) {
        $foto = file_get_contents($_FILES['gambarpengumuman']['tmp_name']);
    } else {
        $foto = null;
    }

    // Mendapatkan 2 karakter terakhir dari ID_PUSKESMAS
    $id_puskesmas_suffix = substr($id_puskesmas, -2);

    // Mendapatkan dua digit terakhir dari ID_PENGUMUMAN terakhir berdasarkan ID_PUSKESMAS
    $sql_last_id = "SELECT ID_PENGUMUMAN FROM pengumuman WHERE ID_PUSKESMAS = '$id_puskesmas' ORDER BY TGL_DIBUAT DESC LIMIT 1";
    $result = mysqli_query($koneksi, $sql_last_id);

    if ($result && mysqli_num_rows($result) > 0) {
        $last_id = mysqli_fetch_assoc($result)['ID_PENGUMUMAN'];
        $last_id_number = (int) substr($last_id, -2);
        $new_id_number = str_pad($last_id_number + 1, 2, '0', STR_PAD_LEFT);
    } else {
        // Jika tidak ada ID pengumuman sebelumnya, mulai dari 01
        $new_id_number = '01';
    }

    // Menggabungkan semua bagian untuk membentuk ID_PENGUMUMAN baru
    $id_pengumuman = 'PGM' . $id_puskesmas_suffix . $new_id_number;

    // Insert data into database
    $sql = "INSERT INTO pengumuman (ID_PENGUMUMAN, ID_PUSKESMAS, JUDUL_PENGUMUMAN, PEMBUAT_PENGUMUMAN, ISI_PENGUMUMAN, TGL_DIBUAT, FOTO_PENGUMUMAN) 
            VALUES (?, ?, ?, ?, ?, ?, ?)";

    $stmt = $koneksi->prepare($sql);
    $stmt->bind_param('sssssss', $id_pengumuman, $id_puskesmas, $judul, $penulis, $isi, $tgl_dibuat, $foto);
    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'Data berhasil disimpan']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Data gagal disimpan']);
    }

    $stmt->close();
}
