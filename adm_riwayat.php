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
$id_puskesmas_suffix = substr($id_puskesmas, -2);

// Mendapatkan parameter dari form
$filter = isset($_GET['filter']) ? $_GET['filter'] : 'all';
$poli = isset($_GET['poli']) ? $_GET['poli'] : 'all';
$sort = isset($_GET['sort']) ? $_GET['sort'] : 'desc';
$date = isset($_GET['date']) ? $_GET['date'] : '';

// Membuat query dasar dengan join
$sql = "SELECT antrian.*, pasien.NAMA_PASIEN, pasien.TGL_LAHIR, pasien.JENIS_KELAMIN, pasien.ASURANSI, poli.NAMA_POLI
        FROM antrian
        JOIN poli ON antrian.id_poli = poli.id_poli
        JOIN pasien ON antrian.nik_pasien = pasien.nik_pasien
        WHERE poli.id_puskesmas = '$id_puskesmas'";

// Menambahkan kondisi berdasarkan filter
$conditions = [];

// Filter berdasarkan waktu
$description = "Menampilkan semua data";
if ($filter == 'week') {
    $start_date = date('Y-m-d', strtotime('-1 week'));
    $end_date = date('Y-m-d');
    $conditions[] = "antrian.hari_tgl >= '$start_date' AND antrian.hari_tgl <= '$end_date'";
    $description = "Menampilkan data 1 minggu terakhir, dari $start_date sampai $end_date";
} elseif ($filter == 'month') {
    $start_date = date('Y-m-d', strtotime('-1 month'));
    $end_date = date('Y-m-d');
    $conditions[] = "antrian.hari_tgl >= '$start_date' AND antrian.hari_tgl <= '$end_date'";
    $description = "Menampilkan data 1 bulan terakhir, dari $start_date sampai $end_date";
} elseif ($filter == 'date' && !empty($date)) {
    $conditions[] = "antrian.hari_tgl LIKE '$date%'";
    $description = "Menampilkan data pada tanggal $date";
}

$daftar_poli = [
    '01' => 'Poli Umum',
    '02' => 'Poli KIA',
    '03' => 'Poli Gigi',
    '04' => 'Poli Lansia',
    '05' => 'Poli Batra',
    '06' => 'Poli Mata'
];

// Filter berdasarkan poli
if ($poli != 'all') {
    $id_poli = 'POL' . $id_puskesmas_suffix . $poli;
    $conditions[] = "antrian.id_poli = '$id_poli'";
    $nama_poli = isset($daftar_poli[$poli]) ? $daftar_poli[$poli] : 'Poli Tidak Diketahui';
    $description .= " pada $nama_poli";
} else {
    $description .= " pada semua poli";
}

// Jika ada kondisi, tambahkan ke query
if (!empty($conditions)) {
    $sql .= " AND " . implode(' AND ', $conditions);
}

// Menambahkan ORDER BY berdasarkan filter sort
$sql .= " ORDER BY antrian.waktu_daftar $sort";
if ($sort == 'asc') {
    $description .= ", diurutkan dari yang terlama";
} else {
    $description .= ", diurutkan dari yang terbaru";
}

// Menjalankan query
$result = $conn->query($sql);

if ($result === false) {
    die("Error in query: " . $conn->error);
}

// Array untuk memetakan status ke deskripsi
$status_mapping = [
    1 => '1. Menunggu',
    2 => '2. Sedang Dilayani',
    3 => '3. Selesai',
    4 => '4. Dibatalkan',
    5 => '5. Tidak Datang'
];

// Menghitung jumlah data yang ditemukan
$num_rows = $result->num_rows;
$description2 = "Menampilkan $num_rows baris data";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Pendaftaran</title>
    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

    <!-- Template Stylesheet -->
    <link href="css/style.css" rel="stylesheet">

    <!-- jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <!-- Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
        function showDetails(antrian) {
            console.log(antrian); // Debug untuk memeriksa data
            $('#modalDetail').modal('show');
            $('#modalBody').html(`
        <table class="table table-striped">
            <tbody>
                <tr>
                    <th>ID Antrian</th>
                    <td>:</td>
                    <td>${antrian.ID_ANTRIAN}</td>
                </tr>
                <tr>
                    <th>Nomor Antrian</th>
                    <td>:</td>
                    <td>${antrian.NOMOR_ANTRIAN}</td>
                </tr>
                <tr>
                    <th>ID Poli</th>
                    <td>:</td>
                    <td>${antrian.ID_POLI}</td>
                </tr>
                <tr>
                    <th>Nama Poli</th>
                    <td>:</td>
                    <td>${antrian.NAMA_POLI}</td>
                </tr>
                <tr>
                    <th>NIK Pasien</th>
                    <td>:</td>
                    <td>${antrian.NIK_PASIEN}</td>
                </tr>
                <tr>
                    <th>Nama Pasien</th>
                    <td>:</td>
                    <td>${antrian.NAMA_PASIEN}</td>
                </tr>
                <tr>
                    <th>Jenis Kelamin</th>
                    <td>:</td>
                    <td>${antrian.JENIS_KELAMIN}</td>
                </tr>
                <tr>
                    <th>Tanggal Lahir</th>
                    <td>:</td>
                    <td>${antrian.TGL_LAHIR}</td>
                </tr>
                <tr>
                    <th>Asuransi</th>
                    <td>:</td>
                    <td>${antrian.ASURANSI}</td>
                </tr>
                <tr>
                    <th>Waktu Daftar</th>
                    <td>:</td>
                    <td>${antrian.WAKTU_DAFTAR}</td>
                </tr>
                <tr>
                    <th>Hari Tanggal</th>
                    <td>:</td>
                    <td>${antrian.HARI_TGL}</td>
                </tr>
                <tr>
                    <th>Estimasi Waktu</th>
                    <td>:</td>
                    <td>${antrian.ESTIMASI_WAKTU}</td>
                </tr>
                <tr>
                    <th>Status</th>
                    <td>:</td>
                    <td>${antrian.STATUS}</td>
                </tr>
            </tbody>
        </table>
    `);
        }
    </script>
</head>

<body>
    <div class="container my-4">
        <h1 class="mb-4">Riwayat Pendaftaran</h1>

        <form class="row g-3 mb-4" method="GET" action="admin.php">
            <input type="hidden" name="page" value="riwayat">
            <div class="col-md-3">
                <label for="filter" class="form-label">Filter Data</label>
                <select class="form-select" name="filter" id="filter">
                    <option value="all">Semua</option>
                    <option value="week">1 Minggu Terakhir</option>
                    <option value="month">1 Bulan Terakhir</option>
                    <option value="date">Tanggal Tertentu</option>
                </select>
            </div>
            <div class="col-md-3">
                <label for="poli" class="form-label">Poli</label>
                <select class="form-select" name="poli" id="poli">
                    <option value="all">Semua Poli</option>
                    <option value="01">Poli Umum</option>
                    <option value="02">Poli KIA</option>
                    <option value="03">Poli Gigi</option>
                    <option value="04">Poli Lansia</option>
                    <option value="05">Poli Batra</option>
                    <option value="06">Poli Mata</option>
                </select>
            </div>
            <div class="col-md-3">
                <label for="sort" class="form-label">Urutkan Berdasarkan</label>
                <select class="form-select" name="sort" id="sort">
                    <option value="desc">Terbaru</option>
                    <option value="asc">Terlama</option>
                </select>
            </div>
            <div class="col-md-3">
                <label for="date" class="form-label">Tanggal</label>
                <input type="date" class="form-control" name="date" id="date">
            </div>
            <div class="col-12">
                <button type="submit" class="btn btn-primary" name="refresh">Tampilkan</button>
                <button type="button" class="btn btn-primary" onclick="window.print()" style="margin-left: 10px;">Print</button>

            </div>
        </form>

        <!-- Menampilkan deskripsi filter -->
        <p><strong><?= $description; ?></strong></p>
        <p><strong><?= $description2; ?></strong></p>

        <table class=" table table-bordered">
            <thead class="table-light">
                <tr>
                    <th>No</th>
                    <th>ID Antrian</th>
                    <th>ID Poli</th>
                    <th>NIK Pasien</th>
                    <th>Waktu Daftar</th>
                    <th>Hari Tanggal</th>
                    <th>Nomor Antrian</th>
                    <th>Estimasi Waktu</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Menampilkan data
                if ($result->num_rows > 0) {
                    $no = 1; // Menambahkan variabel nomor urut
                    while ($row = $result->fetch_assoc()) {
                        $status_desc = isset($status_mapping[$row['STATUS']]) ? $status_mapping[$row['STATUS']] : 'Status Tidak Diketahui';
                        $row_json = htmlspecialchars(json_encode($row), ENT_QUOTES, 'UTF-8'); // Encode data baris menjadi JSON untuk dikirim ke JavaScript
                        echo "<tr onclick='showDetails({$row_json})'>
            <td>{$no}</td>
            <td>{$row['ID_ANTRIAN']}</td>
            <td>{$row['ID_POLI']}</td>
            <td>{$row['NIK_PASIEN']}</td>
            <td>{$row['WAKTU_DAFTAR']}</td>
            <td>{$row['HARI_TGL']}</td>
            <td>{$row['NOMOR_ANTRIAN']}</td>
            <td>{$row['ESTIMASI_WAKTU']}</td>
            <td>{$status_desc}</td>
        </tr>";
                        $no++; // Increment nomor urut
                    }
                } else {
                    echo "<tr><td colspan='9'>Tidak ada data yang ditemukan</td></tr>";
                }


                $conn->close();
                ?>
            </tbody>
        </table>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="modalDetail" tabindex="-1" role="dialog" aria-labelledby="modalDetailLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalDetailLabel">Detail Antrian</h5>
                    </button>
                </div>
                <div class="modal-body" id="modalBody">
                    <!-- Konten detail antrian akan diisi oleh JavaScript -->
                </div>
                <div class="modal-footer">
                    <p style='font-style:italic;'>Klik di luar kotak untuk menutup</p>
                </div>
            </div>
        </div>
    </div>


</body>

</html>