<?php

// Fungsi untuk membuat koneksi ke database
function buat_koneksi()
{
    // Ganti parameter sesuai dengan pengaturan database Anda
    $host = 'localhost';
    $username = 'root';
    $password = '';
    $database = 'db_smarthealth3';

    // Buat koneksi
    $conn = new mysqli($host, $username, $password, $database);

    // Periksa koneksi
    if ($conn->connect_error) {
        die("Koneksi ke database gagal: " . $conn->connect_error);
    }

    // Kembalikan objek koneksi
    return $conn;
}

// Fungsi untuk memulai session
function mulai_session()
{
    // Mulai session jika belum dimulai
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
}

// Mulai session
mulai_session();

// Periksa apakah session id_puskesmas sudah diset
if (!isset($_SESSION['id_puskesmas'])) {
    // Jika tidak, arahkan pengguna ke halaman login
    header('Location: adm_login.php');
    exit();
}

// Fungsi untuk mendapatkan data session
function ambil_session($key)
{
    // Ambil data session jika ada, jika tidak, kembalikan null
    return isset($_SESSION[$key]) ? $_SESSION[$key] : null;
}
