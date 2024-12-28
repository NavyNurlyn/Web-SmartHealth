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

date_default_timezone_set('Asia/Jakarta');

// Membuat koneksi ke database menggunakan fungsi dari config.php
$koneksi = buat_koneksi();

// Query untuk mengambil 10 baris terbaru dari tabel "antrian" untuk satu hari tertentu dan puskesmas yang sesuai dengan id_puskesmas dari session
$query = "
    SELECT antrian.*
    FROM antrian
    JOIN poli ON antrian.ID_POLI = poli.ID_POLI
    WHERE poli.ID_PUSKESMAS = '$id_puskesmas' AND antrian.HARI_TGL = CURDATE()
    ORDER BY antrian.WAKTU_DAFTAR DESC
    LIMIT 10";

$result = mysqli_query($koneksi, $query);

// Format data ke dalam tabel HTML
$table = '<div class="table-responsive">
            <table class="table text-start align-middle table-bordered table-hover mb-0" style="font-size: 14px;">
                <thead>
                    <tr class="text-dark">
                        <th scope="col">ID Antrian</th>
                        <th scope="col">ID Poli</th>
                        <th scope="col">NIK Pasien</th>
                        <th scope="col">Waktu Daftar</th>
                        <th scope="col">Tanggal</th>
                        <th scope="col">No Antrian</th>
                        <th scope="col">Estimasi Waktu</th>
                        <th scope="col">Status</th>
                    </tr>
                </thead>
                <tbody>';

if (mysqli_num_rows($result) > 0) {
    // Tambahkan baris data jika ada hasil query
    while ($row = mysqli_fetch_assoc($result)) {
        $table .= '<tr>
                    <td>' . $row['ID_ANTRIAN'] . '</td>
                    <td>' . $row['ID_POLI'] . '</td>
                    <td>' . $row['NIK_PASIEN'] . '</td>
                    <td>' . $row['WAKTU_DAFTAR'] . '</td>
                    <td>' . $row['HARI_TGL'] . '</td>
                    <td>' . $row['NOMOR_ANTRIAN'] . '</td>
                    <td>' . $row['ESTIMASI_WAKTU'] . '</td>
                    <td>' . $row['STATUS'] . '</td>
                  </tr>';
    }
} else {
    // Tambahkan baris "Belum ada pendaftar" jika tidak ada hasil query
    $table .= '<tr>
                <td colspan="8" class="text-center">Belum ada pendaftar</td>
              </tr>';
}

// Tutup koneksi database
mysqli_close($koneksi);

// Tambahkan akhiran tabel
$table .= '</tbody></table></div>';

// Keluarkan tabel HTML
echo $table;
