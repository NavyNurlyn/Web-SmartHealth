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

// Query untuk mengambil data puskesmas berdasarkan id_puskesmas dari session
$sql = "SELECT * FROM puskesmas WHERE ID_PUSKESMAS = ?";

// Persiapkan statement
$stmt = $conn->prepare($sql);

// Bind parameter
$stmt->bind_param("s", $id_puskesmas);

// Jalankan statement
$stmt->execute();

// Dapatkan hasilnya
$result = $stmt->get_result();

// Cek apakah ada baris hasil
if ($result->num_rows > 0) {
    // Ambil data puskesmas
    $puskesmas = $result->fetch_assoc();
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Detail Puskesmas</title>
        <style>
            .transparent-table {
                background-color: transparent;
            }

            .transparent-table td {
                border: none;
            }

            .column1 {
                font-family: Arial, sans-serif;
                font-size: 16px;
                font-weight: bold;
                width: 160px !important;
            }

            .image-container {
                text-align: center;
                margin-bottom: 20px;
            }

            .image-container img {
                max-width: 500px;
                height: auto;
                border-radius: 10px;
            }
        </style>
    </head>

    <body>
        <div class="container mt-5">
            <h2 class="text-center mb-4" style="margin-left: -20px;">Detail Puskesmas</h2>
            <div class="image-container">
                <?php
                if ($puskesmas['FOTO_PUSKESMAS']) : ?>
                    <img src="data:image/jpeg;base64,<?php echo base64_encode($puskesmas['FOTO_PUSKESMAS']); ?>" alt="Foto Puskesmas">
                <?php endif; ?>
            </div>
            <div class="card mb-4">
                <div class="card-body">
                    <table class="table transparent-table">
                        <tbody>
                            <tr>
                                <td class="column1">Nama Puskesmas</td>
                                <td>:</td>
                                <td><?php echo $puskesmas['NAMA_PUSKESMAS']; ?></td>
                            </tr>
                            <tr>
                                <td class="column1">Deskripsi</td>
                                <td>:</td>
                                <td><?php echo $puskesmas['DESKRIPSI_PUSKESMAS']; ?></td>
                            </tr>
                            <tr>
                                <td class="column1">Alamat</td>
                                <td>:</td>
                                <td><?php echo $puskesmas['ALAMAT_PUSKESMAS']; ?></td>
                            </tr>
                            <tr>
                                <td class="column1">Koordinat</td>
                                <td>:</td>
                                <td><?php echo $puskesmas['KOORDINAT_LINTANG'] . ', ' . $puskesmas['KOORDINAT_BUJUR']; ?></td>
                            </tr>
                            <tr>
                                <td class="column1">Jam Buka</td>
                                <td>:</td>
                                <td><?php echo $puskesmas['JAM_BUKA']; ?></td>
                            </tr>
                            <tr>
                                <td class="column1">Jam Tutup</td>
                                <td>:</td>
                                <td><?php echo $puskesmas['JAM_TUTUP']; ?></td>
                            </tr>
                            <tr>
                                <td class="column1">Telepon</td>
                                <td>:</td>
                                <td><?php echo $puskesmas['TELP_PUSKESMAS']; ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <h2 class="text-center mb-4" style="margin-left: -20px;">Daftar Dokter</h2>
            <div class="card">
                <div class="card-body">
                    <?php
                    // Query untuk mengambil data dokter berdasarkan id_puskesmas
                    $sql_dokter = "
                        SELECT d.* 
                        FROM dokter d
                        JOIN poli p ON d.ID_POLI = p.ID_POLI
                        WHERE p.ID_PUSKESMAS = ?
                    ";
                    $stmt_dokter = $conn->prepare($sql_dokter);
                    $stmt_dokter->bind_param("s", $id_puskesmas);
                    $stmt_dokter->execute();
                    $result_dokter = $stmt_dokter->get_result();

                    if ($result_dokter->num_rows > 0) {
                        echo '<table class="table table-bordered">';
                        echo '<thead>';
                        echo '<tr>';
                        echo '<th>ID Dokter</th>';
                        echo '<th>Nama Dokter</th>';
                        echo '<th>Spesialis</th>';
                        echo '<th>Jenis Kelamin</th>';
                        echo '<th>Telepon</th>';
                        echo '</tr>';
                        echo '</thead>';
                        echo '<tbody>';
                        while ($dokter = $result_dokter->fetch_assoc()) {
                            echo '<tr>';
                            echo '<td>' . $dokter['ID_DOKTER'] . '</td>';
                            echo '<td>' . $dokter['NAMA_DOKTER'] . '</td>';
                            echo '<td>' . $dokter['SPESIALIS'] . '</td>';
                            echo '<td>' . $dokter['JENIS_KELAMIN_DOKTER'] . '</td>';
                            echo '<td>' . $dokter['TELP_DOKTER'] . '</td>';
                            echo '</tr>';
                        }
                        echo '</tbody>';
                        echo '</table>';
                    } else {
                        echo '<p class="text-center">Tidak ada data dokter untuk puskesmas ini.</p>';
                    }

                    // Tutup statement dokter
                    $stmt_dokter->close();
                    ?>
                </div>
            </div>
        </div>
    </body>

    </html>

<?php
} else {
    // Jika tidak ada baris hasil, tampilkan pesan bahwa data tidak ditemukan
    echo "Data Puskesmas tidak ditemukan";
}

// Tutup statement
$stmt->close();

// Tutup koneksi database
$conn->close();
?>