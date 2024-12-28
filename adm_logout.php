<?php
// Mulai sesi jika belum dimulai
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Hapus semua data sesi
session_destroy();

// Redirect kembali ke halaman adm_login.php
header("Location: adm_login.php");
exit;
