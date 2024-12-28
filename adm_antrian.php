<?php
require_once 'config.php';

mulai_session();

if (!isset($_SESSION['id_puskesmas'])) {
    header('Location: adm_login.php');
    exit();
}

$id_puskesmas = $_SESSION['id_puskesmas'];
$conn = buat_koneksi();
$id_puskesmas_suffix = substr($id_puskesmas, -2);

date_default_timezone_set('Asia/Jakarta');
$today = (new DateTime())->format('Y-m-d');

$sql = "SELECT antrian.*, antrian.ID_ANTRIAN, antrian.STATUS, antrian.NOMOR_ANTRIAN, pasien.NAMA_PASIEN, 
pasien.TGL_LAHIR, pasien.JENIS_KELAMIN, pasien.ASURANSI, poli.NAMA_POLI
        FROM antrian
        JOIN poli ON antrian.id_poli = poli.id_poli
        JOIN pasien ON antrian.nik_pasien = pasien.nik_pasien
        WHERE poli.id_puskesmas = '$id_puskesmas' AND antrian.HARI_TGL = '$today' AND antrian.STATUS IN (1, 2)";
$result = $conn->query($sql);

if ($result === false) {
    die("Error in query: " . $conn->error);
}

$data_poli = [];
while ($row = $result->fetch_assoc()) {
    $data_poli[$row['NAMA_POLI']][] = $row;
}

$all_poli = ["Poli Umum", "Poli KIA", "Poli Gigi", "Poli Lansia", "Poli Batra", "Poli Mata"];
foreach ($all_poli as $poli) {
    if (!isset($data_poli[$poli])) {
        $data_poli[$poli] = [];
    }
}

$status_mapping = [
    1 => '1. Menunggu',
    2 => '2. Sedang Dilayani',
    3 => '3. Selesai',
    4 => '4. Dibatalkan',
    5 => '5. Tidak Datang'
];

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Pendaftaran</title>
    <link href="img/favicon.ico" rel="icon">
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <style>
        .table-container {
            padding: 10px;
            margin-bottom: 20px;
            background-color: #f9f9f9;
            border-radius: 5px;
            border: 1px solid #ddd;
            overflow-x: auto;
        }

        .table-container table {
            width: 100%;
            max-width: 100%;
            font-size: 12px;
        }

        .table-container th,
        .table-container td {
            padding: 4px;
        }

        h5 {
            font-size: 16px;
        }

        .btn-icon {
            border: none;
            background: none;
        }
    </style>
</head>

<body>
    <div class="container my-4">
        <h2 class="mb-4">Proses Antrian</h2>

        <div class="row">
            <?php
            $poli_counter = 0;
            foreach ($data_poli as $nama_poli => $rows) {
                if ($poli_counter > 0 && $poli_counter % 3 == 0) {
                    echo '<div class="row"></div>';
                }
                $poli_counter++;
                echo '<div class="col-md-4">';
                echo '<div class="table-container">';
                echo '<h5>' . $nama_poli . '</h5>';
                echo '<div class="table-responsive">';
                echo '<table class="table table-bordered table-sm">';
                echo '<thead class="table-light">';
                echo '<tr>
                        <th>NO</th>
                        <th>Nama</th>
                        <th>Status</th>
                        <th>Dilayani</th>
                        <th>Selesai</th>
                        <th>Tidak Datang</th>
                      </tr>';
                echo '</thead>';
                echo '<tbody>';
                if (count($rows) > 0) {
                    foreach ($rows as $index => $row) {
                        $row_json = htmlspecialchars(json_encode($row), ENT_QUOTES, 'UTF-8'); // Encode data baris menjadi JSON untuk dikirim ke JavaScript
                        echo "<tr onclick='showDetails({$row_json})'>
                                <td>{$row['NOMOR_ANTRIAN']}</td>
                                <td>{$row['NAMA_PASIEN']}</td>
                                <td>{$row['STATUS']}</td>
                                <td><button data-id='{$row['ID_ANTRIAN']}' onClick='updateStatus(this, 2)' class='btn-icon'><i class='fas fa-user-clock'></i></button></td>
                                <td><button data-id='{$row['ID_ANTRIAN']}' onClick='updateStatus(this, 3)' class='btn-icon'><i class='fas fa-check'></i></button></td>
                                <td><button data-id='{$row['ID_ANTRIAN']}' onClick='updateStatus(this, 5)' class='btn-icon'><i class='fas fa-times'></i></button></td>
                              </tr>";
                    }
                } else {
                    echo '<tr><td colspan="7" class="text-center">Belum ada antrian</td></tr>';
                }
                echo '</tbody>';
                echo '</table>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
            }
            ?>
        </div>
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
    <script>
        function updateStatus(button, status) {
            var id_antrian = $(button).data('id');
            console.log('Mengirim permintaan untuk memperbarui status...');
            console.log('ID Antrian:', id_antrian);
            console.log('Status Baru:', status);

            $.ajax({
                url: 'adm_proses_antrian.php',
                type: 'POST',
                data: {
                    id_antrian: id_antrian,
                    status: status
                },
                success: function(response) {
                    console.log('Respons dari server:', response); // Log response for debugging
                    var data = JSON.parse(response);
                    if (data.success) {
                        alert('Status berhasil diperbarui');
                        location.reload(); // Reload page to update status
                    } else {
                        alert('Gagal memperbarui status');
                    }
                },
                error: function() {
                    alert('Terjadi kesalahan pada permintaan');
                }
            });
        }

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
</body>

</html>