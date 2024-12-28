<?php
require_once 'config.php';
mulai_session();

if (!isset($_SESSION['id_puskesmas'])) {
    header('Location: adm_login.php');
    exit();
}

$conn = buat_koneksi();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_antrian = $_POST['id_antrian'];
    $status = $_POST['status'];

    $sql = "UPDATE antrian SET STATUS = ? WHERE ID_ANTRIAN = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('is', $status, $id_antrian);

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => $stmt->error]);
    }

    $stmt->close();
}

$conn->close();
