<?php
require_once 'config.php';
mulai_session();

if (!isset($_SESSION['id_puskesmas'])) {
    header('Location: adm_login.php');
    exit();
}

$id_puskesmas = $_SESSION['id_puskesmas'];
$conn = buat_koneksi();

$sql = "SELECT JUDUL_ARTIKEL, PENULIS_ARTIKEL, ISI_ARTIKEL, TGL_ARTIKEL, FOTO_ARTIKEL FROM artikel_kesehatan WHERE ID_PUSKESMAS = ? ORDER BY TGL_ARTIKEL DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $id_puskesmas);
$stmt->execute();
$result = $stmt->get_result();

$artikel = array();
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        if ($row['FOTO_ARTIKEL']) {
            $row['FOTO_ARTIKEL'] = base64_encode($row['FOTO_ARTIKEL']);
        }
        $artikel[] = $row;
    }
}

$stmt->close();
$conn->close();

header('Content-Type: application/json');
echo json_encode($artikel);
